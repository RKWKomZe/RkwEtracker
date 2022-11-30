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
 * Class Report
 *
 * @author Steffen Kroggel <developer@steffenkroggel.de>
 * @copyright RKW Kompetenzzentrum
 * @package RKW_RkwEtracker
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 */
class Report extends \TYPO3\CMS\Extbase\DomainObject\AbstractEntity
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
     * recipient
     *
     * @var string
     */
    protected $recipient = '';


    /**
     * groups
     *
     * @var \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\RKW\RkwEtracker\Domain\Model\ReportGroup>
     * @TYPO3\CMS\Extbase\Annotation\ORM\Cascade("remove")
     */
    protected $groups = null;

    /**
     * groupsFetch
     *
     * @var \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\RKW\RkwEtracker\Domain\Model\ReportGroup>
     * @TYPO3\CMS\Extbase\Annotation\ORM\Cascade("remove")
     */
    protected $groupsFetch = null;

    /**
     * type
     *
     * @var int
     */
    protected $type = 0;

    /**
     * type
     *
     * @var int
     */
    protected $status = 0;


    /**
     * fetchCounter
     *
     * @var int
     */
    protected $fetchCounter = 0;

    /**
     * lastFetchTstamp
     *
     * @var int
     */
    protected $lastFetchTstamp = 0;


    /**
     * lastMailTstamp
     *
     * @var int
     */
    protected $lastMailTstamp = 0;

    /**
     * lastStartTstamp
     *
     * @var int
     */
    protected $lastStartTstamp = 0;

    /**
     * lastEndTstamp
     *
     * @var int
     */
    protected $lastEndTstamp = 0;

    /**
     * month
     *
     * @var int
     */
    protected $month = 0;

    /**
     * quarter
     *
     * @var int
     */
    protected $quarter = 0;

    /**
     * year
     *
     * @var int
     */
    protected $year = 0;

    /**
     * starttime
     *
     * @var int
     */
    protected $starttime = 0;


    /**
     * endtime
     *
     * @var int
     */
    protected $endtime = 0;

    /**
     * linkToApi
     *
     * @var boolean
     */
    protected $linkToApi = true;


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
        $this->groups = new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();
        $this->groupsFetch = new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();

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
     * Returns the recipient
     *
     * @return string $recipient
     */
    public function getRecipient()
    {
        return $this->recipient;
    }

    /**
     * Sets the recipient
     *
     * @param string $recipient
     * @return void
     */
    public function setRecipient($recipient)
    {
        $this->recipient = $recipient;
    }


    /**
     * Adds a Group
     *
     * @param \RKW\RkwEtracker\Domain\Model\ReportGroup $group
     * @return void
     */
    public function addGroup(\RKW\RkwEtracker\Domain\Model\ReportGroup $group)
    {
        $this->groups->attach($group);
    }

    /**
     * Removes a Group
     *
     * @param \RKW\RkwEtracker\Domain\Model\ReportGroup $groupToRemove The Group to be removed
     * @return void
     */
    public function removeGroup(\RKW\RkwEtracker\Domain\Model\ReportGroup $groupToRemove)
    {
        $this->groups->detach($groupToRemove);
    }

    /**
     * Returns the groups
     *
     * @return \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\RKW\RkwEtracker\Domain\Model\ReportGroup> $groups
     */
    public function getGroups()
    {
        return $this->groups;
    }

    /**
     * Sets the groups
     *
     * @param \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\RKW\RkwEtracker\Domain\Model\ReportGroup> $groups
     * @return void
     */
    public function setGroups(\TYPO3\CMS\Extbase\Persistence\ObjectStorage $groups)
    {
        $this->groups = $groups;
    }


    /**
     * Adds a GroupFetch
     *
     * @param \RKW\RkwEtracker\Domain\Model\ReportGroup $group
     * @return void
     */
    public function addGroupFetch(\RKW\RkwEtracker\Domain\Model\ReportGroup $group)
    {
        $this->groupsFetch->attach($group);
    }

    /**
     * Removes a GroupFetch
     *
     * @param \RKW\RkwEtracker\Domain\Model\ReportGroup $groupToRemove The Group to be removed
     * @return void
     */
    public function removeGroupFetch(\RKW\RkwEtracker\Domain\Model\ReportGroup $groupToRemove)
    {
        $this->groupsFetch->detach($groupToRemove);
    }

    /**
     * Returns the groupsFetch
     *
     * @return \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\RKW\RkwEtracker\Domain\Model\ReportGroup> $groupsFetch
     */
    public function getGroupsFetch()
    {
        return $this->groupsFetch;
    }

    /**
     * Sets the groupsFetch
     *
     * @param \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\RKW\RkwEtracker\Domain\Model\ReportGroup> $groupsFetch
     * @return void
     */
    public function setGroupsFetch(\TYPO3\CMS\Extbase\Persistence\ObjectStorage $groupsFetch)
    {
        $this->groupsFetch = $groupsFetch;
    }


    /**
     * Returns the type
     *
     * @return int
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * Sets the type
     *
     * @param int $type
     * @return void
     */
    public function setType($type)
    {
        $this->type = $type;
    }

    /**
     * Returns the status
     *
     * @return int
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * Sets the status
     *
     * @param int $status
     * @return void
     */
    public function setStatus($status)
    {
        $this->status = $status;
    }


    /**
     * Returns the fetchCounter
     *
     * @return int
     */
    public function getFetchCounter()
    {
        return $this->fetchCounter;
    }


    /**
     * Sets the fetchCounter
     *
     * @param int $fetchCounter
     * @return void
     */
    public function setFetchCounter($fetchCounter)
    {
        $this->fetchCounter = $fetchCounter;
    }


    /**
     * Returns the lastFetchTstamp
     *
     * @return int
     */
    public function getLastFetchTstamp()
    {
        return $this->lastFetchTstamp;
    }


    /**
     * Sets the lastFetchTstamp
     *
     * @param int $lastFetchTstamp
     * @return void
     */
    public function setLastFetchTstamp($lastFetchTstamp)
    {
        $this->lastFetchTstamp = $lastFetchTstamp;
    }


    /**
     * Returns the lastMailTstamp
     *
     * @return int
     */
    public function getLastMailTstamp()
    {
        return $this->lastMailTstamp;
    }


    /**
     * Sets the lastMailTstamp
     *
     * @param int $lastMailTstamp
     * @return void
     */
    public function setLastMailTstamp($lastMailTstamp)
    {
        $this->lastMailTstamp = $lastMailTstamp;
    }


    /**
     * Returns the lastStartTstamp
     *
     * @return int
     */
    public function getLastStartTstamp()
    {
        return $this->lastStartTstamp;
    }


    /**
     * Sets the lastStartTstamp
     *
     * @param int $lastStartTstamp
     * @return void
     */
    public function setLastStartTstamp($lastStartTstamp)
    {
        $this->lastStartTstamp = $lastStartTstamp;
    }


    /**
     * Returns the lastEndTstamp
     *
     * @return int
     */
    public function getLastEndTstamp()
    {
        return $this->lastEndTstamp;
    }


    /**
     * Sets the lastEndTstamp
     *
     * @param int $lastEndTstamp
     * @return void
     */
    public function setLastEndTstamp($lastEndTstamp)
    {
        $this->lastEndTstamp = $lastEndTstamp;
    }


    /**
     * Returns the month
     *
     * @return int $month
     */
    public function getMonth()
    {
        return $this->month;
    }

    /**
     * Sets the month
     *
     * @param int $month
     * @return void
     */
    public function setMonth($month)
    {
        $this->month = $month;
    }

    /**
     * Returns the quarter
     *
     * @return int $quarter
     */
    public function getQuarter()
    {
        return $this->quarter;
    }

    /**
     * Sets the quarter
     *
     * @param int $quarter
     * @return void
     */
    public function setQuarter($quarter)
    {
        $this->quarter = $quarter;
    }

    /**
     * Returns the year
     *
     * @return int $year
     */
    public function getYear()
    {
        return $this->year;
    }

    /**
     * Sets the year
     *
     * @param int $year
     * @return void
     */
    public function setYear($year)
    {
        $this->year = $year;
    }

    /**
     * Returns the starttime
     *
     * @return int $starttime
     */
    public function getStarttime()
    {
        return $this->starttime;
    }

    /**
     * Sets the starttime
     *
     * @param int $starttime
     * @return void
     */
    public function setStartime($starttime)
    {
        $this->starttime = $starttime;
    }

    /**
     * Returns the endtime
     *
     * @return int $endtime
     */
    public function getEndtime()
    {
        return $this->endtime;
    }

    /**
     * Sets the endtime
     *
     * @param int $endtime
     * @return void
     */
    public function setEndime($endtime)
    {
        $this->endtime = $endtime;
    }


    /**
     * Returns the linkToApi
     *
     * @return boolean $linkToApi
     */
    public function getLinkToApi()
    {
        return $this->linkToApi;
    }

    /**
     * Sets the linkToApi
     *
     * @param boolean $linkToApi
     * @return void
     */
    public function setLinkToApi($linkToApi)
    {
        $this->linkToApi = $linkToApi;
    }

}
