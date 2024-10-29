USE VETCAREDB;

-- Inserta el usuario SYSTEM
INSERT INTO tUsuarios (Identificacion, Nombre, Correo, Contrasenna, Activo, tRol_id)
VALUES ('101110111', 'SYSTEM', 'system.vetcare@outlook.com', 'VetCare123', 1, 1);

-- Se crean los roles
INSERT INTO tRoles (NombreRol) VALUES 
('system'),
('admin'),
('veterinario'),
('cliente');
