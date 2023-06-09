<?php

// (c) Copyright by authors of the Tiki Wiki CMS Groupware Project
//
// All Rights Reserved. See copyright.txt for details and a complete list of authors.
// Licensed under the GNU LESSER GENERAL PUBLIC LICENSE. See license.txt for details.
// $Id$

/**
 * @group unit
 *
 */


class EditLibTest extends TikiTestCase
{
    private $el; // the EditLib

    protected function setUp(): void
    {
        TikiLib::lib('edit');
        $this->el = new EditLib();
    }


    protected function tearDown(): void
    {
    }


    public function testParseColor(): void
    {
        $el = new EditLib();

        $col = 'rgb(255 , 0 , 0)';
        $hex = $el->parseColor($col);
        $this->assertEquals('#FF0000', $hex);

        $col = 'rgb(255,0,0)';
        $hex = $el->parseColor($col);
        $this->assertEquals('#FF0000', $hex);

        $col = 'rgb(0, 255,0)';
        $hex = $el->parseColor($col);
        $this->assertEquals('#00FF00', $hex);

        $col = 'rgb(0,0,255)';
        $hex = $el->parseColor($col);
        $this->assertEquals('#0000FF', $hex);

        $col = '#FF0000';
        $hex = $el->parseColor($col);
        $this->assertEquals('#FF0000', $hex);
    }


    public function testParseStyleAttribute(): void
    {
        $el = new EditLib();

        /*
         * empty style -> empty array
         */
        $style = '';
        $parsed = [];
        $el->parseStyleAttribute($style, $parsed);
        $this->assertCount(0, $parsed);


        /*
         * delimiters only -> empty array
         */
        $style = ' ; ; ';
        $parsed = [];
        $el->parseStyleAttribute($style, $parsed);
        $this->assertCount(0, $parsed);


        /*
         * examples, no shortand lists
         */
        $style = 'unknown-list:rgb(1,2,3) url(background.gif);unknown-size:12;';
        $parsed = [];
        $el->parseStyleAttribute($style, $parsed);
        $this->assertCount(2, $parsed);
        $this->assertTrue(isset($parsed['unknown-list']));
        $this->assertEquals('rgb(1,2,3) url(background.gif)', $parsed['unknown-list']);
        $this->assertTrue(isset($parsed['unknown-size']));
        $this->assertEquals(12, $parsed['unknown-size']);

        $style = 'unknown-list:rgb(1,2,3) url(background.gif);unknown-size:12';
        $parsed = [];
        $el->parseStyleAttribute($style, $parsed);
        $this->assertCount(2, $parsed);
        $this->assertTrue(isset($parsed['unknown-list']));
        $this->assertEquals('rgb(1,2,3) url(background.gif)', $parsed['unknown-list']);
        $this->assertTrue(isset($parsed['unknown-size']));
        $this->assertEquals(12, $parsed['unknown-size']);

        $style = ' unknown-list : rgb( 1 , 2 , 3 ) url( background.gif )   ;   unknown-size: 12 ; ';
        $parsed = [];
        $el->parseStyleAttribute($style, $parsed);
        $this->assertCount(2, $parsed);
        $this->assertTrue(isset($parsed['unknown-list']));
        $this->assertEquals('rgb( 1 , 2 , 3 ) url( background.gif )', $parsed['unknown-list']);
        $this->assertTrue(isset($parsed['unknown-size']));
        $this->assertEquals(12, $parsed['unknown-size']);


        /*
         * examples with shorthand list 'background'
         */
        $style = 'background-color:#FF0000';
        $parsed = [];
        $el->parseStyleAttribute($style, $parsed);
        $this->assertCount(1, $parsed);
        $this->assertTrue(isset($parsed['background-color']));
        $this->assertEquals('#FF0000', $parsed['background-color']);

        $style = 'background:#FF0000';
        $parsed = [];
        $el->parseStyleAttribute($style, $parsed);
        $this->assertCount(1, $parsed);
        $this->assertTrue(isset($parsed['background-color']));
        $this->assertEquals('#FF0000', $parsed['background-color']);

        $style = 'background:rgb(0, 0, 0);';
        $parsed = [];
        $el->parseStyleAttribute($style, $parsed);
        $this->assertCount(1, $parsed);
        $this->assertTrue(isset($parsed['background-color']));
        $this->assertEquals('rgb(0, 0, 0)', $parsed['background-color']);

        $style = 'background: rgb(0, 255, 0); background-color:rgb(255, 0, 0);';
        $parsed = [];
        $el->parseStyleAttribute($style, $parsed);
        $this->assertCount(1, $parsed);
        $this->assertTrue(isset($parsed['background-color']));
        $this->assertEquals('rgb(255, 0, 0)', $parsed['background-color']);

        $style = 'background-color:rgb(255, 0, 0); background: rgb(0, 255, 0);';
        $parsed = [];
        $el->parseStyleAttribute($style, $parsed);
        $this->assertCount(1, $parsed);
        $this->assertTrue(isset($parsed['background-color']));
        $this->assertEquals('rgb(0, 255, 0)', $parsed['background-color']);

        $style = 'background-color:rgb(255, 0, 0); background: rgb(0, 255, 0) #0000FF;';
        $parsed = [];
        $el->parseStyleAttribute($style, $parsed);
        $this->assertCount(1, $parsed);
        $this->assertTrue(isset($parsed['background-color']));
        $this->assertEquals('#0000FF', $parsed['background-color']);

        $style = 'background-color:rgb(255, 0, 0); background: rgb(0, 255, 0) unknown1 #0000FF unknown2;';
        $parsed = [];
        $el->parseStyleAttribute($style, $parsed);
        $this->assertCount(2, $parsed);
        $this->assertTrue(isset($parsed['background-color']));
        $this->assertEquals('#0000FF', $parsed['background-color']);
        $this->assertTrue(isset($parsed['background']));
        $this->assertEquals('unknown1 unknown2', $parsed['background']);
    }


