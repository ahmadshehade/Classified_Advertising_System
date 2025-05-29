<?php

namespace App\Traits;

use App\Jobs\ProcessAdImageJob;
use App\Jobs\ProcessAdsImageJob;
use App\Models\Image;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

trait ManagmentFiles
{

    /**
     * Summary of uploadImages
     * @param mixed $request
     * @param mixed $inputName
     * @param mixed $imageable_type
     * @param mixed $imageable_id
     * @param mixed $folderPath
     * @return void
     */
    public function uploadImages($request, $inputName, $imageable_type, $imageable_id, $folderPath)
    {
        if (!$request->hasFile($inputName)) {
            return;
        }

        $files = is_array($request->file($inputName))
            ? $request->file($inputName)
            : [$request->file($inputName)];

        foreach ($files as $file) {
            $filename = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
            $path = $file->storeAs($folderPath, $filename, 'public');

            $image = Image::create([
                'path'      => $path,
                'imageable_type'  => $imageable_type,
                'imageable_id'    => $imageable_id,
            ]);

            dispatch(new ProcessAdsImageJob($image->id));
        }
    }

    /**
     * Summary of deleteImages
     * @param mixed $imageable_type
     * @param mixed $imageable_id
     * @param mixed $imageIds
     * @return void
     */
    public function deleteImages($imageable_type, $imageable_id, $imageIds = null)
    {

        $query = Image::where('imageable_type', $imageable_type)
            ->where('imageable_id', $imageable_id);


        if ($imageIds) {
            $query->whereIn('id', is_array($imageIds) ? $imageIds : [$imageIds]);
        }

        $images = $query->get();

        foreach ($images as $image) {

            if (Storage::disk('public')->exists($image->path)) {
                Storage::disk('public')->delete($image->path);
            }


            $image->delete();
        }
    }
}
