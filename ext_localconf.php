<?php
if (!defined('TYPO3_MODE')) {
	die('Access denied.');
}


\TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
    'RKW.' . $_EXTKEY,
    'Pi1',
    array(
        'Code' => 'show',
    ),
    // non-cacheable actions
    array(
        'Code' => 'show',
    )
);

\TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
    'RKW.' . $_EXTKEY,
    'Pi2',
    array(
        'Redirect' => 'redirect',
    ),
    // non-cacheable actions
    array(
        'Redirect' => 'redirect',
    )
);

// register command controller (cronjob)
$GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['extbase']['commandControllers'][] = 'RKW\\RkwEtracker\\Controller\\ReportCommandController';

// Add rootline fields
$GLOBALS['TYPO3_CONF_VARS']['FE']['addRootLineFields'] .= ',tx_rkwetracker_category_level1,tx_rkwetracker_category_level2,tx_rkwetracker_category_level3,tx_rkwetracker_category_level4,tx_rkwetracker_category_level5';

// set logger
$GLOBALS['TYPO3_CONF_VARS']['LOG']['RKW']['RkwEtracker']['writerConfiguration'] = array(

	// configuration for WARNING severity, including all
	// levels with higher severity (ERROR, CRITICAL, EMERGENCY)
	\TYPO3\CMS\Core\Log\LogLevel::DEBUG => array(
	// add a FileWriter
		'TYPO3\\CMS\\Core\\Log\\Writer\\FileWriter' => array(
			// configuration for the writer
			'logFile' => 'typo3temp/logs/tx_rkwetracker.log'
		)
	),
);