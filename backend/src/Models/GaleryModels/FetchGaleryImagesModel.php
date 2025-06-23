<?php 

namespace App\Models\GaleryModels;

class FetchGaleryImagesModel{
   public int $id;
   public string $name;
   public string $src;
   public string $cdl_id;
   private int $user_foreign_key;
   private int $galery_foreign_key;
   private string $created_at;
}