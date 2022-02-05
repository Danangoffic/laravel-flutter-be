<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            <a href="{{ route('dashboard.product.index') }}">{{ __('Product') }}</a> &raquo; {{ $product->name }}
            &raquo; Gallery
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
                        width: '5%'
                    },
                    {
                        data: 'url',
                        name: 'url'
                    },
                    {
                        data: 'featured',
                        name: 'featured',
                        className: 'font-bold text-center'
                    },
                    {
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
            <div class="mb-10">
                <a href="{{ route('dashboard.product.gallery.create', $product->id) }}"
                    class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded shadow-lg ml-2 sm:ml-0">
                    + Upload Photos
                </a>
            </div>
            <div class="shadow overflow-hidden sm:rounded-sm">
                <div class="px-4 py-5 bg-white sm:p-6">
                    <table id="crudTables" class="w-full table-auto">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Photo</th>
                                <th>Featured</th>
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
