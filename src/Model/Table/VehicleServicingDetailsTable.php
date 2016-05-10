<?php
namespace App\Model\Table;

use App\Model\Entity\VehicleServicingDetail;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * VehicleServicingDetails Model
 */
class VehicleServicingDetailsTable extends Table
{

    /**
     * Initialize method
     *
     * @param array $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config)
    {
        $this->table('vehicle_servicing_details');
        $this->displayField('name');
        $this->primaryKey('id');
        $this->belongsTo('VehicleServicings', [
            'foreignKey' => 'vehicle_servicing_id'
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
            ->allowEmpty('name');
            
        $validator
            ->add('quantity', 'valid', ['rule' => 'numeric'])
            ->allowEmpty('quantity');
            
        $validator
            ->add('rate', 'valid', ['rule' => 'numeric'])
            ->allowEmpty('rate');
            
        $validator
            ->add('total', 'valid', ['rule' => 'numeric'])
            ->allowEmpty('total');
            
        $validator
            ->add('created_date', 'valid', ['rule' => 'numeric'])
            ->allowEmpty('created_date');
            
        $validator
            ->add('created_by', 'valid', ['rule' => 'numeric'])
            ->allowEmpty('created_by');
            
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
        $rules->add($rules->existsIn(['vehicle_servicing_id'], 'VehicleServicings'));
        return $rules;
    }
}
