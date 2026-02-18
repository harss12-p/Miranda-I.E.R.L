-- ============================================
-- CREAR BASE DE DATOS
-- ============================================

CREATE DATABASE tienda_textil;
USE tienda_textil;


-- Tabla base de usuarios
CREATE TABLE usuarios (
    id INT AUTO_INCREMENT PRIMARY KEY,
    email VARCHAR(255) UNIQUE NOT NULL,
    password_hash VARCHAR(255) NOT NULL,
    tipo ENUM('cliente','admin') NOT NULL,
    estado ENUM('activo','inactivo') DEFAULT 'activo',
    fecha_registro DATETIME DEFAULT CURRENT_TIMESTAMP
);

-- Tabla cliente
CREATE TABLE clientes (
    usuario_id INT PRIMARY KEY,
    nombre VARCHAR(100) NOT NULL,
    apellidos VARCHAR(100) NOT NULL,
    telefono VARCHAR(20),
    FOREIGN KEY (usuario_id) REFERENCES usuarios(id) ON DELETE CASCADE
);

-- Tabla administradores = 
CREATE TABLE administradores (
    usuario_id INT PRIMARY KEY,
    nombre VARCHAR(100) NOT NULL,
    rol VARCHAR(50),
    ultimo_acceso DATETIME,
    FOREIGN KEY (usuario_id) REFERENCES usuarios(id) ON DELETE CASCADE
);

-- Tabla de categorias del material
CREATE TABLE categorias (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(100) NOT NULL,
    descripcion TEXT
);

-- tabla de productos(polos shores, medias. etc.)
CREATE TABLE productos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(150) NOT NULL,
    descripcion TEXT,
    precio DECIMAL(10,2) NOT NULL,
    stock INT DEFAULT 0,
    categoria_id INT,
    estado ENUM('disponible','no_disponible') DEFAULT 'disponible',
    fecha_creacion DATETIME DEFAULT CURRENT_TIMESTAMP,

    FOREIGN KEY (categoria_id) REFERENCES categorias(id)
);

-- Tabla sobre la caracteristicas del producto(si el polo o shores,etc, tendra una imagen o forma.)
CREATE TABLE variaciones_producto (
    id INT AUTO_INCREMENT PRIMARY KEY,
    producto_id INT NOT NULL,
    color VARCHAR(50),
    estampado VARCHAR(100),
    material VARCHAR(100),
    stock INT DEFAULT 0,

    FOREIGN KEY (producto_id) REFERENCES productos(id) ON DELETE CASCADE
);

-- Tabla para tener la iamgen del producto(lo que se colocara en el polo,etc.)
CREATE TABLE imagenes_producto (
    id INT AUTO_INCREMENT PRIMARY KEY,
    producto_id INT NOT NULL,
    ruta_imagen VARCHAR(255),
    principal BOOLEAN DEFAULT FALSE,

    FOREIGN KEY (producto_id) REFERENCES productos(id) ON DELETE CASCADE
);

-- Tabla sobre lo que el cliente ´piensa comprar o compro
CREATE TABLE carrito (
    id INT AUTO_INCREMENT PRIMARY KEY,
    usuario_id INT NOT NULL,
    fecha_creacion DATETIME DEFAULT CURRENT_TIMESTAMP,

    FOREIGN KEY (usuario_id) REFERENCES usuarios(id) ON DELETE CASCADE
);

-- Tabla donde el usuario tendra acceso a lo que pedira o pidio(polos o shores, etc).
CREATE TABLE carrito_items (
    id INT AUTO_INCREMENT PRIMARY KEY,
    carrito_id INT NOT NULL,
    variacion_id INT NOT NULL,
    cantidad INT NOT NULL,

    FOREIGN KEY (carrito_id) REFERENCES carrito(id) ON DELETE CASCADE,

    FOREIGN KEY (variacion_id) REFERENCES variaciones_producto(id)
);

-- Tabla donde estara todo lo que el usuario compro(polos o shores, etc).
CREATE TABLE pedidos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    usuario_id INT NOT NULL,
    total DOUBLE(10,2),
    
    estado ENUM(
        'pendiente',
        'en_produccion',
        'listo_para_recojo',
        'entregado',
        'cancelado'
    ) DEFAULT 'pendiente',

    fecha_pedido DATETIME DEFAULT CURRENT_TIMESTAMP,
    fecha_recojo DATETIME,

    FOREIGN KEY (usuario_id) REFERENCES usuarios(id)
);

-- complemento de la Tabla pedidos para mejor que el usuario y administrador tenga mejor conocmiento del pedido.
CREATE TABLE detalle_pedido (
    id INT AUTO_INCREMENT PRIMARY KEY,
    pedido_id INT NOT NULL,
    variacion_id INT NOT NULL,
    cantidad INT NOT NULL,
    precio_unitario DOUBLE(10,2),

    FOREIGN KEY (pedido_id)
        REFERENCES pedidos(id)
        ON DELETE CASCADE,

    FOREIGN KEY (variacion_id) REFERENCES variaciones_producto(id)
);

-- Tabla para metodos de pago
CREATE TABLE pagos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    pedido_id INT NOT NULL,
    metodo ENUM('efectivo','transferencia','tarjeta'),
    monto DOUBLE(10,2),
    estado ENUM('pendiente','pagado','rechazado') DEFAULT 'pendiente',
    fecha_pago DATETIME,

    FOREIGN KEY (pedido_id) REFERENCES pedidos(id) ON DELETE CASCADE
);

-- Tabla del estado del pedido si ha sido aprobado.
CREATE TABLE cotizaciones (
    id INT AUTO_INCREMENT PRIMARY KEY,
    usuario_id INT NOT NULL,
    descripcion TEXT,
    estado ENUM('pendiente','respondido','aprobado','rechazado')
    DEFAULT 'pendiente',
    
    fecha DATETIME DEFAULT CURRENT_TIMESTAMP,

    FOREIGN KEY (usuario_id) REFERENCES usuarios(id)
);

-- Tabla de sobre que tanto le gusto al cliente el polo o el servicio
CREATE TABLE valoraciones (
    id INT AUTO_INCREMENT PRIMARY KEY,
    usuario_id INT NOT NULL,
    producto_id INT NOT NULL,
    puntuacion INT CHECK (puntuacion BETWEEN 1 AND 5),
    comentario TEXT,
    fecha DATETIME DEFAULT CURRENT_TIMESTAMP,

    FOREIGN KEY (usuario_id) REFERENCES usuarios(id),
    FOREIGN KEY (producto_id) REFERENCES productos(id)
);