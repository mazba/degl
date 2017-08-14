<?php
/**
 * Created by PhpStorm.
 * User: shaiful
 * Date: 5/30/15
 * Time: 5:31 PM
 */
return [
    'status_options' => ['1' => 'Active', '0' => 'In-Active'],
    'scheme_progress_status' => ['1' => 'সচল', '0' => 'সমাপ্ত'],
    'project_status' => ['1' => 'Active', '0' => 'In-Active', '4' => 'Complete'],
    'yes_no_options' => ['1' => 'Yes', '0' => 'No'],
    'gender' => ['MALE' => 'Male', 'FEMALE' => 'Female'],
    'departments' => ['MECHANICAL' => 'mechanical', 'LAB' => 'lab', 'ACCOUNT' => 'account', 'EFILE' => 'efile'],
    'employee_type' => ['MASTER' => 'master role', 'REVENUE' => 'revenue', 'PROJECT' => 'project'],
    'books_work_status' => ['ON_GOING' => "On Going", 'SUSPENDED' => 'Suspended'],
    'scheme_complete_status' => 4,
    'attachment_type' => [0 => 'Files', 1 => 'RA Bill', 2 => 'Measurement Book', 3 => 'Estimation', 4 => 'Dak File'],
    'task_media_type' => ['SMS' => 'SMS', 'Phone' => 'Phone', 'Fax' => 'Fax', 'Email' => 'Email', 'Physical' => 'Physical'],
    'user_groups' => [
        'superadmin' => 1,
        'admin' => 2,
        'staff' => 3,
        'lab' => 4,
        'vehicles' => 5,
        'counter' => 6,
        'accounts' => 7,
        'uda' => 8
    ],
    'scheme_type' => [
        'road' => 1,
        'bridge_id' => 2
    ],
    'sub_scheme_type' => [
        'concrete_road_id' => 1,

    ],
    'work_type' => [
        'maintenance_id' => 3
    ],

    'scheme_category' => [
        'Category-1' => 'Category-1',
        'Category-2' => 'Category-2',
        'Category-3' => 'Category-3',
        'Category-4' => 'Category-4',
    ],

    'general_report_fields' => [
        'district_name' => 'District',
        'upazila_name' => 'Upazila',
        'package_name' => 'Package No.',
        'category_name' => 'Category Name',
        'financial_year' => 'Financial Year',
        'name_bn' => 'Scheme Name',
        'contractor_name' => 'Contractor Name',
        'contract_amount' => 'Contract Amount',
        'contract_date' => 'Contract Date',
        'eve_approval_bill' => 'Approval Estimated Cost',
        'completion_date' => 'Completion Date',
        'actual_complete_date' => 'Actual Completion Date',
        'physical_progress' => 'Physical Progress',
        'road_length' => 'Road Length',
        'structure_length' => 'Structure Length',
        'building_quantity' => 'Building',
        'estimated_cost' => 'Estimated Cost',
        'estimated_road' => 'Estimated Cost (Road)',
        'estimated_structure' => 'Estimated Cost (Structure)',
        'etender_date' => 'Tender Received Date',
        'work_order_date' => 'Work Order Date',
        'expected_complete_date' => 'Work Completion Date',
        'total_fund_spend' => 'Total Fund Spend',
        'fund_spend_this_year' => 'Fund Spend This Year',
        'fund_spend_this_month' => 'Fund Spend This Month',
        'total_fund_received' => 'Total Fund Received',
        //'fund_received_this_year'=>'Fund Received This Year',
        'payment_road' => 'Payment (Road)',
        'payment_structure' => 'Payment (Structure)',
        'allotment_bill' => 'Allotted Amount',
        'allotment_date' => 'Allotted Date',
        'eve_approval_date' => 'Approved Date',
        'actual_start_date' => 'Work Start Date',
        'remarks' => 'Remarks',


    ],

    'general_report_group_by' => [
        'upazilas.id' => 'Upazila',
        'packages.id' => 'Package',
        'Schemes.category_name' => 'Category',
        'financial_year_estimates.id' => 'Financial Year'
    ],
    'general_report_sort_by' => [
        'Schemes.upazila_id' => 'Upazila',
        'Schemes.package_id' => 'Package',
        'Schemes.category_name' => 'Category',
        'Schemes.financial_year_estimate_id' => 'Financial Year'
    ],
    'test_no_type' => [
        '' => 'Blank',
        1 => 'Set'
    ],

    'test_frequency_unit_type' => [
        1=>'m<sup>3</sup>',
        2=>'m<sup>2</sup>',
        3=>'m',
        4=>'kg',
    ]

];


