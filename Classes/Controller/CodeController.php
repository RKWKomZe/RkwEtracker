<?php
namespace RKW\RkwEtracker\Controller;

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
 * Class CodeController
 *
 * @author Steffen Kroggel <developer@steffenkroggel.de>
 * @copyright RKW Kompetenzzentrum
 * @package RKW_RkwEtracker
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 */
class CodeController extends \TYPO3\CMS\Extbase\Mvc\Controller\ActionController
{

    /**
     * action show
     * shows the eTracker code
     *
     * @return void
     */
    public function showAction()
    {
        $this->view->assignMultiple(
            [
                'blockCookies' => $this->settings['blockCookiesOnPageLoad'] ? 'true' : 'false',
                'respectDoNotTrack' => $this->settings['respectDoNotTrack'] ? 'true' : 'false',
                'domain' => getenv('HTTP_HOST')
            ]
        );
    }


    /**
     * action optOut
     * shows the eTracker privacy notice with opt-out
     *
     * @return void
     */
    public function optOutAction()
    {

        $this->view->assign(
            'domain', getenv('HTTP_HOST')
        );
    }

}
