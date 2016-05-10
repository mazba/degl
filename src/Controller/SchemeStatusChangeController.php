<?php
/**
 * Created by Rana ranabd36@gmail.com.
 * Date: 04-02-16
 * Time: 01.46
 */

namespace App\Controller;


class SchemeStatusChangeController extends AppController
{
    public function index()
    {
        $user = $this->Auth->user();
        $this->loadModel('Schemes');
        $schemes = $this->Schemes->find('list');
        $this->set('schemes', $schemes);
        $this->set('_serialize', ['schemes']);
    }

    public function status_change()
    {
        $inputs=$this->request->data();
        $this->loadModel('Schemes');
        $scheme=$this->Schemes->get($inputs['scheme_id']);
        $data['status']=$inputs['status'];
        $scheme=$this->Schemes->patchEntity($scheme,$data);
        if($this->Schemes->save($scheme))
        {
            $this->Flash->success(__('The scheme status has been changed'));
            return $this->redirect(['action' => 'index']);
        }else {
            $this->Flash->error(__('The scheme status could not be changed. Please, try again.'));
        }
    }
}