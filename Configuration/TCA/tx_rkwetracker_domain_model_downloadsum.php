<?php
return [
	'ctrl' => [
		'title'	=> 'LLL:EXT:rkw_etracker/Resources/Private/Language/locallang_db.xlf:tx_rkwetracker_domain_model_downloadsum',
		'label' => 'time_per_event',
		'tstamp' => 'tstamp',
		'crdate' => 'crdate',
		'cruser_id' => 'cruser_id',
        'dividers2tabs' => true,
        'hideTable' => true,

		'enablecolumns' => [

		],
		'searchFields' => 'time_per_event,events,unique_events,report,report_fetch_counter,month,quarter,year,',
		'iconfile' => 'EXT:rkw_etracker/Resources/Public/Icons/tx_rkwetracker_domain_model_downloadsum.gif'
	],
	'interface' => [
		'showRecordFieldList' => 'time_per_event, events, unique_events, report, report_group, report_fetch_counter, month, quarter, year',
	],
	'types' => [
		'1' => ['showitem' => 'time_per_event, events, unique_events, report, report_group, report_fetch_counter, month, quarter, year, '],
	],
	'palettes' => [
		'1' => ['showitem' => ''],
	],
	'columns' => [

		'time_per_event' => [
			'exclude' => 0,
			'label' => 'LLL:EXT:rkw_etracker/Resources/Private/Language/locallang_db.xlf:tx_rkwetracker_domain_model_downloadsum.time_per_event',
			'config' => [
				'type' => 'input',
				'size' => 4,
				'eval' => 'int'
			],
		],
		'events' => [
			'exclude' => 0,
			'label' => 'LLL:EXT:rkw_etracker/Resources/Private/Language/locallang_db.xlf:tx_rkwetracker_domain_model_downloadsum.events',
			'config' => [
				'type' => 'input',
				'size' => 4,
				'eval' => 'int'
			],
		],
		'unique_events' => [
			'exclude' => 0,
			'label' => 'LLL:EXT:rkw_etracker/Resources/Private/Language/locallang_db.xlf:tx_rkwetracker_domain_model_downloadsum.unique_events',
			'config' => [
				'type' => 'input',
				'size' => 30,
				'eval' => 'int'
			],
		],
		'report' => [
			'exclude' => 0,
			'label' => 'LLL:EXT:rkw_etracker/Resources/Private/Language/locallang_db.xlf:tx_rkwetracker_domain_model_downloadsum.report',
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
            'label' => 'LLL:EXT:rkw_etracker/Resources/Private/Language/locallang_db.xlf:tx_rkwetracker_domain_model_downloadsum.report_group',
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
			'label' => 'LLL:EXT:rkw_etracker/Resources/Private/Language/locallang_db.xlf:tx_rkwetracker_domain_model_downloadsum.report_fetch_counter',
			'config' => [
				'type' => 'input',
				'size' => 30,
				'eval' => 'trim',
                'readOnly' => true,
			],
		],
		'month' => [
			'exclude' => 0,
			'label' => 'LLL:EXT:rkw_etracker/Resources/Private/Language/locallang_db.xlf:tx_rkwetracker_domain_model_downloadsum.month',
			'config' => [
				'type' => 'input',
				'size' => 30,
				'eval' => 'trim'
			],
		],
		'quarter' => [
			'exclude' => 0,
			'label' => 'LLL:EXT:rkw_etracker/Resources/Private/Language/locallang_db.xlf:tx_rkwetracker_domain_model_downloadsum.quarter',
			'config' => [
				'type' => 'input',
				'size' => 30,
				'eval' => 'trim'
			],
		],
		'year' => [
			'exclude' => 0,
			'label' => 'LLL:EXT:rkw_etracker/Resources/Private/Language/locallang_db.xlf:tx_rkwetracker_domain_model_downloadsum.year',
			'config' => [
				'type' => 'input',
				'size' => 30,
				'eval' => 'trim'
			],
		],
	],
];