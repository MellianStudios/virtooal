<?php

namespace App\Services\Product;

use Illuminate\Support\Facades\Storage;

class ProductService
{
    /**
     * @param  int  $count
     *
     * @return array
     */
    public function getFromXml(int $count): array
    {
        $files = [
            'products_1.xml',
            'products_2.xml',
            'products_3.xml',
        ];

        $products = collect();

        foreach ($files as $file) {
            if (Storage::disk('xml')->exists($file)) {
                $file_content = simplexml_load_string(Storage::disk('xml')->get($file), null, LIBXML_NOCDATA);
                $file_content = json_decode(json_encode($file_content, JSON_UNESCAPED_UNICODE));

                $products = $products->concat($file_content->SHOPITEM);
            }
        }

        $products = $products->sortBy('PRICE');

        return [
            'products' => $products->values()->take($count),
            'is_last' => $products->count() <= $count,
        ];
    }
}
