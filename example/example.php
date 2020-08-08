<?php

declare(strict_types = 1);

use Kolosh\DueDateCalculator\Calculator;

require_once '../vendor/autoload.php';

$calculator = new Calculator();
$startDate = new DateTime('2020-08-10 09:12:00');
$turnaroundTime = 55;
$dueDate = $calculator->calculateDueDate($startDate, $turnaroundTime);

echo "Start date: $startDate->format(DateTimeInterface::ATOM) \n";
echo "Turnaround time: $turnaroundTime \n";
echo "Due date: $dueDate->format(DateTimeInterface::ATOM)";
