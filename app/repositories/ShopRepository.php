<?php

namespace App\repositories;

use App\Models\Article;
use App\Models\Shop;

class ShopRepository
{
    public function getShops()
    {
        return Shop::with(['user' => function($query) {
            $query->select('id', 'name', 'email', 'phone');
        }])->get(['id', 'name', 'description', 'city', 'longitude', 'latitude', 'created_at', 'updated_at', 'user_id']);
    }

    

    public function getRelatedArticles($id){
        $shop = Shop::find($id);
        return $shop->articles;
    }

    public function getUnrelatedArticles($shopId){

        $shop = Shop::find($shopId);

        // Récupérer les IDs des articles liés à l'article
        $relatedArticleIds = $shop->articles()->pluck('article_id');

        // Récupérer les articles qui ne sont pas liés à l'article
        $unrelatedArticles = Article::whereNotIn('id', $relatedArticleIds)->get();

        return $unrelatedArticles;

    }


    public function getStores($id){
        $shop = Shop::find($id);
        return $shop->stores;   
    }
    
    public function store($data)
    {
        return Shop::create($data);
    }

    public function addArticles($articleIds, $shopId){

        $shop = Shop::find($shopId);

        // Ajoute uniquement les nouvelles associations sans dupliquer les existantes
        $shop->articles()->syncWithoutDetaching($articleIds);

        // Retourne les articles associés
        return Article::whereIn('id', $articleIds)->get();
        
    }

    public function removeArticles($shopId, $articleIds)
    {
        $shop = Shop::find($shopId);
        // Détacher l'article de plusieurs shops en une seule requête
        $shop->articles()->detach($articleIds);
        $resposne = $shop->articles;

        return $resposne;
    }

    public function update($data, $id)
    {
        $shop = Shop::find($id);
        $shop->name = $data["name"];
        $shop->description = $data["description"];
        $shop->city = $data["city"];
        $shop->latitude = $data["latitude"];
        $shop->longitude = $data["longitude"];
        $shop->user_id = $data["user_id"];
        $shop->save();
        return $shop;
    }

    public function delete($id)
    {
        $shop = Shop::find($id);
        $shop->state = 1;
        $shop->save();
        return $shop;
    }


    public function assignUserToShop($shopId, $userId)
    {
        $shop = Shop::find($shopId);
        if ($shop) {
            $shop->user_id = $userId;
            $shop->save();
            return $shop;
        }
        return null;
    }
}