<?php

namespace RKW\RkwEtracker\Utility;

use TYPO3\CMS\Extbase\Object\ObjectManager;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Core\Utility\ExtensionManagementUtility;
use RKW\RkwEtracker\Utility\CategoryUtility;
use TYPO3\CMS\Core\LinkHandling\LinkService;
use TYPO3\CMS\Core\Utility\VersionNumberUtility;


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
 * Class LinkUtility
 *
 * @author Steffen Kroggel <developer@steffenkroggel.de>
 * @copyright RKW Kompetenzzentrum
 * @package RKW_RkwEtracker
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 */
class TypolinkUtility extends \TYPO3\CMS\Frontend\ContentObject\ContentObjectRenderer
{


    /**
     * @var \TYPO3\CMS\Core\Log\Logger
     */
    protected $logger;


    /**
     * Get data-attributes for files
     *
     * @param string $typolink
     * @param string $linkType
     * @return array
     */
    public function getDataAttributes($typolink, $linkType = '')
    {

        // determine version
        $currentVersion = VersionNumberUtility::convertVersionNumberToInteger(TYPO3_version);
        $dataTags = [];

        // define dataTags array
        $fileLinkType = 'file';
        if ($currentVersion >= 8000000) {
            $fileLinkType = LinkService::TYPE_FILE;
        }

        try {

            // if no link type is given, we need to detect it
            if (! $linkType) {
                $linkType = $this->getLinkType($typolink);
            }

            // set defaults
            $dataTags = [
                'data-etracker-action' => ($linkType ? $linkType : 'Default'),
                'data-etracker-category' => GeneralUtility::getIndpEnv('TYPO3_HOST_ONLY') . '/Default'
            ];

            // only do this on files!
            if ($linkType == $fileLinkType) {

                /** @var \TYPO3\CMS\Core\Resource\File $file */
                if (
                    ($file = $this->getFileObject($typolink))
                    && ($file instanceof \TYPO3\CMS\Core\Resource\File)
                ) {

                    // add filename
                    $dataTags['data-etracker-object'] = $file->getName();

                    // check for project-extension and get project data
                    if (ExtensionManagementUtility::isLoaded('rkw_projects')) {

                        if ($projectId = $file->getProperty('tx_rkwprojects_project_uid')) {

                            /** @var \TYPO3\CMS\Extbase\Object\ObjectManager $objectManager */
                            $objectManager = GeneralUtility::makeInstance(ObjectManager::class);

                            /** @var \RKW\RkwProjects\Domain\Repository\ProjectsRepository $projectsRepository */
                            $projectsRepository = $objectManager->get(\RKW\RkwProjects\Domain\Repository\ProjectsRepository::class);

                            /** @var \RKW\RkwProjects\Domain\Model\Projects $project */
                            if ($project = $projectsRepository->findByIdentifier($projectId)) {

                                // override category with project-name
                                $projectName = ($project->getInternalName() ? $project->getInternalName() : ($project->getShortName() ? $project->getShortName() : $project->getName()));
                                $dataTags['data-etracker-category'] = GeneralUtility::getIndpEnv('TYPO3_HOST_ONLY')  . '/' . CategoryUtility::cleanUpCategoryName($projectName);
                            }
                        }
                    }
                }
            }

            $this->getLogger()->log(\TYPO3\CMS\Core\Log\LogLevel::DEBUG, sprintf('Resulting data-attributes of typolink "%s": %s.', $typolink, str_replace("\n", '', print_r($dataTags, true))));

        } catch (\Exception $e) {
            $this->getLogger()->log(\TYPO3\CMS\Core\Log\LogLevel::ERROR, $e->getMessage());
        }

        return $dataTags;
    }



    /**
     * Get file object by typolink
     *
     * @param string $typolink
     * @return \TYPO3\CMS\Core\Resource\File|null
     */
    public function getFileObject(string $typolink)
    {

        $currentVersion = VersionNumberUtility::convertVersionNumberToInteger(TYPO3_version);

        // For TYPO3 >= 8.0
        if ($currentVersion >= 8000000) {

            // Detecting kind of link and resolve all necessary parameters
            /** @var \TYPO3\CMS\Core\LinkHandling\LinkService $linkService */
            $linkService = GeneralUtility::makeInstance(LinkService::class);
            $linkDetails = $linkService->resolve($typolink);
            if ($linkDetails['file'] instanceof \TYPO3\CMS\Core\Resource\File) {
                return $linkDetails['file'];
            }
        }

        // For TYPO3 < 8.0
        /** @var \TYPO3\CMS\Core\Resource\ResourceFactory $resourceFactory */
        $resourceFactory = \TYPO3\CMS\Core\Resource\ResourceFactory::getInstance();
        try {

            /** @var \TYPO3\CMS\Core\Resource\File $file */
            if (
                ($file = $resourceFactory->retrieveFileOrFolderObject($typolink))
                && ($file instanceof \TYPO3\CMS\Core\Resource\File)
            ){
                return $file;
            }

        } catch (\Exception $e) {
            // e.g. element wasn't found
        }

        return null;
    }


    /**
     * Get link type
     *
     * @param string $typolink
     * @return string
     * @see: https://docs.typo3.org/m/typo3/reference-typoscript/master/en-us/Functions/Typolink.html#resource-references
     */
    public function getLinkType (string $typolink)
    {

        $currentVersion = VersionNumberUtility::convertVersionNumberToInteger(TYPO3_version);

        // For TYPO3 >= 8.0
        if ($currentVersion >= 8000000) {

            // remove additional params from link. This is needed because the fileHandler is not working properly
            // --> The UID of file has to be numeric. UID given: "8563 - - "zum Flyer RKW-Mitgliedschaft""
            $typolinkCleaned = explode(' ', $typolink);

            // Detecting kind of link and resolve all necessary parameters
            /** @var \TYPO3\CMS\Core\LinkHandling\LinkService $linkService*/
            $linkService = GeneralUtility::makeInstance(LinkService::class);
            $linkDetails = $linkService->resolve($typolinkCleaned[0]);
            $linkType = $linkDetails['type'];

        // For TYPO3 < 8.0
        } else {

            // detect link type based on core method
            $linkType = $this->detectLinkTypeFromLinkParameter($typolink);

            /**
             * in case the FAL is used, we need a separate handling
             * @see \TYPO3\CMS\Frontend\ContentObject\ContentObjectRenderer->resolveMixedLinkParameter
             */
            if (
                (strpos($typolink, 'file:') !== false)
                && (strpos($typolink, 'file://') == false)
            ) {
                $linkType = 'file';
            }
        }

        return $linkType;
    }


    /**
     * Returns logger instance
     *
     * @return \TYPO3\CMS\Core\Log\Logger
     */
    protected function getLogger()
    {

        if (!$this->logger instanceof \TYPO3\CMS\Core\Log\Logger) {
            $this->logger = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance('TYPO3\CMS\Core\Log\LogManager')->getLogger(__CLASS__);
        }

        return $this->logger;
    }

}
