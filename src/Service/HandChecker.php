<?php
namespace Service;

use Entity\Hand;

class HandChecker
{
    public function isFlush(Hand $hand)
    {
        $lastSuit = null;
        foreach ($hand->getCards() as $card) {
            if ($lastSuit == null) {
                $lastSuit = $card->getSuit();
            }
            if ($card->getSuit() != $lastSuit) {
                return false;
            }
        }

        return true;
    }

    public function isStraight(Hand $hand)
    {
        $numbersFound = array();
        foreach ($hand->getCards() as $card) {
            $cardNumber                = $card->getNumber();
            $numbersFound[$cardNumber] = $cardNumber;
        }
        $max = max($numbersFound);
        $min = min($numbersFound);
        if ($max == ($min + 5)) {
            return true;
        } else {
            if ($min == 0) {
                unset($numbersFound[0]);

                return (($max == 13) && min($numbersFound) == 9);
            }
        }

        return false;
    }

}