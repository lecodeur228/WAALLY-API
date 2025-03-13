<?php

namespace App\repositories;

use App\Models\Article;
use App\Models\Shop;

class ArticleRepository{

    public function getArticles($id){

        return Article::where("shop_id" , $id)->get();

    }

    public function getShop($id){   

        $article = Article::find($id);
        return $article->shop;
    }

    public function store($data){

        return Article::create($data);

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
