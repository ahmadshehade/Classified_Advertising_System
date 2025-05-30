<?php

namespace App\Jobs;

use App\Models\Image;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

use Illuminate\Queue\SerializesModels;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;

class ProcessAdsImageJob implements ShouldQueue
{
    use Dispatchable, Queueable, SerializesModels;

    protected $imageId;

    public function __construct(int $imageId)
    {
        $this->imageId = $imageId;
    }

    public function handle(): void
    {
        $image = Image::find($this->imageId);
        if (!$image) return;

        $path = storage_path('app/public/' . $image->path);


        if (!file_exists($path)) {
            logger("Image file not found: " . $path);
            return;
        }


        try {
            $manager = new ImageManager(new Driver());
            $img = $manager->read($path);
            $img->resize(800, null)->save($path);
        } catch (\Exception $e) {
            logger("Image processing failed: " . $e->getMessage());
        }
    }
}
