<?php

namespace App\Services\Product;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Storage;

class ProductService
{
    /**
     * @param  int  $count
     *
     * @return Collection
     */
    public function getAllFromXmlPaginated(int $count): Collection
    {
        $files = [
            'products_1.xml',
            'products_2.xml',
            'products_3.xml',
        ];

        $products = collect();

        foreach ($files as $file) {
            $file_content = simplexml_load_string(Storage::get($file), null, LIBXML_NOCDATA);
            $file_content = json_decode(json_encode($file_content, JSON_UNESCAPED_UNICODE));

            $products = $products->concat($file_content->SHOPITEM);
        }

        return $products->take($count);
    }
}
