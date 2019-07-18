<?php

namespace RKW\RkwEtracker\ViewHelpers\Link;

use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Object\ObjectManager;
use RKW\RkwEtracker\Utility\TypolinkUtility;
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
 * Class AndNotViewHelper
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
     * @param string $parameter stdWrap.typolink style parameter string
     * @param string $target
     * @param string $class
     * @param string $title
     * @param string $additionalParams
     * @param array $additionalAttributes
     *
     * @return string
     */
    public function render($parameter, $target = '', $class = '', $title = '', $additionalParams = '', $additionalAttributes = [])
    {

        /** @var \TYPO3\CMS\Extbase\Object\ObjectManager $objectManager */
        $objectManager = GeneralUtility::makeInstance(ObjectManager::class);

        /** @var \RKW\RkwEtracker\Utility\TypolinkUtility $typolinkUtility */
        $typolinkUtility = $objectManager->get(TypolinkUtility::class);

        // get data attributes for given handle
        $dataAttributes = $typolinkUtility->getDataAttributes($parameter);

        return static::renderStatic(
            [
                'parameter' => $parameter,
                'target' => $target,
                'class' => $class,
                'title' => $title,
                'additionalParams' => $additionalParams,
                'additionalAttributes' => array_merge($additionalAttributes, $dataAttributes)
            ],
            $this->buildRenderChildrenClosure(),
            $this->renderingContext
        );
    }
}