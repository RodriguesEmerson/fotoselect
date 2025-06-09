<?php 

namespace App\Utils;

class Url{
   public static function sanitizeRouteUrl(): string {
      $url = filter_input(INPUT_GET, 'url', FILTER_SANITIZE_URL);  
      if (!$url) return '/';

      // Remove all characters except letters, numbers, slashes, hyphens, and underscores
      $url = preg_replace('/[^a-zA-Z0-9\/_-]/', '', $url);

      // Replace multiple slashes with a single slash
      $url = preg_replace('/\/+/', '/', $url);

      // Remove trailing slash (unless it's the root '/')
      if ($url !== '/') {
         $url = rtrim($url, '/');
      }

      // Ensure the URL always starts with a slash
      return '/' . ltrim($url, '/');
   }
}