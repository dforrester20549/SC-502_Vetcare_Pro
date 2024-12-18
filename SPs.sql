USE VETCAREDB;

-- Eliminar procedimientos
DROP PROCEDURE IF EXISTS sp_GET_consultarMedicamentos;

-- ________________________________________________sp_LOGIN_insertarUsuario_________________________________________________________________________01
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

-- ________________________________________________sp_LOGIN_iniciarSesion___________________________________________________________________________02
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

-- ________________________________________________sp_LOGIN_recuperarAcceso_________________________________________________________________________03
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

-- ________________________________________________sp_LOGIN_actualizarContrasenna___________________________________________________________________04
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

-- ____________________________________________________sp_LOGIN_cambiarContrasenna__________________________________________________________________05
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

-- _____________________________________________________________TUSUARIOS_____________________________________________________________________________

-- ________________________________________________sp_GET_consultarUsuariosTUSUARIOS________________________________________________________________06
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

-- ________________________________________________sp_GET_consultarUsuariosActivos__________________________________________________________________07
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

-- ________________________________________________sp_GET_consultarUsuariosInactivos________________________________________________________________08
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

-- ________________________________________________sp_INSERT_registrarUsuario_______________________________________________________________________09
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

-- ________________________________________________sp_GET_tRoles____________________________________________________________________________________10
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

-- ________________________________________________sp_UPDATE_cambiarEstadoUsuario___________________________________________________________________11
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

-- ________________________________________________sp_GET_UsuarioPorID______________________________________________________________________________12
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

-- ________________________________________________sp_UPDATE_actualizarUsuario______________________________________________________________________13
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

-- ________________________________________________sp_GET_consultarLogs_____________________________________________________________________________14
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


-- ________________________________________________sp_TRUNCATE_Logs_________________________________________________________________________________15
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



-- ________________________________________________sp_UPDATE_seguridad______________________________________________________________________________17
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
        u.Activo = 0;
END
DELIMITER ;


-- ________________________________________________sp_GET_consultarMascotas_________________________________________________________________________18
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


-- ________________________________________________sp_INSERT_RegistrarMascotas______________________________________________________________________19
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
    SET p_Activo = IF(p_Activo = 1, 1, 0);
    
    
    -- Insertar en la tabla tMascotas
    INSERT INTO tMascotas (NombreMascotas, Tipo, Raza, Edad, Peso, Fecha_Registro, tDueno_Id, Activo)
    VALUES (p_NombreMascotas, p_Tipo, p_Raza, p_Edad, p_Peso, p_Fecha_Registro, p_tDueno_Id, p_Activo);
    
    -- Registrar la acción en la tabla Log
    INSERT INTO Log (accion, descripcion, usuario_id)
    VALUES ('Registrar Mascota', CONCAT('Se registró la mascota: ', p_NombreMascotas), p_IdSession);
END;;
DELIMITER ;


-- ________________________________________________sp_GET_tDuenos___________________________________________________________________________________20
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


-- ________________________________________________sp_GET_consultarMascotasPorId____________________________________________________________________21
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


-- ________________________________________________sp_UPDATE_actualizarMascotas_____________________________________________________________________22
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


-- ________________________________________________sp_GET_consultarMascotasInacivos_________________________________________________________________23
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


-- ________________________________________________sp_DELETE_eliminarMascotasPorId__________________________________________________________________24
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


-- ________________________________________________sp_UPDATE_activarMascotasPorId___________________________________________________________________25
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

-- ________________________________________________sp_INSERT_insertarMedicamento____________________________________________________________________26
DELIMITER //
CREATE PROCEDURE sp_INSERT_insertarMedicamento (
    IN p_Nombre NVARCHAR(100),
    IN p_Descripcion NVARCHAR(255),
    IN p_Dosis NVARCHAR(50),
    IN pIdSession BIGINT
)
BEGIN
    INSERT INTO tmedicamentos (Nombre, Descripcion, Dosis)
    VALUES (p_Nombre, p_Descripcion, p_Dosis);
    
    -- Registro de la acción en la tabla de Log
    INSERT INTO Log (accion, descripcion, usuario_id)
    VALUES ('Consultar Usuarios', CONCAT('Consulta realizada para el usuario con ID: ', pIdSession), pIdSession);
