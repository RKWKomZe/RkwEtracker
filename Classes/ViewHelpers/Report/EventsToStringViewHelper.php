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

use RKW\RkwEtracker\Domain\Model\DownloadData;
use RKW\RkwEtracker\Domain\Model\ReportFilter;
use RKW\RkwEtracker\Utility\CategoryUtility;
use TYPO3Fluid\Fluid\Core\Rendering\RenderingContextInterface;
use TYPO3Fluid\Fluid\Core\ViewHelper\AbstractViewHelper;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Configuration\ConfigurationManagerInterface;


/**
 * Class EventsToStringViewHelper
 *
 * @author Steffen Kroggel <developer@steffenkroggel.de>
 * @copyright RKW Kompetenzzentrum
 * @package RKW_RkwEtracker
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 * @deprecated This class will be removed soon. Do not use it any more.
 */
class EventsToStringViewHelper extends AbstractViewHelper
{

    /**
     * Initialize arguments
     */
    public function initializeArguments()
    {
        parent::initializeArguments();
        $this->registerArgument('downloadData', DownloadData::class, 'The DownloadData-object to get the categories from.', true);
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

        /** @var DownloadData $downloadData */
        $downloadData = $arguments['downloadData'];
        $settings = self::getSettings();

        $events = '';

        /** @var ReportFilter $reportFilter */
        if ($reportFilter =  $downloadData->getReportFilter()) {

            // get events
            $events = CategoryUtility::reportFilterEventsToString($reportFilter, true);

            // check domain and remove it if domain is in exclude list
            foreach (GeneralUtility::trimExplode(',', $settings['reportDomainExcludeList']) as $domain) {

                if (strpos($events, $domain) === 0) {
                    $events = substr($events, strlen($domain) +1);
                }
            }
        }

        return $events;
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
