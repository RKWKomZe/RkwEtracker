<?php

namespace RKW\RkwEtracker\Domain\Repository;

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
 * Class DownloadDataRepository
 *
 * @author Steffen Kroggel <developer@steffenkroggel.de>
 * @copyright Rkw Kompetenzzentrum
 * @package RKW_RkwEtracker
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 */
class DownloadDataRepository extends \TYPO3\CMS\Extbase\Persistence\Repository
{


    /**
     * @var array
     */
    protected $fields = array(1, 2, 3);


    /**
     * Find all labels of category in $level
     *
     * @param int $level
     * @return \TYPO3\CMS\Extbase\Persistence\QueryResultInterface

    public function findAllDownloadsGrouped()
    {

        $query = $this->createQuery();
        $query->statement('SELECT * FROM tx_rkwetracker_domain_model_downloaddata
          GROUP BY category
          ORDER BY category'
        );

        return $query->execute();
        //===
    }*/


    /**
     * Find all by download filters
     *
     * @param \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\RKW\RkwEtracker\Domain\Model\ReportFilter> $reportFilters
     * @param  \RKW\RkwEtracker\Domain\Model\Report $report
     * @return \TYPO3\CMS\Extbase\Persistence\QueryResultInterface|null
     * @throws \TYPO3\CMS\Extbase\Persistence\Exception\InvalidQueryException
     */
    public function findAllByFilters($reportFilters, $report)
    {

        $query = $this->createQuery();
        $constraints = array();

        $constraints[] = $query->equals('report', $report);
        $constraints[] = $query->equals('reportFetchCounter', $report->getFetchCounter());
        $constraints[] = $query->in('reportFilter', $reportFilters);
        $constraints[] = $query->equals('action', 'file');

        $query->setOrderings(
            [
                'reportFilter.domain'         => \TYPO3\CMS\Extbase\Persistence\QueryInterface::ORDER_ASCENDING,
                'reportFilter.categoryLevel1' => \TYPO3\CMS\Extbase\Persistence\QueryInterface::ORDER_ASCENDING,
                'reportFilter.categoryLevel2' => \TYPO3\CMS\Extbase\Persistence\QueryInterface::ORDER_ASCENDING,
                'reportFilter.categoryLevel3' => \TYPO3\CMS\Extbase\Persistence\QueryInterface::ORDER_ASCENDING,
                'reportFilter.categoryLevel4' => \TYPO3\CMS\Extbase\Persistence\QueryInterface::ORDER_ASCENDING,
                'reportFilter.categoryLevel5' => \TYPO3\CMS\Extbase\Persistence\QueryInterface::ORDER_ASCENDING,
            ]
        );

        $query->matching($query->logicalAnd($constraints));
        return $query->execute();
    }

}