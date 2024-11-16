USE VETCAREDB;

-- Se crean los roles
INSERT INTO tRoles (NombreRol) VALUES 
('system'),
('admin'),
('veterinario'),
('cliente');

-- Inserta el usuario SYSTEM
INSERT INTO tUsuarios (Identificacion, Nombre, Correo, Contrasenna, Activo, tRol_id,ImagePath, Destacado)
VALUES ('102220222', 'SYSTEM', 'sys.vetcare@gmail.com', 'VetCare123', 1, 1, '',0);

INSERT INTO tmedicamentos (Nombre, Descripcion, Dosis)
VALUES ('Epiotic spherulites x 100 Ml', 'Su uso regular ayuda a prevenir las recaídas en animales predispuestos y a mantener el equilibrio microbiano natural.', '22cc');
