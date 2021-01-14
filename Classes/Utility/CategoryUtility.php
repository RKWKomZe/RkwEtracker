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
 * @copyright Rkw Kompetenzzentrum
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
}