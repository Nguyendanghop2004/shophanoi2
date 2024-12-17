<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreSliderRequest;
use App\Http\Requests\Admin\UpdateSliderRequest;
use App\Models\Category;
use App\Models\Slider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;

class SliderController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');
        $sliders = Slider::with('category')
            ->when($search, function ($query) use ($search) {
                $query->where('title', 'like', "%{$search}%");
            })
            ->orderBy('position', 'asc')
            ->paginate(10);
        return view('admin.slider.index', compact('sliders', 'search'));



    }

    public function updateOrder(Request $request)
    {
        $order = $request->input('order');

        if (!$order) {
            return response()->json(['message' => 'Dữ liệu không hợp lệ'], 400);
        }
        DB::transaction(function () use ($order) {

            Slider::query()->update(['position' => null]);
            foreach ($order as $position => $id) {
                Slider::where('id', $id)
                    ->update(['position' => $position + 1]);
            }
        });

        return response()->json(['message' => 'Cập nhật thứ tự thành công!']);
    }


    public function create()
    {
        return view('admin.slider.create');
    }

    public function store(StoreSliderRequest $request)
    {
        $validated = $request->validated();

        $validated['image_path'] = $this->handleImageUpload($request);

        $maxPosition = Slider::max('position');
        $validated['position'] = $maxPosition ? $maxPosition + 1 : 1;

        Slider::create($validated);

        return redirect()->route('admin.slider.index')
            ->with('success', 'Slider đã được tạo thành công!');
    }

    public function edit($id)
    {
        $slider = Slider::findOrFail($id);
        return view('admin.slider.edit', compact('slider'));
    }

    public function update(UpdateSliderRequest $request, $id)
    {
        $slider = Slider::findOrFail($id);
        $validated = $request->validated();

        $validated['image_path'] = $this->handleImageUpload($request, $slider->image_path);

        $slider->update($validated);

        return redirect()->route('admin.slider.index')
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

        return redirect()->route('admin.slider.index')
            ->with('success', 'Slider đã được xóa và vị trí đã được cập nhật.');
    }

    protected function reorderPositions($category_id)
    {

        $sliders = Slider::whereNull('deleted_at')
            ->orderBy('position')
            ->get();

        foreach ($sliders as $index => $slider) {
            $slider->position = $index + 1;
            $slider->save();
        }
    }
    public function trash(Request $request)
    {
        $search = $request->input('search');

        $sliders = Slider::onlyTrashed()
            ->when($search, function ($query) use ($search) {
                $query->where('title', 'like', "%{$search}%");
            })
            ->paginate(10);
        return view('admin.slider.trash', compact('sliders', 'search'));

    }
    public function restore($id)
    {
        $slider = Slider::onlyTrashed()->findOrFail($id);
        $slider->restore();
        $maxPosition = Slider::max('position');
        $slider->position = $maxPosition ? $maxPosition + 1 : 1;
        $slider->save();
        return redirect()->route('admin.slider.index')
            ->with('success', 'Slider đã được khôi phục!');
    }


    public function forceDelete($id)
    {
        $slider = Slider::onlyTrashed()->findOrFail($id);

        if ($slider->image_path) {
            Storage::disk('public')->delete($slider->image_path);
        }

        $slider->forceDelete();

        return redirect()->route('admin.slider.index')
            ->with('success', 'Slider đã bị xóa vĩnh viễn!');
    }

}
