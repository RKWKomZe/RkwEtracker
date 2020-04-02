<?php

namespace RKW\RkwEtracker\ViewHelpers\Link;

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

use TYPO3\CMS\Core\Utility\VersionNumberUtility;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Object\ObjectManager;
use TYPO3Fluid\Fluid\Core\Rendering\RenderingContextInterface;
use RKW\RkwEtracker\Utility\TypolinkUtility;

$currentVersion = VersionNumberUtility::convertVersionNumberToInteger(TYPO3_version);
if ($currentVersion < 8000000) {

    /**
     * Class TypolinkViewHelper
     *
     * @author Steffen Kroggel <developer@steffenkroggel.de>
     * @copyright Rkw Kompetenzzentrum
     * @package RKW_RkwEtracker
     * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
     */
    class TypolinkViewHelper extends \TYPO3\CMS\Fluid\ViewHelpers\Link\TypolinkViewHelper
    {

        /**
         * Render
         *
         * @param array $arguments
         * @param \Closure $renderChildrenClosure
         * @param \TYPO3\CMS\Fluid\Core\Rendering\RenderingContextInterface $renderingContext
         * @return mixed|string
         * @throws \InvalidArgumentException
         * @throws \UnexpectedValueException
         */
        public static function renderStatic(
            array $arguments,
            \Closure $renderChildrenClosure,
            \TYPO3\CMS\Fluid\Core\Rendering\RenderingContextInterface $renderingContext
        ){

            /** @var \TYPO3\CMS\Extbase\Object\ObjectManager $objectManager */
            $objectManager = GeneralUtility::makeInstance(ObjectManager::class);

            /** @var \RKW\RkwEtracker\Utility\TypolinkUtility $typolinkUtility */
            $typolinkUtility = $objectManager->get(TypolinkUtility::class);

            // get data attributes for given handle
            $dataAttributes = $typolinkUtility->getDataAttributes($arguments['parameter']);
            $arguments['additionalAttributes'] = array_merge($arguments['additionalAttributes'], $dataAttributes);

            return parent::renderStatic($arguments, $renderChildrenClosure, $renderingContext);

        }
    }

} else {


    /**
     * Class TypolinkViewHelper
     *
     * @author Steffen Kroggel <developer@steffenkroggel.de>
     * @copyright Rkw Kompetenzzentrum
     * @package RKW_RkwEtracker
     * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
     */
    class TypolinkViewHelper extends \TYPO3\CMS\Fluid\ViewHelpers\Link\TypolinkViewHelper
    {

        /**
         * Render
         *
         * @param array $arguments
         * @param \Closure $renderChildrenClosure
         * @param RenderingContextInterface $renderingContext
         * @return mixed|string
         * @throws \InvalidArgumentException
         * @throws \UnexpectedValueException
         */
        public static function renderStatic(
            array $arguments,
            \Closure $renderChildrenClosure,
            RenderingContextInterface $renderingContext
        ) {

            /** @var \TYPO3\CMS\Extbase\Object\ObjectManager $objectManager */
            $objectManager = GeneralUtility::makeInstance(ObjectManager::class);

            /** @var \RKW\RkwEtracker\Utility\TypolinkUtility $typolinkUtility */
            $typolinkUtility = $objectManager->get(TypolinkUtility::class);

            // get data attributes for given handle
            $dataAttributes = $typolinkUtility->getDataAttributes($arguments['parameter']);
            $arguments['additionalAttributes'] = array_merge($arguments['additionalAttributes'], $dataAttributes);

            return parent::renderStatic($arguments, $renderChildrenClosure, $renderingContext);
        }
    }

}

