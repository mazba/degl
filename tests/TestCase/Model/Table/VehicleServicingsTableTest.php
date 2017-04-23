<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\VehicleServicingsTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\VehicleServicingsTable Test Case
 */
class VehicleServicingsTableTest extends TestCase
{

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.vehicle_servicings',
        'app.offices',
        'app.divisions',
        'app.districts',
        'app.zones',
        'app.item_rates',
        'app.created_user',
        'app.designations',
        'app.users',
        'app.departments',
        'app.user_groups',
        'app.updated_user',
        'app.municipality',
        'app.upazila',
        'app.upazilas',
        'app.vehicles',
        'app.vehicles_status',
        'app.employees',
        'app.assign_vehicles',
        'app.nothi_assigns',
        'app.nothi_registers',
        'app.projects',
        'app.development_partners',
        'app.receive_file_registers',
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
        'app.proposed_ra_bills',
        'app.scheme_progresses',
        'app.scheme_progress_plans',
        'app.scheme_types',
        'app.sub_scheme_types',
        'app.sector',
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
        'app.vehicle_servicing_details'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::exists('VehicleServicings') ? [] : ['className' => 'App\Model\Table\VehicleServicingsTable'];
        $this->VehicleServicings = TableRegistry::get('VehicleServicings', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->VehicleServicings);

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
