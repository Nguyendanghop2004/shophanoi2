<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ShopCollectionController extends Controller
{
    public function index()
    {
            return view('client.shop-collection');
    }
}
