<?php
return [
	'ctrl' => [
		'title'	=> 'LLL:EXT:rkw_etracker/Resources/Private/Language/locallang_db.xlf:tx_rkwetracker_domain_model_reportfilter',
		'label' => 'uid',
        'label_userFunc' => 'RKW\RkwEtracker\TCA\FilterSelector->getCombinedFilterLabels',
        //'label_alt' => 'category_level2, category_level3, category_level4, category_levelfive',
        //'label_alt_force' => 1,
		'tstamp' => 'tstamp',
		'crdate' => 'crdate',
		'cruser_id' => 'cruser_id',
		'dividers2tabs' => true,
		// 'sortby' => 'sorting',
        'hideTable' => true,
        //'requestUpdate' => 'domain_free, category_free_level1, category_free_level2, category_free_level3, category_free_level4, category_free_level5',
		'delete' => 'deleted',
		'enablecolumns' => [

		],
		'searchFields' => 'domain, domain_free, domain_required, category_level1, category_level2, category_level3, category_level4, category_level5, category_free_level1, category_free_level2, category_free_level3, category_free_level4, category_free_level5, download_filter1, download_free_filter1',
		'iconfile' => 'EXT:rkw_etracker/Resources/Public/Icons/tx_rkwetracker_domain_model_reportfilter.gif'
	],
	'interface' => [
        'showRecordFieldList' => 'domain, domain_free, category_level1, category_level2, category_level3, category_level4, category_level5, category_free_level1, category_free_level2, category_free_level3, category_free_level4, category_free_level5, download_filter1, download_free_filter1',

    ],
	'types' => [
        '1' => ['showitem' => 'domain, domain_free, --div--;LLL:EXT:rkw_etracker/Resources/Private/Language/locallang_db.xlf:tab.categories, category_level1, category_free_level1, category_level2, category_free_level2, category_level3, category_free_level3, category_level4, category_free_level4, category_level5, category_free_level5, --div--;LLL:EXT:rkw_etracker/Resources/Private/Language/locallang_db.xlf:tab.download, download_free_filter1, download_filter1'],
    ],
	'palettes' => [
		'1' => ['showitem' => ''],
	],
	'columns' => [

        'domain' => [
            'displayCond' =>  'FIELD:domain_free:REQ:false',
            'exclude' => 0,
            'label' => 'LLL:EXT:rkw_etracker/Resources/Private/Language/locallang_db.xlf:tx_rkwetracker_domain_model_reportfilter.domain',
            'config' => [
                'type' => 'select',
                'renderType' => 'selectSingle',
                'items' => [
                    ['-', 0],
                ],
                'size' => 1,
                'minitems' => 0,
                'maxitems' => 1,
                'default' => 0,
                'itemsProcFunc' => 'RKW\RkwEtracker\TCA\FilterSelector->getDomainLabels',
            ],
        ],
        'domain_free' => [
            'displayCond' => 'FIELD:domain:REQ:false',
            'exclude' => 0,
            'label' => 'LLL:EXT:rkw_etracker/Resources/Private/Language/locallang_db.xlf:tx_rkwetracker_domain_model_reportfilter.domain_free',
            'config' => [
                'type' => 'input',
                'size' => 30,
                'eval' => 'trim'
            ],
            'onChange' => 'reload'
        ],
		'category_level1' => [
            'displayCond' =>  'FIELD:category_free_level1:REQ:false',
            'exclude' => 0,
			'label' => 'LLL:EXT:rkw_etracker/Resources/Private/Language/locallang_db.xlf:tx_rkwetracker_domain_model_reportfilter.category_level1',
			'config' => [
                'type' => 'select',
                'renderType' => 'selectSingle',
                'items' => [
                    ['-', 0],
                ],
                'size' => 1,
                'minitems' => 0,
                'maxitems' => 1,
                'default' => 0,
                'itemsProcFunc' => 'RKW\RkwEtracker\TCA\FilterSelector->getCategoryLabelsLevel1',
			],
		],
        'category_level2' => [
            'displayCond' =>  'FIELD:category_free_level2:REQ:false',
            'exclude' => 0,
            'label' => 'LLL:EXT:rkw_etracker/Resources/Private/Language/locallang_db.xlf:tx_rkwetracker_domain_model_reportfilter.category_level2',
            'config' => [
                'type' => 'select',
                'renderType' => 'selectSingle',
                'items' => [
                    ['-', 0],
                ],
                'size' => 1,
                'minitems' => 0,
                'maxitems' => 1,
                'itemsProcFunc' => 'RKW\RkwEtracker\TCA\FilterSelector->getCategoryLabelsLevel2',
            ],
        ],
        'category_level3' => [
            'displayCond' =>  'FIELD:category_free_level3:REQ:false',
            'exclude' => 0,
            'label' => 'LLL:EXT:rkw_etracker/Resources/Private/Language/locallang_db.xlf:tx_rkwetracker_domain_model_reportfilter.category_level3',
            'config' => [
                'type' => 'select',
                'renderType' => 'selectSingle',
                'items' => [
                    ['-', 0],
                ],
                'size' => 1,
                'minitems' => 0,
                'maxitems' => 1,
                'itemsProcFunc' => 'RKW\RkwEtracker\TCA\FilterSelector->getCategoryLabelsLevel3',
            ],
        ],
        'category_level4' => [
            'displayCond' =>  'FIELD:category_free_level4:REQ:false',
            'exclude' => 0,
            'label' => 'LLL:EXT:rkw_etracker/Resources/Private/Language/locallang_db.xlf:tx_rkwetracker_domain_model_reportfilter.category_level4',
            'config' => [
                'type' => 'select',
                'renderType' => 'selectSingle',
                'items' => [
                    ['-', 0],
                ],
                'size' => 1,
                'minitems' => 0,
                'maxitems' => 1,
                'itemsProcFunc' => 'RKW\RkwEtracker\TCA\FilterSelector->getCategoryLabelsLevel4',
            ],
        ],
        'category_level5' => [
            'displayCond' =>  'FIELD:category_free_level5:REQ:false',
            'exclude' => 0,
            'label' => 'LLL:EXT:rkw_etracker/Resources/Private/Language/locallang_db.xlf:tx_rkwetracker_domain_model_reportfilter.category_level5',
            'config' => [
                'type' => 'select',
                'renderType' => 'selectSingle',
                'items' => [
                    ['-', 0],
                ],
                'size' => 1,
                'minitems' => 0,
                'maxitems' => 1,
                'itemsProcFunc' => 'RKW\RkwEtracker\TCA\FilterSelector->getCategoryLabelsLevel5',
            ],
        ],
        'category_free_level1' => [
            'exclude' => 0,
            'label' => 'LLL:EXT:rkw_etracker/Resources/Private/Language/locallang_db.xlf:tx_rkwetracker_domain_model_reportfilter.category_free_level1',
            'config' => [
                'type' => 'input',
                'size' => 30,
                'eval' => 'trim'
            ],
            'onChange' => 'reload'
        ],
        'category_free_level2' => [
            'exclude' => 0,
            'label' => 'LLL:EXT:rkw_etracker/Resources/Private/Language/locallang_db.xlf:tx_rkwetracker_domain_model_reportfilter.category_free_level2',
            'config' => [
                'type' => 'input',
                'size' => 30,
                'eval' => 'trim'
            ],
            'onChange' => 'reload'
        ],
        'category_free_level3' => [
            'exclude' => 0,
            'label' => 'LLL:EXT:rkw_etracker/Resources/Private/Language/locallang_db.xlf:tx_rkwetracker_domain_model_reportfilter.category_free_level3',
            'config' => [
                'type' => 'input',
                'size' => 30,
                'eval' => 'trim'
            ],
            'onChange' => 'reload'
        ],
        'category_free_level4' => [
            'exclude' => 0,
            'label' => 'LLL:EXT:rkw_etracker/Resources/Private/Language/locallang_db.xlf:tx_rkwetracker_domain_model_reportfilter.category_free_level4',
            'config' => [
                'type' => 'input',
                'size' => 30,
                'eval' => 'trim'
            ],
            'onChange' => 'reload'
        ],
        'category_free_level5' => [
            'exclude' => 0,
            'label' => 'LLL:EXT:rkw_etracker/Resources/Private/Language/locallang_db.xlf:tx_rkwetracker_domain_model_reportfilter.category_free_level5',
            'config' => [
                'type' => 'input',
                'size' => 30,
                'eval' => 'trim'
            ],
            'onChange' => 'reload'
        ],
        'download_filter1' => [
            'exclude' => 0,
            'label' => 'LLL:EXT:rkw_etracker/Resources/Private/Language/locallang_db.xlf:tx_rkwetracker_domain_model_reportfilter.download_filter1',
            'config' => [
                'type' => 'select',
                'renderType' => 'selectSingle',
                'items' => [
                    ['-', 0],
                ],
                'size' => 1,
                'minitems' => 0,
                'maxitems' => 1,
                'itemsProcFunc' => 'RKW\RkwEtracker\TCA\FilterSelector->getDownloadLabels',
            ],
        ],
        'download_filter2' => [
            'exclude' => 0,
            'label' => 'LLL:EXT:rkw_etracker/Resources/Private/Language/locallang_db.xlf:tx_rkwetracker_domain_model_reportfilter.download_filter2',
            'config' => [
                'type' => 'select',
                'renderType' => 'selectSingle',
                'items' => [
                    ['-', 0],
                ],
                'size' => 1,
                'minitems' => 0,
                'maxitems' => 1,
                'itemsProcFunc' => 'RKW\RkwEtracker\TCA\FilterSelector->getDownloadLabels',
            ],
        ],
        'download_filter3' => [
            'exclude' => 0,
            'label' => 'LLL:EXT:rkw_etracker/Resources/Private/Language/locallang_db.xlf:tx_rkwetracker_domain_model_reportfilter.download_filter3',
            'config' => [
                'type' => 'select',
                'renderType' => 'selectSingle',
                'items' => [
                    ['-', 0],
                ],
                'size' => 1,
                'minitems' => 0,
                'maxitems' => 1,
                'itemsProcFunc' => 'RKW\RkwEtracker\TCA\FilterSelector->getDownloadLabels',
            ],
        ],
        'download_free_filter1' => [
            'exclude' => 0,
            'label' => 'LLL:EXT:rkw_etracker/Resources/Private/Language/locallang_db.xlf:tx_rkwetracker_domain_model_reportfilter.download_free_filter1',
            'config' => [
                'type' => 'input',
                'size' => 30,
                'eval' => 'trim'
            ],
        ],
        'reportgroup' => [
			'config' => [
				'type' => 'passthrough',
			],
		],
	],
];