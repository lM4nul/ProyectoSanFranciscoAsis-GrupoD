<?php

namespace Controllers\Mnt\Productos;

use Controllers\PublicController;
use Dao\Store\Producto as ProductoDao;
use Views\Renderer;


const PRODUCTO_LIST_VIEW = "mnt/productos/productoList";
class ProductoList extends PublicController
{
    public function run(): void
    {
        $viewData = [
            "productos" => ProductoDao::getAll()
        ];
        Renderer::render(
            PRODUCTO_LIST_VIEW,
            $viewData
        );
    }
}
