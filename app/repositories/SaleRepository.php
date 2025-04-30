<?php

namespace App\Repositories;

use App\models\Sale;
use App\models\ArticleShop;
use Illuminate\Support\Facades\Auth;



class SaleRepository {


    public function getSales($shopId)
    {
      return  Sale::with('article', 'customer', 'seller')->where('shop_id', $shopId)->get();
    }

    public function store(array $data){
        $articleShop = ArticleShop::find($data['article_shop_id']);

        if($articleShop){
            if($data['quantity'] >= $articleShop->quantity){
                $articleShop->quantity -= $data['quantity'];
                $articleShop->save();
                $data['article_id'] = $articleShop->article_id;
                $data['shop_id'] = $articleShop->shop_id;
               
                $data['seller_id'] = Auth::user()->id;
            $sale = Sale::create($data);
            if($data['generateInvoice'])
            {
               $invoice = InvoiceRepository::generatePDF($sale->id);
               $sale->invoice_id = $invoice['data']['id'];
               $sale->save();
            }
            return [
                'status' => true,
                'message' => 'Sales added successfully',
                'data' => $sale
            ];
        }else {
            return [
                'status' => false,
                'message' => 'Quantity insufficient'
            ];
        }

    } else {
        return [
            'status' => false,
            'message' => 'Article not found'
        ];
    }

    }


    public function delete($saleId)
{
    $sale = Sale::find($saleId);

    if ($sale) {
        // Récupérer l'article dans la boutique
        $articleShop = ArticleShop::find($sale->article_shop_id);

        if ($articleShop) {
            // Restaurer la quantité à l'article dans la boutique
            $articleShop->quantity += $sale->quantity;
            $articleShop->save();

            // Supprimer la vente
            $sale->state = 1;

            $sale->save();

            return [
                'status' => true,
                'message' => 'Vente supprimée avec succès'
            ];
        } else {
            return [
                'status' => false,
                'message' => 'Article en boutique non trouvé'
            ];
        }
    } else {
        return [
            'status' => false,
            'message' => 'Vente non trouvée'
        ];
    }
}

}
