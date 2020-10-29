<?php
namespace RKW\RkwEtracker\Tests\Functional\Utility;

use Nimut\TestingFramework\TestCase\FunctionalTestCase;

use RKW\RkwEtracker\Utility\TypolinkUtility;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Object\ObjectManager;
use TYPO3\CMS\Extbase\Persistence\Generic\PersistenceManager;

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
 * LinkUtilityTest
 *
 * @author Steffen Kroggel <developer@steffenkroggel.de>
 * @copyright Rkw Kompetenzzentrum
 * @package RKW_RkwEtracker
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 */
class LinkUtilityTest extends FunctionalTestCase
{


    /**
     * @var string[]
     */
    protected $testExtensionsToLoad = [
        'typo3conf/ext/rkw_basics',
        'typo3conf/ext/rkw_authors',
        'typo3conf/ext/rkw_projects',
        'typo3conf/ext/rkw_etracker',
    ];

    /**
     * @var string[]
     */
    protected $coreExtensionsToLoad = [
        'filelist',
        'filemetadata'
    ];

    /**
     * @var \RKW\RkwEtracker\Utility\TypolinkUtility
     */
    private $subject = null;
    /**
     * @var \TYPO3\CMS\Extbase\Persistence\Generic\PersistenceManager
     */
    private $persistenceManager = null;

    /**
     * @var \TYPO3\CMS\Extbase\Object\ObjectManager
     */
    private $objectManager = null;


    /**
     * Setup
     * @throws \Exception
     */
    protected function setUp()
    {
        parent::setUp();

        // load objects
        $this->persistenceManager = GeneralUtility::makeInstance(PersistenceManager::class);
        $this->objectManager = GeneralUtility::makeInstance(ObjectManager::class);
        $this->subject = $this->objectManager->get(TypolinkUtility::class);

        // create folder for files
        if (file_exists(PATH_site . '/fileadmin')) {

            if (! file_exists(PATH_site . '/fileadmin/media')) {
                mkdir (PATH_site . '/fileadmin/media');
            }

            foreach (range(1, 4) as $fileCount) {
                if (! file_exists(PATH_site . '/fileadmin/media/file-placeholder-' . $fileCount . '.pdf')) {
                    touch (PATH_site . '/fileadmin/media/file-placeholder-' . $fileCount . '.pdf');
                }
            }
        }

        // import sql structure
        $this->importDataSet(__DIR__ . '/Fixtures/Database/Pages.xml');
        $this->importDataSet(__DIR__ . '/Fixtures/Database/SysFile.xml');
        $this->importDataSet(__DIR__ . '/Fixtures/Database/SysFileMetadata.xml');
        $this->importDataSet(__DIR__ . '/Fixtures/Database/Projects.xml');

        // setup frontend
        $this->setUpFrontendRootPage(
            1,
            [
                'EXT:rkw_basics/Configuration/TypoScript/setup.txt',
                'EXT:rkw_authors/Configuration/TypoScript/setup.txt',
                'EXT:rkw_projects/Configuration/TypoScript/setup.txt',
                'EXT:rkw_etracker/Configuration/TypoScript/setup.txt',
                'EXT:rkw_etracker/Tests/Functional/Utility/Fixtures/Frontend/Configuration/Rootpage.typoscript',
            ]
        );

        // Set host for testing
        $_SERVER['HTTP_HOST'] = 'testing.com';

        // workaround for forced backend-context in testings
        eval('class BeUserFix { function isAdmin() { return true; } };');
        $GLOBALS['BE_USER'] = new \BeUserFix;
        if (!is_object($GLOBALS['TT'])) {
            $GLOBALS['TT'] = new \TYPO3\CMS\Core\TimeTracker\NullTimeTracker;
            $GLOBALS['TT']->start();
        }

        if (
            (!$GLOBALS['TSFE'] instanceof \TYPO3\CMS\Frontend\Controller\TypoScriptFrontendController)
            || ($GLOBALS['TSFE']->id != 1)
            || ($GLOBALS['TSFE']->type != 0)
        ) {
            $GLOBALS['TSFE'] = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance('TYPO3\\CMS\\Frontend\\Controller\\TypoScriptFrontendController', $GLOBALS['TYPO3_CONF_VARS'], 1, 0);
            $GLOBALS['TSFE']->connectToDB();
            $GLOBALS['TSFE']->initFEuser();
            $GLOBALS['TSFE']->determineId();
            $GLOBALS['TSFE']->initTemplate();
            $GLOBALS['TSFE']->getConfigArray();
        }

    }


    /**
     * @test
     */
    public function getFileObjectGivenNonExistingObjectIdReturnsNull()
    {
        static::assertNull($this->subject->getFileObject(999));
    }


    /**
     * @test
     */
    public function getFileObjectGivenExistingObjectIdReturnsFileObject()
    {
        static::assertInstanceOf('\TYPO3\CMS\Core\Resource\File', $this->subject->getFileObject(2));
    }

    /**
     * @test
     */
    public function getFileObjectGivenExistingObjectIdWithFilePrefixReturnsFileObject()
    {
        static::assertInstanceOf('\TYPO3\CMS\Core\Resource\File', $this->subject->getFileObject('file:2'));
    }

    /**
     * @test
     */
    public function getFileObjectGivenNonExistingFilePathReturnsNull()
    {
        static::assertNull($this->subject->getFileObject('fileadmin/non/existing.pdf'));
    }


