<?php

namespace RKW\RkwEtracker\ViewHelpers;

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

use RKW\RkwEtracker\Utility\CategoryUtility;
use TYPO3Fluid\Fluid\Core\Rendering\RenderingContextInterface;
use TYPO3Fluid\Fluid\Core\ViewHelper\AbstractViewHelper;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Configuration\ConfigurationManagerInterface;


/**
 * Class CategoryImplodeAreaDataViewHelper
 *
 * @author Steffen Kroggel <developer@steffenkroggel.de>
 * @copyright Rkw Kompetenzzentrum
 * @package RKW_RkwEtracker
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 */
class CategoryImplodeAreaDataViewHelper extends AbstractViewHelper
{

    /**
     * Initialize arguments
     */
    public function initializeArguments()
    {
        $this->registerArgument('areaData', '\RKW\RkwEtracker\Domain\Model\AreaData', 'The AreaData-object to get the categories from.', true);
    }


    /**
     * Returns the filtered and combined categories
     *
     * @param array $arguments
     * @param \Closure  $renderChildrenClosure
     * @param RenderingContextInterface $renderingContext
     * @return string
     * @throws \TYPO3\CMS\Extbase\Configuration\Exception\InvalidConfigurationTypeException
     */
    public static function renderStatic(
        array $arguments,
        \Closure $renderChildrenClosure,
        RenderingContextInterface $renderingContext
    ): string {


        $areaData = $arguments['areaData'];
        $settings = self::getSettings();

        $categories = [];
        foreach(range(1,5) as $level) {

            $getter = 'getCategoryLevel' . $level;
            if ($areaData->$getter()) {
                $categories[] = $areaData->$getter();
            }
        }

        // check domain at last end remove it if domain is in exclude list
        $domain = '';
        if ($areaData->getDomain()) {
            if (!in_array($areaData->getDomain(), GeneralUtility::trimExplode(',', $settings['reportDomainExcludeList']))) {
                $domain = $areaData->getDomain();
            }
        }

        return CategoryUtility::implodeCategories($domain, $categories, '.+', false);

    }


    /**
     * Loads TypoScript configuration into $this->configuration
     *
     * @param string $which
     * @return array
     * @throws \TYPO3\CMS\Extbase\Configuration\Exception\InvalidConfigurationTypeException
     */
    public static function getSettings($which = ConfigurationManagerInterface::CONFIGURATION_TYPE_SETTINGS)
    {
        return \RKW\RkwBasics\Utility\GeneralUtility::getTyposcriptConfiguration('Rkwetracker', $which);
    }
}
