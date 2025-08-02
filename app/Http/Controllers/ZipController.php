<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use ZipArchive;

class ZipController extends Controller
{
    public function recibir(Request $request)
    {
        
        $nombre = trim($request->header('name'), '"');
        $valor = trim($request->header('value'), '"');

        Log::info('Encabezados recibidos:', ['name' => $nombre, 'value' => $valor]);
		
        
        $archivos = $request->allFiles();
        if (empty($archivos)) {
            return response()->json(['error' => 'No se recibió ningún archivo'], 400);
        }

        //direcciones de guardado
        $carpetaTemporal = storage_path('app/temporal');
        $carpetaDescomprimido = $carpetaTemporal . '/descomprimido';

        //eliminar en produccion
        if (!file_exists($carpetaTemporal)) {
            mkdir($carpetaTemporal, 0777, true);
        }

        if (!file_exists($carpetaDescomprimido)) {
            mkdir($carpetaDescomprimido, 0777, true);
        }
        ////

        // Obtener el archivo ZIP
        $archivo = reset($archivos);  
        $nombreOriginal = $archivo->getClientOriginalName();  
        $tamano = $archivo->getSize();  
        $mime = $archivo->getMimeType();  

        Log::info("Archivo ZIP recibido", [
            'nombre' => $nombreOriginal,
            'tamaño' => $tamano,
            'tipo_mime' => $mime,
        ]);

        
        $ruta = $archivo->storeAs('temporal', $nombreOriginal);
        
        //si es necesario cambia esta ruta
        $rutaZip = storage_path('app/temporal/' . $nombreOriginal);

        $zip = new ZipArchive;
        $zipStatus = $zip->open($rutaZip);  

        if ($zipStatus === true) {
            
            $zip->extractTo($carpetaDescomprimido);
            $zip->close();

            $archivosProcesados = [];

            foreach (scandir($carpetaDescomprimido) as $archivoDescomprimido) {
                if (pathinfo($archivoDescomprimido, PATHINFO_EXTENSION) === 'pdf') {
                    $nombrePdf = pathinfo($archivoDescomprimido, PATHINFO_FILENAME);
                    $archivosProcesados[] = $nombrePdf;

                    // Generar un nombre aleatorio para el archivo PDF
                    $nombreAleatorioPdf = Str::random(40) . '.pdf';

                    // Buscar la ficha asociada
                    $ficha = DB::table('FICHA')->where('NIT', $nombrePdf)->select('numero')->first();
                    
                    // Guardar el archivo PDF con nombre aleatorio
                    $rutaPdf = Storage::putFileAs("adjuntos/{$ficha->numero}", 
                                                  new \Illuminate\Http\File($carpetaDescomprimido . '/' . $archivoDescomprimido), 
                                                  $nombreAleatorioPdf);

                    

                    if ($ficha) {
                        // Insertar en la base de datos
                        DB::table('adjuntos')->insert([
                            'nombre' => $valor,
                            'url' => 'adjuntos/' . $ficha->numero . '/' . $nombreAleatorioPdf,
                            'ficha_id' => $ficha->numero,
                            'usuario_id' => 1,  
                            'para_todos' => 'N',  
                            'created_at' => now(),
                            'updated_at' => now(),
                            'tipo_id' => 1,  
                            'adjuntable_id' => $ficha->numero,
                            'adjuntable_type' => 'App\Models\Ficha',
                        ]);

                        Log::info("Insertado: {$nombrePdf} en adjuntos.");
                    } else {
                        Log::warning("No se encontró ficha con NIT: {$nombrePdf}");
                    }
                }
            }

            File::deleteDirectory($carpetaDescomprimido); // Elimina los archivos descomprimidos
            File::deleteDirectory($carpetaTemporal);      // Elimina toda la carpeta temporal
            File::delete($rutaZip); 


            return response()->json([
                'mensaje' => 'ZIP recibido y procesado correctamente',
                'nombre' => $nombreOriginal,
                'ruta' => $ruta,
                'nombre_cliente' => $nombre,
                'valor_cliente' => $valor,
                'archivos_procesados' => $archivosProcesados,
            ]);
        } else {
            Log::error("Error al abrir ZIP: código {$zipStatus}");

            return response()->json([
                'error' => 'No se pudo descomprimir el archivo ZIP',
                'codigo' => $zipStatus
            ], 400);
        }
    }
}
