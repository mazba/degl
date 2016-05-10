<?php
namespace App\Model\Table;

use App\Model\Entity\WorkProgramSetup;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * WorkProgramSetups Model
 */
class WorkProgramSetupsTable extends Table
{

    /**
     * Initialize method
     *
     * @param array $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config)
    {
        $this->table('work_program_setups');
        $this->displayField('id');
        $this->primaryKey('id');
        $this->belongsTo('Schemes', [
            'foreignKey' => 'scheme_id',
            'joinType' => 'INNER'
        ]);
        $this->belongsTo('CreatedUser', [
            'className' => 'Users',
            'foreignKey' => 'created_by',
            'joinType' => 'INNER'
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
            ->requirePresence('item_code', 'create')
            ->notEmpty('item_code');
            
        $validator
            ->add('start_date', 'valid', ['rule' => 'numeric'])
            ->requirePresence('start_date', 'create')
            ->notEmpty('start_date');
            
        $validator
            ->add('end_date', 'valid', ['rule' => 'numeric'])
            ->requirePresence('end_date', 'create')
            ->notEmpty('end_date');
            
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
