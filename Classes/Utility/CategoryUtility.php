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
     * Removes slashes and sets string to UpperCamelcase
     *
     * @param $string
     * @return string
     */
    public static function cleanUpCategoryName($string)
    {

        $replacements = array(
            ' ',
            '_',
            '"',
            '.',
        );

        return ucfirst(str_replace($replacements, '', ucwords(str_replace('/', '-', $string))));

    }


}