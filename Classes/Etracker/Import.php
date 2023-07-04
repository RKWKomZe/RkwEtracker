<?php

namespace RKW\RkwEtracker\Etracker;

use Madj2k\CoreExtended\Utility\GeneralUtility;
use Madj2k\CoreExtended\Utility\GeneralUtility as Common;
use RKW\RkwEtracker\Domain\Model\AreaData;
use RKW\RkwEtracker\Domain\Model\DownloadData;
use RKW\RkwEtracker\Domain\Repository\AreaDataRepository;
use RKW\RkwEtracker\Domain\Repository\DownloadDataRepository;
use RKW\RkwEtracker\Utility\CategoryUtility;
use RKW\RkwEtracker\Utility\DateUtility;
use TYPO3\CMS\Core\Log\Logger;
use TYPO3\CMS\Core\Log\LogManager;
use \TYPO3\CMS\Extbase\Configuration\ConfigurationManagerInterface;
use TYPO3\CMS\Extbase\Object\ObjectManager;

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
 * Class Import
 *
 * @author Steffen Kroggel <developer@steffenkroggel.de>
 * @copyright RKW Kompetenzzentrum
 * @package RKW_RkwEtracker
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 */
class Import
{

    /**
     * @const URL to eTracker REST-API
     */
    const ApiUrl = 'https://ws.etracker.com/api/rest/v3/';


    /**
     * @var array Contains the configuration from TypoScript
     */
    protected array $configuration = [];


    /**
     * @var \TYPO3\CMS\Core\Log\Logger|null
     */
    protected ?Logger $logger = null;


    /**
     * Construct
     * Builds streamContext for API authentification
     *
     * @throws \RKW\RkwEtracker\Exception
     * @throws \TYPO3\CMS\Extbase\Configuration\Exception\InvalidConfigurationTypeException
     */
    public function __construct()
    {
        $this->getSettings();

        if (!extension_loaded('curl')) {
            throw new \RKW\RkwEtracker\Exception('The cURL PHP Extension is required by rkw_etracker.');
        }
        if (!extension_loaded('json')) {
            throw new \RKW\RkwEtracker\Exception('The JSON PHP Extension is required by rkw_etracker.');
        }
    }


    /**
     * Imports area report data
     *
     * @param \RKW\RkwEtracker\Domain\Model\Report $report
     * @param \RKW\RkwEtracker\Domain\Model\ReportGroup $reportGroup
     * @param array $credentials
     * @param int $limit
     * @return void
     * @throws \RKW\RkwEtracker\Exception
     */
    public function importAreaData(
        \RKW\RkwEtracker\Domain\Model\Report $report,
        \RKW\RkwEtracker\Domain\Model\ReportGroup $reportGroup,
        array $credentials,
        int $limit = 0
    ): void {

        try {

            $params = array(
                'attributes=area_level_1',
                'figures=unique_visits,unique_visitors,page_impressions,bounces_per_visit,staytime_per_unique_visits_v2',
                'displayType=grouped',
                'startDate=' . date('Y-m-d', $report->getLastStartTstamp()),
                'endDate=' . date('Y-m-d', $report->getLastEndTstamp()),
                'limit=' . ($limit ? intval($limit) : 2000),
            );

            /** @var \TYPO3\CMS\Extbase\Object\ObjectManager $objectManager */
            $objectManager = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance(ObjectManager::class);

            /** @var \RKW\RkwEtracker\Domain\Repository\AreaDataRepository $areaDataRepository */
            $areaDataRepository = $objectManager->get(AreaDataRepository::class);

            /** @var  \RKW\RkwEtracker\Domain\Model\ReportFilter $reportFilter */
            foreach ($reportGroup->getFilter() as $reportFilter) {

                /** @var \RKW\RkwEtracker\Domain\Model\AreaData $areaData */
                $areaData = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance(AreaData::class);

                // set basic values
                $areaData->setReport($report);
                $areaData->setReportGroup($reportGroup);
                $areaData->setReportFilter($reportFilter);
                $areaData->setReportFetchCounter($report->getFetchCounter());
                $areaData->setMonth($report->getMonth());
                $areaData->setQuarter($report->getQuarter());
                $areaData->setYear($report->getYear());

                // get filter properties
                if ($filter = CategoryUtility::reportFilterCategoriesToJson($reportFilter, true)) {

                    // get data from API
                    $completeUrl = $this::ApiUrl . 'report/EAArea/data?'
                        . implode('&', array_merge($params))
                        . '&attributeFilter=' . urlencode($filter);

                    if (
                        ($rawData = $this->getJsonData($completeUrl, $credentials))
                        && (is_array($rawData))
                    ) {
                        $this->mappingAreaData($rawData, $areaData);
                        $areaDataRepository->add($areaData);
                        $this->getLogger()->log(
                            \TYPO3\CMS\Core\Log\LogLevel::INFO,
                            sprintf(
                                'Import of eTracker area data for reportGroup "%s" (id=%s) with filter "%s" (id=%s) successful.',
                                $reportGroup->getName(),
                                $reportGroup->getUid(),
                                $filter,
                                $reportFilter->getUid()
                            )
                        );

                    } else {
                        $this->getLogger()->log(
                            \TYPO3\CMS\Core\Log\LogLevel::INFO,
                            sprintf(
                                'Received no area data for reportGroup "%s" (id=%s) with filter "%s" (id=%s) from eTracker API.',
                                $reportGroup->getName(),
                                $reportGroup->getUid(),
                                $filter,
                                $reportFilter->getUid()
                            )
                        );
                    }
                }
            }

        } catch (\Exception $e) {
            throw new \RKW\RkwEtracker\Exception(
                sprintf(
                    'Error while trying to fetch area data for reportGroup "%s" (id=%s) from API: %s.',
                    $reportGroup->getName(),
                    $reportGroup->getUid(),
                    $e->getMessage()
                ),
                1489562530
            );
        }
    }


