<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\SchemePayordersTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\SchemePayordersTable Test Case
 */
class SchemePayordersTableTest extends TestCase
{

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.scheme_payorders',
        'app.schemes',
        'app.projects',
        'app.development_partners',
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
        'app.upazilas',
        'app.receive_file_registers',
        'app.letter_approvals',
        'app.letter_issue_registers',
        'app.nothi_registers',
        'app.nothi_assigns',
        'app.lab_bills',
        'app.lab_bill_details',
        'app.lab_actual_tests',
        'app.lab_letter_registers',
        'app.hire_charges',
        'app.contractors',
        'app.financial_year_estimates',
        'app.scheme_revisions',
        'app.hire_charge_details',
        'app.purto_bills',
        'app.allotment_registers',
        'app.employees',
        'app.assign_vehicles',
        'app.vehicles',
        'app.vehicles_status',
        'app.assets',
        'app.message_registers',
        'app.recipients',
        'app.files',
        'app.sector',
        'app.packages',
        'app.work_types',
        'app.work_sub_types',
        'app.municipalities',
        'app.multimedia',
        'app.scheme_details',
        'app.items',
        'app.chapters',
        'app.scheme_amounts',
        'app.scheme_item_breakups',
        'app.proposed_ra_bills',
        'app.scheme_progresses',
        'app.scheme_progress_plans',
        'app.scheme_types',
        'app.sub_scheme_types'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::exists('SchemePayorders') ? [] : ['className' => 'App\Model\Table\SchemePayordersTable'];
        $this->SchemePayorders = TableRegistry::get('SchemePayorders', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->SchemePayorders);

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
