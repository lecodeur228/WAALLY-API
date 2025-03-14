<?php

namespace App\repositories;

use App\Models\Article;
use App\Models\Shop;

class ArticleRepository{

    public function getArticles($id){
        $shop = Shop::find($id);
        return $shop->articles;

    }

    public function getShop($id){   

        $article = Article::find($id);
        return $article->shops;
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

    // il faut un try catch ici
    public  function delete($shopId , $id){
        
        $shop = Shop::find($shopId);
        if($shop){
            $article = Article::find($id);
            $article->state = 1;
            $article->save();
            return $article;
        }
        return null;

    }

}
