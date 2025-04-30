<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use PDF;

class PdfUploadHelper
{
    /**
     * Génère et enregistre un fichier PDF à partir d'une vue.
     *
     * @param string $view
     * @param array $data
     * @param string $folder
     * @param string|null $customFilename
     * @return string|null
     */
    public static function generateAndStorePdf($view, $data, $folder = 'pdfs', $customFilename = null)
    {
        try {
            // Charger la vue avec les données
            $pdf = PDF::loadView($view, $data);
            
            // Options de configuration (facultatif)
            $pdf->setPaper('a4', 'portrait');
            
            // Générer un nom unique pour le fichier
            $filename = $customFilename ?? (Str::uuid() . '.pdf');
            
            // Ajouter l'extension .pdf si elle n'est pas présente
            if (!Str::endsWith($filename, '.pdf')) {
                $filename .= '.pdf';
            }
            
            // Chemin de stockage
            $path = $folder . '/' . $filename;
            
            // Stocker le PDF dans le système de fichiers
            Storage::disk('public')->put($path, $pdf->output());
            
            // Ajouter un log pour débogage
            Log::info('PDF generated and stored successfully: ' . $path);
            
            // Retourner le chemin du fichier
            return [
                'path' => $path,
                'url' => asset('storage/' . $path),
                'filename' => $filename
            ];
        } catch (\Exception $e) {
            // Logger l'erreur
            Log::error('PDF generation failed: ' . $e->getMessage());
            report($e);
            
            return null;
        }
    }
    
    /**
     * Enregistre un fichier PDF déjà généré.
     *
     * @param mixed $pdfContent
     * @param string $folder
     * @param string|null $customFilename
     * @return string|null
     */
    public static function storePdf($pdfContent, $folder = 'pdfs', $customFilename = null)
    {
        try {
            // Générer un nom unique pour le fichier
            $filename = $customFilename ?? (Str::uuid() . '.pdf');
            
            // Ajouter l'extension .pdf si elle n'est pas présente
            if (!Str::endsWith($filename, '.pdf')) {
                $filename .= '.pdf';
            }
            
            // Chemin de stockage
            $path = $folder . '/' . $filename;
            
            // Stocker le PDF dans le système de fichiers
            Storage::disk('public')->put($path, $pdfContent);
            
            // Ajouter un log pour débogage
            Log::info('PDF stored successfully: ' . $path);
            
            // Retourner le chemin du fichier
            return [
                'path' => $path,
                'url' => asset('storage/' . $path),
                'filename' => $filename
            ];
        } catch (\Exception $e) {
            // Logger l'erreur
            Log::error('PDF storage failed: ' . $e->getMessage());
            report($e);
            
            return null;
        }
    }
    
    /**
     * Supprime un PDF existant.
     *
     * @param string $path
     * @return bool
     */
    public static function deletePdf($path)
    {
        try {
            // Vérifie si le fichier existe
            if (Storage::disk('public')->exists($path)) {
                $result = Storage::disk('public')->delete($path);
                if ($result) {
                    Log::info('PDF deleted successfully: ' . $path);
                } else {
                    Log::warning('Failed to delete PDF: ' . $path);
                }
                return $result;
            }
            Log::warning('PDF not found: ' . $path);
            return false;
        } catch (\Exception $e) {
            // Gestion des erreurs
            Log::error('PDF deletion failed: ' . $e->getMessage());
            report($e);
            return false;
        }
    }
    
    /**
     * Récupère un PDF pour le téléchargement.
     *
     * @param string $path
     * @param string|null $downloadName
     * @return \Symfony\Component\HttpFoundation\StreamedResponse|null
     */
    public static function downloadPdf($path, $downloadName = null)
    {
        try {
            if (Storage::disk('public')->exists($path)) {
                return Storage::disk('public')->download($path, $downloadName ?? basename($path));
            }
            return null;
        } catch (\Exception $e) {
            Log::error('PDF download failed: ' . $e->getMessage());
            report($e);
            return null;
        }
    }
    
    /**
     * Organise les PDFs par date (année/mois)
     *
     * @param string $baseFolder
     * @return string
     */
    public static function getDateBasedFolder($baseFolder = 'pdfs')
    {
        $dateFolder = date('Y/m');
        return $baseFolder . '/' . $dateFolder;
    }
}