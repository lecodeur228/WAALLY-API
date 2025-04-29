<?php

namespace App\Repositories;

use App\Models\Article;
use GuzzleHttp\Psr7\Message;
use Illuminate\Support\Facades\Auth;

class ArticleRepository{

    public function getArticles(){
        $articles = Article::with('images')->where('owner_id', Auth::user()->id)->get();
        return $articles;
    }


    public function getArticle($id){

        $article = Article::find($id);
        return $article;
    }



    public function store($data ){
        $data['owner_id'] = Auth::user()->id;
        $article = Article::create(
            [
                'name' => $data['name'],
                'description' => $data['description'],
                'sale_price' => $data['sale_price'],
                'purchase_price' => $data['purchase_price'],
                'supplier_id' => $data['supplier_id'],
                'owner_id' => $data['owner_id'],
            ]
        );
        return $article;
    }

    public function update($data, $id){

        $article = Article::find($id);
        $article->name = $data['name'];
        $article->description = $data['description'];
        $article->sale_price = $data['sale_price'];
        $article->purchase_price = $data['purchase_price'];
        $article->save();
        return $article;
    }



    public  function delete($id){

        $article = Article::find($id);
        $article->state = 1;
        $article->save();
        return $article;
    }

}
