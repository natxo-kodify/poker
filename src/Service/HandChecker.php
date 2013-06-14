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



}