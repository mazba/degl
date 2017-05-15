<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\LetterApprovalsTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\LetterApprovalsTable Test Case
 */
class LetterApprovalsTableTest extends TestCase
{

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.letter_approvals',
        'app.receive_file_registers',
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
        'app.schemes',
        'app.packages',
        'app.work_types',
        'app.work_sub_types',
        'app.municipalities',
        'app.financial_year_estimates',
        'app.scheme_revisions',
        'app.multimedia',
        'app.scheme_details',
        'app.items',
        'app.chapters',
        'app.scheme_amounts',
        'app.scheme_item_breakups',
        'app.vehicles_status',
        'app.vehicles',
        'app.employees',
        'app.assign_vehicles',
        'app.nothi_assigns',
        'app.nothi_registers',
        'app.lab_bills',
        'app.lab_bill_details',
        'app.lab_actual_tests',
        'app.lab_letter_registers',
        'app.hire_charges',
        'app.contractors',
        'app.hire_charge_details',
        'app.purto_bills',
        'app.allotment_registers',
        'app.assets',
        'app.proposed_ra_bills',
        'app.scheme_progresses',
        'app.scheme_progress_plans',
        'app.scheme_types',
        'app.sub_scheme_types',
        'app.sector'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::exists('LetterApprovals') ? [] : ['className' => 'App\Model\Table\LetterApprovalsTable'];
        $this->LetterApprovals = TableRegistry::get('LetterApprovals', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->LetterApprovals);

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
