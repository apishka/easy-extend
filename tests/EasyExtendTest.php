<?php namespace ApishkaTest;

use \Composer\Composer;
use \Composer\IO\NullIO;
use \Composer\Script\Event;
use \Composer\Script\ScriptEvents;
use PHPUnit_Framework_TestCase;

use Apishka\EasyExtend\EasyExtend;

class EasyExtendTest extends PHPUnit_Framework_TestCase
{
    /**
     * Set up
     *
     * @access protected
     * @return void
     */

    protected function setUp()
    {
        parent::setUp();
        $this->plugin = new EasyExtend();
        $this->composer = new Composer;
        $this->io = new NullIO;
    }
}
