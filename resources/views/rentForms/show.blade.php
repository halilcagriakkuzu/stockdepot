@extends('layouts.app')

@section('title')
    #{{ $rentForm->id }} Kiralama Formu Detayları
@endsection

@section('content-title')
    #{{ $rentForm->id }} {{ $rentForm->company->name }} Detayları
@endsection

@section('breadcrumb')
    <li class="breadcrumb-item active">Kiralama Formu Detayları #{{ $rentForm->id }}</li>
@endsection

@section('css')
    <!-- DataTables -->
    <link rel="stylesheet" href="{{asset('plugins/datatables-bs4/css/dataTables.bootstrap4.min.css')}}">
    <link rel="stylesheet" href="{{asset('plugins/datatables-responsive/css/responsive.bootstrap4.min.css')}}">
    <link rel="stylesheet" href="{{asset('plugins/datatables-buttons/css/buttons.bootstrap4.min.css')}}">
@endsection

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">#{{ $rentForm->id }} {{ $rentForm->company->name }} kiralama formunun detayları</h3>
                            <div class="float-right">
                                @if($rentForm->rentFormStatus->name == 'ACTIVE')
                                    <a type="button" href="#" class="btn btn-info"><span class="fas fa-check"></span> Tamamlandı Olarak İşaretle</a>
                                @endif
                                <a class="btn btn-success" href="#" type="button"><span class="fas fa-pdf"></span> PDF Çıktı Al</a>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-12 col-md-5 mx-auto">
                                    <div class="card card-primary card-outline">
                                        <div class="card-body box-profile">
                                            <h3 class="profile-username text-center">{{ $rentForm->company->name ?? '' }}</h3>
                                            <ul class="list-group list-group-unbordered mb-3">
                                                <li class="list-group-item">
                                                    <b>Oluşturulma Tarihi / Oluşturan</b> <a class="float-right">{{ $rentForm->created_at->format('d/m/Y H:i') }} / {{ $rentForm->createdBy->name }}</a>
                                                </li>
                                                @if(!empty($rentForm->updated_at) && !empty($rentForm->updatedBy))
                                                    <li class="list-group-item">
                                                        <b>Düzenlenme Tarihi / Düzenleyen</b> <a class="float-right">{{ $rentForm->updated_at->format('d/m/Y H:i') }} / {{ $rentForm->updatedBy->name }}</a>
                                                    </li>
                                                @endif
                                                <li class="list-group-item">
                                                    <b>Muhatap İsmi</b> <a class="float-right">{{ $rentForm->interlocutor_name ?? '' }}</a>
                                                </li>
                                                <li class="list-group-item">
                                                    <b>Muhatap Eposta</b> <a class="float-right">{{ $rentForm->interlocutor_email ?? '' }}</a>
                                                </li>
                                                <li class="list-group-item">
                                                    <b>Muhatap Telefon</b> <a class="float-right">{{ $rentForm->interlocutor_phone ?? '' }}</a>
                                                </li>

                                                <li class="list-group-item">
                                                    <b>Ücret</b> <a class="float-right">{{ $rentForm->price ?? '' }} {{ $rentForm->currency ?? '' }}</a>
                                                </li>

                                                <li class="list-group-item">
                                                    <b>Muhatap Telefon</b> <a class="float-right">{{ $product->interlocutor_phone ?? '' }}</a>
                                                </li>
                                                <li class="list-group-item">
                                                    <b>Durum</b>
                                                    <a class="float-right">
                                        <span class="badge badge-{{ $rentForm->rentFormStatus->color }}">
                                            {{ __("rentFormStatuses.".$rentForm->rentFormStatus->name) }}
                                        </span>
                                                    </a>
                                                </li>
                                            </ul>
                                        </div>
                                        <!-- /.card-body -->
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
            <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Kiralama Formu Malzeme Listesi</h3>
                    </div>
                    <div class="card-body">

                        <table class="table table-striped">
                            <thead>
                            <th>Seri No</th>
                            <th>Marka</th>
                            <th>Model</th>
                            <th>Adet</th>
                            <th>Açıklama</th>
                            <th>#</th>
                            </thead>
                            <tbody>
                            @foreach($rentFormProducts as $rentFormProduct)
                                <tr>
                                    <td>{{ $rentFormProduct->product->serial_number }}</td>
                                    <td>{{ $rentFormProduct->product->make }}</td>
                                    <td>{{ $rentFormProduct->product->model }}</td>
                                    <td>{{ $rentFormProduct->count ?? "--" }}</td>
                                    <td>{{ $rentFormProduct->product->description }}</td>
                                    <td>
                                        <a type="button" target="_blank" href="{{ route('products.show', ['product' => $rentFormProduct->product->id]) }}" class="btn btn-primary"><span class="fas fa-search"></span> Malzeme Detayı</a>
                                        <a type="button" href="{{ route('rentForms.removeProductFromActiveRentForm', ['id' => $rentForm->id, 'productId' => $rentFormProduct->product->id]) }}" class="btn btn-danger"><span class="fas fa-minus"></span> Kiralamadan Al</a>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                        @if($rentFormProducts->count() <= 0)
                            <p class="alert alert-info">Bu kiralamada bir malzeme kalmadı. Kiralamayı tamamlayabilirsiniz yada yeni bir malzeme ekleyerek devam ettirebilirsiniz.</p>
                        @endif
                        <hr>
                        <h3>Kiraya yeni malzeme gönder</h3>
                        <table id="dt" class="table table-bordered table-hover">
                            <thead>
                            <tr>
                                <th>Seri No</th>
                                <th>Kategori</th>
                                <th>Marka</th>
                                <th>Model</th>
                                <th>Kullanılabilir Adet</th>
                                <th>Durum</th>
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
                                    <td>@if(!empty($product->count)) {{ $product->count - $product->unavailable_count }} @else -- @endif</td>
                                    <td>
                                    <span class="badge badge-{{ $product->productStatus->color }}">
                                        {{ __("productStatuses.".$product->productStatus->name) }}
                                    </span>
                                    </td>
                                    <td>
                                        @if($product->productStatus->name == 'IN_DEPOT' && ((!empty($product->count) && $product->count - $product->unavailable_count > 0) || empty($product->count)))
                                            <a type="button" href="{{ route('rentForms.addForm', ['id' => $rentForm->id, 'productId' => $product->id, 'active' => 'true']) }}" class="btn btn-success"><span class="fas fa-search"></span> Kiralık Gönder</a>
                                        @endif
                                        <a type="button" target="_blank" href="{{ route('products.show', ['product' => $product->id]) }}" class="btn btn-primary"><span class="fas fa-search"></span> Malzeme Detayı</a>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>

                    </div>
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
