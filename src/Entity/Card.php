<?php
namespace Entity;

Class Card
{
    protected $number;
    protected $suit;

    const HEARTS   = 0;
    const DIAMONDS = 1;
    const PIKES    = 2;
    const CLUBS    = 3;

    public function __construct($number, $suit)
    {
        $this->setNumber($number);
        $this->setSuit($suit);

        return $this;
    }

    public function setNumber($number)
    {
        if ($number < 0 || $number > 13) {
            throw new \InvalidArgumentException('Number should be between 1 and 13 (inclusive)');
        }
        $this->number = $number;

        return $this;
    }

    public function setSuit($suit)
    {
        if ($suit < 0 || $suit > 3) {
            throw new \InvalidArgumentException('Suit must be one of 1 (hearts),2(diamonds),3(pikes),4(clubs)');
        }
        $this->suit = $suit;

        return $this;
    }

    public function getNumber()
    {
        return $this->number;
    }

    public function getSuit()
    {
        return $this->suit;
    }

}