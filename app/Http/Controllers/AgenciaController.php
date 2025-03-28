<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use App\Models\Agencia;
use App\Models\Tenant;
use App\Models\User;

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
        // Validar los datos de la solicitud
        $data = $request->validate([
            'subdomain' => 'required|string|unique:tenants,subdomain',
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|unique:users,email',
            'password' => 'required|string|min:6',

            'estado' => 'required|boolean',

            'color_principal' => 'required|string',
            'color_secundario' => 'required|string',
            'color_barra_superior' => 'required|string',
            'filtro_imagen_1' => 'required|boolean',
            'filtro_imagen_2' => 'required|boolean',
            'nombre_de_contacto' => 'required|string',
            'direccion' => 'required|string',
            'whatsapp' => 'required|string',
            'telefono' => 'required|string',

        ]);

        // Crear el tenant
        $tenant = Tenant::create([
            'subdomain' => $request->subdomain,
            'template' => 'default', // Puedes personalizar esto
        ]);

        // Crear el usuario asociado al tenant
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'tenant_id' => $tenant->id,
        ]);

        // Asociar el tenant al request
        $data['tenant_id'] = $tenant->id;

       // Crear una subcarpeta con el nombre de la agencia si no existe
    $folderPath = 'agencias/' . $nombreAgencia;
    Storage::disk('public')->makeDirectory($folderPath);

    // Subir imágenes si existen
    if ($request->hasFile('favicon')) {
        // Guardar el archivo en la subcarpeta específica
        $data['favicon'] = $request->file('favicon')->store($folderPath, 'public');
    }

    if ($request->hasFile('logo')) {
        $data['logo'] = $request->file('logo')->store($folderPath, 'public');
    }

    if ($request->hasFile('fondo_1')) {
        $data['fondo_1'] = $request->file('fondo_1')->store($folderPath, 'public');
    }

    if ($request->hasFile('fondo_2')) {
        $data['fondo_2'] = $request->file('fondo_2')->store($folderPath, 'public');
    }
        $data['nombre']=$data['name'];
        $data['dominio']=$data['subdomain'];
        $data['mail']=$data['email'];
        // Crear la agencia con los datos procesados
        $agencia = Agencia::create($data);

        DB::commit(); // Confirma la transacción
        return redirect()->route('admin.dashboard')->with('success', 'Agencia y Tenant creados exitosamente.');

    } catch (\Exception $e) {
        DB::rollBack(); // Revierte la transacción en caso de error
        dd("Error al guardar la agencia y el tenant: " . $e->getMessage());
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
        return response()->json($agencia['fondo_1']);
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
