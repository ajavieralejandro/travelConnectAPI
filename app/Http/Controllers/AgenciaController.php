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
        DB::beginTransaction(); // Inicia la transacción

        $data = json_decode($request->data, true); // Decodificar JSON
        return response()->json($request);
    // Validar que 'data' exista y que los archivos sean correctos
    $request->validate([
        'data' => 'required', // JSON debe existir
        'logo' => 'nullable|file|mimes:jpg,png,jpeg,svg|max:2048', // Logo de la empresa
        'banner' => 'nullable|file|mimes:jpg,png,jpeg|max:4096', // Imagen del banner
    ]);

    // Validar los datos dentro del JSON
    $validator = Validator::make($data, [
        'estado' => 'required|boolean',
        'nombre' => 'required|string|max:255',
        'password' => 'required|string|min:8',
        'dominio' => 'required|string|max:255|unique:empresas,dominio',
        'quienes_somos_es' => 'nullable|string',
        'quienes_somos_en' => 'nullable|string',
        'quienes_somos_pt' => 'nullable|string',
        'color_principal' => 'nullable|string|max:7',
        'color_barra_superior' => 'nullable|string|max:7',
        'filtro_imagen_1' => 'required|boolean',
        'filtro_imagen_2' => 'required|boolean',
        'tipografia_agencia' => 'nullable|string|max:50',
        'color_tipografia_agencia' => 'nullable|string|max:7',
        'color_fondo_app' => 'nullable|string|max:7',
        'color_primario' => 'nullable|string|max:7',
        'color_secundario' => 'nullable|string|max:7',
        'color_terciario' => 'nullable|string|max:7',
        'header_imagen_background_opacidad' => 'nullable|numeric|min:0|max:1',
        'header_video_background_opacidad' => 'nullable|numeric|min:0|max:1',
        'buscador_tipografia' => 'nullable|string|max:50',
        'buscador_tipografia_color' => 'nullable|string|max:7',
        'buscador_tipografia_color_label' => 'nullable|string|max:7',
        'buscador_color_primario' => 'nullable|string|max:7',
        'buscador_color_secundario' => 'nullable|string|max:7',
        'buscador_color_terciario' => 'nullable|string|max:7',
        'publicidad_existe' => 'required|boolean',
        'publicidad_titulo' => 'nullable|string|max:255',
        'publicidad_tipografia_color' => 'nullable|string|max:7',
        'publicidad_color_primario' => 'nullable|string|max:7',
        'publicidad_color_secundario' => 'nullable|string|max:7',
        'publicidad_color_terciario' => 'nullable|string|max:7',
        'tarjetas_titulo' => 'nullable|string|max:255',
        'tarjetas_tipografia' => 'nullable|string|max:50',
        'tarjetas_tipografia_color' => 'nullable|string|max:7',
        'tarjetas_tipografia_color_titulo' => 'nullable|string|max:7',
        'tarjetas_tipografia_color_contenido' => 'nullable|string|max:7',
        'tarjetas_color_primario' => 'nullable|string|max:7',
        'tarjetas_color_secundario' => 'nullable|string|max:7',
        'tarjetas_color_terciario' => 'nullable|string|max:7',
        'banner_registro_titulo' => 'nullable|string|max:255',
        'banner_registro_tipografia_color' => 'nullable|string|max:7',
        'banner_registro_color_primario' => 'nullable|string|max:7',
        'banner_registro_color_secundario' => 'nullable|string|max:7',
        'banner_registro_color_terciario' => 'nullable|string|max:7',
        'footer_texto' => 'nullable|string|max:500',
        'footer_tipografia' => 'nullable|string|max:50',
        'footer_tipografia_color' => 'nullable|string|max:7',
        'footer_color_primario' => 'nullable|string|max:7',
        'footer_color_secundario' => 'nullable|string|max:7',
        'footer_color_terciario' => 'nullable|string|max:7',
        'footer_facebook' => 'nullable|string|max:255|url',
        'footer_twitter' => 'nullable|string|max:255|url',
        'footer_instagram' => 'nullable|string|max:255|url',
        'footer_whatsapp' => 'nullable|string|max:20',
        'footer_telefono' => 'nullable|string|max:20',
        'footer_email' => 'nullable|email|max:255',
        'footer_direccion' => 'nullable|string|max:255',
        'footer_ciudad' => 'nullable|string|max:100',
        'footer_pais' => 'nullable|string|max:100',
    ]);

    if ($validator->fails()) {
        return response()->json(['errors' => $validator->errors()], 422);
    }

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
