<?php
namespace RKW\RkwEtracker\Tests\Unit\Utility;

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

use Nimut\TestingFramework\TestCase\UnitTestCase;
use RKW\RkwEtracker\Domain\Model\Report;
use RKW\RkwEtracker\Utility\DateUtility;
use TYPO3\CMS\Core\Utility\GeneralUtility;

/**
 * DateUtilityTest
 *
 * @author Steffen Kroggel <developer@steffenkroggel.de>
 * @copyright Rkw Kompetenzzentrum
 * @package RKW_RkwEtracker
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 */
class DateUtilityTest extends UnitTestCase
{


    /**
     * Setup
     */
    protected function setUp(): void
    {
        parent::setUp();
    }


    //=============================================

    /**
     * @test
     * @throws \Exception
     */
    public function getStartEndLastYearReturnsLastYearsRange()
    {

        /**
         * Scenario:
         *
         * Given no further param
         * When I call getStartEndYear
         * Then the first day of the last year is returned as startDate
         * Then the last day of the last year is returned as endDate
         * Then zero is returned as month
         * Then zero is returned as quarter
         * Then the last year is returned as year
         */
        $currentTime = getdate();
        $lastYear = $currentTime['year'] - 1;

        $expected = [
            'startDate' => $lastYear . '-01-01',
            'endDate'   => $lastYear . '-12-31',
            'month' => 0,
            'quarter' => 0,
            'year' => $lastYear,
        ];

        self::assertEquals($expected, DateUtility::getStartEndLastYear());

    }

    /**
     * @test
     * @throws \Exception
     */
    public function getStartEndLastYearReturnsGivenYearsRange()
    {

        /**
         * Scenario:
         *
         * Given a date object of the year 1983 as param
         * When I call getStartEndYear
         * Then the first day of the year 1982 is returned as startDate
         * Then the last day of the year 1982 is returned as endDate
         * Then zero is returned as month
         * Then zero is returned as quarter
         * Then the year 1982 is returned as year
         */

        $date = new \DateTime('1983-01-01');
        $expected = [
            'startDate' => '1982-01-01',
            'endDate'   => '1982-12-31',
            'month' => 0,
            'quarter' => 0,
            'year' => 1982,
        ];

        self::assertEquals($expected, DateUtility::getStartEndLastYear($date));

    }

    /**
     * @test
     * @throws \Exception
     */
    public function getStartEndLastYearRespectsGivenDateLimit()
    {

        /**
         * Scenario:
         *
         * Given a date object of the current year as param
         * Given a date limit in the last year as param
         * When I call getStartEndYear
         * Then the given date limit is returned as startDate
         * Then the last day of the last year is returned as endDate
         * Then zero is returned as month
         * Then zero is returned as quarter
         * Then the last year is returned as year
         */

        $date = new \DateTime('now');
        $checkYear = ($date->format('Y') -1);

        $dateLimit = new \DateTime();
        $dateLimit->setDate($checkYear, 2, 15);

        $expected = [
            'startDate' => $checkYear . '-02-15',
            'endDate'   => $checkYear . '-12-31',
            'month' => 0,
            'quarter' => 0,
            'year' => $checkYear,
        ];

        self::assertEquals($expected, DateUtility::getStartEndLastYear($date, $dateLimit));

    }

    //=============================================

    /**
     * @test
     * @throws \Exception
     */
    public function getStartEndLastQuarterReturnsLastQuartersRange()
    {

        /**
         * Scenario:
         *
         * Given a date object of the second quarter of the year 1983 as param
         * When I call getStartEndQuarter
         * Then the first day of the first quarter of the year 1983 is returned as startDate
         * Then the last day of the first quarter of the year 1983 is returned as endDate
         * Then zero is returned as month
         * Then one is returned as quarter
         * Then the year 1983 is returned as year
         */

        $date = new \DateTime('1983-04-01');
        $expected = [
            'startDate' => '1983-01-01',
            'endDate'   => '1983-03-31',
            'month' => 0,
            'quarter' => 1,
            'year' => 1983,
        ];


        self::assertEquals($expected, DateUtility::getStartEndLastQuarter($date));

    }

