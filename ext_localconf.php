<?php
defined('TYPO3_MODE') || die('Access denied.');

call_user_func(
    function($extKey)
    {

        //=================================================================
        // Configure Plugins
        //=================================================================
        \TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
            'RKW.' . $extKey,
            'Pi1',
            [
                'Code' => 'show'
            ],
            // non-cacheable actions
           [
                'Code' => 'show',
           ]
        );

        \TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
            'RKW.' . $extKey,
            'Pi2',
            [
                'Redirect' => 'redirect',
            ],
            // non-cacheable actions
            [
                'Redirect' => 'redirect',
            ]
        );

        \TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
            'RKW.' . $extKey,
            'Pi3',
            [
                'Code' => 'optOut'
            ],
            // non-cacheable actions
            []
        );

        //=================================================================
        // Register Command Controller
        //=================================================================
        $GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['extbase']['commandControllers'][] = 'RKW\\RkwEtracker\\Controller\\ReportCommandController';

        //=================================================================
        // Add rootline fields
        //=================================================================
        $rootlineFields = &$GLOBALS['TYPO3_CONF_VARS']['FE']['addRootLineFields'];
        $newRootlineFields = 'tx_rkwetracker_category_level1,tx_rkwetracker_category_level2,tx_rkwetracker_category_level3,tx_rkwetracker_category_level4,tx_rkwetracker_category_level5';
        $rootlineFields .= (empty($rootlineFields))? $newRootlineFields : ',' . $newRootlineFields;

        //=================================================================
        // Configure Logger
        //=================================================================
        $GLOBALS['TYPO3_CONF_VARS']['LOG']['RKW']['RkwEtracker']['writerConfiguration'] = array(

            // configuration for WARNING severity, including all
            // levels with higher severity (ERROR, CRITICAL, EMERGENCY)
            \TYPO3\CMS\Core\Log\LogLevel::DEBUG => array(

                // add a FileWriter
                'TYPO3\\CMS\\Core\\Log\\Writer\\FileWriter' => array(
                    // configuration for the writer
                    'logFile' => 'typo3temp/var/logs/tx_rkwetracker.log'
                )
            ),
        );
    },
    $_EXTKEY
);


