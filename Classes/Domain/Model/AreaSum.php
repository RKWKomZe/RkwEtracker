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
 * Class AreaSum
 *
 * @author Steffen Kroggel <developer@steffenkroggel.de>
 * @copyright RKW Kompetenzzentrum
 * @package RKW_RkwEtracker
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 */
class AreaSum extends \TYPO3\CMS\Extbase\DomainObject\AbstractEntity
{

    /**
     * visits
     *
     * @var int
     */
    protected $visits = 0;

    /**
     * visitors
     *
     * @var int
     */
    protected $visitors = 0;

    /**
     * pageImpressions
     *
     * @var int
     */
    protected $pageImpressions = 0;

    /**
     * pageImpressionsPerVisit
     *
     * @var float
     */
    protected $pageImpressionsPerVisit = 0.0;

    /**
     * bouncesPerVisit
     *
     * @var float
     */
    protected $bouncesPerVisit = 0.0;

    /**
     * timePerVisit
     *
     * @var int
     */
    protected $timePerVisit = 0;

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
     * @var int
     */
    protected $reportFetchCounter = 0;

    /**
     * month
     *
     * @var float
     */
    protected $month = 0.0;

    /**
     * quarter
     *
     * @var float
     */
    protected $quarter = 0.0;

    /**
     * year
     *
     * @var float
     */
    protected $year = 0.0;

    /**
     * Returns the visits
     *
     * @return int $visits
     */
    public function getVisits()
    {
        return $this->visits;
    }

    /**
     * Sets the visits
     *
     * @param int $visits
     * @return void
     */
    public function setVisits($visits)
    {
        $this->visits = $visits;
    }

    /**
     * Returns the visitors
     *
     * @return int $visitors
     */
    public function getVisitors()
    {
        return $this->visitors;
    }

    /**
     * Sets the visitors
     *
     * @param int $visitors
     * @return void
     */
    public function setVisitors($visitors)
    {
        $this->visitors = $visitors;
    }

    /**
     * Returns the pageImpressions
     *
     * @return int $pageImpressions
     */
    public function getPageImpressions()
    {
        return $this->pageImpressions;
    }

    /**
     * Sets the pageImpressions
     *
     * @param int $pageImpressions
     * @return void
     */
    public function setPageImpressions($pageImpressions)
    {
        $this->pageImpressions = $pageImpressions;
    }

    /**
     * Returns the pageImpressionsPerVisit
     *
     * @return float $pageImpressionPerVisit
     */
    public function getPageImpressionsPerVisit()
    {
        return $this->pageImpressionsPerVisit;
    }

    /**
     * Sets the pageImpressionsPerVisit
     *
     * @param float $pageImpressionsPerVisit
     * @return void
     */
    public function setPageImpressionsPerVisit($pageImpressionsPerVisit)
    {
        $this->pageImpressionsPerVisit = $pageImpressionsPerVisit;
    }

    /**
     * Returns the bouncesPerVisit
     *
     * @return float $bouncesPerVisit
     */
    public function getBouncesPerVisit()
    {
        return $this->bouncesPerVisit;
    }

    /**
     * Sets the bouncesPerVisit
     *
     * @param float $bouncesPerVisit
     * @return void
     */
    public function setBouncesPerVisit($bouncesPerVisit)
    {
        $this->bouncesPerVisit = $bouncesPerVisit;
    }

    /**
     * Returns the timePerVisit
     *
     * @return int $timePerVisit
     */
    public function getTimePerVisit()
    {
        return $this->timePerVisit;
    }

    /**
     * Sets the timePerVisit
     *
     * @param int $timePerVisit
     * @return void
     */
    public function setTimePerVisit($timePerVisit)
    {
        $this->timePerVisit = $timePerVisit;
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
    public function setReport($report)
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
    public function setReportGroup($reportGroup)
    {
        $this->reportGroup = $reportGroup;
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
     * @return float $month
     */
    public function getMonth()
    {
        return $this->month;
    }

    /**
     * Sets the month
     *
     * @param float $month
     * @return void
     */
    public function setMonth($month)
    {
        $this->month = $month;
    }

    /**
     * Returns the quarter
     *
     * @return float $quarter
     */
    public function getQuarter()
    {
        return $this->quarter;
    }

    /**
     * Sets the quarter
     *
     * @param float $quarter
     * @return void
     */
    public function setQuarter($quarter)
    {
        $this->quarter = $quarter;
    }

    /**
     * Returns the year
     *
     * @return float $year
     */
    public function getYear()
    {
        return $this->year;
    }

    /**
     * Sets the year
     *
     * @param float $year
     * @return void
     */
    public function setYear($year)
    {
        $this->year = $year;
    }

}
