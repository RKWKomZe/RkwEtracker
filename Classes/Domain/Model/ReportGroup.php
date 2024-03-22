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
 * Class ReportGroup
 *
 * @author Steffen Kroggel <developer@steffenkroggel.de>
 * @copyright RKW Kompetenzzentrum
 * @package RKW_RkwEtracker
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 * @deprecated This class will be removed soon. Do not use it any more.
 */
class ReportGroup extends \TYPO3\CMS\Extbase\DomainObject\AbstractEntity
{

    /**
     * name
     *
     * @var string
     */
    protected $name = '';

    /**
     * description
     *
     * @var string
     */
    protected $description = '';

    /**
     * filter
     *
     * @var \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\RKW\RkwEtracker\Domain\Model\ReportFilter>
     * @TYPO3\CMS\Extbase\Annotation\ORM\Cascade("remove")
     */
    protected $filter = null;

    /**
     * __construct
     */
    public function __construct()
    {
        //Do not remove the next line: It would break the functionality
        $this->initStorageObjects();
    }

    /**
     * Initializes all ObjectStorage properties
     * Do not modify this method!
     * It will be rewritten on each save in the extension builder
     * You may modify the constructor of this class instead
     *
     * @return void
     */
    protected function initStorageObjects()
    {
        $this->filter = new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();
    }

    /**
     * Returns the name
     *
     * @return string $name
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Sets the name
     *
     * @param string $name
     * @return void
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * Returns the description
     *
     * @return string $description
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Sets the description
     *
     * @param string $description
     * @return void
     */
    public function setDescription($description)
    {
        $this->description = $description;
    }

    /**
     * Adds a Filter
     *
     * @param \RKW\RkwEtracker\Domain\Model\ReportFilter $filter
     * @return void
     */
    public function addFilter(\RKW\RkwEtracker\Domain\Model\ReportFilter $filter)
    {
        $this->filter->attach($filter);
    }

    /**
     * Removes a Filter
     *
     * @param \RKW\RkwEtracker\Domain\Model\ReportFilter $filterToRemove The Filter to be removed
     * @return void
     */
    public function removeFilter(\RKW\RkwEtracker\Domain\Model\ReportFilter $filterToRemove)
    {
        $this->filter->detach($filterToRemove);
    }

    /**
     * Returns the filter
     *
     * @return \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\RKW\RkwEtracker\Domain\Model\ReportFilter> $filter
     */
    public function getFilter()
    {
        return $this->filter;
    }

    /**
     * Sets the filter
     *
     * @param \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\RKW\RkwEtracker\Domain\Model\Filter> $filter
     * @return void
     */
    public function setFilter(\TYPO3\CMS\Extbase\Persistence\ObjectStorage $filter)
    {
        $this->filter = $filter;
    }

}
