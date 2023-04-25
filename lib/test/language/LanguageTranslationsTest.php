<?php

// (c) Copyright by authors of the Tiki Wiki CMS Groupware Project
//
// All Rights Reserved. See copyright.txt for details and a complete list of authors.
// Licensed under the GNU LESSER GENERAL PUBLIC LICENSE. See license.txt for details.
// $Id$

require_once __DIR__ . '/../../language/LanguageTranslations.php';

/**
 * Test class for LanguageTranslations.
 * Generated by PHPUnit on 2010-08-05 at 10:04:14.
 */
class LanguageTranslationsTest extends TikiTestCase
{
    /**
     * @var LanguageTranslations
     */
    protected $obj;

    protected $lang;

    protected $langDir;

    protected $tikiroot;

    protected function setUp(): void
    {
        $this->tikiroot = __DIR__ . '/../../../';
        $this->lang = 'test_language';
        $this->langDir = $this->tikiroot . 'lang/' . $this->lang;

        chdir($this->tikiroot);
        mkdir($this->langDir);

        $this->obj = new LanguageTranslations($this->lang);

        TikiDb::get()->query('INSERT INTO `tiki_language` (`source`, `lang`, `tran`, `changed`) VALUES (?, ?, ?, ?)', ['Contributions by author', $this->lang, 'Contribuições por autor', 1]);
        TikiDb::get()->query('INSERT INTO `tiki_language` (`source`, `lang`, `tran`, `changed`) VALUES (?, ?, ?, ?)', ['Remove', $this->lang, 'Novo remover', 1]);
        TikiDb::get()->query('INSERT INTO `tiki_language` (`source`, `lang`, `tran`, `changed`) VALUES (?, ?, ?, ?)', ['Approved Status', $this->lang, 'Aprovado', 1]);
        TikiDb::get()->query('INSERT INTO `tiki_language` (`source`, `lang`, `tran`, `changed`) VALUES (?, ?, ?, ?)', ['Something', $this->lang, 'Algo', 1]);
        TikiDb::get()->query('INSERT INTO `tiki_language` (`source`, `lang`, `tran`, `changed`) VALUES (?, ?, ?, ?)', ['Trying to insert malicious PHP code back to the language.php file', $this->lang, 'asff"); echo \'teste\'; $dois = array(\'\',"', 1]);
        TikiDb::get()->query('INSERT INTO `tiki_language` (`source`, `lang`, `tran`, `changed`) VALUES (?, ?, ?, ?)', ['Should escape "double quotes" in the source string', $this->lang, 'Deve escapar "aspas duplas" na string original', 1]);
        TikiDb::get()->query('INSERT INTO `tiki_language` (`source`, `lang`, `tran`) VALUES (?, ?, ?)', ['Not changed', $this->lang, 'Translation not changed']);

        TikiDb::get()->query('INSERT INTO `tiki_untranslated` (`source`, `lang`) VALUES (?, ?)', ['Untranslated string 1', $this->lang]);
        TikiDb::get()->query('INSERT INTO `tiki_untranslated` (`source`, `lang`) VALUES (?, ?)', ['Untranslated string 2', $this->lang]);
        TikiDb::get()->query('INSERT INTO `tiki_untranslated` (`source`, `lang`) VALUES (?, ?)', ['Untranslated string 3', $this->lang]);

        global ${"lang_$this->lang"};

        copy(__DIR__ . '/fixtures/language_orig.php', $this->langDir . '/language.php');

        if (! isset(${"lang_$this->lang"})) {
            require_once('lib/init/tra.php');
            init_language($this->lang);
        }
    }

    protected function tearDown(): void
    {
        if (file_exists($this->langDir . '/language.php')) {
            unlink($this->langDir . '/language.php');
        }

        if (file_exists($this->langDir . '/custom.php')) {
            unlink($this->langDir . '/custom.php');
        }

        rmdir($this->langDir);

        TikiDb::get()->query('DELETE FROM `tiki_language` WHERE `lang` = ?', [$this->lang]);
        TikiDb::get()->query('DELETE FROM `tiki_untranslated` WHERE `lang` = ?', [$this->lang]);

        unset($GLOBALS['prefs']['record_untranslated']);
    }

