--------------- TABLAS ---------------

CREATE TABLE TipoUsuario (
    id_tipo_usuario INT PRIMARY KEY AUTO_INCREMENT,
    nombre VARCHAR(50) UNIQUE
);

---------------------------------------

CREATE TABLE Estado_Cita (
    id_estado INT PRIMARY KEY AUTO_INCREMENT,
    estado VARCHAR(50) NOT NULL
);

---------------------------------------

CREATE TABLE Usuarios (
    id_usuario INT PRIMARY KEY AUTO_INCREMENT,
    nombre VARCHAR(100),
    correo VARCHAR(100) UNIQUE,
    contrasena VARCHAR(100),
    id_tipo_usuario INT,
    FOREIGN KEY (id_tipo_usuario) REFERENCES TipoUsuario(id_tipo_usuario)
);

---------------------------------------

CREATE TABLE Terapeutas (
    id_terapeuta INT PRIMARY KEY AUTO_INCREMENT,
    nombre VARCHAR(100),
    apellido VARCHAR(100),
    id_especialidad INT,
    correo VARCHAR(100),
    FOREIGN KEY (id_especialidad) REFERENCES Especialidades(id_especialidad)
);

---------------------------------------

CREATE TABLE Especialidades (
    id_especialidad INT PRIMARY KEY AUTO_INCREMENT,
    nombre VARCHAR(100) UNIQUE
);

---------------------------------------

CREATE TABLE Terapias (
    id_terapia INT PRIMARY KEY AUTO_INCREMENT,
    nombre VARCHAR(100),
    descripcion VARCHAR(500),
    precio DECIMAL(8,2)
);

---------------------------------------

CREATE TABLE Citas (
    id_cita INT PRIMARY KEY AUTO_INCREMENT,
    id_cliente INT,
    id_terapeuta INT,
    fecha_hora DATETIME,
    id_terapia INT,
    id_estado INT,
    FOREIGN KEY (id_cliente) REFERENCES Usuarios(id_usuario),
    FOREIGN KEY (id_terapeuta) REFERENCES Terapeutas(id_terapeuta),
    FOREIGN KEY (id_terapia) REFERENCES Terapias(id_terapia),
    FOREIGN KEY (id_estado) REFERENCES Estado_Cita(id_estado) 
);

---------------------------------------

