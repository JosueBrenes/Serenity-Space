-- TABLAS

CREATE TABLE TipoUsuario (
    id_tipo_usuario INT PRIMARY KEY AUTO_INCREMENT,
    nombre VARCHAR(50) UNIQUE
);

CREATE TABLE Estado_Cita (
    id_estado INT PRIMARY KEY AUTO_INCREMENT,
    estado VARCHAR(50) NOT NULL
);

CREATE TABLE Usuarios (
    id_usuario INT PRIMARY KEY AUTO_INCREMENT,
    nombre VARCHAR(100),
    correo VARCHAR(100) UNIQUE,
    contrasena VARCHAR(100),
    id_tipo_usuario INT,
    FOREIGN KEY (id_tipo_usuario) REFERENCES TipoUsuario(id_tipo_usuario)
);

CREATE TABLE Terapeutas (
    id_terapeuta INT PRIMARY KEY AUTO_INCREMENT,
    nombre VARCHAR(100),
    apellido VARCHAR(100)
    especialidad VARCHAR(100),
    correo VARCHAR(100)
);

CREATE TABLE Terapias (
    id_terapia INT PRIMARY KEY AUTO_INCREMENT,
    nombre VARCHAR(100),
    descripcion VARCHAR(500),
    precio DECIMAL(8,2)
);

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

CREATE TABLE Pagos (
    id_pago INT PRIMARY KEY AUTO_INCREMENT,
    id_cliente INT,
    id_terapia INT,
    monto DECIMAL(8,2),
    fecha_pago TIMESTAMP,
    metodo_pago VARCHAR(50),
    FOREIGN KEY (id_cliente) REFERENCES Usuarios(id_usuario),
    FOREIGN KEY (id_terapia) REFERENCES Terapias(id_terapia)
);

INSERT INTO TipoUsuario (nombre) VALUES ('admin');
INSERT INTO TipoUsuario (nombre) VALUES ('cliente');

INSERT INTO Estado_Cita (estado) VALUES ('activa');
INSERT INTO Estado_Cita (estado) VALUES ('cancelada');

INSERT INTO Usuarios (nombre, correo, contrasena, id_tipo_usuario) 
VALUES ('Juan Pérez', 'juan@example.com', 'password123', 1);
INSERT INTO Usuarios (nombre, correo, contrasena, id_tipo_usuario) 
VALUES ('Ana Gómez', 'ana@example.com', 'password456', 2);

INSERT INTO Terapeutas (nombre, especialidad)
VALUES
('Terapeuta 1', 'Psicología'),
('Terapeuta 2', 'Psiquiatría'),
('Terapeuta 3', 'Terapia familiar'),
('Terapeuta 4', 'Terapia cognitivo-conductual'),
('Terapeuta 5', 'Mindfulness');

INSERT INTO Terapias (nombre, descripcion, precio)
VALUES
('Terapia Cognitiva', 'Terapia enfocada en cambiar patrones de pensamiento negativos.', 80.00),
('Terapia de Pareja', 'Ayuda a mejorar la comunicación y resolver conflictos en la pareja.', 100.00),
('Terapia Infantil', 'Dirigida a niños y adolescentes para tratar problemas emocionales y conductuales.', 70.00),
('Mindfulness', 'Técnica de meditación que ayuda a reducir el estrés y mejorar el bienestar emocional.', 90.00),
('Psicoterapia Gestalt', 'Enfoque terapéutico que enfatiza la importancia del "aquí y ahora".', 85.00);
