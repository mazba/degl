<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * IssueCompletionCertificate Entity.
 */
class IssueCompletionCertificate extends Entity
{

    /**
     * Fields that can be mass assigned using newEntity() or patchEntity().
     *
     * @var array
     */
    protected $_accessible = [
        'scheme_id' => true,
        'work_assessment' => true,
        'issue_date' => true,
        'created_by' => true,
        'created_date' => true,
        'status' => true,
        'scheme' => true,
        'created_user' => true,
        'updated_user' => true,
    ];
}
