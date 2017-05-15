<?php
namespace App\Model\Table;

use App\Model\Entity\File;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Files Model
 */
class FilesTable extends Table
{

    /**
     * Initialize method
     *
     * @param array $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config)
    {
        $this->table('files');
        $this->displayField('id');
        $this->primaryKey('id');
    }

    /**
     * Default validation rules.
     *
     * @param \Cake\Validation\Validator $validator Validator instance.
     * @return \Cake\Validation\Validator
     */
    public function validationDefault(Validator $validator)
    {
//        $validator
//            ->add('id', 'valid', ['rule' => 'numeric'])
//            ->allowEmpty('id', 'create');
//
//        $validator
//            ->requirePresence('file_path', 'create')
//            ->notEmpty('file_path');
//
//        $validator
//            ->allowEmpty('file_label');
//
//        $validator
//            ->requirePresence('table_name', 'create')
//            ->notEmpty('table_name');
//
//        $validator
//            ->add('table_key', 'valid', ['rule' => 'numeric'])
//            ->requirePresence('table_key', 'create')
//            ->notEmpty('table_key');
//
//        $validator
//            ->add('created_by', 'valid', ['rule' => 'numeric'])
//            ->requirePresence('created_by', 'create')
//            ->notEmpty('created_by');
//
//        $validator
//            ->add('created_date', 'valid', ['rule' => 'numeric'])
//            ->requirePresence('created_date', 'create')
//            ->notEmpty('created_date');
//
//        $validator
//            ->add('updated_by', 'valid', ['rule' => 'numeric'])
//            ->allowEmpty('updated_by');
//
//        $validator
//            ->add('updated_date', 'valid', ['rule' => 'numeric'])
//            ->allowEmpty('updated_date');
//
//        $validator
//            ->add('status', 'valid', ['rule' => 'numeric'])
//            ->allowEmpty('status');

        return $validator;
    }
}