END // 
DELIMITER ;


-- ________________________________________________sp_GET_consultarMedicamentos_____________________________________________________________________27
DELIMITER //
CREATE PROCEDURE sp_GET_consultarMedicamentos()
BEGIN
    SELECT 
        Nombre, 
        Descripcion, 
        Dosis 
    FROM tmedicamentos;
END //
DELIMITER ;


-- ________________________________________________sp_UPDATE_actualizarMedicamento__________________________________________________________________28
DELIMITER // 
CREATE PROCEDURE sp_UPDATE_actualizarMedicamento (
    IN p_Id INT(11),
    IN p_Nombre NVARCHAR(100),
    IN p_Descripcion NVARCHAR(255),
    IN p_Dosis NVARCHAR(50),
    IN pIdSession BIGINT
)
BEGIN
    UPDATE tmedicamentos
    SET Nombre = p_Nombre,
        Descripcion = p_Descripcion,
        Dosis = p_Dosis
    WHERE Id = p_Id;

    -- Registro de la acción en la tabla de Log
    INSERT INTO Log (accion, descripcion, usuario_id)
    VALUES ('Consultar Usuarios', CONCAT('Consulta realizada para el usuario con ID: ', pIdSession), pIdSession);
END // 
DELIMITER ;


-- ________________________________________________sp_GET_consultarVeterinarios___________________________________________________________________29
DELIMITER ;;
CREATE PROCEDURE sp_GET_consultarVeterinarios()
BEGIN
    SELECT 
        u.Id,
        u.NombreVeterinarios,
        u.Especialidad,
        u.Telefono,
        u.Email,
        u.ImagePath,       -- Agregar la columna de la imagen
        u.Destacado,       -- Agregar la columna de destacado
        r.NombreRol        -- Obtener el nombre del rol desde la tabla tRoles
    FROM 
        tVeterinarios u
        JOIN tRoles r ON u.RolId = r.Id
    WHERE 
        u.Activo = 1;
END;;
DELIMITER ;



-- ________________________________________________sp_GET_consultarVeterinariosInactivos__________________________________________________________30
DELIMITER ;;
CREATE PROCEDURE sp_GET_consultarVeterinariosInactivos()
BEGIN
    SELECT 
        u.Id,
        u.NombreVeterinarios,
        u.Especialidad,
        u.Telefono,
        u.Email,
        u.ImagePath,       -- Agregar la columna de la imagen
        u.Destacado,       -- Agregar la columna de destacado
        r.NombreRol        -- Obtener el nombre del rol desde la tabla tRoles
    FROM 
        tVeterinarios u
        JOIN tRoles r ON u.RolId = r.Id
    WHERE 
        u.Activo = 0;
END;;
DELIMITER ;