    public function testParseStyleList(): void
    {
        $el = new EditLib();

        /*
         * empty
         */
        $list = '';
        $parsed = [];
        $el->parseStyleList($list, $parsed);
        $this->assertCount(0, $parsed);


        /*
         * mixed examples
         */
        $list = 'rgb(0, 255, 0) #0000FF';
        $parsed = [];
        $el->parseStyleList($list, $parsed);
        $this->assertCount(2, $parsed);
        $this->assertEquals('rgb(0, 255, 0)', $parsed[0]);
        $this->assertEquals('#0000FF', $parsed[1]);

        $list = 'rgb( 1 , 2 , 3 )   20px    url( background-example.gif )';
        $parsed = [];
        $el->parseStyleList($list, $parsed);
        $this->assertCount(3, $parsed);
        $this->assertEquals('rgb( 1 , 2 , 3 )', $parsed[0]);
        $this->assertEquals('20px', $parsed[1]);
        $this->assertEquals('url( background-example.gif )', $parsed[2]);
    }


    public function testParseToWikiSpaces(): void
    {
        /*
         * The EditLib eats spaces after the tags
         */
        $inData = 'abc <b> bold </b> def';
        $res = $this->el->parseToWiki($inData);
        $this->assertEquals('abc __ bold __ def', $res);
    }


