<?php $__env->startSection('content'); ?>
<h1>Listado de Ventas</h1>
<a href="<?php echo e(route('ventas.create')); ?>">Crear nueva venta</a>

<table border="1">
    <thead>
        <tr>
            <th>ID Venta</th>
            <th>ID Pedido</th>
            <th>Cliente</th>
            <th>Total</th>
            <th>Acciones</th>
        </tr>
    </thead>
    <tbody>
        <?php $__currentLoopData = $ventas; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $venta): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <tr>
            <td><?php echo e($venta->idventa); ?></td>
            <td><?php echo e($venta->idpedidos); ?></td>
            <td><?php echo e($venta->nombreCliente); ?></td>
            <td><?php echo e($venta->total); ?></td>
            <td>
                <a href="<?php echo e(route('ventas.show', $venta->idventa)); ?>">Ver</a>
                <a href="<?php echo e(route('ventas.edit', $venta->idventa)); ?>">Editar</a>
                <form action="<?php echo e(route('ventas.destroy', $venta->idventa)); ?>" method="POST" style="display:inline;">
                    <?php echo csrf_field(); ?>
                    <?php echo method_field('DELETE'); ?>
                    <button type="submit">Eliminar</button>
                </form>
            </td>
        </tr>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </tbody>
</table>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\proyectos_php\sichera_2025\resources\views/ventas/index.blade.php ENDPATH**/ ?>