    /**
     * @test
     * @throws \Exception
     */
    public function getStartEndLastQuarterReturnsLastYearsLastQuartersRange()
    {

        /**
         * Scenario:
         *
         * Given a date object of the first quarter of the year 1983 as param
         * When I call getStartEndQuarter
         * Then the first day of the fourth quarter of the year 1982 is returned as startDate
         * Then the last day of the fourth quarter of the year 1982 is returned as endDate
         * Then zero is returned as month
         * Then four is returned as quarter
         * Then the year 1982 is returned as year
         */

        $date = new \DateTime('1983-03-01');
        $expected = [
            'startDate' => '1982-10-01',
            'endDate'   => '1982-12-31',
            'month' => 0,
            'quarter' => 4,
            'year' => 1982,
        ];


        self::assertEquals($expected, DateUtility::getStartEndLastQuarter($date));

    }


    /**
     * @test
     * @throws \Exception
     */
    public function getStartEndLastQuarterRespectsGivenDateLimit()
    {

        /**
         * Scenario:
         *
         * Given a date object of the second quarter of the year 1983 as param
         * Given a dateLimit in the second half of the first quarter of the year 1983 as param
         * When I call getStartEndQuarter
         * Then the first day of the dateLimit is returned as startDate
         * Then the last day of the first quarter of the year 1983 is returned as endDate
         * Then zero is returned as month
         * Then one is returned as quarter
         * Then the year 1983 is returned as year
         */

        $date = new \DateTime('1983-04-01');
        $dateLimit = new \DateTime('1983-02-15');

        $expected = [
            'startDate' => '1983-02-15',
            'endDate'   => '1983-03-31',
            'month' => 0,
            'quarter' => 1,
            'year' => 1983,
        ];

        self::assertEquals($expected, DateUtility::getStartEndLastQuarter($date, $dateLimit));

    }


    //=============================================

    /**
     * @test
     * @throws \Exception
     */
    public function getStartEndLastMonthReturnsLastMonthRange()
    {

        /**
         * Scenario:
         *
         * Given a date object of march in the year 1983 as param
         * When I call getStartEndMonth
         * Then the first day of the february in the year 1983 is returned as startDate
         * Then the last day of the  february in the year 1983 is returned as endDate
         * Then two is returned as month
         * Then zero is returned as quarter
         * Then the year 1983 is returned as year
         */

        $date = new \DateTime('1983-03-01');
        $expected = [
            'startDate' => '1983-02-01',
            'endDate'   => '1983-02-28',
            'month' => 2,
            'quarter' => 0,
            'year' => 1983,
        ];


        self::assertEquals($expected, DateUtility::getStartEndLastMonth($date));


    }

    /**
     * @test
     * @throws \Exception
     */
    public function getStartEndLastMonthReturnsLastMonthRangeWithLeapDays()
    {

        /**
         * Scenario:
         *
         * Given a date object of march in the year 1984 as param
         * When I call getStartEndMonth
         * Then the first day of the february in the year 1984 is returned as startDate
         * Then the last day of the  february in the year 1984 is returned as endDate
         * Then two is returned as month
         * Then zero is returned as quarter
         * Then the leap day is consider in the endDate
         * Then the year 1984 is returned as year
         */

        $date = new \DateTime('1984-03-01');
        $expected = [
            'startDate' => '1984-02-01',
            'endDate'   => '1984-02-29',
            'month' => 2,
            'quarter' => 0,
            'year' => 1984,
        ];


        self::assertEquals($expected, DateUtility::getStartEndLastMonth($date));

    }

    /**
     * @test
     * @throws \Exception
     */
    public function getStartEndLastMonthReturnsLastYearsLastMonthRange()
    {

        /**
         * Scenario:
         *
         * Given a date object of january in the year 1983 as param
         * When I call getStartEndMonth
         * Then the first day of the december in the year 1982 is returned as startDate
         * Then the last day of the december in the year 1982 is returned as endDate
         * Then twelve is returned as month
         * Then zero is returned as quarter
         * Then the year 1982 is returned as year
         */

        $date = new \DateTime('1983-01-01');
        $expected = [
            'startDate' => '1982-12-01',
            'endDate'   => '1982-12-31',
            'month' => 12,
            'quarter' => 0,
            'year' => 1982,
        ];

        self::assertEquals($expected, DateUtility::getStartEndLastMonth($date));
    }


