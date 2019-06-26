<?php

namespace App\Models\Admin;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Sale
 * @package App\Models\Admin
 * @version September 28, 2018, 1:52 pm UTC
 *
 * @property \Illuminate\Database\Eloquent\Collection roleHasPermissions
 * @property integer age
 * @property integer packageType
 * @property integer price
 * @property integer seller_id
 * @property string contractorType
 * @property string contractorFirstName
 * @property string contractorLastName
 * @property string contractorAddress
 * @property string contractorTaxCode
 * @property string contractorBirthday
 * @property string contractorBirthPlace
 * @property string contractorEmail
 * @property string contractorTelephone
 * @property string insuredType
 * @property string insuredFirstName
 * @property string insuredLastName
 * @property string insuredAddress
 * @property string insuredTaxCode
 * @property string insuredBirthday
 * @property string insuredBirthPlace
 * @property string insuredEmail
 * @property string insuredTelephone
 * @property string deathBenType
 * @property string deathBenFirstName
 * @property string deathBenLastName
 * @property string deathBenAddress
 * @property string deathBenTaxCode
 * @property string deathBenBirthday
 * @property string deathBenBirthPlace
 * @property string deathBenEmail
 * @property string deathBenTelephone
 * @property string receiveEmail
 */
class Sale extends Model
{
    use SoftDeletes;

    public $table = 'sales';

    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';


    protected $dates = ['deleted_at'];

    protected $guarded = [];
/*
    public $fillable = [
        'age',
        'packageType',
        'price',
        'seller_id',
        'contractorType',
        'contractorFirstName',
        'contractorLastName',
        'contractorAddress',
        'contractorTaxCode',
        'contractorBirthday',
        'contractorBirthPlace',
        'contractorEmail',
        'contractorTelephone',
        'insuredType',
        'insuredFirstName',
        'insuredLastName',
        'insuredAddress',
        'insuredTaxCode',
        'insuredBirthday',
        'insuredBirthPlace',
        'insuredEmail',
        'insuredTelephone',
        'deathBenType',
        'deathBenFirstName',
        'deathBenLastName',
        'deathBenAddress',
        'deathBenTaxCode',
        'deathBenBirthday',
        'deathBenBirthPlace',
        'deathBenEmail',
        'deathBenTelephone',
        'receiveEmail'
    ];
*/
    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    /*
    protected $casts = [
        'id' => 'integer',
        'age' => 'integer',
        'packageType' => 'integer',
        'price' => 'integer',
        'seller_id' => 'integer',
        'contractorType' => 'string',
        'contractorFirstName' => 'string',
        'contractorLastName' => 'string',
        'contractorAddress' => 'string',
        'contractorTaxCode' => 'string',
        'contractorBirthday' => 'string',
        'contractorBirthPlace' => 'string',
        'contractorEmail' => 'string',
        'contractorTelephone' => 'string',
        'insuredType' => 'string',
        'insuredFirstName' => 'string',
        'insuredLastName' => 'string',
        'insuredAddress' => 'string',
        'insuredTaxCode' => 'string',
        'insuredBirthday' => 'string',
        'insuredBirthPlace' => 'string',
        'insuredEmail' => 'string',
        'insuredTelephone' => 'string',
        'deathBenType' => 'string',
        'deathBenFirstName' => 'string',
        'deathBenLastName' => 'string',
        'deathBenAddress' => 'string',
        'deathBenTaxCode' => 'string',
        'deathBenBirthday' => 'string',
        'deathBenBirthPlace' => 'string',
        'deathBenEmail' => 'string',
        'deathBenTelephone' => 'string',
        'receiveEmail' => 'string'
    ];
*/
    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [

    ];

    public function seller()
    {
        return $this->belongsTo('\App\User');
    }



}
