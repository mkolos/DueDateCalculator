<?php

declare(strict_types=1);

namespace Kolosh\DueDateCalculator;

use DateTime;
use Exception;

class Calculator implements CalculatorInterface
{

    const FIRST_HOUR_OF_WORKDAY = 9;
    const LAST_HOUR_OF_WORKDAY = 16;
    const DAYS_OF_WEEKEND = ['Saturday', 'Sunday'];

    /**
     * @param DateTime|null $submitDate
     * @param int $turnaroundTime
     * @return DateTime|null
     * @throws Exception
     */
    public function calculateDueDate(?DateTime $submitDate = null, int $turnaroundTime = 0): ?DateTime
    {
        if (!$submitDate) {
            $submitDate = new DateTime();
        }

        $this->validateSubmitDate($submitDate);
        $this->validateTurnaroundTime($turnaroundTime);

        $dueDate = clone $submitDate;
        $hoursWorked = 0;
        while ($hoursWorked < $turnaroundTime) {
            $dueDate->modify('+1 hour');

            if ($this->isWorkingHour($dueDate)) {
                $hoursWorked++;
            }
        }

        return $dueDate;
    }

    protected function isWorkingHour(DateTime $date): bool
    {
        $hourOfDate = $date->format('G');
        if ($hourOfDate < static::FIRST_HOUR_OF_WORKDAY || $hourOfDate > static::LAST_HOUR_OF_WORKDAY) {
            return false;
        }

        $dayOfDate = $date->format('l');
        if (in_array($dayOfDate, static::DAYS_OF_WEEKEND)) {
            return false;
        }

        return true;
    }

    /**
     * @param DateTime $date
     * @return $this
     * @throws Exception
     */
    protected function validateSubmitDate(DateTime $date)
    {
        if (!$this->isWorkingHour($date)) {
            throw new Exception('Submit date must be during work time');
        }

        return $this;
    }

    protected function validateTurnaroundTime(int $turnaroundTime)
    {
        if ($turnaroundTime < 0) {
            throw new Exception('Turnaround time must be positive number');
        }

        return $this;
    }
}
