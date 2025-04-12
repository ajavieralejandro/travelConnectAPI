<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use App\Models\Agencia;
use App\Models\Tenant;
use App\Models\User;
use Illuminate\Support\Facades\Validator;


class AgenciaController extends Controller
{
    public function index()
    {
        return response()->json(Agencia::all());
    }



    public function store(Request $request)
    {
        try {
            $booleanFields = ['estado', 'filtro_imagen_1', 'filtro_imagen_2', 'publicidad_existe'];
            foreach ($booleanFields as $field) {
                if ($request->has($field)) {
                    $request->merge([$field => filter_var($request->input($field), FILTER_VALIDATE_BOOLEAN)]);
                }
            }

            $data = $request->validate([
                'nombre' => 'required|string|max:255',
                'estado' => 'required',
                'password' => 'required|string|min:6',
                'dominio' => 'required|string|max:255|unique:agencias,dominio',
                'logo' => 'nullable|image|mimes:jpeg,png|max:2048',
                'favicon' => 'nullable|image|mimes:jpeg,png|max:2048',
                'fondo_1' => 'nullable|image|mimes:jpeg,png|max:2048',
                'fondo_2' => 'nullable|image|mimes:jpeg,png|max:2048',
                'header_imagen_background' => 'nullable|file|mimes:jpeg,png|max:10240',
                'header_video_background' => 'nullable|file|mimes:mp4,mov,avi|max:51200',
                'publicidad_imagen_1' => 'nullable|image|mimes:jpeg,png|max:10240',
                'publicidad_imagen_2' => 'nullable|image|mimes:jpeg,png|max:10240',
                'publicidad_imagen_3' => 'nullable|image|mimes:jpeg,png|max:10240',
                'buscador_inputColor' => 'nullable|string|regex:/^#[A-Fa-f0-9]{6}$/',
                'buscador_inputFondoColor' => 'nullable|string|regex:/^#[A-Fa-f0-9]{6}$/',
                'footer_color_primario' => 'nullable|string|regex:/^#[A-Fa-f0-9]{6}$/',
                'footer_color_secundario' => 'nullable|string|regex:/^#[A-Fa-f0-9]{6}$/',
                'footer_color_terciario' => 'nullable|string|regex:/^#[A-Fa-f0-9]{6}$/',
            ]);
  // Crear Tenant
  $tenant = Tenant::create([
    'subdomain' => $request->dominio,
    'estado' => $request->estado,
]);
$data['tenant_id'] = $tenant->id;
            $agencia = new Agencia();
            $agencia->tenant_id = $tenant->id;
            $agencia->nombre = $request->nombre;
            $agencia->estado = $request->estado;
            $agencia->password = bcrypt($request->password);
            $agencia->dominio = $request->dominio;

            $folderPath = "agencias/{$request->dominio}";

            if ($request->hasFile('logo')) {
                $agencia->logo = $request->file('logo')->store($folderPath, 'public');
            }

            if ($request->hasFile('favicon')) {
                $agencia->favicon = $request->file('favicon')->store($folderPath, 'public');
            }

            if ($request->hasFile('fondo_1')) {
                $agencia->fondo_1 = $request->file('fondo_1')->store($folderPath . '/fondos', 'public');
            }

            if ($request->hasFile('fondo_2')) {
                $agencia->fondo_2 = $request->file('fondo_2')->store($folderPath . '/fondos', 'public');
            }

            if ($request->hasFile('header_imagen_background')) {
                $agencia->header_imagen_background = $request->file('header_imagen_background')->store($folderPath . '/header', 'public');
            }

            if ($request->hasFile('header_video_background')) {
                $agencia->header_video_background = $request->file('header_video_background')->store($folderPath . '/header', 'public');
            }

            foreach ([1, 2, 3] as $n) {
                $campo = "publicidad_imagen_$n";
                if ($request->hasFile($campo)) {
                    $agencia->$campo = $request->file($campo)->store($folderPath . '/publicidad', 'public');
                }
            }

            $campos = [
                'quienes_somos_es', 'quienes_somos_en', 'quienes_somos_pt',
                'tipografia_agencia', 'color_tipografia_agencia', 'color_fondo_app',
                'color_principal', 'color_secundario', 'color_terciario',
                'header_imagen_background_opacidad', 'header_video_background_opacidad',
                'buscador_tipografia', 'buscador_tipografia_color', 'buscador_tipografia_color_label',
                'buscador_color_primario', 'buscador_color_secundario', 'buscador_color_terciario',
                'buscador_inputColor', 'buscador_inputFondoColor',
                'publicidad_existe', 'publicidad_titulo', 'publicidad_tipografia_color',
                'publicidad_color_primario', 'publicidad_color_secundario', 'publicidad_color_terciario',
                'tarjetas_titulo', 'tarjetas_tipografia', 'tarjetas_tipografia_color',
                'tarjetas_tipografia_color_titulo', 'tarjetas_tipografia_color_contenido',
                'tarjetas_color_primario', 'tarjetas_color_secundario', 'tarjetas_color_terciario',
                'banner_registro_titulo', 'banner_registro_tipografia_color',
                'banner_registro_color_primario', 'banner_registro_color_secundario', 'banner_registro_color_terciario',
                'footer_texto', 'footer_tipografia', 'footer_tipografia_color',
                'footer_facebook', 'footer_twitter', 'footer_instagram', 'footer_whatsapp',
                'footer_telefono', 'footer_email', 'footer_direccion', 'footer_ciudad', 'footer_pais',
                'footer_color_primario', 'footer_color_secundario', 'footer_color_terciario'
            ];

            foreach ($campos as $campo) {
                if ($request->has($campo)) {
                    $agencia->$campo = $request->$campo;
                }
            }

            $agencia->save();

            return response()->json([
                'message' => 'Agencia creada con éxito',
                'agencia' => $agencia
            ], 201);

        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Error al crear la agencia',
                'error' => $e->getMessage(),
                'linea' => $e->getLine(),
                'archivo' => $e->getFile(),
            ], 500);
        }
    }

