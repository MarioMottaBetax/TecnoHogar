
</main>
</div>

<!-- jQuery: debe cargarse antes de DataTables -->
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

<!-- Bootstrap 5 -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

<!-- DataTables 1.13.6 -->
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>

<!-- JavaScript general del sistema -->
<script src="<?= base_url('public/js/ventas.js'); ?>"></script>
<script src="<?= base_url('public/js/admin.js'); ?>"></script>
<script src="<?= base_url('public/js/inventario.js'); ?>"></script>
<script src="<?= base_url('public/js/compras.js'); ?>"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>


<!-- JavaScript específico de cada módulo -->
<?php if (!empty($js_adicional)): ?>
    <script src="<?= base_url($js_adicional); ?>"></script>
<?php endif; ?>

</body>
</html>
