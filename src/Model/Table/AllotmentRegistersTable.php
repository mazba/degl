<?php
namespace App\Model\Table;

use App\Model\Entity\AllotmentRegister;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * AllotmentRegisters Model
 */
class AllotmentRegistersTable extends Table
{

    /**
     * Initialize method
     *
     * @param array $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config)
    {
        $this->table('allotment_registers');
        $this->displayField('id');
        $this->primaryKey('id');
        $this->belongsTo('Offices', [
            'foreignKey' => 'office_id',
            'joinType' => 'INNER'
        ]);
        $this->belongsTo('Projects', [
            'foreignKey' => 'project_id'
        ]);
        $this->belongsTo('Schemes', [
            'foreignKey' => 'scheme_id'
        ]);
        $this->belongsTo('PurtoBills', [
            'foreignKey' => 'purto_bill_id'
        ]);
        $this->belongsTo('CreatedUser', [
            'className' => 'Users',
            'foreignKey' => 'created_by',
            'joinType' => 'INNER'
        ]);
        $this->belongsTo('UpdatedUser', [
            'className' => 'Users',
            'foreignKey' => 'updated_by',
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
        $validator
            ->add('id', 'valid', ['rule' => 'numeric'])
            ->allowEmpty('id', 'create');
            
        $validator
            ->requirePresence('dr_cr', 'create')
            ->notEmpty('dr_cr');
            
        $validator
            ->add('memo_no', 'valid', ['rule' => 'numeric'])
            ->allowEmpty('memo_no');
            
        $validator
            ->add('allotment_date', 'valid', ['rule' => 'numeric'])
            ->allowEmpty('allotment_date');
            
        $validator
            ->allowEmpty('particulars');
            
        $validator
            ->add('allotment_amount', 'valid', ['rule' => 'numeric'])
            ->allowEmpty('allotment_amount');
            
        $validator
            ->allowEmpty('remarks');
            
        $validator
            ->add('status', 'valid', ['rule' => 'numeric'])
            ->allowEmpty('status');

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
        $rules->add($rules->existsIn(['office_id'], 'Offices'));
        $rules->add($rules->existsIn(['project_id'], 'Projects'));
        $rules->add($rules->existsIn(['scheme_id'], 'Schemes'));
        $rules->add($rules->existsIn(['purto_bill_id'], 'PurtoBills'));
        return $rules;
    }
}
