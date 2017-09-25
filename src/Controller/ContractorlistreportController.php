<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * Contractorlistreport Controller
 *
 * @property \App\Model\Table\ContractorlistreportTable $Contractorlistreport
 */
class ContractorlistreportController extends AppController
{

    /**
     * Index method
     *
     * @return void
     */
    public function index()
    {
        if ($this->request->is(['post'])) {
            $inputs = $this->request->data;
            $type = $inputs['contractor_type'];
            $this->loadModel('Contractors');
            $results = $this->Contractors->find()->select([
                'contact_person_name',
                'contractor_address',
                'mobile',
                'nid',
                'contractor_title',
            ])
                ->where(['status' => 1, 'contractor_type' => $type])
                ->hydrate(false)
                ->toArray();
            $this->set(compact('results', 'type'));

        }
    }


}
