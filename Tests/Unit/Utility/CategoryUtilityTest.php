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
use RKW\RkwEtracker\Domain\Model\AreaData;
use RKW\RkwEtracker\Domain\Model\ReportFilter;
use RKW\RkwEtracker\Utility\CategoryUtility;
use TYPO3\CMS\Core\Utility\GeneralUtility;


/**
 * CategoryUtilityTest
 *
 * @author Steffen Kroggel <developer@steffenkroggel.de>
 * @copyright RKW Kompetenzzentrum
 * @package RKW_RkwEtracker
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 */
class CategoryUtilityTest extends UnitTestCase
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
     */
    public function cleanupCategoryNameUnifiesCategoryName()
    {

        /**
         * Scenario:
         *
         * Given a category-name with non-alphanumeric signs
         * When I call cleanupCategoryName with that category-name
         * Then non alphanumeric signs are removed
         * Then german umlauts are kept
         * Then hyphens are kept
         * Then spaces are replaced with uppercase
         * Then the first letter is set to uppercase
         * Then uppercase letters are kept
         * Then slashes are replaces with hyphens
         */

        $checkArray = [
            'Entrepreneurship Education' => 'EntrepreneurshipEducation',
            'Gründen mit Erfahrung' => 'GründenMitErfahrung',
            'startup meets Mittelstand' => 'StartupMeetsMittelstand',
            'RG-Bau' => 'RG-Bau',
            'APRODI' => 'APRODI',
            'Leben/Sterben' => 'Leben-Sterben',
            'Das Handwerk - "Wirtschaftsmacht von nebenan"' => 'DasHandwerk-WirtschaftsmachtVonNebenan'
        ];

        foreach ($checkArray as $source => $expected) {
            self::assertEquals($expected, CategoryUtility::cleanUpCategoryName($source));
        }

    }


    /**
     * @test
     */
    public function cleanupDomainNameUnifiesDomainName()
    {

        /**
         * Scenario:
         *
         * Given a domain-name with invalid format according to RFC 1035
         * When I call cleanupDomainName with that domain-name
         * Then non alphanumeric signs are removed
         * Then german umlauts are kept
         * Then hyphens are kept
         * Then uppercase is replaced with lowercase
         */

        $checkArray = [
            'RKW.de' => 'rkw.de',
            'www.RKW-Kompetenzzentrum.de' => 'www.rkw-kompetenzzentrum.de',
            'www.Geschäftsmodellentwicklung.de' => 'www.geschäftsmodellentwicklung.de',
            'www.erfolgreich-digitalisieren.de' => 'www.erfolgreich-digitalisieren.de',
            'www.space in between.net' => 'www.spaceinbetween.net'
        ];

        foreach ($checkArray as $source => $expected) {
            self::assertEquals($expected, CategoryUtility::cleanUpDomainName($source));
        }

    }



    /**
     * @test
     */
    public function categoryImplodeMergesCategoriesAndAddsDomainPrefix()
    {

        /**
         * Scenario:
         *
         * Given an domain name with invalid signs
         * Given an array with category-names
         * When I call categoryImplode with that array
         * Then the given params are combined with a hyphen as separator
         * Then the domain-name prefixes all given categories
         * Then the categories follow the domain-name in the order given by the array
         * Then the category-names are sanitized
         * Then the domain-name is sanitized
         */

        $domain = 'stepp_den bär.com';
        $categoryArray = [
            'Gründen mit Erfahrung',
            'startup meets Mittelstand',
            'RG-Bau',
            'APRODI',
            'Leben/Sterben',
            'Das Handwerk - "Wirtschaftsmacht von nebenan"'
        ];

        $expected = 'steppdenbär.com/GründenMitErfahrung/StartupMeetsMittelstand/RG-Bau/APRODI/Leben-Sterben/DasHandwerk-WirtschaftsmachtVonNebenan';
        self::assertEquals($expected, CategoryUtility::implodeCategories($domain, $categoryArray));

    }

    /**
     * @test
     */
    public function categoryImplodeIgnoresEmptyDomainPrefix()
    {

        /**
         * Scenario:
         *
         * Given an empty domain name
         * Given an array with category-names
         * When I call categoryImplode with that array
         * Then the given params are combined with a hyphen as separator
         * Then the domain-name is ignored
         * Then the categories appear in the order given by the array
         * Then the category-names are sanitized
         */

        $domain = '';
        $categoryArray = [
            'Gründen mit Erfahrung',
            'startup meets Mittelstand',
            'RG-Bau',
            'APRODI',
            'Leben/Sterben',
            'Das Handwerk - "Wirtschaftsmacht von nebenan"',
        ];

        $expected = 'GründenMitErfahrung/StartupMeetsMittelstand/RG-Bau/APRODI/Leben-Sterben/DasHandwerk-WirtschaftsmachtVonNebenan';
        self::assertEquals($expected, CategoryUtility::implodeCategories($domain, $categoryArray));

    }


    /**
     * @test
     */
    public function categoryImplodeAddsDefaultCategories()
    {

        /**
         * Scenario:
         *
         * Given an domain name with invalid signs
         * Given an array with category-names
         * Given the first of the array values is empty
         * Given one of the array values in the middle is empty
         * Given the last of the array values is empty
         * When I call categoryImplode with that array
         * Then the given params are combined with a hyphen as separator
         * Then the domain-name prefixes all given categories
         * Then the categories follow the domain-name in the order given by the array
         * Then the empty values in the middle of the array are replaced with 'Default'
         * Then the empty values at the beginning of the array are replaced with 'Default'
         * Then the empty values at the beginning of the array are replaced with 'Default'
         * Then the category-names are sanitized
         * Then the domain-name is sanitized
         */

        $domain = 'stepp_den bär.com';
        $categoryArray = [
            '',
            'Gründen mit Erfahrung',
            'startup meets Mittelstand',
            'RG-Bau',
            '',
            'APRODI',
            'Leben/Sterben',
            'Das Handwerk - "Wirtschaftsmacht von nebenan"',
            '',
            ''
        ];

        $expected = 'steppdenbär.com/Default/GründenMitErfahrung/StartupMeetsMittelstand/RG-Bau/Default/APRODI/Leben-Sterben/DasHandwerk-WirtschaftsmachtVonNebenan';
        self::assertEquals($expected, CategoryUtility::implodeCategories($domain, $categoryArray));

    }


    /**
     * @test
     */
    public function categoryImplodeUsesGivenDefaultValue()
    {

        /**
         * Scenario:
         *
         * Given a customized default value for empty categories
         * Given an domain name with invalid signs
         * Given an array with category-names
         * Given the first of the array values is empty
         * Given one of the array values in the middle is empty
         * Given the last of the array values is empty
         * When I call categoryImplode with that array
         * Then the given params are combined with a hyphen as separator
         * Then the domain-name prefixes all given categories
         * Then the categories follow the domain-name in the order given by the array
         * Then the empty values in the middle of the array are replaced with the customized default value
         * Then the empty values at the beginning of the array are replaced with the customized default value
         * Then the empty values at the beginning of the array are replaced with with the customized default value
         * Then the category-names are sanitized
         * Then the domain-name is sanitized
         * Then the custom default value is sanitized
         */

        $defaultValue = 'magic Wün_der.+Land';
        $domain = 'stepp_den bär.com';
        $categoryArray = [
            '',
            'Gründen mit Erfahrung',
            'startup meets Mittelstand',
            'RG-Bau',
            '',
            'APRODI',
            'Leben/Sterben',
            'Das Handwerk - "Wirtschaftsmacht von nebenan"',
            '',
            ''
        ];

        $expected = 'steppdenbär.com/MagicWünderLand/GründenMitErfahrung/StartupMeetsMittelstand/RG-Bau/MagicWünderLand/APRODI/Leben-Sterben/DasHandwerk-WirtschaftsmachtVonNebenan';
        self::assertEquals($expected, CategoryUtility::implodeCategories($domain, $categoryArray, $defaultValue));

    }

    /**
     * @test
     */
    public function categoryImplodeIgnoresSanitizationForGivenDefaultValue()
    {

        /**
         * Scenario:
         *
         * Given a customized default value for empty categories
         * Given the sanitization paramater for the default value is set to false
         * Given an domain name with invalid signs
         * Given an array with category-names
         * Given the first of the array values is empty
         * Given one of the array values in the middle is empty
         * Given the last of the array values is empty
         * When I call categoryImplode with that array
         * Then the given params are combined with a hyphen as separator
         * Then the domain-name prefixes all given categories
         * Then the categories follow the domain-name in the order given by the array
         * Then the empty values in the middle of the array are replaced with the customized default value
         * Then the empty values at the beginning of the array are replaced with the customized default value
         * Then the empty values at the beginning of the array are replaced with with the customized default value
         * Then the category-names are sanitized
         * Then the domain-name is sanitized
         * Then the custom default value is not sanitized
         */

        $defaultValue = 'magic Wün_der.+Land';
        $domain = 'stepp_den bär.com';
        $categoryArray = [
            '',
            'Gründen mit Erfahrung',
            'startup meets Mittelstand',
            'RG-Bau',
            '',
            'APRODI',
            'Leben/Sterben',
            'Das Handwerk - "Wirtschaftsmacht von nebenan"',
            '',
            ''
        ];

        $expected = 'steppdenbär.com/magic Wün_der.+Land/GründenMitErfahrung/StartupMeetsMittelstand/RG-Bau/magic Wün_der.+Land/APRODI/Leben-Sterben/DasHandwerk-WirtschaftsmachtVonNebenan';
        self::assertEquals($expected, CategoryUtility::implodeCategories($domain, $categoryArray, $defaultValue, false));

    }



    //=============================================

    /**
     * @test
     */
    public function reportFilterCategoriesToArrayReturnsAllCategories()
    {

        /**
         * Scenario:
         *
         * Given a reportFilter is set as param
         * Given that reportFilter has a filter by domain
         * Given that reportFilter has four of five category filters set
         * Given that the third category filter is empty
         * When I call reportFilterCategoriesToArray
         * Then the domain is not included in the returned array
         * Then all five category filters are returned
         * Then the empty third category filter is returned as empty value
         * Then all category filters are sanitized
         */

        /** @var ReportFilter $reportFilter */
        $reportFilter = GeneralUtility::makeInstance(ReportFilter::class);
        $reportFilter->setDomain('meine dolle domäne.com');
        $reportFilter->setCategoryLevel1('Pferde_Stärken');
        $reportFilter->setCategoryLevel2('Hasen Schwächen');
        $reportFilter->setCategoryLevel3('');
        $reportFilter->setCategoryLevel4('Testen Mit den Besten');
        $reportFilter->setCategoryLevel5('Ganz/Toll');

        $result = CategoryUtility::reportFilterCategoriesToArray($reportFilter);

        $expected = [
            0 => 'PferdeStärken',
            1 => 'HasenSchwächen',
            2 => '',
            3 => 'TestenMitDenBesten',
            4 => 'Ganz-Toll'
        ];

        self::assertIsArray( $result);
        self::assertEquals($expected, $result);
    }


    /**
     * @test
     */
    public function reportFilterCategoriesToArrayTreatsNumericCategoriesAsEmpty()
    {

        /**
         * Scenario:
         *
         * Given a reportFilter is set as param
         * Given that reportFilter has a filter by domain
         * Given that reportFilter has four of five category filters set
         * Given that the third category filter is numeric
         * When I call reportFilterCategoriesToArray
         * Then the domain is not included in the returned array
         * Then all five category filters are returned
         * Then the third category filter is returned as empty value
         * Then all category filters are sanitized
         */

        /** @var ReportFilter $reportFilter */
        $reportFilter = GeneralUtility::makeInstance(ReportFilter::class);
        $reportFilter->setDomain('meine dolle domäne.com');
        $reportFilter->setCategoryLevel1('Pferde_Stärken');
        $reportFilter->setCategoryLevel2('Hasen Schwächen');
        $reportFilter->setCategoryLevel3('15');
        $reportFilter->setCategoryLevel4('Testen Mit den Besten');
        $reportFilter->setCategoryLevel5('Ganz/Toll');

        $result = CategoryUtility::reportFilterCategoriesToArray($reportFilter);

        $expected = [
            0 => 'PferdeStärken',
            1 => 'HasenSchwächen',
            2 => '',
            3 => 'TestenMitDenBesten',
            4 => 'Ganz-Toll'
        ];

        self::assertIsArray( $result);
        self::assertEquals($expected, $result);
    }

    /**
     * @test
     */
    public function reportFilterCategoriesToArrayReturnsEmptyArrayIfAllCategoriesEmpty()
    {

        /**
         * Scenario:
         *
         * Given a reportFilter is set as param
         * Given that reportFilter no category filters are set
         * When I call reportFilterCategoriesToArray
         * Then an empty array is returned
         */

        /** @var ReportFilter $reportFilter */
        $reportFilter = GeneralUtility::makeInstance(ReportFilter::class);

        $result = CategoryUtility::reportFilterCategoriesToArray($reportFilter);

        self::assertIsArray( $result);
        self::assertEmpty($result);
    }


    /**
     * @test
     */
    public function reportFilterCategoriesToArrayDomainFilterIfAllCategoriesEmptyAndDomainSet()
    {

        /**
         * Scenario:
         *
         * Given a reportFilter is set as param
         * Given that reportFilter has a filter by domain
         * Given that reportFilter no category filters set
         * Given the includeDomain param is set to true
         * When I call reportFilterCategoriesToArray
         * Then the domain is returned as only entry in the array
         */

        /** @var ReportFilter $reportFilter */
        $reportFilter = GeneralUtility::makeInstance(ReportFilter::class);
        $reportFilter->setDomain('meine dolle domäne.com');

        $result = CategoryUtility::reportFilterCategoriesToArray($reportFilter, true);

        $expected = [
            0 => 'meinedolledomäne.com',
        ];

        self::assertIsArray( $result);
        self::assertEquals($expected, $result);
    }

    /**
     * @test
     */
    public function reportFilterCategoriesToArrayReturnsAllCategoriesIncludingDomain()
    {

        /**
         * Scenario:
         *
         * Given a reportFilter is set as param
         * Given that reportFilter has a filter by domain
         * Given that reportFilter has four of five category filters set
         * Given that the third category filter is empty
         * Given the includeDomain param is set to true
         * When I call reportFilterCategoriesToArray
         * Then the domain is included in the returned array as first value
         * Then all five category filters are returned after the domain
         * Then the empty third category filter is returned as empty value
         * Then the domain is sanitized
         * Then all category filters are sanitized
         */

        /** @var ReportFilter $reportFilter */
        $reportFilter = GeneralUtility::makeInstance(ReportFilter::class);
        $reportFilter->setDomain('meine doLLe Domäne.com');
        $reportFilter->setCategoryLevel1('Pferde_Stärken');
        $reportFilter->setCategoryLevel2('Hasen Schwächen');
        $reportFilter->setCategoryLevel3('');
        $reportFilter->setCategoryLevel4('Testen Mit den Besten');
        $reportFilter->setCategoryLevel5('Ganz/Toll');

        $result = CategoryUtility::reportFilterCategoriesToArray($reportFilter, true);

        $expected = [
            0 => 'meinedolledomäne.com',
            1 => 'PferdeStärken',
            2 => 'HasenSchwächen',
            3 => '',
            4 => 'TestenMitDenBesten',
            5 => 'Ganz-Toll'
        ];

        self::assertIsArray( $result);
        self::assertEquals($expected, $result);
    }

    /**
     * @test
     */
    public function reportFilterCategoriesToArrayIsOverridenByFreetextCategoriesIncludingDomain()
    {

        /**
         * Scenario:
         *
         * Given a reportFilter is set as param
         * Given that reportFilter has a filter by domain
         * Given that reportFilter has a freetext filter by domain
         * Given that reportFilter has five category filters set
         * Given that reportFilter has five freetext category filters set
         * Given the $includeDomain param is set to true
         * When I call reportFilterCategoriesToArray
         * Then the freetext domain is included in the returned array as first value
         * Then all five freetext category filters are returned after the domain
         * Then the domain is sanitized
         * Then all category filters are sanitized
         */

        /** @var ReportFilter $reportFilter */
        $reportFilter = GeneralUtility::makeInstance(ReportFilter::class);
        $reportFilter->setDomainFree('meine doLLe Domäne.com');
        $reportFilter->setDomain('this is da domain.net');

        $reportFilter->setCategoryFreeLevel1('Pferde_Stärken');
        $reportFilter->setCategoryLevel1('Stärken_Pferde');

        $reportFilter->setCategoryFreeLevel2('Hasen Schwächen');
        $reportFilter->setCategoryLevel2('Schwächen Hasen');

        $reportFilter->setCategoryFreeLevel3('Zucker Schnute');
        $reportFilter->setCategoryLevel3('Schnute Zucker');

        $reportFilter->setCategoryFreeLevel4('Testen Mit den Besten');
        $reportFilter->setCategoryLevel4('Besten Mit dem Testen');

        $reportFilter->setCategoryFreeLevel5('Ganz/Toll');
        $reportFilter->setCategoryLevel5('Toll/Ganz');

        $result = CategoryUtility::reportFilterCategoriesToArray($reportFilter, true);

        $expected = [
            0 => 'meinedolledomäne.com',
            1 => 'PferdeStärken',
            2 => 'HasenSchwächen',
            3 => 'ZuckerSchnute',
            4 => 'TestenMitDenBesten',
            5 => 'Ganz-Toll'
        ];

        self::assertIsArray( $result);
        self::assertEquals($expected, $result);
    }

    //=============================================

    /**
     * @test
     */
    public function reportFilterEventsToStringReturnsAllFilters()
    {

        /**
         * Scenario:
         *
         * Given a reportFilter is set as param
         * Given that reportFilter has a filter by domain
         * Given that reportFilter has an event filter set
         * When I call reportFilterEventsToString
         * Then the domain is not included in the returned array
         * Then the the event filter is returned
         * Then the event filter is sanitized
         */

        /** @var ReportFilter $reportFilter */
        $reportFilter = GeneralUtility::makeInstance(ReportFilter::class);
        $reportFilter->setDomain('meine dolle domäne.com');
        $reportFilter->setDownloadFilter1('Pferde_Stärken');

        $result = CategoryUtility::reportFilterEventsToString($reportFilter);
        $expected = 'PferdeStärken';

        self::assertIsString( $result);
        self::assertEquals($expected, $result);
    }

    /**
     * @test
     */
    public function reportFilterEventsToStringIgnoresEmptyFilters()
    {

        /**
         * Scenario:
         *
         * Given a reportFilter is set as param
         * Given that reportFilter has no filter by name
         * When I call reportFilterEventsToString
         * Then an empty string is returned
         */

        /** @var ReportFilter $reportFilter */
        $reportFilter = GeneralUtility::makeInstance(ReportFilter::class);
        $reportFilter->setDownloadFilter1('');

        $result = CategoryUtility::reportFilterEventsToString($reportFilter);

        self::assertIsString( $result);
        self::assertEmpty($result);
    }

    /**
     * @test
     */
    public function reportFilterEventsToStringReturnsEmptyArrayIfAllFiltersEmptyAndDomainSet()
    {

        /**
         * Scenario:
         *
         * Given a reportFilter is set as param
         * Given that reportFilter has a filter by domain
         * Given that reportFilter has no filter by name
         * Given that includeDomain is set to true
         * When I call reportFilterEventsToString
         * Then an empty array is returned
         */

        /** @var ReportFilter $reportFilter */
        $reportFilter = GeneralUtility::makeInstance(ReportFilter::class);
        $reportFilter->setDomain('meine dolle domäne.com');
        $reportFilter->setDownloadFilter1('');

        $result = CategoryUtility::reportFilterEventsToString($reportFilter, true);

        self::assertIsString( $result);
        self::assertEmpty($result);
    }

    /**
     * @test
     */
    public function reportFilterEventsToStringTreatsNumericFiltersAsEmpty()
    {

        /**
         * Scenario:
         *
         * Given a reportFilter is set as param
         * Given that reportFilter has an numeric filter by name
         * When I call reportFilterEventsToString
         * Then an empty array is returned
         */

        /** @var ReportFilter $reportFilter */
        $reportFilter = GeneralUtility::makeInstance(ReportFilter::class);
        $reportFilter->setDownloadFilter1('15');

        $result = CategoryUtility::reportFilterEventsToString($reportFilter);

        self::assertIsString( $result);
        self::assertEmpty($result);
    }

    /**
     * @test
     */
    public function reportFilterEventsToStringReturnsAllFiltersIncludingDomain()
    {

        /**
         * Scenario:
         *
         * Given a reportFilter is set as param
         * Given that reportFilter has a filter by domain
         * Given that reportFilter an event filters set
         * Given the includeDomain param is set to true
         * When I call reportFilterEventsToString
         * Then the domain is included in the returned array as first part o  the event filter
         * Then the the event filter is returned
         * Then the domain is sanitized
         * Then the event filter is sanitized
         */

        /** @var ReportFilter $reportFilter */
        $reportFilter = GeneralUtility::makeInstance(ReportFilter::class);
        $reportFilter->setDomain('meine dolle domäne.com');
        $reportFilter->setDownloadFilter1('Pferde_Stärken');

        $result = CategoryUtility::reportFilterEventsToString($reportFilter, true);
        $expected = 'meinedolledomäne.com/PferdeStärken';

        self::assertIsString( $result);
        self::assertEquals($expected, $result);
    }

    /**
     * @test
     */
    public function reportFilterEventsToStringIsOverridenByFreetextFilterAndDomain()
    {

        /**
         * Scenario:
         *
         * Given a reportFilter is set as param
         * Given that reportFilter has a filter by domain
         * Given that reportFilter has a freetext filter by domain
         * Given the includeDomain param is set to true
         * When I call reportFilterEventsToString
         * Then the domain is included as first part of the event filter
         * Then the freetext filter is returned
         * Then the domain is sanitized
         * Then the event filter is sanitized
         */

        /** @var ReportFilter $reportFilter */
        $reportFilter = GeneralUtility::makeInstance(ReportFilter::class);
        $reportFilter->setDomain('meine doLLe Domäne.com');
        $reportFilter->setDomainFree('this is da domain.net');

        $reportFilter->setDownloadFilter1('Pferde_Stärken');
        $reportFilter->setDownloadFreeFilter1('Zucker Schnute');

        $result = CategoryUtility::reportFilterEventsToString($reportFilter, true);
        $expected = 'thisisdadomain.net/ZuckerSchnute';

        self::assertIsString( $result);
        self::assertEquals($expected, $result);
    }

    //=============================================


    /**
     * @test
     */
    public function reportFilterCategoriesToJsonReturnsJsonFilterString()
    {

        /**
         * Scenario:
         *
         * Given a reportFilter filters by domain
         * Given that reportFilter filters by the first category
         * Given that reportFilter filters by the second category
         * When I call reportFilterCategoriesToJson with that reportFilter
         * Then the filter criteria are sanitized
         * Then a JSON filter string according to that filter criteria is returned
         * Then the domain is not included in that filter string
         */

        /** @var ReportFilter $reportFilter */
        $reportFilter = GeneralUtility::makeInstance(ReportFilter::class);
        $reportFilter->setDomain('meine dolle domäne.com');
        $reportFilter->setCategoryLevel1('Pferde_Stärken');
        $reportFilter->setCategoryLevel2('Hasen Schwächen');

        $expected = '[{"input":"PferdeStärken","type":"exact","attributeId":"area_level_1","filterType":"extended","filter":"include"}' .
            ',{"input":"HasenSchwächen","type":"exact","attributeId":"area_level_2","filterType":"extended","filter":"include"}]';


        $result = CategoryUtility::reportFilterCategoriesToJson($reportFilter);
        self::assertEquals($expected, $result);
    }


    /**
     * @test
     */
    public function reportFilterCategoriesToJsonSkipsEmptyAndNumericCategoryLevels()
    {

        /**
         * Scenario:
         *
         * Given a reportFilter filters by domain
         * Given that reportFilter filters by the first category
         * Given that reportFilter has no filters by the second category
         * Given that reportFilter has a numeric filters by the third category
         * Given that reportFilter filters by the fourth category
         * When I call reportFilterCategoriesToJson with that reportFilter
         * Then the filter criteria are sanitized
         * Then a JSON filter string according to that filter criteria is returned
         * Then the area level two is skipped
         * Then the area level three is skipped
         * Then the domain is not included in that filter string
         */

        /** @var ReportFilter $reportFilter */
        $reportFilter = GeneralUtility::makeInstance(ReportFilter::class);
        $reportFilter->setDomain('meine dolle domäne.com');
        $reportFilter->setCategoryLevel1('Pferde_Stärken');
        $reportFilter->setCategoryLevel3('15');
        $reportFilter->setCategoryLevel4('Hasen Schwächen');

        $expected = '[{"input":"PferdeStärken","type":"exact","attributeId":"area_level_1","filterType":"extended","filter":"include"}' .
            ',{"input":"HasenSchwächen","type":"exact","attributeId":"area_level_4","filterType":"extended","filter":"include"}]';


        $result = CategoryUtility::reportFilterCategoriesToJson($reportFilter);
        self::assertEquals($expected, $result);
    }


    /**
     * @test
     */
    public function reportFilterCategoriesToJsonReturnsJsonFilterStringIncludingDomain()
    {

        /**
         * Scenario:
         *
         * Given a reportFilter filters by domain
         * Given that reportFilter filters by the first category
         * Given that reportFilter filters by the second category
         * Given that includeDomain is true
         * When I call reportFilterCategoriesToJson with that reportFilter
         * Then the filter criteria are sanitized
         * Then a JSON filter string according to that filter criteria is returned
         * Then the domain is included in that filter string
         */

        /** @var ReportFilter $reportFilter */
        $reportFilter = GeneralUtility::makeInstance(ReportFilter::class);
        $reportFilter->setDomain('meine dolle domäne.com');
        $reportFilter->setCategoryLevel1('Pferde_Stärken');
        $reportFilter->setCategoryLevel2('Hasen Schwächen');

        $expected = '[{"input":"meinedolledomäne.com","type":"exact","attributeId":"area_level_1","filterType":"extended","filter":"include"}' .
            ',{"input":"PferdeStärken","type":"exact","attributeId":"area_level_2","filterType":"extended","filter":"include"}' .
            ',{"input":"HasenSchwächen","type":"exact","attributeId":"area_level_3","filterType":"extended","filter":"include"}]';


        $result = CategoryUtility::reportFilterCategoriesToJson( $reportFilter, true);
        self::assertEquals($expected, $result);
    }

    /**
     * @test
     */
    public function reportFilterCategoriesToJsonReturnsEmptyStringIfNothingSet()
    {

        /**
         * Scenario:
         *
         * Given a reportFilter does not filter by domain
         * Given that reportFilter has no filters set
         * When I call reportFilterCategoriesToJson with that reportFilter
         * Then an empty string is returned
         */

        /** @var ReportFilter $reportFilter */
        $reportFilter = GeneralUtility::makeInstance(ReportFilter::class);

        $result = CategoryUtility::reportFilterCategoriesToJson($reportFilter);
        self::assertEmpty($result);
    }

    //=============================================


    /**
     * @test
     */
    public function reportFilterEventsToJsonReturnsJsonFilterString()
    {

        /**
         * Scenario:
         *
         * Given a reportFilter filters by domain
         * Given that reportFilter has an event filters set
         * When I call reportFilterEventsToJson with that reportFilter
         * Then the filter criteria are sanitized
         * Then a JSON filter string according to that filter criteria is returned
         * Then the domain is not included in that filter string
         */

        /** @var ReportFilter $reportFilter */
        $reportFilter = GeneralUtility::makeInstance(ReportFilter::class);
        $reportFilter->setDomain('meine dolle domäne.com');
        $reportFilter->setDownloadFilter1('Pferde_Stärken');


        $expected = '[{"input":"file","type":"exact","attributeId":"action","filterType":"extended","filter":"include"},' .
            '{"input":["PferdeStärken"],"type":"exact","attributeId":"category","filterType":"extended","filter":"include"}]';

        $result = CategoryUtility::reportFilterEventsToJson($reportFilter);
        self::assertEquals($expected, $result);
    }



    /**
     * @test
     */
    public function reportFilterEventsToJsonReturnsEmptyStringIfEmptyFilter()
    {

        /**
         * Scenario:
         *
         * Given a reportFilter filters by domain
         * Given that reportFilter has no event filter set
         * When I call reportFilterEventsToJson with that reportFilter
         * Then the filter criteria are sanitized
         * Then an empty string is returned
         */

        /** @var ReportFilter $reportFilter */
        $reportFilter = GeneralUtility::makeInstance(ReportFilter::class);
        $reportFilter->setDomain('meine dolle domäne.com');
        $reportFilter->setDownloadFilter1('');


        $result = CategoryUtility::reportFilterEventsToJson($reportFilter);
        self::assertEmpty($result);
    }


    /**
     * @test
     */
    public function reportFilterEventsToJsonReturnsEmptyStringIfEmptyFilterButDomain()
    {
        /**
         * Scenario:
         *
         * Given a reportFilter filters by domain
         * Given that reportFilter has no event filter set
         * Given that includeDomain is true
         * When I call reportFilterEventsToJson with that reportFilter
         * Then an empty string is returned
         */

        /** @var ReportFilter $reportFilter */
        $reportFilter = GeneralUtility::makeInstance(ReportFilter::class);
        $reportFilter->setDomain('meine dolle domäne.com');

        $result = CategoryUtility::reportFilterEventsToJson($reportFilter, true);
        self::assertEmpty($result);
    }



    /**
     * @test
     */
    public function reportFilterEventsToJsonReturnsEmptyStringIfNumericFilter()
    {

        /**
         * Scenario:
         *
         * Given a reportFilter filters by domain
         * Given that reportFilter has a numeric  event filter set
         * When I call reportFilterEventsToJson with that reportFilter
         * Then the filter criteria are sanitized
         * Then an empty string is returned

         */

        /** @var ReportFilter $reportFilter */
        $reportFilter = GeneralUtility::makeInstance(ReportFilter::class);
        $reportFilter->setDomain('meine dolle domäne.com');
        $reportFilter->setDownloadFilter1('');

        $result = CategoryUtility::reportFilterEventsToJson($reportFilter);
        self::assertEmpty($result);
    }

    /**
     * @test
     */
    public function reportFilterEventsToJsonReturnsJsonFilterStringIncludingDomain()
    {
        /**
         * Scenario:
         *
         * Given a reportFilter filters by domain
         * Given that reportFilter has an event filter set
         * Given that includeDomain is true
         * When I call reportFilterEventsToJson with that reportFilter
         * Then the filter criteria are sanitized
         * Then a JSON filter string according to that filter criteria is returned
         * Then the domain is not included in that filter string
         */

        /** @var ReportFilter $reportFilter */
        $reportFilter = GeneralUtility::makeInstance(ReportFilter::class);
        $reportFilter->setDomain('meine dolle domäne.com');
        $reportFilter->setDownloadFilter1('Pferde_Stärken');


        $expected = '[{"input":"file","type":"exact","attributeId":"action","filterType":"extended","filter":"include"},' .
            '{"input":["meinedolledomäne.com/PferdeStärken"],"type":"exact","attributeId":"category","filterType":"extended","filter":"include"}]';

        $result = CategoryUtility::reportFilterEventsToJson($reportFilter, true);
        self::assertEquals($expected, $result);
    }


    /**
     * TearDown
     */
    protected function tearDown(): void
    {
        parent::tearDown();
    }








}
