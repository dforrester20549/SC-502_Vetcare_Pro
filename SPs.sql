USE VETCAREDB;

-- Eliminar procedimientos
DROP PROCEDURE IF EXISTS sp_TRUNCATE_Logs;

-- ________________________________________________sp_LOGIN_insertarUsuario___________________________________________________________________01
DELIMITER //
CREATE PROCEDURE sp_LOGIN_insertarUsuario (
    IN p_Identificacion VARCHAR(20),
    IN p_Nombre VARCHAR(100),
    IN p_Correo VARCHAR(100),
    IN p_Contrasenna VARCHAR(255)
) 
BEGIN
    -- Verifica si ya existe un usuario con el mismo email
    IF EXISTS (SELECT 1 FROM tusuarios WHERE Correo = p_Correo) THEN
        SIGNAL SQLSTATE '45000'
        SET MESSAGE_TEXT = 'El correo electrónico ya está registrado';
    ELSE
        -- Insertar nuevo usuario
        INSERT INTO tusuarios (Identificacion, Nombre, Correo, Contrasenna, Activo, tRol_id)
        VALUES (p_Identificacion, p_Nombre, p_Correo, p_Contrasenna, 1, 4);
    END IF; -- Cerrar el bloque IF
END // -- Cerrar el procedimiento
DELIMITER ;

-- ________________________________________________sp_LOGIN_iniciarSesion___________________________________________________________________02
DELIMITER ;;
CREATE PROCEDURE sp_LOGIN_iniciarSesion(pCorreo varchar(80),
                                    pContrasenna varchar(10))
BEGIN
    SELECT 
        u.Id,
        u.Identificacion,
        u.Nombre,
        u.Correo,
        u.Contrasenna,
        u.Activo,
        r.Id AS RolId,
        r.NombreRol
    FROM 
        vetcaredb.tUsuarios u
    LEFT JOIN 
        vetcaredb.tRoles r ON u.tRol_id = r.Id
    WHERE 
        u.Correo = pCorreo
        AND u.Contrasenna = pContrasenna
        AND u.Activo = 1;
END ;;
DELIMITER ;

-- ________________________________________________sp_LOGIN_recuperarAcceso___________________________________________________________________03
DELIMITER $$
CREATE PROCEDURE sp_LOGIN_recuperarAcceso(IN p_correo VARCHAR(255))
BEGIN
    DECLARE v_usuario_id INT;
    DECLARE v_token VARCHAR(255);
    DECLARE v_fecha_expiracion DATETIME;
    
    -- Paso 1: Verificar si el correo existe
    SELECT id INTO v_usuario_id
    FROM tUsuarios
    WHERE correo = p_correo;
    
    IF v_usuario_id IS NOT NULL THEN
        SET v_token = MD5(UUID());  -- Usamos MD5 y UUID para generar un token único
        SET v_fecha_expiracion = DATE_ADD(NOW(), INTERVAL 24 HOUR);  -- Expira en 24 horas

        INSERT INTO tRecuperacion(tUsuarios_id, token, fecha_expiracion)
        VALUES (v_usuario_id, v_token, v_fecha_expiracion)
        ON DUPLICATE KEY UPDATE token = v_token, fecha_expiracion = v_fecha_expiracion;

    ELSE
        SELECT 'Correo no encontrado' AS mensaje;
    END IF;
END $$
DELIMITER ;

-- ________________________________________________sp_LOGIN_actualizarContrasenna______________________________________________________________04
DELIMITER $$
CREATE PROCEDURE sp_LOGIN_actualizarContrasenna(
    IN pId BIGINT,
    IN pCodigo VARCHAR(10)
)
BEGIN
    UPDATE vetcaredb.tUsuarios
    SET Contrasenna = pCodigo,
        ContrasennaTemporal = TRUE,
        CodigoRecuperacion = pCodigo
    WHERE Id = pId;
END
DELIMITER ;

-- ________________________________________________sp_LOGIN_cambiarContrasenna________________________________________________________________05
DELIMITER $$
CREATE PROCEDURE sp_LOGIN_cambiarContrasenna(
    IN p_token VARCHAR(255),
    IN p_nuevaContrasennaHash VARCHAR(255)
)
BEGIN
    DECLARE v_usuario_id INT;

    -- Verificar si el token es válido
    SELECT idUsuario INTO v_usuario_id
    FROM RecuperacionContrasenna
    WHERE token = p_token
    AND NOW() <= fecha_expiracion;  -- Asume que tienes una fecha de expiración para el token

    -- Si no encuentra un usuario con ese token o está expirado, termina
    IF v_usuario_id IS NULL THEN
        SIGNAL SQLSTATE '45000'
        SET MESSAGE_TEXT = 'Token inválido o expirado';
    ELSE
        -- Actualizar la contraseña del usuario
        UPDATE Usuario
        SET contrasenna = p_nuevaContrasennaHash
        WHERE idUsuario = v_usuario_id;

        -- Invalidar el token después de usarlo (podrías eliminarlo o marcarlo como usado)
        DELETE FROM RecuperacionContrasenna
        WHERE token = p_token;
    END IF;