    /**
     * Imports area report data
     *
     * @param \RKW\RkwEtracker\Domain\Model\Report $report
     * @param \RKW\RkwEtracker\Domain\Model\ReportGroup $reportGroup
     * @param array $credentials
     * @param int $limit
     * @return void
     * @throws \RKW\RkwEtracker\Exception
     */
    public function importDownloadData(
        \RKW\RkwEtracker\Domain\Model\Report $report,
        \RKW\RkwEtracker\Domain\Model\ReportGroup $reportGroup,
        array $credentials,
        int $limit = 0
    ) {

        try {

            $params = array(
                'attributes=category,action,object',
                'displayType=grouped',
                'startDate=' . date('Y-m-d', $report->getLastStartTstamp()),
                'endDate=' . date('Y-m-d', $report->getLastEndTstamp()),
                'limit=' . ($limit ? intval($limit) : 2000),
            );

            /** @var \TYPO3\CMS\Extbase\Object\ObjectManager $objectManager */
            $objectManager = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance(ObjectManager::class);

            /** @var \RKW\RkwEtracker\Domain\Repository\DownloadDataRepository $downloadDataRepository * */
            $downloadDataRepository = $objectManager->get(DownloadDataRepository::class);

            /** @var  \RKW\RkwEtracker\Domain\Model\ReportFilter $reportFilter */
            foreach ($reportGroup->getFilter() as $reportFilter) {

                /** @var \RKW\RkwEtracker\Domain\Model\DownloadData $downloadData */
                $downloadData = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance(DownloadData::class);

                // set basic values
                $downloadData->setReport($report);
                $downloadData->setReportGroup($reportGroup);
                $downloadData->setReportFilter($reportFilter);
                $downloadData->setReportFetchCounter($report->getFetchCounter());
                $downloadData->setMonth($report->getMonth());
                $downloadData->setQuarter($report->getQuarter());
                $downloadData->setYear($report->getYear());

                // only if something is set!
                if ($filter = CategoryUtility::reportFilterEventsToJson($reportFilter, true)) {

                    // get data from API
                    $completeUrl = $this::ApiUrl . 'report/EAEvents/data?' . implode('&', array_merge($params)) . '&attributeFilter=' . urlencode($filter);
                    if (
                        ($rawData = $this->getJsonData($completeUrl, $credentials))
                        && (is_array($rawData))
                    ) {

                        $this->mappingDownloadData($rawData, $downloadData);
                        $downloadDataRepository->add($downloadData);
                        $this->getLogger()->log(
                            \TYPO3\CMS\Core\Log\LogLevel::INFO,
                            sprintf(
                                'Import of eTracker download data for reportGroup "%s" (id=%s) with filter "%s" (id=%s) successful.',
                                $reportGroup->getName(),
                                $reportGroup->getUid(), $filter,
                                $reportFilter->getUid()
                            )
                        );

                    } else {
                        $this->getLogger()->log(
                            \TYPO3\CMS\Core\Log\LogLevel::INFO,
                            sprintf(
                                'Received no download data for reportGroup "%s" (id=%s) with filter "%s" (id=%s) from eTracker API.',
                                $reportGroup->getName(),
                                $reportGroup->getUid(),
                                $filter,
                                $reportFilter->getUid()
                            )
                        );
                    }
                }
            }

        } catch (\Exception $e) {
            throw new \RKW\RkwEtracker\Exception(
                sprintf(
                    'Error while trying to fetch download data for reportGroup "%s" (id=%s) from API: %s.',
                    $reportGroup->getName(),
                    $reportGroup->getUid(),
                    $e->getMessage()
                ),
                1489562530
            );
        }
    }


