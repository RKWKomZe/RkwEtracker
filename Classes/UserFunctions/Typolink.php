<?php
namespace RKW\RkwEtracker\UserFunctions;

use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Object\ObjectManager;
use RKW\RkwEtracker\Utility\TypolinkUtility;
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
 * Class Typolink
 *
 * @author Steffen Kroggel <developer@steffenkroggel.de>
 * @copyright RKW Kompetenzzentrum
 * @package RKW_RkwEtracker
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 */
class Typolink
{


    /**
     * Add data-attribute to Typolink
     *
     * @param array $data
     * @param array $conf
     * @return string
     */
    public function getParsedLinkWithDataAttributes(array $data = [], $conf = []): string
    {

        /** @var \TYPO3\CMS\Extbase\Object\ObjectManager $objectManager */
        $objectManager = GeneralUtility::makeInstance(ObjectManager::class);

        /** @var \RKW\RkwEtracker\Utility\TypolinkUtility $typolinkUtility */
        $typolinkUtility = $objectManager->get(TypolinkUtility::class);

        // get data attributes for given handle
        $dataAttributes = $typolinkUtility->getDataAttributes($data['url'], $data['TYPE']);
        $dataAttributeString = '';

        // build attributes as string
        foreach ($dataAttributes as $dataAttributeName => $dataAttributeValue) {
            $dataAttributeString .= $dataAttributeName .'="' . htmlspecialchars($dataAttributeValue) . '" ';
        }

        // add attributes
        $data['TAG'] = str_replace('href=', $dataAttributeString . ' href=', $data['TAG']);

        return $data['TAG'];
    }



    /**
     * Add data-attribute to Typolink
     *
     * @param string $data
     * @param array $conf
     * @return string
     * @deprecated since 2019-07-18
     */
    public function getParsedLink($data = '', $conf = array())
    {
        return $this->getParsedLinkWithDataAttributes($data, $conf);
    }

}
