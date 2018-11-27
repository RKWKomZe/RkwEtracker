<?php

namespace RKW\RkwEtracker\ViewHelpers;

use RKW\RkwBasics\Helper\Common;
use RKW\RkwEtracker\Helpers\CategoryHelper;
use \TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Fluid\Core\ViewHelper\AbstractViewHelper;
use TYPO3\CMS\Extbase\Configuration\ConfigurationManagerInterface;

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
 * Class CategoryListViewHelper
 *
 * @author Steffen Kroggel <developer@steffenkroggel.de>
 * @copyright Rkw Kompetenzzentrum
 * @package RKW_RkwEtracker
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 */
class CategoryListViewHelper extends AbstractViewHelper
{

    /**
     * Returns the filtered and combined categories
     *
     * @param \RKW\RkwEtracker\Domain\Model\AreaData $areaData
     * @return string
     */
    public function render(\RKW\RkwEtracker\Domain\Model\AreaData $areaData)
    {

        $settings = $this->getSettings();

        $categories = array('.+', '.+', '.+', '.+', '.+', '.+');
        $spliceEnd = 1;
        if ($areaData->getCategoryLevel1()) {
            $categories[1] = CategoryHelper::cleanUp($areaData->getCategoryLevel1());
            $spliceEnd = -4;
        }
        if ($areaData->getCategoryLevel2()) {
            $categories[2] = CategoryHelper::cleanUp($areaData->getCategoryLevel2());
            $spliceEnd = -3;
        }
        if ($areaData->getCategoryLevel3()) {
            $categories[3] = CategoryHelper::cleanUp($areaData->getCategoryLevel3());
            $spliceEnd = -2;
        }
        if ($areaData->getCategoryLevel4()) {
            $categories[4] = CategoryHelper::cleanUp($areaData->getCategoryLevel4());
            $spliceEnd = -1;
        }
        if ($areaData->getCategoryLevel5()) {
            $categories[5] = CategoryHelper::cleanUp($areaData->getCategoryLevel5());
            $spliceEnd = 0;
        }

        // check domain at last end remove it if domain is in exclude list
        if ($areaData->getDomain()) {
            if (!in_array($areaData->getDomain(), GeneralUtility::trimExplode(',', $settings['reportDomainExcludeList']))) {
                $categories[0] = $areaData->getDomain();
            } else {
                array_shift($categories);
            }
        }

        return implode(' / ', array_slice($categories, 0, $spliceEnd));
        //===

    }

    /**
     * Loads TypoScript configuration into $this->configuration
     *
     * @param string $which
     * @return array
     */
    protected function getSettings($which = ConfigurationManagerInterface::CONFIGURATION_TYPE_SETTINGS)
    {

        return Common::getTyposcriptConfiguration('Rkwetracker', $which);
        //====
    }

}