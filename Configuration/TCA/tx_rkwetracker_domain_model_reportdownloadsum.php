<?php
return array(
	'ctrl' => array(
		'title'	=> 'LLL:EXT:rkw_etracker/Resources/Private/Language/locallang_db.xlf:tx_rkwetracker_domain_model_reportdownloadsum',
		'label' => 'time_per_event',
		'tstamp' => 'tstamp',
		'crdate' => 'crdate',
		'cruser_id' => 'cruser_id',
        'dividers2tabs' => true,
        'hideTable' => true,

		'enablecolumns' => array(

		),
		'searchFields' => 'time_per_event,events,unique_events,report,report_fetch_counter,month,quarter,year,',
		'iconfile' => 'EXT:rkw_etracker/Resources/Public/Icons/tx_rkwetracker_domain_model_reportdownloadsum.gif'
	),
	'interface' => array(
		'showRecordFieldList' => 'time_per_event, events, unique_events, report, report_group, report_fetch_counter, month, quarter, year',
	),
	'types' => array(
		'1' => array('showitem' => 'time_per_event, events, unique_events, report, report_group, report_fetch_counter, month, quarter, year, '),
	),
	'palettes' => array(
		'1' => array('showitem' => ''),
	),
	'columns' => array(

		'time_per_event' => array(
			'exclude' => 0,
			'label' => 'LLL:EXT:rkw_etracker/Resources/Private/Language/locallang_db.xlf:tx_rkwetracker_domain_model_reportdownloadsum.time_per_event',
			'config' => array(
				'type' => 'input',
				'size' => 4,
				'eval' => 'int'
			)
		),
		'events' => array(
			'exclude' => 0,
			'label' => 'LLL:EXT:rkw_etracker/Resources/Private/Language/locallang_db.xlf:tx_rkwetracker_domain_model_reportdownloadsum.events',
			'config' => array(
				'type' => 'input',
				'size' => 4,
				'eval' => 'int'
			)
		),
		'unique_events' => array(
			'exclude' => 0,
			'label' => 'LLL:EXT:rkw_etracker/Resources/Private/Language/locallang_db.xlf:tx_rkwetracker_domain_model_reportdownloadsum.unique_events',
			'config' => array(
				'type' => 'input',
				'size' => 30,
				'eval' => 'int'
			),
		),
		'report' => array(
			'exclude' => 0,
			'label' => 'LLL:EXT:rkw_etracker/Resources/Private/Language/locallang_db.xlf:tx_rkwetracker_domain_model_reportdownloadsum.report',
			'config' => array(
                'type' => 'select',
                'renderType' => 'selectSingle',
                'foreign_table' => 'tx_rkwetracker_domain_model_report',
                'foreign_table_where' => ' ORDER BY tx_rkwetracker_domain_model_report.name ASC',
                'maxitems'      => 1,
                'minitems'      => 1,
                'size'          => 5,
			)
		),
        'report_group' => array(
            'exclude' => 0,
            'label' => 'LLL:EXT:rkw_etracker/Resources/Private/Language/locallang_db.xlf:tx_rkwetracker_domain_model_reportdownloadsum.report_group',
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
        'report_fetch_counter' => array(
			'exclude' => 0,
			'label' => 'LLL:EXT:rkw_etracker/Resources/Private/Language/locallang_db.xlf:tx_rkwetracker_domain_model_reportdownloadsum.report_fetch_counter',
			'config' => array(
				'type' => 'input',
				'size' => 30,
				'eval' => 'trim',
                'readOnly' => true,
			),
		),
		'month' => array(
			'exclude' => 0,
			'label' => 'LLL:EXT:rkw_etracker/Resources/Private/Language/locallang_db.xlf:tx_rkwetracker_domain_model_reportdownloadsum.month',
			'config' => array(
				'type' => 'input',
				'size' => 30,
				'eval' => 'trim'
			),
		),
		'quarter' => array(
			'exclude' => 0,
			'label' => 'LLL:EXT:rkw_etracker/Resources/Private/Language/locallang_db.xlf:tx_rkwetracker_domain_model_reportdownloadsum.quarter',
			'config' => array(
				'type' => 'input',
				'size' => 30,
				'eval' => 'trim'
			),
		),
		'year' => array(
			'exclude' => 0,
			'label' => 'LLL:EXT:rkw_etracker/Resources/Private/Language/locallang_db.xlf:tx_rkwetracker_domain_model_reportdownloadsum.year',
			'config' => array(
				'type' => 'input',
				'size' => 30,
				'eval' => 'trim'
			),
		),
		
	),
);