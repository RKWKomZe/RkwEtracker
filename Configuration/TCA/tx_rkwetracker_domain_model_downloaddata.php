<?php
return array(
	'ctrl' => array(
		'title'	=> 'LLL:EXT:rkw_etracker/Resources/Private/Language/locallang_db.xlf:tx_rkwetracker_domain_model_downloaddata',
		'label' => 'action',
		'tstamp' => 'tstamp',
		'crdate' => 'crdate',
		'cruser_id' => 'cruser_id',
		'dividers2tabs' => true,
        'hideTable' => true,

		'enablecolumns' => array(

		),
		'searchFields' => 'action,category,time_per_event,events,unique_events,month,quarter,year,',
		'iconfile' => 'EXT:rkw_etracker/Resources/Public/Icons/tx_rkwetracker_domain_model_downloaddata.gif'
	),
	'interface' => array(
		'showRecordFieldList' => 'action, category, time_per_event, events, unique_events, report, report_fetch_counter, month, quarter, year',
	),
	'types' => array(
		'1' => array('showitem' => 'action, category, time_per_event, events, unique_events, report, report_fetch_counter, month, quarter, year'),
	),
	'palettes' => array(
		'1' => array('showitem' => ''),
	),
	'columns' => array(

        'report' => array(
            'exclude' => 0,
            'label' => 'LLL:EXT:rkw_etracker/Resources/Private/Language/locallang_db.xlf:tx_rkwetracker_domain_model_downloaddata.report',
            'config' => array(
                'type' => 'select',
                'renderType' => 'selectSingle',
                'foreign_table' => 'tx_rkwetracker_domain_model_report',
                'foreign_table_where' => ' ORDER BY tx_rkwetracker_domain_model_report.name ASC',
                'maxitems'      => 1,
                'minitems'      => 1,
                'size'          => 5,
            ),
        ),
        'report_group' => array(
            'exclude' => 0,
            'label' => 'LLL:EXT:rkw_etracker/Resources/Private/Language/locallang_db.xlf:tx_rkwetracker_domain_model_downloaddata.report_group',
            'config' => array(
                'type' => 'select',
                'renderType' => 'selectSingle',
                'foreign_table' => 'tx_rkwetracker_domain_model_reportgroup',
                'foreign_table_where' => ' ORDER BY tx_rkwetracker_domain_model_reportgroup.name ASC',
                'maxitems'      => 1,
                'minitems'      => 1,
                'size'          => 5,
            ),
        ),
        'report_filter' => array(
            'exclude' => 0,
            'label' => 'LLL:EXT:rkw_etracker/Resources/Private/Language/locallang_db.xlf:tx_rkwetracker_domain_model_downloaddata.report_filter',
            'config' => array(
                'type' => 'select',
                'renderType' => 'selectSingle',
                'foreign_table' => 'tx_rkwetracker_domain_model_reportfilter',
                'foreign_table_where' => ' ORDER BY tx_rkwetracker_domain_model_reportfilter.domain ASC, tx_rkwetracker_domain_model_reportfilter.domain_free ASC',
                'maxitems'      => 1,
                'minitems'      => 1,
                'size'          => 5,
            ),
        ),
        'report_fetch_counter' => array(
            'exclude' => 1,
            'label' => 'LLL:EXT:rkw_etracker/Resources/Private/Language/locallang_db.xlf:tx_rkwetracker_domain_model_downloaddata.report_fetch_counter',
            'config' => array(
                'type' => 'input',
                'size' => 13,
                'max' => 20,
                'eval' => 'int',
                'readOnly' => true,
            ),
        ),
		'action' => array(
			'exclude' => 0,
			'label' => 'LLL:EXT:rkw_etracker/Resources/Private/Language/locallang_db.xlf:tx_rkwetracker_domain_model_downloaddata.action',
			'config' => array(
				'type' => 'input',
				'size' => 30,
				'eval' => 'trim'
			),
		),
		'category' => array(
			'exclude' => 0,
			'label' => 'LLL:EXT:rkw_etracker/Resources/Private/Language/locallang_db.xlf:tx_rkwetracker_domain_model_downloaddata.category',
			'config' => array(
				'type' => 'input',
				'size' => 30,
				'eval' => 'trim'
			),
		),
		'time_per_event' => array(
			'exclude' => 0,
			'label' => 'LLL:EXT:rkw_etracker/Resources/Private/Language/locallang_db.xlf:tx_rkwetracker_domain_model_downloaddata.time_per_event',
			'config' => array(
				'type' => 'input',
				'size' => 30,
				'eval' => 'int'
			),
		),
		'events' => array(
			'exclude' => 0,
			'label' => 'LLL:EXT:rkw_etracker/Resources/Private/Language/locallang_db.xlf:tx_rkwetracker_domain_model_downloaddata.events',
			'config' => array(
				'type' => 'input',
				'size' => 30,
				'eval' => 'int'
			),
		),
		'unique_events' => array(
			'exclude' => 0,
			'label' => 'LLL:EXT:rkw_etracker/Resources/Private/Language/locallang_db.xlf:tx_rkwetracker_domain_model_downloaddata.unique_events',
			'config' => array(
				'type' => 'input',
				'size' => 30,
				'eval' => 'int'
			),
		),
        'month' => array(
            'exclude' => 0,
            'label' => 'LLL:EXT:rkw_etracker/Resources/Private/Language/locallang_db.xlf:tx_rkwetracker_domain_model_downloaddata.month',
            'config' => array(
                'type' => 'input',
                'size' => 4,
                'eval' => 'int'
            )
        ),
        'quarter' => array(
            'exclude' => 0,
            'label' => 'LLL:EXT:rkw_etracker/Resources/Private/Language/locallang_db.xlf:tx_rkwetracker_domain_model_downloaddata.quarter',
            'config' => array(
                'type' => 'input',
                'size' => 30,
                'eval' => 'int'
            ),
        ),
        'year' => array(
            'exclude' => 0,
            'label' => 'LLL:EXT:rkw_etracker/Resources/Private/Language/locallang_db.xlf:tx_rkwetracker_domain_model_downloaddata.year',
            'config' => array(
                'type' => 'input',
                'size' => 30,
                'eval' => 'int'
            ),
        ),		
	),
);