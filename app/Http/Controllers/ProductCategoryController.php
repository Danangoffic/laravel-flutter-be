<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProductCategoryRequest;
use App\Models\Product;
use App\Models\ProductCategory;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class ProductCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $query = ProductCategory::query();

            return DataTables::of($query)
                ->addColumn('action', function ($item) {
                    return '<a class="inline-block border border-blue-700 bg-blue-700 text-white rounded-md px-2 py-1 m-1 transition duration-500 ease select-none
                        hover:bg-blue-800 focus:outline-none focus:shadow-outline" href="' . route('dashboard.category.edit', $item->id) . '">Edit</a>
                        <a class="inline-block border border-emerald-700 bg-emerald-700 text-white rounded-md px-2 py-1 m-1 transition duration-500 ease select-none
                        hover:bg-emerald-800 focus:outline-none focus:shadow-outline" href="' . route('dashboard.category.show', $item->id) . '">Products</a>
                        <form class="inline-block" action="' . route('dashboard.category.destroy', $item->id) . '" method="POST">
                        ' . csrf_field() . method_field('DELETE') . '
                        <button class="inline-block border border-gray-300 bg-gray-300 text-gray-700 rounded-md px-2 py-1 m-1 transition duration-500 ease select-none
                        hover:bg-gray-500 hover:text-gray-200 focus:outline-none focus:shadow-outline" type="submit">Delete</button>
                        </form>
                        ';
                })
                ->rawColumns(['action'])
                ->make();
        }
        return view('pages.dashboard.category.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('pages.dashboard.category.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ProductCategoryRequest $request)
    {
        ProductCategory::create([
            'name' => $request->name
        ]);
        return redirect()->route('dashboard.category.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\ProductCategory  $category
     * @return \Illuminate\Http\Response
     */
    public function show(ProductCategory $category)
    {
        if (request()->ajax()) {
            $query = Product::with(['category'])->where('categories_id', $category->id)->get();

            return DataTables::of($query)
                ->addColumn('action', function ($item) {
                    return '<a class="inline-block border border-blue-700 bg-blue-700 text-white rounded-md px-2 py-1 m-1 transition duration-500 ease select-none
                        hover:bg-blue-800 focus:outline-none focus:shadow-outline" href="' . route('dashboard.product.edit', $item->id) . '">Edit</a>
                        <a class="inline-block border border-green-700 bg-green-700 text-white rounded-md px-2 py-1 m-1 transition duration-500 ease select-none
                        hover:bg-green-800 focus:outline-none focus:shadow-outline" href="' . route('dashboard.product.gallery.index', $item->id) . '">Gallery</a>
                        <form class="inline-block" action="' . route('dashboard.product.destroy', $item->id) . '" method="POST">
                        ' . csrf_field() . method_field('DELETE') . '
                        <button class="inline-block border border-gray-300 bg-gray-300 text-gray-700 rounded-md px-2 py-1 m-1 transition duration-500 ease select-none
                        hover:bg-gray-500 hover:text-gray-200 focus:outline-none focus:shadow-outline" type="submit">Delete</button>
                        </form>
                        ';
                })
                ->editColumn('price', function ($item) {
                    return 'Rp ' . number_format($item->price, 0, ',', '.');
                })
                ->rawColumns(['action'])
                ->make();
        }
        return view('pages.dashboard.category.show', compact('category'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\ProductCategory  $category
     * @return \Illuminate\Http\Response
     */
    public function edit(ProductCategory $category)
    {
        return view('pages.dashboard.category.edit', ['category' => $category]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\ProductCategory  $category
     * @return \Illuminate\Http\Response
     */
    public function update(ProductCategoryRequest $request, ProductCategory $category)
    {
        $data = $request->all();
        $category['name'] = $data['name'];

        $category->update($data);
        return redirect()->route('dashboard.category.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\ProductCategory  $category
     * @return \Illuminate\Http\Response
     */
    public function destroy(ProductCategory $category)
    {
        $category->delete();
        return redirect()->route('dashboard.category.index');
    }
}
