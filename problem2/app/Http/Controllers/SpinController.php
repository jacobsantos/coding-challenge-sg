<?php

namespace App\Http\Controllers;

use App\Player;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Http\Request;
use InvalidArgumentException;

class SpinController extends BaseController
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
			return response()->json([
				'error' => 'coins_won must be more than 0',
			]);
		}

		if (!is_numeric($spin['coins_bet']) || intval($spin['coins_bet']) < 1) {
			return response()->json([
				'error' => 'coins_bet must be more than 0',
			]);
		}

		/** @var Player $player */
		$player = Player::where('player_id', '=', intval($spin['player_id']))->first();

		if (!$player || !hash_equals($player->salt_value, $spin['hash'])) {
			return response()->json([
				'error' => 'player not found',
			]);
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