    /**
     * @test
     * @throws \Exception
     */
    public function getStartEndLastMonthRespectsGivenDateLimit()
    {

        /**
         * Scenario:
         *
         * Given a date object of the second month of the year 1983 as param
         * Given a dateLimit in the second half of the second month of the year 1983 as param
         * When I call getStartEndMonth
         * Then the first day of the dateLimit is returned as startDate
         * Then the last day of the second month of the year 1983 is returned as endDate
         * Then two is returned as month
         * Then zero is returned as quarter
         * Then the year 1983 is returned as year
         */
        $date = new \DateTime('1983-02-01');
        $dateLimit = new \DateTime('1983-01-15');

        $expected = [
            'startDate' => '1983-01-15',
            'endDate'   => '1983-01-31',
            'month' => 1,
            'quarter' => 0,
            'year' => 1983,
        ];

        self::assertEquals($expected, DateUtility::getStartEndLastMonth($date, $dateLimit));

    }


    //=============================================
    /**
     * @test
     * @throws \Exception
     */
    public function getStartEndForReportReturnsLastYearsRangeByDefault()
    {

        /**
         * Scenario:
         *
         * Given a report with default values as param
         * Given a date object of first of June of the year 1983 as param
         * When I call setStartEndForReport
         * Then the first day of the year 1982 is returned as startDate
         * Then the last day of the year 1982 is returned as endDate
         * Then zero is returned as month
         * Then zero is returned as quarter
         * Then the year 1982 is returned as year
         */

        /** @var Report $report */
        $report = GeneralUtility::makeInstance(Report::class);
        $date = new \DateTime('1983-06-01');

        $expected = [
            'startDate' => '1982-01-01',
            'endDate'   => '1982-12-31',
            'month' => 0,
            'quarter' => 0,
            'year' => 1982,
        ];

        self::assertEquals($expected, DateUtility::getStartEndForReport($report, [], $date));

    }


    /**
     * @test
     * @throws \Exception
     */
    public function getStartEndForReportReturnsLastQuartersRange()
    {

        /**
         * Scenario:
         *
         * Given a report with 1 as type as param
         * Given a date object of first of June of the year 1983 as param
         * When I call getStartEndForReport
         * Then the first day of January of the year 1983 is is returned as startDate
         * Then the last day of March of the year 1983 is returned as endDae
         * Then zero is returned as month
         * Then one is returned as quarter
         * Then the year 1983 is returned as year
         */

        /** @var Report $report */
        $report = GeneralUtility::makeInstance(Report::class);
        $report->setType(1);

        $date = new \DateTime('1983-06-01');

        $expected = [
            'startDate' => '1983-01-01',
            'endDate'   => '1983-03-31',
            'month' => 0,
            'quarter' => 1,
            'year' => 1983,
        ];

        self::assertEquals($expected, DateUtility::getStartEndForReport($report, [], $date));
    }


    /**
     * @test
     * @throws \Exception
     */
    public function getStartEndForReportReturnsLastMonthRange()
    {

        /**
         * Scenario:
         *
         * Given a report with 2 as type as param
         * Given a date object of first of June of the year 1983 as param
         * When I call getStartEndForReport
         * Then the first day of May of the year 1983 is returned as startDate
         * Then the last day of May of the year 1983 is returned as endDate
         * Then five is returned as month
         * Then zero is returned as quarter
         * Then the year 1983 is returned as year
         */

        /** @var Report $report */
        $report = GeneralUtility::makeInstance(Report::class);
        $report->setType(2);

        $date = new \DateTime('1983-06-01');

        $expected = [
            'startDate' => '1983-05-01',
            'endDate'   => '1983-05-31',
            'month' => 5,
            'quarter' => 0,
            'year' => 1983,
        ];

        self::assertEquals($expected, DateUtility::getStartEndForReport($report, [], $date));
     }


    /**
     * @test
     * @throws \Exception
     */
    public function getStartEndForReportRespectsAccountStartDate()
    {

        /**
         * Scenario:
         *
         * Given a report with 2 as type as param
         * Given an accountStartDate of the fifteenths of May of the year 1983 via configuration as param
         * Given a date object of first of June of the year 1983 as param
         * When I call getStartEndForReport
         * Then the fifteenths of May of the year 1983 is returned as startDate
         * Then the last day of May of the year 1983 is returned as endDate
         * Then five is returned as month
         * Then zero is returned as quarter
         * Then the year 1983 is returned as year
         */

        /** @var Report $report */
        $report = GeneralUtility::makeInstance(Report::class);
        $report->setType(2);

        $date = new \DateTime('1983-06-01');

        $configuration = [
            'accountStartDate' => '1983-05-15'
        ];

        $expected = [
            'startDate' => '1983-05-15',
            'endDate'   => '1983-05-31',
            'month' => 5,
            'quarter' => 0,
            'year' => 1983,
        ];

        self::assertEquals($expected, DateUtility::getStartEndForReport($report, $configuration, $date));

    }

