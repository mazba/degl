<?php
namespace App\Model\Table;

use App\Model\Entity\LabTestFrequency;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * LabTestFrequency Model
 */
class LabTestFrequencyTable extends Table
{

    /**
     * Initialize method
     *
     * @param array $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config)
    {
        $this->table('lab_test_frequency');
        $this->displayField('id');
        $this->primaryKey('id');
        $this->belongsTo('LabTestGroup', [
            'foreignKey' => 'lab_test_group_id'
        ]);

        $this->belongsTo('LabTestLists', [
            'foreignKey' => 'lab_test_list_id'
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
            ->add('test_no', 'valid', ['rule' => 'numeric'])
            ->allowEmpty('test_no');
            
        $validator
            ->add('test_no_type', 'valid', ['rule' => 'numeric'])
            ->allowEmpty('test_no_type');
            
        $validator
            ->notEmpty('per_unit');
            
        $validator
            ->add('unit_type', 'valid', ['rule' => 'numeric'])
            ->allowEmpty('unit_type');
            
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
        $rules->add($rules->existsIn(['lab_test_group_id'], 'LabTestGroup'));
        $rules->add($rules->existsIn(['lab_test_list_id'], 'LabTestLists'));
        return $rules;
    }
}
