<?php
namespace App\Model\Table;

use App\Model\Entity\Measurement;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Measurements Model
 */
class MeasurementsTable extends Table
{

    /**
     * Initialize method
     *
     * @param array $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config)
    {
        $this->table('measurements');
        $this->displayField('measurement_no');
        $this->primaryKey('id');
        $this->belongsTo('Schemes', [
            'foreignKey' => 'scheme_id',
            'joinType' => 'INNER'
        ]);
        $this->belongsTo('Items', [
            'foreignKey' => 'item_id',
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
            ->add('measurement_no', 'valid', ['rule' => 'numeric'])
            ->allowEmpty('measurement_no');
            
        $validator
            ->add('measurement_date', 'valid', ['rule' => 'numeric'])
            ->allowEmpty('measurement_date');
            
        $validator
            ->allowEmpty('measured-by');
            
        $validator
            ->add('quantity_of_work_done', 'valid', ['rule' => 'numeric'])
            ->requirePresence('quantity_of_work_done', 'create')
            ->notEmpty('quantity_of_work_done');
            
        $validator
            ->add('created_by', 'valid', ['rule' => 'numeric'])
            ->requirePresence('created_by', 'create')
            ->notEmpty('created_by');
            
        $validator
            ->add('created_date', 'valid', ['rule' => 'numeric'])
            ->requirePresence('created_date', 'create')
            ->notEmpty('created_date');
            
        $validator
            ->add('updated_by', 'valid', ['rule' => 'numeric'])
            ->allowEmpty('updated_by');
            
        $validator
            ->add('updated_date', 'valid', ['rule' => 'numeric'])
            ->allowEmpty('updated_date');
            
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
    //   $rules->add($rules->existsIn(['scheme_id'], 'Schemes'));
     //   $rules->add($rules->existsIn(['item_id'], 'Items'));
        return $rules;
    }
}
