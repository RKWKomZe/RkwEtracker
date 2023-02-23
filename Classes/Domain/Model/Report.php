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

use TYPO3\CMS\Extbase\Persistence\ObjectStorage;

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
     * @var string
     */
    protected string $name = '';

    /**
     * @var string
     */
    protected string $description = '';


    /**
     * @var string
     */
    protected string $recipient = '';


    /**
     * groups
     *
     * @var \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\RKW\RkwEtracker\Domain\Model\ReportGroup>|null
     * @TYPO3\CMS\Extbase\Annotation\ORM\Cascade("remove")
     */
    protected ?ObjectStorage $groups = null;


    /**
     * @var \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\RKW\RkwEtracker\Domain\Model\ReportGroup>|null
     * @TYPO3\CMS\Extbase\Annotation\ORM\Cascade("remove")
     */
    protected ?ObjectStorage $groupsFetch = null;


    /**
     * @var int
     */
    protected int $type = 0;


    /**
     * @var int
     */
    protected int $status = 0;


    /**
     * @var int
     */
    protected int $fetchCounter = 0;


    /**
     * @var int
     */
    protected int $lastFetchTstamp = 0;


    /**
     * @var int
     */
    protected int $lastMailTstamp = 0;


    /**
     * @var int
     */
    protected int $lastStartTstamp = 0;


    /**
     * @var int
     */
    protected int $lastEndTstamp = 0;


    /**
     * @var int
     */
    protected int $month = 0;


    /**
     * @var int
     */
    protected int $quarter = 0;


    /**
     * @var int
     */
    protected int $year = 0;


    /**
     * @var int
     */
    protected int $starttime = 0;


    /**
     * @var int
     */
    protected int $endtime = 0;


    /**
     * @var boolean
     */
    protected bool $linkToApi = true;


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
    protected function initStorageObjects(): void
    {
        $this->groups = new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();
        $this->groupsFetch = new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();

    }


    /**
     * Returns the name
     *
     * @return string $name
     */
    public function getName(): string
    {
        return $this->name;
    }


    /**
     * Sets the name
     *
     * @param string $name
     * @return void
     */
    public function setName(string $name): void
    {
        $this->name = $name;
    }


    /**
     * Returns the description
     *
     * @return string $description
     */
    public function getDescription(): string
    {
        return $this->description;
    }


    /**
     * Sets the description
     *
     * @param string $description
     * @return void
     */
    public function setDescription(string $description): void
    {
        $this->description = $description;
    }


    /**
     * Returns the recipient
     *
     * @return string $recipient
     */
    public function getRecipient(): string
    {
        return $this->recipient;
    }


    /**
     * Sets the recipient
     *
     * @param string $recipient
     * @return void
     */
    public function setRecipient(string $recipient): void
    {
        $this->recipient = $recipient;
    }


    /**
     * Adds a Group
     *
     * @param \RKW\RkwEtracker\Domain\Model\ReportGroup $group
     * @return void
     */
    public function addGroup(\RKW\RkwEtracker\Domain\Model\ReportGroup $group): void
    {
        $this->groups->attach($group);
    }


    /**
     * Removes a Group
     *
     * @param \RKW\RkwEtracker\Domain\Model\ReportGroup $groupToRemove
     * @return void
     */
    public function removeGroup(\RKW\RkwEtracker\Domain\Model\ReportGroup $groupToRemove): void
    {
        $this->groups->detach($groupToRemove);
    }


    /**
     * Returns the groups
     *
     * @return \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\RKW\RkwEtracker\Domain\Model\ReportGroup> $groups
     */
    public function getGroups(): ObjectStorage
    {
        return $this->groups;
    }


    /**
     * Sets the groups
     *
     * @param \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\RKW\RkwEtracker\Domain\Model\ReportGroup> $groups
     * @return void
     */
    public function setGroups(\TYPO3\CMS\Extbase\Persistence\ObjectStorage $groups): void
    {
        $this->groups = $groups;
    }


    /**
     * Adds a GroupFetch
     *
     * @param \RKW\RkwEtracker\Domain\Model\ReportGroup $group
     * @return void
     */
    public function addGroupFetch(\RKW\RkwEtracker\Domain\Model\ReportGroup $group): void
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
     * @return \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\RKW\RkwEtracker\Domain\Model\ReportGroup>
     */
    public function getGroupsFetch(): ObjectStorage
    {
        return $this->groupsFetch;
    }


    /**
     * Sets the groupsFetch
     *
     * @param \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\RKW\RkwEtracker\Domain\Model\ReportGroup> $groupsFetch
     * @return void
     */
    public function setGroupsFetch(\TYPO3\CMS\Extbase\Persistence\ObjectStorage $groupsFetch): ObjectStorage
    {
        $this->groupsFetch = $groupsFetch;
    }


    /**
     * Returns the type
     *
     * @return int
     */
    public function getType(): int
    {
        return $this->type;
    }


    /**
     * Sets the type
     *
     * @param int $type
     * @return void
     */
    public function setType(int $type): void
    {
        $this->type = $type;
    }


    /**
     * Returns the status
     *
     * @return int
     */
    public function getStatus(): int
    {
        return $this->status;
    }


    /**
     * Sets the status
     *
     * @param int $status
     * @return void
     */
    public function setStatus(int $status): void
    {
        $this->status = $status;
    }


    /**
     * Returns the fetchCounter
     *
     * @return int
     */
    public function getFetchCounter(): int
    {
        return $this->fetchCounter;
    }


    /**
     * Sets the fetchCounter
     *
     * @param int $fetchCounter
     * @return void
     */
    public function setFetchCounter(int $fetchCounter): void
    {
        $this->fetchCounter = $fetchCounter;
    }


    /**
     * Returns the lastFetchTstamp
     *
     * @return int
     */
    public function getLastFetchTstamp(): int
    {
        return $this->lastFetchTstamp;
    }


    /**
     * Sets the lastFetchTstamp
     *
     * @param int $lastFetchTstamp
     * @return void
     */
    public function setLastFetchTstamp(int $lastFetchTstamp): void
    {
        $this->lastFetchTstamp = $lastFetchTstamp;
    }


    /**
     * Returns the lastMailTstamp
     *
     * @return int
     */
    public function getLastMailTstamp(): int
    {
        return $this->lastMailTstamp;
    }


    /**
     * Sets the lastMailTstamp
     *
     * @param int $lastMailTstamp
     * @return void
     */
    public function setLastMailTstamp(int $lastMailTstamp): void
    {
        $this->lastMailTstamp = $lastMailTstamp;
    }


    /**
     * Returns the lastStartTstamp
     *
     * @return int
     */
    public function getLastStartTstamp(): int
    {
        return $this->lastStartTstamp;
    }


    /**
     * Sets the lastStartTstamp
     *
     * @param int $lastStartTstamp
     * @return void
     */
    public function setLastStartTstamp(int $lastStartTstamp): void
    {
        $this->lastStartTstamp = $lastStartTstamp;
    }


    /**
     * Returns the lastEndTstamp
     *
     * @return int
     */
    public function getLastEndTstamp(): int
    {
        return $this->lastEndTstamp;
    }


    /**
     * Sets the lastEndTstamp
     *
     * @param int $lastEndTstamp
     * @return void
     */
    public function setLastEndTstamp(int $lastEndTstamp): void
    {
        $this->lastEndTstamp = $lastEndTstamp;
    }


    /**
     * Returns the month
     *
     * @return int $month
     */
    public function getMonth(): int
    {
        return $this->month;
    }


    /**
     * Sets the month
     *
     * @param int $month
     * @return void
     */
    public function setMonth(int $month): void
    {
        $this->month = $month;
    }


    /**
     * Returns the quarter
     *
     * @return int $quarter
     */
    public function getQuarter(): int
    {
        return $this->quarter;
    }


    /**
     * Sets the quarter
     *
     * @param int $quarter
     * @return void
     */
    public function setQuarter(int $quarter): void
    {
        $this->quarter = $quarter;
    }


    /**
     * Returns the year
     *
     * @return int $year
     */
    public function getYear(): int
    {
        return $this->year;
    }

    /**
     * Sets the year
     *
     * @param int $year
     * @return void
     */
    public function setYear(int $year): void
    {
        $this->year = $year;
    }


    /**
     * Returns the starttime
     *
     * @return int
     */
    public function getStarttime(): int
    {
        return $this->starttime;
    }


    /**
     * Sets the starttime
     *
     * @param int $starttime
     * @return void
     */
    public function setStartime(int $starttime): void
    {
        $this->starttime = $starttime;
    }


    /**
     * Returns the endtime
     *
     * @return int
     */
    public function getEndtime(): int
    {
        return $this->endtime;
    }


    /**
     * Sets the endtime
     *
     * @param int $endtime
     * @return void
     */
    public function setEndime(int $endtime): void
    {
        $this->endtime = $endtime;
    }


    /**
     * Returns the linkToApi
     *
     * @return bool $linkToApi
     */
    public function getLinkToApi(): bool
    {
        return $this->linkToApi;
    }


    /**
     * Sets the linkToApi
     *
     * @param bool $linkToApi
     * @return void
     */
    public function setLinkToApi(bool $linkToApi): void
    {
        $this->linkToApi = $linkToApi;
    }

}
