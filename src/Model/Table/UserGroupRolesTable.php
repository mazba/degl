<?php
namespace App\Model\Table;

use App\Model\Entity\UserGroupRole;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * UserGroupRoles Model
 */
class UserGroupRolesTable extends Table
{

    /**
     * Initialize method
     *
     * @param array $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config)
    {
        $this->table('user_group_roles');
        $this->displayField('id');
        $this->primaryKey('id');
        $this->belongsTo('UserGroups', [
            'foreignKey' => 'user_group_id',
            'joinType' => 'INNER'
        ]);
        $this->belongsTo('Components', [
            'foreignKey' => 'component_id',
            'joinType' => 'INNER'
        ]);
        $this->belongsTo('Modules', [
            'foreignKey' => 'module_id',
            'joinType' => 'INNER'
        ]);
        $this->belongsTo('Tasks', [
            'foreignKey' => 'task_id',
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
            ->add('task_index', 'valid', ['rule' => 'numeric'])
            ->requirePresence('task_index', 'create')
            ->notEmpty('task_index');
            
        $validator
            ->add('task_view', 'valid', ['rule' => 'numeric'])
            ->requirePresence('task_view', 'create')
            ->notEmpty('task_view');
            
        $validator
            ->add('task_add', 'valid', ['rule' => 'numeric'])
            ->requirePresence('task_add', 'create')
            ->notEmpty('task_add');
            
        $validator
            ->add('task_edit', 'valid', ['rule' => 'numeric'])
            ->requirePresence('task_edit', 'create')
            ->notEmpty('task_edit');
            
        $validator
            ->add('task_delete', 'valid', ['rule' => 'numeric'])
            ->requirePresence('task_delete', 'create')
            ->notEmpty('task_delete');
            
        $validator
            ->add('task_report', 'valid', ['rule' => 'numeric'])
            ->requirePresence('task_report', 'create')
            ->notEmpty('task_report');
            
        $validator
            ->add('task_print', 'valid', ['rule' => 'numeric'])
            ->requirePresence('task_print', 'create')
            ->notEmpty('task_print');
            
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
        $rules->add($rules->existsIn(['user_group_id'], 'UserGroups'));
        $rules->add($rules->existsIn(['component_id'], 'Components'));
        $rules->add($rules->existsIn(['module_id'], 'Modules'));
        $rules->add($rules->existsIn(['task_id'], 'Tasks'));
        return $rules;
    }
}
