<?php
namespace App\Model\Table;

use App\Model\Entity\RaBillDetail;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * RaBillDetails Model
 */
class RaBillDetailsTable extends Table
{

    /**
     * Initialize method
     *
     * @param array $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config)
    {
        $this->table('ra_bill_details');
        $this->displayField('id');
        $this->primaryKey('id');
//        $this->belongsTo('RaBills', [
//            'foreignKey' => 'ra_bill_id',
//            'joinType' => 'INNER'
//        ]);
        $this->belongsTo('SchemeItems', [
            'foreignKey' => 'scheme_item_id',
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
            ->allowEmpty('short_description');
            
        $validator
            ->add('serial_number', 'valid', ['rule' => 'numeric'])
            ->allowEmpty('serial_number');

        return $validator;
    }

    /**
     * Returns a rules checker object that will be used for validating
     * application integrity.
     *
     * @param \Cake\ORM\RulesChecker $rules The rules object to be modified.
     * @return \Cake\ORM\RulesChecker
     */
//    public function buildRules(RulesChecker $rules)
//    {
//      //  $rules->add($rules->existsIn(['ra_bill_id'], 'RaBills'));
//       // $rules->add($rules->existsIn(['scheme_item_id'], 'SchemeItems'));
//        return $rules;
//    }
}
