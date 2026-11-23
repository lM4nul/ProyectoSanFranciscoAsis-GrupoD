<section class="WWTable">
    <section class="depth-1">
        <h2>Productos</h2>
    </section>
    <table>
        <thead>
            <tr>
                <th>Codigo del producto</th>
                <th>Codigo de la categoria</th>
                <th>Nombre del producto</th>
                <th>Descripcion del producto</th>
                <th>Principio activo</th>
                <th>Presentacion</th>
                <th>Requiere receta</th>
                <th>Precio</th>
                <th>Imagen</th>
                <th>Estado</th>
                <th>
                    <a href="index.php?page=Mnt-Productos-ProductoForm&mode=INS">Nuevo</a>
                </th>
            </tr>
        </thead>
        <tbody>
            {{foreach productos}}
            <tr>
                <td>{{prodcod}}</td>
                <td>{{catcod}}</td>
                <td>{{prodnombre}}</td>
                <td>{{proddescripcion}}</td>
                <td>{{prodprincipio}}</td>
                <td>{{prodpresentacion}}</td>
                <td>{{prodrequiereceta}}</td>
                <td>{{prodprecio}}</td>
                <td>{{prodimagen}}</td>
                <td>{{prodest}}</td>
                <td>
                    <a href="index.php?page=Mnt-Productos-ProductoForm&mode=DSP&prodcod={{prodcod}}">Ver</a><br/>
                    <a href="index.php?page=Mnt-Productos-ProductoForm&mode=UPD&prodcod={{prodcod}}">Editar</a><br/>
                    <a href="index.php?page=Mnt-Productos-ProductoForm&mode=DEL&prodcod={{prodcod}}">Eliminar</a><br/>
                </td>
            </tr>
            {{endfor productos}}
        </tbody>
    </table>
</section>
