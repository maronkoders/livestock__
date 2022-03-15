<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\NewsLetterSubscriber;
use Illuminate\Http\Request;

class NewsletterController extends Controller
{
    public function __construct()
    { 
        $this->news_letter = new NewsLetterSubscriber();
    }
    
    public function processAllRequests(Request $request)
    {
        return $this->dbOperations($this->news_letter, $request);
    }
}
