<?php

namespace App\Services;

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Intervention\Image\Facades\Image;
use App\Models\FileUpload;
use Illuminate\Http\UploadedFile;
use DB;
use Illuminate\Support\Facades\View;


class FileUploadService
{
    /**
     * Handle file upload, compression, validation, and logging.
     *
     * @param  \Illuminate\Http\UploadedFile  $file
     * @param  string  $destinationPath
     * @return array
     */
    public function uploadFile(UploadedFile $file, string $destinationPath, $fileUploadId)
{

   // Step 1: Validate the file (Ensure the file is valid before proceeding)
    $validationResult = $this->validateFile($file);
    if ($validationResult !== true) {
        return $validationResult;  // Return validation errors if the file is not valid
    }

    // Optional Step: Compress the image if it's an image (uncomment to use)
    // if ($file->isImage()) {
    //     $file = $this->compressImage($file);
    // }

    // Step 2: Modify the filename by removing hyphens
    $originalName = $file->getClientOriginalName();  // Get the original filename
    $modifiedName = str_replace('-', '', $originalName);  // Remove hyphens

    // Step 3: Store the file in the specified folder
    // Store the file and retrieve the path with the modified filename
    $filePath = $this->storeFile($file, $destinationPath, $modifiedName);

    // Ensure the file is stored correctly, check if $filePath is not empty
    if (empty($filePath)) {
        return response()->json(['error' => 'File upload failed.'], 500);  // Error if file upload failed
    }

    // Step 4: Insert or Update the file details into the database
    // if (View::shared('auditeelogin') === 'I') {
    //     $sessionuser  = session('user');
    //     $userchargeid = $sessionuser->userid;
    // } else {
    //     $chargedel    =   session('charge');
    //     $userchargeid   =   $chargedel->userchargeid;
    // }
    $chargedel    =   session('charge');
    $usertypecode   =   $chargedel->usertypecode;

    // Step 4: Insert or Update the file details into the database
    if (View::shared('auditeelogin') === $usertypecode) {
        $sessionuser  = session('user');
        $userchargeid = $sessionuser->userid;
    } else {
        $userchargeid   =   $chargedel->userchargeid;
    }
    if ($fileUploadId) {

        // Update existing record
        DB::table('audit.fileuploaddetail')
            ->where('fileuploadid', $fileUploadId)
            ->update([
                'filepath' => $filePath,
                'filename' => $modifiedName,  // Store the modified filename
                'filesize' => $file->getSize(),
                'mimetype' => $file->getClientMimeType(),
                'uploadedby' => $userchargeid,
                'usertypecode'  =>  $usertypecode,
                'uploadedon' => now(),
                'statusflag' => 'Y', // Set status flag to 'Y' (Active)
            ]);
    } else {
        // Step 5: Insert new file details into database
        $fileUploadId = DB::table('audit.fileuploaddetail')->insertGetId([
            'filepath' => $filePath,
            'filename' => $modifiedName,  // Store the modified filename
            'filesize' => $file->getSize(),
            'mimetype' => $file->getClientMimeType(),
            'uploadedby' =>   $userchargeid ,
            'usertypecode'  =>  $usertypecode,
            'uploadedon' => now(),
            'statusflag' => 'Y', // Set status flag to 'Y' (Active)
        ], 'fileuploadid');  // Get the ID of the inserted record
    }

    // Step 6: Return the fileupload_id as a response
    $uploadResult = [
        'fileupload_id' => $fileUploadId,
        // other data can be added here
    ];

    return response()->json($uploadResult);  // This will return a JsonResponse
}


    /**
     * Validate the file (size, type, existence)
     *
     * @param  \Illuminate\Http\UploadedFile  $file
     * @return mixed
     */
    private function validateFile(UploadedFile $file)
    {
        $validator = Validator::make([
            'file' => $file,
        ], [
            'file' => 'required|file|mimes:jpeg,png,jpg,gif,pdf,docx,txt|max:10240',  // Adjust validation rules
        ]);

        if ($validator->fails()) {
            return $validator->errors()->all();
        }

        // Check if the file already exists
        if (Storage::exists($file->getClientOriginalName())) {
            return ['File already exists'];
        }

        return true;
    }

    /**
     * Compress the uploaded image file.
     *
     * @param  \Illuminate\Http\UploadedFile  $file
     * @return \Illuminate\Http\UploadedFile
     */
    private function compressImage(UploadedFile $file)
    {
        $image = Image::make($file);
        $image->save($file->getRealPath(), 75);  // Adjust compression quality (0-100)
        return $file;
    }

    /**
     * Store the uploaded file in the specified path.
     *
     * @param  \Illuminate\Http\UploadedFile  $file
     * @param  string  $destinationPath
     * @param  string  $modifiedName
     * @return string  $filePath
     */
    private function storeFile(UploadedFile $file, string $destinationPath, string $modifiedName)
    {
        // Store the file with the modified name (no hyphens)
        return $file->storeAs($destinationPath, $modifiedName, 'public');
    }
}
