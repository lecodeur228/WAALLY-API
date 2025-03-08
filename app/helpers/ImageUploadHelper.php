<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ImageUploadHelper
{
    /**
     * Upload une image.
     *
     * @param \Illuminate\Http\UploadedFile $file
     * @param string $folder
     * @return string|null
     */


     public static function uploadImage($file, $folder = 'uploads')
     {
         try {
             // Vérifier si le fichier est valide
             if (!$file->isValid()) {
                 throw new \Exception('File is not valid.');
             }

             // Vérifier si le type MIME est une image autorisée
             $allowedMimeTypes = ['image/jpeg', 'image/png', 'image/gif', 'image/webp'];
             if (!in_array($file->getMimeType(), $allowedMimeTypes)) {
                 throw new \Exception('Invalid file type. Only JPEG, PNG, GIF, and WEBP are allowed.');
             }

             // Générer un nom unique pour le fichier
             $filename = Str::uuid() . '.' . $file->getClientOriginalExtension();

             // Stocker l'image dans le dossier spécifié
             $path = $file->storeAs($folder, $filename, 'public');

             // Ajouter un log pour débogage
             Log::info('Image uploaded successfully: ' . $path);

             // Retourner une URL publique
             return asset('storage/' . $path);
         } catch (\Exception $e) {
             // Logger l'erreur
             Log::error('Image upload failed: ' . $e->getMessage());
             report($e);

             return null;
         }
     }




    /**
     * Supprime une image existante.
     *
     * @param string $path
     * @return bool
     */
    public static function deleteImage($path)
    {
        try {
            // Vérifie si le fichier existe
            if (Storage::disk('public')->exists($path)) {
                return Storage::disk('public')->delete($path);
            }
            return false;
        } catch (\Exception $e) {
            // Gestion des erreurs (optionnel)
            report($e);
            return false;
        }
    }
}
