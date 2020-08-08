<?php

namespace Kolosh\DueDateCalculator\Tests\Unit;

use DateTime;
use Exception;
use Kolosh\DueDateCalculator\Calculator;
use PHPUnit\Framework\TestCase;

/**
 * Class CalculatorTest
 * @covers \Kolosh\DueDateCalculator\Calculator
 */
class CalculatorTest extends TestCase
{
    public function casesCalculateDueDate()
    {
        return [
            'basic' => [
                new DateTime('2020-08-10 12:12:00'),
                new DateTime('2020-08-10 09:12:00'),
                3,
            ],
            'longer_workaround_time' => [
                new DateTime('2020-08-11 11:12:00'),
                new DateTime('2020-08-10 09:12:00'),
                10,
            ],
            'with_weekend' => [
                new DateTime('2020-08-11 09:12:00'),
                new DateTime('2020-08-07 15:12:00'),
                10,
            ],
        ];
    }

    /**
     * @dataProvider casesCalculateDueDate
     */
    public function testCalculateDueDate(DateTime $expected, DateTime $submitDate, int $workaroundTime)
    {
        $calculator = new Calculator();
        $dueDate = $calculator->calculateDueDate($submitDate, $workaroundTime);

        static::assertEquals($expected, $dueDate);
    }

    public function casesCalculateDueDateFailed()
    {
        return [
            'wrong_submit_date' => [
                new Exception('Submit date must be during work time'),
                new DateTime('2020-08-08 15:12:00'),
                10,
            ],
            'wrong_turnaround_time' => [
                new Exception('Turnaround time must be positive number'),
                new DateTime('2020-08-12 15:12:00'),
                -1,
            ],
        ];
    }

    /**
     * @param Exception $expectedException
     * @param DateTime $submitDate
     * @param int $workaroundTime
     *
     * @dataProvider casesCalculateDueDateFailed
     */
    public function testCalculateDueDateFailed(Exception $expectedException, DateTime $submitDate, int $workaroundTime)
    {
        $calculator = new Calculator();

        static::expectExceptionObject($expectedException);
        $calculator->calculateDueDate($submitDate, $workaroundTime);
    }
}