END $$

DELIMITER ;

-- _________________________________________________TUSUARIOS______________________________________________________________________________

-- ________________________________________________sp_GET_consultarUsuariosTUSUARIOS___________________________________________________________06
DELIMITER ;;
CREATE PROCEDURE sp_GET_consultarUsuarios(
    IN pIdSession BIGINT
)
BEGIN
    -- Registro de la acción en la tabla de Log
    INSERT INTO Log (accion, descripcion, usuario_id)
    VALUES ('Consultar Usuarios', CONCAT('Consulta realizada para el usuario con ID: ', pIdSession), pIdSession);

    -- Selección de la información del usuario y el nombre del rol
    SELECT 
        u.Id,
        u.Identificacion,
        u.Nombre,
        u.Correo,
        u.Activo,
        u.tRol_id,
        r.NombreRol
    FROM 
        tUsuarios u
        JOIN tRoles r ON u.tRol_id = r.Id
    WHERE 
        u.Id = pIdSession;
END ;;
DELIMITER ;

-- ________________________________________________sp_GET_consultarUsuariosActivos_____________________________________________________________07
DELIMITER ;;
CREATE PROCEDURE sp_GET_consultarUsuariosActivos()
BEGIN
    -- Selección de la información de los usuarios activos y el nombre del rol
    SELECT 
        u.Id,
        u.Identificacion,
        u.Nombre,
        u.Correo,
        u.Activo,
        u.tRol_id,
        r.NombreRol
    FROM 
        tUsuarios u
        JOIN tRoles r ON u.tRol_id = r.Id
    WHERE 
        u.Activo = 1;
END
DELIMITER ;

-- ________________________________________________sp_GET_consultarUsuariosInactivos___________________________________________________________08
DELIMITER ;;
CREATE PROCEDURE sp_GET_consultarUsuariosInactivos()
BEGIN
    -- Selección de la información de los usuarios activos y el nombre del rol
    SELECT 
        u.Id,
        u.Identificacion,
        u.Nombre,
        u.Correo,
        u.Activo,
        u.tRol_id,
        r.NombreRol
    FROM 
        tUsuarios u
        JOIN tRoles r ON u.tRol_id = r.Id
    WHERE 
        u.Activo = 0;
END
DELIMITER ;

-- ________________________________________________sp_INSERT_registrarUsuario_________________________________________________________________09
DELIMITER ;;
CREATE PROCEDURE sp_INSERT_registrarUsuario(
    IN pIdentificacion VARCHAR(20),
    IN pNombre VARCHAR(100),
    IN pCorreo VARCHAR(100),
    IN pContrasenna VARCHAR(255), 
    IN pActivo BIT,
    IN pTRol_id BIGINT,
    IN pIdSession BIGINT
)
BEGIN
    -- Inserción del nuevo usuario
    INSERT INTO tUsuarios (Identificacion, Nombre, Correo, Contrasenna, ContrasennaTemporal, Activo, tRol_id)
    VALUES (pIdentificacion, pNombre, pCorreo, pContrasenna, 1, pActivo, pTRol_id);
    
    -- Registro de la acción en la tabla de Log
    INSERT INTO Log (accion, descripcion, usuario_id)
    VALUES ('Registrar Usuario', CONCAT('Usuario registrado: ', pNombre, ', por el usuario con ID: ', pIdSession), pIdSession);
END ;;
DELIMITER ;

-- ________________________________________________sp_GET_tRoles____________________________________________________________________________10
DELIMITER ;;
CREATE PROCEDURE sp_GET_tRoles()
BEGIN
    -- Selección de todos los roles
    SELECT 
        Id,
        NombreRol
    FROM 
        tRoles;
END
DELIMITER ;

-- ________________________________________________sp_UPDATE_cambiarEstadoUsuario___________________________________________________________11
DELIMITER ;;
CREATE PROCEDURE sp_UPDATE_cambiarEstadoUsuario(
    IN pUserId BIGINT,
    IN pNuevoEstado BIT
)
BEGIN
    -- Actualización del estado del usuario
    UPDATE tUsuarios 
    SET Activo = pNuevoEstado
    WHERE Id = pUserId;
END ;;
DELIMITER ;

