@extends('layouts.app')

@section('title') Kiralama Formları @endsection

@section('content-title') Kiralama Formları Listesi @endsection

@section('breadcrumb')
    <li class="breadcrumb-item active">Kiralama Formları</li>
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
                <h3 class="card-title">Sistemde kayıtlı kiralama formları listesi ve işlemleri</h3>
                <div class="float-right">
                    <a type="button" href="{{ route('rentForms.create') }}" class="btn btn-success"><span class="fas fa-plus"></span> Yeni Kiralama Formu Oluştur</a>
                </div>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
                <table id="dt" class="table table-bordered table-striped table-hover">
                    <thead>
                        <tr>
                            <th class="excel">Id</th>
                            <th class="printable excel">Firma</th>
                            <th class="printable excel">Muhatap</th>
                            <th class="printable excel">Oluşturulma Tarihi</th>
                            <th class="printable excel">Oluşturan</th>
                            <th class="printable excel">Durum</th>
                            <th>#</th>
                        </tr>
                    </thead>
                    <tbody>
                    @foreach ($rentForms as $rentForm)
                        <tr>
                            <td>{{ $rentForm->id }}</td>
                            <td>{{ $rentForm->company->name }}</td>
                            <td>{{ $rentForm->interlocutor_name }}</td>
                            <td>{{ $rentForm->created_at->format('d/m/Y H:i') }}</td>
                            <td>{{ $rentForm->createdBy->name }}</td>
                            <td>
                                <span class="badge badge-{{ $rentForm->rentFormStatus->color }}">
                                    {{ __("rentFormStatuses.".$rentForm->rentFormStatus->name) }}
                                </span>
                            </td>
                            <td>
                                @if($rentForm->rentFormStatus->name == 'DRAFT')
                                <a type="button" href="{{ route('rentForms.edit', ['rentForm' => $rentForm->id, 'active' => 'false']) }}" class="btn btn-warning"><span class="fas fa-pencil-alt"></span> Form Düzenle</a>
                                @else
                                <a type="button" href="{{ route('rentForms.show', ['rentForm' => $rentForm->id]) }}" class="btn btn-primary"><span class="fas fa-search"></span> Form Detayı</a>
                                @endif
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
