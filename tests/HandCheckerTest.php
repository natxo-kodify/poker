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

    public function testFourOfAKindOK()
    {
        for ($i = 0; $i < 4; ++$i) {
            for ($j = 0; $j < 13; ++$j) {
                for ($k = 0; $k < 13; $k) {
                    if ($k == $j) {
                        break;
                    }
                    $different = new Card($k, $i);
                    $hand      = new Hand(
                        $different,
                        new Card($j, 0),
                        new Card($j, 1),
                        new Card($j, 2),
                        new Card($j, 3)
                    );
                    $this->assertTrue($this->checker->isFourOfAKind($hand));
                }
            }
        }
    }

    public function testFourOfAKindNotOk()
    {
        for ($i = 0; $i < 4; ++$i) {
            for ($j = 0; $j < 13; ++$j) {
                for ($k = 0; $k < 13; $k) {
                    if ($k == $j) {
                        break;
                    }
                    $different   = new Card($k, $i);
                    $handArray   = $this->getSameNumberCardsArray($k, 4);
                    $handArray[] = $different;
                    $hand        = new Hand($handArray);
                    $this->assertFalse($this->checker->isFourOfAKind($hand));
                }
            }
        }
    }

    protected function getSameNumberCardsArray($number, $times)
    {
        $cardsArray = array();
        $starting   = rand(0, 3);
        $end        = $times + $starting;
        for ($i = $starting; $i < $end; ++$i) {
            $cardsArray[] = new Card($number, ($i % 4));
        }

        return $cardsArray;
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