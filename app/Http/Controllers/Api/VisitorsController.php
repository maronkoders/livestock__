<?php

namespace App\Http\Controllers\Api;

use App\CompanySelectionCount;
use App\Http\Controllers\Controller;
use App\ProductSelectionCount;
use App\Traits\VisitorHandler;
use App\Visitor;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;

class VisitorsController extends Controller
{
    use VisitorHandler;
    public function __construct()
    { 
        $this->visit = new Visitor();
        $this->company = new CompanySelectionCount();
        $this->product = new ProductSelectionCount();
        $this->today =  Carbon::now('Africa/Harare');
    }

    private function iterateData($data, $visitor, $date, $columnName, $model)
    {
        foreach($data as $item)
        {
            $model::create([$columnName =>$item['id'],'visitor_id'=>$visitor->id,'date'=>$date]);
        }
    }

    private function saveDetails($data, $visitor, $date)
    {
        if(count($data) > 0)
        {
            foreach($data as $product)
            {
                $this->iterateData($product, $visitor, $date, "product_attribute_id", $this->product);
            }
        }
    }

    public function processAllRequests(Request $request)
    {
        $visitor = $this->visitorDetails();
        if(!empty($visitor))
        {
            try{    
                $this->saveDetails($request->products, $visitor, $this->today);
              // $this->saveCompanyDetails($request->companies, $visitor, $today);
               return response()->json(["status"=>201 ,"message"=>  "data was saved","optional_data"=>[]]);
            }catch(Exception $th)
            {
                return response()->json(["status"=>500,"message"=> "Failed to create a record", "optional_data"=> $th->getMessage()]);
            }
        }
    }
}
