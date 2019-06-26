<?php

namespace App\Models\Forms;
use \App\Models\Forms\Regioni;

use Illuminate\Database\Eloquent\Model;


class Province extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'province';

    public static function getAllProvince($region)
    {
         $provinces = array();
         $regionId = Regioni::getRegionID($region);
         $results =  Province::select('sigla')->orderBy('sigla')->where(function ($query) use ($regionId) {
            $query->where('id_regione', '=', $regionId);
        })->get();
        foreach($results as $result){
            $provinces[] = $result->sigla;
        }
        return $provinces;  
    }
    

    public static function getProvinceId($province)
    {
        $regionid = Province::select('id')->where(function ($query) use ($province) {
            $query->where('sigla', '=', $province);
        })->first();
        return $regionid->id;

    }

    

}
