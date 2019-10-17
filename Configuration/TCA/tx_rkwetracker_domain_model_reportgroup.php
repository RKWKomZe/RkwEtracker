<?php
return array(
	'ctrl' => array(
		'title'	=> 'LLL:EXT:rkw_etracker/Resources/Private/Language/locallang_db.xlf:tx_rkwetracker_domain_model_reportgroup',
		'label' => 'name',
		'tstamp' => 'tstamp',
		'crdate' => 'crdate',
		'cruser_id' => 'cruser_id',
		'dividers2tabs' => TRUE,
        'default_sortby' => 'name',

		'delete' => 'deleted',
		'enablecolumns' => array(

		),
		'searchFields' => 'name,description,filter,',
		'iconfile' => 'EXT:rkw_etracker/Resources/Public/Icons/tx_rkwetracker_domain_model_reportgroup.gif'
	),
	'interface' => array(
		'showRecordFieldList' => 'name, description',
	),
	'types' => array(
		'1' => array('showitem' => 'name, description, filter'),
	),
	'palettes' => array(
		'1' => array('showitem' => ''),
	),
	'columns' => array(

		'name' => array(
			'exclude' => 0,
			'label' => 'LLL:EXT:rkw_etracker/Resources/Private/Language/locallang_db.xlf:tx_rkwetracker_domain_model_reportgroup.name',
			'config' => array(
				'type' => 'input',
				'size' => 30,
				'eval' => 'trim,required'
			),
		),
		'description' => array(
			'exclude' => 0,
			'label' => 'LLL:EXT:rkw_etracker/Resources/Private/Language/locallang_db.xlf:tx_rkwetracker_domain_model_reportgroup.description',
			'config' => array(
				'type' => 'text',
				'size' => 30,
				'eval' => 'trim',
                'cols' => 30,
                'rows' => 10
			),
		),
		'filter' => array(
			'exclude' => 0,
			'label' => 'LLL:EXT:rkw_etracker/Resources/Private/Language/locallang_db.xlf:tx_rkwetracker_domain_model_reportgroup.filter',
			'config' => array(
				'type' => 'inline',
				'foreign_table' => 'tx_rkwetracker_domain_model_reportfilter',
				'foreign_field' => 'reportgroup',
				/* 'foreign_sortby' => 'sorting', */
                'foreign_default_sortby' => 'domain, domain_free, category_level1, category_level2',
				'maxitems' => 9999,
                'minitems' => 1,
				'appearance' => array(
					'collapseAll' => 1,
					'levelLinksPosition' => 'top',
					'showSynchronizationLink' => 1,
					'showPossibleLocalizationRecords' => 1,
					'useSortable' => 0,
					'showAllLocalizationLink' => 1,
                    'enabledControls' => array (
                        'info' => true,
                        'new' => true,
                        'dragdrop' => false,
                        'sort' => false,
                        'hide' => false,
                        'delete' => true,
                        'localize' => false,
                    ),
				),
			),

		),
		
		'report' => array(
			'config' => array(
				'type' => 'passthrough',
			),
		),
	),
);