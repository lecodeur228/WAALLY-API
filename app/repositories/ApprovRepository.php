<?php

namespace App\Repositories;

use App\Models\Approv;

class ApprovRepository
{
    public function getApprovals($shopId){
        return Approv::where('shop_id', $shopId)->get();
    }



public function store($data)
{
    $approv = Approv::create($data);

    if ($approv->type === 'WarehouseSupplyAction') {
        // Approvisionnement classique du magasin
        $articleMag = ArticleMagazine::where('article_id', $data['article_id'])
                                     ->where('magazine_id', $data['magazine_id'])
                                     ->first();

        if ($articleMag) {
            $articleMag->quantity += $data['quantity'];
            $articleMag->save();
            return [
                'status' => true,
                'message' => 'Approvisionnement effectué avec succès'
            ];
        } else {
            ArticleMagazine::create([
                'article_id' => $data['article_id'],
                'magazine_id' => $data['magazine_id'],
                'quantity' => $data['quantity']
            ]);

            return [
                'status' => true,
                'message' => 'Approvisionnement effectué avec succès'
            ];
        }

    } elseif ($approv->type === 'SaleSupplyAction') {
        // Transfert du magasin vers le shop

        // Étape 1 : Retirer du magasin
        $articleMag = ArticleMagazine::where('article_id', $data['article_id'])
                                     ->where('magazine_id', $data['magazine_id'])
                                     ->first();

        if ($articleMag && $articleMag->quantity >= $data['quantity']) {
            $articleMag->quantity -= $data['quantity'];
            $articleMag->save();
            return [
                'status' => true,
                'message' => 'Approvisionnement effectué avec succès'
            ];
        } else {
            return [
                'status' => false,
                'message' => 'Quantité insuffisante dans le magasin'
            ];
        }

        // Étape 2 : Ajouter dans le shop
        $articleShop = ArticleShop::where('article_id', $data['article_id'])
                                  ->where('shop_id', $data['shop_id'])
                                  ->first();

        if ($articleShop) {
            $articleShop->quantity += $data['quantity'];
            $articleShop->save();
            return [
                'status' => true,
                'message' => 'Approvisionnement effectué avec succès'
            ];
        } else {
            ArticleShop::create([
                'article_id' => $data['article_id'],
                'shop_id' => $data['shop_id'],
                'quantity' => $data['quantity']
            ]);

            return [
                'status' => true,
                'message' => 'Approvisionnement effectué avec succès'
            ];
        }
    }
}





   public function delete($id)
{
    $approval = Approv::find($id);

    if (!$approval) {
        return [
            'status' => false,
            'message' => 'Approvisionnement non trouvé'
        ];
    }

    // Marquer comme supprimé
    $approval->state = 1;
    $approval->save();

    if ($approval->type === 'WarehouseSupplyAction') {
        // Réduction du stock magasin
        $articleMag = ArticleMagazine::where('article_id', $approval->article_id)
                                     ->where('magazine_id', $approval->magazine_id)
                                     ->first();

        if ($articleMag) {
            $articleMag->quantity -= $approval->quantity;
            if ($articleMag->quantity < 0) $articleMag->quantity = 0;
            $articleMag->save();
            return [
                'status' => true,
                'message' => 'Approvisionnement annulé avec succès'

            ];
        }

    } elseif ($approval->type === 'SaleSupplyAction') {
        // 1. Retirer du shop
        $articleShop = ArticleShop::where('article_id', $approval->article_id)
                                  ->where('shop_id', $approval->shop_id)
                                  ->first();

        if ($articleShop) {
            $articleShop->quantity -= $approval->quantity;
            if ($articleShop->quantity < 0) $articleShop->quantity = 0;
            $articleShop->save();
            return [
                'status' => true,
                'message' => 'Approvisionnement annulé avec succès'
            ];
        }

        // 2. Remettre dans le magasin
        $articleMag = ArticleMagazine::where('article_id', $approval->article_id)
                                     ->where('magazine_id', $approval->magazine_id)
                                     ->first();

        if ($articleMag) {
            $articleMag->quantity += $approval->quantity;
            $articleMag->save();
            return [
                'status' => true,
                'message' => 'Approvisionnement annulé avec succès'
            ];
        } else {
            ArticleMagazine::create([
                'article_id' => $approval->article_id,
                'magazine_id' => $approval->magazine_id,
                'quantity' => $approval->quantity,
            ]);
            return [
                'status' => true,
                'message' => 'Approvisionnement annulé avec succès'
            ];
        }
    }


}


}
