<?php

namespace Controllers\Mnt\Productos;

use Controllers\PublicController;
use Views\Renderer;
use Utilities\Site;
use Utilities\Validators;
use Dao\Store\Producto as ProductoDao;

const PRODUCTO_FORM_VIEW = "mnt/productos/productoForm";
const PRODUCTO_FORM_XSF_SEED = "85a0ed52-52c6-45b0-b641-b57a6262ddb6";
const PRODUCTO_LIST_URL = "index.php?page=Mnt-Productos-ProductoList";

class ProductoForm extends PublicController
{
    private $viewData = [];

    private $prodcod = 0;
    private $catcod = 0;
    private $prodnombre = "";
    private $proddescripcion = "";
    private $prodprincipio = "";
    private $prodpresentacion = "";
    private $prodrequiereceta = false;
    private $prodprecio = 0;
    private $prodimagen = "";
    private $prodest = "ACT";

    private $mode = "NA";
    private $modeDscArr = [
        "DSP" => "Detalles de %s - %s",
        "INS" => "Crear nuevo Producto",
        "UPD" => "Actualizar %s - %s",
        "DEL" => "Eliminar %s - %s"
    ];

    private $hasErrors = false;
    private $errors = [];

    private $xsfToken = "";


    public function run(): void
    {

        $this->getQueryParams();
        if ($this->isPostBack()) {
            $this->getPostBody();
            if ($this->validatePostBody()) {
                $this->processPostBody();
            }
        }
        $this->prepareViewData();
        Renderer::render(
            PRODUCTO_FORM_VIEW,
            $this->viewData
        );
    }

    private function xss(string $value): string
    {
        return htmlspecialchars($value, ENT_QUOTES | ENT_SUBSTITUTE, "UTF-8");
    }

