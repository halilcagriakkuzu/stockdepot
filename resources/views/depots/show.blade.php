@extends('layouts.app')

@section('title')
    @if(!empty($depot))
        {{ $depot->name }}
    @else
        Ölçü/Bakım
    @endif
@endsection

@section('content-title')
    @if(!empty($depot))
        {{ $depot->name }}
    @else
        Ölçü/Bakım
    @endif
@endsection

@section('breadcrumb')
    <li class="breadcrumb-item active"> @if(!empty($depot)) {{ $depot->name }} @else Ölçü/Bakım @endif Malzeme Listesi</li>
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
                <h3 class="card-title">Sistemde kayıtlı @if(!empty($depot)) {{ $depot->name }} @else Ölçü/Bakım @endif malzemeleri</h3>
                @if(!empty($depot))
                    <div class="float-right">
                        <a type="button" href="{{ route('products.create') }}" class="btn btn-success"><span class="fas fa-plus"></span> Yeni Malzeme Oluştur</a>
                        <a type="button" href="{{ route('products.create') }}" class="btn btn-success"><span class="fas fa-plus"></span> Yeni Kiralama Oluştur</a>
                    </div>
                @endif
            </div>
            <!-- /.card-header -->
            <div class="card-body">
                <table id="dt" class="table table-bordered table-hover">
                    <thead>
                    <tr>
                        <th class="excel printable">Seri No</th>
                        <th class="excel printable">Kategori</th>
                        <th class="excel printable">Marka</th>
                        <th class="excel printable">Model</th>
                        <th class="excel printable">Bakımdaki Adet</th>
                        <th>#</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach ($products as $product)
                        <tr>
                            <td>{{ $product->serial_number }}</td>
                            <td>{{ $product->category->name }}</td>
                            <td>{{ $product->make }}</td>
                            <td>{{ $product->model }}</td>
                            <td>{{ $product->maintenance_count ?? '--' }}</td>
                            <td>
                                <a type="button" href="{{ route('products.show', ['product' => $product->id]) }}" class="btn btn-primary"><span class="fas fa-search"></span> Malzeme Detayı</a>
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