    //=============================================
    /**
     * @test
     * @throws \Exception
     */
    public function setStartEndForReportReturnsLastYearsRangeByDefault()
    {

        /**
         * Scenario:
         *
         * Given a report with default values as param
         * Given a date object of first of June of the year 1983 as param
         * When I call setStartEndForReport
         * Then the first day of the year 1982 is set as lastStartTstamp in the report object
         * Then the last day of the year 1982 is set as lastEndTstamp in the report object
         * Then zero is set as month in the report object
         * Then zero is set as quarter in the report object
         * Then the year 1982 is set as year in the report object
         */

        /** @var Report $report */
        $report = GeneralUtility::makeInstance(Report::class);
        $date = new \DateTime('1983-06-01');

        $expected = [
            'startDate' => '1982-01-01',
            'endDate'   => '1982-12-31',
            'month' => 0,
            'quarter' => 0,
            'year' => 1982,
        ];

        DateUtility::setStartEndForReport($report, [], $date);
        self::assertEquals($report->getMonth(), $expected['month']);
        self::assertEquals($report->getQuarter(), $expected['quarter']);
        self::assertEquals($report->getYear(), $expected['year']);
        self::assertEquals(date('Y-m-d', $report->getLastStartTstamp()), $expected['startDate']);
        self::assertEquals(date('Y-m-d', $report->getLastEndTstamp()), $expected['endDate']);

    }


    /**
     * @test
     * @throws \Exception
     */
    public function setStartEndForReportReturnsLastQuartersRange()
    {

        /**
         * Scenario:
         *
         * Given a report with 1 as type as param
         * Given a date object of first of June of the year 1983 as param
         * When I call setStartEndForReport
         * Then the first day of January of the year 1983 is set as lastStartTstamp in the report object
         * Then the last day of March of the year 1983 is set as lastEndTstamp in the report object
         * Then zero is set as month in the report object
         * Then one is set as quarter in the report object
         * Then the year 1983 is set as year in the report object
         */

        /** @var Report $report */
        $report = GeneralUtility::makeInstance(Report::class);
        $report->setType(1);

        $date = new \DateTime('1983-06-01');

        $expected = [
            'startDate' => '1983-01-01',
            'endDate'   => '1983-03-31',
            'month' => 0,
            'quarter' => 1,
            'year' => 1983,
        ];

        DateUtility::setStartEndForReport($report, [], $date);
        self::assertEquals($report->getMonth(), $expected['month']);
        self::assertEquals($report->getQuarter(), $expected['quarter']);
        self::assertEquals($report->getYear(), $expected['year']);
        self::assertEquals(date('Y-m-d', $report->getLastStartTstamp()), $expected['startDate']);
        self::assertEquals(date('Y-m-d', $report->getLastEndTstamp()), $expected['endDate']);
    }

    /**
     * @test
     * @throws \Exception
     */
    public function setStartEndForReportReturnsLastMonthRange()
    {

        /**
         * Scenario:
         *
         * Given a report with 2 as type as param
         * Given a date object of first of June of the year 1983 as param
         * When I call setStartEndForReport
         * Then the first day of May of the year 1983 is set as lastStartTstamp in the report object
         * Then the last day of May of the year 1983 is set as lastEndTstamp in the report object
         * Then five is set as month in the report object
         * Then zero is set as quarter in the report object
         * Then the year 1983 is set as year in the report object
         */

        /** @var Report $report */
        $report = GeneralUtility::makeInstance(Report::class);
        $report->setType(2);

        $date = new \DateTime('1983-06-01');

        $expected = [
            'startDate' => '1983-05-01',
            'endDate'   => '1983-05-31',
            'month' => 5,
            'quarter' => 0,
            'year' => 1983,
        ];

        DateUtility::setStartEndForReport($report, [], $date);
        self::assertEquals($report->getMonth(), $expected['month']);
        self::assertEquals($report->getQuarter(), $expected['quarter']);
        self::assertEquals($report->getYear(), $expected['year']);
        self::assertEquals(date('Y-m-d', $report->getLastStartTstamp()), $expected['startDate']);
        self::assertEquals(date('Y-m-d', $report->getLastEndTstamp()), $expected['endDate']);
    }