public function guardarVideo(Request $request)
{
    // Validar que se haya enviado un archivo
    if (!$request->hasFile('fondo_1')) {
        Log::error('No se recibió fondo_1 en la petición');
        return response()->json([
            'success' => false,
            'message' => 'No se encontró el archivo fondo_1 en la petición'
        ], 400);
    }

    // Obtener el nombre de la agencia (asegurar que venga en la solicitud)
    $nombreAgencia = $request->input('nombre_agencia');
    if (!$nombreAgencia) {
        return response()->json([
            'success' => false,
            'message' => 'El nombre de la agencia es requerido'
        ], 400);
    }

    // Crear la carpeta de la agencia si no existe
    $folderPath = 'agencias/' . $nombreAgencia;
    Storage::disk('public')->makeDirectory($folderPath);

    try {
        $file = $request->file('fondo_1');
        $extension = strtolower($file->getClientOriginalExtension());
        Log::info('Extensión detectada: ' . $extension);

        if (in_array($extension, ['mp4', 'mov', 'avi'])) {
            $path = $file->store($folderPath . '/videos', 'public');
            return response()->json([
                'success' => true,
                'message' => 'Video subido correctamente',
                'path' => $path
            ]);
        } else {
            Log::error('Extensión no permitida: ' . $extension);
            return response()->json([
                'success' => false,
                'message' => 'Tipo de archivo no permitido',
                'extension' => $extension
            ], 400);
        }
    } catch (\Exception $e) {
        Log::error('Error al subir fondo_1: ' . $e->getMessage());
        return response()->json([
            'success' => false,
            'message' => 'Error al subir el archivo',
            'error' => $e->getMessage()
        ], 500);
    }
}

    public function getaAgencia(Request $request){

        $agencia = Agencia::where('nombre','=',)->first();
        if(!$agencia){
            $agencia = Agencia::all()->first();
            if (!empty($agencia['fondo_1'])) {
                // Construir la ruta relativa en storage
                $customPath = "agencias/{$agencia['dominio']}/imagenes/{$agencia['fondo_1']}";
                // Generar la URL accesible públicamente
                $agencia['fondo_1'] = asset("storage/{$customPath}");
            }



            return response()->json($agencia);
        }

    }


    public function getAgencia(Request $request){
        $host = $request->getHost(); // Obtiene el host completo (subdominio.dominio.com)
        $subdominio = explode('.', $host)[0];
        $agencia = Agencia::where('dominio','=',$subdominio)->first();
        if($agencia){
            if (!empty($agencia['fondo_1'])) {
                // Construir la ruta relativa en storage
                $customPath = "agencias/{$agencia['dominio']}/imagenes/{$agencia['fondo_1']}";
                // Generar la URL accesible públicamente
                $agencia['fondo_1'] = asset("storage/{$customPath}");
                if (!empty($agencia['fondo_1'])) {
                    // Construir la ruta relativa en storage
                    $customPath = "agencias/{$agencia['dominio']}/imagenes/{$agencia['fondo_1']}";
                    // Generar la URL accesible públicamente
                    $agencia['fondo_1'] = asset("storage/{$customPath}");
                }

            }
            if (!empty($agencia->logo)) {
                // Construir la ruta relativa en storage
                // Generar la URL accesible públicamente
                $agencia['logo'] = asset("storage/{$agencia['logo']}");
            }
            if (!empty($agencia->header_video_background)) {
                // Construir la ruta relativa en storage
                // Generar la URL accesible públicamente
                $agencia['header_video_background'] = asset("storage/{$agencia['header_video_background']}");
            }
            $response = [
                'idAgencia' => (string) $agencia->id,
                'nombreAgencia' => $agencia->nombre,
                'logoAgencia' => $agencia->logo,
                'tipografiaAgencia' => $agencia->tipografia_agencia,
                'colorTipografiaAgencia' => $agencia->color_tipografia_agencia,
                'colorFondoApp' => $agencia->color_fondo_app,
                'color' => [
                    'primario' => $agencia->color_primario,
                    'secundario' => $agencia->color_secundario,
                    'terciario' => $agencia->color_terciario,
                ],

                'header' => [
                    'imagenBackground' => $agencia->header_imagen_background,
                    'imagenBackgroundOpacidad' => (float) $agencia->header_imagen_background_opacidad,
                    'videoBackground' => $agencia->header_video_background,
                    'videoBackgroundOpacidad' => $agencia->header_video_background_opacidad,
                ],

                'buscador' => [
                    'tipografia' => $agencia->buscador_tipografia,
                    'tipografiaColor' => $agencia->buscador_tipografia_color,
                    'tipografiaColorLabel' => $agencia->buscador_tipografia_color_label,
                    'inputColor' => null, // No está en la base de datos, debes agregarlo si lo necesitas
                    'inputFondoColor' => null, // No está en la base de datos
                    'color' => [
                        'primario' => $agencia->buscador_color_primario,
                        'secundario' => $agencia->buscador_color_secundario,
                        'terciario' => $agencia->buscador_color_terciario,
                    ],
                ],

                'publicidadCliente' => [
                    'existe' => (bool) $agencia->publicidad_existe,
                    'titulo' => $agencia->publicidad_titulo,
                    'tipografiaColor' => $agencia->publicidad_tipografia_color,
                    'color' => [
                        'primario' => $agencia->publicidad_color_primario,
                        'secundario' => $agencia->publicidad_color_secundario,
                        'terciario' => $agencia->publicidad_color_terciario,
                    ],
                    'imagenes' => [
                        $agencia->publicidad_imagen_1,
                        $agencia->publicidad_imagen_2,
                        $agencia->publicidad_imagen_3,
                    ],
                ],

                'tarjetas' => [
                    'titulo' => $agencia->tarjetas_titulo,
                    'tipografia' => $agencia->tarjetas_tipografia,
                    'tipografiaColor' => $agencia->tarjetas_tipografia_color,
                    'tipografiaColorTitulo' => $agencia->tarjetas_tipografia_color_titulo,
                    'tipografiaColorContenido' => $agencia->tarjetas_tipografia_color_contenido,
                    'color' => [
                        'primario' => $agencia->tarjetas_color_primario,
                        'secundario' => $agencia->tarjetas_color_secundario,
                        'terciario' => $agencia->tarjetas_color_terciario,
                    ],
                ],

                'bannerRegistro' => [
                    'titulo' => $agencia->banner_registro_titulo,
                    'tipografiaColor' => $agencia->banner_registro_tipografia_color,
                    'color' => [
                        'primario' => $agencia->banner_registro_color_primario,
                        'secundario' => $agencia->banner_registro_color_secundario,
                        'terciario' => $agencia->banner_registro_color_terciario,
                    ],
                ],

                'footer' => [
                    'texto' => $agencia->footer_texto,
                    'tipografia' => $agencia->footer_tipografia,
                    'tipografiaColor' => $agencia->footer_tipografia_color,
                    'color' => [
                        'primario' => $agencia->footer_color_primario,
                        'secundario' => $agencia->footer_color_secundario,
                        'terciario' => $agencia->footer_color_terciario,
                    ],
                    'redes' => [
                        'facebook' => $agencia->footer_facebook,
                        'twitter' => $agencia->footer_twitter,
                        'instagram' => $agencia->footer_instagram,
                        'whatsapp' => $agencia->footer_whatsapp,
                    ],
                    'contacto' => [
                        'telefono' => $agencia->footer_telefono,
                        'email' => $agencia->footer_email,
                    ],
                    'ubicacion' => [
                        'direccion' => $agencia->footer_direccion,
                        'ciudad' => $agencia->footer_ciudad,
                        'pais' => $agencia->footer_pais,
                    ],
                ],
            ];
            return response()->json($response);
        }

        if (!empty($agencia['fondo_1'])) {
            // Construir la ruta relativa en storage
            $customPath = "agencias/{$agencia['dominio']}/imagenes/{$agencia['fondo_1']}";
            // Generar la URL accesible públicamente
            $agencia['fondo_1'] = asset("storage/{$customPath}");
        }
        //if(isset($agencia['logo']))
        //$agencia['logo']= (request()->getSchemeAndHttpHost() . '/storage/' . ltrim($agencia->logo, '/'));
        return response()->json($agencia);
    }



    public function show(Agencia $agencia)
    {
        return response()->json($agencia);
    }

    public function update(Request $request, Agencia $agencia)
    {
        $agencia->update($request->all());
        return response()->json($agencia);
    }

    public function createAgencia(){
        return view('admin.create_agencia');
    }

    public function destroy($id)
    {
        try {
            DB::beginTransaction();

            // 1. Encontrar la agencia
            $agencia = Agencia::findOrFail($id);

            // 2. Encontrar y eliminar el tenant asociado
            $tenant = Tenant::where('subdomain','=',$agencia->domain)->first();

            if ($tenant) {
                // Eliminar base de datos del tenant (si aplica)
                //$tenant->database()->manager()->deleteDatabase($tenant);

                // Eliminar tenant
                $tenant->delete();
            }

            // 3. Eliminar la agencia
            $agencia->delete();

            DB::commit();

            return response()->json(['message' => 'Agencia y tenant eliminados correctamente']);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}
