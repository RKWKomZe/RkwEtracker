<?php

namespace RKW\RkwEtracker\Etracker;

use \RKW\RkwBasics\Helper\Common;
use \TYPO3\CMS\Extbase\Configuration\ConfigurationManagerInterface;

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
 * @copyright Rkw Kompetenzzentrum
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
    protected $configuration;


    /**
     * @var \TYPO3\CMS\Core\Log\Logger
     */
    protected $logger;


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
     * check if there is something to fetch
     *
     * @param \RKW\RkwEtracker\Domain\Model\Report $report
     * @return boolean
     */
    public function checkForImport($report)
    {

        $currentTime = getdate();

        //===================
        // yearly reports
        if ($report->getType() == 0) {

            // check if we had no fetch this year
            if (date('Y', $report->getLastFetchTstamp()) >= $currentTime['year']) {
                $report->setStatus(0);

                return false;
                //===
            }


            // check if report has started recently
            if (date('Y', $report->getStarttime()) >= $currentTime['year']) {
                $report->setStatus(0);

                return false;
                //===
            }

        //===================
        // quarterly reports
        } elseif ($report->getType() == 1) {

            // define quarters
            $quarters = array(
                1  => 1,
                2  => 1,
                3  => 1,
                4  => 2,
                5  => 2,
                6  => 2,
                7  => 3,
                8  => 3,
                9  => 3,
                10 => 4,
                11 => 4,
                12 => 4,
            );

            // check if we had no fetch this quarter
            if (
                ($quarters[date('n', $report->getLastFetchTstamp())] >= $quarters[$currentTime['mon']])
                && (date('Y', $report->getLastFetchTstamp()) >= $currentTime['year'])
            ) {
                $report->setStatus(0);

                return false;
                //===
            }


            // check if report has started recently
            if (
                ($quarters[date('n', $report->getStarttime())] >= $quarters[$currentTime['mon']])
                && (date('Y', $report->getStarttime()) >= $currentTime['year'])
            ) {
                $report->setStatus(0);

                return false;
                //===
            }


        //===================
        // monthly reports
        } else {
            if ($report->getType() == 2) {

                // check if we had no fetch this year
                if (
                    (date('m', $report->getLastFetchTstamp()) >= $currentTime['mon'])
                    && (date('Y', $report->getLastFetchTstamp()) >= $currentTime['year'])
                ) {
                    $report->setStatus(0);

                    return false;
                    //===
                }


                // check if report has started recently
                if (
                    (date('m', $report->getStarttime()) >= $currentTime['mon'])
                    && (date('Y', $report->getStarttime()) >= $currentTime['year'])
                ) {
                    $report->setStatus(0);

                    return false;
                    //===
                }
            }
        }

        // set status to reset-value
        $report->setStatus(89);

        return true;
    }


    /**
     * Imports area report data
     *
     * @param \RKW\RkwEtracker\Domain\Model\Report $report
     * @param \RKW\RkwEtracker\Domain\Model\ReportGroup $reportGroup
     * @param int $limit
     * @return void
     * @throws  \RKW\RkwEtracker\Exception
     */
    public function importAreaData($report, $reportGroup, $limit = 0)
    {

        try {

            /** @var \TYPO3\CMS\Extbase\Object\ObjectManager $objectManager */
            $objectManager = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance('TYPO3\CMS\Extbase\Object\ObjectManager');

            /** @var \RKW\RkwEtracker\Domain\Repository\AreaDataRepository $areaDataRepository */
            $areaDataRepository = $objectManager->get('RKW\RkwEtracker\Domain\Repository\AreaDataRepository');

            $paramsArray = $this->getDateParams($report);
            $params = array(
                'attributes=area_level_1',
                'figures=unique_visits,unique_visitors,page_impressions,bounces_per_visit,staytime_per_unique_visits_v2',
                'displayType=grouped',
                'startDate=' . $paramsArray['startDate'],
                'endDate=' . $paramsArray['endDate'],
                'limit=' . ($limit ? intval($limit) : 2000),
            );

            /** @var  \RKW\RkwEtracker\Domain\Model\ReportFilter $reportFilter */
            foreach ($reportGroup->getFilter() as $reportFilter) {

                /** @var \RKW\RkwEtracker\Domain\Model\AreaData $areaData */
                $areaData = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance('RKW\RkwEtracker\Domain\Model\AreaData');

                // set basic values
                $areaData->setReport($report);
                $areaData->setReportGroup($reportGroup);
                $areaData->setReportFilter($reportFilter);
                $areaData->setReportFetchCounter($report->getFetchCounter());
                $areaData->setMonth($report->getMonth());
                $areaData->setQuarter($report->getQuarter());
                $areaData->setYear($report->getYear());

                // define filter properties
                $categoryFilter = array();
                $categoryFilterString = null;
                $properties = array('domain', 'categoryLevel1', 'categoryLevel2', 'categoryLevel3', 'categoryLevel4');
                foreach ($properties as $level => $property) {

                    // build getters
                    $getterDefault = 'get' . ucfirst($property);
                    $setterDefault = 'set' . ucfirst($property);
                    $getterFreetext = 'get' . ucfirst($property) . 'Free';

                    // get values
                    $filterString = $reportFilter->$getterDefault();
                    if ($reportFilter->$getterFreetext()) {
                        $filterString = $reportFilter->$getterFreetext();
                    }

                    // build category filter for API
                    if (
                        ($filterString)
                        && (!is_numeric($filterString))
                    ) {

                        $categoryFilterString = $filterString;
                        $categoryFilter[] = preg_replace("/\s/", '', '
                            {
                                "input":"' . $filterString . '",
                                "type":"exact",
                                "attributeId":"area_level_' . intval($level + 1) . '",
                                "filterType":"extended",
                                "filter":"include"
                            }
                        ');

                        // set filter-string to final object
                        $areaData->$setterDefault($filterString);
                    }
                }

                // get data from API
                $completeUrl = $this::ApiUrl . 'report/EAArea/data?' . implode('&', array_merge($params)) . '&attributeFilter=' . urlencode('[' . implode(',', $categoryFilter) . ']');
                if (
                    ($rawData = $this->getJsonData($completeUrl))
                    && (is_array($rawData))
                ) {
                    $this->mappingAreaData($rawData, $areaData);
                    $areaDataRepository->add($areaData);
                    $this->getLogger()->log(\TYPO3\CMS\Core\Log\LogLevel::INFO, sprintf('Import of eTracker area data for reportGroup "%s" (id=%s) with filter "%s" (id=%s) successfull.', $reportGroup->getName(), $reportGroup->getUid(), $categoryFilterString, $reportFilter->getUid()));

                } else {
                    $this->getLogger()->log(\TYPO3\CMS\Core\Log\LogLevel::INFO, sprintf('Received no area data for reportGroup "%s" (id=%s) with filter "%s" (id=%s) from eTracker API.', $reportGroup->getName(), $reportGroup->getUid(), $categoryFilterString, $reportFilter->getUid()));
                }
            }

        } catch (\Exception $e) {
            throw new \RKW\RkwEtracker\Exception(sprintf('Error while trying to fetch area data for reportGroup "%s" (id=%s) from API: %s.', $reportGroup->getName(), $reportGroup->getUid(), $e->getMessage()), 1489562530);
        }
    }


    /**
     * Imports area report data
     *
     * @param \RKW\RkwEtracker\Domain\Model\Report $report
     * @param \RKW\RkwEtracker\Domain\Model\ReportGroup $reportGroup
     * @param int $limit
     * @return void
     * @throws \RKW\RkwEtracker\Exception
     */
    public function importDownloadData($report, $reportGroup, $limit = 0)
    {

        try {

            /** @var \TYPO3\CMS\Extbase\Object\ObjectManager $objectManager */
            $objectManager = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance('TYPO3\CMS\Extbase\Object\ObjectManager');

            /** @var \RKW\RkwEtracker\Domain\Repository\DownloadDataRepository $downloadDataRepository * */
            $downloadDataRepository = $objectManager->get('RKW\RkwEtracker\Domain\Repository\DownloadDataRepository');

            $paramsArray = $this->getDateParams($report);
            $params = array(
                'attributes=category,action,object',
                'displayType=grouped',
                'startDate=' . $paramsArray['startDate'],
                'endDate=' . $paramsArray['endDate'],
                'limit=' . ($limit ? intval($limit) : 2000),
            );

            /** @var  \RKW\RkwEtracker\Domain\Model\ReportFilter $reportFilter */
            foreach ($reportGroup->getFilter() as $reportFilter) {


                // get domain
                $domain = $reportFilter->getDomain();
                if ($reportFilter->getDomainFree()) {
                    $domain = $reportFilter->getDomainFree();
                }

                // get other filters
                $filterArray = array();
                $properties = array('downloadFilter1', 'downloadFilter2', 'downloadFilter3', 'downloadFreeFilter1');
                foreach ($properties as $property) {

                    // build getter and get values
                    $getterDefault = 'get' . ucfirst($property);
                    $filterString = $reportFilter->$getterDefault();

                    if (
                        ($filterString)
                        && (!is_numeric($filterString))
                    ) {

                        /** @toDo: remove version without domain-prefix. Is included here for backwards-compatibility */
                        if (strtolower($filterString) == 'default') {
                            $filterArray[] = 'default';
                            $filterArray[] = 'Default';
                            $filterArray[] = ($domain ? $domain . '/' : '') . 'default';
                            $filterArray[] = ($domain ? $domain . '/' : '') . 'Default';

                        } else {
                            $filterArray[] = $filterString;
                            $filterArray[] = ($domain ? $domain . '/' : '') . $filterString;
                        }
                    }
                }

                // only if something is set!
                if (count($filterArray) > 0) {

                    // define filter properties - combine filter-strings to "or"-Array
                    $categoryFilter = array();
                    $categoryFilterString = implode(',', $filterArray);
                    $categoryFilter[] = preg_replace("/\s/", '', '
                        {
                            "input":"file",
                            "type":"exact",
                            "attributeId":"action",
                            "filterType":"extended",
                            "filter":"include"
                        },
                        {
                            "input":["' . implode('","', $filterArray) . '"],
                            "type":"exact",
                            "attributeId":"category",
                            "filterType":"extended",
                            "filter":"include"
                        }
                    ');

                    // get data from API
                    $completeUrl = $this::ApiUrl . 'report/EAEvents/data?' . implode('&', array_merge($params)) . '&attributeFilter=' . urlencode('[' . implode(',', $categoryFilter) . ']');
                    if (
                        ($rawData = $this->getJsonData($completeUrl))
                        && (is_array($rawData))
                    ) {

                        // since we are using an or-request we have to go through all the lines
                        foreach ($rawData as $line => $rawDataItem) {

                            // ignore first sum-line
                            if ($line == 0) {
                                continue;
                                //===
                            }

                            /** @var \RKW\RkwEtracker\Domain\Model\DownloadData $downloadData */
                            $downloadData = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance('RKW\RkwEtracker\Domain\Model\DownloadData');

                            // set basic values
                            $downloadData->setReport($report);
                            $downloadData->setReportGroup($reportGroup);
                            $downloadData->setReportFilter($reportFilter);
                            $downloadData->setReportFetchCounter($report->getFetchCounter());
                            $downloadData->setMonth($report->getMonth());
                            $downloadData->setQuarter($report->getQuarter());
                            $downloadData->setYear($report->getYear());

                            $this->mappingDownloadData($rawDataItem, $downloadData);

                            $downloadDataRepository->add($downloadData);


                        }

                        $this->getLogger()->log(\TYPO3\CMS\Core\Log\LogLevel::INFO, sprintf('Import of eTracker download data for reportGroup "%s" (id=%s) with filter "%s" (id=%s) successfull.', $reportGroup->getName(), $reportGroup->getUid(), $categoryFilterString, $reportFilter->getUid()));

                    } else {
                        $this->getLogger()->log(\TYPO3\CMS\Core\Log\LogLevel::INFO, sprintf('Received no download data for reportGroup "%s" (id=%s) with filter "%s" (id=%s) from eTracker API.', $reportGroup->getName(), $reportGroup->getUid(), $categoryFilterString, $reportFilter->getUid()));
                    }
                }
            }

        } catch (\Exception $e) {
            throw new \RKW\RkwEtracker\Exception(sprintf('Error while trying to fetch download data for reportGroup "%s" (id=%s) from API: %s.', $reportGroup->getName(), $reportGroup->getUid(), $e->getMessage()), 1489562530);
        }
    }


    /**
     * Get the JSON data
     *
     * @param string $url
     * @return array|null
     * @throws \RKW\RkwEtracker\Exception
     */
    protected function getJsonData ($url)
    {

        $this->getLogger()->log(\TYPO3\CMS\Core\Log\LogLevel::DEBUG, sprintf ('API-Request: %s',  $url));
        if (
            ($this->configuration['apiEmail'])
            && (\TYPO3\CMS\Core\Utility\GeneralUtility::validEmail($this->configuration['apiEmail']))
            && ($this->configuration['apiToken'])
            && ($this->configuration['apiAccountId'])
            && ($this->configuration['apiPassword'])
        ) {


            // init curl
            $curlHandle = curl_init();
            curl_setopt($curlHandle , CURLOPT_RETURNTRANSFER, true); // Do not output result directly on screen.
            curl_setopt($curlHandle, CURLOPT_FOLLOWLOCATION, true);  // If url has redirects then go to the final redirected URL.
            curl_setopt($curlHandle, CURLOPT_HEADER, false);   // If you want header information of response

            // login header for etracker
            $headers = [
                'X-ET-email: ' . $this->configuration['apiEmail'],
                'X-ET-developerToken: ' . $this->configuration['apiToken'],
                'X-ET-accountId: ' . $this->configuration['apiAccountId'],
                'X-ET-password: ' . $this->configuration['apiPassword'],
            ];
            curl_setopt($curlHandle, CURLOPT_HTTPHEADER, $headers);


            // optional: proxy configuration
            if ($this->configuration['proxy']) {

                curl_setopt($curlHandle, CURLOPT_PROXY, $this->configuration['proxy']);
                if ($this->configuration['proxyUsername']) {
                    curl_setopt($curlHandle, CURLOPT_PROXYUSERPWD, $this->configuration['proxyUsername'] . ':' . $this->configuration['proxyPassword']);
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
                    (false == $connectCode)
                    || (200 == $connectCode)
                )
            ){

                // check if there is some data
                if ($jsonData = json_decode($requestResult)) {

                    if (
                        ($jsonData->errorCode)
                        && (($jsonData->msg))
                    ) {
                        $this->getLogger()->log(\TYPO3\CMS\Core\Log\LogLevel::ERROR, sprintf('Error code %s while trying to receive data from eTracker API: %s.', $jsonData->errorCode, $jsonData->msg));
                        throw new \RKW\RkwEtracker\Exception($jsonData->msg, 1583494777);
                    }

                    $this->getLogger()->log(\TYPO3\CMS\Core\Log\LogLevel::DEBUG, sprintf ('API-Result: %s',  str_replace("\n", '', print_r($requestResult, true))));
                    return $jsonData;
                }

            } else {
                throw new \RKW\RkwEtracker\Exception('Got no valid response from API. HTTP-Status-Code: ' . $connectCode, 1583494777);
            }

        } else {
            throw new \RKW\RkwEtracker\Exception('Configuration for API-Login incomplete.', 1489562529);
        }

        return null;

    }


    /**
     * Mapping area data into local database
     *
     * @param array $rawData
     * @param \RKW\RkwEtracker\Domain\Model\AreaData $areaData
     * @param \RKW\RkwEtracker\Domain\Model\ReportGroup $reportGroup
     * @param \RKW\RkwEtracker\Domain\Model\ReportFilter $reportFilter
     * @throws \TYPO3\CMS\Extbase\Persistence\Exception\IllegalObjectTypeException
     */
    protected function mappingAreaData($rawData, $areaData)
    {

        if (
            ($rawData)
            && (is_array($rawData))
        ) {

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
     */
    protected function mappingDownloadData($rawData, $downloadData)
    {

        if (
            ($rawData)
            && (is_array($rawData))
        ) {

            // mapping for JSON-data to model
            $mapping = array(
                6 => 'events',
                5 => 'uniqueEvents',
            );

            // ignore everything else but the first line
            foreach ($rawData as $key => $value) {

                if (!$mapping[$key]) {
                    continue;
                    //===
                }

                $downloadData->setAction('file');
                $downloadData->setCategory($rawData[2]);

                $setter = 'set' . ucfirst($mapping[$key]);
                $downloadData->$setter($value);
            }
        }
    }


    /**
     * Gets the date params
     *
     * @param \RKW\RkwEtracker\Domain\Model\Report $report
     * @return array
     */
    protected function getDateParams($report)
    {
        $currentTime = getdate();
        $returnValues = array();

        //===================
        // yearly reports
        if ($report->getType() == 0) {

            $report->setMonth(0);
            $report->setQuarter(0);
            $report->setYear(($currentTime['year'] - 1));#

            // set params
            $returnValues = array(
                'startDate' => ($currentTime['year'] - 1) . '-01-01',
                'endDate'   => ($currentTime['year'] - 1) . '-12-31',
            );

        //===================
        // quarterly reports
        } elseif ($report->getType() == 1) {

            // define quarters
            $quarters = array(
                1  => 1,
                2  => 1,
                3  => 1,
                4  => 2,
                5  => 2,
                6  => 2,
                7  => 3,
                8  => 3,
                9  => 3,
                10 => 4,
                11 => 4,
                12 => 4,
            );

            // define quarter and year
            $quarter = ($quarters[$currentTime['mon']] - 1);
            $year = $currentTime['year'];
            if ($quarter == 0) {
                $quarter = 4;
                $year--;
            }

            // get start and end dates for quarters
            $quartersStartEnd = array(
                1 => array(
                    'startDate' => $year . '-01-01',
                    'endDate'   => date('Y-m-t', strtotime($year . '-03-01')),
                ),
                2 => array(
                    'startDate' => $year . '-04-01',
                    'endDate'   => date('Y-m-t', strtotime($year . '-06-01')),
                ),
                3 => array(
                    'startDate' => $year . '-07-01',
                    'endDate'   => date('Y-m-t', strtotime($year . '-09-01')),
                ),
                4 => array(
                    'startDate' => $year . '-10-01',
                    'endDate'   => date('Y-m-t', strtotime($year . '-12-01')),
                ),
            );

            $report->setMonth(0);
            $report->setQuarter($quarter);
            $report->setYear($year);

            // set params
            $returnValues = array(
                'startDate' => $quartersStartEnd[$quarter]['startDate'],
                'endDate'   => $quartersStartEnd[$quarter]['endDate'],
            );

        //===================
        // monthly reports
        } else {
            if ($report->getType() == 2) {

                // define quarter and year
                $month = ($currentTime['mon'] - 1);
                $year = $currentTime['year'];
                if ($month == 0) {
                    $month = 12;
                    $year--;
                }

                $report->setMonth($month);
                $report->setQuarter(0);
                $report->setYear($year);

                // set params
                $returnValues = array(
                    'startDate' => date('Y-m-d', strtotime($year . '-' . $month . '-01')),
                    'endDate'   => date('Y-m-t', strtotime($year . '-' . $month . '-01')),
                );
            }
        }

        // check if startdate lies before account start
        if ($this->configuration['accountStartDate']) {

            if (strtotime($returnValues['startDate']) < strtotime($this->configuration['accountStartDate'])) {
                $returnValues['startDate'] = date('Y-m-d', strtotime($this->configuration['accountStartDate']));
            }
        }

        $report->setLastStartTstamp(strtotime($returnValues['startDate']));
        $report->setLastEndTstamp(strtotime($returnValues['endDate']));

        return $returnValues;
    }


    /**
     * Loads TypoScript configuration into $this->configuration
     *
     * @param string $which
     * @return void
     * @throws \TYPO3\CMS\Extbase\Configuration\Exception\InvalidConfigurationTypeException
     */
    protected function getSettings($which = ConfigurationManagerInterface::CONFIGURATION_TYPE_SETTINGS)
    {

        if (!$this->configuration) {
            $this->configuration = Common::getTyposcriptConfiguration('Rkwetracker', $which);
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
            $this->logger = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance('TYPO3\CMS\Core\Log\LogManager')->getLogger(__CLASS__);
        }

        return $this->logger;
    }
}