    public function testUpdateTransShouldInsertNewTranslation(): void
    {
        $this->obj->updateTrans('New string', 'New translation');
        $result = TikiDb::get()->getOne('SELECT `tran` FROM `tiki_language` WHERE `lang` = ? AND `source` = ?', [$this->lang, 'New string']);
        $this->assertEquals('New translation', $result);
        TikiDb::get()->query('DELETE FROM `tiki_language` WHERE `lang` = ? AND `source` = ?', [$this->lang, 'New string']);
    }

    public function testUpdateTransShouldUpdateTranslation(): void
    {
        TikiDb::get()->query('INSERT INTO `tiki_language` (`source`, `lang`, `tran`) VALUES (?, ?, ?)', ['New string', $this->lang, 'Old translation']);
        $this->obj->updateTrans('New string', 'New translation');
        $result = TikiDb::get()->getOne('SELECT `tran` FROM `tiki_language` WHERE `lang` = ? AND `source` = ?', [$this->lang, 'New string']);
        $this->assertEquals('New translation', $result);
        TikiDb::get()->query('DELETE FROM `tiki_language` WHERE `lang` = ? AND `source` = ?', [$this->lang, 'New string']);
    }

    /* tiki_language.change seems unused, so this is superfluous as of 2017-10-06
     public function testUpdateTransShouldNotUpdateTranslation()
    {
        global ${"lang_$this->lang"};
        ${"lang_$this->lang"}['Not changed'] = 'Translation not changed';

        $this->assertEquals(null, $this->obj->updateTrans('Not changed', 'Translation not changed'));
        $result = TikiDb::get()->getOne('SELECT `changed` FROM `tiki_language` WHERE `lang` = ? AND binary `source` = ?', array($this->lang, 'Not changed'));
        $this->assertEquals(null, $result);
    }*/

    public function testUpdateTransShouldDeleteTranslation(): void
    {
        TikiDb::get()->query('INSERT INTO `tiki_language` (`source`, `lang`, `tran`) VALUES (?, ?, ?)', ['New string', $this->lang, 'New translation']);
        $this->obj->updateTrans('New string', '');
        $result = TikiDb::get()->getOne('SELECT `tran` FROM `tiki_language` WHERE `lang` = ? AND `source` = ?', [$this->lang, 'New string']);
        $this->assertFalse($result);
    }

    public function testUpdateTransShouldNotInsertStringsThatWereNotChanged(): void
    {
        $this->obj->updateTrans('last modification time', 'data da última modificação');
        $this->assertFalse(TikiDb::get()->getOne('SELECT `tran` FROM `tiki_language` WHERE `lang` = ? AND `source` = ?', [$this->lang, 'last modification time']));
    }

    public function testUpdateTransShouldMarkTranslationAsChanged(): void
    {
        TikiDb::get()->query('INSERT INTO `tiki_language` (`source`, `lang`, `tran`) VALUES (?, ?, ?)', ['New string', $this->lang, 'Old translation']);
        $this->obj->updateTrans('New string', 'New translation');
        $result = TikiDb::get()->getOne('SELECT `changed` FROM `tiki_language` WHERE `lang` = ? AND `source` = ?', [$this->lang, 'New string']);
        $this->assertEquals(1, $result);
        TikiDb::get()->query('DELETE FROM `tiki_language` WHERE `lang` = ? AND `source` = ?', [$this->lang, 'New string']);
    }

    public function testUpdateTransShouldDeleteEntryFromUntranslatedTable(): void
    {
        TikiDb::get()->query('INSERT INTO `tiki_untranslated` (`source`, `lang`) VALUES (?, ?)', ['New string', $this->lang]);
        $this->obj->updateTrans('New string', 'New translation');
        $result = TikiDb::get()->getOne('SELECT `source` FROM `tiki_untranslated` WHERE `lang` = ? AND `source` = ?', [$this->lang, 'New string']);
        $this->assertFalse($result);
    }

    public function testUpdateTransShouldIgnoreWhenSourceAndTranslationAreEqual(): void
    {
        $this->obj->updateTrans('Source and translation are the same', 'Source and translation are the same');
        $result = TikiDb::get()->getOne('SELECT `source` FROM `tiki_language` WHERE `lang` = ? AND `source` = ?', [$this->lang, 'Source and translation are the same']);
        $this->assertFalse($result);
    }

    public function testWriteLanguageFile(): void
    {
        copy(__DIR__ . '/fixtures/language_orig.php', $this->langDir . '/language.php');
        $this->obj->writeLanguageFile();
        $this->assertFileEquals(
            __DIR__ . '/fixtures/language_modif.php',
            $this->langDir . '/language.php'
        );
    }

