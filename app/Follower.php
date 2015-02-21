<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class Follower extends Model {

	protected $table = 'followers';
	public $timestamps = false;

	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = ['followed_by', 'followed'];

	/**
	 * The attributes excluded from the model's JSON form.
	 *
	 * @var array
	 */
	protected $hidden = [];

}
