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
 * Class ReportFilter
 *
 * @author Steffen Kroggel <developer@steffenkroggel.de>
 * @copyright RKW Kompetenzzentrum
 * @package RKW_RkwEtracker
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 * @deprecated This class will be removed soon. Do not use it any more.
 */
class ReportFilter extends \TYPO3\CMS\Extbase\DomainObject\AbstractEntity
{

    /**
     * @var string
     */
    protected string $domain = '';


    /**
     * @var string
     */
    protected string $domainFree = '';


    /**
     * @var string
     */
    protected string $categoryLevel1 = '';


    /**
     * @var string
     */
    protected string $categoryLevel2 = '';


    /**
     * @var string
     */
    protected string $categoryLevel3 = '';


    /**
     * @var string
     */
    protected string $categoryLevel4 = '';


    /**
     * @var string
     */
    protected string $categoryLevel5 = '';


    /**
     * @var string
     */
    protected string $categoryFreeLevel1 = '';


    /**
     * @var string
     */
    protected string $categoryFreeLevel2 = '';


    /**
     * @var string
     */
    protected string $categoryFreeLevel3 = '';


    /**
     * @var string
     */
    protected string $categoryFreeLevel4 = '';


    /**
     * @var string
     */
    protected string $categoryFreeLevel5 = '';


    /**
     * @var string
     */
    protected string $downloadFilter1 = '';


    /**
     * @var string
     * @deprecated
     */
    protected string $downloadFilter2 = '';


    /**
     * @var string
     * @deprecated
     */
    protected string $downloadFilter3 = '';


    /**
     * @var string
     */
    protected string $downloadFreeFilter1 = '';


    /**
     * Returns the domain
     *
     * @return string $domain
     */
    public function getDomain(): string
    {
        return $this->domain;
    }


    /**
     * Sets the domain
     *
     * @param string $domain
     * @return void
     */
    public function setDomain(string $domain): void
    {
        $this->domain = $domain;
    }


    /**
     * Returns the domainFree
     *
     * @return string
     */
    public function getDomainFree(): string
    {
        return $this->domainFree;
    }


    /**
     * Sets the domainFree
     *
     * @param string $domainFree
     * @return void
     */
    public function setDomainFree(string $domainFree): void
    {
        $this->domainFree = $domainFree;
    }


    /**
     * Returns the categoryLevel1
     *
     * @return string
     */
    public function getCategoryLevel1(): string
    {
        return $this->categoryLevel1;
    }


    /**
     * Sets the categoryLevel1
     *
     * @param string $categoryLevel1
     * @return void
     */
    public function setCategoryLevel1(string $categoryLevel1): void
    {
        $this->categoryLevel1 = $categoryLevel1;
    }


    /**
     * Returns the categoryLevel2
     *
     * @return string
     */
    public function getCategoryLevel2(): string
    {
        return $this->categoryLevel2;
    }


    /**
     * Sets the categoryLevel2
     *
     * @param string $categoryLevel2
     * @return void
     */
    public function setCategoryLevel2(string $categoryLevel2): void
    {
        $this->categoryLevel2 = $categoryLevel2;
    }


    /**
     * Returns the categoryLevel3
     *
     * @return string
     */
    public function getCategoryLevel3(): string
    {
        return $this->categoryLevel3;
    }


    /**
     * Sets the categoryLevel3
     *
     * @param string $categoryLevel3
     * @return void
     */
    public function setCategoryLevel3(string $categoryLevel3): void
    {
        $this->categoryLevel3 = $categoryLevel3;
    }


    /**
     * Returns the categoryLevel4
     *
     * @return string
     */
    public function getCategoryLevel4(): string
    {
        return $this->categoryLevel4;
    }


    /**
     * Sets the categoryLevel4
     *
     * @param string $categoryLevel4
     * @return void
     */
    public function setCategoryLevel4(string $categoryLevel4): void
    {
        $this->categoryLevel4 = $categoryLevel4;
    }


    /**
     * Returns the categoryLevel5
     *
     * @return string
     */
    public function getCategoryLevel5(): string
    {
        return $this->categoryLevel5;
    }


    /**
     * Sets the categoryLevel5
     *
     * @param string $categoryLevel5
     * @return void
     */
    public function setCategoryLevel5(string $categoryLevel5)
    {
        $this->categoryLevel5 = $categoryLevel5;
    }


    /**
     * Returns the categoryFreeLevel1
     *
     * @return string
     */
    public function getCategoryFreeLevel1(): string
    {
        return $this->categoryFreeLevel1;
    }


    /**
     * Returns the categoryLevel1Free
     * Alias of getCategoryFreeLevel1()
     *
     * @return string $categoryFreeLevel1
     * @deprecated
     */
    public function getCategoryLevel1Free(): string
    {
        return $this->categoryFreeLevel1;
    }


