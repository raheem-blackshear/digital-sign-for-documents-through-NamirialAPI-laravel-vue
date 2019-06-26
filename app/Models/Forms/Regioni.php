<?php

namespace App\Models\Forms;

use Illuminate\Database\Eloquent\Model;

class Regioni extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'regioni';

    public static function getAllRegioni()
    {
       
        $regioni = array(); 
        $results = Regioni::orderBy('regione')->get();
        foreach($results as $result){
            $regioni[] = $result->regione;
        }
        return $regioni;   

    }

    public static function getRegionID($region)
    {
        $regionid = Regioni::select('id')->where(function ($query) use ($region) {
            $query->where('regione', '=', $region);
        })->first();
        return $regionid->id;   

    }

}
