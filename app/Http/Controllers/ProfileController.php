<?php

namespace App\Http\Controllers;

use Exception;
use Faker\Factory;
use Illuminate\Http\{JsonResponse, Request};
use Illuminate\Support\Facades\{Log, Storage, URL, Validator};
use Symfony\Component\HttpFoundation\StreamedResponse;

class ProfileController extends Controller
{
    // public function register(Request $request): void
    // {
    //     $validate = Validator::make($request->all(), [
    //         'name'     => ['required', 'string'],
    //         'email'    => ['required', 'email'],
    //         'password' => ['required'],
    //         'photo'    => ['nullable', 'image', 'max:2048'],
    //     ]);

    //     if ($validate->fails()) {
    //         response()->json(['error' => $validate->errors()->first()]);

    //         return;
    //     }

    //     if ($request->hasFile('photo')) {
    //         $path     = $request->file('photo')->store('profile-photos', 'public');
    //         $fileName = $request->file('photo')->getClientOriginalName();
    //     } else {
    //         $faker       = Factory::create();
    //         $fakerAvatar = $faker->imageUrl(300, 300, 'people');
    //         $fileName    = uniqid() . '.jpg';
    //         $path        = 'avatars/' . $fileName;
    //         Storage::disk('public')->put($path, file_get_contents($fakerAvatar));
    //     }
    // }

    // public function file(Request $request): JsonResponse
    // {
    //     try {
    //         $validate = Validator::make($request->all(), [
    //             'file' => ['file', 'max:2048', 'nullable', 'mimes:jpeg,png,jpg,gif,pdf,doc,docx,txt'],
    //         ]);

    //         if ($validate->fails()) {
    //             return response()->json(['error' => $validate->errors()->first()], 422);
    //         }

    //         $file = $request->file('file');
    //         $path = $file->store('files');
    //         $url  = URL::temporarySignedRoute('file.download', now()->addMinutes(30), ['file' => basename($path)]);
    //         Log::channel('file')->info('File stored in: ' . $path);

    //         return response()->json(['success' => 'File uploaded successfully', 'download_url' => $url], 200);
    //     } catch (Exception $exception) {
    //         Log::channel('error')->error('Error processing file: ' . $exception->getMessage());

    //         return response()->json(['error' => 'Error processing file. Please try again later.'], 500);
    //     }
    // }

    // public function download(string $file): StreamedResponse
    // {
    //     if (Storage::exists('files/' . $file)) {
    //         return Storage::download('files/' . $file);
    //     }

    //     return response()->json(['Error' => 'File not found'], 404);
    // }
}
