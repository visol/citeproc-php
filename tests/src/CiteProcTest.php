<?php

namespace AcademicPuma\CiteProc;

/**
 * Generated by PHPUnit_SkeletonGenerator on 2014-12-30 at 16:32:33.
 */
class CiteProcTest extends \PHPUnit_Framework_TestCase {

    /**
     * @var CiteProc
     */
    protected $object;

    /**
     * @var array
     */
    protected $publications;
    
    /**
     * Sets up the fixture, for example, opens a network connection.
     * This method is called before a test is executed.
     */
    protected function setUp() {
            
            $file = file_get_contents(__DIR__."/../data.json");
    
            $this->publications = json_decode($file);
    }

    /**
     * Tears down the fixture, for example, closes a network connection.
     * This method is called after a test is executed.
     */
    protected function tearDown() {
        //noop
    }



    /**
     * @covers academicpuma\citeproc\CiteProc::render
     * @todo   Implement testRender().
     */
    public function testRender() {
        foreach($this->publications as $key => $dataObject) {
            
            foreach($dataObject->rendereddata as $styleName => $renderedText) {

                
                $csl = CiteProc::loadStyleSheet($styleName);
                $lang = substr($this->publications->{$key}->locales, 0, 2);

                $citeProc = new CiteProc($csl, $lang);

                $actual = preg_replace("!(\s{2,})!"," ",strip_tags($citeProc->render($dataObject->rawdata)));
                
                echo $renderedText."\n";
                $this->assertEquals($renderedText, $actual, "Testing $key");
            }
        }
    }
}
