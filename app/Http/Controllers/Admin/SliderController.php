<?php
namespace App\Http\Controllers\Admin;

use App\Models\Slider;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\Admin\StoreSliderRequest;
use App\Http\Requests\Admin\UpdateSliderRequest;

class SliderController extends Controller
{
    public function index(Request $request, $category_id)
    {
        $search = $request->input('search');
        if ($category_id != 'trash') {
            $sliders = Slider::with('category')
                ->where('category_id', $category_id)
                ->when($search, function ($query) use ($search) {
                    $query->where('title', 'like', "%{$search}%");
                })
                ->orderBy('position', 'asc')
                ->paginate(10);
            return view('admin.slider.index', compact('sliders', 'search', 'category_id'));
        } else {
            $sliders = Slider::onlyTrashed()
                ->when($search, function ($query) use ($search) {
                    $query->where('title', 'like', "%{$search}%");
                })
                ->paginate(10);
            return view('admin.slider.trash', compact('sliders', 'search', 'category_id'));
        }


    }

    public function updateOrder(Request $request)
    {
        $order = $request->input('order');
        $category_id = $request->input('category_id');

        if (!$order || !$category_id) {
            return response()->json(['message' => 'Dữ liệu không hợp lệ'], 400);
        }

        $category = Category::findOrFail($category_id);


        DB::transaction(function () use ($order, $category_id) {

            Slider::where('category_id', $category_id)->update(['position' => null]);
            foreach ($order as $position => $id) {
                Slider::where('id', $id)
                    ->where('category_id', $category_id)
                    ->update(['position' => $position + 1]);
            }
        });

        return response()->json(['message' => 'Cập nhật thứ tự thành công!']);
    }


    public function create()
    {
        $categories = Category::whereNull('parent_id')->get();
        return view('admin.slider.create', compact('categories'));
    }

    public function store(StoreSliderRequest $request)
    {
        $validated = $request->validated();

        $validated['image_path'] = $this->handleImageUpload($request);

        $maxPosition = Slider::where('category_id', $validated['category_id'])->max('position');
        $validated['position'] = $maxPosition ? $maxPosition + 1 : 1;

        Slider::create($validated);

        return redirect()->route('admin.slider.index', ['category_id' => $validated['category_id']])
            ->with('success', 'Slider đã được tạo thành công!');
    }

    public function edit($id)
    {
        $slider = Slider::findOrFail($id);

        $categories = Category::whereNull('parent_id')->get();
        return view('admin.slider.edit', compact('slider', 'categories'));
    }

    public function update(UpdateSliderRequest $request, $id)
    {
        $slider = Slider::findOrFail($id);
        $validated = $request->validated();

        $validated['image_path'] = $this->handleImageUpload($request, $slider->image_path);

        $slider->update($validated);

        return redirect()->route('admin.slider.index', ['category_id' => $validated['category_id']])
            ->with('success', 'Slider đã được cập nhật thành công!');
    }

    protected function handleImageUpload($request, $existingImagePath = null)
    {
        if ($request->hasFile('image_path')) {
            $imagePath = $request->file('image_path')->store('images/sliders', 'public');

            if ($existingImagePath && Storage::disk('public')->exists($existingImagePath)) {
                Storage::disk('public')->delete($existingImagePath);
            }

            return $imagePath;
        }

        return $existingImagePath;
    }

    public function destroy($id)
    {

        $slider = Slider::findOrFail($id);

        DB::transaction(function () use ($slider) {

            $minDeletedPosition = Slider::onlyTrashed()->min('position');

            $slider->position = $minDeletedPosition ? $minDeletedPosition - 1 : -1;

            $slider->save();
            $slider->delete();

            $this->reorderPositions($slider->category_id);
        });

        return redirect()->route('admin.slider.index', ['category_id' => $slider->category_id])
            ->with('success', 'Slider đã được xóa và vị trí đã được cập nhật.');
    }

    protected function reorderPositions($category_id)
    {

        $sliders = Slider::whereNull('deleted_at')
            ->where('category_id', $category_id)
            ->orderBy('position')
            ->get();

        foreach ($sliders as $index => $slider) {
            $slider->position = $index + 1;
            $slider->save();
        }
    }

    public function restore($id)
    {
        $slider = Slider::onlyTrashed()->findOrFail($id);
        $slider->restore();
        $maxPosition = Slider::where('category_id', $slider->category_id)->max('position');
        $slider->position = $maxPosition ? $maxPosition + 1 : 1;
        $slider->save();
        return redirect()->route('admin.slider.index', ['category_id' => "trash"])
            ->with('success', 'Slider đã được khôi phục!');
    }


    public function forceDelete($id)
    {

        $slider = Slider::onlyTrashed()->findOrFail($id);
        $slider->forceDelete();
        // Xóa ảnh trên hệ thống tệp (đảm bảo đường dẫn ảnh đúng)
        $imagePath = storage_path('app/public/' . $slider->image_path); // Đảm bảo đường dẫn chính xác

        if (file_exists($imagePath)) {
            // Xóa file ảnh thực tế
            unlink($imagePath); // Xóa ảnh khỏi hệ thống tệp
        }
        return redirect()->route('admin.slider.index', ['category_id' => 'trash'])
            ->with('success', 'Slider đã bị xóa vĩnh viễn!');
    }

}
