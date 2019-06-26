<?php

namespace App\Http\Controllers;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;
use Spatie\Async\Pool;
use \App\Models\Admin\Sale;
use \App\Models\Forms\Comuni;
use \App\Models\Forms\Province;
use \App\Models\Forms\Regioni;
use \App\Models\Forms\Stati;
use \App\Models\Forms\Categorie;

class FormsController extends Controller
{
    /**
     * Get agent details.
     */
    public function get_agent_details(){
        $agentDetails = Auth::user();
        return response()->json(['success' => true, 'agentdetails' => $agentDetails]);
    }

    /**
     * Get communes detail.
     */
   public function get_commune_details(Request $request){
    $province = $request->all()['value'];   
    $communes = Comuni::getAllComuni($province);
    return response()->json(['success' => true, 'communes' => $communes]);
   }


    /**
     * Get regions detail.
     */
    public function get_regions_details(){
        $regions = Regioni::getAllRegioni();
        return response()->json(['success' => true, 'regions' => $regions]);
       }


     /**
     * Get provinces detail.
     */
   public function get_provinces_details(Request $request){
    $region = $request->all()['value'];
    $provinces = Province::getAllProvince($region);
    return response()->json(['success' => true, 'provinces' => $provinces]);
   }   


     /**
     * Get all countries.
     */
   public function get_country_details(){
    $countries = Stati::getAllCountries();
    return response()->json(['success' => true, 'countries' => $countries]);
   }   


     /**
     * Get all categories.
     */
    public function get_all_categories(){
      $catagories = Categorie::getAllCatagories();
      return response()->json(['success' => true, 'catagories' => $catagories]);
     }   
}
