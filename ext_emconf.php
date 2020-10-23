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
	'version' => '8.7.52',
	'constraints' => [
		'depends' => [
            'typo3' => '7.6.0-8.7.99',
            'rkw_basics' => '8.7.0-8.7.99',
            'rkw_mailer' => '8.7.0-8.7.99',
		],
		'conflicts' => [
		],
		'suggests' => [
		],
	],
];