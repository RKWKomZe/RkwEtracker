<?php

namespace RKW\RkwEtracker\TCA;

use \RKW\RkwEtracker\Utility\CategoryUtility;

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
 * Class FilterSelector
 *
 * @author Steffen Kroggel <developer@steffenkroggel.de>
 * @copyright RKW Kompetenzzentrum
 * @package RKW_RkwEtracker
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 * @deprecated This class will be removed soon. Do not use it any more.
 */
class FilterSelector
{
    /**
     * Fetches filter for domain
     *
     * @params array &$params
     * @params object $pObj
     * @return void
     * @throws \TYPO3\CMS\Extbase\Object\Exception
     */
    public function getCombinedFilterLabels(array &$params, $pObj): void
    {

        $uid = intval($params['row']['uid']);
        $label = $params['row']['uid'];
        if ($uid) {

            /** @var \TYPO3\CMS\Extbase\Object\ObjectManager $objectManager */
            $objectManager = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance('TYPO3\CMS\Extbase\Object\ObjectManager');

            /** @var \RKW\RkwEtracker\Domain\Repository\ReportFilterRepository $reportFilterRepository */
            $reportFilterRepository = $objectManager->get('RKW\RkwEtracker\Domain\Repository\ReportFilterRepository');

            /** @var \RKW\RkwEtracker\Domain\Model\ReportFilter $filter */
            if ($filter = $reportFilterRepository->findByIdentifier(intval($uid))) {

                // add domain label
                $labelPre = '';
                $labelCategories = array();
                $labelDownloads = array();
                if ($filter->getDomainFree()) {
                    $labelPre = $filter->getDomainFree();
                } else {
                    if ($filter->getDomain()) {
                        $labelPre = $filter->getDomain();
                    }
                }

                // add regular labels
                $levels = range(1, 5);
                $levelCounter = 0;
                foreach ($levels as $level) {

                    $fieldName = 'categoryLevel' . strval(intval($level));
                    $getter = 'get' . ucfirst($fieldName);

                    $fieldNameFree = 'categoryFreeLevel' . strval(intval($level));
                    $getterFree = 'get' . ucfirst($fieldNameFree);

                    if (
                        (method_exists($filter, $getter))
                        && (method_exists($filter, $getterFree))
                    ) {
                        $filterValue = $filter->$getter();
                        $filterValueFree = $filter->$getterFree();

                        if ($filterValueFree) {
                            $labelCategories[] = '"' . $filterValueFree . '"';
                            $levelCounter++;
                        } else {
                            if ($filterValue) {
                                if (is_numeric($filterValue)) {
                                    $labelCategories[] = '-';
                                } else {
                                    $labelCategories[] = $filterValue;
                                    $levelCounter++;
                                }
                            } else {
                                $labelCategories[] = '-';
                            }
                        }
                    }
                }

                // add download labels
                $levels = range(1, 1);
                foreach ($levels as $level) {

                    $fieldName = 'downloadFilter' . strval(intval($level));
                    $getter = 'get' . ucfirst($fieldName);

                    $fieldNameFree = 'downloadFreeFilter' . strval(intval($level));
                    $getterFree = 'get' . ucfirst($fieldNameFree);

                    if (method_exists($filter, $getterFree)) {
                        $filterValueFree = $filter->$getterFree();

                        if ($filterValueFree) {
                            $labelDownloads[] = '"' . $filterValueFree . '"';
                        }
                    }

                    if (method_exists($filter, $getter)) {

                        $filterValue = $filter->$getter();
                        if (is_numeric($filterValue)) {
                            $labelDownloads[] = '-';
                        } else {
                            $labelDownloads[] = $filterValue;
                        }
                    }
                }

                if (
                    ($levelCounter)
                    || (!$labelPre)
                ) {
                    $label = implode(', ', $labelCategories) . '|' . implode(', ', $labelDownloads);
                } else {
                    $label = $labelPre . '|' . implode(', ', $labelDownloads);
                }
            }
        }

        $params['title'] = $label;
    }


    /**
     * Fetches filter for domain
     *
     * @params array &$params
     * @params object $pObj
     * @return void
     */
    public function getDomainLabels(array &$params, $pObj)
    {

        /** @var \TYPO3\CMS\Extbase\Object\ObjectManager $objectManager */
        $objectManager = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance('TYPO3\CMS\Extbase\Object\ObjectManager');

        /** @var \RKW\RkwEtracker\Domain\Repository\SysDomainRepository $sysDomainRepository */
        $sysDomainRepository = $objectManager->get('RKW\RkwEtracker\Domain\Repository\SysDomainRepository');
        $result = $sysDomainRepository->findAll();

        /** @var \RKW\RkwEtracker\Domain\Model\SysDomain $sysDomain */
        foreach ($result as $sysDomain) {

            if ($sysDomain->getDomainName()) {

                // just in case of using a DEV-Environment with LIVE-data
                $domain = str_replace('.local', '.de', $sysDomain->getDomainName());
                $params['items'][] = array($domain, $domain);

            }
        }

    }

