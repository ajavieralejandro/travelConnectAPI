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
        DB::beginTransaction();

        try {
            // Parseo booleanos
            $booleanFields = ['estado', 'filtro_imagen_1', 'filtro_imagen_2', 'publicidad_existe'];
            foreach ($booleanFields as $field) {
                if ($request->has($field)) {
                    $request->merge([$field => filter_var($request->input($field), FILTER_VALIDATE_BOOLEAN)]);
                }
            }

            $data = $request->validate([
                // Requeridos
                "estado" => "required|boolean",
                "nombre" => "required|string|max:255",
                "password" => "required|string|min:8",
                "dominio" => "required|string|unique:tenants,subdomain|max:255",
                "logo" => "required|image|mimes:jpeg,png,svg|max:10240", // 10MB

                // Opcionales y colores
                "quienes_somos_es" => "nullable|string",
                "quienes_somos_en" => "nullable|string",
                "quienes_somos_pt" => "nullable|string",

                "color_primario" => "nullable|string|regex:/^#[A-Fa-f0-9]{6}$/",
                "color_barra_superior" => "nullable|string|regex:/^#[A-Fa-f0-9]{6}$/",
                "color_principal" => "nullable|string|regex:/^#[A-Fa-f0-9]{6}$/",
                "color_tipografia_agencia" => "nullable|string|regex:/^#[A-Fa-f0-9]{6}$/",
                "color_fondo_app" => "nullable|string|regex:/^#[A-Fa-f0-9]{6}$/",
                "color_secundario" => "nullable|string|regex:/^#[A-Fa-f0-9]{6}$/",
                "color_terciario" => "nullable|string|regex:/^#[A-Fa-f0-9]{6}$/",

                // Booleanos
                "filtro_imagen_1" => "boolean",
                "filtro_imagen_2" => "boolean",
                "publicidad_existe" => "boolean",

                // Header
                "header_imagen_background_opacidad" => "nullable|numeric|between:0,1",
                "header_video_background_opacidad" => "nullable|numeric|between:0,1",

                // Tipografía
                "tipografia_agencia" => "nullable|string",
                "buscador_tipografia" => "nullable|string",

                // Colores del buscador
                "buscador_tipografia_color" => "nullable|string|regex:/^#[A-Fa-f0-9]{6}$/",
                "buscador_tipografia_color_label" => "nullable|string|regex:/^#[A-Fa-f0-9]{6}$/",
                "buscador_color_primario" => "nullable|string|regex:/^#[A-Fa-f0-9]{6}$/",
                "buscador_color_secundario" => "nullable|string|regex:/^#[A-Fa-f0-9]{6}$/",
                "buscador_color_terciario" => "nullable|string|regex:/^#[A-Fa-f0-9]{6}$/",

                // Publicidad
                "publicidad_titulo" => "nullable|string",
                "publicidad_tipografia_color" => "nullable|string|regex:/^#[A-Fa-f0-9]{6}$/",
                "publicidad_color_primario" => "nullable|string|regex:/^#[A-Fa-f0-9]{6}$/",
                "publicidad_color_secundario" => "nullable|string|regex:/^#[A-Fa-f0-9]{6}$/",
                "publicidad_color_terciario" => "nullable|string|regex:/^#[A-Fa-f0-9]{6}$/",

                // Tarjetas
                "tarjetas_titulo" => "nullable|string",
                "tarjetas_tipografia" => "nullable|string",
                "tarjetas_tipografia_color" => "nullable|string|regex:/^#[A-Fa-f0-9]{6}$/",
                "tarjetas_tipografia_color_titulo" => "nullable|string|regex:/^#[A-Fa-f0-9]{6}$/",
                "tarjetas_tipografia_color_contenido" => "nullable|string|regex:/^#[A-Fa-f0-9]{6}$/",
                "tarjetas_color_primario" => "nullable|string|regex:/^#[A-Fa-f0-9]{6}$/",
                "tarjetas_color_secundario" => "nullable|string|regex:/^#[A-Fa-f0-9]{6}$/",
                "tarjetas_color_terciario" => "nullable|string|regex:/^#[A-Fa-f0-9]{6}$/",

                // Banner de registro
                "banner_registro_titulo" => "nullable|string",
                "banner_registro_tipografia_color" => "nullable|string|regex:/^#[A-Fa-f0-9]{6}$/",
                "banner_registro_color_primario" => "nullable|string|regex:/^#[A-Fa-f0-9]{6}$/",
                "banner_registro_color_secundario" => "nullable|string|regex:/^#[A-Fa-f0-9]{6}$/",
                "banner_registro_color_terciario" => "nullable|string|regex:/^#[A-Fa-f0-9]{6}$/",

                // Footer
                "footer_texto" => "nullable|string",
                "footer_tipografia" => "nullable|string",
                "footer_tipografia_color" => "nullable|string|regex:/^#[A-Fa-f0-9]{6}$/",
                "footer_facebook" => "nullable|string",
                "footer_twitter" => "nullable|string",
                "footer_instagram" => "nullable|string",
                "footer_whatsapp" => "nullable|string",
                "footer_telefono" => "nullable|string",
                "footer_email" => "nullable|email",
                "footer_direccion" => "nullable|string",
                "footer_ciudad" => "nullable|string",
                "footer_pais" => "nullable|string",

                // Archivos multimedia
                "fondo_1" => "nullable|mimes:jpeg,png,mp4,mov,avi|max:51200", // 50MB imagen o video
                "favicon" => "nullable|image|mimes:jpeg,png,svg|max:5120", // 5MB
                "fondo_2" => "nullable|mimes:jpeg,png,mp4,mov,avi|max:51200",
            ]);

            // Crear Tenant
            $tenant = Tenant::create([
                'subdomain' => $request->dominio,
                'estado' => $request->estado,
            ]);
            $data['tenant_id'] = $tenant->id;

            // Crear carpeta
            $folderPath = 'agencias/' . $request->nombre;
            Storage::disk('public')->makeDirectory($folderPath);

            // Subir archivos
            if ($request->hasFile('favicon')) {
                $data['favicon'] = $request->file('favicon')->store($folderPath, 'public');
            }
            if ($request->hasFile('logo')) {
                $data['logo'] = $request->file('logo')->store($folderPath, 'public');
            }
            if ($request->hasFile('fondo_1')) {
                $file = $request->file('fondo_1');
                $extension = strtolower($file->getClientOriginalExtension());

                if (in_array($extension, ['jpeg', 'png', 'jpg', 'gif'])) {
                    $data['fondo_1'] = $file->store($folderPath . '/imagenes', 'public');
                } elseif (in_array($extension, ['mp4', 'mov', 'avi'])) {
                    $data['fondo_1'] = $file->store($folderPath . '/videos', 'public');
                } else {
                    throw new \Exception("Tipo de archivo no permitido: $extension");
                }
            }

            // Crear agencia
            $agencia = Agencia::create($data);

            DB::commit();
            return response()->json($agencia);

        } catch (\Exception $e) {
            DB::rollBack();
            \Log::error('Error al crear agencia: ' . $e->getMessage());
            return response()->json(['error' => $e->getMessage()], 500);
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
        if(!$agencia){
            $agencia = Agencia::all()->first();
            if (!empty($agencia['fondo_1'])) {
                // Construir la ruta relativa en storage
                $customPath = "agencias/{$agencia['dominio']}/imagenes/{$agencia['fondo_1']}";
                // Generar la URL accesible públicamente
                $agencia['fondo_1'] = asset("storage/{$customPath}");
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
