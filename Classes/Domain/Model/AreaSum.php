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
     * @var int
     */
    protected int $visits = 0;


    /**
     * @var int
     */
    protected int $visitors = 0;


    /**
     * @var int
     */
    protected int $pageImpressions = 0;


    /**
     * @var float
     */
    protected float $pageImpressionsPerVisit = 0.0;


    /**
     * @var float
     */
    protected float $bouncesPerVisit = 0.0;


    /**
     * @var int
     */
    protected int $timePerVisit = 0;


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
    protected int $reportFetchCounter = 0;


    /**
     * @var int
     */
    protected int $month = 0;


    /**
     * @var int
     */
    protected int $quarter = 0;


    /**
     * @var int
     */
    protected int $year = 0;


    /**
     * Returns the visits
     *
     * @return int $visits
     */
    public function getVisits(): int
    {
        return $this->visits;
    }


    /**
     * Sets the visits
     *
     * @param int $visits
     * @return void
     */
    public function setVisits(int $visits): void
    {
        $this->visits = $visits;
    }


    /**
     * Returns the visitors
     *
     * @return int $visitors
     */
    public function getVisitors(): int
    {
        return $this->visitors;
    }


    /**
     * Sets the visitors
     *
     * @param int $visitors
     * @return void
     */
    public function setVisitors(int $visitors): void
    {
        $this->visitors = $visitors;
    }


    /**
     * Returns the pageImpressions
     *
     * @return int $pageImpressions
     */
    public function getPageImpressions(): int
    {
        return $this->pageImpressions;
    }


    /**
     * Sets the pageImpressions
     *
     * @param int $pageImpressions
     * @return void
     */
    public function setPageImpressions(int $pageImpressions): void
    {
        $this->pageImpressions = $pageImpressions;
    }


    /**
     * Returns the pageImpressionsPerVisit
     *
     * @return float $pageImpressionPerVisit
     */
    public function getPageImpressionsPerVisit(): float
    {
        return $this->pageImpressionsPerVisit;
    }


    /**
     * Sets the pageImpressionsPerVisit
     *
     * @param float $pageImpressionsPerVisit
     * @return void
     */
    public function setPageImpressionsPerVisit(float $pageImpressionsPerVisit): void
    {
        $this->pageImpressionsPerVisit = $pageImpressionsPerVisit;
    }


    /**
     * Returns the bouncesPerVisit
     *
     * @return float $bouncesPerVisit
     */
    public function getBouncesPerVisit(): float
    {
        return $this->bouncesPerVisit;
    }


    /**
     * Sets the bouncesPerVisit
     *
     * @param float $bouncesPerVisit
     * @return void
     */
    public function setBouncesPerVisit(float $bouncesPerVisit): void
    {
        $this->bouncesPerVisit = $bouncesPerVisit;
    }


    /**
     * Returns the timePerVisit
     *
     * @return int $timePerVisit
     */
    public function getTimePerVisit(): int
    {
        return $this->timePerVisit;
    }


    /**
     * Sets the timePerVisit
     *
     * @param int $timePerVisit
     * @return void
     */
    public function setTimePerVisit(int $timePerVisit): void
    {
        $this->timePerVisit = $timePerVisit;
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
    public function getReportGroup(): ReportGroup
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
     * @return int $reportFetchCounter
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
     * @return int $month
     */
    public function getMonth(): int
    {
        return $this->month;
    }


    /**
     * Sets the month
     *
     * @param int $month
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
     * @param float $quarter
     * @return void
     */
    public function setQuarter(int $quarter): void
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
