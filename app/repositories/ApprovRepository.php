<?php

namespace App\Repositories;

use App\Models\Approv;
use App\Models\ArticleMagazine;
use App\Models\ArticleShop;

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
        return $this->handleWarehouseSupply($data);
    }
    elseif ($approv->type === 'SaleSupplyAction') {
        // Transfert du magasin vers le shop
        return $this->handleSaleSupply($data);
    }

    // Si le type n'est pas reconnu
    return [
        'status' => false,
        'message' => 'Type d\'approvisionnement non reconnu'
    ];
}

private function handleWarehouseSupply($data)
{
    $articleMag = ArticleMagazine::where('article_id', $data['article_id'])
                                 ->where('magazine_id', $data['magazine_id'])
                                 ->first();

    if ($articleMag) {
        // L'article existe déjà dans le magasin, augmenter la quantité
        $articleMag->quantity += $data['quantity'];
        $articleMag->save();
    } else {
        // L'article n'existe pas dans le magasin, le créer
        ArticleMagazine::create([
            'article_id' => $data['article_id'],
            'magazine_id' => $data['magazine_id'],
            'quantity' => $data['quantity']
        ]);
    }

    return [
        'status' => true,
        'message' => 'Approvisionnement du magasin effectué avec succès'
    ];
}

private function handleSaleSupply($data)
{
    // Étape 1 : Vérifier la disponibilité dans le magasin
    $articleMag = ArticleMagazine::where('article_id', $data['article_id'])
                                 ->where('magazine_id', $data['magazine_id'])
                                 ->first();

    if (!$articleMag || $articleMag->quantity < $data['quantity']) {
        return [
            'status' => false,
            'message' => 'Quantité insuffisante dans le magasin'
        ];
    }

    // Étape 2 : Retirer du magasin
    $articleMag->quantity -= $data['quantity'];
    $articleMag->save();

    // Étape 3 : Ajouter dans le shop
    $articleShop = ArticleShop::where('article_id', $data['article_id'])
                              ->where('shop_id', $data['shop_id'])
                              ->first();

    if ($articleShop) {
        // L'article existe déjà dans la boutique, augmenter la quantité
        $articleShop->quantity += $data['quantity'];
        $articleShop->save();
    } else {
        // L'article n'existe pas dans la boutique, le créer
        ArticleShop::create([
            'article_id' => $data['article_id'],
            'shop_id' => $data['shop_id'],
            'quantity' => $data['quantity']
        ]);
    }

    return [
        'status' => true,
        'message' => 'Transfert du magasin vers la boutique effectué avec succès'
    ];
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
        return $this->handleWarehouseSupplyDeletion($approval);
    }
    elseif ($approval->type === 'SaleSupplyAction') {
        return $this->handleSaleSupplyDeletion($approval);
    }

    // Si le type n'est pas reconnu
    return [
        'status' => false,
        'message' => 'Type d\'approvisionnement non reconnu'
    ];
}

private function handleWarehouseSupplyDeletion($approval)
{
    // Réduction du stock magasin
    $articleMag = ArticleMagazine::where('article_id', $approval->article_id)
                                 ->where('magazine_id', $approval->magazine_id)
                                 ->first();

    if (!$articleMag) {
        return [
            'status' => false,
            'message' => 'Article non trouvé dans le magasin'
        ];
    }

    // Réduire la quantité en s'assurant qu'elle ne devient pas négative
    $articleMag->quantity -= $approval->quantity;
    if ($articleMag->quantity < 0) $articleMag->quantity = 0;
    $articleMag->save();

    return [
        'status' => true,
        'message' => 'Approvisionnement du magasin annulé avec succès'
    ];
}

private function handleSaleSupplyDeletion($approval)
{
    // 1. Retirer du shop
    $articleShop = ArticleShop::where('article_id', $approval->article_id)
                              ->where('shop_id', $approval->shop_id)
                              ->first();

    if (!$articleShop) {
        return [
            'status' => false,
            'message' => 'Article non trouvé dans la boutique'
        ];
    }

    // Réduire la quantité en s'assurant qu'elle ne devient pas négative
    $articleShop->quantity -= $approval->quantity;
    if ($articleShop->quantity < 0) $articleShop->quantity = 0;
    $articleShop->save();

    // 2. Remettre dans le magasin
    $articleMag = ArticleMagazine::where('article_id', $approval->article_id)
                                 ->where('magazine_id', $approval->magazine_id)
                                 ->first();

    if ($articleMag) {
        $articleMag->quantity += $approval->quantity;
        $articleMag->save();
    } else {
        ArticleMagazine::create([
            'article_id' => $approval->article_id,
            'magazine_id' => $approval->magazine_id,
            'quantity' => $approval->quantity,
        ]);
    }

    return [
        'status' => true,
        'message' => 'Transfert du shop vers le magasin effectué avec succès'
    ];
}


}
