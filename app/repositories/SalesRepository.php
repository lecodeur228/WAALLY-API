<?php

namespace App\Repositories;

class SalesRepository {


    public function getSales($shopId)
    {
         Sale::where('shop_id', $shopId)->get();
    }

    public function store(array $data){
        $articleShop = ArticleShop::find($data['article_shop_id']);

        if($articleShop){
            if($data['quantity'] >= $articleShop->quantity){
                $articleShop->quantity -= $data['quantity'];
                $articleShop->save();
                $data['article_shop_id'] = $articleShop->id;
                $data['total_price'] = $articleShop->article()->purchase_price * $data['quantity'];
                $data['seller_id'] = Auth::user()->id;

            Sale::create($data);
            return [
                'status' => true,
                'message' => 'Sales added successfully'
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
