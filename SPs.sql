USE VETCAREDB;

-- Eliminar procedimientos
DROP PROCEDURE IF EXISTS sp_UPDATE_actualizarMascotas;

-- ________________________________________________sp_LOGIN_insertarUsuario_____________________________________________________________________01
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

-- ________________________________________________sp_LOGIN_iniciarSesion_____________________________________________________________________02
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

-- ________________________________________________sp_LOGIN_recuperarAcceso_____________________________________________________________________03
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

-- ________________________________________________sp_LOGIN_actualizarContrasenna________________________________________________________________04
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

-- ________________________________________________sp_LOGIN_cambiarContrasenna__________________________________________________________________05
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

-- _________________________________________________TUSUARIOS_____________________________________________________________________________

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

-- ________________________________________________sp_GET_consultarUsuariosActivos____________________________________________________________07
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

-- ________________________________________________sp_UPDATE_seguridad___________________________________________________17
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
<<<<<<< HEAD
=======
        u.Activo = 0;
END
DELIMITER ;


-- ________________________________________________sp_GET_consultarMascotas________________________________________________________18
DELIMITER ;;
CREATE PROCEDURE sp_GET_consultarMascotas()
BEGIN

    SELECT 
		u.Id,
        u.NombreMascotas,
        u.Tipo,
        u.Raza,
        u.Edad,
        u.Peso,
        u.Fecha_Registro,
        u.tDueno_Id,
		r.NombreDuenos
        
     FROM 
        tMascotas u
        JOIN tDuenos r ON u.tDueno_Id = r.Id
    WHERE 
        u.Activo = 1;
END;;
DELIMITER ;


-- ________________________________________________sp_INSERT_RegistrarMascotas__________________________________________________19
DELIMITER ;;
CREATE PROCEDURE sp_INSERT_RegistrarMascotas(
    IN p_NombreMascotas VARCHAR(100),
    IN p_Tipo VARCHAR(50),
    IN p_Raza VARCHAR(50),
    IN p_Edad INT,
    IN p_Peso DECIMAL(5, 2),
    IN p_Fecha_Registro DATE,
    IN p_tDueno_Id BIGINT,
    IN p_Activo TINYINT(1),
    IN p_IdSession INT
)
BEGIN

 -- Convertir el valor de pActivo a 0 si es diferente de 1
    SET pActivo = IF(pActivo = 1, 1, 0);
    
    
    -- Insertar en la tabla tMascotas
    INSERT INTO tMascotas (NombreMascotas, Tipo, Raza, Edad, Peso, Fecha_Registro, tDueno_Id, Activo)
    VALUES (p_NombreMascotas, p_Tipo, p_Raza, p_Edad, p_Peso, p_Fecha_Registro, p_tDueno_Id, p_Activo);
    
    -- Registrar la acción en la tabla Log
    INSERT INTO Log (accion, descripcion, usuario_id)
    VALUES ('Registrar Mascota', CONCAT('Se registró la mascota: ', p_NombreMascotas), p_IdSession);
END;;
DELIMITER ;


-- ________________________________________________sp_GET_tDuenos_______________________________________________________________20
DELIMITER ;;
CREATE PROCEDURE sp_GET_tDuenos()
BEGIN
    SELECT 
        Id,
        NombreDuenos,
        Telefono,
        Email,
        Direccion,
        Activo
    FROM 
        tDuenos
    WHERE 
        Activo = 1;
END;;
DELIMITER ;


-- ________________________________________________sp_GET_consultarMascotasPorId________________________________________________21
DELIMITER ;;
CREATE PROCEDURE sp_GET_consultarMascotasPorId(
    IN p_Id BIGINT
)
BEGIN
    SELECT 
        m.Id,
        m.NombreMascotas,
        m.Tipo,
        m.Raza,
        m.Edad,
        m.Peso,
        m.Fecha_Registro,
        m.tDueno_Id,
        d.NombreDuenos AS NombreDueno,
        m.Activo
    FROM 
        tMascotas m
    JOIN 
        tDuenos d ON m.tDueno_Id = d.Id
    WHERE 
        m.Id = p_Id;
END;;
DELIMITER ;


-- ________________________________________________sp_UPDATE_actualizarMascotas_________________________________________________22
DELIMITER ;;
CREATE PROCEDURE sp_UPDATE_actualizarMascotas(

	IN p_Id bigint (11),
    IN p_NombreMascotas VARCHAR(100),
    IN p_Tipo VARCHAR(50),
    IN p_Raza VARCHAR(50),
    IN p_Edad INT,
    IN p_Peso DECIMAL(5, 2),
    IN p_Fecha_Registro DATE,
    IN p_tDueno_Id BIGINT,
    IN p_Activo BIT,
    IN p_IdSession INT
)
BEGIN
	
    

    UPDATE tMascotas
    SET 
		Id = p_Id,
        NombreMascotas = p_NombreMascotas,
        Tipo = p_Tipo,
        Raza = p_Raza,
        Edad = p_Edad,
        Peso = p_Peso,
        Fecha_Registro = p_Fecha_Registro,
        tDueno_Id = p_tDueno_Id,
        Activo = 1
    WHERE 
        Id = p_Id;
    
    INSERT INTO Log (accion, descripcion, usuario_id)
    VALUES (
        'Actualizar Mascota', 
        CONCAT('Se actualizó la mascota: ', p_NombreMascotas, ' con ID: ', p_Id), 
        p_IdSession
    );
END;;
DELIMITER ;


-- ________________________________________________sp_GET_consultarMascotasInacivos_________________________________________23
DELIMITER ;;
CREATE PROCEDURE sp_GET_consultarMascotasInactivos()
BEGIN

    SELECT 
		u.Id,
        u.NombreMascotas,
        u.Tipo,
        u.Raza,
        u.Edad,
        u.Peso,
        u.Fecha_Registro,
        u.tDueno_Id,
		r.NombreDuenos
        
     FROM 
        tMascotas u
        JOIN tDuenos r ON u.tDueno_Id = r.Id
    WHERE 
        u.Activo = 0;
END;;
DELIMITER ;


-- ________________________________________________sp_DELETE_eliminarMascotasPorId__________________________________________24
DELIMITER ;;
CREATE PROCEDURE sp_DELETE_eliminarMascotasPorId(
    IN p_Id BIGINT,
    IN p_IdSession INT
)
BEGIN
    -- Cambiar el campo Activo a 0
    UPDATE tMascotas
    SET 
        Activo = 0
    WHERE 
        Id = p_Id;
    
    -- Registrar la acción en el log
    INSERT INTO Log (accion, descripcion, usuario_id)
    VALUES (
        'Inactivar Mascota',
        CONCAT('Se ha inactivado la mascota con ID: ', p_Id),
        p_IdSession
    );
END;;
DELIMITER ;;


-- ________________________________________________sp_UPDATE_activarMascotasPorId__________________________________________25
DELIMITER ;;
CREATE PROCEDURE sp_UPDATE_activarMascotasPorId(
    IN p_Id BIGINT,
    IN p_IdSession INT
)
BEGIN
    -- Cambiar el campo Activo a 0
    UPDATE tMascotas
    SET 
        Activo = 1
    WHERE 
        Id = p_Id;
    
    -- Registrar la acción en el log
    INSERT INTO Log (accion, descripcion, usuario_id)
    VALUES (
        'Inactivar Mascota',
        CONCAT('Se ha inactivado la mascota con ID: ', p_Id),
        p_IdSession
    );
END;;
DELIMITER ;;
=======
DELIMITER ;
>>>>>>> parent of 51a8fcc (Merge branch 'main' into Daniel)
