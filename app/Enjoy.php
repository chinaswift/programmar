<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class Enjoy extends Model {

	protected $table = 'enjoys';
	public $timestamps = false;

	protected $fillable = ['user_id', 'article_id','created_at','updated_at'];

	/**
	 * The attributes excluded from the model's JSON form.
	 *
	 * @var array
	 */
	protected $hidden = [];

}
