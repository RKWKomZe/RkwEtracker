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
 * Class DownloadSum
 *
 * @author Steffen Kroggel <developer@steffenkroggel.de>
 * @copyright Rkw Kompetenzzentrum
 * @package RKW_RkwEtracker
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 */
class DownloadSum extends \TYPO3\CMS\Extbase\DomainObject\AbstractEntity
{

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
    protected $events = 0;
    
    /**
     * uniqueEvents
     *
     * @var int
     */
    protected $uniqueEvents = 0;

    /**
     * report
     *
     * @var \RKW\RkwEtracker\Domain\Model\Report
     */
    protected $report = null;


    /**
     * reportGroup
     *
     * @var \RKW\RkwEtracker\Domain\Model\ReportGroup
     */
    protected $reportGroup = null;

    /**
     * reportFetchCounter
     *
     * @var string
     */
    protected $reportFetchCounter = '';
    
    /**
     * month
     *
     * @var string
     */
    protected $month = '';
    
    /**
     * quarter
     *
     * @var string
     */
    protected $quarter = '';
    
    /**
     * year
     *
     * @var string
     */
    protected $year = '';
    
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
     * @return \RKW\RkwEtracker\Domain\Model\Report $report
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
     * @return \RKW\RkwEtracker\Domain\Model\ReportGroup $reportGroup
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
     * Returns the reportFetchCounter
     *
     * @return string $reportFetchCounter
     */
    public function getReportFetchCounter()
    {
        return $this->reportFetchCounter;
    }
    
    /**
     * Sets the reportFetchCounter
     *
     * @param string $reportFetchCounter
     * @return void
     */
    public function setReportFetchCounter($reportFetchCounter)
    {
        $this->reportFetchCounter = $reportFetchCounter;
    }
    
    /**
     * Returns the month
     *
     * @return string $month
     */
    public function getMonth()
    {
        return $this->month;
    }
    
    /**
     * Sets the month
     *
     * @param string $month
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