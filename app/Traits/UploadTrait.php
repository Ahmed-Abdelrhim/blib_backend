<?php

namespace App\Traits;

use Exception;
use Intervention\Image\Facades\Image;

trait UploadTrait
{

    private function createFolderIfNotExist($full_path)
    {
        if (!file_exists($full_path)) {
            mkdir($full_path, 0777, true);
        }
    }

    public function upload($image, string $folder)
    {
        $public_path = rtrim(app()->basePath('public/storage'), '/');
        $full_path = $public_path . '/uploads/' . $folder;

        $file_name = time() . '_' . rand(111111, 999999);
        $original_extension = $image->getClientOriginalExtension();

        $this->createFolderIfNotExist($full_path);

        if (in_array($original_extension, ['png', 'jpg', 'jpeg', 'webp'])) {
            Image::make($image)->encode('webp')->save($full_path . '/' . $file_name . '.webp');
            $image_name = $file_name . '.webp';
        } else {
            $file_name_with_original_extension = $file_name . '.' . $original_extension;
            $image->move($full_path, $file_name_with_original_extension);
            $image_name = $file_name_with_original_extension;
        }

        return '/uploads/' . $folder . '/' . $image_name;
    }

    public function updateImage($image, string $folder, string $old_image_path = null)
    {
        $new_image_path = $this->upload($image, $folder);
        $this->deleteFile($old_image_path);
        return $new_image_path;
    }

    public function updateImageWithResize($image, string $folder, string $old_image_path = null, int $w, int $h)
    {
        $new_image_path = $this->uploadWithResize($image, $folder, $w, $h);
        $this->deleteFile($old_image_path);
        return $new_image_path;
    }
    public function deleteFile($file_path)
    {
        if ($file_path) {
            try {
                unlink(public_path('storage') . $file_path);
            } catch (Exception $e) {
                return;
            }
        }
    }


    public function uploadWithResize($image, string $folder, int $w, int $h)
    {

        $public_path = rtrim(app()->basePath('public/storage'), '/');
        $full_path = $public_path . '/uploads/' . $folder;

        $file_name = time() . '_' . rand(111111, 999999);
        $original_extension = $image->getClientOriginalExtension();

        $this->createFolderIfNotExist($full_path);

        if (in_array($original_extension, ['png', 'jpg', 'jpeg', 'webp'])) {
            // Image::make($image)
            Image::make($image)
                ->encode('webp')
                ->orientate()
                ->resize($w, $h, function ($constraint) {
                    $constraint->aspectRatio();
                    $constraint->upsize();
                })
                ->save($full_path . '/' . $file_name . '.webp');

            $image_name = $file_name . '.webp';
        } else {
            $file_name_with_original_extension = $file_name . '.' . $original_extension;
            $image->move($full_path, $file_name_with_original_extension);
            $image_name = $file_name_with_original_extension;
        }

        return '/uploads/' . $folder . '/' . $image_name;
    }
}
