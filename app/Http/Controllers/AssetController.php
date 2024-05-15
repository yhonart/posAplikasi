<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AssetController extends Controller
{
    public function AssetListIndex(){
        return view ('AssetManagement/Asset/AssetListIndex');
    }
}
