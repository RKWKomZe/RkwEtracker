<?php
namespace RKW\RkwEtracker\Tests\Integration\Utility;

use Nimut\TestingFramework\TestCase\FunctionalTestCase;

use RKW\RkwBasics\Utility\FrontendSimulatorUtility;
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
 * @copyright RKW Kompetenzzentrum
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
    protected function setUp(): void
    {
        parent::setUp();

        // load objects
        $this->persistenceManager = GeneralUtility::makeInstance(PersistenceManager::class);
        $this->objectManager = GeneralUtility::makeInstance(ObjectManager::class);
        $this->subject = $this->objectManager->get(TypolinkUtility::class);

        // create folder for files
        if (file_exists(\TYPO3\CMS\Core\Core\Environment::getPublicPath() . '/fileadmin')) {

            if (! file_exists(\TYPO3\CMS\Core\Core\Environment::getPublicPath() . '/fileadmin/media')) {
                mkdir (\TYPO3\CMS\Core\Core\Environment::getPublicPath() . '/fileadmin/media');
            }

            foreach (range(1, 4) as $fileCount) {
                if (! file_exists(\TYPO3\CMS\Core\Core\Environment::getPublicPath() . '/fileadmin/media/file-placeholder-' . $fileCount . '.pdf')) {
                    touch (\TYPO3\CMS\Core\Core\Environment::getPublicPath() . '/fileadmin/media/file-placeholder-' . $fileCount . '.pdf');
                }
            }
        }

        // import sql structure
        $this->importDataSet(__DIR__ . '/Fixtures/Database/Pages.xml');
        $this->importDataSet(__DIR__ . '/Fixtures/Database/SysDomain.xml');
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
                'EXT:rkw_etracker/Tests/Integration/Utility/Fixtures/Frontend/Configuration/Rootpage.typoscript',
            ]
        );

        // init frontend (needed in test-context)
        FrontendSimulatorUtility::simulateFrontendEnvironment(1);
    }


    //=============================================

    /**
     * @test
     */
    public function getFileObjectReturnsNullIfIdNotExists()
    {

        /**
         * Scenario:
         *
         * Given we have a non existent object-id
         * When getFileObject is called with that id
         * Then null is returned
         */
        self::assertNull($this->subject->getFileObject(999));
    }


    /**
     * @test
     */
    public function getFileObjectReturnsFileObject()
    {
        /**
         * Scenario:
         *
         * Given there is an existing file-object-id
         * When getFileObject is called with its id
         * Then the file-object is returned
         */
        self::assertInstanceOf('\TYPO3\CMS\Core\Resource\File', $this->subject->getFileObject(2));
    }

    /**
     * @test
     */
    public function getFileObjectReturnsFileObjectIfPrependedWithFileKeyword()
    {
        /**
         * Scenario:
         *
         * Given there is an existing file-object-id
         * Given the id is prepended with "file:"
         * When getFileObject is called with that id
         * Then the file-object is returned
         */
        self::assertInstanceOf('\TYPO3\CMS\Core\Resource\File', $this->subject->getFileObject('file:2'));
    }

    /**
     * @test
     */
    public function getFileObjectReturnsNullIfPathInvalid()
    {
        /**
         * Scenario:
         *
         * Given there is a non existing path to a file
         * When getFileObject is called with that path
         * Then null is returned
         */
        self::assertNull($this->subject->getFileObject('fileadmin/non/existing.pdf'));
    }


    /**
     * @test
     */
    public function getFileObjectReturnsFileObjectIfPathValid()
    {
        /**
         * Scenario:
         *
         * Given there is an existing path to a file
         * When getFileObject is called with that path
         * Then the file object is returned
         */
        self::assertInstanceOf('\TYPO3\CMS\Core\Resource\File', $this->subject->getFileObject('fileadmin/media/file-placeholder-1.pdf'));
    }

    /**
     * @test
     */
    public function getFileObjectReturnsFileObjectIfPrependedWithStorageId()
    {
        /**
         * Scenario:
         *
         * Given there is an existing path to a file
         * Given that path is prepended with the storage id
         * When getFileObject is called with that path
         * Then the file object is returned
         */
        self::assertInstanceOf('\TYPO3\CMS\Core\Resource\File', $this->subject->getFileObject('0:fileadmin/media/file-placeholder-1.pdf'));
    }

    //=============================================

    /**
     * @test
     */
    public function getLinkTypeReturnsPageForNonExistentPage()
    {

        /**
         * Scenario:
         *
         * Given there is a non existing page
         * When getLinkType is called with the id of the page
         * Then "page" is is returned
         */
        self::assertEquals('page', $this->subject->getLinkType(99999));
    }


    /**
     * @test
     */
    public function getLinkTypeReturnsPageForExistentPage()
    {

        /**
         * Scenario:
         *
         * Given there is an existing page
         * When getLinkType is called with the id of the page
         * Then "page" is is returned
         */
        self::assertEquals('page', $this->subject->getLinkType(1));
    }


    /**
     * @test
     */
    public function getLinkTypeReturnsPageForExistentPageIfPrefixUsed()
    {

        /**
         * Scenario:
         *
         * Given there is an existing page
         * Given the t3://-prefix is prepended
         * When getLinkType is called with the id of the page
         * Then "page" is is returned
         */
        self::assertEquals('page', $this->subject->getLinkType('t3://page?uid=1'));
    }



    /**
     * @test
     */
    public function getLinkTypeReturnsPageIfAdditionalParamsGiven()
    {

        /**
         * Scenario:
         *
         * Given there is an existing page
         * Given the t3://-prefix is prepended
         * Given a title and a link-target are set
         * When getLinkType is called with this additional params
         * Then "page" is returned
         */
        self::assertEquals('page', $this->subject->getLinkType('t3://page?uid=1 - - "zur Website"'));
    }

    /**
     * @test
     */
    public function getLinkTypeReturnsMail()
    {
        /**
         * Scenario:
         *
         * Given there is an email-address
         * When getLinkType is called with that email-address
         * Then "email" is returned
         */
        self::assertEquals('email', $this->subject->getLinkType('mailto:kroggel@test.de'));
    }

    /**
     * @test
     */
    public function getLinkTypeReturnsMailIfPrefixUsed()
    {
        /**
         * Scenario:
         *
         * Given there is an email-address
         * Given the t3://-prefix is prepended
         * When getLinkType is called with that email-address
         * Then "email" is returned
         */
        self::assertEquals('email', $this->subject->getLinkType('t3://email?email=mailto:kroggel@test.de'));
    }

    /**
     * @test
     */
    public function getLinkTypeReturnsMailIfAdditionalParamsGiven()
    {
        /**
         * Scenario:
         *
         * Given there is an email-address
         * Given the t3://-prefix is prepended
         * Given a title and a link-target are set
         * When getLinkType is called with that email-address
         * Then "email" is returned
         */
        self::assertEquals('email', $this->subject->getLinkType('t3://email?email=mailto:kroggel@test.de - - "zur Website"'));
    }


    /**
     * @test
     */
    public function getLinkTypeReturnsUrl()
    {

        /**
         * Scenario:
         *
         * Given there is an external weblink
         * When getLinkType is called with that weblink
         * Then "url" is returned
         */
        self::assertEquals('url', $this->subject->getLinkType('https://www.google.de'));
    }

    /**
     * @test
     */
    public function getLinkTypeReturnsUrlIfPrefixUsed()
    {
        /**
         * Scenario:
         *
         * Given there is an external weblink
         * Given the t3://-prefix is prepended
         * When getLinkType is called with that weblink
         * Then "url" is returned
         */
        self::assertEquals('url', $this->subject->getLinkType('t3://url?url=https://www.google.de'));
    }

    /**
     * @test
     */
    public function getLinkTypeReturnsUrlIfAdditionalParamsGiven()
    {
        /**
         * Scenario:
         *
         * Given there is an external weblink
         * Given the t3://-prefix is prepended
         * Given a title and a link-target are set
         * When getLinkType is called with that weblink
         * Then "url" is returned
         */
        self::assertEquals('url', $this->subject->getLinkType('t3://url?url=https://www.google.de - - "zur Website"'));
    }


    /**
     * @test
     */
    public function getLinkTypeReturnsUnknownForNonFalFile()
    {

        /**
         * Scenario:
         *
         * Given there is a path to a file
         * Given this file is not in FAL
         * When getLinkType is called with that path
         * Then "unknown" is returned
         */

        self::assertEquals('unknown', $this->subject->getLinkType('fileadmin/media/file-placeholder.pdf'));
    }


    /**
     * @test
     */
    public function getLinkTypeReturnsUnknownForNonFalFileId()
    {

        /**
         * Scenario:
         *
         * Given this file-id which is not in FAL
         * When getLinkType is called with that file-id
         * Then "unknown" is returned
         */

        self::assertEquals('unknown', $this->subject->getLinkType('file:99999'));
    }


    /**
     * @test
     */
    public function getLinkTypeReturnsFileForExistingFalId()
    {

        /**
         * Scenario:
         *
         * Given there is a file-id which is existing in FAL
         * When getLinkType is called with that file-id
         * Then "file" is returned
         */

        self::assertEquals('file', $this->subject->getLinkType('file:1'));
    }


    /**
     * @test
     */
    public function getLinkTypeReturnsFileIfPrefixUsed()
    {
        /**
         * Scenario:
         *
         * Given there is a file-id which is existing in FAL
         * Given the t3://-prefix is prepended
         * When getLinkType is called with that file-id
         * Then "file" is returned
         */
        self::assertEquals('file', $this->subject->getLinkType('t3://file?uid=1'));
    }

    /**
     * @test
     */
    public function getLinkTypeReturnsFileIfAdditionalParamsGiven()
    {
        /**
         * Scenario:
         *
         * Given there is a file-id which is existing in FAL
         * Given the t3://-prefix is prepended
         * Given a title and a link-target are set
         * When getLinkType is called with that file-id
         * Then "file" is returned
         */
        self::assertEquals('file', $this->subject->getLinkType('t3://file?uid=1 - - "zur Website"'));
    }




    //=============================================


    /**
     * @test
     */
    public function getDataAttributesReturnsPageAsActionAndHostnameAsCategory()
    {

        /**
         * Scenario:
         *
         * Given there is an existing page
         * When getDataAttributes is called with the id of the page
         * Then "page" is is returned as action
         * Then the domain of the rootpage with "Default" as subcategory is returned as category
         */
        $assert = [
            'data-etracker-action' => 'page',
            'data-etracker-category' => 'testing.com/Default'
        ];

        self::assertEquals($assert, $this->subject->getDataAttributes('t3://page?uid=1'));
    }


    /**
     * @test
     */
    public function getDataAttributesReturnsActionEmailAndHostnameAsCategory()
    {
        /**
         * Scenario:
         *
         * Given there is an email-address
         * When getDataAttributes is called with that email-address
         * Then "email" is is returned as action
         * Then the domain of the rootpage with "Default" as subcategory is returned as category
         */
        $assert = [
            'data-etracker-action' => 'email',
            'data-etracker-category' => 'testing.com/Default'
        ];

        self::assertEquals($assert, $this->subject->getDataAttributes('t3://email?email=mailto:kroggel@test.de'));
    }

    /**
     * @test
     */
    public function getDataAttributesReturnsActionUrlAndHostnameAsCategory()
    {

        /**
         * Scenario:
         *
         * Given there is an external weblink
         * When getDataAttributes is called with that weblink
         * Then "url" is is returned as action
         * Then the domain of the rootpage with "Default" as subcategory is returned as category
         */
        $assert = [
            'data-etracker-action' => 'url',
            'data-etracker-category' => 'testing.com/Default'
        ];

        self::assertEquals($assert, $this->subject->getDataAttributes('t3://url?url=https://www.google.de'));
    }


    /**
     * @test
     */
    public function getDataAttributesReturnsActionFileAndObjectNameForExistentFalFile()
    {

        /**
         * Scenario:
         *
         * Given there is an existent FAL-file
         * Given that FAL-File has no project set
         * When getDataAttributes is called with that file-id
         * Then "file" is is returned as action
         * Then filename is is returned as object
         * Then the domain of the rootpage with "Default" as subcategory is returned as category
         */
        $assert = [
            'data-etracker-action' => 'file',
            'data-etracker-category' => 'testing.com/Default',
            'data-etracker-object' => 'file-placeholder-1.pdf'
        ];

        self::assertEquals($assert, $this->subject->getDataAttributes('t3://file?uid=1'));
    }


    /**
     * @test
     */
    public function getDataAttributesReturnsActionFileAndObjectNameAndProjectLongName()
    {

        /**
         * Scenario:
         *
         * Given there is an existent FAL-file
         * Given that FAL-File has a project set
         * Given that project has no short name
         * Given that Project has no internal name
         * When getDataAttributes is called with that file-id
         * Then "file" is is returned as action
         * Then filename is is returned as object
         * Then the domain of the rootpage plus the long name of the project are is returned as category
         */
        $assert = [
            'data-etracker-action' => 'file',
            'data-etracker-category' => 'testing.com/TestenLong',
            'data-etracker-object' => 'file-placeholder-2.pdf'
        ];

        self::assertEquals($assert, $this->subject->getDataAttributes('t3://file?uid=2'));
    }

    /**
     * @test
     */
    public function getDataAttributesReturnsActionFileAndObjectNameAndProjectShortName()
    {
        /**
         * Scenario:
         *
         * Given there is an existent FAL-file
         * Given that FAL-File has a project set
         * Given that project has a short name
         * Given that Project has no internal name
         * When getDataAttributes is called with that file-id
         * Then "file" is is returned as action
         * Then filename is is returned as object
         * Then the domain of the rootpage plus the short name of the project are is returned as category
         */
        $assert = [
            'data-etracker-action' => 'file',
            'data-etracker-category' => 'testing.com/TestenShort',
            'data-etracker-object' => 'file-placeholder-3.pdf'
        ];

        self::assertEquals($assert, $this->subject->getDataAttributes('t3://file?uid=3'));
    }

    /**
     * @test
     */
    public function getDataAttributesReturnsActionFileAndObjectNameAndProjectInternalName()
    {

        /**
         * Scenario:
         *
         * Given there is an existent FAL-file
         * Given that FAL-File has a project set
         * Given that project has a short name
         * Given that Project has an internal name
         * When getDataAttributes is called with that file-id
         * Then "file" is is returned as action
         * Then filename is is returned as object
         * Then the domain of the rootpage plus the internal name of the project are is returned as category
         */
        $assert = [
            'data-etracker-action' => 'file',
            'data-etracker-category' => 'testing.com/TestenInternal',
            'data-etracker-object' => 'file-placeholder-4.pdf'
        ];

        self::assertEquals($assert, $this->subject->getDataAttributes('t3://file?uid=4'));
    }

    //=============================================


    /**
     * TearDown
     */
    protected function tearDown(): void
    {
        parent::tearDown();

        // remove folders and files
        if (file_exists(\TYPO3\CMS\Core\Core\Environment::getPublicPath() . '/fileadmin')) {

            foreach (range(1, 4) as $fileCount) {
                if (file_exists(\TYPO3\CMS\Core\Core\Environment::getPublicPath() . '/fileadmin/media/file-placeholder-' . $fileCount . '.pdf')) {
                    unlink (\TYPO3\CMS\Core\Core\Environment::getPublicPath() . '/fileadmin/media/file-placeholder-' . $fileCount . '.pdf');
                }
            }

            if (file_exists(\TYPO3\CMS\Core\Core\Environment::getPublicPath() . '/fileadmin/media')) {
                rmdir (\TYPO3\CMS\Core\Core\Environment::getPublicPath() . '/fileadmin/media');
            }
        }
    }






}
