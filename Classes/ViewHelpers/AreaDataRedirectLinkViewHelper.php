<?php

namespace RKW\RkwEtracker\ViewHelpers;

use TYPO3\CMS\Fluid\Core\ViewHelper\AbstractViewHelper;

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
 * Class AreaDataRedirectLinkViewHelper
 *
 * @author Steffen Kroggel <developer@steffenkroggel.de>
 * @copyright Rkw Kompetenzzentrum
 * @package RKW_RkwEtracker
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 * @deprecated This class will be removed soon. Do not use it any more.
 */
class AreaDataRedirectLinkViewHelper extends AbstractViewHelper
{

    /**
     * Returns the detail link to eTracker for areaData
     *
     * @param \RKW\RkwEtracker\Domain\Model\Report $report
     * @param \RKW\RkwEtracker\Domain\Model\AreaData $areaData
     * @return array
     */
    public function render(\RKW\RkwEtracker\Domain\Model\Report $report, \RKW\RkwEtracker\Domain\Model\AreaData $areaData)
    {

        \TYPO3\CMS\Core\Utility\GeneralUtility::deprecationLog(__CLASS__ . ' is deprecated and will be removed soon.');

        $levels = range(1, 5);
        $categories = array();

        // add domain
        if ($areaData->getReportFilter()->getDomain()) {
            $categories[] = $areaData->getReportFilter()->getDomain();
        }

        // add categories
        foreach ($levels as $level) {

            $getter = 'getCategoryLevel' . $level;
            if (method_exists($areaData, $getter)) {
                if ($areaData->getReportFilter()->$getter()) {
                    $categories[] = $areaData->getReportFilter()->$getter();
                }
            }
        }

        // build link
        $link = '/report/EAArea' .
            // '&filterString=' . urlencode(implode('/',  $categories)) .
            '&startDate=' . date('d.m.Y', $report->getLastStartTstamp()) .
            '&endDate=' . date('d.m.Y', $report->getLastEndTstamp());

        return array(
            'tx_rkwetracker_pi2' => array(
                'redirectUrl' => $link,
            ),
        );
        //===

    }

}