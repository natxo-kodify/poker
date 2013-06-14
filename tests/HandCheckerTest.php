<?php

namespace tests;

use Entity\Card;
use Entity\Hand;

class HandCheckerTest extends PHPUnit_Framework_TestCase
{
    protected $checker;

    public function setUp()
    {
        $this->checker = new OBJ();
    }

    public function testIsRoyalFlushNotFlush()
    {
        for ($i = 0; $i < 4; ++$i) {
            $handArray = $this->getHandArraySameSuit(array(0, 10, 11, 12, 13), $i);
            $handArray = $this->changeLastElementSuit($handArray);
            $hand      = new Hand($handArray);
            $this->assertTrue($this->checker->isFlush($hand));
            $this->assertFalse($this->checker->isStraight($hand));
            $this->assertFalse($this->checker->isRoyalFlush($hand));
        }
    }

    public function testIsRoyalFlushNotStraight()
    {
        for ($i = 0; $i < 4; ++$i) {
            $handArray = $this->getHandArraySameSuit(array(0, 10, 11, 12, rand(2, 9)), $i);
            $hand      = new Hand($handArray);
            $this->assertFalse($this->checker->isFlush($hand));
            $this->assertTrue($this->checker->isStraight($hand));
            $this->assertFalse($this->checker->isRoyalFlush($hand));
        }
    }

    public function testIsRoyalFlushNotEndingAce()
    {
        for ($i = 0; $i < 4; ++$i) {
            for ($j = 0; $j < 8; ++$j) {

                $handArray = $this->getHandArraySameSuit(array($j, $j + 1, $j + 2, $j + 3, $j + 4), $i);
                $hand      = new Hand($handArray);
                $this->assertTrue($this->checker->isFlush($hand));
                $this->assertTrue($this->checker->isStraight($hand));
                $this->assertFalse($this->checker->isRoyalFlush($hand));
            }
        }
    }

    public function testIsRoyalFlushOK()
    {
        for ($i = 0; $i < 4; ++$i) {
            $handArray = $this->getHandArraySameSuit(array(0, 10, 11, 12, 13), $i);
            $hand      = new Hand($handArray);
            $this->assertTrue($this->checker->isFlush($hand));
            $this->assertTrue($this->checker->isStraight($hand));
            $this->assertTrue($this->checker->isRoyalFlush($hand));
        }
    }

    public function testIsStraightFlushOK()
    {
        for ($i = 0; $i < 4; ++$i) {
            for ($j = 0; $j < 8; ++$j) {
                $handArray = $this->getHandArraySameSuit(array($j, $j + 1, $j + 2, $j + 3, $j + 4), $i);
                $hand      = new Hand($handArray);
                $this->assertTrue($this->checker->isFlush($hand));
                $this->assertTrue($this->checker->isStraight($hand));
                $this->assertTrue($this->checker->isRoyalFlush($hand));
            }
        }
    }

    public function testIsStraightFlushNotAllSameSuit()
    {
        for ($i = 0; $i < 4; ++$i) {
            for ($j = 0; $j < 8; ++$j) {
                $handArray = $this->getHandArraySameSuit(array($j, $j + 1, $j + 2, $j + 3, $j + 4), $i);
                $handArray = $this->changeLastElementSuit($handArray);
                $hand      = new Hand($handArray);
                $this->assertFalse($this->checker->isFlush($hand));
                $this->assertTrue($this->checker->isStraight($hand));
                $this->assertFalse($this->checker->isRoyalFlush($hand));
            }
        }
    }

    public function testIsStraightFlushNotStraight()
    {
        for ($i = 0; $i < 4; ++$i) {
            for ($j = 1; $j < 8; ++$j) {
                $handArray = $this->getHandArraySameSuit(array($j - 1, $j + 1, $j + 2, $j + 3, $j + 4), $i);
                $hand      = new Hand($handArray);
                $this->assertTrue($this->checker->isFlush($hand));
                $this->assertFalse($this->checker->isStraight($hand));
                $this->assertFalse($this->checker->isRoyalFlush($hand));
            }
        }
    }

    public function testIsStraightFlushNotStraightNoFlush()
    {
        for ($i = 0; $i < 4; ++$i) {
            for ($j = 1; $j < 8; ++$j) {
                $handArray = $this->getHandArraySameSuit(array($j - 1, $j + 1, $j + 2, $j + 3, $j + 4), $i);
                $handArray = $this->changeLastElementSuit($handArray);
                $hand      = new Hand($handArray);
                $this->assertFalse($this->checker->isFlush($hand));
                $this->assertFalse($this->checker->isStraight($hand));
                $this->assertFalse($this->checker->isRoyalFlush($hand));
            }
        }
    }



    protected function changeLastElementSuit($handArray)
    {
        $last        = array_pop($handArray);
        $newSuit     = ($last->getSuit() + 1) % 4;
        $handArray[] = new Card($last->getNumber(), $newSuit);

        return $handArray;
    }

    protected function getHandArraySameSuit(array $keys, $suit)
    {
        $handArray = array();
        foreach ($keys as $key) {
            $handArray[] = new Card($key, $suit);
        }

        return $handArray;
    }
}