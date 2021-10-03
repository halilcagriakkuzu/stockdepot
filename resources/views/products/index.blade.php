@extends('layouts.app')

@section('title') Malzemeler @endsection

@section('content-title') Malzeme Listesi @endsection

@section('breadcrumb')
    <li class="breadcrumb-item active">Malzemeler</li>
@endsection

@section('css')
    <!-- DataTables -->
    <link rel="stylesheet" href="{{asset('plugins/datatables-bs4/css/dataTables.bootstrap4.min.css')}}">
    <link rel="stylesheet" href="{{asset('plugins/datatables-responsive/css/responsive.bootstrap4.min.css')}}">
    <link rel="stylesheet" href="{{asset('plugins/datatables-buttons/css/buttons.bootstrap4.min.css')}}">
@endsection

@section('content')
<div class="row">
    <p class="alert"></p>
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Sistemde kayıtlı malzemelerin listesi ve işlemleri</h3>
                <div class="float-right">
                    <a type="button" href="{{ route('products.create') }}" class="btn btn-success"><span class="fas fa-plus"></span> Yeni Malzeme Oluştur</a>
                </div>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
                <table id="dt" class="table table-bordered table-hover">
                    <thead>
                        <tr>
                            <th class="excel">Id</th>
                            <th class="printable excel">Kategori</th>
                            <th class="printable excel">Seri No</th>
                            <th class="printable excel">Marka</th>
                            <th class="printable excel">Model</th>
                            <th class="printable excel">Toplam Stok</th>
                            <th class="printable excel">Kullanılabilir Stok</th>
                            <th class="printable excel">Durum</th>
                            <th>#</th>
                        </tr>
                    </thead>
                    <tbody>
                    @foreach ($products as $product)
                        <tr>
                            <td>{{ $product->id }}</td>
                            <td>{{ $product->category->name }}</td>
                            <td>{{ $product->serial_number }}</td>
                            <td>{{ $product->make }}</td>
                            <td>{{ $product->model }}</td>
                            <td>{{ $product->count ?? '--' }}</td>
                            <td>@if(!empty($product->count)) {{ $product->count - $product->unavailable_count }} @else -- @endif</td>
                            <td>
                                <span class="badge badge-{{ $product->productStatus->color }}">
                                    {{ __("productStatuses.".$product->productStatus->name) }}
                                </span>
                            </td>
                            <td>
                                <a type="button" href="{{ route('products.show', ['product' => $product->id]) }}" class="btn btn-primary"><span class="fas fa-search"></span> Malzeme Detayı</a>
                                <a type="button" href="{{ route('products.edit', ['product' => $product]) }}" class="btn btn-warning"><span class="fas fa-edit"></span> Düzenle</a>
                                <form class="d-inline delete" action="{{ action('App\Http\Controllers\ProductController@destroy', ['product' => $product]) }}" method="post">
                                    {{ method_field('DELETE') }}
                                    {!! csrf_field() !!}
                                    <button type="submit" class="btn btn-danger"><span class="fas fa-trash"></span> Sil</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
            <!-- /.card-body -->
        </div>
    </div>
</div>
@endsection

@section('js')
    <!-- DataTables -->
    <script src="{{asset('plugins/datatables/jquery.dataTables.min.js')}}"></script>
    <script src="{{asset('plugins/datatables-bs4/js/dataTables.bootstrap4.min.js')}}"></script>
    <script src="{{asset('plugins/datatables-responsive/js/dataTables.responsive.min.js')}}"></script>
    <script src="{{asset('plugins/datatables-responsive/js/responsive.bootstrap4.min.js')}}"></script>
    <script src="{{asset('plugins/datatables-buttons/js/dataTables.buttons.min.js')}}"></script>
    <script src="{{asset('plugins/datatables-buttons/js/buttons.bootstrap4.min.js')}}"></script>
    <script src="{{asset('plugins/jszip/jszip.min.js')}}"></script>
    <script src="{{asset('plugins/pdfmake/pdfmake.min.js')}}"></script>
    <script src="{{asset('plugins/pdfmake/vfs_fonts.js')}}"></script>
    <script src="{{asset('plugins/datatables-buttons/js/buttons.html5.min.js')}}"></script>
    <script src="{{asset('plugins/datatables-buttons/js/buttons.print.min.js')}}"></script>
    <script src="{{asset('plugins/datatables-buttons/js/buttons.colVis.min.js')}}"></script>

    <script>
        $(".delete").on("submit", function(){
            return confirm("Bu kaydı silmek istediğinden emin misin? Bu ürünleri kullandığımız kiralamalar bundan etkilenecektir!silmek");
        });

        $(function () {
            $("#dt").DataTable({
                "responsive": true,
                "searching": true,
                "ordering": true,
                "paging": true,
                "lengthChange": false,
                "autoWidth": false,
                "info": true,
                language: {
                    url: "{{asset('plugins/datatables/tr.json')}}"
                },
                initComplete: function(){
                    var api = this.api();
                    new $.fn.dataTable.Buttons(api, {
                        buttons: [
                            {
                                extend: 'pdf',
                                text: 'PDF',
                                exportOptions: {
                                    columns: '.printable',
                                },
                                customize: function (doc) {
                                    doc.content[1].table.widths =
                                        Array(doc.content[1].table.body[0].length + 1).join('*').split('');
                                }
                            },
                            {
                                extend: 'excel',
                                text: 'Excel',
                                exportOptions: {
                                    columns: '.excel',
                                }
                            },
                            {
                                extend: 'print',
                                text: 'Sayfayı Yazdır',
                                autoPrint: true,
                                exportOptions: {
                                    columns: '.printable',
                                }
                            }
                        ]
                    });
                    api.buttons().container().appendTo( '#dt_wrapper .col-md-6:eq(0)' );
                }
            })
        });
    </script>
@endsection
