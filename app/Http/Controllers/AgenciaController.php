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
        $booleanFields = [
            'estado', 'filtro_imagen_1', 'filtro_imagen_2', 'publicidad_existe'
        ];

        foreach ($booleanFields as $field) {
            if ($request->has($field)) {
                $request->merge([$field => filter_var($request->input($field), FILTER_VALIDATE_BOOLEAN)]);
            }
        }

        DB::beginTransaction(); // Inicia la transacción
        $data = $request->validate([
            "estado" => "required|boolean",
            "nombre" => "required|string|max:255",
            "password" => "required|string|min:8",
            "dominio" => "required|string|unique:tenants,dominio|max:255",
            "quienes_somos_es" => "nullable|string",
            "quienes_somos_en" => "nullable|string",
            "quienes_somos_pt" => "nullable|string",
            "color_primario" => "required|string|regex:/^#[A-Fa-f0-9]{6}$/",
            "color_barra_superior" => "required|string|regex:/^#[A-Fa-f0-9]{6}$/",
            "filtro_imagen_1" => "required|boolean",
            "filtro_imagen_2" => "required|boolean",
            "tipografia_agencia" => "nullable|string",
            "color_principal" => "required|string|regex:/^#[A-Fa-f0-9]{6}$/",
            "color_tipografia_agencia" => "required|string|regex:/^#[A-Fa-f0-9]{6}$/",
            "color_fondo_app" => "required|string|regex:/^#[A-Fa-f0-9]{6}$/",
            "color_primario" => "required|string|regex:/^#[A-Fa-f0-9]{6}$/",
            "color_secundario" => "required|string|regex:/^#[A-Fa-f0-9]{6}$/",
            "color_terciario" => "required|string|regex:/^#[A-Fa-f0-9]{6}$/",
            "header_imagen_background_opacidad" => "required|numeric|between:0,1",
            "header_video_background_opacidad" => "required|numeric|between:0,1",
            "buscador_tipografia" => "nullable|string",
            "buscador_tipografia_color" => "required|string|regex:/^#[A-Fa-f0-9]{6}$/",
            "buscador_tipografia_color_label" => "required|string|regex:/^#[A-Fa-f0-9]{6}$/",
            "buscador_color_primario" => "required|string|regex:/^#[A-Fa-f0-9]{6}$/",
            "buscador_color_secundario" => "required|string|regex:/^#[A-Fa-f0-9]{6}$/",
            "buscador_color_terciario" => "required|string|regex:/^#[A-Fa-f0-9]{6}$/",
            "publicidad_existe" => "required|boolean",
            "publicidad_titulo" => "nullable|string",
            "publicidad_tipografia_color" => "required|string|regex:/^#[A-Fa-f0-9]{6}$/",
            "publicidad_color_primario" => "required|string|regex:/^#[A-Fa-f0-9]{6}$/",
            "publicidad_color_secundario" => "required|string|regex:/^#[A-Fa-f0-9]{6}$/",
            "publicidad_color_terciario" => "required|string|regex:/^#[A-Fa-f0-9]{6}$/",
            "tarjetas_titulo" => "nullable|string",
            "tarjetas_tipografia" => "nullable|string",
            "tarjetas_tipografia_color" => "required|string|regex:/^#[A-Fa-f0-9]{6}$/",
            "tarjetas_tipografia_color_titulo" => "required|string|regex:/^#[A-Fa-f0-9]{6}$/",
            "tarjetas_tipografia_color_contenido" => "required|string|regex:/^#[A-Fa-f0-9]{6}$/",
            "tarjetas_color_primario" => "required|string|regex:/^#[A-Fa-f0-9]{6}$/",
            "tarjetas_color_secundario" => "required|string|regex:/^#[A-Fa-f0-9]{6}$/",
            "tarjetas_color_terciario" => "required|string|regex:/^#[A-Fa-f0-9]{6}$/",
            "banner_registro_titulo" => "nullable|string",
            "banner_registro_tipografia_color" => "required|string|regex:/^#[A-Fa-f0-9]{6}$/",
            "banner_registro_color_primario" => "required|string|regex:/^#[A-Fa-f0-9]{6}$/",
            "banner_registro_color_secundario" => "required|string|regex:/^#[A-Fa-f0-9]{6}$/",
            "banner_registro_color_terciario" => "required|string|regex:/^#[A-Fa-f0-9]{6}$/",
            "footer_texto" => "nullable|string",
            "footer_tipografia" => "nullable|string",
            "footer_tipografia_color" => "required|string|regex:/^#[A-Fa-f0-9]{6}$/",
            "footer_facebook" => "nullable|string",
            "footer_twitter" => "nullable|string",
            "footer_instagram" => "nullable|string",
            "footer_whatsapp" => "nullable|string",
            "footer_telefono" => "nullable|string",
            "footer_email" => "nullable|email",
            "footer_direccion" => "nullable|string",
            "footer_ciudad" => "nullable|string",
            "footer_pais" => "nullable|string",
        ]);


        // Crear el tenant
        $tenant = Tenant::create([
            'subdomain' => $request->dominio,
            'estado' => $request->estado,
        ]);


        // Asociar el tenant al request
        $data['tenant_id'] = $tenant->id;
        $nombreAgencia = $request->nombre;

        // Crear la subcarpeta con el nombre de la agencia si no existe
        $folderPath = 'agencias/' . $nombreAgencia;
        Storage::disk('public')->makeDirectory($folderPath);

        // Subir imágenes y videos si existen
        if ($request->hasFile('favicon')) {
            $data['favicon'] = $request->file('favicon')->store($folderPath, 'public');
        }

        if ($request->hasFile('logo')) {
            $data['logo'] = $request->file('logo')->store($folderPath, 'public');
        }

        if ($request->hasFile('fondo_1')) {
            $file = $request->file('fondo_1');
            $extension = $file->getClientOriginalExtension();

            // Determinar si es imagen o video y almacenarlo
            if (in_array($extension, ['jpeg', 'png', 'jpg', 'gif'])) {
                $data['fondo_1'] = $file->store($folderPath . '/imagenes', 'public');
            } elseif (in_array($extension, ['mp4', 'mov', 'avi'])) {
                $data['fondo_1'] = $file->store($folderPath . '/videos', 'public');
            }
        }

        if ($request->hasFile('fondo_2')) {
            $data['fondo_2'] = $request->file('fondo_2')->store($folderPath, 'public');
        }

        // Crear la agencia con los datos procesados
        $agencia = Agencia::create($data);

        DB::commit(); // Confirma la transacción
        return response()->json($agencia);
    } catch (\Exception $e) {
        return response()->json($e->getmessage());
        DB::rollBack(); // Revierte la transacción en caso de error
        return back()->with('error', 'Error al guardar la agencia y el tenant: ' . $e->getMessage());
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
            return response()->json(asset("storage/{$customPath}"));
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

    public function destroy(Agencia $agencia)
    {
        $agencia->delete();
        return response()->json(['message' => 'Agencia eliminada']);
    }
}
