<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Image;
use GuzzleHttp\Client;


class ImageController extends Controller
{
    // public function upload(Request $request)
    // {
    //     $request->validate([
    //         'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
    //     ]);

    //     $image = $request->file('image');
    //     $imageName = time() . '.' . $image->extension();
    //     $imagePath = $image->storeAs('public/images', $imageName);


    //     $client = new Client();
    //     $response = $client->request('POST', 'https://api.imgbb.com/1/upload', [
    //         'form_params' => [
    //             'key' => 'YOUR_IMGBB_API_KEY', // Thay thế bằng API key của bạn
    //             'image' => base64_encode(file_get_contents(storage_path('app/public/' . $imagePath))),
    //         ],
    //     ]);


    //     $data = json_decode($response->getBody(), true);
    //     $imgbbUrl = $data['data']['image']['url'];

    //     Image::create([
    //         'name' => $imageName,
    //         'original_path' => $imagePath,
    //         'imgbb_url' => $imgbbUrl,
    //     ]);

    //     return redirect()->back()->with('success', 'Image uploaded successfully!');
    // }


    public function index()
    {
        return view('upload'); // Cập nhật đường dẫn view
    }

    public function upload(Request $request)
    {
        $request->validate([
            'image' => 'required|file|max:10240|mimes:jpg,jpeg,png,gif,mp4,mov,avi,wmv', // cho phép tải lên nhiều định dạng
        ]);

        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $path = $file->store('uploads', 'public'); // thay đổi thư mục lưu nếu cần
            $type = $file->getClientOriginalExtension();

            // Tạo bản ghi trong cơ sở dữ liệu
            Image::create([
                'filename' => basename($path),
                'path' => $path,
                'type' => $type,
            ]);

            return response()->json(['success' => 'File uploaded successfully!']);
        }

        return response()->json(['error' => 'No file uploaded'], 400);
    }
    public function showClickForm()
    {
        return view('upload');
    }
}
