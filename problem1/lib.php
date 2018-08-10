<?php
/**
 * Solution 1 implementation library.
 */


/**
 * Interface GeneratorPopulationInterface
 *
 * birth and death date set generation.
 */
interface GeneratorPopulationInterface {
	/**
	 * Generate birth and death date for person.
	 *
	 * @param int $population
	 *     Amount of people.
	 * @return Generator
	 */
	public function generate_person($population);
}

/**
 * Class PeopleGenerator
 *
 * Generate birth and death dates for person.
 */
class PeopleGenerator implements GeneratorPopulationInterface
{
	/**
	 * Minimum year for people dates.
	 *
	 * Used for births.
	 *
	 * @var int
	 */
	private $startYear;

	/**
	 * Maximum year for people dates.
	 *
	 * This sets the maximum (minus 1) birth. People can not be zero... even if
	 * people can be zero years.
	 *
	 * Used for deaths.
	 *
	 * @var
	 */
	private $endYear;

	public function __construct($startYear=1900, $endYear=2000)
	{
		if ($startYear > $endYear) {
			throw new InvalidArgumentException('Start year must be before end year.');
		}
		$this->startYear = $startYear;
		$this->endYear = $endYear;
	}

	/**
	 * Generate birth and death date for person.
	 *
	 * @param int $population
	 *     Amount of people.
	 * @return Generator
	 */
	public function generate_person($population)
	{
		for ($at=0; $at < $population; $at += 1) {
			$birth = mt_rand($this->startYear, $this->endYear - 1);
			$death = mt_rand($birth, $this->endYear);
			yield [$birth, $death];
		}
	}
}


/**
 * Class PopulationAgeData
 *
 * Generate and load population birth and death dates.
 */
class PopulationAgeData
{
	const FILE = __DIR__ . '/people.json';
	const YEAR_START = 1900;
	const YEAR_END = 2000;
	const PEOPLE_POPULATION = 1000;

	/**
	 * Used to generate population birth and death dates.
	 *
	 * @var GeneratorPopulationInterface
	 */
	private $peopleGenerator;

	public function __construct(GeneratorPopulationInterface $peopleGenerator = null)
	{
		if ($peopleGenerator === null) {
			$peopleGenerator = new PeopleGenerator(PopulationAgeData::YEAR_START, PopulationAgeData::YEAR_END);
		}
		$this->peopleGenerator = $peopleGenerator;
	}

	/**
	 * Generate and dump data to people file.
	 */
	public function dump()
	{
		file_put_contents(self::FILE, json_encode($this->generate(), JSON_PRETTY_PRINT));
	}

	/**
	 * Generate population birth and death data.
	 *
	 * @return array
	 */
	public function generate()
	{
		$peopleDates = [];
		foreach ($this->peopleGenerator->generate_person(self::PEOPLE_POPULATION) as $person) {
			$peopleDates[] = $person;
		}
		return $peopleDates;
	}

	/**
	 * Load population birth and death data from people.json file if it exists.
	 *
	 * Will generate population data if people.json file does not exist.
	 *
	 * @return array
	 *     Population list of birth and death tuple.
	 * @throws Exception
	 */
	public function load()
	{
		if (!file_exists(self::FILE)) {
			return $this->generate();
		}

		$population = json_decode(file_get_contents(self::FILE), true);
		if (json_last_error() > 0) {
			throw new Exception('JSON error: ' . json_last_error_msg());
		}
		return $population;
	}
}


/**
 * Build array of how many were alive during a given year based on population birth and death dates.
 *
 * This is not the best algorithm but it is quick to code and least prone to error.
 *
 * @param array $population
 *     Population list of birth and death tuple.
 * @return array
 *     Array with year as key and population alive at the time as value.
 */
function build_population_by_year(array $population)
{
	$peopleAliveYears = [];
	foreach ($population as list($birth, $death)) {
		foreach (range($birth, $death) as $aliveYear) {
			if (!isset($peopleAliveYears[$aliveYear])) {
				$peopleAliveYears[$aliveYear] = 0;
			}
			$peopleAliveYears[$aliveYear] += 1;
		}
	}
	return $peopleAliveYears;
}


/**
 * Retrieve the first year with the most people.
 *
 * @param array $peopleAliveYears
 *     Array with year as key and population alive at the time as value.
 * @return int
 *     Year with the most population.
 */
function get_year_with_most_population(array $peopleAliveYears)
{
	if (count($peopleAliveYears) < 1) {
		throw new InvalidArgumentException('$peopleAliveYears has no items.');
	}
	arsort($peopleAliveYears);
	file_put_contents(__DIR__ . '/population-alive.json', json_encode($peopleAliveYears, JSON_PRETTY_PRINT));
	return key($peopleAliveYears);
}