    /**
     * Nested color specifications
     *
     * In HTML, color specifications can be nested.
     * In Wiki, the colors specifications cannot be nested.
     * Hence some reordering is required.
     */
    public function testParseToWikiNestedColors(): void
    {
        /*
         * <span><span>text</span></span>
         */
        $inData = '<span style="color: rgb(255, 0, 0);">';
        $inData .= '<span style="background-color: rgb(255, 255, 0);">';
        $inData .= 'fg and bg colored';
        $inData .= '</span></span>';
        $res = $this->el->parseToWiki($inData);
        $ex = '~~#FF0000:~~ ,#FFFF00:fg and bg colored~~~~';
        $this->assertEquals($ex, $res);


        /*
         * <span>text<span>text</span>text</span>text
         */
        $inData = '<span style="color: rgb(255, 0, 0);">';
        $inData .= 'fg colored ';
        $inData .= '<span style="background-color: rgb(255, 255, 0);">';
        $inData .= 'both colored ';
        $inData .= '</span>';
        $inData .= 'fg colored ';
        $inData .= '</span>';
        $inData .= 'regular';
        $res = $this->el->parseToWiki($inData);
        $ex = '~~#FF0000:fg colored ~~ ,#FFFF00:both colored ~~fg colored ~~regular';
        $this->assertEquals($ex, $res);

        $inData = '<span style="background-color: rgb(255, 0, 0);">';
        $inData .= 'bg colored ';
        $inData .= '<span style="color: rgb(255, 255, 0);">';
        $inData .= 'both colored ';
        $inData .= '</span>';
        $inData .= 'bg colored ';
        $inData .= '</span>';
        $inData .= 'regular';
        $res = $this->el->parseToWiki($inData);
        $ex = '~~ ,#FF0000:bg colored ~~#FFFF00:both colored ~~bg colored ~~regular';
        $this->assertEquals($ex, $res);
    }

    /**
     * Nested colors with wiki inline
     */
    public function testParseToWikiNestedColorsWithWikiInline(): void
    {

        $inData = '<span style="color: rgb(255, 0, 0);">';
        $inData .= 'red ';
        $inData .= '<strong>';
        $inData .= 'bold ';
        $inData .= '<span style="background-color: rgb(255, 255, 0);">';
        $inData .= 'yellow ';
        $inData .= '</span>';
        $inData .= 'bold ';
        $inData .= '</strong>';
        $inData .= 'red';
        $inData .= '</span>';
        $ex = '~~#FF0000:red __bold ~~ ,#FFFF00:yellow ~~bold __red~~';
        $res = $this->el->parseToWiki($inData);
        $this->assertEquals($ex, $res);
    }

    /**
     * Nested wiki inline tags
     *
     * This test verifies that the tags are written in the correct
     * order to the output stream.
     */
    public function testParseToWikiNestedInline(): void
    {

        $ex = '__bold\'\'bold italic\'\'__\n__\'\'bold italic\'\'__';
        $inData = '<strong>bold<em>bold italic<br />bold italic</em></strong>';
        $res = $this->el->parseToWiki($inData);
        $res = preg_replace('/\n/', '\n', $res); // fix LF encoding for comparison
        $this->assertEquals($ex, $res);

        $ex = '__bold\'\'bold italic\'\'__\n__bold__';
        $inData = '<strong>bold<em>bold italic</em><br />bold</strong>';
        $res = $this->el->parseToWiki($inData);
        $res = preg_replace('/\n/', '\n', $res); // fix LF encoding for comparison
        $this->assertEquals($ex, $res);

        $ex = '__\'\'bold italic\'\'__\n__\'\'BOLD ITALIC\'\'__';
        $inData = '<span style="font-weight:bold;font-style:italic">bold italic<br />BOLD ITALIC</span>';
        $res = $this->el->parseToWiki($inData);
        $res = preg_replace('/\n/', '\n', $res); // fix LF encoding for comparison
        $this->assertEquals($ex, $res);
    }

    /**
     * @group marked-as-incomplete
     */
    public function testSpanNestedTitle(): void
    {
        $this->markTestIncomplete('Work in progress.');
        $ex = '--===text===--';
        $inData = '<span style="text-decoration:line-through underline;">text</span>';
        $res = $this->el->parseToWiki($inData);
        $this->assertEquals($ex, $res);
    }
}
