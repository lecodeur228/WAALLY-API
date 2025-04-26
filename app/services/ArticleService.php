<?php

namespace App\Services;

use App\repositories\ArticleRepository;

class ArticleService {

    protected $articleRepository;

    public function __construct(ArticleRepository $articleRepository)
    {
        $this->articleRepository = $articleRepository;
    }

    public function getArticles($id) {

        return $this->articleRepository->getArticles($id);

    }

    public function getRelatedShops($id){

        return $this->articleRepository->getRelatedShops($id);

    }

    public function getUnrelatedShops($articleId){

        return $this->articleRepository->getUnrelatedShops($articleId);
    }

    public function store($data , $shopIds) {

        return $this->articleRepository->store($data,$shopIds);

    }

    public function addToshops($articleId , $shopIds) {

        return $this->articleRepository->addToShops($articleId , $shopIds);

    }

    public function removeFromShops($articleId , $shopIds) {

        return $this->articleRepository->removeFromShops($articleId , $shopIds);
    }



    public function update($data , $id) {

        return $this->articleRepository->update($data , $id);

    }

    public function delete($id){

        return $this->articleRepository->delete($id);

    }
}
