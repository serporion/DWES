
<div class = "container">
    <h1>Editar Usuario</h1>
    <div class = "col-md-12 well">
        <form role = "form" id = "myForm" action = "<?=BASE_URL?>Usuario/guardarCategoria" method = "post" enctype="multipart/form-data">

            <input type="hidden" name="id" value="<?= $mi_categoria->getId() ?>" >

            <div class="mb-3">
                <label for="nombre" class="form-label">Nombre</label>
                <input type="text" class="form-control" id="nombre" name="nombre" aria-describedby="nombreHelp" minLength = "5" value="<?= htmlspecialchars($mi_categoria->getNombre()) ?>" required = "true">
            </div>

            <button type="submit" class="btn btn-primary">Enviar</button>
            <button type="submit" class="btn btn-primary" onclick="history.back()">Cancelar</button>
        </form>
    </div>
</div>
