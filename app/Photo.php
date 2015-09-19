<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class Photo extends Model
{

	protected $table = 'flyer_photos';

	protected $fillable = ['path', 'name', 'thumbnail_path'];

    public function flyer()
    {
    	return $this->belongsTo('App\Flyer');
    }

    public function setNameAttribute($name)
    {
        $this->attributes['name'] = $name;

        $this->path = $this->baseDir() . '/' . $name;
        $this->thumbnail_path = $this->baseDir()  . '/tn-' . $name;
    }

    public function baseDir()
    {
        return 'images/photos';
    }

}
