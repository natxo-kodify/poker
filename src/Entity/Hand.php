<?php
namespace Entity;

use Entity\Card;

Class Hand
{
    protected $cards;

    public function __construct(array $handArray = array())
    {
        $this->cards = array();
        foreach ($handArray as $card) {
            if ($card instanceof Card) {
                $this->addCard($card);
            }
        }
    }

    public function addCard(Card $card)
    {
        if (count($this->cards)) {
            throw new \ErrorException('no more cards can be held');
        }
        foreach ($this->cards as $cardInHand) {
            if ($cardInHand->getNumber() == $card->getNumber() && $cardInHand->getSuit() == $card->getSuit()) {
                throw new \InvalidArgumentException('This cart is already in hand');
            }
        }
        $this->cards[] = $card;

        return $this;
    }

    public function getCards()
    {
        return $this->cards;
    }

}