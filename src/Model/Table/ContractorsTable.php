<?php
namespace App\Model\Table;

use App\Model\Entity\Contractor;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Contractors Model
 */
class ContractorsTable extends Table
{

    /**
     * Initialize method
     *
     * @param array $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config)
    {
        $this->table('contractors');
        $this->displayField('contractor_title');
        $this->primaryKey('id');
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

        $this->addBehavior('FileUpload',['upload_path'=>'contractor_photo','field'=>'picture']);
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
            ->requirePresence('contractor_class_title', 'create')
            ->notEmpty('contractor_class_title');
            
        $validator
            ->requirePresence('contractor_title', 'create')
            ->notEmpty('contractor_title');
            
        $validator
            ->requirePresence('contact_person_name', 'create')
            ->notEmpty('contact_person_name');
            
        $validator
            ->requirePresence('contractor_phone', 'create')
            ->notEmpty('contractor_phone');
            
        $validator
            ->allowEmpty('contractor_email');
            
        $validator
            ->allowEmpty('contractor_address');
            
        $validator
            ->allowEmpty('mobile');
            
        $validator
            ->allowEmpty('fax');
            
        $validator
            ->allowEmpty('vat_no');
            
        $validator
            ->allowEmpty('tin_no');
            
        $validator
            ->allowEmpty('trade_licence_no');
            
        $validator
            ->add('status', 'valid', ['rule' => 'numeric'])
            ->allowEmpty('status');

        return $validator;
    }
}