    /**
     * @test
     * @throws \Exception
     */
    public function setStartEndForReportRespectsAccountStartDate()
    {

        /**
         * Scenario:
         *
         * Given a report with 2 as type as param
         * Given an accountStartDate of the fifteenths of May of the year 1983 via configuration as param
         * Given a date object of first of June of the year 1983 as param
         * When I call setStartEndForReport
         * Then the fifteenths of May of the year 1983 is set as lastStartTstamp in the report object
         * Then the last day of May of the year 1983 is set as lastEndTstamp in the report object
         * Then five is set as month in the report object
         * Then zero is set as quarter in the report object
         * Then the year 1983 is set as year in the report object
         */

        /** @var Report $report */
        $report = GeneralUtility::makeInstance(Report::class);
        $report->setType(2);

        $date = new \DateTime('1983-06-01');

        $configuration = [
            'accountStartDate' => '1983-05-15'
        ];

        $expected = [
            'startDate' => '1983-05-15',
            'endDate'   => '1983-05-31',
            'month' => 5,
            'quarter' => 0,
            'year' => 1983,
        ];

        DateUtility::setStartEndForReport($report, $configuration, $date);
        self::assertEquals($report->getMonth(), $expected['month']);
        self::assertEquals($report->getQuarter(), $expected['quarter']);
        self::assertEquals($report->getYear(), $expected['year']);
        self::assertEquals(date('Y-m-d', $report->getLastStartTstamp()), $expected['startDate']);
        self::assertEquals(date('Y-m-d', $report->getLastEndTstamp()), $expected['endDate']);
    }


    //=============================================
    /**
     * @test
     * @throws \Exception
     */
    public function isReportImportNeededReturnsFalseForLastYear()
    {

        /**
         * Scenario:
         *
         * Given a report with default values as param
         * Given that report has the first of January of the last year as lastStartTimestamp
         * Given the current date is the fifteenths of January of the current year
         * When I call isReportImportNeeded
         * Then false is returned
         */
        $currentDate = new \DateTime(date('Y') . '-06-15');

        $date = new \DateTime(date('Y') . '-01-01');
        $date->modify('-1 year');

        /** @var Report $report */
        $report = GeneralUtility::makeInstance(Report::class);
        $report->setLastStartTstamp(strtotime($date->format('Y-m-d')));

        self::assertFalse(DateUtility::isReportImportNeeded($report, [], $currentDate));

    }

    /**
     * @test
     * @throws \Exception
     */
    public function isReportImportNeededReturnsTrueForYearBeforeLast()
    {

        /**
         * Scenario:
         *
         * Given a report with default values as param
         * Given that report has the first of January of the year before last as lastStartTimestamp
         * Given the current date is the fifteenths of January of the current year
         * When I call isReportImportNeeded
         * Then true is returned
         */
        $currentDate = new \DateTime(date('Y') . '-06-15');

        $date = new \DateTime(date('Y') . '-01-01');
        $date->modify('-2 year');

        /** @var Report $report */
        $report = GeneralUtility::makeInstance(Report::class);
        $report->setLastStartTstamp(strtotime($date->format('Y-m-d')));

        self::assertTrue(DateUtility::isReportImportNeeded($report, [], $currentDate));

    }


    /**
     * @test
     * @throws \Exception
     */
    public function isReportImportNeededReturnsFalseForYearBeforeLastWhenStartInNextMonth()
    {

        /**
         * Scenario:
         *
         * Given a report with default values as param
         * Given the current date is the fifteenths of January of the current year
         * Given that report has the first of January of the year before last as lastStartTimestamp
         * Given that report has set the startTime to the fifteenths of January of the next year
         * When I call isReportImportNeeded
         * Then false is returned
         */
        $currentDate = new \DateTime(date('Y') . '-01-15');

        $date = new \DateTime(date('Y') . '-01-15');
        $date->modify('-2 year');

        $startDate = new \DateTime(date('Y') . '-01-15');
        $startDate->modify('+1 year');

        /** @var Report $report */
        $report = GeneralUtility::makeInstance(Report::class);
        $report->setLastStartTstamp(strtotime($date->format('Y-m-d')));
        $report->setStartime(strtotime($startDate->format('Y-m-d')));

        self::assertFalse(DateUtility::isReportImportNeeded($report, [], $currentDate));

    }

