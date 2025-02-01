<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Http\Controllers\Controller;
use Intervention\Image\Facades\Image;


class FileController extends Controller
{
    
    // public function uploadFromUrl(Request $request)
    // {
    //     $request->validate([
    //         'url' => 'required|url',
    //     ]);

    //     $url = $request->input('url');
    //     $uploadDir = public_path('images/');
    //     $fileName = Str::uuid() . '.png';
    //     $filePath = $uploadDir . $fileName;

    //     try {
    //         if (!file_exists($uploadDir)) {
    //             mkdir($uploadDir, 0755, true);
    //         }

    //         // Fetch the image content from URL
    //         $imageContent = file_get_contents($url);
    //         if ($imageContent === false) {
    //             return response()->json(['success' => false, 'error' => 'Failed to fetch image.'], 400);
    //         }

    //         // Create an image instance from the content
    //         $image = Image::make($imageContent);

    //         // Define the target width and height
    //         $canvasWidth = 660; // Set your desired canvas width
    //         $canvasHeight = 900; // Set your desired canvas height

    //         // Maintain aspect ratio and resize the image to fit within the canvas
    //         $image->resize($canvasWidth, $canvasHeight, function ($constraint) {
    //             $constraint->aspectRatio(); // Keep the aspect ratio intact
    //             $constraint->upsize(); // Prevent upsizing
    //         });

    //         // Create a blank white canvas with the defined dimensions
    //         $canvas = Image::canvas($canvasWidth, $canvasHeight, '#ffffff');

    //         // Center the resized image on the canvas
    //         $canvas->insert($image, 'center');

    //         // Save the final image to the server
    //         $canvas->save($filePath);

    //         return response()->json(['success' => true, 'url' => url('public/images/' . $fileName)]);
    //     } catch (\Exception $e) {
    //         return response()->json(['success' => false, 'error' => $e->getMessage()], 500);
    //     }
    // }
    
    public function uploadFromUrl(Request $request)
{
    $request->validate([
        'url' => 'required|url',
        'logo' => 'nullable|file|image|mimes:jpeg,png,jpg,gif|max:2048', // Validate the logo
        'logoPosition' => 'nullable|string|in:top-left,top-right,bottom-left,bottom-right,center',
    ]);
    

    $url = $request->input('url');
    $dimension = $request->input('dimensions');
    $logo = $request->file('logo');
    $logoPosition = $request->input('logoPosition', 'center');
    $uploadDir = public_path('images/');
    $fileName = Str::uuid() . '.png';
    $filePath = $uploadDir . $fileName;
    

    try {
        if (!file_exists($uploadDir)) {
            mkdir($uploadDir, 0755, true);
        }

        // Fetch the image content from URL
        $imageContent = file_get_contents($url);
        if ($imageContent === false) {
            return response()->json(['success' => false, 'error' => 'Failed to fetch image.'], 400);
        }

        // Create an image instance from the content
        $image = Image::make($imageContent);

        // Define the target width and height
        
        if ($dimension[0] == 660 && $dimension[1] == 900) {
    $canvasWidth = 660;
    $canvasHeight = 900;
} else {
    $canvasWidth = 800;
    $canvasHeight = 1200;
}
        // Maintain aspect ratio and resize the image to fit within the canvas
        $image->resize($canvasWidth, $canvasHeight, function ($constraint) {
            $constraint->aspectRatio(); // Keep the aspect ratio intact
            $constraint->upsize(); // Prevent upsizing
        });

        // Create a blank white canvas with the defined dimensions
        $canvas = Image::canvas($canvasWidth, $canvasHeight, '#ffffff');

        // Center the resized image on the canvas
        $canvas->insert($image, 'center');

        // Process and add the logo if provided
        if ($logo) {
            $logoImage = Image::make($logo);
            $logoSize = 100; // Fixed size for the logo

            // Resize the logo to a square if necessary
            $logoImage->resize($logoSize, $logoSize, function ($constraint) {
                $constraint->aspectRatio();
                $constraint->upsize();
            });

            // Determine logo position
            $logoX = 0;
            $logoY = 0;
            switch ($logoPosition) {
                case 'top-left':
                    $logoX = 10;
                    $logoY = 10;
                    break;
                case 'top-right':
                    $logoX = $canvasWidth - $logoSize - 10;
                    $logoY = 10;
                    break;
                case 'bottom-left':
                    $logoX = 10;
                    $logoY = $canvasHeight - $logoSize - 10;
                    break;
                case 'bottom-right':
                    $logoX = $canvasWidth - $logoSize - 10;
                    $logoY = $canvasHeight - $logoSize - 10;
                    break;
                case 'center':
                default:
                    $logoX = ($canvasWidth - $logoSize) / 2;
                    $logoY = ($canvasHeight - $logoSize) / 2;
                    break;
            }

            // Insert the logo onto the canvas
            $canvas->insert($logoImage, 'top-left', $logoX, $logoY);
        }

        // Save the final image to the server
        $canvas->save($filePath);

        return response()->json(['success' => true, 'url' => url('public/images/' . $fileName)]);
    } catch (\Exception $e) {
        return response()->json(['success' => false, 'error' => $e->getMessage()], 500);
    }
}


    // public function uploadFile(Request $request)
    // {
       

    //     $file = $request->file('image');
    //     $uploadDir = public_path('images/');
    //     $fileName = Str::uuid() . '.' . $file->getClientOriginalExtension();
    //     $filePath = $uploadDir . $fileName;

    //     try {
    //         if (!file_exists($uploadDir)) {
    //             mkdir($uploadDir, 0755, true);
    //         }
    //         $file->move($uploadDir, $fileName);
    //         return response()->json(['success' => true, 'url' => url('images/' . $fileName)]);
    //     } catch (\Exception $e) {
    //         return response()->json(['success' => false, 'error' => $e->getMessage()], 500);
    //     }
    // }
    public function uploadFile(Request $request)
{
    try {
        $request->validate([
            'image' => 'required|file|mimes:png,jpg,jpeg|max:2048',
        ]);

        $file = $request->file('image');
        $uploadDir = public_path('images/');
        $fileName = Str::uuid() . '.' . $file->getClientOriginalExtension();
        $filePath = $uploadDir . $fileName;

        if (!file_exists($uploadDir)) {
            mkdir($uploadDir, 0755, true);
        }
        $file->move($uploadDir, $fileName);

        return response()->json(['success' => true, 'url' => url('public/images/' . $fileName)]);
    } catch (\Exception $e) {
        \Log::error('Upload error: ' . $e->getMessage()); // Log the error
        return response()->json(['success' => false, 'error' => $e->getMessage()], 500);
    }
}

}
