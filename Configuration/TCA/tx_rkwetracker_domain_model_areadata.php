<?php
return [
	'ctrl' => [
		'title'	=> 'LLL:EXT:rkw_etracker/Resources/Private/Language/locallang_db.xlf:tx_rkwetracker_domain_model_areadata',
		'label' => 'external_id',
		'tstamp' => 'tstamp',
		'crdate' => 'crdate',
		'cruser_id' => 'cruser_id',
		'dividers2tabs' => true,
        'hideTable' => true,

		'enablecolumns' => [

		],
		'searchFields' => 'external_id,last_access_tstamp,visitors,page_impressions,page_impression_per_visitor,time_per_visitor,time_per_page,category_level1,category_level2,category_level3,category_level4,category_level5,month,quarter,year,',
		'iconfile' => 'EXT:rkw_etracker/Resources/Public/Icons/tx_rkwetracker_domain_model_areadata.gif'
	],
	'interface' => [
		'showRecordFieldList' => 'visit, visitors, page_impressions, bounces_per_visit, time_per_visit, domain, category_level1, category_level2, category_level3, category_level4, category_level5, report, report_group, report_filter, report_fetch_counter, month, quarter, year',
	],
	'types' => [
		'1' => ['showitem' => 'visit, visitors, page_impressions, bounces_per_visit, time_per_visit,domain, category_level1, category_level2, category_level3, category_level4, category_level5, report, report_group, report_filter, report_fetch_counter, month, quarter, year, '],
	],
	'palettes' => [
		'1' => ['showitem' => ''],
	],
	'columns' => [

        'visits' => [
            'exclude' => 0,
            'label' => 'LLL:EXT:rkw_etracker/Resources/Private/Language/locallang_db.xlf:tx_rkwetracker_domain_model_areadata.visits',
            'config' => [
                'type' => 'input',
                'size' => 4,
                'eval' => 'int'
            ],
        ],
		'visitors' => [
			'exclude' => 0,
			'label' => 'LLL:EXT:rkw_etracker/Resources/Private/Language/locallang_db.xlf:tx_rkwetracker_domain_model_areadata.visitors',
			'config' => [
				'type' => 'input',
				'size' => 4,
				'eval' => 'int'
			],
		],
		'page_impressions' => [
			'exclude' => 0,
			'label' => 'LLL:EXT:rkw_etracker/Resources/Private/Language/locallang_db.xlf:tx_rkwetracker_domain_model_areadata.page_impressions',
			'config' => [
				'type' => 'input',
				'size' => 30,
				'eval' => 'trim'
			],
		],
		'bounces_per_visit' => [
			'exclude' => 0,
			'label' => 'LLL:EXT:rkw_etracker/Resources/Private/Language/locallang_db.xlf:tx_rkwetracker_domain_model_areadata.bounces_per_visit',
			'config' => [
				'type' => 'input',
				'size' => 30,
				'eval' => 'double2'
			],
		],
		'time_per_visit' => [
			'exclude' => 0,
			'label' => 'LLL:EXT:rkw_etracker/Resources/Private/Language/locallang_db.xlf:tx_rkwetracker_domain_model_areadata.time_per_visit',
			'config' => [
				'type' => 'input',
				'size' => 30,
				'eval' => 'trim'
			],
		],
        'domain' => [
            'exclude' => 0,
            'label' => 'LLL:EXT:rkw_etracker/Resources/Private/Language/locallang_db.xlf:tx_rkwetracker_domain_model_areadata.domain',
            'config' => [
                'type' => 'input',
                'size' => 30,
                'eval' => 'trim'
            ],
        ],
        'category_level1' => [
            'exclude' => 0,
            'label' => 'LLL:EXT:rkw_etracker/Resources/Private/Language/locallang_db.xlf:tx_rkwetracker_domain_model_areadata.category_level1',
            'config' => [
                'type' => 'input',
                'size' => 30,
                'eval' => 'trim'
            ],
        ],
        'category_level2' => [
            'exclude' => 0,
            'label' => 'LLL:EXT:rkw_etracker/Resources/Private/Language/locallang_db.xlf:tx_rkwetracker_domain_model_areadata.category_level2',
            'config' => [
                'type' => 'input',
                'size' => 30,
                'eval' => 'trim'
            ],
        ],
        'category_level3' => [
            'exclude' => 0,
            'label' => 'LLL:EXT:rkw_etracker/Resources/Private/Language/locallang_db.xlf:tx_rkwetracker_domain_model_areadata.category_level3',
            'config' => [
                'type' => 'input',
                'size' => 30,
                'eval' => 'trim'
            ],
        ],
        'category_level4' => [
            'exclude' => 0,
            'label' => 'LLL:EXT:rkw_etracker/Resources/Private/Language/locallang_db.xlf:tx_rkwetracker_domain_model_areadata.category_level4',
            'config' => [
                'type' => 'input',
                'size' => 30,
                'eval' => 'trim'
            ],
        ],
        'category_level5' => [
            'exclude' => 0,
            'label' => 'LLL:EXT:rkw_etracker/Resources/Private/Language/locallang_db.xlf:tx_rkwetracker_domain_model_areadata.category_level5',
            'config' => [
                'type' => 'input',
                'size' => 30,
                'eval' => 'trim'
            ],
        ],
        'report' => [
            'exclude' => 0,
            'label' => 'LLL:EXT:rkw_etracker/Resources/Private/Language/locallang_db.xlf:tx_rkwetracker_domain_model_areadata.report',
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
            'label' => 'LLL:EXT:rkw_etracker/Resources/Private/Language/locallang_db.xlf:tx_rkwetracker_domain_model_areadata.report_group',
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
            'label' => 'LLL:EXT:rkw_etracker/Resources/Private/Language/locallang_db.xlf:tx_rkwetracker_domain_model_areadata.report_filter',
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
            'label' => 'LLL:EXT:rkw_etracker/Resources/Private/Language/locallang_db.xlf:tx_rkwetracker_domain_model_areadata.report_fetch_counter',
            'config' => [
                'type' => 'input',
                'size' => 13,
                'max' => 20,
                'eval' => 'int',
                'readOnly' => true,
            ],
        ],
		'month' => [
			'exclude' => 0,
			'label' => 'LLL:EXT:rkw_etracker/Resources/Private/Language/locallang_db.xlf:tx_rkwetracker_domain_model_areadata.month',
			'config' => [
				'type' => 'input',
				'size' => 4,
				'eval' => 'int'
			],
		],
		'quarter' => [
			'exclude' => 0,
			'label' => 'LLL:EXT:rkw_etracker/Resources/Private/Language/locallang_db.xlf:tx_rkwetracker_domain_model_areadata.quarter',
			'config' => [
				'type' => 'input',
				'size' => 30,
				'eval' => 'int'
			],
		],
		'year' => [
			'exclude' => 0,
			'label' => 'LLL:EXT:rkw_etracker/Resources/Private/Language/locallang_db.xlf:tx_rkwetracker_domain_model_areadata.year',
			'config' => [
				'type' => 'input',
				'size' => 30,
				'eval' => 'int'
			],
		],
	],
];