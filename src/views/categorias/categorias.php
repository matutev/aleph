<h3 class="my-3" id="titulo">Categorias</h3>

<?php require_once 'src/views/messages/alert.php'; ?>

<?php if(!empty($this->categorias)): ?>

<table class="table table-hover table-bordered my-3" id="categoriasTable">
    <thead class="table-dark">
        <tr>
            <th scope="col">Id</th>
            <th scope="col">Nombre</th>
            <th scope="col">Acciones</th>
        </tr>
    </thead>
    <tbody>
    <?php foreach($this->categorias as $categoria) : ?>
        <tr>
            <td><?= $categoria['id']; ?></td>
            <td><?= $categoria['nombre']; ?></td>
            <td>
                <a href="<?= $this->basePublicUrl ?>exportCategoria/<?= $categoria['id']; ?>" class="btn btn-success btn-sm me-2">Exportar CSV</a>
                <?php if($categoria['nombre'] == 'Categoria test api'): ?>
                    <a href="<?= $this->basePublicUrl ?>insertCsvDataIntoCategoriaTest/<?= $categoria['id']; ?>" class="btn btn-primary btn-sm me-2">Insertar cmdb</a>
                <?php endif; ?>           
            </td>
        </tr>
    <?php endforeach; ?>
    </tbody>
</table>

<?php endif; ?>