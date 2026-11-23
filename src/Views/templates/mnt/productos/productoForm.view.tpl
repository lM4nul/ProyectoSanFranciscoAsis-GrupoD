<section class="depth-1 py-4 px-4">
    <h2>{{modeDsc}}</h2>
</section>
<section class="depth-2 grid">
    <form class="col-12 col-m-8 offset-m-2 col-l-6 offset-l-3"
        action="{{action}}" method="post">
        <input type="hidden" name="prodcod" value="{{prodcod}}" />
        <input type="hidden" name="xsftoken" value="{{xsftoken}}" />
        <div class="row my-3">
            <label class="col-12 col-m-5 col-l-4" for="catcod">Código de Categoría</label>
            <input {{readonly}} class="col-12 col-m-7 col-l-8" type="number" name="catcod" value="{{catcod}}"
                id="catcod" />
        </div>
        <div class="row my-3">
            <label class="col-12 col-m-5 col-l-4" for="prodnombre">Nombre</label>
            <input {{readonly}} class="col-12 col-m-7 col-l-8" type="text" name="prodnombre" value="{{prodnombre}}"
                id="prodnombre" />
        </div>
        <div class="row my-3">
            <label class="col-12 col-m-5 col-l-4" for="proddescripcion">Descripción</label>
            <input {{readonly}} class="col-12 col-m-7 col-l-8" type="text" name="proddescripcion" value="{{proddescripcion}}"
                id="proddescripcion" />
        </div>
        <div class="row my-3">
            <label class="col-12 col-m-5 col-l-4" for="prodprincipio">Principio Activo</label>
            <input {{readonly}} class="col-12 col-m-7 col-l-8" type="text" name="prodprincipio" value="{{prodprincipio}}"
                id="prodprincipio" />
        </div>
        <div class="row my-3">
            <label class="col-12 col-m-5 col-l-4" for="prodpresentacion">Presentación</label>
            <input {{readonly}} class="col-12 col-m-7 col-l-8" type="text" name="prodpresentacion" value="{{prodpresentacion}}"
                id="prodpresentacion" />
        </div>
        <div class="row my-3">
            <label class="col-12 col-m-5 col-l-4" for="prodrequiereceta">Requiere receta (0=No, 1=Sí)</label>
            <input {{readonly}} class="col-12 col-m-7 col-l-8" type="number" min="0" max="1" name="prodrequiereceta" value="{{prodrequiereceta}}"
                id="prodrequiereceta" />
        </div>
        <div class="row my-3">
            <label class="col-12 col-m-5 col-l-4" for="prodprecio">Precio</label>
            <input {{readonly}} class="col-12 col-m-7 col-l-8" type="number" step="0.01" name="prodprecio" value="{{prodprecio}}"
                id="prodprecio" />
        </div>
        <div class="row my-3">
            <label class="col-12 col-m-5 col-l-4" for="prodimagen">Imagen (url)</label>
            <input {{readonly}} class="col-12 col-m-7 col-l-8" type="url" name="prodimagen" value="{{prodimagen}}"
                id="prodimagen" />
        </div>
        <div class="row my-3">
            <label class="col-12 col-m-5 col-l-4" for="prodest">Estado</label>
            <input {{readonly}} class="col-12 col-m-7 col-l-8" type="text" name="prodest" value="{{prodest}}"
                id="prodest" />
        </div>
        <div class="row my-3 flex-end">
            {{if showGuardar}}
            <button class="col-12 col-m-2 primary" type="submit">Guardar</button>&nbsp;
            {{endif showGuardar}}
            <button class="col-12 col-m-2" id="btnCancelar">Cancelar</button>
        </div>
    </form>
    <script>
        document.addEventListener("DOMContentLoaded", ()=>{
            document.querySelector("#btnCancelar").addEventListener("click", (e)=>{
                e.preventDefault();
                e.stopPropagation();
                window.location.assign("index.php?page=Mnt-Productos-ProductoList");
            });
        });
    </script>
</section>
