<?php $__env->startSection('content'); ?>
<div class="container px-4 py-8 mx-auto max-w-7xl sm:px-6 lg:px-8">
    <h1 class="mb-8 text-3xl font-bold text-center text-gray-900 md:text-4xl">Paquetes Disponibles</h1>

    <!-- Controles de Filtrado -->
    <div class="flex flex-col gap-4 mb-8 sm:flex-row sm:justify-center sm:gap-8">
        <div class="flex items-center gap-2">
            <label for="togglePaquetes" class="text-lg font-medium text-gray-700">Paquetes All Seasons</label>
            <label class="switch">
                <input type="checkbox" id="togglePaquetes" checked>
                <span class="slider round"></span>
            </label>
        </div>

        <div class="flex items-center gap-2">
            <label for="toggleJulia" class="text-lg font-medium text-gray-700">Paquetes Julia</label>
            <label class="switch">
                <input type="checkbox" id="toggleJulia" checked>
                <span class="slider round"></span>
            </label>
        </div>
    </div>

    <!-- Grid de Paquetes -->
    <div class="grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4">
        <!-- Paquetes Regulares -->
        <?php $__currentLoopData = $paquetes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $paquete): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <div class="flex flex-col overflow-hidden transition-shadow duration-300 bg-white shadow-lg paquete-regular rounded-xl hover:shadow-xl">
            <div class="relative aspect-video">
                <img
                    src="<?php echo e($paquete->imagen_principal ?? 'https://via.placeholder.com/400x300'); ?>"
                    alt="Imagen del paquete"
                    class="object-cover w-full h-full"
                    loading="lazy"
                >
            </div>

            <div class="flex-1 p-6">
                <div class="mb-4">
                    <h2 class="text-xl font-bold text-gray-900 truncate"><?php echo e($paquete->nombre); ?></h2>
                    <p class="mt-1 text-sm text-gray-500">
                        <span class="font-medium"><?php echo e($paquete->ciudad); ?></span> - <?php echo e($paquete->pais); ?>

                    </p>
                </div>

                <div class="space-y-2">
                    <div class="flex items-center text-sm text-gray-500">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                        </svg>
                        <?php echo e($paquete->fecha_vigencia_desde->format('d M')); ?> - <?php echo e($paquete->fecha_vigencia_hasta->format('d M Y')); ?>

                    </div>

                    <div class="flex items-center text-sm text-gray-500">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                        </svg>
                        <?php echo e($paquete->tipo_producto); ?> • <?php echo e($paquete->transporte); ?>

                    </div>
                </div>

                <div class="flex items-center justify-between mt-6">
                    <div>
                        <span class="text-2xl font-bold text-gray-900">
                            <?php echo e($paquete->tipo_moneda); ?> <?php echo e(number_format($paquete->precio, 2)); ?>

                        </span>
                        <?php if($paquete->descuento > 0): ?>
                            <span class="ml-2 text-sm text-gray-400 line-through">
                                <?php echo e($paquete->tipo_moneda); ?> <?php echo e(number_format($paquete->precio_original, 2)); ?>

                            </span>
                        <?php endif; ?>
                    </div>

                    <span class="px-3 py-1 text-sm font-semibold rounded-full <?php echo e($paquete->activo ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800'); ?>">
                        <?php echo e($paquete->activo ? 'Disponible' : 'Agotado'); ?>

                    </span>
                </div>

                <div class="mt-4">
                    <a href="#"
                       class="block w-full px-4 py-2 text-center text-white transition-colors duration-200 bg-indigo-600 rounded-lg hover:bg-indigo-700">
                        Ver detalles
                    </a>
                </div>
            </div>
        </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

        <!-- Paquetes Julia -->
        <?php $__currentLoopData = $tarjetasJulia; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $paquete): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <div class="transition-shadow duration-300 bg-white shadow-lg paquete-julia rounded-xl hover:shadow-xl">
            <div class="relative h-48 overflow-hidden rounded-t-xl">
                <img
                    src="<?php echo e($paquete->imagen_principal ?? 'https://images.unsplash.com/photo-1544551763-46a013bb70d5?ixlib=rb-1.2.1&auto=format&fit=crop&w=800&q=80'); ?>"
                    alt="<?php echo e($paquete->nombre); ?>"
                    class="object-cover w-full h-full"
                    loading="lazy"
                >
                <?php if($paquete->descuento > 0): ?>
                <div class="absolute px-3 py-1 text-sm font-bold text-white bg-red-500 rounded-full top-2 right-2">
                    -<?php echo e($paquete->descuento); ?>%
                </div>
                <?php endif; ?>
            </div>

            <div class="p-6">
                <div class="mb-4">
                    <h2 class="text-xl font-bold text-gray-800 truncate"><?php echo e($paquete->nombre); ?></h2>
                    <div class="flex items-center mt-2 text-sm text-gray-500">
                        <svg class="w-5 h-5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                        </svg>
                        <?php echo e($paquete->ciudad); ?> (<?php echo e($paquete->ciudad_iata); ?>), <?php echo e($paquete->pais); ?>

                    </div>
                </div>

                <div class="mb-4 space-y-2">
                    <div class="flex items-center text-sm text-gray-600">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                        </svg>
                        <?php echo e($paquete->fecha_vigencia_desde->format('d M')); ?> - <?php echo e($paquete->fecha_vigencia_hasta->format('d M Y')); ?>

                    </div>

                    <div class="flex items-center text-sm text-gray-600">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        <?php echo e($paquete->cant_noches); ?> noches
                    </div>
                </div>

                <div class="flex flex-wrap gap-2 mb-4">
                    <?php $__currentLoopData = $paquete->componentes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $componente): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <span class="px-2 py-1 text-xs text-blue-800 bg-blue-100 rounded-full">
                        <?php echo e($componente); ?>

                    </span>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                    <?php $__currentLoopData = $paquete->categorias; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $categoria): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <span class="px-2 py-1 text-xs text-purple-800 bg-purple-100 rounded-full">
                        <?php echo e($categoria); ?>

                    </span>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>

                <div class="flex items-center justify-between">
                    <div>
                        <span class="text-sm font-semibold text-gray-600"><?php echo e($paquete->tipo_producto); ?></span>
                        <p class="text-sm text-gray-500"><?php echo e($paquete->transporte); ?></p>
                    </div>

                    <span class="px-3 py-1 text-sm font-semibold rounded-full <?php echo e($paquete->activo ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800'); ?>">
                        <?php echo e($paquete->activo ? 'Activo' : 'Inactivo'); ?>

                    </span>
                </div>

                <div class="mt-4">
                    <a href="#"
                       class="block w-full px-4 py-2 text-center text-white transition-colors duration-200 bg-indigo-600 rounded-lg hover:bg-indigo-700">
                        Ver detalles
                    </a>
                </div>
            </div>
        </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </div>
