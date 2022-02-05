<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Transactions') }}
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
                        data: 'address',
                        name: 'address'
                    },
                    {
                        data: 'total_price',
                        name: 'total_price',
                        className: 'font-bold text-right'
                    },
                    {
                        data: 'shipping_price',
                        name: 'shipping_price',
                        className: 'font-bold text-right'
                    },
                    {
                        data: 'status',
                        name: 'status',
                        className: 'text-center'
                    }, {
                        data: 'action',
                        name: 'action',
                        orderable: false,
                        searchable: false,
                        width: '25%',
                        className: 'text-center'
                    }
                ]
            });
        </script>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <div class="shadow overflow-hidden sm:rounded-sm">
                <div class="px-4 py-5 bg-white sm:p-6">
                    <table id="crudTables" class="w-full table-auto">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Address</th>
                                <th>Total Price</th>
                                <th>Shipping Price</th>
                                <th>Status</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
