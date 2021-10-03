@extends('layouts.app')

@section('title') Firmalar @endsection

@section('content-title') Firma Listesi @endsection

@section('breadcrumb')
    <li class="breadcrumb-item active">Firmalar</li>
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
                <h3 class="card-title">Sistemde kayıtlı firmaların listesi ve işlemleri</h3>
                <div class="float-right">
                    <a type="button" href="{{ route('companies.create') }}" class="btn btn-success"><span class="fas fa-plus"></span> Yeni Firma Oluştur</a>
                </div>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
                <table id="dt" class="table table-bordered table-hover">
                    <thead>
                        <tr>
                            <th class="excel">Id</th>
                            <th class="printable excel">İsim</th>
                            <th class="printable excel">Durum</th>
                            <th>#</th>
                        </tr>
                    </thead>
                    <tbody>
                    @foreach ($companies as $company)
                        <tr>
                            <td>{{ $company->id }}</td>
                            <td>{{ $company->name }}</td>
                            <td>
                                @if(!empty($company->is_active) && $company->is_active == true)
                                    <span class="badge badge-success">Aktif</span>
                                @else
                                    <span class="badge badge-danger">Pasif</span>
                                @endif
                            </td>
                            <td>
                                <a type="button" href="{{ route('companies.show', ['company' => $company]) }}" class="btn btn-primary"><span class="fas fa-search"></span> Firma Detayı</a>
                                <a type="button" href="{{ route('companies.edit', ['company' => $company]) }}" class="btn btn-warning"><span class="fas fa-edit"></span> Düzenle</a>
                                <form class="d-inline delete" action="{{ action('App\Http\Controllers\CompanyController@destroy', ['company' => $company]) }}" method="post">
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
            return confirm("Bu kaydı silmek istediğinden emin misin? Varsa bu firmaya bağlı kiralamalar bundan etkilenecektir!");
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