-- ________________________________________________sp_INSERT_registrarVeterinarios_______________________________________________________________31
DELIMITER ;;
CREATE PROCEDURE sp_INSERT_registrarVeterinarios(
    IN p_NombreVeterinarios VARCHAR(100),
    IN p_Especialidad VARCHAR(50),
    IN p_Telefono VARCHAR(15),
    IN p_Email VARCHAR(100),
    IN p_Activo TINYINT(1),
    IN p_ImagePath VARCHAR(255),
    IN p_Destacado TINYINT(1),
    IN p_IdSession INT
)
BEGIN
    DECLARE v_NewVeterinarioId BIGINT;
    DECLARE v_NewUsuarioId BIGINT;
    DECLARE v_TemporaryPassword VARCHAR(10);

    -- Validar que el valor de Activo sea 0 o 1
    SET p_Activo = IF(p_Activo = 1, 1, 0);

    -- Insertar en la tabla tVeterinarios
    INSERT INTO tVeterinarios (NombreVeterinarios, Especialidad, Telefono, Email, Activo, RolId)
    VALUES (p_NombreVeterinarios, p_Especialidad, p_Telefono, p_Email, p_Activo, 3);

    -- Obtener el último ID generado para tVeterinarios
    SET v_NewVeterinarioId = LAST_INSERT_ID();

    -- Insertar en la tabla tUsuarios con ImagePath y Destacado
    INSERT INTO tUsuarios (Identificacion, Nombre, Correo, Contrasenna, Activo, tRol_id, ImagePath, Destacado)
    VALUES (
        v_NewVeterinarioId, -- Usar el ID del veterinario como Identificación
        p_NombreVeterinarios,
        p_Email,
        'default', -- Contraseña temporal inicial
        p_Activo,
        3, -- Rol Veterinario
        IFNULL(p_ImagePath, '/SC-502_Vetcare_Pro/View/root/img/veterinario/noimage.jpg'), -- Ruta de la imagen, valor por defecto si no se envía
        IFNULL(p_Destacado, 0) -- Valor de destacado, por defecto 0 si no se envía
    );

    -- Obtener el último ID generado para tUsuarios
    SET v_NewUsuarioId = LAST_INSERT_ID();

    -- Generar un código de recuperación temporal
    SET v_TemporaryPassword = LPAD(FLOOR(RAND() * 1000000), 6, '0'); -- Código aleatorio de 6 dígitos

    -- Actualizar la contraseña temporal usando el procedimiento sp_LOGIN_actualizarContrasenna
    CALL sp_LOGIN_actualizarContrasenna(v_NewUsuarioId, v_TemporaryPassword);

    -- Registrar la acción en la tabla Log
    INSERT INTO Log (accion, descripcion, usuario_id)
    VALUES (
        'Registrar Veterinario',
        CONCAT('Se registró el veterinario: ', p_NombreVeterinarios, ' con el ID de usuario: ', v_NewUsuarioId),
        p_IdSession
    );

    -- Retornar el correo y la contraseña temporal
    SELECT p_Email AS Correo, v_TemporaryPassword AS ContrasennaTemporal;
END;;
DELIMITER ;



-- ________________________________________________sp_GET_consultarVeterinariosPorId______________________________________________________________32
DELIMITER ;;
CREATE PROCEDURE sp_GET_consultarVeterinariosPorId(
    IN p_Id BIGINT
)
BEGIN
    SELECT 
        m.Id,
        m.NombreVeterinarios,
        m.Especialidad,
        m.Telefono,
        m.Email,
        m.RolId,
        m.Activo,
        m.ImagePath, -- Nueva columna para la ruta de la imagen
        m.Destacado  -- Nueva columna para el estado de destacado
    FROM 
        tVeterinarios m
    WHERE 
        m.Id = p_Id;
END;;
DELIMITER ;



-- ________________________________________________sp_UPDATE_actualizarVeterinarios_______________________________________________________________33
DELIMITER ;;
CREATE PROCEDURE sp_UPDATE_actualizarVeterinarios(
    IN p_Id BIGINT(11),
    IN p_NombreVeterinarios VARCHAR(100),
    IN p_Especialidad VARCHAR(50),
    IN p_Telefono VARCHAR(15),
    IN p_Email VARCHAR(100),
    IN p_Activo TINYINT(1),
    IN p_ImagePath VARCHAR(400),
    IN p_Destacado TINYINT(1),
    IN p_IdSession INT
)
BEGIN
    -- Actualizar la tabla tVeterinarios
    UPDATE tVeterinarios
    SET 
        NombreVeterinarios = p_NombreVeterinarios,
        Especialidad = p_Especialidad,
        Telefono = p_Telefono,
        Email = p_Email,
        Activo = p_Activo,
        ImagePath = p_ImagePath,
        Destacado = p_Destacado
    WHERE 
        Id = p_Id;

    -- Insertar un registro en la tabla Log
    INSERT INTO Log (accion, descripcion, usuario_id)
    VALUES (
        'Actualizar Veterinario', 
        CONCAT('Se actualizó al Veterinario: ', p_NombreVeterinarios, 
               ' con ID: ', p_Id, 
               ', Destacado: ', p_Destacado), 
        p_IdSession
    );
