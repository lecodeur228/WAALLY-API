<?php

namespace App\services;

use App\repositories\ArticleRepository;

class ArticlesService {
    
    protected $articleRepository;

    public function __construct(ArticleRepository $articleRepository)
    {
        $this->articleRepository = $articleRepository;
    }

    public function getArticles($id) {

        return $this->articleRepository->getArticles($id);

    }

    public function getShop($id){

        return $this->articleRepository->getShop($id);
        
    }

    public function store($data , $shopIds) {
        
        return $this->articleRepository->store($data,$shopIds);

    }

    public function update($data , $id) {
        
        return $this->articleRepository->update($data , $id);

    }

    public function delete($shopId , $id){

        return $this->articleRepository->delete($shopId , $id);

    }
}