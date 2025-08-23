<?php $__env->startSection('content'); ?>
<h2 class="mb-4">Lista de Empleados</h2>
<a href="<?php echo e(route('empleados.create')); ?>" class="btn btn-success mb-3">Registrar Nuevo Empleado</a>

<?php if(session('success')): ?>
    <div class="alert alert-success"><?php echo e(session('success')); ?></div>
<?php endif; ?>

<table class="table table-bordered table-striped">
    <thead class="table-dark">
        <tr>
            <th>DNI</th>
            <th>Nombre</th>
            <th>Apellido</th>
            <th>Cargo</th>
            <th>Acciones</th>
        </tr>
    </thead>
    <tbody>
        <?php $__empty_1 = true; $__currentLoopData = $empleados; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $empleado): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
        <tr>
            <td><?php echo e($empleado->dni); ?></td>
            <td><?php echo e($empleado->nombre); ?></td>
            <td><?php echo e($empleado->apellido); ?></td>
            <td><?php echo e($empleado->cargo); ?></td>
            <td>
                <a href="<?php echo e(route('empleados.show', $empleado)); ?>" class="btn btn-sm btn-info">Ver</a>
                <a href="<?php echo e(route('empleados.edit', $empleado)); ?>" class="btn btn-sm btn-warning">Editar</a>
                <form action="<?php echo e(route('empleados.destroy', $empleado)); ?>" method="POST" class="d-inline">
                    <?php echo csrf_field(); ?> <?php echo method_field('DELETE'); ?>
                    <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('¿Eliminar este empleado?')">Eliminar</button>
                </form>
            </td>
        </tr>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
        <tr>
            <td colspan="5">No hay empleados registrados.</td>
        </tr>
        <?php endif; ?>
    </tbody>
</table>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\proyectos_php\sichera_2025\resources\views/empleados/index.blade.php ENDPATH**/ ?>