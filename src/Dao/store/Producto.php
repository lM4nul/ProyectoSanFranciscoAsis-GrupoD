<?php

namespace Dao\Store;

use Dao\Table;

const STORE_PRODUCTO_SELECT_ALL = "SELECT `prodcod`,`catcod`,`prodnombre`,`proddescripcion`,`prodprincipio`,`prodpresentacion`,`prodrequiereceta`,`prodprecio`,`prodimagen`,`prodest` FROM `producto`";
const STORE_PRODUCTO_SELECT_BY_ID = "SELECT `prodcod`,`catcod`,`prodnombre`,`proddescripcion`,`prodprincipio`,`prodpresentacion`,`prodrequiereceta`,`prodprecio`,`prodimagen`,`prodest` FROM `producto` where `prodcod` = :prodcod;";
const STORE_PRODUCTO_INSERT = "insert into `producto` ( `catcod`, `prodnombre`, `proddescripcion`, `prodprincipio`, `prodpresentacion`, `prodrequiereceta`, `prodprecio`, `prodimagen`, `prodest`) values (:catcod, :prodnombre, :proddescripcion, :prodprincipio, :prodpresentacion, :prodrequiereceta, :prodprecio, :prodimagen, :prodest);";
const STORE_PRODUCTO_UPDATE = "update `producto` set `catcod` = :catcod, `prodnombre` = :prodnombre, `proddescripcion` = :proddescripcion, `prodprincipio` = :prodprincipio, `prodpresentacion` = :prodpresentacion, `prodrequiereceta` = :prodrequiereceta, `prodprecio` = :prodprecio, `prodimagen` = :prodimagen, `prodest` = :prodest where `prodcod` = :prodcod;";
const STORE_PRODUCTO_DELETE = "delete from `producto` where `prodcod` = :prodcod;";


class Producto extends Table
{
    private function __construct()
    {
        throw new \Exception('Not implemented');
    }
    private function __clone()
    {
        throw new \Exception('Not implemented');
    }

    public static function getAll(): array
    {
        return self::obtenerRegistros(
           STORE_PRODUCTO_SELECT_ALL,[]     
        );
    }
    public static function getById(int $prodcod)
    {
        return self::obtenerUnRegistro(
            STORE_PRODUCTO_SELECT_BY_ID,
            [
                "prodcod" => $prodcod
            ]
        );
    }
    public static function new(
        int $catcod,
        string $prodnombre,
        ?string $proddescripcion,
        ?string $prodprincipio,
        ?string $prodpresentacion,
        bool $prodrequiereceta,
        float $prodprecio,
        ?string $prodimagen,
        string $prodest
    ) {
        return self::executeNonQuery(
            STORE_PRODUCTO_INSERT,
            [
                "catcod" => $catcod,
                "prodnombre" => $prodnombre,
                "proddescripcion" => $proddescripcion,
                "prodprincipio" => $prodprincipio,
                "prodpresentacion" => $prodpresentacion,
                "prodrequiereceta" => $prodrequiereceta,
                "prodprecio" => $prodprecio,
                "prodimagen" => $prodimagen,
                "prodest" => $prodest
            ]
        );
    }

    public static function update(
        int $catcod,
        string $prodnombre,
        ?string $proddescripcion,
        ?string $prodprincipio,
        ?string $prodpresentacion,
        bool $prodrequiereceta,
        float $prodprecio,
        ?string $prodimagen,
        string $prodest,
        int $prodcod
    ) {
        return self::executeNonQuery(
            STORE_PRODUCTO_UPDATE,
            [
                "catcod" => $catcod,
                "prodnombre" => $prodnombre,
                "proddescripcion" => $proddescripcion,
                "prodprincipio" => $prodprincipio,
                "prodpresentacion" => $prodpresentacion,
                "prodrequiereceta" => $prodrequiereceta,
                "prodprecio" => $prodprecio,
                "prodimagen" => $prodimagen,
                "prodest" => $prodest,
                "prodcod" => $prodcod
            ]
        );
    }

    public static function delete(int $prodcod)
    {
        return self::executeNonQuery(
            STORE_PRODUCTO_DELETE,
            [
                "prodcod" => $prodcod
            ]
        );
    }
}
