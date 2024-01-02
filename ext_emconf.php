<?php

/***************************************************************
 * Extension Manager/Repository config file for ext: "rkw_etracker"
 *
 * Auto generated by Extension Builder 2017-03-15
 *
 * Manual updates:
 * Only the data in the array - anything else is removed by next write.
 * "version" and "dependencies" must not be touched!
 ***************************************************************/

$EM_CONF[$_EXTKEY] = [
	'title' => 'RKW eTracker',
	'description' => 'Extension for reportings based on eTracker (see https://etracker.de]',
	'category' => 'plugin',
	'author' => 'Steffen Kroggel',
	'author_email' => 'developer@steffenkroggel,de',
	'state' => 'stable',
	'internal' => '',
	'uploadfolder' => '0',
	'createDirs' => '',
	'clearCacheOnLoad' => 0,
	'version' => '9.5.11',
	'constraints' => [
		'depends' => [
            'typo3' => '9.5.0-10.4.99',
            'core_extended' => '9.5.4-10.4.99',
            'postmaster' => '9.5.0-10.4.99',
            'rkw_basics' => '9.5.0-10.4.99'
		],
		'conflicts' => [
		],
		'suggests' => [
		],
	],
];
