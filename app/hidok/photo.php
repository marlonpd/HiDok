<?php

namespace App\hidok;

use Image;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class Photo
{

	protected $name;

	protected $photos_dir = 'images/photos';

	protected $thumbnail_path = $photos_dir.'/thumb';

	public function get(Request $request)
	{

	}

	public function save_as($name)
	{
		return sprintf("%s-%s", time(), $name);
	}


	public function addPhoto(Request $request)
    {
        $this->validate($request, [
            'photo' => 'required|mimes:jpg,jpeg,png,bmp',
        ]);

    }



	public function store()
	{


	}

	protected function make_thumbnail()
    {
        Image::make($this->path)
            ->fit(200)
            ->save($this->thumbnail_path);
    }

    public function move(UploadedFile $file)
    {
        $file->move($this->baseDir, $this->name);
        $this->makeThumbnail();
        return $this;
    }

    public static function named($name)
    {
        return (new static)->saveAs($name);
    }
    protected function saveAs($name)
    {
        $this->name = sprintf("%s-%s", time(), $name);
        $this->path = sprintf("%s/%s", $this->baseDir, $this->name);
        $this->thumbnail_path = sprintf("%s/tn-%s", $this->baseDir, $this->name);
        return $this;
    }

}