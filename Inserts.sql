USE VETCAREDB;


SET FOREIGN_KEY_CHECKS = 0;
DROP TABLE `tduenos`;
SET FOREIGN_KEY_CHECKS = 1;


-- Inserta el usuario SYSTEM
INSERT INTO tUsuarios (Identificacion, Nombre, Correo, Contrasenna, Activo, tRol_id,ImagePath, Destacado)
VALUES ('102220222', 'SYSTEM', 'sys.vetcare@gmail.com', 'VetCare123', 1, 1, '',0);


-- Se crean los roles
INSERT INTO tRoles (NombreRol) VALUES 
('system'),
('admin'),
('veterinario'),
('cliente');



-- Inserta mascotas SYSTEM
INSERT INTO tMascotas (NombreMascotas, Tipo, Raza, Edad, Peso, Fecha_Registro, tDueno_Id, Activo) 
VALUES 
('Max', 'Perro', 'Golden Retriever', 3, 25.50, '2024-11-10', 1, 1);

INSERT INTO tMascotas (NombreMascotas, Tipo, Raza, Edad, Peso, Fecha_Registro, tDueno_Id, Activo) 
VALUES 
('Luna', 'Gato', 'Siames', 2, 4.30, '2024-11-11', 2, 1);

INSERT INTO tMascotas (NombreMascotas, Tipo, Raza, Edad, Peso, Fecha_Registro, tDueno_Id, Activo) 
VALUES 
('Rocky', 'Perro', 'Bulldog', 5, 22.70, '2024-11-12', 3, 0);



-- Inserta dueños SYSTEM
INSERT INTO tDuenos (NombreDuenos, Telefono, Email, Direccion, Activo) 
VALUES 
('Carlos Ramírez', '8888-1234', 'carlos.ramirez@example.com', 'San José, Avenida Central', 1);

INSERT INTO tDuenos (NombreDuenos, Telefono, Email, Direccion, Activo) 
VALUES 
('María González', '8999-5678', 'maria.gonzalez@example.com', 'Alajuela, Barrio San José', 1);

INSERT INTO tDuenos (NombreDuenos, Telefono, Email, Direccion, Activo) 
VALUES 
('Pedro López', '8777-9012', 'pedro.lopez@example.com', 'Cartago, Urbanización Lomas', 1);

INSERT INTO tDuenos (NombreDuenos, Telefono, Email, Direccion, Activo) 
VALUES 
('Ana Morales', '8666-3456', 'ana.morales@example.com', 'Heredia, Residencial Flores', 1);

INSERT INTO tDuenos (NombreDuenos, Telefono, Email, Direccion, Activo) 
VALUES 
('Laura Jiménez', '8555-7890', 'laura.jimenez@example.com', 'Puntarenas, Centro', 1);





