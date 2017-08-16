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
use Cake\Datasource\ConnectionManager;
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
class ProjectOverviewController extends AppController
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

        $conn = ConnectionManager::get('default');
        $sql="SELECT pro.id project_id, scm.id scheme_id,pro.name_bn as project ,
                sc_prog.progress_value,
                count(CASE WHEN progress_value BETWEEN 0 AND 20 THEN 1 END) as 0to20,
                count(CASE WHEN progress_value BETWEEN 21 AND 30 THEN 1 END) as 21to30,
                count(CASE WHEN progress_value BETWEEN 31 AND 40 THEN 1 END) as 31to40,
                count(CASE WHEN progress_value BETWEEN 41 AND 50 THEN 1 END) as 41to50,
                count(CASE WHEN progress_value BETWEEN 51 AND 60 THEN 1 END) as 51to60,
                count(CASE WHEN progress_value BETWEEN 61 AND 70 THEN 1 END) as 61to70,
                count(CASE WHEN progress_value BETWEEN 71 AND 80 THEN 1 END) as 71to80,
                count(CASE WHEN progress_value BETWEEN 81 AND 90 THEN 1 END) as 81to90,
                count(CASE WHEN progress_value BETWEEN 90 AND 100 THEN 1 END) as 91to100
                FROM `projects` pro
                LEFT JOIN `schemes` scm on scm.project_id = pro.id
                LEFT JOIN `scheme_progresses` sc_prog on sc_prog.scheme_id = scm.id
                WHERE sc_prog.status = 1
                GROUP BY pro.id";
        $query = $conn->execute($sql);
        $results = $query->fetchAll('assoc');
        $this->set(compact('results'));
    }
}
