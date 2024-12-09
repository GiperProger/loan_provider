<?php

namespace App\Event;

use App\Entity\Credit;

class CreditApprovedEvent
{
    private Credit $credit;

    public function __construct(Credit $credit)
    {
        $this->credit = $credit;
    }

    public function getCredit(): Credit
    {
        return $this->credit;
    }
}