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
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Fluid\Core\ViewHelper\AbstractViewHelper;
use TYPO3\CMS\Extbase\Configuration\ConfigurationManagerInterface;

/**
 * Class CategoryListViewHelper
 *
 * @author Steffen Kroggel <developer@steffenkroggel.de>
 * @copyright Rkw Kompetenzzentrum
 * @package RKW_RkwEtracker
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 * @deprecated This class will be removed soon. Do not use it any more.
 */
class CategoryListViewHelper extends AbstractViewHelper
{

    /**
     * Returns the filtered and combined categories
     *
     * @param \RKW\RkwEtracker\Domain\Model\AreaData $areaData
     * @return string
     * @throws \TYPO3\CMS\Extbase\Configuration\Exception\InvalidConfigurationTypeException
     */
    public function render(\RKW\RkwEtracker\Domain\Model\AreaData $areaData)
    {

        \TYPO3\CMS\Core\Utility\GeneralUtility::deprecationLog(__CLASS__ . ' is deprecated and will be removed soon. Use ImplodeCategoriesViewHelper instead.');
        $settings = $this->getSettings();

        $categories = [];
        $domain = '';

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
    protected function getSettings($which = ConfigurationManagerInterface::CONFIGURATION_TYPE_SETTINGS)
    {

        return \RKW\RkwBasics\Utility\GeneralUtility::getTyposcriptConfiguration('Rkwetracker', $which);
    }

}