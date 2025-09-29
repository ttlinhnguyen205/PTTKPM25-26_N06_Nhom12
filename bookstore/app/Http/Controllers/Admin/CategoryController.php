<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::all();
        return view('admin.categories.index', compact('categories'));
    }

    public function create()
    {
        return view('admin.categories.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        // Tạo slug từ tên (name)
        $slug = Str::slug($request->name);

        // Kiểm tra xem slug có bị trùng không
        if (Category::where('slug', $slug)->exists()) {
            $slug = $slug . '-' . Str::random(5); 
        }

        Category::create([
            'name' => $request->name,
            'slug' => $slug
        ]);

        return redirect()->route('admin.categories.index')->with('success', 'Thêm danh mục thành công');
    }

    public function edit($id)
    {
        $category = Category::findOrFail($id);
        return view('admin.categories.edit', compact('category'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $category = Category::findOrFail($id);
        $slug = Str::slug($request->name);

        if (Category::where('slug', $slug)->where('id', '!=', $id)->exists()) {
            $slug = $slug . '-' . Str::random(5); 
        }

        $category->update([
            'name' => $request->name,
            'slug' => $slug
        ]);

        return redirect()->route('admin.categories.index')->with('success', 'Cập nhật danh mục thành công');
    }

    public function destroy($id)
    {
        Category::destroy($id);

        return redirect()->route('admin.categories.index')->with('success', 'Xóa danh mục thành công');
    }
}
