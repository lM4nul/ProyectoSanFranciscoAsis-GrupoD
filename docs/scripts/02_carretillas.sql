use clinica;
-- Categorías de los productos de la tienda
CREATE TABLE categoria (
  catcod BIGINT AUTO_INCREMENT PRIMARY KEY,
  catnombre VARCHAR(80) NOT NULL
) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4;

-- Productos que se venden en la tienda (medicamentos e insumos por igual)
CREATE TABLE producto (
  prodcod BIGINT AUTO_INCREMENT PRIMARY KEY,
  catcod BIGINT NOT NULL,
  prodnombre VARCHAR(120) NOT NULL,
  proddescripcion TEXT NULL,
  prodprincipio VARCHAR(120) NULL,         -- principio activo (solo si aplica)
  prodpresentacion VARCHAR(120) NULL,      -- por ejemplo: caja con 10 tabletas
  prodrequiereceta BOOLEAN NOT NULL DEFAULT FALSE,
  prodprecio DECIMAL(10,2) NOT NULL,
  prodimagen VARCHAR(255) NULL,
  prodest CHAR(3) NOT NULL DEFAULT 'ACT',
  CONSTRAINT producto_categoria_fk FOREIGN KEY (catcod) REFERENCES categoria (catcod),
  CONSTRAINT chk_producto_precio CHECK (prodprecio >= 0)
) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4;