<?php

namespace RKW\RkwEtracker\ViewHelpers;

use TYPO3\CMS\Fluid\Core\ViewHelper\AbstractViewHelper;
use RKW\RkwEtracker\Helpers\CategoryHelper;

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
 * Class CategoryViewHelper
 *
 * @author Steffen Kroggel <developer@steffenkroggel.de>
 * @copyright Rkw Kompetenzzentrum
 * @package RKW_RkwEtracker
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 */
class CategoryViewHelper extends AbstractViewHelper
{

    /**
     * Returns the filtered and combined categories
     *
     * @param string $category1
     * @param string $category2
     * @param string $category3
     * @param string $category4
     * @param string $category5
     * @return string
     */
    public function render($category1 = '', $category2 = '', $category3 = '', $category4 = '', $category5 = '')
    {

        $categories = array();
        if ($category1) {
            $categories[] = CategoryHelper::cleanUp($category1);
        }
        if ($category2) {
            $categories[] = CategoryHelper::cleanUp($category2);
        }
        if ($category3) {
            $categories[] = CategoryHelper::cleanUp($category3);
        }
        if ($category4) {
            $categories[] = CategoryHelper::cleanUp($category4);
        }
        if ($category5) {
            $categories[] = CategoryHelper::cleanUp($category5);
        }

        return implode('/', $categories);
        //===

    }

}