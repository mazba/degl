<?php
namespace App\Model\Table;

use App\Model\Entity\ProjectIncomeExpense;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * ProjectIncomeExpenses Model
 */
class ProjectIncomeExpensesTable extends Table
{

    /**
     * Initialize method
     *
     * @param array $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config)
    {
        $this->table('project_income_expenses');
        $this->displayField('id');
        $this->primaryKey('id');
        $this->belongsTo('Projects', [
            'foreignKey' => 'project_id',
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
            ->add('receive_money', 'valid', ['rule' => 'numeric'])
            ->allowEmpty('receive_money');
            
        $validator
            ->add('expense_money', 'valid', ['rule' => 'numeric'])
            ->allowEmpty('expense_money');
            
        $validator
            ->add('unpaid_money', 'valid', ['rule' => 'numeric'])
            ->allowEmpty('unpaid_money');
            
        $validator
            ->allowEmpty('month');
            
        $validator
            ->add('year', 'valid', ['rule' => 'numeric'])
            ->allowEmpty('year');
            
        $validator
            ->add('status', 'valid', ['rule' => 'numeric'])
            ->requirePresence('status', 'create')
            ->notEmpty('status');
            
        $validator
            ->add('created_by', 'valid', ['rule' => 'numeric'])
            ->allowEmpty('created_by');

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
        $rules->add($rules->existsIn(['project_id'], 'Projects'));
        return $rules;
    }
}
