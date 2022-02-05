<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            <a href="{{ route('dashboard.transaction.index') }}">Transactions</a> &raquo; Detail
            {{ $transaction->id }}
        </h2>
    </x-slot>

    <x-slot name="script">
        <script>
            var dataTable = $("#crudTables").DataTable({
                ajax: {
                    url: "{!! url()->current() !!}"
                },
                columns: [{
                        data: 'id',
                        name: 'id',
                        width: '5%',
                        className: 'text-center'
                    },
                    {
                        data: 'product.name',
                        name: 'product.name'
                    },
                    {
                        data: 'product.price',
                        name: 'product.price',
                        className: 'font-bold text-right'
                    },
                    {
                        data: 'quantity',
                        name: 'quantity',
                        className: 'font-bold text-center'
                    },
                    {
                        data: 'total_price',
                        name: 'total_price',
                        className: 'font-bold text-right'
                    }
                ]
            });
        </script>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 mb-10">
            <div class="shadow overflow-hidden sm:rounded-sm">
                <div class="px-4 py-5 bg-white sm:p-6">
                    <h1 class="font-bold text-xl mb-5">Detail Transaction</h1>
                    <table id="my-trx-table" class="w-full table-auto border-collapse">
                        <tbody>
                            <tr class="border-b border-gray-400">
                                <td class="font-bold">Nama Pembeli</td>
                                <td>{{ $transaction->user->name }}</td>
                            </tr>
                            <tr class="border-b border-gray-400">
                                <td class="font-bold">Alamat Pembeli</td>
                                <td>{{ $transaction->address }}</td>
                            </tr>
                            <tr class="border-b border-gray-400">
                                <td class="font-bold">Total Harga</td>
                                <td>{{ 'Rp ' . number_format($transaction->total_price, 0, ',', '.') }}</td>
                            </tr>
                            <tr class="border-b border-gray-400">
                                <td class="font-bold">Total Shipping</td>
                                <td>{{ 'Rp ' . number_format($transaction->shipping_price, 0, ',', '.') }}</td>
                            </tr>
                            <tr class="border-b border-gray-400">
                                <td class="font-bold">Jenis Pembayaran</td>
                                <td>{{ $transaction->payment }}</td>
                            </tr>
                            <tr class="border-b border-gray-400">
                                <td class="font-bold">Status</td>
                                <td>
                                    <span
                                        class="px-2 rounded {{ $transaction->status == 'SUCCESS' ? 'bg-green-700 text-white' : 'bg-slate-700 text-white' }}">{{ $transaction->status }}</span>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="shadow overflow-hidden sm:rounded-sm">
                <div class="px-4 py-5 bg-white sm:p-6">
                    <h1 class="font-bold text-xl mb-5">Product Items</h1>
                    <table id="crudTables" class="w-full table-auto">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Produk</th>
                                <th>Price</th>
                                <th>Quantity</th>
                                <th>Total Price</th>
                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
