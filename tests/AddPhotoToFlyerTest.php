<?php

namespace App;

use App\AddPhotoToFlyer;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Mockery as m;

class AddPhotoToFlyerTest extends \TestCase
{



	/** @test */
	public function it_processes_a_form_to_add_a_photo_to_a_flyer()
	{
		$flyer = factory(Flyer::class)->create();

		$file = m::mock(UploadedFile::class, [
			'getClientOriginalName' => 'foo',
			'getClientOriginalExtension' => 'jpg',
		]);

		$file->shouldReceive('move')
			->once()
			->with('images/photos', 'nowfoo.jpg');

		$form = new AddPhotoToFlyer($flyer, $file, $thumbnail);

		$thumbnail = m::mock(Thumbnail::class);

		$thumbnail->shouldReceive('make')
			->once()
			->with('images/photos/nowfoo.jpg', 'images/photos/tn-nowfoo.jpg');

		$form->save();

		$this->assertCount(1, $flyer->photos);
	}
}

function time() {
	return 'now';
}

function sha1($path) {
	return $path;
}