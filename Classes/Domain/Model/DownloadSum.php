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
 * @copyright RKW Kompetenzzentrum
 * @package RKW_RkwEtracker
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 */
class DownloadSum extends \TYPO3\CMS\Extbase\DomainObject\AbstractEntity
{

    /**
     * @var int
     */
    protected int $timePerEvent = 0;


    /**
     * @var int
     */
    protected int $events = 0;


    /**
     * @var int
     */
    protected int $uniqueEvents = 0;


    /**
     * @var \RKW\RkwEtracker\Domain\Model\Report|null
     */
    protected ?Report $report = null;


    /**
     * @var \RKW\RkwEtracker\Domain\Model\ReportGroup|null
     */
    protected ?ReportGroup $reportGroup = null;


    /**
     * @var int
     */
    protected int $reportFetchCounter =  0;


    /**
     * @var int
     */
    protected $month = 0;


    /**
     * @var int
     */
    protected int $quarter = 0;


    /**
     * @var int
     */
    protected int $year = 0;


    /**
     * Returns the timePerEvent
     *
     * @return int $timePerEvent
     */
    public function getTimePerEvent(): int
    {
        return $this->timePerEvent;
    }


    /**
     * Sets the timePerEvent
     *
     * @param int $timePerEvent
     * @return void
     */
    public function setTimePerEvent(int $timePerEvent): void
    {
        $this->timePerEvent = $timePerEvent;
    }


    /**
     * Returns the events
     *
     * @return int $events
     */
    public function getEvents(): int
    {
        return $this->events;
    }


    /**
     * Sets the events
     *
     * @param int $events
     * @return void
     */
    public function setEvents(int $events): void
    {
        $this->events = $events;
    }


    /**
     * Returns the uniqueEvents
     *
     * @return int $uniqueEvents
     */
    public function getUniqueEvents(): int
    {
        return $this->uniqueEvents;
    }


    /**
     * Sets the uniqueEvents
     *
     * @param int $uniqueEvents
     * @return void
     */
    public function setUniqueEvents(int $uniqueEvents): void
    {
        $this->uniqueEvents = $uniqueEvents;
    }


    /**
     * Returns the report
     *
     * @return \RKW\RkwEtracker\Domain\Model\Report $report
     */
    public function getReport():? Report
    {
        return $this->report;
    }


    /**
     * Sets the report
     *
     * @param \RKW\RkwEtracker\Domain\Model\Report $report
     * @return void
     */
    public function setReport(Report $report): void
    {
        $this->report = $report;
    }


    /**
     * Returns the reportGroup
     *
     * @return \RKW\RkwEtracker\Domain\Model\ReportGroup $reportGroup
     */
    public function getReportGroup():? ReportGroup
    {
        return $this->reportGroup;
    }


    /**
     * Sets the reportGroup
     *
     * @param \RKW\RkwEtracker\Domain\Model\ReportGroup $reportGroup
     * @return void
     */
    public function setReportGroup(ReportGroup $reportGroup): void
    {
        $this->reportGroup = $reportGroup;
    }


    /**
     * Returns the reportFetchCounter
     *
     * @return int
     */
    public function getReportFetchCounter(): int
    {
        return $this->reportFetchCounter;
    }

    /**
     * Sets the reportFetchCounter
     *
     * @param int $reportFetchCounter
     * @return void
     */
    public function setReportFetchCounter(int $reportFetchCounter): void
    {
        $this->reportFetchCounter = $reportFetchCounter;
    }


    /**
     * Returns the month
     *
     * @return int
     */
    public function getMonth(): int
    {
        return $this->month;
    }


    /**
     * Sets the month
     *
     * @param string $month
     * @return void
     */
    public function setMonth(int $month): void
    {
        $this->month = $month;
    }


    /**
     * Returns the quarter
     *
     * @return int
     */
    public function getQuarter(): int
    {
        return $this->quarter;
    }


    /**
     * Sets the quarter
     *
     * @param int $quarter
     * @return void
     */
    public function setQuarter(int $quarter): int
    {
        $this->quarter = $quarter;
    }


    /**
     * Returns the year
     *
     * @return int
     */
    public function getYear(): int
    {
        return $this->year;
    }


    /**
     * Sets the year
     *
     * @param int $year
     * @return void
     */
    public function setYear(int $year): void
    {
        $this->year = $year;
    }

}
