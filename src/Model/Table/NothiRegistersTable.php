<?php
namespace App\Model\Table;

use App\Model\Entity\NothiRegister;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * NothiRegisters Model
 */
class NothiRegistersTable extends Table
{

    /**
     * Initialize method
     *
     * @param array $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config)
    {
        $this->table('nothi_registers');
        $this->displayField('nothi_no');
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
        $this->belongsTo('NothiRegister', [
            'className' => 'NothiRegisters',
            'foreignKey' => 'parent_id',
            'joinType' => 'left'
        ]);
        
        $this->hasMany('ParentNothi', [
            'className' => 'NothiRegisters',
            'foreignKey' => 'parent_id',
            'joinType' => 'INNER'
        ]);

        $this->hasMany('NothiAssigns', [
            'foreignKey' => 'nothi_register_id'
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
            ->allowEmpty('nothi_description');
            
        $validator
            ->requirePresence('nothi_no','create');
            
        $validator
            ->add('nothi_date', 'valid', ['rule' => 'numeric'])
            ->allowEmpty('nothi_date');
            
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
        return $rules;
    }
}
