<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProductRequest;
use App\Models\Product;
use App\Models\ProductCategory;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $query = Product::with(['category'])->get();

            return DataTables::of($query)
                ->addColumn('category', function ($item) {
                    return $item->category->name;
                })
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
        return view('pages.dashboard.product.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $productCategory = ProductCategory::all();
        return view('pages.dashboard.product.create', ['category' => $productCategory]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ProductRequest $request)
    {
        Product::create($request->all());
        return redirect()->route('dashboard.product.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function show(Product $product)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function edit(Product $product)
    {
        $category = ProductCategory::all();
        return view('pages.dashboard.product.edit', ['product' => $product, 'category' => $category]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function update(ProductRequest $request, Product $product)
    {
        $product->update($request->all());
        return redirect()->route('dashboard.product.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product)
    {
        $product->delete();
        return redirect()->route('dashboard.product.index');
    }
}
