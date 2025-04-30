<?php

namespace App\Repositories;
use App\Models\Sale;
use Illuminate\Http\Request;
use App\Helpers\PdfUploadHelper;


class InvoiceRepository {

public function generatePDF($saleId)
    {
        $sale = Sale::with(['article', 'customer', 'seller'])->findOrFail($saleId);
        
        // Utilisation du dossier organisé par date
        $folder = PdfUploadHelper::getDateBasedFolder('invoices');
        
        // Nom personnalisé pour le fichier
        $filename = 'invoice-' . $sale->id . '-' . date('YmdHis');
        
        // Génération et stockage du PDF
        $result = PdfUploadHelper::generateAndStorePdf(
            'invoices.pdf',  // Nom de la vue
            compact('sale'),  // Données pour la vue
            'invoices/$folder',  // Dossier
            $filename        // Nom du fichier
        );
        
        if ($result) {
            // Enregistrer le chemin dans la base de données
            $invoice = Invoice::create();
            $sale->invoice_path = $result['path'];
            $sale->save();
            
            return [
                'status' => true,
                'message' => 'Facture générée et sauvegardée avec succès',
                'data' => $result
            ];
        }
        
        return [
            'status' => false,
            'message' => 'Échec de la génération de la facture'
        ];
    }
    
    public function downloadPDF($saleId)
    {
        $sale = Sale::findOrFail($saleId);
        
        if (!$sale->invoice_path) {
            return [
                'status' => false,
                'message' => 'Aucune facture trouvée pour cette vente'
            ];
        }
        
        $download = PdfUploadHelper::downloadPdf(
            $sale->invoice_path, 
            'facture-' . $sale->ref . '.pdf'
        );
        
        if ($download) {
            return $download;
        }
        
        return [
            'status' => false,
            'message' => 'Facture introuvable sur le serveur'
        ];
    }

}