    /**
     * @test
     */
    public function getFileObjectByLinkHandleGivenExistingFilePathReturnsFileObject()
    {
        static::assertInstanceOf('\TYPO3\CMS\Core\Resource\File', $this->subject->getFileObject('fileadmin/media/file-placeholder-1.pdf'));
    }

    /**
     * @test
     */
    public function getFileObjectByLinkHandleGivenExistingFilePathWithStoragePrefixReturnsFileObject()
    {
        static::assertInstanceOf('\TYPO3\CMS\Core\Resource\File', $this->subject->getFileObject('0:fileadmin/media/file-placeholder-1.pdf'));
    }

    //=============================================

    /**
     * @test
     */
    public function getDataAttributesGivenNonExistingPageReturnsArrayWithActionPage()
    {
        $assert = [
            'data-etracker-action' => 'page',
            'data-etracker-category' => 'testing.com'
        ];

        static::assertEquals($assert, $this->subject->getDataAttributes(99999));
    }


    /**
     * @test
     */
    public function getDataAttributesGivenExistingPageReturnsArrayWithActionPage()
    {
        $assert = [
            'data-etracker-action' => 'page',
            'data-etracker-category' => 'testing.com'
        ];

        static::assertEquals($assert, $this->subject->getDataAttributes(1));
    }

    /**
     * @test
     */
    public function getDataAttributesGivenMailtoLinkReturnsArrayWithActionMailto()
    {

        $assert = [
            'data-etracker-action' => 'email',
            'data-etracker-category' => 'testing.com'
        ];

        static::assertEquals($assert, $this->subject->getDataAttributes('mailto:kroggel@test.de'));
    }

    /**
     * @test
     */
    public function getDataAttributesGivenExternalLinkReturnsArrayWithActionUrl()
    {

        $assert = [
            'data-etracker-action' => 'url',
            'data-etracker-category' => 'testing.com'
        ];

        static::assertEquals($assert, $this->subject->getDataAttributes('https://www.google.de'));
    }


    /**
     * @test
     */
    public function getDataAttributesGivenNonFalFileReturnsArrayWithActionUnknown()
    {

        $assert = [
            'data-etracker-action' => 'unknown',
            'data-etracker-category' => 'testing.com'
        ];

        static::assertEquals($assert, $this->subject->getDataAttributes('fileadmin/media/file-placeholder.pdf'));
    }

    /**
     * @test
     */
    public function getDataAttributesGivenNonExistingFalFileWithoutProjectSetReturnsArrayWithActionUnknown()
    {
        $assert = [
            'data-etracker-action' => 'Unknown',
            'data-etracker-category' => 'testing.com'
        ];

        static::assertEquals($assert, $this->subject->getDataAttributes('file:99999'));
    }


    /**
     * @test
     */
    public function getDataAttributesGivenExistingFalFileWithoutProjectSetReturnsArrayWithActionLinkAndObjectName()
    {
        $assert = [
            'data-etracker-action' => 'file',
            'data-etracker-category' => 'testing.com',
            'data-etracker-object' => 'file-placeholder-1.pdf'
        ];

        static::assertEquals($assert, $this->subject->getDataAttributes('file:1'));
    }


    /**
     * @test
     */
    public function getDataAttributesGivenExistingFalFileWithProjectMissingShortAndInternalNameSetReturnsArrayWithActionLinkAndObjectNameAndProjectLongName()
    {
        $assert = [
            'data-etracker-action' => 'file',
            'data-etracker-category' => 'testing.com/TestenLong',
            'data-etracker-object' => 'file-placeholder-2.pdf'
        ];

        static::assertEquals($assert, $this->subject->getDataAttributes('file:2'));
    }

    /**
     * @test
     */
    public function getDataAttributesGivenExistingFalFileWithProjectMissingInternalNameSetReturnsArrayWithActionLinkAndObjectNameAndProjectShortName()
    {
        $assert = [
            'data-etracker-action' => 'file',
            'data-etracker-category' => 'testing.com/TestenShort',
            'data-etracker-object' => 'file-placeholder-3.pdf'
        ];

        static::assertEquals($assert, $this->subject->getDataAttributes('file:3'));
    }

    /**
     * @test
     */
    public function getDataAttributesGivenExistingFalFileWithProjectHavingInternalNameSetReturnsArrayWithActionLinkAndObjectNameAndProjectInternalName()
    {
        $assert = [
            'data-etracker-action' => 'file',
            'data-etracker-category' => 'testing.com/TestenInternal',
            'data-etracker-object' => 'file-placeholder-4.pdf'
        ];

        static::assertEquals($assert, $this->subject->getDataAttributes('file:4'));
    }

    //=============================================


    /**
     * TearDown
     */
    protected function tearDown()
    {
        parent::tearDown();

        // remove folders and files
        if (file_exists(PATH_site . '/fileadmin')) {

            foreach (range(1, 4) as $fileCount) {
                if (file_exists(PATH_site . '/fileadmin/media/file-placeholder-' . $fileCount . '.pdf')) {
                    unlink (PATH_site . '/fileadmin/media/file-placeholder-' . $fileCount . '.pdf');
                }
            }

            if (file_exists(PATH_site . '/fileadmin/media')) {
                rmdir (PATH_site . '/fileadmin/media');
            }
        }
    }






}