    /**
     * @test
     * @throws \Exception
     */
    public function isReportImportNeededReturnsTrueForYearBeforeLastWhenStartInCurrentMonth()
    {

        /**
         * Scenario:
         *
         * Given a report with default values as param
         * Given the current date is the fifteenths of January of the current year
         * Given that report has the fifteenths of January of the year before last as lastStartTimestamp
         * Given that report has set the startTime to the fifteenths of January of the current year
         * When I call isReportImportNeeded
         * Then true is returned
         */

        $currentDate = new \DateTime(date('Y') . '-06-15');

        $date = new \DateTime(date('Y') . '-01-15');
        $date->modify('-2 year');

        $startDate = new \DateTime(date('Y') . '-01-15');

        /** @var Report $report */
        $report = GeneralUtility::makeInstance(Report::class);
        $report->setLastStartTstamp(strtotime($date->format('Y-m-d')));
        $report->setStartime(strtotime($startDate->format('Y-m-d')));

        self::assertTrue(DateUtility::isReportImportNeeded($report, [], $currentDate));

    }

    /**
     * @test
     * @throws \Exception
     */
    public function isReportImportNeededReturnsFalseForLastQuarter()
    {

        /**
         * Scenario:
         *
         * Given a report with 1 as type as param
         * Given the current date is the fifteenths of June of the current year
         * Given that report has the first of January of the current year as lastStartTimestamp
         * When I call isReportImportNeeded
         * Then false is returned
         */

        $currentDate = new \DateTime(date('Y') . '-06-15');
        $date = new \DateTime(date('Y') . '-01-01');

        /** @var Report $report */
        $report = GeneralUtility::makeInstance(Report::class);
        $report->setType(1);
        $report->setLastStartTstamp(strtotime($date->format('Y-m-d')));

        self::assertFalse(DateUtility::isReportImportNeeded($report, [], $currentDate));

    }

    /**
     * @test
     * @throws \Exception
     */
    public function isReportImportNeededReturnsTrueForQuarterBeforeLast()
    {

        /**
         * Scenario:
         *
         * Given a report with 1 as type as param
         * Given the current date is the fifteenths of August of the current year
         * Given that report has the first of January of the current year as lastStartTimestamp
         * When I call isReportImportNeeded
         * Then true is returned
         */

        $currentDate = new \DateTime(date('Y') . '-08-15');
        $date = new \DateTime(date('Y') . '-01-01');

        /** @var Report $report */
        $report = GeneralUtility::makeInstance(Report::class);
        $report->setType(1);
        $report->setLastStartTstamp(strtotime($date->format('Y-m-d')));

        self::assertTrue(DateUtility::isReportImportNeeded($report, [], $currentDate));

    }

    /**
     * @test
     * @throws \Exception
     */
    public function isReportImportNeededReturnsFalseForQuarterBeforeLastWhenStartInNextMonth()
    {

        /**
         * Scenario:
         *
         * Given a report with 1 as type as param
         * Given the current date is the fifteenths of August of the current year
         * Given that report has the first of January of the current year as lastStartTimestamp
         * Given that report has set the startTime is the fifteenths of September of the same year
         * When I call isReportImportNeeded
         * Then false is returned
         */

        $currentDate = new \DateTime(date('Y') . '-08-15');
        $date = new \DateTime(date('Y') . '-01-01');
        $startDate = new \DateTime(date('Y') . '-09-15');

        /** @var Report $report */
        $report = GeneralUtility::makeInstance(Report::class);
        $report->setType(1);
        $report->setLastStartTstamp(strtotime($date->format('Y-m-d')));
        $report->setStartime(strtotime($startDate->format('Y-m-d')));

        self::assertFalse(DateUtility::isReportImportNeeded($report, [], $currentDate));

    }

    /**
     * @test
     * @throws \Exception
     */
    public function isReportImportNeededReturnsTrueForQuarterBeforeLastWhenStartInCurrentMonth()
    {

        /**
         * Scenario:
         *
         * Given a report with 1 as type as param
         * Given the current date is the fifteenths of August of the current year
         * Given that report has the first of January of the current year as lastStartTimestamp
         * Given that report has set the startTime is the fifteenths of August of the same year
         * When I call isReportImportNeeded
         * Then true is returned
         */

        $currentDate = new \DateTime(date('Y') . '-08-15');
        $date = new \DateTime(date('Y') . '-01-01');
        $startDate = new \DateTime(date('Y') . '-08-15');

        /** @var Report $report */
        $report = GeneralUtility::makeInstance(Report::class);
        $report->setType(1);
        $report->setLastStartTstamp(strtotime($date->format('Y-m-d')));
        $report->setStartime(strtotime($startDate->format('Y-m-d')));

        self::assertTrue(DateUtility::isReportImportNeeded($report, [], $currentDate));

    }


