<?php


namespace App\Http\Controllers;


use App\Models\Media;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Symfony\Component\HttpFoundation\File\Exception\UploadException;

class FileUploadController extends Controller
{
    public function store(Request $request): JsonResponse
    {
        $request->validate([
            'file' => 'required|mimes:'.config('notifier.allow_file_types')
        ]);

        if ($file = $request->file('file')) {
            $hash = md5_file($file->getRealPath());

            $path = sprintf('files/%s/%s%s', 'bb', date('Y/m/d'), $file->getExtension());
            $path = $file->store($path);

            $name = $file->getClientOriginalName();

            $media = Media::create([
                Media::APP_ID => 'aaa',
                Media::MEDIA_ID => (string)Str::uuid(),
                Media::PATH => $path,
                Media::FS_DRIVER => config('filesystem.default'),
                Media::NAME => $name,
                Media::MEDIA_HASH => $hash
            ]);

            return response()->json([
                "success" => true,
                "message" => "File successfully uploaded",
                "media_id" => $media->{Media::MEDIA_ID},
            ]);
        }

        throw new UploadException();
    }
}
