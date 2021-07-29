@extends('layouts.app')

@section('title')
    @if($new)
        Yeni Kiralama Formu Oluştur
    @else
        #{{ $rentForm->id }} Kiralama Formu Düzenle
    @endif
@endsection

@section('content-title')
    @if($new)
        Yeni Kiralama Formu Oluştur
    @else
        #{{ $rentForm->id }} {{ $rentForm->company->name }} Düzenle
    @endif
@endsection

@section('breadcrumb')
    @if($new)
        <li class="breadcrumb-item active">Yeni Kiralama Formu Oluştur</li>
    @else
        <li class="breadcrumb-item active">Kiralama Formu Düzenle #{{ $rentForm->id }}</li>
    @endif
@endsection

@section('css')
    <!-- DataTables -->
    <link rel="stylesheet" href="{{asset('plugins/datatables-bs4/css/dataTables.bootstrap4.min.css')}}">
    <link rel="stylesheet" href="{{asset('plugins/datatables-responsive/css/responsive.bootstrap4.min.css')}}">
    <link rel="stylesheet" href="{{asset('plugins/datatables-buttons/css/buttons.bootstrap4.min.css')}}">
    <!-- Select2 -->
    <link rel="stylesheet" href="{{asset('plugins/select2/css/select2.min.css')}}">
    <link rel="stylesheet" href="{{asset('plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css')}}">
