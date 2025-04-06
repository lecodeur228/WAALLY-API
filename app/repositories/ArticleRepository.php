<?php

namespace App\repositories;

use App\Models\Article;
use App\Models\Shop;
use GuzzleHttp\Psr7\Message;
use Illuminate\Support\Facades\Auth;

class ArticleRepository{

    public function getArticles($id){
        $shop = Shop::find($id);
        return $shop->articles;
    }

    public function getRelatedShops($id){

        $article = Article::find($id);
        return $article->shops;
    }

    public function getUnrelatedShops($articleId){

        $article = Article::find($articleId);

        // Récupérer les IDs des shops liés à l'article
        $relatedShopIds = $article->shops()->pluck('shop_id');

        // Récupérer les shops qui ne sont pas liés à l'article
        $userConnectedId = Auth::user()->id;
        $unrelatedShops = Shop::whereNotIn('id', $relatedShopIds)->where('user_id', $userConnectedId)->get();

        return $unrelatedShops;

    }

    public function store($data , $shopIds){

        $article = Article::create($data);
        foreach($shopIds as $shopId){
            $article->shops()->attach($shopId);
            $response[$shopId] = $article;
        }
        return $response;

    }

    public function update($data, $id){

        $article = Article::find($id);
        $article->name = $data['name'];
        $article->description = $data['description'];
        $article->sale_price = $data['sale_price'];
        $article->buy_price = $data['buy_price'];
        $article->save();
        return $article;

    }

    public function addToShops($articleId, $shopIds){

        $article = Article::find($articleId);

        // Ajoute uniquement les nouvelles associations sans dupliquer les existantes
        $article->shops()->syncWithoutDetaching($shopIds);

        // Retourne les shops associés
        return Shop::whereIn('id', $shopIds)->get();

    }
    // bug dans cette fonction
    /**public function removeFromShop($articleId, $shopIds)
    {
        $article = Article::find($articleId);
        $bool  = false;
        // Détacher l'article du shop
        $numberOfShops = $article->shops->count();
        foreach($shopIds as $shopId){
            if($numberOfShops > 1){
                $article->shops()->detach($shopId);
                $numberOfShops = $article->shops->count();
            }
            else{
                $bool = true;
            }
        }
        $response["shops"] = $article->shops;
        if($bool){
            $response["message"] = "Article removed successfully from shops but cannot remove it from the shop because it is the last one.";
        }
        return $response;
    }   */

    public function removeFromShops($articleId, array $shopIds)
    {
        $article = Article::find($articleId);

        // Détacher l'article de plusieurs shops en une seule requête
        $article->shops()->detach($shopIds);
        $response= $article->shops;

        return $response;
    }


    // il faut un try catch ici
    public  function delete($id){

        $article = Article::find($id);
        $shops = $article->shops;
        $article->state = 1;
        $article->save();
        if( $shops ){
            foreach ($shops as $shop) {
                $article->shops()->detach($shop->id);
            }
        }
        return $article;

    }

}