    public function testWriteLanguageFileCallingTwoTimesShouldNotDuplicateStringsInTheFile(): void
    {
        copy(__DIR__ . '/fixtures/language_orig.php', $this->langDir . '/language.php');
        $this->obj->writeLanguageFile();
        $this->obj->writeLanguageFile();
        $this->assertFileEquals(
            __DIR__ . '/fixtures/language_modif.php',
            $this->langDir . '/language.php'
        );
    }

    public function testWriteLanguageShouldReturnTheNumberOfNewStringsInLanguageFile(): void
    {
        copy(__DIR__ . '/fixtures/language_orig.php', $this->langDir . '/language.php');
        $expectedResult = ['modif' => 2, 'new' => 4];
        $return = $this->obj->writeLanguageFile();
        $this->assertEquals($expectedResult, $return);
    }

    public function testWriteLanguageShouldIgnoreEmptyStrings(): void
    {
        TikiDb::get()->query('INSERT INTO `tiki_language` (`source`, `lang`, `tran`, `changed`) VALUES (?, ?, ?, ?)', ['', $this->lang, '', 1]);
        copy(__DIR__ . '/fixtures/language_orig.php', $this->langDir . '/language.php');
        $this->obj->writeLanguageFile();
        $this->assertFileEquals(
            __DIR__ . '/fixtures/language_modif.php',
            $this->langDir . '/language.php'
        );
    }

    public function testWriteLanguageShouldRaiseExceptionForInvalidLanguagePhp(): void
    {
        $this->expectException('Language_Exception');
        copy(__DIR__ . '/fixtures/language_invalid.php', $this->langDir . '/language.php');
        $this->obj->writeLanguageFile();
    }

    public function testDeleteTranslations(): void
    {
        $this->obj->deleteTranslations();
        $this->assertFalse(TikiDb::get()->getOne('SELECT * FROM `tiki_language` WHERE `lang` = ?', [$this->obj->lang]));
    }

    public function testGetFileUntranslated(): void
    {
        $cachelib = $this->getMockBuilder('Cachelib')->onlyMethods(['getSerialized', 'cacheItem'])->getMock();
        $cachelib->expects($this->once())->method('getSerialized')->with('untranslatedStrings.test_language.1234', 'untranslatedStrings')->willReturn(null);
        $cachelib->expects($this->once())->method('cacheItem');

        $obj = $this->getMockBuilder('LanguageTranslations')
                    ->onlyMethods(['_getCacheLib', '_getFileHash'])
                    ->setConstructorArgs([$this->lang])
                    ->getMock();

        $obj->expects($this->once())->method('_getCacheLib')->willReturn($cachelib);
        $obj->expects($this->once())->method('_getFileHash')->willReturn(1234);

        $expectedResult = [
                "Kalture Video" => ['source' => "Kalture Video", 'tran' => null],
                "Communication error" => ['source' => "Communication error", 'tran' => null],
                "Invalid response provided by the Kaltura server. Please retry" => ['source' => "Invalid response provided by the Kaltura server. Please retry", 'tran' => null],
                "Delete comments" => ['source' => "Delete comments", 'tran' => null],
                "Approved Status" => ['source' => "Approved Status", 'tran' => null],
                "Queued" => ['source' => "Queued", 'tran' => null],
                "The file is already locked by %s" => ['source' => "The file is already locked by %s", 'tran' => null],
                "Warning: The file is used in" => ['source' => "Warning: The file is used in", 'tran' => null],
                "You do not have permission to edit this file" => ['source' => "You do not have permission to edit this file", 'tran' => null],
                "Not modified since" => ['source' => "Not modified since", 'tran' => null],
                'Test special "characters" escaping' => ['source' => 'Test special "characters" escaping', 'tran' => null],
                ];

        $this->assertEquals($expectedResult, $obj->getFileUntranslated());
    }

