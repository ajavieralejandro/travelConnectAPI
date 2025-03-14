<?php $__env->startSection('content'); ?>
<div class="flex items-center justify-center min-h-screen p-6 bg-gray-200">
    <div class="w-full max-w-4xl p-6 bg-white rounded-lg shadow-lg">
        <h2 class="mb-4 text-2xl font-semibold text-center text-gray-800">Buscar Paquetes de Viaje</h2>

        <form action="<?php echo e(route('paquetes.buscar')); ?>" method="GET">
            <div class="flex flex-wrap items-center justify-between gap-4 p-4 bg-gray-100 rounded-lg">

                
                <div class="flex flex-col">
                    <label for="ciudad_origen" class="text-sm font-medium text-gray-700">Origen</label>
                    <input type="text" name="ciudad_origen" id="ciudad_origen"
                           class="w-48 p-2 mt-1 border rounded-lg focus:ring focus:ring-blue-300"
                           placeholder="Ej: Buenos Aires">
                </div>

                
                <div class="flex flex-col">
                    <label for="ciudad_destino" class="text-sm font-medium text-gray-700">Destino</label>
                    <input type="text" name="destino" id="ciudad_destino"
                           class="w-48 p-2 mt-1 border rounded-lg focus:ring focus:ring-blue-300"
                           placeholder="Ej: Iguazú">
                </div>

                
                <div class="flex flex-col">
                    <label for="fecha_salida" class="text-sm font-medium text-gray-700">Fecha</label>
                    <input type="date" name="fecha_desde" id="fecha_salida"
                           class="w-48 p-2 mt-1 border rounded-lg focus:ring focus:ring-blue-300">
                </div>

                
                <div class="flex flex-col">
                    <label for="cantidad_pasajeros" class="text-sm font-medium text-gray-700">Pasajeros</label>
                    <input type="number" name="cantidad_pasajeros" id="cantidad_pasajeros" min="1" value="1"
                           class="w-32 p-2 mt-1 border rounded-lg focus:ring focus:ring-blue-300">
                </div>

                
                <button type="submit"
                        class="px-6 py-2 text-white transition bg-blue-600 rounded-lg hover:bg-blue-700">
                    Buscar
                </button>
            </div>
        </form>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\amoro\OneDrive\Escritorio\travelConnect\travelConnectAPI\resources\views/buscar_paquetes.blade.php ENDPATH**/ ?>