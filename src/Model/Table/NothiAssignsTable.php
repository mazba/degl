<?php
namespace App\Model\Table;

use App\Model\Entity\NothiAssign;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * NothiAssigns Model
 */
class NothiAssignsTable extends Table
{

    /**
     * Initialize method
     *
     * @param array $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config)
    {
        $this->table('nothi_assigns');
        $this->displayField('id');
        $this->primaryKey('id');


        $this->belongsTo('NothiRegisters', [
            'foreignKey' => 'nothi_register_id'
        ]);
        $this->belongsTo('ReceiveFileRegisters', [
            'foreignKey' => 'receive_file_register_id'
        ]);
        $this->belongsTo('Schemes', [
            'foreignKey' => 'scheme_id'
        ]);
        $this->belongsTo('Projects', [
            'foreignKey' => 'project_id'
        ]);
        $this->belongsTo('LabBills', [
            'foreignKey' => 'lab_bill_id'
        ]);
        $this->belongsTo('HireCharges', [
            'foreignKey' => 'hire_charge_id'
        ]);
        $this->belongsTo('PurtoBills', [
            'foreignKey' => 'purto_bill_id'
        ]);
        $this->belongsTo('AllotmentRegisters', [
            'foreignKey' => 'allotment_register_id'
        ]);

        $this->belongsTo('Employees', [
            'foreignKey' => 'employee_id'
        ]);

        $this->belongsTo('Assets', [
            'foreignKey' => 'asset_id'
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
        $rules->add($rules->existsIn(['nothi_register_id'], 'NothiRegisters'));
        $rules->add($rules->existsIn(['receive_file_register_id'], 'ReceiveFileRegisters'));
        $rules->add($rules->existsIn(['scheme_id'], 'Schemes'));
        $rules->add($rules->existsIn(['project_id'], 'Projects'));
        $rules->add($rules->existsIn(['lab_bill_id'], 'LabBills'));
        $rules->add($rules->existsIn(['hire_charge_id'], 'HireCharges'));
        $rules->add($rules->existsIn(['purto_bill_id'], 'PurtoBills'));
        $rules->add($rules->existsIn(['allotment_register_id'], 'AllotmentRegisters'));
        return $rules;
    }
}