    public function testGetFileUntranslatedCheckCache(): void
    {
        $expectedResult = [
                "Kalture Video" => ['source' => "Kalture Video", 'tran' => null],
                "Communication error" => ['source' => "Communication error", 'tran' => null],
                "Invalid response provided by the Kaltura server. Please retry" => ['source' => "Invalid response provided by the Kaltura server. Please retry", 'tran' => null],
                "Delete comments" => ['source' => "Delete comments", 'tran' => null],
                "Approved Status" => ['source' => "Approved Status", 'tran' => null],
                "Queued" => ['source' => "Queued", 'tran' => null],
                "The file is already locked by %s" => ['source' => "The file is already locked by %s", 'tran' => null],
                "Warning: The file is used in" => ['source' => "Warning: The file is used in", 'tran' => null],
                "You do not have permission to edit this file" => ['source' => "You do not have permission to edit this file", 'tran' => null],
                "Not modified since" => ['source' => "Not modified since", 'tran' => null],
                'Test special "characters" escaping' => ['source' => 'Test special "characters" escaping', 'tran' => null],
                ];
        $this->assertEquals($expectedResult, $this->obj->getFileUntranslated());

        // change file to check if the cache is ignored when the file changes
        copy(__DIR__ . '/fixtures/language_untranslated.php', $this->langDir . '/language.php');
        $expectedResult = [
                "Kalture Video" => ['source' => "Kalture Video", 'tran' => null],
                "Invalid response provided by the Kaltura server. Please retry" => ['source' => "Invalid response provided by the Kaltura server. Please retry", 'tran' => null],
                "Delete comments" => ['source' => "Delete comments", 'tran' => null],
                "Queued" => ['source' => "Queued", 'tran' => null],
                "The file is already locked by %s" => ['source' => "The file is already locked by %s", 'tran' => null],
                "Warning: The file is used in" => ['source' => "Warning: The file is used in", 'tran' => null],
                "You do not have permission to edit this file" => ['source' => "You do not have permission to edit this file", 'tran' => null],
                ];
        $this->assertEquals($expectedResult, $this->obj->getFileUntranslated());
    }

    public function getAllTranslationsDataProvider(): array
    {
        $fileTranslations = [
                "categorize" => ["source" => "categorize", "tran" => "categorizar"],
                "Set prefs" => ["source" => "Set prefs", "tran" => "Definir preferências"],
                "creation date" => ["source" => "creation date", "tran" => "data de criação"],
                "Delete comments" => ["source" => "Delete comments", "tran" => "Deletar comentários"],
                ];

        $dbTranslations = [
                "Approved Status" => ["id" => "16131", "source" => "Approved Status", "lang" => "test_language", "tran" => "Aprovado", "changed" => "1"],
                "creation date" => ["id" => "16132", "source" => "creation date", "lang" => "test_language", "tran" => "data de criação nova", "changed" => "1"],
                "Post" => ["id" => "16133", "source" => "Post", "lang" => "test_language", "tran" => "Enviar", "changed" => "1"],
                ];

        return [
                [$fileTranslations, $dbTranslations]
                ];
    }

    /**
     * @dataProvider getAllTranslationsDataProvider
     *
     * @param $fileTranslations
     * @param $dbTranslations
     */
    public function testGetAllTranslations($fileTranslations, $dbTranslations): void
    {
        $expectedResult = [
                'translations' => [
                    "Approved Status" => ["id" => "16131", "source" => "Approved Status", "lang" => "test_language", "tran" => "Aprovado", "changed" => "1"],
                    "categorize" => ["source" => "categorize", "tran" => "categorizar"],
                    "creation date" => ["id" => "16132", "source" => "creation date", "lang" => "test_language", "tran" => "data de criação nova", "changed" => "1"],
                    "Delete comments" => ["source" => "Delete comments", "tran" => "Deletar comentários"],
                    "Post" => ["id" => "16133", "source" => "Post", "lang" => "test_language", "tran" => "Enviar", "changed" => "1"],
                    "Set prefs" => ["source" => "Set prefs", "tran" => "Definir preferências"],
                    ],
                'total' => 6,
                ];

        $obj = $this->getMockBuilder('LanguageTranslations')
                    ->onlyMethods(['getFileTranslations', '_getDbTranslations'])
                    ->getMock();

        $obj->expects($this->once())->method('getFileTranslations')->willReturn($fileTranslations);
        $obj->expects($this->once())->method('_getDbTranslations')->willReturn($dbTranslations);

        $this->assertEquals($expectedResult, $obj->getAllTranslations());
    }

