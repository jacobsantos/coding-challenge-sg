<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Player extends Model
{
    protected $table = 'player';

    protected $fillable = [
    	'name',
		'player_id',
		'credits',
		'lifetime_spins',
	];

    protected $guarded = [
    	'salt_value',
	];

    public $timestamps = false;

    public function getLifetimeAverageAttribute()
	{
		if ($this->lifetime_spins < 1) {
			return 0;
		}

		return round($this->credits / $this->lifetime_spins, 2);
	}
}
