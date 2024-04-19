<?php
return [
	'ctrl' => [
		'title'	=> 'LLL:EXT:rkw_etracker/Resources/Private/Language/locallang_db.xlf:tx_rkwetracker_domain_model_reportgroup',
		'label' => 'name',
		'tstamp' => 'tstamp',
		'crdate' => 'crdate',
		'cruser_id' => 'cruser_id',
		'dividers2tabs' => true,
        'default_sortby' => 'name',

		'delete' => 'deleted',
		'enablecolumns' => [

		],
		'searchFields' => 'name,description,filter,',
		'iconfile' => 'EXT:rkw_etracker/Resources/Public/Icons/tx_rkwetracker_domain_model_reportgroup.gif'
	],
	'types' => [
		'1' => ['showitem' => 'name, description, filter'],
	],
	'palettes' => [
		'1' => ['showitem' => ''],
	],
	'columns' => [

		'name' => [
			'exclude' => 0,
			'label' => 'LLL:EXT:rkw_etracker/Resources/Private/Language/locallang_db.xlf:tx_rkwetracker_domain_model_reportgroup.name',
			'config' => [
				'type' => 'input',
				'size' => 30,
				'eval' => 'trim,required'
			],
		],
		'description' => [
			'exclude' => 0,
			'label' => 'LLL:EXT:rkw_etracker/Resources/Private/Language/locallang_db.xlf:tx_rkwetracker_domain_model_reportgroup.description',
			'config' => [
				'type' => 'text',
				'size' => 30,
				'eval' => 'trim',
                'cols' => 30,
                'rows' => 10
			],
		],
		'filter' => [
			'exclude' => 0,
			'label' => 'LLL:EXT:rkw_etracker/Resources/Private/Language/locallang_db.xlf:tx_rkwetracker_domain_model_reportgroup.filter',
			'config' => [
				'type' => 'inline',
				'foreign_table' => 'tx_rkwetracker_domain_model_reportfilter',
				'foreign_field' => 'reportgroup',
				/* 'foreign_sortby' => 'sorting', */
                'foreign_default_sortby' => 'domain, domain_free, category_level1, category_level2',
				'maxitems' => 9999,
                'minitems' => 1,
				'appearance' => [
					'collapseAll' => 1,
					'levelLinksPosition' => 'top',
					'showSynchronizationLink' => 1,
					'showPossibleLocalizationRecords' => 1,
					'useSortable' => 0,
					'showAllLocalizationLink' => 1,
                    'enabledControls' => [
                        'info' => true,
                        'new' => true,
                        'dragdrop' => false,
                        'sort' => false,
                        'hide' => false,
                        'delete' => true,
                        'localize' => false,
                    ],
				],
			],
		],

		'report' => [
			'config' => [
				'type' => 'passthrough',
			],
		],
	],
];
