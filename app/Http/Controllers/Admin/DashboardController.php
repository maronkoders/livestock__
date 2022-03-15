<?php

namespace App\Http\Controllers\Admin;

use App\Company;
use App\CompanySelectionCount;
use App\Http\Controllers\Controller;
use App\Industry;
use App\Manufacturer;
use App\NewsLetterSubscriber;
use App\Product;
use App\ProductCategory;
use App\Traits\ServerResponse;
use App\Traits\ViewHandler;
use App\Visitor;
use Illuminate\Http\Request;

class DashboardController extends Controller
{   

    use ServerResponse;
    public function index(Request $request)
    {
        return view('dashboard.master');
    }

    public function __construct()
    {
        $this->company = new Company();
        $this->product  = new Product();
        $this->industry  = new Industry();
        $this->category   = new ProductCategory();
        $this->subscribers = new NewsLetterSubscriber();
        $this->visitors = new Visitor();
        $this->company_selection = new CompanySelectionCount();
        $this->manufacturer    = new Manufacturer();
    }

    public function processAllRequests(Request $request)
    {
        $productsCategories = [];
        foreach($this->product::all() as  $item)
        {
            $productsCategories[] = $item['product_category_id'];
        }

        $totalProducts = array_unique($productsCategories);

        $industries  = $this->industry::all();
        $companies  = $this->company::all();
        $categories = $this->category::all();
        $subscribers = $this->subscribers::all();
        $visitors = $this->visitors::all();



        $data =  [
            'products' =>[
                "total_products" => count($totalProducts)
            ],
            'companies' =>[
                'total_companies' => count($companies), 
                'companies' => $companies
            ],

            'industries' => [
                'total_industries' => count($industries),
                'industries' => $industries
            ],

            'categories' => [
                'total_categories' =>  count($categories),
                'categories' => $categories
            ] ,
            'subscribers' => [
                'total_subscribers' =>  count($subscribers),
                'subscribers' => $subscribers
            ],
            'visitors' => [
                'total_visitors' =>  count($visitors),
                'visitors' => $visitors
            ],
            'manufacturers' =>[
                'total_manufacturers' => count($this->manufacturer::all()),
            ]


            
        ];
        return $this->success(200,"Records retrieved",null, $data );
    }


    public function getDailyVisitors(Request $request)
    {
        try{
            $allVisitors =  $this->visitors::all();
            return $this->success(200, "Total visitors",null,$allVisitors);
        }catch(\Exception $th)
        {
            return $this->failure(500, "failed to get visitors", $th->getMessage());
        } 
    }

    public function getCompanyProductSelection(Request $request)
    {
        try{
             $data = $this->company_selection::where('company_id', $request->company_id)->get();
            return $this->success(200, "Total selection",null,$data);
        }catch(\Exception $th)
        {
            return $this->failure(500, "failed to get visitors", $th->getMessage());
        }   
    }
}
