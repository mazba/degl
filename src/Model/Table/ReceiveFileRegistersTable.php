<?php
namespace App\Model\Table;

use App\Model\Entity\ReceiveFileRegister;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * ReceiveFileRegisters Model
 */
class ReceiveFileRegistersTable extends Table
{

    /**
     * Initialize method
     *
     * @param array $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config)
    {
        $this->table('receive_file_registers');
        $this->displayField('id');
        $this->primaryKey('id');
        $this->belongsTo('Projects', [
            'foreignKey' => 'project_id'
        ]);
        $this->belongsTo('Schemes', [
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
            ->allowEmpty('letter_no');
            
        $validator
            ->add('letter_date', 'valid', ['rule' => 'numeric'])
            ->allowEmpty('letter_date');
            
        $validator
            ->allowEmpty('sarok_no');
            
        $validator
            ->allowEmpty('subject');
            
        $validator
            ->add('receive_date', 'valid', ['rule' => 'numeric'])
            ->allowEmpty('receive_date');
            
        $validator
            ->allowEmpty('sender_address');
            
        $validator
            ->allowEmpty('sender_office_name');
            
        $validator
            ->add('sender_office', 'valid', ['rule' => 'numeric'])
            ->allowEmpty('sender_office');
            
        $validator
            ->add('receive_office', 'valid', ['rule' => 'numeric'])
            ->allowEmpty('receive_office');
            
        $validator
            ->allowEmpty('letter_type');
            
        $validator
            ->allowEmpty('letter_nature');
            
        $validator
            ->allowEmpty('sender_name');
            
        $validator
            ->allowEmpty('sender_designation');
            
        $validator
            ->allowEmpty('sender_phone');
            
        $validator
            ->allowEmpty('sender_email');
            
        $validator
            ->allowEmpty('sender_fax');
            
        $validator
            ->add('is_urgent', 'valid', ['rule' => 'numeric'])
            ->allowEmpty('is_urgent');
            
        $validator
            ->add('is_answer_required', 'valid', ['rule' => 'numeric'])
            ->allowEmpty('is_answer_required');
            
        $validator
            ->add('answer_date', 'valid', ['rule' => 'numeric'])
            ->allowEmpty('answer_date');
            
        $validator
            ->add('is_guard_file', 'valid', ['rule' => 'numeric'])
            ->allowEmpty('is_guard_file');
            
        $validator
            ->add('parent_letter', 'valid', ['rule' => 'numeric'])
            ->allowEmpty('parent_letter');
            
        $validator
            ->add('receive_user', 'valid', ['rule' => 'numeric'])
            ->allowEmpty('receive_user');
            
        $validator
            ->allowEmpty('receive_department');
            
        $validator
            ->add('is_hardcopy_attached', 'valid', ['rule' => 'numeric'])
            ->allowEmpty('is_hardcopy_attached');
            
        $validator
            ->add('number_of_pages', 'valid', ['rule' => 'numeric'])
            ->allowEmpty('number_of_pages');
            
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
        $rules->add($rules->existsIn(['project_id'], 'Projects'));
        $rules->add($rules->existsIn(['scheme_id'], 'Schemes'));
        return $rules;
    }
}
