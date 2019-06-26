<?php

namespace App\Models\Forms;

use Illuminate\Database\Eloquent\Model;

class Categorie extends Model
{
        /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'Categorie';

    public static function getAllCatagories()
    {
       
        $catagories = array(); 
        $results = Categorie::orderBy('Nome')->get();
        foreach($results as $result){
            $catagories[] = $result->Nome;
        }
        return  $catagories;   

    }
}
