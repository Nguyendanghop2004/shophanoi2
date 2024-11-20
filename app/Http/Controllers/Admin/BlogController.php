<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\BlogClient;
use App\Models\ProductImage;
use Illuminate\Http\Request;
use Storage;

class BlogController extends Controller
{
    public function index()
    {
        return view('admin.blog.index');
    }
    public function store(Request $request)
    {
        $data = BlogClient::create([
            'title' => $request->title,
            'unique' => 'admin',
            'slug' => '-das123',
            'content' => $request->content
        ]);
        $data['content'] = $this->processDescription($request->input('description'), $data->id);
        // dd($data);
        $data->save();
        // dd($data);
    }
    private function processDescription($description, $productId)
    {
        if (empty(trim($description))) {
            // Nếu mô tả rỗng, xóa toàn bộ ảnh liên quan
            ProductImage::where('product_id', $productId)->get()->each(function ($image) {
                Storage::delete("public/" . $image->image_url); // Xóa file
                $image->delete(); // Xóa bản ghi trong CSDL
            });
            return ''; // Trả về chuỗi rỗng
        }

        $dom = new \DOMDocument();
        libxml_use_internal_errors(true); // Bỏ qua các lỗi HTML không hợp lệ
        $dom->loadHTML(mb_convert_encoding($description, 'HTML-ENTITIES', 'UTF-8'));

        // Danh sách ảnh trong mô tả mới
        $newImages = [];

        foreach ($dom->getElementsByTagName('img') as $img) {
            /** @var \DOMElement $img */
            $src = $img->getAttribute('src');

            // Kiểm tra nếu ảnh được encode base64
            if (preg_match('/^data:image\/(\w+);base64,/', $src, $type)) {
                $data = substr($src, strpos($src, ',') + 1);
                $data = base64_decode($data);

                // Tạo tên ảnh ngẫu nhiên
                $imageName = uniqid() . '.png';
                $filePath = "public/images/products/summernote/$imageName";
                Storage::put($filePath, $data);

                // Cập nhật đường dẫn của ảnh trong nội dung
                $img->setAttribute('src', asset("storage/images/products/summernote/$imageName"));

                // Lưu thông tin ảnh mới vào CSDL
                $imageUrl = "images/products/summernote/$imageName";
                ProductImage::create([
                    'product_id' => $productId,
                    'image_url' => $imageUrl,
                ]);

                // Thêm vào danh sách ảnh mới
                $newImages[] = $imageUrl;
            } else {
                // Nếu ảnh đã tồn tại (không phải base64), thêm vào danh sách ảnh mới
                $existingPath = str_replace(asset('storage') . '/', '', $src); // Loại bỏ asset URL để lấy đường dẫn lưu trữ
                $newImages[] = $existingPath;
            }
        }

        // Lấy danh sách ảnh cũ từ CSDL
        $oldImages = ProductImage::where('product_id', $productId)->pluck('image_url')->toArray();
        // Xóa các ảnh cũ không còn trong mô tả
        $imagesToDelete = array_diff($oldImages, $newImages);

        foreach ($imagesToDelete as $imagePath) {
            Storage::delete("public/" . $imagePath); // Xóa file khỏi storage
            ProductImage::where('product_id', $productId)->where('image_url', $imagePath)->delete(); // Xóa bản ghi CSDL
        }

        // Chỉ lấy phần nội dung bên trong <body>
        $bodyContent = '';
        foreach ($dom->getElementsByTagName('body')->item(0)->childNodes as $child) {
            $bodyContent .= $dom->saveHTML($child);
        }

        return $bodyContent; // Trả về nội dung đã xử lý
    }

    public function show(Request $request)
    {
        $data = BlogClient::get();
        return view('admin.blog.blog', compact('data'));
    }
}