@endsection

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                @if($new)
                    <h3 class="card-title">Yeni Kiralama Formu oluştur.</h3>
                @else
                    <h3 class="card-title">#{{ $rentForm->id }} {{ $rentForm->company->name }} kiralama formunun bilgilerini düzenle</h3>
                @endif
                <div class="float-right">
                    @if(!$new)
                        @if($rentForm->rentFormStatus->name == 'DRAFT')
                            <a type="button" href="{{ route('rentForms.activateRentForm', ['id' => $rentForm->id]) }}" class="btn btn-success"><span class="fas fa-check"></span> Aktifleştir</a>
                            <form class="d-inline delete" action="{{ action('App\Http\Controllers\RentFormController@destroy', ['rentForm' => $rentForm]) }}" method="post">
                                {{ method_field('DELETE') }}
                                {!! csrf_field() !!}
                                <button type="submit" class="btn btn-danger"><span class="fas fa-trash"></span> Taslağı Sil</button>
                            </form>
                        @elseif($rentForm->rentFormStatus->name == 'ACTIVE')
                            <a type="button" href="#" class="btn btn-info"><span class="fas fa-check"></span> Tamamlandı Olarak İşaretle</a>
                        @endif
                            <a class="btn btn-success" href="{{ route('rentForms.exportPdf', ['id' => $rentForm->id]) }}" type="button"><span class="fas fa-pdf"></span> PDF Çıktı Al</a>
                    @endif
                </div>
            </div>
            <!-- /.card-header -->
            @if($new)
                <form action="{{ action('App\Http\Controllers\RentFormController@store') }}" method="post">
                    {{ method_field('POST') }}
            @else
                <form action="{{ action('App\Http\Controllers\RentFormController@update', ['rentForm' => $rentForm]) }}" method="post">
                    {{ method_field('PUT') }}
            @endif
                {!! csrf_field() !!}
                <div class="card-body">
                    <div class="form-group">
                        <label for="company_id">Firma <i class="text-danger">*</i></label>
                        <select class="form-control select2bs4 @error('company_id') is-invalid @enderror" name="company_id" id="company_id" required>
                            <option value="">Seçiniz</option>
                            @foreach($companies as $company)
                                <option value="{{ $company->id }}" @if(!empty($rentForm) && $company->id === $rentForm->company->id ?? 0) selected @endif>{{ $company->name }}</option>
                            @endforeach
                        </select>
                        @error('company_id')
                        <span class="error invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="interlocutor_name">Muhatap İsmi <i class="text-danger">*</i></label>
                        <input class="form-control @error('interlocutor_name') is-invalid @enderror" type="text" name="interlocutor_name" id="interlocutor_name" value="{{ old('interlocutor_name') ?? $rentForm->interlocutor_name ?? '' }}" placeholder="Muhatap İsmi" required>
                        @error('interlocutor_name')
                        <span class="error invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="interlocutor_email">Muhatap Eposta <i class="text-danger">*</i></label>
                        <input class="form-control @error('interlocutor_email') is-invalid @enderror" type="email" name="interlocutor_email" id="interlocutor_email" value="{{ old('interlocutor_email') ?? $rentForm->interlocutor_email ?? '' }}" placeholder="Muhatap Eposta" required>
                        @error('interlocutor_email')
                        <span class="error invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="interlocutor_phone">Muhatap Telefon <i class="text-danger">*</i></label>
                        <input class="form-control @error('interlocutor_phone') is-invalid @enderror" type="text" name="interlocutor_phone" id="interlocutor_phone" value="{{ old('interlocutor_phone') ?? $rentForm->interlocutor_phone ?? '' }}" placeholder="Muhatap Telefon" required>
                        @error('interlocutor_phone')
                        <span class="error invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group row">
                        <div class="col-10">
                            <label for="price">Fiyat <i>(Sonradan girilebilir)</i></label>
                            <input class="form-control @error('price') is-invalid @enderror" type="text" name="price" id="price" value="{{ old('price') ?? $rentForm->price ?? '' }}" placeholder="Fiyat">
                            @error('price')
                            <span class="error invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="col">
                            <label for="currency">Para Birimi</label>
                            <select class="form-control @error('currency') is-invalid @enderror" name="currency" id="currency">
                                <option value="">Seçiniz</option>
                                <option value="₺" @if((old('currency') ?? $rentForm->currency ?? '') == '₺') selected @endif>₺</option>
                                <option value="$" @if((old('currency') ?? $rentForm->currency ?? '') == '$') selected @endif>$</option>
                                <option value="€" @if((old('currency') ?? $rentForm->currency ?? '') == '€') selected @endif>€</option>
                            </select>
                            @error('currency')
                            <span class="error invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                </div>
                <div class="card-footer">
                    @if($new)
                        <button class="btn btn-success" type="submit"><span class="fas fa-plus"></span> Oluştur</button>
                    @else
                        <button class="btn btn-success" type="submit"><span class="fas fa-edit"></span> Düzenle</button>
                    @endif
                    <div class="text-muted">
                        <small><i class="text-danger">*</i> : Gerekli alanlar</small>
                    </div>
                </div>
            </form>
            <!-- /.card-body -->
        </div>

        @if(!$new)
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Forma Malzeme Ekle</h3>
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
                                        @if(!$rentFormProduct->is_removed)
                                            <a type="button" href="{{ route('rentForms.removeProductFromRentForm', ['id' => $rentForm->id, 'productId' => $rentFormProduct->product->id]) }}" class="btn btn-sm btn-danger"><span class="fas fa-minus"></span> Formdan Çıkart</a>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    @if($rentFormProducts->count() <= 0)
                        <p class="alert alert-info">Şuan seçili bir malzeme yok, lütfen aşağıdaki listeden bir malzeme seçip forma ekleyin.</p>
                    @endif
                    <hr>
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
                                        <a type="button" href="{{ route('rentForms.addForm', ['id' => $rentForm->id, 'productId' => $product->id, 'active' => 'false']) }}" class="btn btn-success"><span class="fas fa-search"></span> Forma Ekle</a>
                                    @endif
                                    <a type="button" target="_blank" href="{{ route('products.show', ['product' => $product->id]) }}" class="btn btn-primary"><span class="fas fa-search"></span> Malzeme Detayı</a>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>

            </div>
            </div>
        @endif
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
    <!-- Select2 -->
    <script src="{{asset('plugins/select2/js/select2.full.min.js')}}"></script>
    <script>
        $(function () {
            $('.select2bs4').select2({
                theme: 'bootstrap4'
            })

            $(".delete").on("submit", function(){
                return confirm("Bu taslağı silmek istediğinden emin misin?");
            });

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