    /**
     * Sets the categoryFreeLevel1
     *
     * @param string $categoryFreeLevel1
     * @return void
     */
    public function setCategoryFreeLevel1(string $categoryFreeLevel1): void
    {
        $this->categoryFreeLevel1 = $categoryFreeLevel1;
    }


    /**
     * Returns the categoryFreeLevel2
     *
     * @return string
     */
    public function getCategoryFreeLevel2(): string
    {
        return $this->categoryFreeLevel2;
    }


    /**
     * Returns the categoryLevel2Free
     * Alias of getCategoryFreeLevel2()
     *
     * @return string
     * @deprecated
     */
    public function getCategoryLevel2Free(): string
    {
        return $this->categoryFreeLevel2;
    }


    /**
     * Sets the categoryFreeLevel2
     *
     * @param string $categoryFreeLevel2
     * @return void
     */
    public function setCategoryFreeLevel2(string $categoryFreeLevel2): void
    {
        $this->categoryFreeLevel2 = $categoryFreeLevel2;
    }


    /**
     * Returns the categoryFreeLevel3
     *
     * @return string
     */
    public function getCategoryFreeLevel3(): string
    {
        return $this->categoryFreeLevel3;
    }


    /**
     * Returns the categoryLevel3Free
     * Alias of getCategoryFreeLevel3()
     *
     * @return string
     * @deprecated
     */
    public function getCategoryLevel3Free(): string
    {
        return $this->categoryFreeLevel3;
    }


    /**
     * Sets the categoryFreeLevel3
     *
     * @param string $categoryFreeLevel3
     * @return void
     */
    public function setCategoryFreeLevel3(string $categoryFreeLevel3): void
    {
        $this->categoryFreeLevel3 = $categoryFreeLevel3;
    }


    /**
     * Returns the categoryFreeLevel4
     *
     * @return string
     */
    public function getCategoryFreeLevel4(): string
    {
        return $this->categoryFreeLevel4;
    }


    /**
     * Returns the categoryLevel4Free
     * Alias of getCategoryFreeLevel4()
     *
     * @return string
     * @deprecated
     */
    public function getCategoryLevel4Free(): string
    {
        return $this->categoryFreeLevel4;
    }


    /**
     * Sets the categoryFreeLevel4
     *
     * @param string $categoryFreeLevel4
     * @return void
     */
    public function setCategoryFreeLevel4(string $categoryFreeLevel4): void
    {
        $this->categoryFreeLevel4 = $categoryFreeLevel4;
    }


    /**
     * Returns the categoryFreeLevel5
     *
     * @return string $categoryFreeLevel5
     */
    public function getCategoryFreeLevel5(): string
    {
        return $this->categoryFreeLevel5;
    }

    /**
     * Returns the categoryLevel5Free
     * Alias of getCategoryFreeLevel5()
     *
     * @return string $categoryFreeLevel5
     * @deprecated
     */
    public function getCategoryLevel5Free(): string
    {
        return $this->categoryFreeLevel5;
    }


    /**
     * Sets the categoryFreeLevel5
     *
     * @param string $categoryFreeLevel5
     * @return void
     */
    public function setCategoryFreeLevel5(string $categoryFreeLevel5): void
    {
        $this->categoryFreeLevel5 = $categoryFreeLevel5;
    }


    /**
     * Returns the downloadFilter1
     *
     * @return string
     */
    public function getDownloadFilter1(): string
    {
        return $this->downloadFilter1;
    }


    /**
     * Sets the downloadFilter1
     *
     * @param string $downloadFilter1
     * @return void
     */
    public function setDownloadFilter1(string $downloadFilter1): void
    {
        $this->downloadFilter1 = $downloadFilter1;
    }


    /**
     * Returns the downloadFilter2
     *
     * @return string
     * @deprecated
     */
    public function getDownloadFilter2(): string
    {
        return $this->downloadFilter2;
    }


    /**
     * Sets the downloadFilter2
     *
     * @param string $downloadFilter2
     * @return void
     * @deprecated
     */
    public function setDownloadFilter2(string $downloadFilter2): void
    {
        $this->downloadFilter2 = $downloadFilter2;
    }


    /**
     * Returns the downloadFilter3
     *
     * @return string
     * @deprecated
     */
    public function getDownloadFilter3(): string
    {
        return $this->downloadFilter3;
    }


    /**
     * Sets the downloadFilter3
     *
     * @param string $downloadFilter3
     * @return void
     * @deprecated
     */
    public function setDownloadFilter3(string $downloadFilter3)
    {
        $this->downloadFilter3 = $downloadFilter3;
    }

    /**
     * Returns the downloadFreeFilter1
     *
     * @return string $downloadFreeFilter1
     */
    public function getDownloadFreeFilter1()
    {
        return $this->downloadFreeFilter1;
    }

    /**
     * Sets the downloadFreeFilter1
     *
     * @param string $downloadFreeFilter1
     * @return void
     */
    public function setDownloadFreeFilter1($downloadFreeFilter1)
    {
        $this->downloadFreeFilter1 = $downloadFreeFilter1;
    }
}
