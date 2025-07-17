<?php 

namespace App\Models\GaleryModels;

class FetchGaleryDataModel{
   public int $id;
   public string $galery_name;
   public string $galery_cover;
   public string $deadline;
   public bool $private;
   public bool $watermark;
   public string $status;
   public string $cdl_id;
   public string $created_at;
   private int $user_foreign_key;
   private string $password;
}