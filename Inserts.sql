USE VETCAREDB;

-- Inserta el usuario SYSTEM
INSERT INTO tUsuarios (Identificacion, Nombre, Correo, Contrasenna, Activo, tRol_id,ImagePath, Destacado)
VALUES ('102220222', 'SYSTEM', 'sys.vetcare@gmail.com', 'VetCare123', 1, 1, '',0);

-- Se crean los roles
INSERT INTO tRoles (NombreRol) VALUES 
('system'),
('admin'),
('veterinario'),
('cliente');