</div>

<style>
    .switch {
        position: relative;
        display: inline-block;
        width: 60px;
        height: 34px;
    }
    .switch input {
        opacity: 0;
        width: 0;
        height: 0;
    }
    .slider {
        position: absolute;
        cursor: pointer;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background-color: #ccc;
        transition: .4s;
        border-radius: 34px;
    }
    .slider:before {
        position: absolute;
        content: "";
        height: 26px;
        width: 26px;
        left: 4px;
        bottom: 4px;
        background-color: white;
        transition: .4s;
        border-radius: 50%;
    }
    input:checked + .slider {
        background-color: #3B82F6;
    }
    input:checked + .slider:before {
        transform: translateX(26px);
    }
    .hidden {
        display: none !important;
    }
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const togglePaquetes = document.getElementById('togglePaquetes');
    const toggleJulia = document.getElementById('toggleJulia');

    const paquetesRegulares = document.querySelectorAll('.paquete-regular');
    const paquetesJulia = document.querySelectorAll('.paquete-julia');

    function toggleVisibility(checkbox, elements) {
        checkbox.addEventListener('change', () => {
            elements.forEach(element => {
                element.style.display = checkbox.checked ? 'block' : 'none';
            });
        });
    }

    toggleVisibility(togglePaquetes, paquetesRegulares);
    toggleVisibility(toggleJulia, paquetesJulia);
});
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\amoro\OneDrive\Escritorio\travelConnect\travelConnectAPI\resources\views/paquetes/index.blade.php ENDPATH**/ ?>