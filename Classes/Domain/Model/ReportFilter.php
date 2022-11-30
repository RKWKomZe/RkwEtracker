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
 */
class ReportFilter extends \TYPO3\CMS\Extbase\DomainObject\AbstractEntity
{

    /**
     * domain
     *
     * @var string
     */
    protected $domain = '';

    /**
     * domainFree
     *
     * @var string
     */
    protected $domainFree = '';


    /**
     * categoryLevel1
     *
     * @var string
     */
    protected $categoryLevel1 = '';

    /**
     * categoryLevel2
     *
     * @var string
     */
    protected $categoryLevel2 = '';

    /**
     * categoryLevel3
     *
     * @var string
     */
    protected $categoryLevel3 = '';

    /**
     * categoryLevel4
     *
     * @var string
     */
    protected $categoryLevel4 = '';

    /**
     * categoryLevel5
     *
     * @var string
     */
    protected $categoryLevel5 = '';

    /**
     * categoryFreeLevel1
     *
     * @var string
     */
    protected $categoryFreeLevel1 = '';

    /**
     * categoryFreeLevel2
     *
     * @var string
     */
    protected $categoryFreeLevel2 = '';

    /**
     * categoryFreeLevel3
     *
     * @var string
     */
    protected $categoryFreeLevel3 = '';

    /**
     * categoryFreeLevel4
     *
     * @var string
     */
    protected $categoryFreeLevel4 = '';

    /**
     * categoryFreeLevel5
     *
     * @var string
     */
    protected $categoryFreeLevel5 = '';

    /**
     * downloadFilter1
     *
     * @var string
     */
    protected $downloadFilter1 = '';

    /**
     * downloadFilter2
     *
     * @var string
     * @deprecated
     */
    protected $downloadFilter2 = '';

    /**
     * downloadFilter3
     *
     * @var string
     * @deprecated
     */
    protected $downloadFilter3 = '';


    /**
     * downloadFilter1
     *
     * @var string
     */
    protected $downloadFreeFilter1 = '';


    /**
     * Returns the domain
     *
     * @return string $domain
     */
    public function getDomain()
    {
        return $this->domain;
    }

    /**
     * Sets the domain
     *
     * @param string $domain
     * @return void
     */
    public function setDomain($domain)
    {
        $this->domain = $domain;
    }

    /**
     * Returns the domainFree
     *
     * @return string $domainFree
     */
    public function getDomainFree()
    {
        return $this->domainFree;
    }

    /**
     * Sets the domainFree
     *
     * @param string $domainFree
     * @return void
     */
    public function setDomainFree($domainFree)
    {
        $this->domainFree = $domainFree;
    }


    /**
     * Returns the categoryLevel1
     *
     * @return string $categoryLevel1
     */
    public function getCategoryLevel1()
    {
        return $this->categoryLevel1;
    }

    /**
     * Sets the categoryLevel1
     *
     * @param string $categoryLevel1
     * @return void
     */
    public function setCategoryLevel1($categoryLevel1)
    {
        $this->categoryLevel1 = $categoryLevel1;
    }

    /**
     * Returns the categoryLevel2
     *
     * @return string $categoryLevel2
     */
    public function getCategoryLevel2()
    {
        return $this->categoryLevel2;
    }

    /**
     * Sets the categoryLevel2
     *
     * @param string $categoryLevel2
     * @return void
     */
    public function setCategoryLevel2($categoryLevel2)
    {
        $this->categoryLevel2 = $categoryLevel2;
    }

    /**
     * Returns the categoryLevel3
     *
     * @return string $categoryLevel3
     */
    public function getCategoryLevel3()
    {
        return $this->categoryLevel3;
    }

    /**
     * Sets the categoryLevel3
     *
     * @param string $categoryLevel3
     * @return void
     */
    public function setCategoryLevel3($categoryLevel3)
    {
        $this->categoryLevel3 = $categoryLevel3;
    }

    /**
     * Returns the categoryLevel4
     *
     * @return string $categoryLevel4
     */
    public function getCategoryLevel4()
    {
        return $this->categoryLevel4;
    }

    /**
     * Sets the categoryLevel4
     *
     * @param string $categoryLevel4
     * @return void
     */
    public function setCategoryLevel4($categoryLevel4)
    {
        $this->categoryLevel4 = $categoryLevel4;
    }

    /**
     * Returns the categoryLevel5
     *
     * @return string $categoryLevel5
     */
    public function getCategoryLevel5()
    {
        return $this->categoryLevel5;
    }

    /**
     * Sets the categoryLevel5
     *
     * @param string $categoryLevel5
     * @return void
     */
    public function setCategoryLevel5($categoryLevel5)
    {
        $this->categoryLevel5 = $categoryLevel5;
    }


