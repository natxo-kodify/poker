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
        $numbersFound = $this->getHandNumbers($hand);
        $max          = max($numbersFound);
        $min          = min($numbersFound);
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

    public function isRoyalFlush(Hand $hand)
    {
        return $this->isStraight($hand) && $this->isFlush($hand) && max($this->getHandNumbers($hand) == 13);
    }

    public function isFourOfAKind(Hand $hand)
    {
        $numbersCount = $this->getHandNumbersCount($hand);

        return max($numbersCount) == 4;
    }


    protected function getHandNumbersCount(Hand $hand)
    {
        $numbersCount = array();
        foreach ($hand->getCards() as $card) {
            $cardNumber = $card->getNumber();
            if (!isset($numbersCount[$cardNumber])) {
                $numbersCount[$cardNumber] = 1;
            } else {
                $numbersCount[$cardNumber]++;
            }
        }

        return $numbersCount;
    }

    protected function getHandNumbers(Hand $hand)
    {
        $numbersFound = array();
        foreach ($hand->getCards() as $card) {
            $cardNumber                = $card->getNumber();
            $numbersFound[$cardNumber] = $cardNumber;
        }

        return $numbersFound;
    }

}