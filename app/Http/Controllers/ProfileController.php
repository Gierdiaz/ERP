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

            $url = URL::temporarySignedRoute('file.download', now()->addMinutes(30), ['file' => basename($path)]);

            Log::channel('file')->info('File stored in: ' . $path);

            return response()->json(['success' => 'File uploaded successfully', 'download_url' => $url], 200);
        } catch(Exception $exception) {
            Log::channel('error')->error('Error processing file: ' . $exception->getMessage());
            return response()->json(['error' => 'Error processing file. Please try again later.'], 500);
        }
    }

    public function download($file)
    {
        if(Storage::exists('files/'. $file)) {
            return Storage::download('files/' .$file);
        }

        return response()->json(['Error' => 'File not found'], 404);
    }

}
