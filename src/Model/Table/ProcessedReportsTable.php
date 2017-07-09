<?php
namespace App\Model\Table;

use App\Model\Entity\ProcessedReport;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * ProcessedReports Model
 */
class ProcessedReportsTable extends Table
{

    /**
     * Initialize method
     *
     * @param array $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config)
    {
        $this->table('processed_reports');
        $this->displayField('id');
        $this->primaryKey('id');

        $this->belongsTo('ProcessedRaBills', [
            'foreignKey' => 'scheme_id'
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
            ->allowEmpty('do_commencement');
            
        $validator
            ->allowEmpty('do_completion');
            
        $validator
            ->allowEmpty('edo_completion');
            
        $validator
            ->allowEmpty('ado_completion');
            
        $validator
            ->add('status', 'valid', ['rule' => 'numeric'])
            ->allowEmpty('status');
            
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
/*    public function buildRules(RulesChecker $rules)
    {
        $rules->add($rules->existsIn(['processed_ra_bill_id'], 'ProcessedRaBills'));
        $rules->add($rules->existsIn(['scheme_id'], 'Schemes'));
        return $rules;
    }*/
}
