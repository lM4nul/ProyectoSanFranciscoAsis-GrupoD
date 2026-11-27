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



USE clinica;

-- Existencias para controlar carrito y ventas
ALTER TABLE `producto`
    ADD COLUMN `prodstock` INT NOT NULL DEFAULT 0 AFTER `prodprecio`;

-- Carrito solo para usuarios logueados
CREATE TABLE `carretilla` (
    `usercod` BIGINT(10) NOT NULL,
    `prodcod` BIGINT NOT NULL,
    `crrctd` INT NOT NULL,
    `crrprc` DECIMAL(10, 2) NOT NULL,
    `crrfching` DATETIME NOT NULL,
    PRIMARY KEY (`usercod`, `prodcod`),
    KEY `carretilla_producto_idx` (`prodcod`),
    CONSTRAINT `carretilla_usuario_fk`
        FOREIGN KEY (`usercod`) REFERENCES `usuario` (`usercod`)
        ON DELETE NO ACTION ON UPDATE NO ACTION,
    CONSTRAINT `carretilla_producto_fk`
        FOREIGN KEY (`prodcod`) REFERENCES `producto` (`prodcod`)
        ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4;

-- Cabecera de ventas
CREATE TABLE `venta` (
    `ventacod` BIGINT NOT NULL AUTO_INCREMENT,
    `usercod` BIGINT(10) NOT NULL,
    `ventafch` DATETIME NOT NULL,
    `ventatotal` DECIMAL(12, 2) NOT NULL,
    `ventaest` CHAR(3) NOT NULL DEFAULT 'PEN' COMMENT 'PEN=Pendiente, PAG=Pagada, ANU=Anulada',
    `ventapagoref` VARCHAR(128) NULL,
    `ventadsc` VARCHAR(255) NULL,
    PRIMARY KEY (`ventacod`),
    KEY `venta_usuario_idx` (`usercod`),
    KEY `venta_fecha_idx` (`ventafch`),
    CONSTRAINT `venta_usuario_fk`
        FOREIGN KEY (`usercod`) REFERENCES `usuario` (`usercod`)
        ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4;

-- Detalle de ventas
CREATE TABLE `detalle_venta` (
    `detallecod` BIGINT NOT NULL AUTO_INCREMENT,
    `ventacod` BIGINT NOT NULL,
    `prodcod` BIGINT NOT NULL,
    `detallenombre` VARCHAR(120) NOT NULL,
    `detallecantidad` INT NOT NULL,
    `detalleprecio` DECIMAL(10, 2) NOT NULL,
    `detallesubtotal` DECIMAL(12, 2) NOT NULL,
    PRIMARY KEY (`detallecod`),
    KEY `detalle_venta_venta_idx` (`ventacod`),
    KEY `detalle_venta_producto_idx` (`prodcod`),
    CONSTRAINT `detalle_venta_venta_fk`
        FOREIGN KEY (`ventacod`) REFERENCES `venta` (`ventacod`)
        ON DELETE NO ACTION ON UPDATE NO ACTION,
    CONSTRAINT `detalle_venta_producto_fk`
        FOREIGN KEY (`prodcod`) REFERENCES `producto` (`prodcod`)
        ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4;