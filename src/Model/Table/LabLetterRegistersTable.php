<?php
namespace App\Model\Table;

use App\Model\Entity\LabLetterRegister;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * LabLetterRegisters Model
 */
class LabLetterRegistersTable extends Table
{

    /**
     * Initialize method
     *
     * @param array $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config)
    {
        $this->table('lab_letter_registers');
        $this->displayField('subject');
        $this->primaryKey('id');
        $this->belongsTo('Offices', [
            'foreignKey' => 'office_id',
            'joinType' => 'INNER'
        ]);
        $this->belongsTo('Schemes', [
            'foreignKey' => 'scheme_id'
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
        $this->hasMany('LabActualTests', [
            'foreignKey' => 'lab_letter_registers_id',
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
            ->add('receive_date', 'valid', ['rule' => 'numeric'])
            ->requirePresence('receive_date', 'create')
            ->notEmpty('receive_date');
            
        $validator
            ->allowEmpty('letter_no');
            
        $validator
            ->allowEmpty('letter_date');
            
        $validator
            ->allowEmpty('client_name');
            
        $validator
            ->allowEmpty('client_designation');
            
        $validator
            ->allowEmpty('client_phone');
            
        $validator
            ->allowEmpty('client_email');
            
        $validator
            ->allowEmpty('client_address');
            
        $validator
            ->allowEmpty('work_description');
            
        $validator
            ->allowEmpty('subject');
            
        $validator
            ->allowEmpty('received_from');
            
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
        $rules->add($rules->existsIn(['scheme_id'], 'Schemes'));
        return $rules;
    }
}
