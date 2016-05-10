<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\Core\Configure;

/**
 * IssueCompletionCertificate Controller
 *
 * @property \App\Model\Table\IssueCompletionCertificateTable $IssueCompletionCertificate
 */
class IssueCompletionCertificateController extends AppController
{

    /**
     * Index method
     *
     * @return void
     */
    public function index()
    {
        $user = $this->Auth->user();
        $this->loadModel('Schemes');
        $schemes = $this->Schemes->find('list')
            ->innerJoin('project_offices', 'project_offices.project_id = Schemes.project_id')
            ->leftJoin('projects', 'projects.id = Schemes.project_id')
            ->where(['project_offices.office_id' => $user['office_id']]);
        $this->set('schemes', $schemes);
    }

    public function ajax($action = '')
    {
        if($action == 'get_certificate')
        {
            $this->layout = 'ajax';
            $this->view = 'certificate';
            $input = $this->request->data;
            $this->loadModel('Schemes');
            $scheme = $this->Schemes->find()
                ->autoFields(true)
                ->select(['projects.name_bn','contractors.contractor_title','development_partners.name_bn'])
                ->where(['Schemes.id'=>$input['scheme_id']])
                ->leftJoin('projects','projects.id = Schemes.project_id')
                ->leftJoin('scheme_contractors','scheme_contractors.scheme_id = Schemes.id')
                ->leftJoin('contractors','contractors.id = scheme_contractors.contractor_id')
                ->leftJoin('development_partners','development_partners.id = projects.development_partner_id')
                ->first();
//            echo '<pre>';
//            print_r($scheme);
//            echo '</pre>';
//            die;
            $this->set(compact('scheme'));
        }
    }
}
