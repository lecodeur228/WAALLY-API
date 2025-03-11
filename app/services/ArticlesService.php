<?php

namespace App\Services;

use App\Repositories\ArticleRepository;

class ArticleService {
    
    protected $articleRepository;

    public function __construct(ArticleRepository $articleRepository)
    {
        $this->articleRepository = $articleRepository;
    }

    public function getArticles($id) {

        return $this->articleRepository->getArticles($id);

    }

    public function getShop(){

        return $this->articleRepository->getShop();
        
    }

    public function store($data) {
        
        return $this->articleRepository->store($data);

    }

    public function update($data , $id) {
        
        return $this->articleRepository->update($data , $id);

    }

    public function delete($id){

        return $this->articleRepository->delete($id);

    }
}