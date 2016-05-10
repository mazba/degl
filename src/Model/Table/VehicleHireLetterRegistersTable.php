<?php
namespace App\Model\Table;

use App\Model\Entity\VehicleHireLetterRegister;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * VehicleHireLetterRegisters Model
 */
class VehicleHireLetterRegistersTable extends Table
{

    /**
     * Initialize method
     *
     * @param array $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config)
    {
        $this->table('vehicle_hire_letter_registers');
        $this->displayField('id');
        $this->primaryKey('id');
        $this->belongsTo('Schemes', [
            'foreignKey' => 'scheme_id'
        ]);
        $this->belongsTo('Offices', [
            'foreignKey' => 'sender_office'
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
            
//        $validator
//            ->requirePresence('letter_no', 'create')
//            ->notEmpty('letter_no');
            
        $validator
            ->allowEmpty('sarok_no');

        $validator
            ->allowEmpty('subject');
            
        $validator
            ->add('sender_office', 'valid', ['rule' => 'numeric'])
            ->allowEmpty('sender_office');
            
        $validator
            ->add('receive_office', 'valid', ['rule' => 'numeric'])
            ->requirePresence('receive_office', 'create')
            ->notEmpty('receive_office');
            
        $validator
            ->add('receive_date', 'valid', ['rule' => 'numeric'])
            ->requirePresence('receive_date', 'create')
            ->notEmpty('receive_date');
            
        $validator
            ->allowEmpty('client_name');
            
        $validator
            ->allowEmpty('client_phone');
            
        $validator
            ->allowEmpty('client_email');
            
        $validator
            ->allowEmpty('client_fax');
            
        $validator
            ->allowEmpty('work_description');
            
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
        $rules->add($rules->existsIn(['scheme_id'], 'Schemes'));
        return $rules;
    }
}
