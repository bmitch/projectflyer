<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Flyer extends Model
{

	/**
	 * Fillable fields for a flyer
	 *
	 * @var array
	 */
	protected $fillable = [
		'street',
		'city',
		'zip',
		'country',
		'state',
		'price',
		'description',
	];

	/**
	 * Get flyer located at a given address.
	 *
	 * @param string  $zip
	 * @param string  $street
	 * @return Builder
	 */
	public static function locatedAt($zip, $street)
	{
		$street = str_replace('-', ' ', $street);

		return static::where(compact('zip', 'street'))->firstOrFail();
	}

	public function getPriceAttribute($price)
	{
		return '$' . number_format($price);
	}

	public function addPhoto(Photo $photo)
	{
		return $this->photos()->save($photo);
	}

	/**
	 * A flyer is composed of many photos.
	 * 
	 * @return \Illuminate\Database\Eloquent\Relations\HasMany
	 */
    public function photos()
    {
    	return $this->hasMany('App\Photo');	
    }

    /**
     * A flyer is owned by a user.
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function owner()
    {
    	return $this->belongsTo('App\User', 'user_id');
    }

    /**
     * Determine if the given user created the flyer.
     * @return boolean
     */
    public function ownedBy(User $user)
    {
    	return $this->user_id == $user->id;
    }
}

