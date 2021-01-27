<?php

namespace RKW\RkwEtracker\Domain\Model;

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
 * Class DownloadData
 *
 * @author Steffen Kroggel <developer@steffenkroggel.de>
 * @copyright Rkw Kompetenzzentrum
 * @package RKW_RkwEtracker
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 */
class DownloadData extends \TYPO3\CMS\Extbase\DomainObject\AbstractEntity
{

    /**
     * action
     *
     * @var string
     */
    protected $action = '';


    /**
     * timePerEvent
     *
     * @var int
     */
    protected $timePerEvent = 0;

    /**
     * events
     *
     * @var int
     */
    protected $events = '';

    /**
     * uniqueEvents
     *
     * @var int
     */
    protected $uniqueEvents = '';

    /**
     * Report
     *
     * @var \RKW\RkwEtracker\Domain\Model\Report
     */
    protected $report = null;


    /**
     * ReportGroup
     *
     * @var \RKW\RkwEtracker\Domain\Model\ReportGroup
     */
    protected $reportGroup = null;


    /**
     * ReportFilter
     *
     * @var \RKW\RkwEtracker\Domain\Model\ReportFilter
     */
    protected $reportFilter = null;


    /**
     * ReportFetchCounter
     *
     * @var int
     */
    protected $reportFetchCounter = 0;

    /**
     * month
     *
     * @var int
     */
    protected $month = 0;

    /**
     * quarter
     *
     * @var int
     */
    protected $quarter = '';

    /**
     * year
     *
     * @var int
     */
    protected $year = '';

    /**
     * Returns the action
     *
     * @return string $action
     */
    public function getAction()
    {
        return $this->action;
    }

    /**
     * Sets the action
     *
     * @param string $action
     * @return void
     */
    public function setAction($action)
    {
        $this->action = $action;
    }


    /**
     * Returns the timePerEvent
     *
     * @return int $timePerEvent
     */
    public function getTimePerEvent()
    {
        return $this->timePerEvent;
    }

    /**
     * Sets the timePerEvent
     *
     * @param int $timePerEvent
     * @return void
     */
    public function setTimePerEvent($timePerEvent)
    {
        $this->timePerEvent = $timePerEvent;
    }

    /**
     * Returns the events
     *
     * @return int $events
     */
    public function getEvents()
    {
        return $this->events;
    }

    /**
     * Sets the events
     *
     * @param int $events
     * @return void
     */
    public function setEvents($events)
    {
        $this->events = $events;
    }

    /**
     * Returns the uniqueEvents
     *
     * @return int $uniqueEvents
     */
    public function getUniqueEvents()
    {
        return $this->uniqueEvents;
    }

    /**
     * Sets the uniqueEvents
     *
     * @param int $uniqueEvents
     * @return void
     */
    public function setUniqueEvents($uniqueEvents)
    {
        $this->uniqueEvents = $uniqueEvents;
    }

    /**
     * Returns the report
     *
     * @return \RKW\RkwEtracker\Domain\Model\Report
     */
    public function getReport()
    {
        return $this->report;
    }

    /**
     * Sets the report
     *
     * @param \RKW\RkwEtracker\Domain\Model\Report $report
     * @return void
     */
    public function setReport(\RKW\RkwEtracker\Domain\Model\Report $report)
    {
        $this->report = $report;
    }

    /**
     * Returns the reportGroup
     *
     * @return \RKW\RkwEtracker\Domain\Model\ReportGroup
     */
    public function getReportGroup()
    {
        return $this->reportGroup;
    }

    /**
     * Sets the reportGroup
     *
     * @param \RKW\RkwEtracker\Domain\Model\ReportGroup $reportGroup
     * @return void
     */
    public function setReportGroup(\RKW\RkwEtracker\Domain\Model\ReportGroup $reportGroup)
    {
        $this->reportGroup = $reportGroup;
    }

    /**
     * Returns the reportFilter
     *
     * @return \RKW\RkwEtracker\Domain\Model\ReportFilter
     */
    public function getReportFilter()
    {
        return $this->reportFilter;
    }

    /**
     * Sets the reportFilter
     *
     * @param \RKW\RkwEtracker\Domain\Model\ReportFilter $reportFilter
     * @return void
     */
    public function setReportFilter(\RKW\RkwEtracker\Domain\Model\ReportFilter $reportFilter)
    {
        $this->reportFilter = $reportFilter;
    }


    /**
     * Returns the reportFetchCounter
     *
     * @return int $reportFetchCounter
     */
    public function getReportFetchCounter()
    {
        return $this->reportFetchCounter;
    }

    /**
     * Sets the reportFetchCounter
     *
     * @param int $reportFetchCounter
     * @return void
     */
    public function setReportFetchCounter($reportFetchCounter)
    {
        $this->reportFetchCounter = $reportFetchCounter;
    }

    /**
     * Returns the month
     *
     * @return int $month
     */
    public function getMonth()
    {
        return $this->month;
    }

    /**
     * Sets the month
     *
     * @param int $month
     * @return void
     */
    public function setMonth($month)
    {
        $this->month = $month;
    }

    /**
     * Returns the quarter
     *
     * @return string $quarter
     */
    public function getQuarter()
    {
        return $this->quarter;
    }

    /**
     * Sets the quarter
     *
     * @param string $quarter
     * @return void
     */
    public function setQuarter($quarter)
    {
        $this->quarter = $quarter;
    }

    /**
     * Returns the year
     *
     * @return string $year
     */
    public function getYear()
    {
        return $this->year;
    }

    /**
     * Sets the year
     *
     * @param string $year
     * @return void
     */
    public function setYear($year)
    {
        $this->year = $year;
    }

}