CREATE TABLE Paquetes (
    id_paquete INT PRIMARY KEY AUTO_INCREMENT,
    nombre VARCHAR(255) NOT NULL,
    precio DECIMAL(10, 2) NOT NULL,
    descripcion TEXT,
    fecha_creacion TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

---------------------------------------

CREATE TABLE Detalles_Paquete (
    id_detalle INT PRIMARY KEY AUTO_INCREMENT,
    id_paquete INT,
    detalle VARCHAR(255) NOT NULL,
    FOREIGN KEY (id_paquete) REFERENCES Paquetes(id_paquete) ON DELETE CASCADE
);

---------------------------------------

CREATE TABLE Servicios (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(255) NOT NULL,
    descripcion TEXT NOT NULL,
    caracteristicas TEXT NOT NULL,
    id_paquete INT,
    FOREIGN KEY (id_paquete) REFERENCES Paquetes(id_paquete)
);

---------------------------------------

CREATE TABLE Facturas (
    id_factura INT(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
    nombre_cliente VARCHAR(100) NOT NULL,
    telefono_cliente VARCHAR(15) NOT NULL,
    correo_cliente VARCHAR(100) NOT NULL,
    cedula_cliente VARCHAR(20) NOT NULL,
    id_paquete INT(11) NOT NULL,
    duracion_mes INT(2) NOT NULL,
    fecha_pago DATETIME NOT NULL,
    total DECIMAL(10, 2) NOT NULL,
    FOREIGN KEY (id_paquete) REFERENCES Paquetes(id_paquete)
);

---------------------------------------

--------------- INSERTS ---------------

INSERT INTO TipoUsuario (nombre) VALUES ('admin');
INSERT INTO TipoUsuario (nombre) VALUES ('cliente');

---------------------------------------

INSERT INTO Estado_Cita (estado) VALUES ('activa');
INSERT INTO Estado_Cita (estado) VALUES ('cancelada');

---------------------------------------

INSERT INTO Paquetes (nombre, precio, descripcion) VALUES
('Paquete Inicial', 35.00, 'Paquete básico para nuevas consultas.'),
('Paquete Profesional', 65.00, 'Paquete con consultas ilimitadas y seguimiento continuo.'),
('Paquete Premium', 125.00, 'Paquete completo con atención prioritaria y asesoría integral.');

---------------------------------------

-- Paquete Inicial
INSERT INTO Detalles_Paquete (id_paquete, detalle) VALUES
(1, 'Consulta inicial'),
(1, 'Diagnóstico personalizado'),
(1, 'Plan de tratamiento'),
(1, 'Psicoterapia Individual'),
(1, 'Apoyo Psicológico a Adolescentes'),
(1, 'Terapia de Depresión');

---------------------------------------

-- Paquete Profesional
INSERT INTO Detalles_Paquete (id_paquete, detalle) VALUES
(2, 'Consultas ilimitadas'),
(2, 'Acceso a especialistas'),
(2, 'Seguimiento continuo'),
(2, 'Terapia de Pareja'),
(2, 'Terapia Familiar'),
(2, 'Asesoramiento en Crisis');

---------------------------------------

-- Paquete Premium
INSERT INTO Detalles_Paquete (id_paquete, detalle) VALUES
(3, 'Atención prioritaria'),
(3, 'Consultas a domicilio'),
(3, 'Asesoría integral'),
(3, 'Mindfulness y Bienestar'),
(3, 'Terapia de Ansiedad'),
(3, 'Coaching Personalizado');

---------------------------------------

INSERT INTO Usuarios (nombre, correo, contrasena, id_tipo_usuario) 
VALUES ('Juan Pérez', 'juan@example.com', 'password123', 1);

INSERT INTO Usuarios (nombre, correo, contrasena, id_tipo_usuario) 
VALUES ('Ana Gómez', 'ana@example.com', 'password456', 2);

---------------------------------------

INSERT INTO Terapeutas (nombre, especialidad)
VALUES
('Terapeuta 1', 'Psicología'),
('Terapeuta 2', 'Psiquiatría'),
('Terapeuta 3', 'Terapia familiar'),
('Terapeuta 4', 'Terapia cognitivo-conductual'),
('Terapeuta 5', 'Mindfulness');

---------------------------------------

INSERT INTO Terapias (nombre, descripcion, precio)
VALUES
('Terapia Cognitiva', 'Terapia enfocada en cambiar patrones de pensamiento negativos.', 80.00),
('Terapia de Pareja', 'Ayuda a mejorar la comunicación y resolver conflictos en la pareja.', 100.00),
('Terapia Infantil', 'Dirigida a niños y adolescentes para tratar problemas emocionales y conductuales.', 70.00),
('Mindfulness', 'Técnica de meditación que ayuda a reducir el estrés y mejorar el bienestar emocional.', 90.00),
('Psicoterapia Gestalt', 'Enfoque terapéutico que enfatiza la importancia del "aquí y ahora".', 85.00);

---------------------------------------

INSERT INTO Especialidades (nombre) VALUES ('Psicología Clínica');
INSERT INTO Especialidades (nombre) VALUES ('Psicoterapia Cognitivo-Conductual');
INSERT INTO Especialidades (nombre) VALUES ('Psicología Infantil');
INSERT INTO Especialidades (nombre) VALUES ('Psicología Deportiva');
INSERT INTO Especialidades (nombre) VALUES ('Psicología de Pareja');

----------------------------------------

INSERT INTO Servicios (nombre, descripcion, caracteristicas, id_paquete) VALUES
('Psicoterapia Individual', 'Apoyo profesional personalizado para enfrentar retos emocionales.', 'Terapia cognitivo-conductual, Técnicas de relajación', 1),
('Terapia de Pareja', 'Mejora la comunicación y resuelve conflictos en la relación.', 'Enfoque en la resolución de conflictos, Técnicas de comunicación efectiva', 2),
('Mindfulness y Bienestar', 'Entrenamiento en mindfulness para reducir estrés y mejorar el bienestar general.', 'Prácticas de mindfulness guiadas, Técnicas de respiración consciente', 3),
('Apoyo Psicológico a Adolescentes', 'Acompañamiento profesional adaptado a las necesidades específicas de adolescentes.', 'Enfoque en problemas adolescentes comunes, Terapia centrada en el desarrollo personal', 1),
('Terapia Familiar', 'Soluciones para mejorar la dinámica familiar y fortalecer los lazos afectivos.', 'Intervenciones basadas en el sistema familiar, Terapia centrada en la resolución de conflictos familiares', 2),
('Terapia de Ansiedad', 'Tratamiento especializado para gestionar y superar la ansiedad.', 'Técnicas de control de la ansiedad, Enfoque en la gestión emocional', 3),
('Terapia de Depresión', 'Apoyo profesional para manejar y superar la depresión.', 'Intervención psicológica especializada, Estrategias para mejorar el estado de ánimo', 1),
('Asesoramiento en Crisis', 'Apoyo profesional para situaciones de crisis emocional y personal.', 'Estrategias de intervención inmediata, Apoyo emocional en momentos críticos', 2),
('Coaching Personalizado', 'Desarrollo personal guiado para alcanzar objetivos y mejorar la calidad de vida.', 'Coaching centrado en metas personales, Apoyo para el crecimiento personal', 3);

----------------------------------------