<?php
return array(
	'ctrl' => array(
		'title'	=> 'LLL:EXT:rkw_etracker/Resources/Private/Language/locallang_db.xlf:tx_rkwetracker_domain_model_reportfilter',
		'label' => 'uid',
        'label_userFunc' => 'RKW\RkwEtracker\Hook\FilterSelector->getCombinedFilterLabels',
        //'label_alt' => 'category_level2, category_level3, category_level4, category_levelfive',
        //'label_alt_force' => 1,
		'tstamp' => 'tstamp',
		'crdate' => 'crdate',
		'cruser_id' => 'cruser_id',
		'dividers2tabs' => TRUE,
		// 'sortby' => 'sorting',
        'hideTable' => true,
        'requestUpdate' => 'domain_free, category_free_level1, category_free_level2, category_free_level3, category_free_level4, category_free_level5',

		'delete' => 'deleted',
		'enablecolumns' => array(

		),
		'searchFields' => 'domain, domain_free, domain_required, category_level1, category_level2, category_level3, category_level4, category_level5, category_free_level1, category_free_level2, category_free_level3, category_free_level4, category_free_level5, download_filter1, download_filter2, download_filter3, download_free_filter1',
		'iconfile' => 'EXT:rkw_etracker/Resources/Public/Icons/tx_rkwetracker_domain_model_reportfilter.gif'
	),
	'interface' => array(
        'showRecordFieldList' => 'domain, domain_free, category_level1, category_level2, category_level3, category_level4, category_level5, category_free_level1, category_free_level2, category_free_level3, category_free_level4, category_free_level5, download_filter1, download_filter2, download_filter3, download_free_filter1',

    ),
	'types' => array(
        '1' => array('showitem' => 'domain, domain_free, --div--;LLL:EXT:rkw_etracker/Resources/Private/Language/locallang_db.xlf:tab.categories, category_level1, category_free_level1, category_level2, category_free_level2, category_level3, category_free_level3, category_level4, category_free_level4, category_level5, category_free_level5, --div--;LLL:EXT:rkw_etracker/Resources/Private/Language/locallang_db.xlf:tab.download, download_free_filter1, download_filter1, download_filter2, download_filter3'),
    ),
	'palettes' => array(
		'1' => array('showitem' => ''),
	),
	'columns' => array(

        'domain' => array(
            'displayCond' =>  'FIELD:domain_free:REQ:false',
            'exclude' => 0,
            'label' => 'LLL:EXT:rkw_etracker/Resources/Private/Language/locallang_db.xlf:tx_rkwetracker_domain_model_reportfilter.domain',
            'config' => array(
                'type' => 'select',
                'renderType' => 'selectSingle',
                'items' => array (
                    array('-', 0),
                ),
                'size' => 1,
                'minitems' => 0,
                'maxitems' => 1,
                'default' => 0,
                'itemsProcFunc' => 'RKW\RkwEtracker\Hook\FilterSelector->getDomainLabels',
            ),
        ),
        'domain_free' => array(
            'displayCond' =>  'FIELD:domain:REQ:0',
            'exclude' => 0,
            'label' => 'LLL:EXT:rkw_etracker/Resources/Private/Language/locallang_db.xlf:tx_rkwetracker_domain_model_reportfilter.domain_free',
            'config' => array(
                'type' => 'input',
                'size' => 30,
                'eval' => 'trim'
            ),
        ),
		'category_level1' => array(
            'displayCond' =>  'FIELD:category_free_level1:REQ:false',
            'exclude' => 0,
			'label' => 'LLL:EXT:rkw_etracker/Resources/Private/Language/locallang_db.xlf:tx_rkwetracker_domain_model_reportfilter.category_level1',
			'config' => array(
                'type' => 'select',
                'renderType' => 'selectSingle',
                'items' => array (
                    array('-', 0),
                ),
                'size' => 1,
                'minitems' => 0,
                'maxitems' => 1,
                'default' => 0,
                'itemsProcFunc' => 'RKW\RkwEtracker\Hook\FilterSelector->getCategoryLabelsLevel1',
			),
		),
        'category_level2' => array(
            'displayCond' =>  'FIELD:category_free_level2:REQ:false',
            'exclude' => 0,
            'label' => 'LLL:EXT:rkw_etracker/Resources/Private/Language/locallang_db.xlf:tx_rkwetracker_domain_model_reportfilter.category_level2',
            'config' => array(
                'type' => 'select',
                'renderType' => 'selectSingle',
                'items' => array (
                    array('-', 0),
                ),
                'size' => 1,
                'minitems' => 0,
                'maxitems' => 1,
                'itemsProcFunc' => 'RKW\RkwEtracker\Hook\FilterSelector->getCategoryLabelsLevel2',
            ),
        ),
        'category_level3' => array(
            'displayCond' =>  'FIELD:category_free_level3:REQ:false',
            'exclude' => 0,
            'label' => 'LLL:EXT:rkw_etracker/Resources/Private/Language/locallang_db.xlf:tx_rkwetracker_domain_model_reportfilter.category_level3',
            'config' => array(
                'type' => 'select',
                'renderType' => 'selectSingle',
                'items' => array (
                    array('-', 0),
                ),
                'size' => 1,
                'minitems' => 0,
                'maxitems' => 1,
                'itemsProcFunc' => 'RKW\RkwEtracker\Hook\FilterSelector->getCategoryLabelsLevel3',
            ),
        ),
        'category_level4' => array(
            'displayCond' =>  'FIELD:category_free_level4:REQ:false',
            'exclude' => 0,
            'label' => 'LLL:EXT:rkw_etracker/Resources/Private/Language/locallang_db.xlf:tx_rkwetracker_domain_model_reportfilter.category_level4',
            'config' => array(
                'type' => 'select',
                'renderType' => 'selectSingle',
                'items' => array (
                    array('-', 0),
                ),
                'size' => 1,
                'minitems' => 0,
                'maxitems' => 1,
                'itemsProcFunc' => 'RKW\RkwEtracker\Hook\FilterSelector->getCategoryLabelsLevel4',
            ),
        ),
        'category_level5' => array(
            'displayCond' =>  'FIELD:category_free_level5:REQ:false',
            'exclude' => 0,
            'label' => 'LLL:EXT:rkw_etracker/Resources/Private/Language/locallang_db.xlf:tx_rkwetracker_domain_model_reportfilter.category_level5',
            'config' => array(
                'type' => 'select',
                'renderType' => 'selectSingle',
                'items' => array (
                    array('-', 0),
                ),
                'size' => 1,
                'minitems' => 0,
                'maxitems' => 1,
                'itemsProcFunc' => 'RKW\RkwEtracker\Hook\FilterSelector->getCategoryLabelsLevel5',
            ),
        ),
        'category_free_level1' => array(
            'exclude' => 0,
            'label' => 'LLL:EXT:rkw_etracker/Resources/Private/Language/locallang_db.xlf:tx_rkwetracker_domain_model_reportfilter.category_free_level1',
            'config' => array(
                'type' => 'input',
                'size' => 30,
                'eval' => 'trim'
            ),
        ),
        'category_free_level2' => array(
            'exclude' => 0,
            'label' => 'LLL:EXT:rkw_etracker/Resources/Private/Language/locallang_db.xlf:tx_rkwetracker_domain_model_reportfilter.category_free_level2',
            'config' => array(
                'type' => 'input',
                'size' => 30,
                'eval' => 'trim'
            ),
        ),
        'category_free_level3' => array(
            'exclude' => 0,
            'label' => 'LLL:EXT:rkw_etracker/Resources/Private/Language/locallang_db.xlf:tx_rkwetracker_domain_model_reportfilter.category_free_level3',
            'config' => array(
                'type' => 'input',
                'size' => 30,
                'eval' => 'trim'
            ),
        ),
        'category_free_level4' => array(
            'exclude' => 0,
            'label' => 'LLL:EXT:rkw_etracker/Resources/Private/Language/locallang_db.xlf:tx_rkwetracker_domain_model_reportfilter.category_free_level4',
            'config' => array(
                'type' => 'input',
                'size' => 30,
                'eval' => 'trim'
            ),
        ),
        'category_free_level5' => array(
            'exclude' => 0,
            'label' => 'LLL:EXT:rkw_etracker/Resources/Private/Language/locallang_db.xlf:tx_rkwetracker_domain_model_reportfilter.category_free_level5',
            'config' => array(
                'type' => 'input',
                'size' => 30,
                'eval' => 'trim'
            ),
        ),        
        'download_filter1' => array(
            'exclude' => 0,
            'label' => 'LLL:EXT:rkw_etracker/Resources/Private/Language/locallang_db.xlf:tx_rkwetracker_domain_model_reportfilter.download_filter1',
            'config' => array(
                'type' => 'select',
                'renderType' => 'selectSingle',
                'items' => array (
                    array('-', 0),
                ),
                'size' => 1,
                'minitems' => 0,
                'maxitems' => 1,
                'itemsProcFunc' => 'RKW\RkwEtracker\Hook\FilterSelector->getDownloadLabels',
            ),
        ),
        'download_filter2' => array(
            'exclude' => 0,
            'label' => 'LLL:EXT:rkw_etracker/Resources/Private/Language/locallang_db.xlf:tx_rkwetracker_domain_model_reportfilter.download_filter2',
            'config' => array(
                'type' => 'select',
                'renderType' => 'selectSingle',
                'items' => array (
                    array('-', 0),
                ),
                'size' => 1,
                'minitems' => 0,
                'maxitems' => 1,
                'itemsProcFunc' => 'RKW\RkwEtracker\Hook\FilterSelector->getDownloadLabels',
            ),
        ),
        'download_filter3' => array(
            'exclude' => 0,
            'label' => 'LLL:EXT:rkw_etracker/Resources/Private/Language/locallang_db.xlf:tx_rkwetracker_domain_model_reportfilter.download_filter3',
            'config' => array(
                'type' => 'select',
                'renderType' => 'selectSingle',
                'items' => array (
                    array('-', 0),
                ),
                'size' => 1,
                'minitems' => 0,
                'maxitems' => 1,
                'itemsProcFunc' => 'RKW\RkwEtracker\Hook\FilterSelector->getDownloadLabels',
            ),
        ),
        'download_free_filter1' => array(
            'exclude' => 0,
            'label' => 'LLL:EXT:rkw_etracker/Resources/Private/Language/locallang_db.xlf:tx_rkwetracker_domain_model_reportfilter.download_free_filter1',
            'config' => array(
                'type' => 'input',
                'size' => 30,
                'eval' => 'trim'
            ),
        ),
        'reportgroup' => array(
			'config' => array(
				'type' => 'passthrough',
			),
		),
	),
);