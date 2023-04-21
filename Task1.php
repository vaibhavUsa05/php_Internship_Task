<?php
// Declaring an empty array
$numbers = array();
for ($i = 0; $i < 10; $i++) {
    $numbers[] = rand(1, 100);
}

// Step 2: Print out the original array
// implode function for joining the array elements with comma as a separator
echo "Original Array: [" . implode(", ", $numbers) . "] <br><br>";

// sorting method for sorting the array in ascending order
sort($numbers);

// Step 4: Print out the sorted array
echo "Sorted Array: [" . implode(", ", $numbers) . "]<br><br>";

// average value of the array
$average = array_sum($numbers) / count($numbers);
// rounding off the $average value to two decimal places
$average = round($average, 2);

// Step 6: Print out the average value
echo "Average: " . $average . "\n";
?>
