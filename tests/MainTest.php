<?php
/**
 * User: Script
 * Date: 06.11.2018
 * Time: 7:10
 */

namespace Geega\EventManager\Tests;


use Geega\EventManager\EventManager;
use PHPUnit\Framework\TestCase;

class MainTest extends TestCase
{
    public function testSingelton()
    {
        $em1 = EventManager::getInstance();
        $em2 = EventManager::getInstance();

        $this->assertEquals($em1, $em2);
    }

    public function testCallbackByEvent()
    {
        $em = EventManager::getInstance();
        $em->on('some-event', function(){ echo 'some-event triggered '; });
        $em->on('some-event', function(){ echo 'another handler'; });

        ob_start();
        $em->emit('some-event', array('somedata'));
        $result = ob_get_clean();

        $this->assertEquals('some-event triggered another handler', $result);
    }
}