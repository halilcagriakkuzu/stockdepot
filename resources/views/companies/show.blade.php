@extends('layouts.app')

@section('title') Firma Detayı {{ $company->name ?? '' }} @endsection

@section('content-title') Firma Detayı @endsection

@section('breadcrumb')
    <li class="breadcrumb-item active">Firma Detayı {{ $company->name ?? '' }}</li>
@endsection

@section('css')
    <!-- DataTables -->
    <link rel="stylesheet" href="{{asset('plugins/datatables-bs4/css/dataTables.bootstrap4.min.css')}}">
    <link rel="stylesheet" href="{{asset('plugins/datatables-responsive/css/responsive.bootstrap4.min.css')}}">
    <link rel="stylesheet" href="{{asset('plugins/datatables-buttons/css/buttons.bootstrap4.min.css')}}">
@endsection

@section('content')
<div class="row">
    <div class="col-md-3">

        <!-- Profile Image -->
        <div class="card card-primary card-outline">
            <div class="card-body box-profile">
                <h3 class="profile-username text-center">{{ $company->name ?? '' }}</h3>

                <ul class="list-group list-group-unbordered mb-3">
                    <li class="list-group-item">
                        <b>Oluşturan</b>
                        <a class="float-right">{{ $company->createdBy->name }}</a>
                    </li>
                    <li class="list-group-item">
                        <b>Durum</b>
                        <a class="float-right">
                            @if($company->is_active)
                                <span class="badge badge-success">Aktif</span>
                            @else
                                <span class="badge badge-danger">Pasif</span>
                            @endif
                        </a>
                    </li>
                </ul>

                <a type="button" href="{{ route('rentForms.create') }}" class="btn btn-block btn-info"><span class="fas fa-plus"></span> Kiralama Oluştur</a>
                <a type="button" href="{{ route('companies.edit', ['company' => $company]) }}" class="btn btn-block btn-warning"><span class="fas fa-pencil-alt"></span> Düzenle</a>
            </div>
            <!-- /.card-body -->
        </div>
        <!-- /.card -->
    </div>
    <!-- /.col -->
    <div class="col-md-9">
        <div class="card">
            <div class="card-body">
                <h2>Kiralamalar <small class="text-muted">(En son kiralama en üstte)</small></h2>
                <table class="table table-striped">
                    <thead>
                        <th>Id</th>
                        <th>Muhatap</th>
                        <th>Durum</th>
                        <th>Formu Oluşturan</th>
                        <th>Kiralama Tarihi</th>
                    </thead>
                    <tbody>
                    @foreach($rentForms as $rentForm)
                        <tr>
                            <td>{{ $rentForm->id }}</td>
                            <td>{{ $rentForm->interlocutor_name }}</td>
                            <td>
                            <span class="badge badge-{{ $rentForm->rentFormStatus->color }}">
                                    {{ __("rentFormStatuses.".$rentForm->rentFormStatus->name) }}
                                </span>
                            </td>
                            <td>{{ $rentForm->createdBy->name }}</td>
                            <td>{{ $rentForm->created_at->format('d/m/Y H:i') }}</td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        <!-- /.card -->
    </div>
    <!-- /.col -->
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
            $('#dt').DataTable({
                language: {
                    url: "{{asset('plugins/datatables/tr.json')}}"
                },
                "paging": true,
                "lengthChange": false,
                "searching": true,
                "ordering": true,
                "info": true,
                "autoWidth": false,
                "responsive": true,
            });
        });
    </script>
@endsection
