<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\ContractorDocumentsTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\ContractorDocumentsTable Test Case
 */
class ContractorDocumentsTableTest extends TestCase
{

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.contractor_documents',
        'app.contractors',
        'app.created_user',
        'app.offices',
        'app.divisions',
        'app.districts',
        'app.zones',
        'app.item_rates',
        'app.updated_user',
        'app.designations',
        'app.users',
        'app.departments',
        'app.user_groups',
        'app.municipality',
        'app.upazila',
        'app.upazilas'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::exists('ContractorDocuments') ? [] : ['className' => 'App\Model\Table\ContractorDocumentsTable'];
        $this->ContractorDocuments = TableRegistry::get('ContractorDocuments', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->ContractorDocuments);

        parent::tearDown();
    }

    /**
     * Test initialize method
     *
     * @return void
     */
    public function testInitialize()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test validationDefault method
     *
     * @return void
     */
    public function testValidationDefault()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test buildRules method
     *
     * @return void
     */
    public function testBuildRules()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