    /**
     * @dataProvider getAllTranslationsDataProvider
     * @param $fileTranslations
     * @param $dbTranslations
     */
    public function testGetAllTranslationsFilterByMaxRecordsAndOffset($fileTranslations, $dbTranslations): void
    {
        $expectedResult = [
                'translations' => [
                    "Delete comments" => ["source" => "Delete comments", "tran" => "Deletar comentários"],
                    "Post" => ["id" => "16133", "source" => "Post", "lang" => "test_language", "tran" => "Enviar", "changed" => "1"],
                    ],
                'total' => 6,
                ];

        $obj = $this->getMockBuilder('LanguageTranslations')
                    ->onlyMethods(['getFileTranslations', '_getDbTranslations'])
                    ->getMock();

        $obj->expects($this->once())->method('getFileTranslations')->willReturn($fileTranslations);
        $obj->expects($this->once())->method('_getDbTranslations')->willReturn($dbTranslations);

        $this->assertEquals($expectedResult, $obj->getAllTranslations(2, 3));
    }

    /**
     * @dataProvider getAllTranslationsDataProvider
     * @param $fileTranslations
     * @param $dbTranslations
     */
    public function testGetAllTranslationsFilterByMaxRecordsOffsetAndSearch($fileTranslations, $dbTranslations): void
    {
        $expectedResult = [
                'translations' => [
                    "Set prefs" => ["source" => "Set prefs", "tran" => "Definir preferências"],
                    ],
                'total' => 2,
                ];

        $obj = $this->getMockBuilder('LanguageTranslations')
                    ->onlyMethods(['getFileTranslations', '_getDbTranslations'])
                    ->getMock();

        $obj->expects($this->once())->method('getFileTranslations')->willReturn($fileTranslations);
        $obj->expects($this->once())->method('_getDbTranslations')->willReturn($dbTranslations);

        $this->assertEquals($expectedResult, $obj->getAllTranslations(2, 1, 're'));
    }

    /**
     * @dataProvider getAllTranslationsDataProvider
     * @param $fileTranslations
     * @param $dbTranslations
     */
    public function testGetAllTranslationsSearchByTranslation($fileTranslations, $dbTranslations): void
    {
        $expectedResult = [
                'translations' => [
                    "Set prefs" => ["source" => "Set prefs", "tran" => "Definir preferências"],
                    ],
                'total' => 1,
                ];

        $obj = $this->getMockBuilder('LanguageTranslations')
                    ->onlyMethods(['getFileTranslations', '_getDbTranslations'])
                    ->getMock();

        $obj->expects($this->once())->method('getFileTranslations')->willReturn($fileTranslations);
        $obj->expects($this->once())->method('_getDbTranslations')->willReturn($dbTranslations);

        $this->assertEquals($expectedResult, $obj->getAllTranslations(-1, 0, 'rê'));
    }

    public function testGetFileTranslations(): void
    {
        copy(__DIR__ . '/fixtures/custom.php', $this->langDir . '/custom.php');
        $this->assertCount(27, $this->obj->getFileTranslations());
    }

    public function testGetFileTranslationsShouldEscapeSpecialCharacters(): void
    {
        $trans = $this->obj->getFileTranslations();
        $this->assertArrayHasKey('Second test special "characters" escaping', $trans);
    }

    public function testGetDbTranslations(): void
    {
        $obj = $this->getMockBuilder('LanguageTranslations')
                    ->onlyMethods(['_diff'])
                    ->setConstructorArgs(['test_language'])
                    ->getMock();

        $obj->method('_diff');

        $dbTranslations = $obj->getDbTranslations('source_asc', -1, 0);
        $this->assertGreaterThan(0, $dbTranslations['total']);
        $this->assertEquals('Aprovado', $dbTranslations['translations']['Approved Status']['tran']);
    }

    public function testGetDbTranslationsMaxrecordsAndOffset(): void
    {
        $obj = $this->getMockBuilder('LanguageTranslations')
                    ->onlyMethods(['_diff'])
                    ->setConstructorArgs(['test_language'])
                    ->getMock();

        $obj->method('_diff');

        $dbTranslations = $obj->getDbTranslations('source_asc', 2, 1);
        $this->assertEquals(2, $dbTranslations['total']);
        $this->assertEquals('Contribuições por autor', $dbTranslations['translations']['Contributions by author']['tran']);
    }

