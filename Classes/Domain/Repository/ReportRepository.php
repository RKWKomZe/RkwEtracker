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

/**
 * Class ReportRepository
 *
 * @author Steffen Kroggel <developer@steffenkroggel.de>
 * @author Christian Dilger <c.dilger@addorange.de>
 * @copyright RKW Kompetenzzentrum
 * @package RKW_RkwEtracker
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 * @deprecated This class will be removed soon. Do not use it any more.
 */
class ReportRepository extends AbstractRepository
{

    /**
     * Find all by type and status
     *
     * @param  array $types
     * @param  array $status
     * @return \RKW\RkwEtracker\Domain\Model\Report|null
     * @throws \TYPO3\CMS\Extbase\Persistence\Exception\InvalidQueryException
     */
    public function findOneByTypeAndStatus(array $types, array $status):? Report
    {
        $query = $this->createQuery();
        $constraints = array();

        $constraints[] = $query->in('type', $types);
        $constraints[] = $query->in('status', $status);
        $constraints[] = $query->logicalNot($query->equals('status', 99));

        $query->setOrderings(
            array(
                'status'          => \TYPO3\CMS\Extbase\Persistence\QueryInterface::ORDER_DESCENDING,
                'type'            => \TYPO3\CMS\Extbase\Persistence\QueryInterface::ORDER_DESCENDING,
                'lastFetchTstamp' => \TYPO3\CMS\Extbase\Persistence\QueryInterface::ORDER_ASCENDING,
            )
        );

        $query->matching($query->logicalAnd($constraints));

        return $query->execute()->getFirst();

    }

}
