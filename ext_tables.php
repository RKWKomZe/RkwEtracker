<?php
defined('TYPO3_MODE') || die('Access denied.');

call_user_func(
    function($extKey)
    {

        //=================================================================
        // Register Plugins
        //=================================================================
        \TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerPlugin(
            $extKey,
            'Pi1',
            'RKW eTracker Tracklet'
        );

        \TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerPlugin(
            $extKey,
            'Pi2',
            'RKW eTracker Redirect'
        );

        \TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerPlugin(
            $extKey,
            'Pi3',
            'RKW eTracker OptOut'
        );

        //=================================================================
        // Add TypoScript
        //=================================================================
        \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addStaticFile(
            $extKey,
            'Configuration/TypoScript',
            'RKW eTracker'
        );

    },
    $_EXTKEY
);
