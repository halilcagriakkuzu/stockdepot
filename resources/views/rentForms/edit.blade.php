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
                        <select class="form-control  @error('company_id') is-invalid @enderror" name="company_id" id="company_id" required>
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
                                <option value="TL" @if((old('currency') ?? $rentForm->currency ?? '') == 'TL') selected @endif>₺</option>
                                <option value="USD" @if((old('currency') ?? $rentForm->currency ?? '') == 'USD') selected @endif>$</option>
                                <option value="EUR" @if((old('currency') ?? $rentForm->currency ?? '') == 'EUR') selected @endif>€</option>
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
                                    <td>{{ $rentFormProduct->product->count ?? "--" }}</td>
                                    <td>{{ $rentFormProduct->product->description }}</td>
                                    <td>
                                        <a type="button" href="{{ route('rentForms.removeProductFromRentForm', ['id' => $rentForm->id, 'productId' => $rentFormProduct->product->id]) }}" class="btn btn-block btn-danger"><span class="fas fa-minus"></span> Formdan Çıkart</a>
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
                                        <a type="button" href="{{ route('rentForms.addForm', ['id' => $rentForm->id, 'productId' => $product->id]) }}" class="btn btn-success"><span class="fas fa-search"></span> Forma Ekle</a>
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

<div class="modal fade" id="addToFormModal" tabindex="-1" role="dialog" aria-labelledby="addToFormModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addToFormModalLabel"></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Kapat">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="card card-primary card-outline">
                    <div class="card-body box-profile">
                        <h3 class="profile-username text-center" id="modal-product-make-model">...</h3>
                        <p class="text-muted text-center">ID: <a target="_blank" id="modal-product-id" href="#">#...</a></p>
                        <ul class="list-group list-group-unbordered mb-3">
                            <li class="list-group-item">
                                <b>Seri Numarası</b> <a class="float-right" id="modal-product-serial-no">...</a>
                            </li>
                            <li class="list-group-item" id="modal-product-available-count-item">
                                <b>Kullanılabilir Adet</b> <a class="float-right" id="modal-product-available-count">...</a>
                            </li>
                        </ul>
                    </div>
                </div>
                <form id="modal-form">
                    <div class="form-group" id="count-modal-form-control">
                        <label for="modal-count" class="col-form-label">Kullanılacak Adet <i class="text-danger">*</i></label>
                        <input type="number" min="1" max="" class="form-control" id="modal-count" name="modal-count" required>
                    </div>
                    <div class="form-group">
                        <label for="modal-description" class="col-form-label">Açıklama</label>
                        <textarea class="form-control" name="modal-description" id="modal-description"></textarea>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" id="add-to-form-modal-button">Forma Ekle</button>
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
            // addProductToFormButton
            // selectedProducts [tbody] .push(tr)

            $('#addToFormModal').on('show.bs.modal', function (event) {
                var button = $(event.relatedTarget) // Button that triggered the modal

                var productId = button.data('product-id')
                var productSerialNo = button.data('product-serial-number')
                var productMakeModel = button.data('product-make-model')
                var availableCount = button.data('available-count')
                console.log('availableCount:', availableCount)

                if (availableCount) {
                    $('#modal-count').attr('max', availableCount)
                    $('#modal-product-available-count').text(availableCount)
                } else {
                    $('#count-modal-form-control').remove()
                    $('#modal-product-available-count-item').remove()
                }

                $('#modal-product-make-model').text(productMakeModel)
                $('#modal-product-serial-no').text(productSerialNo)
                $('#modal-product-id').attr('href', "/products/" + productId)
                $('#modal-product-id').text(`#${productId}`)

                // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
                // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.
                var modal = $(this)
                modal.find('.modal-title').text('Forma Ürün Ekle ' + productMakeModel)
            })

            $('#add-to-form-modal-button').on('click', function () {
                var form = document.querySelector('#modal-form')
                if (form.reportValidity()) {
                    let request = $(form).serializeArray()
                    console.log("request:", request)
                    alert("form submit");
                }
            })

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
