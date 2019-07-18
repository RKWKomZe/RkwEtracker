<?php

namespace RKW\RkwEtracker\Utility;

use TYPO3\CMS\Extbase\Object\ObjectManager;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Core\Utility\ExtensionManagementUtility;
use RKW\RkwEtracker\Helpers\CategoryHelper;

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
 * @copyright Rkw Kompetenzzentrum
 * @package RKW_RkwEtracker
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 */
class TypolinkUtility extends \TYPO3\CMS\Frontend\ContentObject\ContentObjectRenderer
{

    /**
     * Get data-attributes for files
     *
     * @param string $typolink
     * @param string $linkType
     * @return array
     */
    public function getDataAttributes($typolink, $linkType = '')
    {

        // if no link type is given we have to detect it on our own
        if (! $linkType) {

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


        // define dataTags array
        $dataTags = [
            'data-etracker-action' => $linkType,
            'data-etracker-category' => GeneralUtility::getIndpEnv('TYPO3_HOST_ONLY')
        ];


        // only do this on files!
        if ($linkType == 'file') {

            /** @var \TYPO3\CMS\Core\Resource\File $file */
            if ($file = $this->getFileObject($typolink)) {

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

                            // add project name to category
                            $projectName = ($project->getInternalName() ? $project->getInternalName() : ($project->getShortName() ? $project->getShortName() : $project->getName()));
                            $dataTags['data-etracker-category'] .= '/' . CategoryHelper::cleanUp($projectName);
                        }
                    }
                }
            }
        }

        return $dataTags;
    }



    /**
     * Get file object by fileHandle
     *
     * @param mixed $fileHandle
     * @return \TYPO3\CMS\Core\Resource\File|null
     */
    public function getFileObject($fileHandle)
    {
        /** @var \TYPO3\CMS\Core\Resource\ResourceFactory $resourceFactory */
        $resourceFactory = \TYPO3\CMS\Core\Resource\ResourceFactory::getInstance();

        try {

            /** @var \TYPO3\CMS\Core\Resource\File $file */
            if (
                ($file = $resourceFactory->retrieveFileOrFolderObject($fileHandle))
                && ($file instanceof \TYPO3\CMS\Core\Resource\File)
            ){
                return $file;
            }

        } catch (\Exception $e) {
            // e.g. element wasn't found
        }

        return null;
    }


}