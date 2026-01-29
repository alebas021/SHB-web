CREATE DATABASE shbdb
CHARACTER SET utf8mb4
COLLATE utf8mb4_spanish_ci;

USE shbdb;

CREATE TABLE categorias (
  id INT AUTO_INCREMENT PRIMARY KEY,
  nombre VARCHAR(100) NOT NULL,
  descripcion TEXT
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;

CREATE TABLE productos (
  id INT AUTO_INCREMENT PRIMARY KEY,
  nombre VARCHAR(150) NOT NULL,
  descripcion TEXT,
  precio DECIMAL(10,2) NOT NULL,
  imagen VARCHAR(255),
  categoria_id INT,
  CONSTRAINT fk_categoria
    FOREIGN KEY (categoria_id)
    REFERENCES categorias(id)
    ON DELETE SET NULL
    ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;

INSERT INTO categorias (nombre, descripcion) VALUES
('Herramientas y Accesorios', 'Herramientas manuales y accesorios en general'),
('Electricidad', 'Productos eléctricos, bombillos, tomacorrientes, cables'),
('Plomería', 'Tuberías, codos, llaves de agua y conectores'),
('Seguridad y Hogar', 'Artículos variados para el hogar, entre ellos cerraduras, candados y diversos accesorios.'),
('pinturas', 'Pinturas, barnices, esmaltes y accesorios relacionados');

INSERT INTO productos (nombre, descripcion, precio, imagen, categoria_id) VALUES
('Alicate Emtop de Presión 10”', 'Alicate de presión resistente, ideal para trabajos de sujeción y agarre fuerte.', 7.50, 'imagenes/productos/AlicateEmtopDePresion10Pulg.webp', 1),

('Anillo PVC 3/4"', 'Anillo de PVC de 3/4” para instalaciones de agua y conexiones de plomería.', 0.80, 'imagenes/productos/AnilloPvc34.jpg', 3),
('Anillo PVC 1/2"', 'Anillo de PVC de 1/2” usado en tuberías de agua y conexiones básicas.', 0.60, 'imagenes/productos/AnilloPvcMedia.jpg', 3),

('Bombillo LED 9W', 'Bombillo LED de bajo consumo, luz brillante y duradera.', 2.00, 'imagenes/productos/BombilloLed9W.jpg', 2),
('Bombillo LED Cilíndrico 20W', 'Bombillo LED cilíndrico de 20W, ideal para espacios amplios.', 3.50, 'imagenes/productos/BombilloLedCilindrico20W.jpg', 2),

('Brocha 1”', 'Brocha de 1 pulgada para pintura en superficies pequeñas y retoques.', 1.00, 'imagenes/productos/Brocha1Pulgadas.webp', 1),
('Brocha 2”', 'Brocha de 2 pulgadas para trabajos de pintura general.', 1.30, 'imagenes/productos/Brocha2Pulg.jpg', 1),
('Brocha 3”', 'Brocha de 3 pulgadas, ideal para paredes y superficies amplias.', 1.60, 'imagenes/productos/Brocha3Pulgadas.webp', 1),
('Brocha 4”', 'Brocha de 4 pulgadas para trabajos de pintura de mayor cobertura.', 2.00, 'imagenes/productos/Brocha4Pulgadas.webp', 1),
('Brocha 5”', 'Brocha grande de 5 pulgadas para máxima cobertura en superficies amplias.', 2.50, 'imagenes/productos/Brocha5Pulgadas.webp', 1),

('Disco de Corte Covo 4.5” Fino', 'Disco de corte fino 4.5”, ideal para metal y trabajos precisos.', 1.20, 'imagenes/productos/DiscoDeCorteCovo4YMedioFino.jpg', 1),
('Disco de Corte Covo Bosch 4.5” Fino', 'Disco Bosch de corte fino para alto rendimiento en metales.', 1.80, 'imagenes/productos/DiscoDeCorteCovo4YMedioFinoBosch.jpg', 1),

('Juego Destornilladores FIXTEC 4 PCS', 'Set de 4 destornilladores FIXTEC para trabajos generales.', 6.50, 'imagenes/productos/JuegoDestonilladoresFIXTEC4PCS.webp', 1),

('Junta Dresser 3/4"', 'Junta tipo Dresser 3/4” para uniones de tuberías de agua.', 1.20, 'imagenes/productos/JuntaDreeser34.jpg', 3),
('Junta Dresser 1/2"', 'Junta Dresser 1/2” para conexiones de tuberías.', 1.00, 'imagenes/productos/JuntaDreeserMedia.jpg', 3),

('Llave de Tubo Emtop', 'Llave de tubo resistente ideal para trabajos de plomería y mecánica.', 5.80, 'imagenes/productos/LLaveDeTuboEmtop.webp', 1),

('Martillo Emtop 8 Oz', 'Martillo compacto de 8 oz para trabajos generales.', 4.50, 'imagenes/productos/MartilloEmtop8Oz.webp', 1),

('Pintura Decomax Aceite', 'Pintura de aceite ideal para superficies metálicas y de madera.', 4.00, 'imagenes/productos/PinturaDecomaxAceite.jpg', 5),
('Pintura Decomax Caucho', 'Pintura tipo caucho para interiores y exteriores.', 5.00, 'imagenes/productos/PinturaDECOMAXCaucho.jpg', 5),

('Suiche Doble Vitron', 'Interruptor doble Vitron de alta calidad.', 1.80, 'imagenes/productos/SuicheDobleVitron.jpg', 2),
('Suiche Sencillo Vitron', 'Interruptor sencillo Vitron, durable y seguro.', 1.40, 'imagenes/productos/SuicheSencilloVitron.webp', 2),

('Tapa para Toma Doble', 'Tapa decorativa para tomacorriente doble.', 0.90, 'imagenes/productos/TapaParaTomaDoble.webp', 2),

('Tee Roscada PVC 3/4"', 'Tee roscada PVC 3/4” para distribución de líneas de agua.', 1.20, 'imagenes/productos/TeeRoscadaPVC34.jpg', 3),
('Tee Roscada PVC 1/2"', 'Tee roscada PVC 1/2” para conexiones de tuberías.', 1.00, 'imagenes/productos/TeeRoscadaPVCMedia.jpg', 3),

('Tomacorriente Doble 110V 20A', 'Tomacorriente doble resistente de 20A.', 2.50, 'imagenes/productos/TomacorrienteDoble110V20A.webp', 2),

('Tubo Azul Agua 3/4"', 'Tubo azul de agua de 3/4” para instalaciones domésticas.', 3.00, 'imagenes/productos/TuboAzulAgua34.png', 3),
('Tubo Azul Agua 1/2"', 'Tubo azul de agua de 1/2” para redes de agua potable.', 2.20, 'imagenes/productos/TuboAzulAguaMedia.png', 3),

('Unión Universal PVC Rosca 3/4"', 'Unión universal roscada PVC 3/4” para unir tuberías.', 1.50, 'imagenes/productos/UnionUniversalPVCRosca34.png', 3),
('Unión Universal PVC Rosca 1/2"', 'Unión universal roscada PVC 1/2” para instalaciones comunes.', 1.30, 'imagenes/productos/UnionUniversalPVCRoscaMedia.jpg', 3);

CREATE TABLE admins (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL
);

INSERT INTO admins (username, password) VALUES ('alebas', '1235');