
<div class="catalogo-container">

    <div class="catalogo-encabezado">
        <div>
            <h2>Catálogo de productos</h2>
            <p>Encuentra los productos disponibles en TecnoHogar.</p>
        </div>

        <span class="catalogo-contador">
            <?= count($productos); ?> productos
        </span>
    </div>

    <!-- Buscador y filtros -->
    <form method="GET"
          action="<?= base_url('cliente/productos'); ?>"
          class="catalogo-filtros">

        <div class="catalogo-buscador">
            <i class="bi bi-search"></i>

            <input
                type="text"
                name="buscar"
                placeholder="Buscar productos..."
                value="<?= html_escape($busqueda); ?>"
            >
        </div>

        <select name="categoria" class="form-select">
            <option value="">Todas las categorías</option>

            <?php foreach ($categorias as $cat): ?>
                <option
                    value="<?= html_escape($cat->categoria); ?>"
                    <?= $categoria_seleccionada == $cat->categoria ? 'selected' : ''; ?>
                >
                    <?= html_escape($cat->categoria); ?>
                </option>
            <?php endforeach; ?>
        </select>

        <button type="submit" class="btn btn-primary">
            <i class="bi bi-funnel"></i>
            Filtrar
        </button>

        <a href="<?= base_url('cliente/productos'); ?>"
           class="btn btn-light">
            Limpiar
        </a>

    </form>

    <!-- Productos -->
    <?php if (!empty($productos)): ?>

        <div class="productos-grid">

            <?php foreach ($productos as $producto): ?>

                <article class="producto-card">

                    <div class="producto-imagen">
                        <i class="bi bi-box-seam"></i>
                    </div>

                    <div class="producto-contenido">

                        <span class="producto-categoria">
                            <?= html_escape($producto->categoria); ?>
                        </span>

                        <h3>
                            <?= html_escape($producto->nombre_producto); ?>
                        </h3>

                        <p class="producto-modelo">
                            <?= !empty($producto->modelo_detalle)
                                ? html_escape($producto->modelo_detalle)
                                : 'Sin descripción disponible'; ?>
                        </p>

                        <div class="producto-precio">
                            $<?= number_format($producto->precio, 0, ',', '.'); ?>
                        </div>

                        <div class="producto-disponibilidad">

                            <?php if ($producto->cantidad > 0): ?>

                                <span class="disponible">
                                    <i class="bi bi-check-circle-fill"></i>
                                    Disponible
                                </span>

                            <?php else: ?>

                                <span class="agotado">
                                    <i class="bi bi-x-circle-fill"></i>
                                    Agotado
                                </span>

                            <?php endif; ?>

                        </div>

                        <div class="producto-botones">

                            <a
                                href="<?= base_url('cliente/productos/detalle/' . $producto->id_producto); ?>"
                                class="btn btn-outline-primary w-100"
                            >
                                <i class="bi bi-eye"></i>
                                Ver producto
                            </a>

                            <?php if ($producto->cantidad > 0): ?>

                                <!-- Añadir al carrito -->
                                <form
                                    method="POST"
                                    action="<?= base_url('cliente/carrito/agregar'); ?>"
                                    class="form-agregar-carrito"
                                >

                                    <input
                                        type="hidden"
                                        name="id_producto"
                                        value="<?= $producto->id_producto; ?>"
                                    >

                                    <input
                                        type="hidden"
                                        name="cantidad"
                                        value="1"
                                    >

                                    <input
                                        type="hidden"
                                        name="destino"
                                        value="carrito"
                                    >

                                    <?php if ($this->config->item('csrf_protection')): ?>
                                        <input
                                            type="hidden"
                                            name="<?= $this->security->get_csrf_token_name(); ?>"
                                            value="<?= $this->security->get_csrf_hash(); ?>"
                                        >
                                    <?php endif; ?>

                                    <button type="submit"
                                            class="btn btn-primary w-100">
                                        <i class="bi bi-cart-plus"></i>
                                        Añadir al carrito
                                    </button>

                                </form>

                                <!-- Comprar ahora -->
                                <form
                                    method="POST"
                                    action="<?= base_url('cliente/carrito/agregar'); ?>"
                                    class="form-agregar-carrito"
                                >

                                    <input
                                        type="hidden"
                                        name="id_producto"
                                        value="<?= $producto->id_producto; ?>"
                                    >

                                    <input
                                        type="hidden"
                                        name="cantidad"
                                        value="1"
                                    >

                                    <input
                                        type="hidden"
                                        name="destino"
                                        value="comprar"
                                    >

                                    <?php if ($this->config->item('csrf_protection')): ?>
                                        <input
                                            type="hidden"
                                            name="<?= $this->security->get_csrf_token_name(); ?>"
                                            value="<?= $this->security->get_csrf_hash(); ?>"
                                        >
                                    <?php endif; ?>

                                    <button type="submit"
                                            class="btn btn-success w-100">
                                        <i class="bi bi-bag-check"></i>
                                        Comprar ahora
                                    </button>

                                </form>

                            <?php else: ?>

                                <button type="button"
                                        class="btn btn-secondary w-100"
                                        disabled>
                                    <i class="bi bi-cart-x"></i>
                                    Producto agotado
                                </button>

                            <?php endif; ?>

                        </div>

                    </div>

                </article>

            <?php endforeach; ?>

        </div>

    <?php else: ?>

        <div class="catalogo-vacio">

            <i class="bi bi-search"></i>

            <h4>No encontramos productos</h4>

            <p>
                Intenta cambiar la búsqueda o seleccionar otra categoría.
            </p>

        </div>

    <?php endif; ?>

</div>
