<?php namespace ApishkaTest;

use Apishka\EasyExtend\EasyExtend;
use Composer\Composer;
use Composer\IO\NullIO;
use PHPUnit_Framework_TestCase;

class EasyExtendTest extends PHPUnit_Framework_TestCase
{
    /**
     * Set up
     */

    protected function setUp()
    {
        parent::setUp();
        $this->plugin = new EasyExtend();
        $this->composer = new Composer;
        $this->io = new NullIO;
    }
}
