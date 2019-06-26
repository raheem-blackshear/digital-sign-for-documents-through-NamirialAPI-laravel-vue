<?php

namespace App\Models\Forms;
use \App\Models\Forms\Province;
use Illuminate\Database\Eloquent\Model;
class Comuni extends Model
{
   /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'comuni';
    
    public static function getAllComuni($province)
    {   
        $comuni = array();
        $provinceid = Province::getProvinceId($province);
        $comunes =  Comuni::select('comune')->orderBy('comune')->where(function ($query) use ($provinceid) {
            $query->where('id_provincia', '=', $provinceid);
        })->get();
        foreach($comunes as $comune){
            $comuni[] = $comune->comune;
        }
        return $comuni;

    }

}
