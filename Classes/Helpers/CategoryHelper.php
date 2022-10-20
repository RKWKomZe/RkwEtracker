<?php

namespace RKW\RkwEtracker\Helpers;

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

use RKW\RkwEtracker\Utility\CategoryUtility;

/**
 * Class CategoryHelper
 *
 * @author Steffen Kroggel <developer@steffenkroggel.de>
 * @copyright Rkw Kompetenzzentrum
 * @package RKW_RkwEtracker
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 * @deprecated This class will be removed soon. Do not use it any more.
 */
class CategoryHelper
{

    /**
     * Cleans up category strings
     * Removes slashes and sets string to UpperCamelcase
     *
     * @param $string
     * @return string
     */
    public static function cleanUp($string)
    {
        trigger_error(__CLASS__  . ' will be removed soon. Do not use it any more.', E_USER_DEPRECATED);
        return CategoryUtility::cleanUpCategoryName($string);
    }


}
