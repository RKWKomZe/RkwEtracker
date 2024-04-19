<?php
return [
	'ctrl' => [
		'title'	=> 'LLL:EXT:rkw_etracker/Resources/Private/Language/locallang_db.xlf:tx_rkwetracker_domain_model_downloaddata',
		'label' => 'action',
		'tstamp' => 'tstamp',
		'crdate' => 'crdate',
		'cruser_id' => 'cruser_id',
		'dividers2tabs' => true,
        'hideTable' => true,

		'enablecolumns' => [

		],
		'searchFields' => 'action,category,time_per_event,events,unique_events,month,quarter,year,',
		'iconfile' => 'EXT:rkw_etracker/Resources/Public/Icons/tx_rkwetracker_domain_model_downloaddata.gif'
	],
	'types' => [
		'1' => ['showitem' => 'action, time_per_event, events, unique_events, report, report_fetch_counter, month, quarter, year'],
	],
	'palettes' => [
		'1' => ['showitem' => ''],
	],
	'columns' => [

        'report' => [
            'exclude' => 0,
            'label' => 'LLL:EXT:rkw_etracker/Resources/Private/Language/locallang_db.xlf:tx_rkwetracker_domain_model_downloaddata.report',
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
            'label' => 'LLL:EXT:rkw_etracker/Resources/Private/Language/locallang_db.xlf:tx_rkwetracker_domain_model_downloaddata.report_group',
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
        'report_filter' => [
            'exclude' => 0,
            'label' => 'LLL:EXT:rkw_etracker/Resources/Private/Language/locallang_db.xlf:tx_rkwetracker_domain_model_downloaddata.report_filter',
            'config' => [
                'type' => 'select',
                'renderType' => 'selectSingle',
                'foreign_table' => 'tx_rkwetracker_domain_model_reportfilter',
                'foreign_table_where' => ' ORDER BY tx_rkwetracker_domain_model_reportfilter.domain ASC, tx_rkwetracker_domain_model_reportfilter.domain_free ASC',
                'maxitems'      => 1,
                'minitems'      => 1,
                'size'          => 5,
            ],
        ],
        'report_fetch_counter' => [
            'exclude' => 1,
            'label' => 'LLL:EXT:rkw_etracker/Resources/Private/Language/locallang_db.xlf:tx_rkwetracker_domain_model_downloaddata.report_fetch_counter',
            'config' => [
                'type' => 'input',
                'size' => 13,
                'max' => 20,
                'eval' => 'int',
                'readOnly' => true,
            ],
        ],
		'action' => [
			'exclude' => 0,
			'label' => 'LLL:EXT:rkw_etracker/Resources/Private/Language/locallang_db.xlf:tx_rkwetracker_domain_model_downloaddata.action',
			'config' => [
				'type' => 'input',
				'size' => 30,
				'eval' => 'trim'
			],
		],
		'time_per_event' => [
			'exclude' => 0,
			'label' => 'LLL:EXT:rkw_etracker/Resources/Private/Language/locallang_db.xlf:tx_rkwetracker_domain_model_downloaddata.time_per_event',
			'config' => [
				'type' => 'input',
				'size' => 30,
				'eval' => 'int'
			],
		],
		'events' => [
			'exclude' => 0,
			'label' => 'LLL:EXT:rkw_etracker/Resources/Private/Language/locallang_db.xlf:tx_rkwetracker_domain_model_downloaddata.events',
			'config' => [
				'type' => 'input',
				'size' => 30,
				'eval' => 'int'
			],
		],
		'unique_events' => [
			'exclude' => 0,
			'label' => 'LLL:EXT:rkw_etracker/Resources/Private/Language/locallang_db.xlf:tx_rkwetracker_domain_model_downloaddata.unique_events',
			'config' => [
				'type' => 'input',
				'size' => 30,
				'eval' => 'int'
			],
		],
        'month' => [
            'exclude' => 0,
            'label' => 'LLL:EXT:rkw_etracker/Resources/Private/Language/locallang_db.xlf:tx_rkwetracker_domain_model_downloaddata.month',
            'config' => [
                'type' => 'input',
                'size' => 4,
                'eval' => 'int'
            ],
        ],
        'quarter' => [
            'exclude' => 0,
            'label' => 'LLL:EXT:rkw_etracker/Resources/Private/Language/locallang_db.xlf:tx_rkwetracker_domain_model_downloaddata.quarter',
            'config' => [
                'type' => 'input',
                'size' => 30,
                'eval' => 'int'
            ],
        ],
        'year' => [
            'exclude' => 0,
            'label' => 'LLL:EXT:rkw_etracker/Resources/Private/Language/locallang_db.xlf:tx_rkwetracker_domain_model_downloaddata.year',
            'config' => [
                'type' => 'input',
                'size' => 30,
                'eval' => 'int'
            ],
        ],
	],
];