    /**
     * Returns the categoryFreeLevel1
     *
     * @return string $categoryFreeLevel1
     */
    public function getCategoryFreeLevel1()
    {
        return $this->categoryFreeLevel1;
    }

    /**
     * Returns the categoryLevel1Free
     * Alias of getCategoryFreeLevel1()
     *
     * @return string $categoryFreeLevel1
     */
    public function getCategoryLevel1Free()
    {
        return $this->categoryFreeLevel1;
    }


    /**
     * Sets the categoryFreeLevel1
     *
     * @param string $categoryFreeLevel1
     * @return void
     */
    public function setCategoryFreeLevel1($categoryFreeLevel1)
    {
        $this->categoryFreeLevel1 = $categoryFreeLevel1;
    }

    /**
     * Returns the categoryFreeLevel2
     *
     * @return string $categoryFreeLevel2
     */
    public function getCategoryFreeLevel2()
    {
        return $this->categoryFreeLevel2;
    }

    /**
     * Returns the categoryLevel2Free
     * Alias of getCategoryFreeLevel2()
     *
     * @return string $categoryFreeLevel2
     */
    public function getCategoryLevel2Free()
    {
        return $this->categoryFreeLevel2;
    }


    /**
     * Sets the categoryFreeLevel2
     *
     * @param string $categoryFreeLevel2
     * @return void
     */
    public function setCategoryFreeLevel2($categoryFreeLevel2)
    {
        $this->categoryFreeLevel2 = $categoryFreeLevel2;
    }

    /**
     * Returns the categoryFreeLevel3
     *
     * @return string $categoryFreeLevel3
     */
    public function getCategoryFreeLevel3()
    {
        return $this->categoryFreeLevel3;
    }

    /**
     * Returns the categoryLevel3Free
     * Alias of getCategoryFreeLevel3()
     *
     * @return string $categoryFreeLevel3
     */
    public function getCategoryLevel3Free()
    {
        return $this->categoryFreeLevel3;
    }


    /**
     * Sets the categoryFreeLevel3
     *
     * @param string $categoryFreeLevel3
     * @return void
     */
    public function setCategoryFreeLevel3($categoryFreeLevel3)
    {
        $this->categoryFreeLevel3 = $categoryFreeLevel3;
    }

    /**
     * Returns the categoryFreeLevel4
     *
     * @return string $categoryFreeLevel4
     */
    public function getCategoryFreeLevel4()
    {
        return $this->categoryFreeLevel4;
    }

    /**
     * Returns the categoryLevel4Free
     * Alias of getCategoryFreeLevel4()
     *
     * @return string $categoryFreeLevel4
     */
    public function getCategoryLevel4Free()
    {
        return $this->categoryFreeLevel4;
    }


    /**
     * Sets the categoryFreeLevel4
     *
     * @param string $categoryFreeLevel4
     * @return void
     */
    public function setCategoryFreeLevel4($categoryFreeLevel4)
    {
        $this->categoryFreeLevel4 = $categoryFreeLevel4;
    }

    /**
     * Returns the categoryFreeLevel5
     *
     * @return string $categoryFreeLevel5
     */
    public function getCategoryFreeLevel5()
    {
        return $this->categoryFreeLevel5;
    }

    /**
     * Returns the categoryLevel5Free
     * Alias of getCategoryFreeLevel5()
     *
     * @return string $categoryFreeLevel5
     */
    public function getCategoryLevel5Free()
    {
        return $this->categoryFreeLevel5;
    }


    /**
     * Sets the categoryFreeLevel5
     *
     * @param string $categoryFreeLevel5
     * @return void
     */
    public function setCategoryFreeLevel5($categoryFreeLevel5)
    {
        $this->categoryFreeLevel5 = $categoryFreeLevel5;
    }


    /**
     * Returns the downloadFilter1
     *
     * @return string $downloadFilter1
     */
    public function getDownloadFilter1()
    {
        return $this->downloadFilter1;
    }

    /**
     * Sets the downloadFilter1
     *
     * @param string $downloadFilter1
     * @return void
     */
    public function setDownloadFilter1($downloadFilter1)
    {
        $this->downloadFilter1 = $downloadFilter1;
    }

    /**
     * Returns the downloadFilter2
     *
     * @return string $downloadFilter2
     * @deprecated
     */
    public function getDownloadFilter2()
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
    public function setDownloadFilter2($downloadFilter2)
    {
        $this->downloadFilter2 = $downloadFilter2;
    }

    /**
     * Returns the downloadFilter3
     *
     * @return string $downloadFilter3
     * @deprecated
     */
    public function getDownloadFilter3()
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
    public function setDownloadFilter3($downloadFilter3)
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
