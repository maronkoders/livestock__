<?php

namespace App;

use App\Traits\RequestHandler;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Company extends Model
{
    use RequestHandler, SoftDeletes;
    
    protected $fillable = ['name','industry_id','logo_path','site_link'];
    protected $with = ['company_selection_count'];

    public function processRequest($request)
    {
        return $this->handleIncomingRequest($this, $request);
    }
    public function industry()
    {
       //return $this->belongsTo(Industry::class);
    }

    public function company_selection_count()
    {
        return $this->hasMany(CompanySelectionCount::class,'company_id','id');
    }

    public function product()
    {
         return $this->hasMany(Product::class);
    }
}
