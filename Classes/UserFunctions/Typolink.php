<?php

use RKW\RkwEtracker\Helpers\CategoryHelper;
use \TYPO3\CMS\Core\Utility\GeneralUtility;

/*
 * This file is part of the TYPO3 CMS project.
 *
 * It is free software; you can redistribute it and/or modify it under
 * the terms of the GNU General Public License, either version 2
 * of the License, or any later version.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 *
 * The TYPO3 project - inspiring people to share!
 */

/**
 * Class Typolink
 *
 * @author Steffen Kroggel <developer@steffenkroggel.de>
 * @copyright Rkw Kompetenzzentrum
 * @package RKW_RkwEtracker
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 */
class Typolink
{

    /**
     * Change TypoLink and add data-attribute with project
     *
     * @param string $data
     * @param array $conf
     * @return string
     */
    public function getParsedLink($data = '', $conf = array())
    {

        $fileIdentifier = null;
        $projectName = '';
        if ($data['TYPE'] == 'file') {

            $fileIdentifier = preg_replace('/^((.+)\/)?fileadmin/', '', $data['url']);
            $fileNameArray = explode(DIRECTORY_SEPARATOR, $data['url']);
            $fileName = addslashes($fileNameArray[count($fileNameArray) - 1]);
            if (\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::isLoaded('rkw_projects')) {

                // get name of project
                $resource = $GLOBALS['TYPO3_DB']->exec_SELECTquery(
                    'tx_rkwprojects_domain_model_projects.*',
                    'sys_file
                    LEFT JOIN sys_file_metadata ON (sys_file.uid = sys_file_metadata.file)
                    LEFT JOIN tx_rkwprojects_domain_model_projects ON (tx_rkwprojects_domain_model_projects.uid = sys_file_metadata.tx_rkwprojects_project_uid)',
                    'identifier = "' . addslashes($fileIdentifier) . '"',
                    $groupBy = '',
                    $orderBy = '',
                    $limit = ''
                );

                $result = array();
                if ($resource) {
                    while ($record = $GLOBALS['TYPO3_DB']->sql_fetch_assoc($resource)) {
                        $result = $record;
                        break;
                        //===
                    }
                }

                // free memory of query
                $GLOBALS['TYPO3_DB']->sql_free_result($resource);

                // set data-attribute for project name
                $projectName = CategoryHelper::cleanUp($result['internal_name'] ? $result['internal_name'] : ($result['short_name'] ? $result['short_name'] : $result['name']));
            }

            // set data-attribute for file name
            if ($fileName) {
                $data['TAG'] = str_replace('href=', 'data-etracker-object="' . urlencode($fileName) . '" href=', $data['TAG']);
            }
        }

        // get hostname and use it as prefix
        $hostname = GeneralUtility::getIndpEnv('TYPO3_HOST_ONLY');
        if ($projectName) {
            $data['TAG'] = str_replace('href=', 'data-etracker-category="' . urlencode($hostname . '/' . $projectName) . '" href=', $data['TAG']);
        } else {
            $data['TAG'] = str_replace('href=', 'data-etracker-category="' . urlencode($hostname) . '" href=', $data['TAG']);
        }

        // add link type
        $data['TAG'] = str_replace('href=', 'data-etracker-action="' . urlencode(strtolower($data['TYPE'])) . '" href=', $data['TAG']);

        return $data['TAG'];
        //===
    }

}