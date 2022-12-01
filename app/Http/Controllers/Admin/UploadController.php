<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\UploadedFile;

use Pion\Laravel\ChunkUpload\Receiver\FileReceiver;
use Pion\Laravel\ChunkUpload\Handler\HandlerFactory;
use Pion\Laravel\ChunkUpload\Exceptions\UploadMissingFileException;

class UploadController extends Controller
{
    public function upload(Request $request)
    {
        // create the file receiver
        $receiver = new FileReceiver("file", $request, HandlerFactory::classFromRequest($request));

        // check if the upload is success, throw exception or return response you need
        if ($receiver->isUploaded() === false) {
            throw new UploadMissingFileException();
        }

        // receive the file
        $save = $receiver->receive();

        // check if the upload has finished (in chunk mode it will send smaller files)
        if ($save->isFinished()) {
            $file = $save->getFile();

            $mime = str_replace('/', '-', $file->getMimeType());



            if (
                strpos($mime, 'video') === false
                && strpos($mime, 'image') === false
                && strpos($mime, 'application') === false
            ) {
                return response()->json([
                    'code' => 0,
                    'errors' => ['Wrong file!']
                ]);
            }


            if (strpos($mime, 'image') !== false && strpos($mime, 'svg') === false) {

                $imgWidth = !empty($request->img_width) ? $request->img_width : null;
                $imgHeight = !empty($request->img_height) ? $request->img_height : null;

                return $this->saveImage($file, $imgWidth, $imgHeight);
            }


            return $this->saveFile($file);
        }

        // we are in chunk mode, lets send the current progress
        /** @var AbstractHandler $handler */
        $handler = $save->handler();

        return response()->json([
            'code' => 1,
            "done" => $handler->getPercentageDone(),
        ]);
    }
    protected function saveFile(UploadedFile $file)
    {
        $fileName = $this->createFilename($file);
        // Group files by mime type
        $mime = str_replace('/', '-', $file->getMimeType());


        // Group files by the date (week
        $dateFolder = date("Y-m-d");

        // Build the file path
        $filePath = "uploads/{$dateFolder}/";
        $finalPath = Storage::path('public') . '/' . $filePath;


        // move the file name
        $target = $file->move($finalPath, $fileName);





        /*$uploadedFile = new FileModel();
        $uploadedFile->original_name = $file->getClientOriginalName();
        $uploadedFile->file_path = $filePath;
        $uploadedFile->user_id = Auth::user()->id;
        $uploadedFile->file_name = $fileName;
        $uploadedFile->file_mime = $mime;
        $uploadedFile->file_size_kb = round($target->getSize() / 1024);
        $uploadedFile->created_at = MyCarbon::now();

        $uploadedFile->save();*/


        return response()->json([
            'code' => 1,
            'path' => $filePath,
            'name' => $fileName,
            'mime_type' => $mime,
            //'file_id' => $uploadedFile->id,
            //'url' => route('file.get', ['id' => $uploadedFile->id], false)
        ]);
    }
    protected function saveImage(UploadedFile $file, $width = null, $height = null)
    {
        $fileName = $this->createFilename($file);
        // Group files by mime type
        $mime = str_replace('/', '-', $file->getMimeType());


        // Group files by the date (week
        $dateFolder = date("Y-m-d");

        // Build the file path
        $filePath = "uploads/{$dateFolder}/";
        $finalPath = Storage::path('public') . '/' . $filePath;


        // move the file name
        $target = $file->move($finalPath, $fileName);

        /*$uploadedFile = new FileModel();
        $uploadedFile->original_name = $file->getClientOriginalName();
        $uploadedFile->file_path = $filePath;
        $uploadedFile->user_id = Auth::user()->id;
        $uploadedFile->file_name = $fileName;
        $uploadedFile->file_mime = $mime;
        $uploadedFile->file_size_kb = round($target->getSize() / 1024);
        $uploadedFile->created_at = MyCarbon::now();

        $uploadedFile->save();
        if (!empty($width)) {
            $resizeImg = Image::make(Storage::path('public') . '/' . $uploadedFile->file_path . $uploadedFile->file_name)
                ->fit($width);
            $resizeImg->save();
        }*/
        return response()->json([
            'code' => 1,
            'path' => $filePath,
            'name' => $fileName,
            'mime_type' => $mime,
            //'file_id' => $uploadedFile->id,
            //'url' => route('file.get', ['id' => $uploadedFile->id], false)
        ]);
    }
    protected function createFilename(UploadedFile $file)
    {
        $extension = $file->getClientOriginalExtension();
        //$filename = str_replace("." . $extension, "", \Str::slug($file->getClientOriginalName())); // Filename without extension
        $filename = auth()->guard()->user()->id;
        // Add timestamp hash to name of the file
        $filename .= "_" . md5(time().$file->getClientOriginalName()) . "." . $extension;

        return $filename;
    }
}