END;;
DELIMITER ;



-- ________________________________________________sp_INSERT_registrarCita________________________________________________________________________34
DELIMITER $$
USE `vetcaredb`$$
CREATE PROCEDURE `sp_INSERT_registrarCita` (pmascotaid bigint(11),pfecha datetime,pmotivo text, pveterinarioid bigint(11))
BEGIN
INSERT INTO `vetcaredb`.`tcitas`
(
`tMascota_id`,
`Fecha_Cita`,
`Motivo`,
`Estado`,
`Activo`,
`tVeterinario_id`)
VALUES
(
pmascotaid,
pfecha,
pmotivo,
'pendiente',
1,
pveterinarioid);
 
END$$
 
DELIMITER ;


-- ________________________________________________sp_UPDATE_inhabilitarCita______________________________________________________________________35
DELIMITER $$
USE vetcaredb$$
CREATE PROCEDURE sp_UPDATE_inhabilitarCita (pid bigint(11))
BEGIN
UPDATE vetcaredb.tcitas
SET
Activo = 0
WHERE Id = pid;
 
END$$
 
DELIMITER ;


-- ________________________________________________sp_UPDATE_actualizarCita______________________________________________________________________36
DELIMITER $$
USE vetcaredb$$
CREATE PROCEDURE sp_UPDATE_actualizarCita (pid bigint(11),pmascotaid bigint(11),pfecha datetime,pmotivo text, pestado enum('pendiente','completada','cancelada'),pveterinarioid bigint(11))
 
BEGIN
UPDATE vetcaredb.tcitas
SET
tMascota_id = pmascotaid,
Fecha_Cita = pfecha,
Motivo = pmotivo,
Estado = pestado,
Activo = 1,
tVeterinario_id = pveterinarioid
WHERE Id = pid;
 
 
END$$
 
DELIMITER ;


-- ________________________________________________sp_INSERT_registrarDueno________________________________________________________________________37
DELIMITER $$
CREATE PROCEDURE sp_INSERT_registrarDueno(
    IN pNombre VARCHAR(100),
    IN pTelefono VARCHAR(15),
    IN pEmail VARCHAR(100),
    IN pDireccion VARCHAR(255),
    IN pActivo BIT
)
BEGIN
    INSERT INTO tDuenos (NombreDuenos, Telefono, Email, Direccion, Activo)
    VALUES (pNombre, pTelefono, pEmail, pDireccion, pActivo);
END$$
DELIMITER ;



-- ________________________________________________sp_GET_consultarDuenos________________________________________________________________________38
DELIMITER ;;
CREATE PROCEDURE sp_GET_consultarDuenos()
BEGIN
    -- Seleccionar todos los registros de la tabla tDuenos
    SELECT 
        Id,
        NombreDuenos,
        Telefono,
        Email,
        Direccion,
        Activo
    FROM 
        tDuenos;
END;;
DELIMITER ;


-- ________________________________________________sp_UPDATE_desactivarDueno____________________________________________________________________39
DELIMITER ;;
CREATE PROCEDURE sp_UPDATE_desactivarDueno(
    IN p_Id BIGINT
)
BEGIN
    -- Actualizar el estado de activo a 0 para el dueño con el ID proporcionado
    UPDATE tDuenos
    SET Activo = 0
    WHERE Id = p_Id;
END;;
DELIMITER ;



