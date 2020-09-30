<?php
defined('TYPO3_MODE') || die('Access denied.');

//=================================================================
// Register Plugins
//=================================================================
\TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerPlugin(
    'RKW.RkwEtracker',
    'Pi1',
    'RKW eTracker Tracklet'
);

\TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerPlugin(
    'RKW.RkwEtracker',
    'Pi2',
    'RKW eTracker Redirect'
);

\TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerPlugin(
    'RKW.RkwEtracker',
    'Pi3',
    'RKW eTracker OptOut'
);