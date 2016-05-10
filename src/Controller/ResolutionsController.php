<?php
/**
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link      http://cakephp.org CakePHP(tm) Project
 * @since     0.2.9
 * @license   http://www.opensource.org/licenses/mit-license.php MIT License
 */
namespace App\Controller;

use Cake\Core\Configure;
use Cake\Network\Exception\NotFoundException;
use Cake\View\Exception\MissingTemplateException;
use Cake\ORM\TableRegistry;

/**
 * Static content controller
 *
 * This controller will render views from Template/Pages/
 *
 * @link http://book.cakephp.org/3.0/en/controllers/pages-controller.html
 */
class ResolutionsController extends AppController
{

    /**
     * Displays a view
     *
     * @return void|\Cake\Network\Response
     * @throws \Cake\Network\Exception\NotFoundException When the view file could not
     *   be found or \Cake\View\Exception\MissingTemplateException in debug mode.
     */

    public function index()
    {
        $this->loadModel('ReceiveFileRegisters');
        $files=$this->ReceiveFileRegisters->find('all',['conditions'=>['ReceiveFileRegisters.is_resolution'=>1],
            'order'=> ['ReceiveFileRegisters.created_date'=>'DESC']]);
        $this->set(compact('files'));
    }

    public function view($id = null)
    {
        $this->loadModel('ReceiveFileRegisters');
        $receiveFileRegister = $this->ReceiveFileRegisters->get($id, [
            'contain' => ['Projects', 'Schemes']
        ]);
        $files_table = TableRegistry::get('files');
        $query = $files_table->find();
        $query->where(['table_name'=>'receive_file_registers','table_key'=>$id]);
        $files=$query->toArray();
        $this->set('receiveFileRegister', $receiveFileRegister);
        $this->set('files', $files);
        $this->set('_serialize', ['receiveFileRegister']);
    }
}
