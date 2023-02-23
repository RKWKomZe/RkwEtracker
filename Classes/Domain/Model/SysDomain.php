<?php

namespace RKW\RkwEtracker\Domain\Model;

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
 * Class SysDomain
 *
 * @author Steffen Kroggel <developer@steffenkroggel.de>
 * @copyright RKW Kompetenzzentrum
 * @package RKW_RkwEtracker
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 */
class SysDomain extends \TYPO3\CMS\Extbase\DomainObject\AbstractEntity
{

    /**
     * name
     *
     * @var string
     */
    protected $domainName = '';


    /**
     * Returns the name
     *
     * @return string $name
     */
    public function getDomainName()
    {
        return $this->domainName;
    }

    /**
     * Sets the domainName
     *
     * @param string $domainName
     * @return void
     */
    public function setDomainName($domainName)
    {
        $this->domainName = $domainName;
    }


}
