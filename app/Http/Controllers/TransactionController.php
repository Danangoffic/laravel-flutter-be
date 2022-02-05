<?php

namespace App\Http\Controllers;

use App\Http\Requests\TransactionRequest;
use App\Models\Transaction;
use App\Models\TransactionItem;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class TransactionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (request()->ajax()) {
            try {
                $query = Transaction::query();
                return DataTables::of($query)
                    ->addColumn('action', function ($item) {
                        return '
                            <a class="inline-block border border-blue-700 bg-blue-700 text-white rounded-md px-2 py-1 m-1 transition duration-500 ease select-none
                            hover:bg-blue-800 focus:outline-none focus:shadow-outline" href="' . route('dashboard.transaction.show', $item->id) . '">Detail</a>
                            <a class="inline-block border border-green-700 bg-green-700 text-white rounded-md px-2 py-1 m-1 transition duration-500 ease select-none
                            hover:bg-green-800 focus:outline-none focus:shadow-outline" href="' . route('dashboard.transaction.edit', $item->id) . '">Edit</a>
                        ';
                    })
                    ->editColumn('total_price', function ($item) {
                        return 'Rp ' . number_format($item->total_price, 0, ',', '.');
                    })
                    ->editColumn('shipping_price', function ($item) {
                        return 'Rp ' . number_format($item->shipping_price, 0, ',', '.');
                    })
                    ->rawColumns(['action'])
                    ->make();
            } catch (\Throwable $th) {
                //throw $th;
            }
        }
        return view('pages.dashboard.transaction.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Transaction  $transaction
     * @return \Illuminate\Http\Response
     */
    public function show(Transaction $transaction)
    {
        if (request()->ajax()) {
            try {
                $query = TransactionItem::with(['product'])->where('transactions_id', $transaction->id);
                return DataTables::of($query)
                    ->editColumn('price', function ($item) {
                        return 'Rp ' . number_format($item->price, 0, ',', '.');
                    })
                    ->addColumn('total_price', function ($item) {
                        return 'Rp ' . number_format($item->product->price * $item->quantity, 0, ',', '.');
                    })
                    ->make();
            } catch (\Throwable $th) {
                //throw $th;
            }
        }
        // $data = Transaction::with(['user'])->where('id', $transaction->id)->first();
        return view('pages.dashboard.transaction.show', compact('transaction'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Transaction  $transaction
     * @return \Illuminate\Http\Response
     */
    public function edit(Transaction $transaction)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Transaction  $transaction
     * @return \Illuminate\Http\Response
     */
    public function update(TransactionRequest $request, Transaction $transaction)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Transaction  $transaction
     * @return \Illuminate\Http\Response
     */
    public function destroy(Transaction $transaction)
    {
        //
    }
}
