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
use RKW\RkwEtracker\Utility\DateUtility;

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
    protected function setUp()
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

        static::assertEquals($expected, DateUtility::getStartEndLastYear());

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
         * Given a date object of the year 1983
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

        static::assertEquals($expected, DateUtility::getStartEndLastYear($date));

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
         * Given a date object of the current year
         * Given a date limit in the last year
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

        static::assertEquals($expected, DateUtility::getStartEndLastYear($date, $dateLimit));

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
         * Given a date object of the second quarter of the year 1983
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


        static::assertEquals($expected, DateUtility::getStartEndLastQuarter($date));

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
         * Given a date object of the first quarter of the year 1983
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


        static::assertEquals($expected, DateUtility::getStartEndLastQuarter($date));

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
         * Given a date object of the second quarter of the year 1983
         * Given a dateLimit in the second half of the first quarter of the year 1983
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

        static::assertEquals($expected, DateUtility::getStartEndLastQuarter($date, $dateLimit));

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
         * Given a date object of march in the year 1983
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


        static::assertEquals($expected, DateUtility::getStartEndLastMonth($date));


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
         * Given a date object of march in the year 1984
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


        static::assertEquals($expected, DateUtility::getStartEndLastMonth($date));

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
         * Given a date object of january in the year 1983
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

        static::assertEquals($expected, DateUtility::getStartEndLastMonth($date));
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
         * Given a date object of the second month of the year 1983
         * Given a dateLimit in the second half of the second month of the year 1983
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

        static::assertEquals($expected, DateUtility::getStartEndLastMonth($date, $dateLimit));

    }


    /**
     * TearDown
     */
    protected function tearDown()
    {
        parent::tearDown();
    }








}