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
 * Class RedirectController
 *
 * @author Steffen Kroggel <developer@steffenkroggel.de>
 * @copyright RKW Kompetenzzentrum
 * @package RKW_RkwEtracker
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 */
class RedirectController extends \TYPO3\CMS\Extbase\Mvc\Controller\ActionController
{

    /**
     * @const eTracker Login Url
     */
    const eTrackerLoginUrl = 'https://application.etracker.com/login.php';

    /**
     * @const eTracker Login Url
     */
    const eTrackerLoginMaskUrl = 'https://www.etracker.com/login/';


	/**
	 * Redirect action
	 * Redirects to eTracker and does a single-sign-on
     *
     * @param string $redirectUrl
     * @return void
     * @throws \TYPO3\CMS\Extbase\Mvc\Exception\StopActionException;
     * @throws \TYPO3\CMS\Extbase\Mvc\Exception\UnsupportedRequestTypeException;
	 */
	public function redirectAction($redirectUrl = '/')
    {

        $remoteAddress = filter_var($_SERVER['REMOTE_ADDR'], FILTER_VALIDATE_IP);
        if ($_SERVER['HTTP_X_FORWARDED_FOR']) {
            $ips = \TYPO3\CMS\Core\Utility\GeneralUtility::trimExplode (',', $_SERVER['HTTP_X_FORWARDED_FOR']);
            if ($ips[0])
                $remoteAddress = filter_var($ips[0], FILTER_VALIDATE_IP);
        }

        // check singleSignOnHash and ip
        $allowedIps = \TYPO3\CMS\Core\Utility\GeneralUtility::trimExplode(',', $this->settings['singleSignOnAllowedIps'], true);
        if(
            ($this->settings['singleSignOnAccountId'])
            && ($this->settings['singleSignOnPassword'])
            && (
                (in_array($remoteAddress, $allowedIps))
                || (empty($allowedIps))
        )
        ) {

            $loginData = array (
                'username=' . urlencode($this->settings['singleSignOnAccountId']),
                'password=' . urlencode($this->settings['singleSignOnPassword']),
                'cmsLogin=CMS2',
                'targetUrl=' . $redirectUrl
            );

            // set context with login data
            $aContext = array (
                'http' =>
                    array (
                        'method' => 'POST',
                        'content' => implode('&', $loginData)
                    )
            );

            // complete context if proxy is used
            if ($this->settings['proxy']) {

                $aContext = array_merge_recursive(
                    $aContext,
                    array(
                        'http' => array(
                            'proxy' => $this->settings['proxy'],
                            'request_fulluri' => true,
                        ),
                    )
                );

                if ($this->settings['proxyUsername']) {
                    $auth = base64_encode($this->settings['proxyUsername'] . ':' . $this->settings['proxyPassword']);
                    $aContext['http']['header'] = 'Proxy-Authorization: Basic ' . $auth;
                }
            }

            // get login url
            $cxContext = stream_context_create($aContext);
            $fp = @fopen(self::eTrackerLoginUrl, 'rb', false, $cxContext);

            // if request was successful, the API returns a url that is valid for 60 secs
            if (
                ($loginUrl = @stream_get_contents($fp))
                && ($loginUrl == strip_tags($loginUrl))
            ){

                $this->redirectToUri($loginUrl);
                //===
            }
        }

        // add error FlashMessage
        $this->addFlashMessage(
            \TYPO3\CMS\Extbase\Utility\LocalizationUtility::translate(
                'redirectController.error.redirect', 'rkw_etracker'
            ),
            '',
            \TYPO3\CMS\Core\Messaging\AbstractMessage::ERROR
        );

        $this->view->assign('redirectUrl', self::eTrackerLoginMaskUrl);

	}

    /**
     * Returns RedirectUrl with encoded values
     *
     * @param string $rawUrl
     * @return string
     */
	protected function getRedirectUrlEncoded ($rawUrl, $sessionId)
    {

        $params = array ();

        // check for params
        $urlArray = explode ('?', urldecode($rawUrl));
        if ($urlArray[1]) {

            // get key-value-pairs
            $keyValuePairs = explode ('&', $urlArray[1]);

            // separate key from value and urlencode value
            foreach ($keyValuePairs as $keyValue) {

                $temp = explode ('=', $keyValue);
                if (
                    ($temp[0])
                    && ($temp[1])
                ) {
                    $params[] = trim($temp[0]) . '=' . urlencode(trim($temp[1]));
                }
            }
        }

        // add sessionId
        $params[] = 'sid=' . urlencode($sessionId);

        // build url
        return $urlArray[0] . '?' . implode('&', $params);
        //===

    }



}
