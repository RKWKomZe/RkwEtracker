<?php

namespace RKW\RkwEtracker\ViewHelpers;
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
 * Class AndNotViewHelper
 *
 * @author Steffen Kroggel <developer@steffenkroggel.de>
 * @copyright Rkw Kompetenzzentrum
 * @package RKW_RkwEtracker
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 * @deprecated This class will be removed soon. Do not use it any more.
 */
class AndNotViewHelper extends \TYPO3\CMS\Fluid\Core\ViewHelper\AbstractViewHelper
{

    /**
     * are both values are set
     *
     * @param mixed $and
     * @param mixed $not
     * @return boolean
     */
    public function render($and, $not)
    {

        \TYPO3\CMS\Core\Utility\GeneralUtility::deprecationLog(__CLASS__ . ' is deprecated and will be removed soon. Use natively supported logical operators supported since TYPO3 8.7.');
        if ($and && (!$not)) {
            return true;
            //===

        }

        return false;
        //===
    }
}