    public function testGetDbTranslationsSearch(): void
    {
        $obj = $this->getMockBuilder('LanguageTranslations')
                    ->onlyMethods(['_diff'])
                    ->setConstructorArgs(['test_language'])
                    ->getMock();

        $obj->method('_diff');

        $dbTranslations = $obj->getDbTranslations('source_asc', -1, 0, 'Approved');
        $this->assertEquals(1, $dbTranslations['total']);
        $this->assertEquals('Aprovado', $dbTranslations['translations']['Approved Status']['tran']);
    }

    public function testGetDbUntranslated(): void
    {
        global $prefs;
        $prefs['record_untranslated'] = 'y';

        $expectedResult = [
                'translations' => [
                    'Untranslated string 1' => ['source' => 'Untranslated string 1', 'tran' => null],
                    'Untranslated string 2' => ['source' => 'Untranslated string 2', 'tran' => null],
                    'Untranslated string 3' => ['source' => 'Untranslated string 3', 'tran' => null],
                    ],
                'total' => 3
                ];

        $this->assertEquals($expectedResult, $this->obj->getDbUntranslated());
    }

    public function testGetDbUntranslatedFilterByMaxRecordsAndOffset(): void
    {
        global $prefs;
        $prefs['record_untranslated'] = 'y';

        $expectedResult = [
                'translations' => [
                    'Untranslated string 3' => ['source' => 'Untranslated string 3', 'tran' => null],
                    ],
                'total' => 3,
                ];

        $this->assertEquals($expectedResult, $this->obj->getDbUntranslated(1, 2));
    }

    public function testGetDbUntranslatedFilterBySearch(): void
    {
        global $prefs;
        $prefs['record_untranslated'] = 'y';

        $expectedResult = [
                'translations' => [
                    'Untranslated string 3' => ['source' => 'Untranslated string 3', 'tran' => null],
                    ],
                'total' => 1,
                ];

        $this->assertEquals($expectedResult, $this->obj->getDbUntranslated(-1, 0, 'string 3'));
    }

    public function getAllUntranslatedDataProvider(): array
    {
        $dbUntranslated = [
                'Untranslated string 1' => ['source' => 'Untranslated string 1', 'tran' => null],
                'Untranslated string 2' => ['source' => 'Untranslated string 2', 'tran' => null],
                "Communication error" => ['source' => "Communication error", 'tran' => null],
                ];

        $fileUntranslated = [
                "Kalture Video" => ['source' => "Kalture Video", 'tran' => null],
                "Communication error" => ['source' => "Communication error", 'tran' => null],
                "Invalid response provided by the Kaltura server. Please retry" => ['source' => "Invalid response provided by the Kaltura server. Please retry", 'tran' => null],
                "Delete comments" => ['source' => "Delete comments", 'tran' => null],
                "Approved Status" => ['source' => "Approved Status", 'tran' => null],
                ];

        $dbTranslations = [
                "Approved Status" => ['source' => "Approved Status", 'tran' => 'Aprovado'],
                ];

        return [
                [$dbUntranslated, $fileUntranslated, $dbTranslations],
                ];
    }

    /**
     * @dataProvider getAllUntranslatedDataProvider
     * @param $dbUntranslated
     * @param $fileUntranslated
     * @param $dbTranslations
     */
    public function testGetAllUntranslated($dbUntranslated, $fileUntranslated, $dbTranslations): void
    {
        $obj = $this->getMockBuilder('LanguageTranslations')
                    ->onlyMethods(['getFileUntranslated', '_getDbUntranslated', '_getDbTranslations'])
                    ->getMock();

        $obj->expects($this->once())->method('getFileUntranslated')->willReturn($fileUntranslated);
        $obj->expects($this->once())->method('_getDbUntranslated')->willReturn($dbUntranslated);
        $obj->expects($this->once())->method('_getDbTranslations')->willReturn($dbTranslations);

        $expectedResult = [
                'translations' => [
                    "Communication error" => ['source' => "Communication error", 'tran' => null],
                    "Delete comments" => ['source' => "Delete comments", 'tran' => null],
                    "Invalid response provided by the Kaltura server. Please retry" => ['source' => "Invalid response provided by the Kaltura server. Please retry", 'tran' => null],
                    "Kalture Video" => ['source' => "Kalture Video", 'tran' => null],
                    'Untranslated string 1' => ['source' => 'Untranslated string 1', 'tran' => null],
                    'Untranslated string 2' => ['source' => 'Untranslated string 2', 'tran' => null],
                    ],
                'total' => 6
                ];

        $this->assertEquals($expectedResult, $obj->getAllUntranslated());
    }
}
