<?php
namespace App\Model\Table;

use App\Model\Entity\LabBillDetail;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * LabBillDetails Model
 */
class LabBillDetailsTable extends Table
{

    /**
     * Initialize method
     *
     * @param array $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config)
    {
        $this->table('lab_bill_details');
        $this->displayField('id');
        $this->primaryKey('id');
        $this->belongsTo('LabBills', [
            'foreignKey' => 'lab_bill_id'
        ]);
        $this->belongsTo('LabActualTests', [
            'foreignKey' => 'lab_actual_test_id'
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
        $validator
            ->add('id', 'valid', ['rule' => 'numeric'])
            ->allowEmpty('id', 'create');

        return $validator;
    }

    /**
     * Returns a rules checker object that will be used for validating
     * application integrity.
     *
     * @param \Cake\ORM\RulesChecker $rules The rules object to be modified.
     * @return \Cake\ORM\RulesChecker
     */
    public function buildRules(RulesChecker $rules)
    {
        $rules->add($rules->existsIn(['lab_bill_id'], 'LabBills'));
        $rules->add($rules->existsIn(['lab_actual_test_id'], 'LabActualTests'));
        return $rules;
    }
}
