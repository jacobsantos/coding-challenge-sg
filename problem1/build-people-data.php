<?php
/**
 * Build random list of ages and save to people.json.
 */

require __DIR__ . '/lib.php';

$buildData = new PopulationAgeData(
	new PeopleGenerator(PopulationAgeData::YEAR_START, PopulationAgeData::YEAR_END)
);
$buildData->dump();
