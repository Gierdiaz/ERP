<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileFileRequest;
use Exception;
use Illuminate\Support\Facades\{Log, Storage, URL};

class ProfileController extends Controller
{
    public function file(ProfileFileRequest $request)
    {
        try {
            $request->validated();
    
            $file = $request->file('file');
    
            $path = $file->store('files');

            $url = URL::signedRoute('file.download', ['file' => basename($path)]);
    
            Log::channel('file')->info('Arquivo armazenado em: ' . $path);
    
            return response()->json(['success' => 'Arquivo enviado com sucesso', 'download_url' => $url], 200);
        } catch(Exception $exception) {
            Log::channel('error')->error('Erro durante o processamento do arquivo: ' . $exception->getMessage());
            return response()->json(['error' => 'Erro durante o processamento do arquivo. Por favor, tente novamente mais tarde.'], 500);
        }
    }

    public function download($file)
    {
        if(Storage::exists('files/'. $file)) {
            return Storage::download('files/' .$file);
        }

        return response()->json(['Eror' => 'Arquivo não encontrado'], 404);
    }
    
}
