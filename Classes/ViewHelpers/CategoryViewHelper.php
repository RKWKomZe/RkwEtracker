<?php

namespace RKW\RkwEtracker\ViewHelpers;

use TYPO3\CMS\Fluid\Core\ViewHelper\AbstractViewHelper;
use RKW\RkwEtracker\Utility\CategoryUtility;

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
 * @deprecated This class will be removed soon. Do not use it any more.
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

        \TYPO3\CMS\Core\Utility\GeneralUtility::deprecationLog(__CLASS__ . ' is deprecated and will be removed soon. Use ImplodeCategoriesViewHelper instead.');
        $categories = [
            $category1,
            $category2,
            $category3,
            $category4,
            $category5
        ];
        return CategoryUtility::implodeCategories('', $categories);

    }

}