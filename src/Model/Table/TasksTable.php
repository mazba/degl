<?php
namespace App\Model\Table;

use App\Model\Entity\Task;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Tasks Model
 */
class TasksTable extends Table
{

    /**
     * Initialize method
     *
     * @param array $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config)
    {
        $this->table('tasks');
        $this->displayField('name_en');
        $this->primaryKey('id');
        $this->belongsTo('Components', [
            'foreignKey' => 'component_id',
            'joinType' => 'INNER'
        ]);
        $this->belongsTo('Modules', [
            'foreignKey' => 'module_id',
            'joinType' => 'INNER'
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
            ->requirePresence('name_en', 'create')
            ->notEmpty('name_en');
            
        $validator
            ->requirePresence('name_bn', 'create')
            ->notEmpty('name_bn');
            
        $validator
            ->allowEmpty('description');
            
        $validator
            ->allowEmpty('icon');
            
        $validator
            ->requirePresence('controller', 'create')
            ->notEmpty('controller');
            
        $validator
            ->add('ordering', 'valid', ['rule' => 'numeric'])
            ->allowEmpty('ordering');
            
        $validator
            ->add('position_left', 'valid', ['rule' => 'numeric'])
            ->allowEmpty('position_left');
            
        $validator
            ->add('position_top', 'valid', ['rule' => 'numeric'])
            ->allowEmpty('position_top');
            
        $validator
            ->add('status', 'valid', ['rule' => 'numeric'])
            ->requirePresence('status', 'create')
            ->notEmpty('status');

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


        $rules->add($rules->isUnique(['name_en']));
        $rules->add($rules->isUnique(['name_bn']));
        $rules->add($rules->isUnique(['controller']));
        $rules->add($rules->existsIn(['component_id'], 'Components'));
        //$rules->add($rules->existsIn(['module_id'], 'Modules'));
        return $rules;
    }
}
