<?php
namespace App\Model\Table;

use App\Model\Entity\LabBill;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * LabBills Model
 */
class LabBillsTable extends Table
{

    /**
     * Initialize method
     *
     * @param array $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config)
    {
        $this->table('lab_bills');
        $this->displayField('id');
        $this->primaryKey('id');

        $this->hasMany('LabBillDetails', [
            'foreignKey' => 'lab_bill_id',
            'joinType' => 'LEFT'
        ]);

    }

    /**
     * Default validation rules.
     *
     * @param \Cake\Validation\Validator $validator Validator instance.
     * @return \Cake\Validation\Validator
     */
    public function validationDefault(Validator $validator)
    {


        return $validator;
    }


}
