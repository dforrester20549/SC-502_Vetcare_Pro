USE VETCAREDB;

-- Eliminar procedimientos
DROP PROCEDURE IF EXISTS sp_INSERT_registrarUsuario;

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
        VALUES (p_Identificacion, p_Nombre, p_Correo, p_Contrasenna, 1, 3);
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
    INSERT INTO tUsuarios (Identificacion, Nombre, Correo, Contrasenna, Activo, tRol_id)
    VALUES (pIdentificacion, pNombre, pCorreo, pContrasenna, pActivo, pTRol_id);
    
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