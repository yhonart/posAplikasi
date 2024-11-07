<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class tmpUploadPrd extends Model
{
    use HasFactory;

    protected $table = "temp_uploadPrd";

    protected $fillable = [
        'prd_code',
        'prd_name',
        'prd_category',
        'prd_brand',
        'volB',
        'volK',
        'volKonv',
        'price_orderB',
        'price_orderK',
        'price_orderKonv',
        'sell_orderB',
        'sell_orderK',
        'sell_orderKonv',
        'status'
    ];
}
