<?php $__env->startSection('content'); ?>
<div class="container">
    <h2>Lista de Clientes</h2>
    <a href="<?php echo e(route('clientes.create')); ?>" class="btn btn-primary mb-3">Nuevo Cliente</a>

    <?php if(session('success')): ?>
        <div class="alert alert-success"><?php echo e(session('success')); ?></div>
    <?php endif; ?>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Nombre</th>
                <th>Apellido</th>
                <th>Correo</th>
                <th>Celular</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php $__currentLoopData = $clientes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $cliente): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <tr>
                <td><?php echo e($cliente->nombre); ?></td>
                <td><?php echo e($cliente->apellido); ?></td>
                <td><?php echo e($cliente->correo); ?></td>
                <td><?php echo e($cliente->celular); ?></td>
                <td>
                    <a href="<?php echo e(route('clientes.show', $cliente)); ?>" class="btn btn-info btn-sm">Ver</a>
                    <a href="<?php echo e(route('clientes.edit', $cliente)); ?>" class="btn btn-warning btn-sm">Editar</a>
                    <form action="<?php echo e(route('clientes.destroy', $cliente)); ?>" method="POST" style="display:inline;">
                        <?php echo csrf_field(); ?> <?php echo method_field('DELETE'); ?>
                        <button class="btn btn-danger btn-sm" onclick="return confirm('¿Eliminar cliente?')">Eliminar</button>
                    </form>
                </td>
            </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </tbody>
    </table>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\proyectos_php\sichera_2025\resources\views/clientes/index.blade.php ENDPATH**/ ?>