-- ________________________________________________sp_INSERT_registrarDueno____________________________________________________________________40
DELIMITER ;;
CREATE PROCEDURE sp_INSERT_registrarDueno(
    IN p_NombreDuenos VARCHAR(100),
    IN p_Telefono VARCHAR(15),
    IN p_Email VARCHAR(100),
    IN p_Direccion VARCHAR(255),
    IN p_Activo TINYINT(1)
)
BEGIN
    -- Validar que el valor de Activo sea 0 o 1
    SET p_Activo = IF(p_Activo = 1, 1, 0);

    -- Insertar los datos en la tabla tDuenos
    INSERT INTO tDuenos (NombreDuenos, Telefono, Email, Direccion, Activo)
    VALUES (p_NombreDuenos, p_Telefono, p_Email, p_Direccion, p_Activo);

    -- Registrar la acción en la tabla Log
    INSERT INTO Log (accion, descripcion, usuario_id)
    VALUES ('Registrar Dueño', CONCAT('Se registró el dueño: ', p_NombreDuenos), NULL);
END;;
DELIMITER ;


-- ________________________________________________sp_GET_consultarmascotatx_________________________________________________________________41
DELIMITER ;;
CREATE PROCEDURE sp_GET_consultarmascotatx()
BEGIN
    SELECT 
        m.Id AS MascotaId,
        m.NombreMascotas AS NombreMascota,
        m.Tipo AS TipoMascota,
        m.Raza AS Raza,
        m.Edad AS Edad,
        m.Peso AS Peso,
        c.Id AS CitaId,
        c.Fecha_Cita AS FechaCita,
        c.Motivo AS MotivoCita,
        c.Estado AS EstadoCita,
        d.NombreDuenos AS NombreDueno,
        v.NombreVeterinarios AS Veterinario
    FROM 
        tMascotas AS m
    INNER JOIN 
        tCitas AS c ON m.Id = c.tMascota_id
    INNER JOIN 
        tDuenos AS d ON m.tDueno_Id = d.Id
    INNER JOIN 
        tVeterinarios AS v ON c.tVeterinario_id = v.Id
    WHERE 
        c.Activo = 1; -- Filtrar solo citas activas
END;;
DELIMITER ;


-- ________________________________________________sp_INSERT_registrarTx___________________________________________________________________42
DELIMITER ;;
CREATE PROCEDURE sp_INSERT_registrarTx(
    IN p_Costo DECIMAL(10, 2),
    IN p_Descripcion TEXT,
    IN p_tMascota_Id BIGINT,
    IN p_tVeterinario_Id BIGINT,
    IN p_tMedicamento_Id BIGINT,
    IN p_Activo TINYINT(1),
    IN p_IdSession INT
)
BEGIN
    DECLARE v_TratamientoId BIGINT;

    -- Insertar en la tabla tTratamientos
    INSERT INTO tTratamientos (tMascota_Id, Fecha_Tratamiento, Descripcion, Costo, Activo, tMedicamento_Id)
    VALUES (p_tMascota_Id, NOW(), p_Descripcion, p_Costo, p_Activo, p_tMedicamento_Id);

    -- Obtener el ID del tratamiento recién insertado
    SET v_TratamientoId = LAST_INSERT_ID();

    -- Actualizar el estado de la cita asociada a 'completada'
    UPDATE tCitas
    SET Estado = 'completada'
    WHERE tMascota_id = p_tMascota_Id AND tVeterinario_id = p_tVeterinario_Id;

    -- Registrar en el Log
    INSERT INTO Log (accion, descripcion, usuario_id)
    VALUES (
        'Registrar Tratamiento',
        CONCAT('Se registró el tratamiento con ID: ', v_TratamientoId, ' para la mascota con ID: ', p_tMascota_Id),
        p_IdSession
    );
END;;
DELIMITER ;



