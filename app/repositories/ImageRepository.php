<?php

namespace App\Repositories;


use App\Helpers\ImageUploadHelper;

use App\Models\Image;





class ImageRepository{

    public function uploadImage(array $files, $articleId){

        foreach ($files as $file) {
            $path = ImageUploadHelper::uploadImage($file, 'articles');
            Image::create([
                'image_path' => $path,
                'article_id' => $articleId,
            ]);
        }
        return true;

    }
    

    public function deleteImage($imageId){
        $image = Image::find($imageId);
        ImageUploadHelper::deleteImage($image->image_path);
        $image->delete();
        return true;
    }


}
