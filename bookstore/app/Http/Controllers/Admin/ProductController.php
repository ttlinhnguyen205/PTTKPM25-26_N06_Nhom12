<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $query = Product::with('category');

        if ($search = trim($request->input('q'))) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                ->orWhere('author', 'like', "%{$search}%")
                ->orWhere('publisher', 'like', "%{$search}%")
                ->orWhereHas('category', function ($cq) use ($search) {
                    $cq->where('name', 'like', "%{$search}%");
                });
            });
        }

        if ($categoryId = $request->input('category_id')) {
            $query->where('category_id', $categoryId);
        }

        if ($request->filled('price_min')) {
            $query->where('price', '>=', (float) $request->price_min);
        }
        if ($request->filled('price_max')) {
            $query->where('price', '<=', (float) $request->price_max);
        }

        if ($request->filled('year_from')) {
            $query->where('year_of_publication', '>=', (int) $request->year_from);
        }
        if ($request->filled('year_to')) {
            $query->where('year_of_publication', '<=', (int) $request->year_to);
        }

        $sort = $request->input('sort', 'latest');
        switch ($sort) {
            case 'price_asc':  $query->orderBy('price', 'asc'); break;
            case 'price_desc': $query->orderBy('price', 'desc'); break;
            case 'qty_asc':    $query->orderBy('quantity', 'asc'); break;
            case 'qty_desc':   $query->orderBy('quantity', 'desc'); break;
            case 'oldest':     $query->orderBy('id', 'asc'); break;
            default:           $query->latest(); break; 
        }

        $perPage = (int) $request->input('per_page', 10);
        if (! in_array($perPage, [10, 20, 50, 100], true)) {
            $perPage = 10;
        }

        $products   = $query->paginate($perPage)->withQueryString(); 
        $categories = Category::orderBy('name')->get();

        return view('admin.products.index', compact('products', 'categories', 'sort'));
    }

    public function show($id)
    {
        $product = Product::with('category')->findOrFail($id);
        return view('admin.products.show', compact('product'));
    }

    public function create()
    {
        $categories = Category::all();
        return view('admin.products.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'id'          => 'nullable|integer|min:1|unique:products,id', 
            'name'        => 'required|string|max:255',
            'price'       => 'required|numeric|min:0',
            'quantity'    => 'required|integer|min:0',
            'category_id' => 'required|exists:categories,id',
            'image'       => 'nullable|image|mimes:jpg,jpeg,png,webp|max:4096',
        ]);

        $data = $request->except(['image','id']);
        $product = new Product($data);

        if ($request->filled('id')) {
            $product->id = (int) $request->id;
        }

        if ($request->hasFile('image')) {
            if (! File::exists(public_path('images/book'))) {
                File::makeDirectory(public_path('images/book'), 0755, true);
            }
            $file     = $request->file('image');
            $filename = time().'_'.$file->getClientOriginalName();
            $file->move(public_path('images/book'), $filename);
            $product->image = 'images/book/'.$filename;
        }

        $product->save();

        return redirect()->route('admin.products.index')
                         ->with('success', 'Thêm sản phẩm thành công');
    }

    public function edit($id)
    {
        $product    = Product::findOrFail($id);
        $categories = Category::all();
        return view('admin.products.edit', compact('product', 'categories'));
    }

    public function update(Request $request, $id)
    {
        $product = Product::findOrFail($id);

        $request->validate([
            'name'        => 'required|string|max:255',
            'price'       => 'required|numeric|min:0',
            'quantity'    => 'required|integer|min:0',
            'category_id' => 'required|exists:categories,id',
            'image'       => 'nullable|image|mimes:jpg,jpeg,png,webp|max:4096',
        ]);

        $data = $request->except(['image','id']);

        if ($request->hasFile('image')) {
            if (! File::exists(public_path('images/book'))) {
                File::makeDirectory(public_path('images/book'), 0755, true);
            }
            if (!empty($product->image) && File::exists(public_path($product->image))) {
                File::delete(public_path($product->image));
            }
            $file     = $request->file('image');
            $filename = time().'_'.$file->getClientOriginalName();
            $file->move(public_path('images/book'), $filename);
            $data['image'] = 'images/book/'.$filename;
        }

        $product->update($data);

        return redirect()->route('admin.products.index')
                         ->with('success', 'Cập nhật sản phẩm thành công');
    }

    public function destroy($id)
    {
        $product = Product::findOrFail($id);

        if (!empty($product->image) && File::exists(public_path($product->image))) {
            File::delete(public_path($product->image));
        }

        $product->delete();

        return redirect()->route('admin.products.index')
                         ->with('success', 'Xóa sản phẩm thành công');
    }
}