-- ________________________________________________sp_DELETE_eliminarVeterinarioPorId_____________________________________________________43
DELIMITER ;;
CREATE PROCEDURE sp_DELETE_eliminarVeterinarioPorId(
    IN p_Id BIGINT,
    IN p_IdSession INT
)
BEGIN
     -- Actualizar el estado de activo a 0 para el dueño con el ID proporcionado
    UPDATE tVeterinarios
    SET Activo = 0
    WHERE Id = p_Id;
    
    -- Registrar la acción en el log
    INSERT INTO Log (accion, descripcion, usuario_id)
    VALUES (
        'Inactivar Mascota',
        CONCAT('Se ha inactivado el Veterinario con ID: ', p_Id),
        p_IdSession
    );
END;;
DELIMITER ;;



-- ___________________________________________sp_GET_consultarVeterinariosDestacados___________________________________________________44
DELIMITER $$
CREATE PROCEDURE sp_GET_consultarVeterinariosDestacados()
BEGIN
    SELECT 
        Id, 
        NombreVeterinarios AS Nombre, 
        Especialidad, 
        Telefono, 
        Email, 
        ImagePath
    FROM 
        tVeterinarios
    WHERE 
        Destacado = 1 AND Activo = 1
    ORDER BY 
        NombreVeterinarios ASC;
END$$
DELIMITER ;



-- ___________________________________________sp_GET_consultarTratamientoporID_______________________________________________________45
DELIMITER $$
CREATE PROCEDURE sp_GET_consultarTratamientoporID (
    IN p_Id BIGINT
)
BEGIN
    SELECT 
        Id, 
        tMascota_Id, 
        Fecha_Tratamiento, 
        Descripcion, 
        Costo, 
        Activo, 
        tMedicamento_id
    FROM 
        tTratamientos
    WHERE 
        Id = p_Id;
END $$
DELIMITER ;



-- ___________________________________________sp_INSERT_registrarTratamiento_______________________________________________________46
DELIMITER $$
CREATE PROCEDURE sp_INSERT_registrarTratamiento (
    IN p_tMascota_Id BIGINT,
    IN p_Fecha_Tratamiento DATE,
    IN p_Descripcion TEXT,
    IN p_Costo DECIMAL(10, 2),
    IN p_Activo BIT,
    IN p_tMedicamento_id BIGINT,
    IN p_IdSession INT
)
BEGIN
    DECLARE v_LastInsertId BIGINT;

    -- Insertar en la tabla de tratamientos
    INSERT INTO tTratamientos (
        tMascota_Id,
        Fecha_Tratamiento,
        Descripcion,
        Costo,
        Activo,
        tMedicamento_id
    ) 
    VALUES (
        p_tMascota_Id,
        p_Fecha_Tratamiento,
        p_Descripcion,
        p_Costo,
        p_Activo,
        p_tMedicamento_id
    );

    -- Obtener el ID del tratamiento recién insertado
    SET v_LastInsertId = LAST_INSERT_ID();

    -- Insertar en la tabla de Log
    INSERT INTO Log (
        accion,
        descripcion,
        usuario_id
    ) 
    VALUES (
        'INSERT',
        CONCAT('Se registró un nuevo tratamiento con ID: ', v_LastInsertId),
        p_IdSession
    );

    -- Devolver el ID del tratamiento insertado
    SELECT v_LastInsertId AS IdTratamiento;
END$$
DELIMITER ;


-- ___________________________________________sp_UPDATE_activarVeterinarioPorId____________________________________________________47
DELIMITER ;;
CREATE PROCEDURE sp_UPDATE_activarVeterinarioPorId(
    IN p_Id BIGINT,
    IN p_IdSession INT
)
BEGIN
     -- Actualizar el estado de activo a 0 para el dueño con el ID proporcionado
    UPDATE tVeterinarios
    SET Activo = 1
    WHERE Id = p_Id;
    
    -- Registrar la acción en el log
    INSERT INTO Log (accion, descripcion, usuario_id)
    VALUES (
        'Activar Mascota',
        CONCAT('Se ha Activado el Veterinario con ID: ', p_Id),
        p_IdSession
    );
END;;
DELIMITER ;;


