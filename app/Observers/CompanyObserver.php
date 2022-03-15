<?php

namespace App\Observers;

use App\Company;

class CompanyObserver
{
    public function updating(Company $company)
    {    
        if(request()->is_default !=null)
        {
             $isDefault = $company::where('is_default',1)->first();
             if($isDefault !=null)
             {
                $company::where('id', $isDefault->id)->update(['is_default'=>0]);
             }
          
        }   
    }
}
