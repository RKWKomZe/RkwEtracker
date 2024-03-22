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
 * Class AreaData
 *
 * @package RKW_RkwEtracker
 * @author Steffen Kroggel <developer@steffenkroggel.de>
 * @copyright Steffen Kroggel, RKW Kompetenzzentrum
 * @licence http://www.gnu.org/copyleft/gpl.htm GNU General Public License, version 2 or later
 * @deprecated This class will be removed soon. Do not use it any more.
 */
class AreaData extends \TYPO3\CMS\Extbase\DomainObject\AbstractEntity
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
     * @var \RKW\RkwEtracker\Domain\Model\ReportFilter|null
     */
    protected ?ReportFilter $reportFilter = null;


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
     * @return int
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
     * @return int
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
        if ($this->getVisits() > 0) {
            return $this->getPageImpressions() / $this->getVisits();
        }

        return 0.0;
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
     * @return int
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
     * @return \RKW\RkwEtracker\Domain\Model\Report
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
     * @return \RKW\RkwEtracker\Domain\Model\ReportGroup
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
    public function setReportGroup(ReportGroup $reportGroup)
    {
        $this->reportGroup = $reportGroup;
    }


    /**
     * Returns the reportFilter
     *
     * @return \RKW\RkwEtracker\Domain\Model\ReportFilter
     */
    public function getReportFilter(): ReportFilter
    {
        return $this->reportFilter;
    }


    /**
     * Sets the reportFilter
     *
     * @param \RKW\RkwEtracker\Domain\Model\ReportFilter $reportFilter
     * @return void
     */
    public function setReportFilter(ReportFilter $reportFilter): void
    {
        $this->reportFilter = $reportFilter;
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
     * @return int $quarter
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
    public function setQuarter(int $quarter): void
    {
        $this->quarter = $quarter;
    }


    /**
     * Returns the year
     *
     * @return int $year
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
