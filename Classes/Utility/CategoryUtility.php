<?php

namespace RKW\RkwEtracker\Utility;

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
 * Class CategoryUtility
 *
 * @author Steffen Kroggel <developer@steffenkroggel.de>
 * @copyright RKW Kompetenzzentrum
 * @package RKW_RkwEtracker
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 */
class CategoryUtility
{

    /**
     * Cleans up category strings
     * Removes non-alphanumeric signs and sets string to UpperCamelcase
     *
     * @param string $string
     * @return string
     */
    public static function cleanUpCategoryName(string $string): string
    {

        // replace slashes with hyphens for backwards compatibility
        $string = str_replace('/', '-', $string);

        return ucfirst(preg_replace('#[^a-zA-Z0-9\-äÄüÜöÖß]#', '', ucwords($string)));
    }


    /**
     * Cleans up domain strings
     * Removes all signs not allowed in domain names
     *
     * @param string $string
     * @return string
     */
    public static function cleanUpDomainName(string $string): string
    {
        return strtolower(preg_replace('#[^a-zA-Z0-9\-\.äÄüÜöÖß]#', '', $string));
    }


    /**
     * Implodes categories
     *
     * @param string $domain
     * @param array $categories
     * @param string $defaultValue
     * @param bool $sanitizeDefaultValue
     * @return string
     */
    public static function implodeCategories(
        string $domain = '',
        array $categories = [],
        string $defaultValue = 'Default',
        bool $sanitizeDefaultValue = true): string
    {

        $cleanedCategories = [];
        if ($sanitizeDefaultValue) {
            $defaultValue = self::cleanUpCategoryName($defaultValue);
        }

        // add domain
        if ($domain) {
            $cleanedCategories[] = self::cleanUpDomainName($domain);
        }

        // add categories
        foreach ($categories as $category) {
            if (! $category) {
                $cleanedCategories[] = $defaultValue;
            } else {
                $cleanedCategories[] = self::cleanUpCategoryName($category);
            }
        }

        // remove default categories from the end
        while ($defaultValue === end($cleanedCategories)) {
            array_pop($cleanedCategories);
        }

        return implode('/', $cleanedCategories);
    }



    /**
     * Returns categories of a reportFilter as array and optionally includes the domain
     *
     * @param \RKW\RkwEtracker\Domain\Model\ReportFilter $reportFilter
     * @param bool $includeDomain
     * @return array
     * @deprecated This method will be removed soon. Do not use it any more.
     */
    public static function reportFilterCategoriesToArray(
        \RKW\RkwEtracker\Domain\Model\ReportFilter $reportFilter,
        $includeDomain = false
    ): array {

        $categories = [];


        // add all categories to array
        foreach (range(1, 5) as $level) {

            $getter = 'getCategoryLevel' . $level;
            $getterFreetext = 'getCategoryLevel' . $level . 'Free';

            if (method_exists($reportFilter, $getter)) {

                $value = $reportFilter->$getter();
                if (
                    (method_exists($reportFilter, $getterFreetext))
                    && ($reportFilter->$getterFreetext())
                ){
                    $value = $reportFilter->$getterFreetext();
                }

                // treat numeric categories as empty
                if (is_numeric($value)) {
                    $value = '';
                }

                $categories[] = CategoryUtility::cleanUpCategoryName($value);
            }
        }

        // if no categories at all or only empty ones, return an empty array
        if (! array_filter($categories)) {
            $categories = [];
        }

        // add domain if param is true
        if ($includeDomain) {

            $value = $reportFilter->getDomain();
            if ($reportFilter->getDomainFree()) {
                $value = $reportFilter->getDomainFree();
            }
            array_unshift($categories, CategoryUtility::cleanUpDomainName($value));
        }

        return $categories;
    }



    /**
     * Returns categories of a reportFilter as array and optionally includes the domain
     *
     * @param \RKW\RkwEtracker\Domain\Model\ReportFilter $reportFilter
     * @param bool $includeDomain
     * @return string
     * @deprecated This method will be removed soon. Do not use it any more.
     */
    public static function reportFilterEventsToString(
        \RKW\RkwEtracker\Domain\Model\ReportFilter $reportFilter,
        $includeDomain = false
    ): string {

        // add domain to array
        $domain = '';
        if ($includeDomain) {

            $value = $reportFilter->getDomain();
            if ($reportFilter->getDomainFree()) {
                $value = $reportFilter->getDomainFree();
            }
            $domain = CategoryUtility::cleanUpDomainName($value);
        }

        // add all categories to array
        // freeText-Filter overrides normal filter
        // ignore numeric filters !
        if (
            (
                ($value = $reportFilter->getDownloadFreeFilter1())
                || ($value = $reportFilter->getDownloadFilter1())
            )
            && (! is_numeric($value))
        ){
            return ($domain ? $domain . '/' : '') . CategoryUtility::cleanUpCategoryName($value);
        }

        return '';
    }



    /**
     * Returns the JSON-filter for a reportFilter and optionally includes the domain
     *
     * @param \RKW\RkwEtracker\Domain\Model\ReportFilter $reportFilter
     * @param bool $includeDomain
     * @return string
     * @deprecated This method will be removed soon. Do not use it any more.
     */
    public static function reportFilterCategoriesToJson(
        \RKW\RkwEtracker\Domain\Model\ReportFilter $reportFilter,
        $includeDomain = false
    ): string
    {

        // define filter properties
        $categoryFilter = [];
        $categories = CategoryUtility::reportFilterCategoriesToArray($reportFilter, $includeDomain);
        foreach ($categories as $level => $category) {

            // build filter for API
            if ($category){
                $categoryFilter[] = preg_replace("/\s/", '', '
                    {
                        "input":"' . $category . '",
                        "type":"exact",
                        "attributeId":"area_level_' . intval($level + 1) . '",
                        "filterType":"extended",
                        "filter":"include"
                    }
                ');
            }
        }

        if ($categoryFilter) {
            return '[' . implode(',', $categoryFilter) . ']';
        }

        return '';
    }

    /**
     * Returns the JSON-filter for a reportFilter and optionally includes the domain
     *
     * @param \RKW\RkwEtracker\Domain\Model\ReportFilter $reportFilter
     * @param bool $includeDomain
     * @return string
     * @deprecated This method will be removed soon. Do not use it any more.
     */
    public static function reportFilterEventsToJson(
        \RKW\RkwEtracker\Domain\Model\ReportFilter $reportFilter,
        $includeDomain = false
    ): string
    {

        // define filter properties
        if ($categoryFilter = CategoryUtility::reportFilterEventsToString($reportFilter, $includeDomain)) {
            $filterString = preg_replace("/\s/", '', '
                {
                    "input":"file",
                    "type":"exact",
                    "attributeId":"action",
                    "filterType":"extended",
                    "filter":"include"
                },
                {
                    "input":["' . $categoryFilter . '"],
                    "type":"exact",
                    "attributeId":"category",
                    "filterType":"extended",
                    "filter":"include"
                }
            ');
            return '[' . $filterString . ']';
        }

        return '';
    }
}
