<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function __construct()
    { 
      $this->product = new Product();
    }

    public function processAllRequests(Request $request)
    {
      return $this->dbOperations($this->product, $request);    
    }
}

