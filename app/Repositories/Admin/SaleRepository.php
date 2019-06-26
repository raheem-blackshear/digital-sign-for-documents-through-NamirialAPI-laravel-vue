<?php

namespace App\Repositories\Admin;

use App\Models\Admin\Sale;
use InfyOm\Generator\Common\BaseRepository;

/**
 * Class SaleRepository
 * @package App\Repositories\Admin
 * @version September 28, 2018, 1:52 pm UTC
 *
 * @method Sale findWithoutFail($id, $columns = ['*'])
 * @method Sale find($id, $columns = ['*'])
 * @method Sale first($columns = ['*'])
*/
class SaleRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'age',
        'packageType',
        'price',
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

    /**
     * Configure the Model
     **/
    public function model()
    {
        return Sale::class;
    }
}
