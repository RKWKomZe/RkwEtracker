<?php

$tempColumnsPages = [

	'tx_rkwetracker_category_level1' => [
		'exclude' => 1,
		'label' => 'LLL:EXT:rkw_etracker/Resources/Private/Language/locallang_db.xlf:pages.tx_rkwetracker_category_level1',
		'config' => [
            'type' => 'input',
            'size' => '30',
            'eval' => 'trim'
		],
	],

    'tx_rkwetracker_category_level2' => [
        'exclude' => 1,
        'label' => 'LLL:EXT:rkw_etracker/Resources/Private/Language/locallang_db.xlf:pages.tx_rkwetracker_category_level2',
        'config' => [
            'type' => 'input',
            'size' => '30',
            'eval' => 'trim'
        ],
    ],

    'tx_rkwetracker_category_level3' => [
        'exclude' => 1,
        'label' => 'LLL:EXT:rkw_etracker/Resources/Private/Language/locallang_db.xlf:pages.tx_rkwetracker_category_level3',
        'config' => [
            'type' => 'input',
            'size' => '30',
            'eval' => 'trim'
        ],
    ],

    'tx_rkwetracker_category_level4' => [
        'exclude' => 1,
        'label' => 'LLL:EXT:rkw_etracker/Resources/Private/Language/locallang_db.xlf:pages.tx_rkwetracker_category_level4',
        'config' => [
            'type' => 'input',
            'size' => '30',
            'eval' => 'trim'
        ],
    ],

    'tx_rkwetracker_category_level5' => [
        'exclude' => 1,
        'label' => 'LLL:EXT:rkw_etracker/Resources/Private/Language/locallang_db.xlf:pages.tx_rkwetracker_category_level5',
        'config' => [
            'type' => 'input',
            'size' => '30',
            'eval' => 'trim'
        ],
    ],
];


//===========================================================================
// Add fields
//===========================================================================

\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addTCAcolumns('pages',$tempColumnsPages);

// Add new tab for etracker
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addToAllTCAtypes('pages','--div--;LLL:EXT:rkw_etracker/Resources/Private/Language/locallang_db.xlf:pages.tabs.etracker, tx_rkwetracker_category_level1, tx_rkwetracker_category_level2, tx_rkwetracker_category_level3, tx_rkwetracker_category_level4, tx_rkwetracker_category_level5', '1,7,254');


