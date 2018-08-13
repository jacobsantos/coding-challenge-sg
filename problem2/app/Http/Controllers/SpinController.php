<?php

namespace App\Http\Controllers;

use App\Player;
use http\Exception\InvalidArgumentException;
use Illuminate\Http\Request;

class SpinController extends Controller
{

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
    	$spin = $request->all(['hash', 'player_id', 'coins_won', 'coins_bet']);

    	// Validate coins won and coins bet.
		if (!is_numeric($spin['coins_won']) || intval($spin['coins_won']) < 1) {
			throw new InvalidArgumentException('coins_won must be more than 0');
		}

		if (!is_numeric($spin) || intval($spin['coins_bet']) < 1) {
			throw new InvalidArgumentException('coins_bet must be more than 0');
		}

		/** @var Player $player */
		$player = Player::where('salt_value', $spin['hash'])
			->where('player_id', $spin['player_id'])
			->first();

		if (!$player || $player->exists === false) {
			throw new InvalidArgumentException('player not found');
		}

		$player->lifetime_spins += 1;
		$player->credits += intval($spin['coins_won']) - intval($spin['coins_bet']);
		$player->save();

		return response()->json([
			'player_id' => $player->player_id,
			'name' => $player->name,
			'credits' => $player->credits,
			'lifetime_spins' => $player->lifetime_spins,
			'lifetime_average' => $player->lifetime_average,
		]);
    }
}
