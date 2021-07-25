@extends('layouts.app')

@section('title') Malzeme Detayı {{ $product->make }} {{ $product->model }} @endsection

@section('content-title') Malzeme Detayı @endsection

@section('breadcrumb')
    <li class="breadcrumb-item active">Malzeme Detayı {{ $product->make }} {{ $product->model }}</li>
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
                <h3 class="profile-username text-center">{{ $product->make ?? '' }} {{ $product->model ?? '' }}</h3>
                <p class="text-muted text-center">{{ $product->category->name }} / {{ $product->category->depot->name }}</p>

                <ul class="list-group list-group-unbordered mb-3">
                    @if(!empty($product->count))
                        <li class="list-group-item">
                            <b>Toplam Stok Adedi</b> <a class="float-right">{{ $product->count }}</a>
                        </li>
                        <li class="list-group-item">
                            <b>Ölçü/Bakımdaki</b> <a class="float-right">{{ $product->maintenance_count }}</a>
                        </li>
                        <li class="list-group-item">
                            <b>Kullanılabilir</b> <a class="float-right">{{ $product->count - $product->unavailable_count }}</a>
                        </li>
                    @endif
                    @if(!empty($product->serial_number))
                        <li class="list-group-item">
                            <b>Seri Numarası</b> <a class="float-right">{{ $product->serial_number }}</a>
                        </li>
                    @endif
                    <li class="list-group-item">
                        <b>Satın Alınma Tarihi</b> <a class="float-right">{{ $product->buy_date ?? '' }}</a>
                    </li>
                    <li class="list-group-item">
                        <b>Satın Alınma Fiyatı</b> <a class="float-right">{{ $product->buy_price ?? '' }} ₺</a>
                    </li>
                    <li class="list-group-item">
                        <b>Raf No</b> <a class="float-right">{{ $product->shelf_no ?? '' }}</a>
                    </li>
                    <li class="list-group-item">
                        <b>Satır No</b> <a class="float-right">{{ $product->row_no ?? '' }}</a>
                    </li>
                    <li class="list-group-item">
                        <b>Durum</b>
                        <a class="float-right">
                            <span class="badge badge-{{ $product->productStatus->color }}">
                                {{ __("productStatuses.".$product->productStatus->name) }}
                            </span>
                        </a>
                    </li>
                    <li class="list-group-item">
                        <p>
                            {{ $product->description ?? '' }}
                        </p>
                    </li>
                </ul>
                @if($product->productStatus->name == 'IN_DEPOT' || $product->productStatus->name == 'RENTED')
                    <a type="button" href="{{ route('productStatus.changeProductStatus', ['id' => $product->id, 'status' => 'IN_MAINTENANCE']) }}" class="btn btn-block btn-info"><span class="fas fa-tools"></span> Ölçü Bakıma Gönder</a>
                @endif
                @if($product->productStatus->name == 'IN_MAINTENANCE' || $product->maintenance_count > 0)
                    <a type="button" href="{{ route('productStatus.changeProductStatus', ['id' => $product->id, 'status' => 'IN_DEPOT']) }}" class="btn btn-block btn-success"><span class="fas fa-warehouse"></span> Depoya Gönder</a>
                @endif
                @if($product->productStatus->name == 'IN_DEPOT' || $product->productStatus->name == 'RENTED' || $product->productStatus->name == 'IN_MAINTENANCE')
                    <a type="button" href="{{ route('productStatus.changeProductStatus', ['id' => $product->id, 'status' => 'DISABLED']) }}" class="btn btn-block btn-danger"><span class="fas fa-trash"></span> Hizmet Dışı Yap</a>
                @endif
                <a type="button" href="{{ route('products.edit', ['product' => $product]) }}" class="btn btn-block btn-warning"><span class="fas fa-edit"></span> Düzenle</a>
            </div>
            <!-- /.card-body -->
        </div>
        <!-- /.card -->
    </div>
    <!-- /.col -->
    <div class="col-md-9">
        <div class="card">
            <div class="card-body">
                <h2>Malzeme Hareketleri <small class="text-muted">(En son aksiyon en üstte)</small></h2>
                <table class="table table-striped">
                    <thead>
                        <th>Aksiyon</th>
                        <th>Adet</th>
                        <th>Açıklama</th>
                        <th>Kiralama Formu</th>
                        <th>Tarih/Saat</th>
                        <th>Kullanıcı</th>
                    </thead>
                    <tbody>
                    @foreach($transactions as $transaction)
                        <tr>
                            <td>{{ __("actions.".$transaction->action->type) }}</td>
                            <td>{{ $transaction->count ?? 1}}</td>
                            <td>{{ $transaction->description }}</td>
                            <td>
                                @if(!empty($transaction->rentForm))
                                    @if($transaction->rentForm->rentFormStatus->name == 'ACTIVE')
                                        <a href="{{ route('rentForms.show', ['rentForm' => $transaction->rentForm->id]) }}">
                                            {{ $transaction->rentForm->company->name }}#{{ $transaction->rentForm->id }}
                                        </a>
                                    @else
                                        <a href="{{ route('rentForms.edit', ['rentForm' => $transaction->rentForm->id]) }}">
                                            {{ $transaction->rentForm->company->name }}#{{ $transaction->rentForm->id }}
                                        </a>
                                    @endif
                                @else
                                    --
                                @endif
                            </td>
                            <td>{{ $transaction->created_at->format('d/m/Y H:i') }}</td>
                            <td>{{ $transaction->createdBy->name }}</td>
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