    /**
     * Get the JSON data
     *
     * @param string $url
     * @param array $credentials
     * @return array
     * @throws \RKW\RkwEtracker\Exception
     */
    protected function getJsonData (
        string $url,
        array $credentials
    ): array {

        $this->getLogger()->log(\TYPO3\CMS\Core\Log\LogLevel::DEBUG, sprintf ('API-Request: %s',  $url));

        if ($credentials['apiToken']) {

            // init curl
            $curlHandle = curl_init();
            curl_setopt($curlHandle , CURLOPT_RETURNTRANSFER, true); // Do not output result directly on screen.
            curl_setopt($curlHandle, CURLOPT_FOLLOWLOCATION, true);  // If url has redirects then go to the final redirected URL.
            curl_setopt($curlHandle, CURLOPT_HEADER, false);   // We don't want header information of response, because otherwise json_decode won't work

            // login header for etracker
            $headers = [
                'X-ET-Token: ' . $credentials['apiToken']
            ];
            curl_setopt($curlHandle, CURLOPT_HTTPHEADER, $headers);

            // optional: proxy configuration
            if ($credentials['proxy']) {

                curl_setopt($curlHandle, CURLOPT_PROXY, $credentials['proxy']);
                if ($credentials['proxyUsername']) {
                    curl_setopt(
                        $curlHandle,
                        CURLOPT_PROXYUSERPWD,
                        $credentials['proxyUsername'] . ':' . $credentials['proxyPassword']);
                }
            }

            // set url and get data
            curl_setopt($curlHandle, CURLOPT_URL, $url);

            $requestResult = curl_exec($curlHandle);
            $connectCode = curl_getinfo($curlHandle, CURLINFO_HTTP_CONNECTCODE);
            curl_close($curlHandle);

            // check result and HTTP-status code
            if (
                ($requestResult)
                && (
                    (!$connectCode)
                    || (200 == $connectCode)
                )
            ){

                // check if there is some data
                if ($jsonData = json_decode($requestResult)) {

                    if (
                        ($jsonData->errorCode)
                        && (($jsonData->msg))
                    ) {
                        $this->getLogger()->log(
                            \TYPO3\CMS\Core\Log\LogLevel::ERROR,
                            sprintf(
                                'Error code %s while trying to receive data from eTracker API: %s.',
                                $jsonData->errorCode,
                                $jsonData->msg
                            )
                        );
                        throw new \RKW\RkwEtracker\Exception($jsonData->msg, 1583494777);
                    }

                    $this->getLogger()->log(
                        \TYPO3\CMS\Core\Log\LogLevel::DEBUG,
                        sprintf (
                            'API-Result: %s',
                            str_replace("\n", '', print_r($requestResult, true))
                        )
                    );
                    return $jsonData;

                }

            } else {
                throw new \RKW\RkwEtracker\Exception(
                    'Got no valid response from API. HTTP-Status-Code: ' .
                    $connectCode,
                    1583494777
                );
            }

        } else {
            throw new \RKW\RkwEtracker\Exception(
                'Configuration for API-Login incomplete.',
                1489562529
            );
        }

        return [];

    }


    /**
     * Mapping area data into local database
     *
     * @param array $rawData
     * @param \RKW\RkwEtracker\Domain\Model\AreaData $areaData
     * @return void
     * @throws \TYPO3\CMS\Extbase\Persistence\Exception\IllegalObjectTypeException
     */
    protected function mappingAreaData(array $rawData, AreaData $areaData): void
    {

        if ($rawData) {

            // mapping for JSON-data to model
            $mapping = array(
                3 => 'visits',
                4 => 'visitors',
                5 => 'pageImpressions',
                6 => 'bouncesPerVisit',
                7 => 'timePerVisit',
            );

            // set "normal" fields according to mapping
            // ignore everything else but the first line
            foreach ($rawData[0] as $key => $value) {

                if (!$mapping[$key]) {
                    continue;
                    //===
                }

                $setter = 'set' . ucfirst($mapping[$key]);
                if ($key == 7) {
                    $areaData->$setter(intval($value));
                } elseif ($key == 6) {
                    $areaData->$setter((float)$value);
                } else {
                    $areaData->$setter($value);
                }
            }
        }
    }


    /**
     * Imports download data into local database
     *
     * @param array $rawData
     * @param \RKW\RkwEtracker\Domain\Model\DownloadData $downloadData
     * @return void
     */
    protected function mappingDownloadData(array $rawData, DownloadData $downloadData): void
    {

        if ($rawData) {

            // mapping for JSON-data to model
            $mapping = array(
                6 => 'events',
                5 => 'uniqueEvents',
            );

            // ignore everything else but the first line
            foreach ($rawData[0] as $key => $value) {

                if (!$mapping[$key]) {
                    continue;
                    //===
                }

                $downloadData->setAction('file');

                $setter = 'set' . ucfirst($mapping[$key]);
                $downloadData->$setter($value);
            }
        }
    }



    /**
     * Loads TypoScript configuration into $this->configuration
     *
     * @param string $which
     * @return void
     * @throws \TYPO3\CMS\Extbase\Configuration\Exception\InvalidConfigurationTypeException
     */
    protected function getSettings(string $which = ConfigurationManagerInterface::CONFIGURATION_TYPE_SETTINGS): void
    {
        if (!$this->configuration) {
            $this->configuration = GeneralUtility::getTypoScriptConfiguration('Rkwetracker', $which);
        }
    }


    /**
     * Returns logger instance
     *
     * @return \TYPO3\CMS\Core\Log\Logger
     */
    protected function getLogger()
    {

        if (!$this->logger instanceof \TYPO3\CMS\Core\Log\Logger) {
            $this->logger = GeneralUtility::makeInstance(LogManager::class)->getLogger(__CLASS__);
        }

        return $this->logger;
    }
}
