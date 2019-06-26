<?php

namespace App\Models\Forms;

use Illuminate\Database\Eloquent\Model;

class Stati extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'stati';

    public static function getAllCountries()
    {
       
        $countries = array(); 
        $results = Stati::orderBy('nome_stati')->get();
        foreach($results as $result){
            $countries[] = $result->nome_stati;
        }
        return $countries;   

    }

}
