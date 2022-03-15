<?php

namespace App;

use App\Traits\RequestHandler;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProductCategory extends Model
{
    use RequestHandler, SoftDeletes;
    protected $fillable = ['name','slug','industry_id','sku_id'];

    protected $with = ['sku'];

    
    public function processRequest($request)
    {
        return $this->handleIncomingRequest($this, $request);
    }

    public function product()
    {
         return $this->hasMany(Product::class);
    }

    public function sku()
    {
        return $this->belongsTo(Sku::class);
    }

}
