<?php
/**
 * Description:
 * Given a list of people with their birth and end years (all between 1900 and 2000),
 * find the year with the most number of people alive.
 */

require __DIR__ . '/lib.php';

try {
	$buildData = new PopulationAgeData();
	$population = $buildData->load();
	$peopleAlive = build_population_by_year($population);
	$yearWithMostPopulation = get_year_with_most_population($peopleAlive);
	echo "Solution 1: Year with most population = $yearWithMostPopulation\n";
} catch (Exception $ex) {
	echo $ex->getMessage() . "\n" . $ex->getTraceAsString();
}

