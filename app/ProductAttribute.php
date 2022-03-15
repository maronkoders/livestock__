<?php

namespace App;

use App\Traits\RequestHandler;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProductAttribute extends Model
{
    use RequestHandler,SoftDeletes;
    
    protected $fillable = ['description','discount','price','tax','company_id','product_id','is_show','manufacturer_id','manufacturer_report_enabled','sku_id'];
   //protected $with = ['product'];

    public function processRequest($request)
    {       
        return $this->handleIncomingRequest($this, $request);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
