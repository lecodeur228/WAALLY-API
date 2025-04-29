<?php

namespace App\Services;

use App\repositories\ArticleRepository;
use App\repositories\ImageRepository;

class ArticleService {

    protected $articleRepository;
    protected $imageRepository;

    public function __construct(ArticleRepository $articleRepository, ImageRepository $imageRepository)
    {
        $this->articleRepository = $articleRepository;
        $this->imageRepository = $imageRepository;
    }

    public function getArticles() {

        return $this->articleRepository->getArticles();

    }




    public function store($data) {

        $article = $this->articleRepository->store($data);
        $this->imageRepository->uploadImage($data['images'], $article->id);
        return $article;

    }

    public function addImagesToArticle($data , $id) {
        $this->imageRepository->uploadImage($data['images'], $id);
        return true;
    }





    public function update($data , $id) {

        return $this->articleRepository->update($data , $id);

    }

    public function delete($id){

        $article = $this->articleRepository->delete($id);
        foreach ($article->images as $image) {
            $this->imageRepository->deleteImage($image->id);
        }
        return $article;
    }
}