    /**
     * @test
     * @throws \Exception
     */
    public function isReportImportNeededReturnsFalseForLastMonth()
    {

        /**
         * Scenario:
         *
         * Given a report with 2 as type as param
         * Given the current date is the fifteenths of Feburary of the current year
         * Given that report has the first of January of the current year as lastStartTimestamp
         * When I call isReportImportNeeded
         * Then false is returned
         */

        $currentDate = new \DateTime(date('Y') . '-02-15');
        $date = new \DateTime(date('Y') . '-01-01');

        /** @var Report $report */
        $report = GeneralUtility::makeInstance(Report::class);
        $report->setType(2);
        $report->setLastStartTstamp(strtotime($date->format('Y-m-d')));

        self::assertFalse(DateUtility::isReportImportNeeded($report, [], $currentDate));

    }

    /**
     * @test
     * @throws \Exception
     */
    public function isReportImportNeededReturnsTrueForMonthBeforeLast()
    {

        /**
         * Scenario:
         *
         * Given a report with 2 as type as param
         * Given the current date is the fifteenths of March of the current year
         * Given that report has the first of January of the current year as lastStartTimestamp
         * When I call isReportImportNeeded
         * Then true is returned
         */

        $currentDate = new \DateTime(date('Y') . '-03-15');
        $date = new \DateTime(date('Y') . '-01-01');

        /** @var Report $report */
        $report = GeneralUtility::makeInstance(Report::class);
        $report->setType(2);
        $report->setLastStartTstamp(strtotime($date->format('Y-m-d')));

        self::assertTrue(DateUtility::isReportImportNeeded($report, [], $currentDate));

    }


    /**
     * @test
     * @throws \Exception
     */
    public function isReportImportNeededReturnsFalseForMonthBeforeLastWhenStartInNextMonth()
    {

        /**
         * Scenario:
         *
         * Given a report with 2 as type as param
         * Given the current date is the fifteenths of March of the current year
         * Given that report has the first of January of the current year as lastStartTimestamp
         * Given that report has set the startTime is the fifteenths of April of the same year
         * When I call isReportImportNeeded
         * Then false is returned
         */

        $currentDate = new \DateTime(date('Y') . '-03-15');
        $date = new \DateTime(date('Y') . '-01-01');
        $startDate = new \DateTime(date('Y') . '-04-15');

        /** @var Report $report */
        $report = GeneralUtility::makeInstance(Report::class);
        $report->setType(2);
        $report->setLastStartTstamp(strtotime($date->format('Y-m-d')));
        $report->setStartime(strtotime($startDate->format('Y-m-d')));

        self::assertFalse(DateUtility::isReportImportNeeded($report, [], $currentDate));

    }

    /**
     * @test
     * @throws \Exception
     */
    public function isReportImportNeededReturnsTrueForMonthBeforeLastWhenStartInCurrentMonth()
    {

        /**
         * Scenario:
         *
         * Given a report with 2 as type as param
         * Given the current date is the fifteenths of March of the current year
         * Given that report has the first of January of the current year as lastStartTimestamp
         * Given that report has set the startTime is the fifteenths of March of the same year
         * When I call isReportImportNeeded
         * Then true is returned
         */

        $currentDate = new \DateTime(date('Y') . '-03-15');
        $date = new \DateTime(date('Y') . '-01-01');
        $startDate = new \DateTime(date('Y') . '-03-15');

        /** @var Report $report */
        $report = GeneralUtility::makeInstance(Report::class);
        $report->setType(2);
        $report->setLastStartTstamp(strtotime($date->format('Y-m-d')));
        $report->setStartime(strtotime($startDate->format('Y-m-d')));

        self::assertTrue(DateUtility::isReportImportNeeded($report, [], $currentDate));

    }
    /**
     * TearDown
     */
    protected function tearDown(): void
    {
        parent::tearDown();
    }








}
