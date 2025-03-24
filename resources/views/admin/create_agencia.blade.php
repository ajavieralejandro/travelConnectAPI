@extends('layouts.admin')

@section('content')
<div class="w-full p-6 mx-auto mt-6 bg-white rounded-lg shadow-md">
    <h2 class="mb-4 text-2xl font-bold text-center">Crear Agencia</h2>

    <div x-data="{ step: 1 }">
        <!-- Progreso -->
        <div class="flex justify-between mb-4">
            <template x-for="i in 5">
                <div :class="step >= i ? 'bg-blue-600' : 'bg-gray-300'" class="w-1/5 h-1 rounded"></div>
            </template>
        </div>

        <form action="{{ route('agencias.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <!-- Paso 1: Información básica -->
            <div x-show="step === 1">
                <label class="block font-semibold">Nombre:</label>
                <input type="text" name="name" class="w-full p-2 mb-3 border-gray-300 rounded" required>

                <label class="block font-semibold">Dominio:</label>
                <input type="text" name="subdomain" class="w-full p-2 mb-3 border-gray-300 rounded" required>

                <label class="block font-semibold">Estado:</label>
                <select name="estado" class="w-full p-2 mb-3 border-gray-300 rounded">
                    <option value="1">Activo</option>
                    <option value="0">Inactivo</option>
                </select>

                <label class="block font-semibold">Contraseña:</label>
                <input type="password" name="password" class="w-full p-2 mb-3 border-gray-300 rounded" required>
            </div>

            <!-- Paso 2: Información de la Agencia -->
            <div x-show="step === 2">
                <label class="block font-semibold">¿Quiénes somos? (ES):</label>
                <textarea  name="content" class="w-full p-2 mb-3 border-gray-300 rounded"></textarea>

                <label class="block font-semibold">¿Quiénes somos? (EN):</label>
                <textarea name="content2" class="w-full p-2 mb-3 border-gray-300 rounded"></textarea>

                <label class="block font-semibold">¿Quiénes somos? (PT):</label>
                <textarea name="content" class="w-full p-2 mb-3 border-gray-300 rounded"></textarea>
            </div>

            <!-- Paso 3: Diseño y Colores -->
            <div x-show="step === 3">
                <label class="block font-semibold">Color Principal:</label>
                <input type="color" name="color_principal" class="w-full p-2 mb-3 border-gray-300 rounded">

                <label class="block font-semibold">Color Secundario:</label>
                <input type="color" name="color_secundario" class="w-full p-2 mb-3 border-gray-300 rounded">

                <label class="block font-semibold">Color Barra Superior:</label>
                <input type="color" name="color_barra_superior" class="w-full p-2 mb-3 border-gray-300 rounded">

                <label class="block font-semibold">Filtro Imagen 1:</label>
                <select name="filtro_imagen_1" class="w-full p-2 mb-3 border-gray-300 rounded">
                    <option value="1">Sí</option>
                    <option value="0">No</option>
                </select>

                <label class="block font-semibold">Filtro Imagen 2:</label>
                <select name="filtro_imagen_2" class="w-full p-2 mb-3 border-gray-300 rounded">
                    <option value="1">Sí</option>
                    <option value="0">No</option>
                </select>
            </div>

            <!-- Paso 4: Contacto -->
            <div x-show="step === 4">
                <label class="block font-semibold">Nombre de Contacto:</label>
                <input type="text" name="nombre_de_contacto" class="w-full p-2 mb-3 border-gray-300 rounded" required>

                <label class="block font-semibold">Dirección:</label>
                <input type="text" name="direccion" class="w-full p-2 mb-3 border-gray-300 rounded" required>

                <label class="block font-semibold">WhatsApp:</label>
                <input type="text" name="whatsapp" class="w-full p-2 mb-3 border-gray-300 rounded">

                <label class="block font-semibold">Email:</label>
                <input type="email" name="email" class="w-full p-2 mb-3 border-gray-300 rounded" required>

                <label class="block font-semibold">Teléfono:</label>
                <input type="text" name="telefono" class="w-full p-2 mb-3 border-gray-300 rounded">
            </div>

            <!-- Paso 5: Redes Sociales e Imágenes -->
            <div x-show="step === 5">
                <label class="block font-semibold">Facebook:</label>
                <input type="text" name="facebook" class="w-full p-2 mb-3 border-gray-300 rounded">

                <label class="block font-semibold">Instagram:</label>
                <input type="text" name="instagram" class="w-full p-2 mb-3 border-gray-300 rounded">

                <label class="block font-semibold">Twitter:</label>
                <input type="text" name="twitter" class="w-full p-2 mb-3 border-gray-300 rounded">

                <label class="block font-semibold">YouTube:</label>
                <input type="text" name="youtube" class="w-full p-2 mb-3 border-gray-300 rounded">

                <label class="block font-semibold">LinkedIn:</label>
                <input type="text" name="linkedin" class="w-full p-2 mb-3 border-gray-300 rounded">

                <label class="block font-semibold">Favicon:</label>
                <input type="file" name="favicon" class="w-full p-2 mb-3 border-gray-300 rounded">

                <label class="block font-semibold">Logo:</label>
                <input type="file" name="logo" class="w-full p-2 mb-3 border-gray-300 rounded">

                <label class="block font-semibold">Fondo 1:</label>
                <input type="file" name="fondo_1" class="w-full p-2 mb-3 border-gray-300 rounded">

                <label class="block font-semibold">Fondo 2:</label>
                <input type="file" name="fondo_2" class="w-full p-2 mb-3 border-gray-300 rounded">
            </div>

            <!-- Botones -->
            <div class="flex justify-between mt-4">
                <button type="button" x-show="step > 1" @click="step--"
                    class="px-4 py-2 text-white bg-gray-400 rounded">Atrás</button>

                <button type="button" x-show="step < 5" @click="step++"
                    class="px-4 py-2 text-white bg-blue-600 rounded">Siguiente</button>

                <button type="submit" x-show="step === 5"
                    class="px-4 py-2 text-white bg-green-600 rounded">Guardar</button>
            </div>
        </form>
    </div>
</div>

<script src="https://cdn.ckeditor.com/4.16.0/standard/ckeditor.js"></script>

<script>
    CKEDITOR.replace( 'content' );
    CKEDITOR.replace( 'content2' );

</script>
@endsection
