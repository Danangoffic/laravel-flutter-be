<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProductGalleryRequest;
use App\Models\Product;
use App\Models\ProductGallery;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Yajra\DataTables\Facades\DataTables;

class ProductGalleryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Product $product)
    {
        if (request()->ajax()) {
            try {
                $query = ProductGallery::where('products_id', $product->id);
                return DataTables::of($query)
                    ->addColumn('action', function ($item) {
                        return '
                            <form class="inline-block" action="' . route('dashboard.gallery.destroy', $item->id) . '" method="POST">
                            ' . csrf_field() . method_field('DELETE') . '
                                <button title="Delete ' . $item->name . '" class="bg-red-500 hover:bg-red-700 text-white font-bold py-1 px-2 rounded shadow-lg mr-2" type="submit">Delete</button>
                            </form>
                        ';
                    })
                    ->editColumn('url', function ($item) {
                        return '<img style="max-width: 150px;" src="' . Storage::url($item->url) . '">';
                    })
                    ->editColumn('featured', function ($item) {
                        return $item->is_featured ? 'Yes' : 'No';
                    })
                    ->rawColumns(['action', 'url'])
                    ->make();
            } catch (\Throwable $th) {
                //throw $th;
                Log::error("error with : " . $th->getMessage() . " code " . $th->getCode());
            }
        }
        return view('pages.dashboard.gallery.index', compact('product'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Product $product)
    {
        return view('pages.dashboard.gallery.create', compact('product'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ProductGalleryRequest $request, Product $product)
    {
        $files = $request->file('files');
        if ($request->hasFile('files')) {

            foreach ($files as $file) {
                $path = $file->store('public/gallery');

                ProductGallery::create([
                    'products_id' => $product->id,
                    'url' => $path
                ]);
            }
        }

        return redirect()->route('dashboard.product.gallery.index', $product->id)
            ->with('status', 'success upload photos');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\ProductGallery  $productGallery
     * @return \Illuminate\Http\Response
     */
    public function show(ProductGallery $productGallery)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\ProductGallery  $productGallery
     * @return \Illuminate\Http\Response
     */
    public function edit(ProductGallery $productGallery)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\ProductGallery  $productGallery
     * @return \Illuminate\Http\Response
     */
    public function update(ProductGalleryRequest $request, ProductGallery $productGallery)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\ProductGallery  $gallery
     * @return \Illuminate\Http\Response
     */
    public function destroy(ProductGallery $gallery)
    {
        if (Storage::url($gallery->url)) Storage::delete($gallery->url);
        $gallery->delete();

        return redirect()->route('dashboard.product.gallery.index', $gallery->products_id)->with('status', 'success delete photo');
    }
}
