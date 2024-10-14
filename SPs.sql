USE VETCAREDB;

DELIMITER $$

CREATE PROCEDURE sp_insertar_usuario (
    IN p_nombre VARCHAR(100),
    IN p_email VARCHAR(100),
    IN p_contraseña VARCHAR(255),
    IN p_rol_id INT
)
BEGIN
    -- Verifica si ya existe un usuario con el mismo email
    IF EXISTS (SELECT 1 FROM usuarios WHERE email = p_email) THEN
        SIGNAL SQLSTATE '45000'
        SET MESSAGE_TEXT = 'El correo electrónico ya está registrado';
    ELSE
        -- Insertar nuevo usuario
        INSERT INTO usuarios (nombre, email, contraseña, rol_id, fecha_registro)
        VALUES (p_nombre, p_email, p_contraseña, p_rol_id, CURRENT_TIMESTAMP);
    END IF;
END $$

DELIMITER ;
