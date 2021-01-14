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
use RKW\RkwEtracker\Utility\CategoryUtility;


/**
 * CategoryUtilityTest
 *
 * @author Steffen Kroggel <developer@steffenkroggel.de>
 * @copyright Rkw Kompetenzzentrum
 * @package RKW_RkwEtracker
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 */
class CategoryUtilityTest extends UnitTestCase
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
            static::assertEquals($expected, CategoryUtility::cleanUpCategoryName($source));
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
            static::assertEquals($expected, CategoryUtility::cleanUpDomainName($source));
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
        static::assertEquals($expected, CategoryUtility::implodeCategories($domain, $categoryArray));

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
        static::assertEquals($expected, CategoryUtility::implodeCategories($domain, $categoryArray));

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
        static::assertEquals($expected, CategoryUtility::implodeCategories($domain, $categoryArray));

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
        static::assertEquals($expected, CategoryUtility::implodeCategories($domain, $categoryArray, $defaultValue));

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
        static::assertEquals($expected, CategoryUtility::implodeCategories($domain, $categoryArray, $defaultValue, false));

    }
    //=============================================


    /**
     * TearDown
     */
    protected function tearDown()
    {
        parent::tearDown();
    }








}