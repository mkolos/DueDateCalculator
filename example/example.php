<?php

declare(strict_types = 1);

use Kolosh\DueDateCalculator\Calculator;

require_once '../vendor/autoload.php';

$calculator = new Calculator();
$startDate = new \DateTime('2020-08-10 09:12:00');
$formattedStartDate = $startDate->format(DateTimeInterface::ATOM);
$turnaroundTime = 55;
$dueDate = $calculator->calculateDueDate($startDate, $turnaroundTime);
$formattedDueDate = $dueDate->format(DateTimeInterface::ATOM);

echo "Start date: $formattedStartDate \n";
echo "Turnaround time: $turnaroundTime \n";
echo "Due date: $formattedDueDate";
