
<div class="card border-0 shadow-sm">
    <div class="card-body">

        <div class="d-flex justify-content-between align-items-center mb-3">
            <div>
                <h5 class="mb-1">
                    <?= html_escape($titulo); ?>
                </h5>
                <p class="text-muted mb-0">
                    <?= html_escape($descripcion); ?>
                </p>
            </div>

            <?php if (!empty($crear_url)): ?>
                <a href="<?= $crear_url; ?>" class="btn btn-primary">
                    <i class="bi bi-plus-lg"></i>
                    Nuevo registro
                </a>
            <?php endif; ?>
        </div>

        <div class="table-responsive">
            <table id="tablaModulo"
                   class="table table-striped table-hover align-middle w-100">

                <thead class="table-light">
                    <tr>
                        <?php foreach ($columnas as $columna): ?>
                            <th><?= html_escape($columna); ?></th>
                        <?php endforeach; ?>
                    </tr>
                </thead>

                <tbody>
                    <?php if (!empty($filas)): ?>
                        <?php foreach ($filas as $fila): ?>
                            <tr>
                                <?php foreach ($fila as $valor): ?>
                                    <td><?= html_escape((string) $valor); ?></td>
                                <?php endforeach; ?>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>

            </table>
        </div>

    </div>
</div>

<script>
$(document).ready(function () {
    $('#tablaModulo').DataTable({
        language: {
            url: 'https://cdn.datatables.net/plug-ins/2.1.8/i18n/es-ES.json'
        },
        pageLength: 10,
        lengthMenu: [5, 10, 25, 50, 100],
        ordering: true,
        searching: true,
        responsive: true
    });
});
</script>
