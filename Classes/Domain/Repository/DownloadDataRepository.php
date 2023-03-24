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

use RKW\RkwEtracker\Domain\Model\Report;
use TYPO3\CMS\Extbase\Persistence\ObjectStorage;
use TYPO3\CMS\Extbase\Persistence\QueryResultInterface;

/**
 * Class DownloadDataRepository
 *
 * @author Steffen Kroggel <developer@steffenkroggel.de>
 * @copyright RKW Kompetenzzentrum
 * @package RKW_RkwEtracker
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 */
class DownloadDataRepository extends AbstractRepository
{

    /**
     * @var array
     */
    protected array $fields = [1, 2, 3];


    /**
     * Find all by download filters
     *
     * @param \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\RKW\RkwEtracker\Domain\Model\ReportFilter> $reportFilters
     * @param  \RKW\RkwEtracker\Domain\Model\Report $report
     * @return \TYPO3\CMS\Extbase\Persistence\QueryResultInterface
     * @throws \TYPO3\CMS\Extbase\Persistence\Exception\InvalidQueryException
     */
    public function findAllByFilters(ObjectStorage $reportFilters, Report $report): QueryResultInterface
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