    private function registerError(string $error, bool $redirect): void
    {
        $this->hasErrors = true;
        $this->errors[] = $error;
        if ($redirect) {
            Site::redirectToWithMsg(PRODUCTO_LIST_URL, implode("\n", $this->errors));
        }
    }
    private function getQueryParams(): void
    {
        $tmpMode = $_GET["mode"] ?? "NA";
        if ($tmpMode === "NA") {
            $this->registerError("El modo no fué enviada a este formulario", true);
        }
        if (!isset($this->modeDscArr[$tmpMode])) {
            $this->registerError("El modo no existe para este formulario", true);
        }
        $this->mode = $tmpMode;
        if ($this->mode !== "INS") {
            $tmpProdcod = $_GET["prodcod"] ?? "NA";
            if ($tmpProdcod === "NA") {
                $this->registerError("El Código del Producto no fue enviado este formulario", true);
            }
            if (!is_numeric($tmpProdcod)) {
                $this->registerError("El Código del Producto no es válido", true);
            }
            $this->prodcod = intval($tmpProdcod);
            $tmpProductoRow = ProductoDao::getById($this->prodcod);
            if (!$tmpProductoRow) {
                $tmpProductoRow = [];
            }
            if (count($tmpProductoRow) === 0) {
                $this->registerError("Producto no existe", true);
            }

            $this->prodcod = $tmpProductoRow["prodcod"];
            $this->catcod = $tmpProductoRow["catcod"];
            $this->prodnombre = $this->xss($tmpProductoRow["prodnombre"] ?? "");
            $this->proddescripcion = $this->xss($tmpProductoRow["proddescripcion"] ?? "");
            $this->prodprincipio = $this->xss($tmpProductoRow["prodprincipio"] ?? "");
            $this->prodpresentacion = $this->xss($tmpProductoRow["prodpresentacion"] ?? "");
            $this->prodrequiereceta = (bool)$tmpProductoRow["prodrequiereceta"];
            $this->prodprecio = $tmpProductoRow["prodprecio"];
            $this->prodimagen = $this->xss($tmpProductoRow["prodimagen"] ?? "");
            $this->prodest = $this->xss($tmpProductoRow["prodest"] ?? "");
        }
    }
    private function getPostBody(): void
    {
        $this->validateXsfToken($_POST["xsftoken"] ?? "");
        $this->prodcod = intval($_POST["prodcod"] ?? "0");
        $this->catcod = intval($_POST["catcod"] ?? "0");
        $this->prodnombre = $this->xss($_POST["prodnombre"] ?? "");
        $this->proddescripcion = $this->xss($_POST["proddescripcion"] ?? "");
        $this->prodprincipio = $this->xss($_POST["prodprincipio"] ?? "");
        $this->prodpresentacion = $this->xss($_POST["prodpresentacion"] ?? "");
        $this->prodrequiereceta = (($_POST["prodrequiereceta"] ?? "0") === "1");
        $this->prodprecio = floatval($_POST["prodprecio"] ?? "0");
        $this->prodimagen = $this->xss($_POST["prodimagen"] ?? "");
        $this->prodest = $this->xss($_POST["prodest"] ?? "");
    }
    private function validatePostBody(): bool
    {
        if ($this->catcod <= 0) {
            $this->registerError("El Código de Categoría es requerido", true);
        }

        if (Validators::IsEmpty($this->prodnombre)) {
            $this->registerError("El Nombre del Producto es requerido", true);
        }

        if (!is_numeric($_POST["prodprecio"] ?? "") || $this->prodprecio < 0) {
            $this->registerError("El Precio debe ser un número mayor o igual a cero", true);
        }

        if (!in_array($_POST["prodrequiereceta"] ?? "", ["0", "1"], true)) {
            $this->registerError("Requiere receta debe ser 0 o 1", true);
        }

        if (Validators::IsEmpty($this->prodest)) {
            $this->registerError("El Estado es requerido", true);
        }

        return !$this->hasErrors;
    }
    private function processPostBody(): void
    {
        $tmpDescripcion = $this->proddescripcion === "" ? null : $this->proddescripcion;
        $tmpPrincipio = $this->prodprincipio === "" ? null : $this->prodprincipio;
        $tmpPresentacion = $this->prodpresentacion === "" ? null : $this->prodpresentacion;
        $tmpImagen = $this->prodimagen === "" ? null : $this->prodimagen;
        switch ($this->mode) {
            case "INS":
                if (ProductoDao::new(
                    $this->catcod,
                    $this->prodnombre,
                    $tmpDescripcion,
                    $tmpPrincipio,
                    $tmpPresentacion,
                    $this->prodrequiereceta,
                    $this->prodprecio,
                    $tmpImagen,
                    $this->prodest
                )) {
                    Site::redirectToWithMsg(PRODUCTO_LIST_URL, "Producto Agregado Satisfactoriamente");
                }
                break;
            case "UPD":
                if (ProductoDao::update(
                    $this->catcod,
                    $this->prodnombre,
                    $tmpDescripcion,
                    $tmpPrincipio,
                    $tmpPresentacion,
                    $this->prodrequiereceta,
                    $this->prodprecio,
                    $tmpImagen,
                    $this->prodest,
                    $this->prodcod
                )) {
                    Site::redirectToWithMsg(PRODUCTO_LIST_URL, "Producto Actualizado Satisfactoriamente");
                }
                break;
            case "DEL":
                if (ProductoDao::delete(
                    $this->prodcod
                )) {
                    Site::redirectToWithMsg(PRODUCTO_LIST_URL, "Producto Eliminado Satisfactoriamente");
                }
                break;
        }
    }
    private function generarXsfToken()
    {
        $token =  hash("sha256", time() . rand(10000, 99999) . PRODUCTO_FORM_XSF_SEED);
        $_SESSION["PRODUCTO_FORM_XSF_T"] = $token;
        $this->xsfToken = $token;
    }
    private function validateXsfToken($token)
    {
        if (isset($_SESSION["PRODUCTO_FORM_XSF_T"])) {
            if ($token !== $_SESSION["PRODUCTO_FORM_XSF_T"]) {
                $this->registerError("Algo no esta bien, intente nuevamente!", true);
            }
        } else {
            $this->registerError("Algo no esta bien, intente nuevamente!", true);
        }
    }
    private function prepareViewData(): void
    {
        $this->viewData["mode"] = $this->mode;

        $this->viewData["modeDsc"] = sprintf(
            $this->modeDscArr[$this->mode],
            $this->prodcod,
            $this->prodnombre
        );

        $this->viewData["prodcod"] = $this->prodcod;
        $this->viewData["catcod"] = $this->catcod;
        $this->viewData["prodnombre"] = $this->prodnombre;
        $this->viewData["proddescripcion"] = $this->proddescripcion;
        $this->viewData["prodprincipio"] = $this->prodprincipio;
        $this->viewData["prodpresentacion"] = $this->prodpresentacion;
        $this->viewData["prodrequiereceta"] = $this->prodrequiereceta ? 1 : 0;
        $this->viewData["prodprecio"] = $this->prodprecio;
        $this->viewData["prodimagen"] = $this->prodimagen;
        $this->viewData["prodest"] = $this->prodest;
        $this->viewData["readonly"] = "";
        $this->viewData["showGuardar"] = true;
        if (in_array($this->mode, ["DSP", "DEL"])) {
            $this->viewData["readonly"] = "readonly";
            $this->viewData["showGuardar"] = ($this->mode !== "DSP");
        }


        $this->viewData["action"] = "index.php?page=Mnt-Productos-ProductoForm&mode=" . $this->mode;
        if ($this->mode !== "INS") {
            $this->viewData["action"] .= "&prodcod=" . $this->prodcod;
        }
        $this->generarXsfToken();
        $this->viewData["xsftoken"] = $this->xsfToken;
    }
}