    /**
     * Fetches filter for category level 1
     *
     * @params array &$params
     * @params object $pObj
     * @return void
     */
    public function getCategoryLabelsLevel1(array &$params, $pObj)
    {

        if (\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::isLoaded('rkw_projects')) {

            /** @var \TYPO3\CMS\Extbase\Object\ObjectManager $objectManager */
            $objectManager = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance('TYPO3\CMS\Extbase\Object\ObjectManager');

            /** @var \RKW\RkwBasics\Domain\Repository\DepartmentRepository $departmentRepository */
            $departmentRepository = $objectManager->get('RKW\RkwBasics\Domain\Repository\DepartmentRepository');
            $result = $departmentRepository->findAllSorted();

            /** @var \RKW\RkwBasics\Domain\Model\Department $department */
            foreach ($result as $department) {
                if ($department->getName()) {
                    $params['items'][] = array(($department->getInternalName() ? CategoryUtility::cleanUpCategoryName($department->getInternalName()) : CategoryUtility::cleanUpCategoryName($department->getName())), ($department->getInternalName() ? CategoryUtility::cleanUpCategoryName($department->getInternalName()) : CategoryUtility::cleanUpCategoryName($department->getName())));
                }
            }
        }
    }


    /**
     * Fetches filter for category level 2
     *
     * @params array &$params
     * @params object $pObj
     * @return void
     */
    public function getCategoryLabelsLevel2(array &$params, $pObj)
    {

        if (\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::isLoaded('rkw_projects')) {

            /** @var \TYPO3\CMS\Extbase\Object\ObjectManager $objectManager */
            $objectManager = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance(\TYPO3\CMS\Extbase\Object\ObjectManager::class);

            /** @var \RKW\RkwProjects\Domain\Repository\ProjectsRepository $projectRepository */
            $projectRepository = $objectManager->get(\RKW\RkwProjects\Domain\Repository\ProjectsRepository::class);
            $result = $projectRepository->findAllSorted();

            $params['items'][] = array('- DEFAULT - ', 'Default');

            /** @var \RKW\RkwProjects\Domain\Model\Projects $project */
            foreach ($result as $project) {
                if ($project->getName()) {
                    $params['items'][] = [
                        \RKW\RkwProjects\TCA\OptionLabels::getExtendedProjectName($project),
                        ($project->getInternalName() ? CategoryUtility::cleanUpCategoryName($project->getInternalName()) : CategoryUtility::cleanUpCategoryName($project->getName()))
                    ];
                }
            }
        }
    }


    /**
     * Fetches filter for category level 3
     *
     * @params array &$params
     * @params object $pObj
     * @return void
     */
    public function getCategoryLabelsLevel3(array &$params, $pObj)
    {

        if (\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::isLoaded('rkw_projects')) {

            /** @var \TYPO3\CMS\Extbase\Object\ObjectManager $objectManager */
            $objectManager = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance('TYPO3\CMS\Extbase\Object\ObjectManager');

            /** @var \RKW\RkwBasics\Domain\Repository\DocumentTypeRepository $documentTypeRepository */
            $documentTypeRepository = $objectManager->get('RKW\RkwBasics\Domain\Repository\DocumentTypeRepository');
            $result = $documentTypeRepository->findAllSorted();

            /** @var \RKW\RkwBasics\Domain\Model\DocumentType $documentType */
            foreach ($result as $documentType) {
                if ($documentType->getName()) {
                    $params['items'][] = array(($documentType->getInternalName() ? CategoryUtility::cleanUpCategoryName($documentType->getInternalName()) : CategoryUtility::cleanUpCategoryName($documentType->getName())), ($documentType->getInternalName() ? CategoryUtility::cleanUpCategoryName($documentType->getInternalName()) : CategoryUtility::cleanUpCategoryName($documentType->getName())));
                }
            }
        }
    }


    /**
     * Fetches filter for category level 4
     *
     * @params array &$params
     * @params object $pObj
     * @return void
     */
    public function getCategoryLabelsLevel4(array &$params, $pObj)
    {
        // nothing here
    }

    /**
     * Fetches filter for category level 5
     *
     * @params array &$params
     * @params object $pObj
     * @return void
     */
    public function getCategoryLabelsLevel5(array &$params, $pObj)
    {
        // nothing here
    }

    /**
     * Get all available download labels
     *
     * @params array &$params
     * @params object $pObj
     * @return void
     */
    public function getDownloadLabels(array &$params, $pObj)
    {

        if (\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::isLoaded('rkw_projects')) {

            /** @var \TYPO3\CMS\Extbase\Object\ObjectManager $objectManager */
            $objectManager = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance('TYPO3\CMS\Extbase\Object\ObjectManager');

            /** @var \RKW\RkwProjects\Domain\Repository\ProjectsRepository $projectRepository */
            $projectRepository = $objectManager->get('RKW\RkwProjects\Domain\Repository\ProjectsRepository');
            $result = $projectRepository->findAllSorted();

            $params['items'][] = array('- DEFAULT - ', 'Default');

            /** @var \RKW\RkwProjects\Domain\Model\Projects $project */
            foreach ($result as $project) {
                if ($project->getName()) {
                    $params['items'][] = array(($project->getInternalName() ? CategoryUtility::cleanUpCategoryName($project->getInternalName()) : CategoryUtility::cleanUpCategoryName($project->getName())), ($project->getInternalName() ? CategoryUtility::cleanUpCategoryName($project->getInternalName()) : CategoryUtility::cleanUpCategoryName($project->getName())));
                }
            }
        }
    }


}
