<?php
return [
	'ctrl' => [
		'title'	=> 'LLL:EXT:rkw_etracker/Resources/Private/Language/locallang_db.xlf:tx_rkwetracker_domain_model_reportareasum',
		'label' => 'report_group',
		'tstamp' => 'tstamp',
		'crdate' => 'crdate',
		'cruser_id' => 'cruser_id',
		'dividers2tabs' => true,
        'hideTable' => true,

		'enablecolumns' => [

		],
		'searchFields' => 'report_group,visitors,page_impressions,page_impressions_per_visitor,time_per_visitor,time_per_page,report,report_fetch_counter,month,quarter,year,',
		'iconfile' => 'EXT:rkw_etracker/Resources/Public/Icons/tx_rkwetracker_domain_model_reportareasum.gif'
	],
	'interface' => [
		'showRecordFieldList' => 'report_group, visitors, page_impressions, page_impressions_per_visitor, time_per_visitor, time_per_page, report, report_group, report_fetch_counter, month, quarter, year',
	],
	'types' => [
		'1' => ['showitem' => 'report_group, visitors, page_impressions, page_impressions_per_visitor, time_per_visitor, time_per_page, report, report_group, report_fetch_counter, month, quarter, year, '],
	],
	'palettes' => [
		'1' => ['showitem' => ''],
	],
	'columns' => [

		'visitors' => [
			'exclude' => 0,
			'label' => 'LLL:EXT:rkw_etracker/Resources/Private/Language/locallang_db.xlf:tx_rkwetracker_domain_model_reportareasum.visitors',
			'config' => [
				'type' => 'input',
				'size' => 4,
				'eval' => 'int'
			],
		],
		'page_impressions' => [
			'exclude' => 0,
			'label' => 'LLL:EXT:rkw_etracker/Resources/Private/Language/locallang_db.xlf:tx_rkwetracker_domain_model_reportareasum.page_impressions',
			'config' => [
				'type' => 'input',
				'size' => 4,
				'eval' => 'int'
			],
		],
		'page_impressions_per_visitor' => [
			'exclude' => 0,
			'label' => 'LLL:EXT:rkw_etracker/Resources/Private/Language/locallang_db.xlf:tx_rkwetracker_domain_model_reportareasum.page_impressions_per_visitor',
			'config' => [
				'type' => 'input',
				'size' => 30,
				'eval' => 'double2'
			],
		],
		'time_per_visitor' => [
			'exclude' => 0,
			'label' => 'LLL:EXT:rkw_etracker/Resources/Private/Language/locallang_db.xlf:tx_rkwetracker_domain_model_reportareasum.time_per_visitor',
			'config' => [
				'type' => 'input',
				'size' => 4,
				'eval' => 'int'
			],
		],
		'time_per_page' => [
			'exclude' => 0,
			'label' => 'LLL:EXT:rkw_etracker/Resources/Private/Language/locallang_db.xlf:tx_rkwetracker_domain_model_reportareasum.time_per_page',
			'config' => [
				'type' => 'input',
				'size' => 30,
				'eval' => 'int'
			],
		],
		'report' => [
			'exclude' => 0,
			'label' => 'LLL:EXT:rkw_etracker/Resources/Private/Language/locallang_db.xlf:tx_rkwetracker_domain_model_reportareasum.report',
			'config' => [
                'type' => 'select',
                'renderType' => 'selectSingle',
                'foreign_table' => 'tx_rkwetracker_domain_model_report',
                'foreign_table_where' => ' ORDER BY tx_rkwetracker_domain_model_report.name ASC',
                'maxitems'      => 1,
                'minitems'      => 1,
                'size'          => 5,
			],
		],
        'report_group' => [
            'exclude' => 0,
            'label' => 'LLL:EXT:rkw_etracker/Resources/Private/Language/locallang_db.xlf:tx_rkwetracker_domain_model_reportareasum.report_group',
            'config' => [
                'type' => 'select',
                'renderType' => 'selectSingle',
                'foreign_table' => 'tx_rkwetracker_domain_model_reportgroup',
                'foreign_table_where' => ' ORDER BY tx_rkwetracker_domain_model_reportgroup.name ASC',
                'maxitems'      => 1,
                'minitems'      => 1,
                'size'          => 5,
            ],
        ],
		'report_fetch_counter' => [
			'exclude' => 0,
			'label' => 'LLL:EXT:rkw_etracker/Resources/Private/Language/locallang_db.xlf:tx_rkwetracker_domain_model_reportareasum.report_fetch_counter',
			'config' => [
				'type' => 'input',
				'size' => 4,
				'eval' => 'int',
                'readOnly' => true,
			],
		],
		'month' => [
			'exclude' => 0,
			'label' => 'LLL:EXT:rkw_etracker/Resources/Private/Language/locallang_db.xlf:tx_rkwetracker_domain_model_reportareasum.month',
			'config' => [
				'type' => 'input',
				'size' => 30,
				'eval' => 'double2'
			],
		],
		'quarter' => [
			'exclude' => 0,
			'label' => 'LLL:EXT:rkw_etracker/Resources/Private/Language/locallang_db.xlf:tx_rkwetracker_domain_model_reportareasum.quarter',
			'config' => [
				'type' => 'input',
				'size' => 30,
				'eval' => 'double2'
			],
		],
		'year' => [
			'exclude' => 0,
			'label' => 'LLL:EXT:rkw_etracker/Resources/Private/Language/locallang_db.xlf:tx_rkwetracker_domain_model_reportareasum.year',
			'config' => [
				'type' => 'input',
				'size' => 30,
				'eval' => 'double2'
			],
		],
	],
];