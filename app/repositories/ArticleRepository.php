<?php
namespace App\Repositories;

use App\Models\Article;

class ArticleRepository{

    public function getArticles($id){

        return Article::where("shop_id" , $id);

    }

    public function getShop(){

        return Article::shop();
    }

    public function store($data){

        return Article::create($data);

    }

    public function update($data, $id){
        
        return Article::where('id',$id)->update($data);

    }

    public  function delete($id){
        
        return Article::where('id',$id)->update(["state" => 1]);

    }

}
