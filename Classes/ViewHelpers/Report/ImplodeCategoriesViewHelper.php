<?php

namespace RKW\RkwEtracker\ViewHelpers\Report;

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

use RKW\RkwEtracker\Domain\Model\AreaData;
use RKW\RkwEtracker\Domain\Model\ReportFilter;
use RKW\RkwEtracker\Utility\CategoryUtility;
use TYPO3Fluid\Fluid\Core\Rendering\RenderingContextInterface;
use TYPO3Fluid\Fluid\Core\ViewHelper\AbstractViewHelper;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Configuration\ConfigurationManagerInterface;


/**
 * Class ImplodeCategoriesViewHelper
 *
 * @author Steffen Kroggel <developer@steffenkroggel.de>
 * @copyright RKW Kompetenzzentrum
 * @package RKW_RkwEtracker
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 */
class ImplodeCategoriesViewHelper extends AbstractViewHelper
{

    /**
     * Initialize arguments
     */
    public function initializeArguments()
    {
        parent::initializeArguments();
        $this->registerArgument('areaData', AreaData::class, 'The AreaData-object to get the categories from.', true);
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

        /** @var AreaData $areaData */
        $areaData = $arguments['areaData'];
        $settings = self::getSettings();

        $categories = [];
        $domain = '';

        /** @var ReportFilter $reportFilter */
        if ($reportFilter = $areaData->getReportFilter()) {

            // get categories
            $categories = CategoryUtility::reportFilterCategoriesToArray($reportFilter, true);

            // check domain and remove it if domain is in exclude list
            if ($tempDomain = array_shift($categories)) {
                if (!in_array($tempDomain, GeneralUtility::trimExplode(',', $settings['reportDomainExcludeList']))) {
                    $domain = $tempDomain;
                }
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
        return \Madj2k\CoreExtended\Utility\GeneralUtility::getTypoScriptConfiguration('Rkwetracker', $which);
    }
}