-- ________________________________________________sp_GET_UsuarioPorID_______________________________________________________________________12
DELIMITER ;;
CREATE PROCEDURE sp_GET_UsuarioPorID(
    IN pId BIGINT
)
BEGIN
    -- Seleccionar el usuario por su ID
    SELECT 
        u.Id,
        u.Identificacion,
        u.Nombre,
        u.Correo,
        u.Activo,
        u.tRol_id,
        r.NombreRol,
        u.ContrasennaTemporal
    FROM 
        tUsuarios u
        JOIN tRoles r ON u.tRol_id = r.Id
    WHERE 
        u.Id = pId;
END ;;
DELIMITER ;

-- ________________________________________________sp_UPDATE_actualizarUsuario_________________________________________________________________13
DELIMITER ;;
CREATE PROCEDURE sp_UPDATE_actualizarUsuario(
    IN pId BIGINT,
    IN pNombre VARCHAR(100),
    IN pCorreo VARCHAR(100),
    IN pIdentificacion VARCHAR(20),
    IN pActivo TINYINT(1),
    IN pRolId BIGINT,
    IN pIdSession BIGINT
)
BEGIN
    -- Convertir el valor de pActivo a 0 si es diferente de 1
    SET pActivo = IF(pActivo = 1, 1, 0);

    -- Actualización del usuario
    UPDATE tUsuarios
    SET 
        Nombre = pNombre,
        Correo = pCorreo,
        Identificacion = pIdentificacion,
        Activo = pActivo,
        tRol_id = pRolId
    WHERE 
        Id = pId;

    -- Registro de la acción en la tabla de Log
    INSERT INTO Log (accion, descripcion, usuario_id)
    VALUES ('Actualizar Usuario', CONCAT('Usuario actualizado: ', pNombre, ', por el usuario con ID: ', pIdSession), pIdSession);
END ;;
DELIMITER ;;

-- ________________________________________________sp_GET_consultarLogs_________________________________________________________________14
DELIMITER ;;
CREATE PROCEDURE sp_GET_consultarLogs()
BEGIN

    SELECT 
        Id,
        accion,
        descripcion,
        usuario_id
        
    FROM 
        Log;
END ;;
DELIMITER ;


-- ________________________________________________sp_TRUNCATE_Logs____________________________________________________________________15
DELIMITER ;;
CREATE PROCEDURE sp_TRUNCATE_Logs(
    IN pIdSession BIGINT
)
BEGIN
    -- Limpiar la tabla Logs
    TRUNCATE TABLE Log;

    -- Registrar la acción de eliminación en la tabla Log
    INSERT INTO Log (accion, descripcion, usuario_id)
    VALUES ('Eliminar Logs', CONCAT( 'Se realizó el eliminado de todos los registros en la tabla Logs',pIdSession), pIdSession);
END ;;
DELIMITER ;

-- ________________________________________________sp_GET_consultarUsuariosTUSUARIOS___________________________________________________16
DELIMITER ;;
CREATE PROCEDURE sp_GET_consultarUsuarios(
    IN pIdSession BIGINT
)
BEGIN
    -- Registro de la acción en la tabla de Log
    INSERT INTO Log (accion, descripcion, usuario_id)
    VALUES ('Consultar Usuarios', CONCAT('Consulta realizada para el usuario con ID: ', pIdSession), pIdSession);

    -- Selección de la información del usuario y el nombre del rol


-- ________________________________________________sp_UPDATE_seguridad_________________________________________________________________17
DELIMITER $$
CREATE PROCEDURE sp_UPDATE_seguridad (
    IN p_Id BIGINT,
    IN p_contrasennaNueva VARCHAR(255)
)
BEGIN
    DECLARE v_usuarioExistente INT;

    -- Verificar si el usuario existe
    SELECT COUNT(*) INTO v_usuarioExistente
    FROM tUsuarios
    WHERE Id = p_Id;

    IF v_usuarioExistente = 1 THEN
        -- Actualizar la contraseña del usuario
        UPDATE tUsuarios
        SET Contrasenna = p_contrasennaNueva,
            ContrasennaTemporal = FALSE -- Cambiamos a FALSE si es una contraseña definitiva
        WHERE Id = p_Id;

        -- Insertar un registro en la tabla Log
        INSERT INTO Log (accion, descripcion, usuario_id)
        VALUES ('Actualizar Contraseña', CONCAT('La contraseña del usuario con ID ', p_Id, ' fue actualizada.'), p_Id);

    ELSE
        SIGNAL SQLSTATE '45000'
        SET MESSAGE_TEXT = 'Usuario no encontrado.';
    END IF;
END $$
=======
        u.Activo = 0;
END
DELIMITER ;