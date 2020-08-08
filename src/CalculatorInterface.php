<?php

namespace Kolosh\DueDateCalculator;

use DateTime;
use Exception;

interface CalculatorInterface
{
    /**
     * @param DateTime|null $submitDate
     * @param int $turnaroundTime
     * @return DateTime|null
     * @throws Exception
     */
    public function calculateDueDate(?DateTime $submitDate = null, int $turnaroundTime = 0): ?DateTime;
}
