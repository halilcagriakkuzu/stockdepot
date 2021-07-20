@extends('layouts.app')

@section('title')
    @if($new)
        Yeni Malzeme Oluştur
    @else
        #{{ $product->id }} Malzeme Düzenle
    @endif
@endsection

@section('content-title')
    @if($new)
        Yeni Malzeme Oluştur
    @else
        #{{ $product->id }} {{ $product->make }} {{ $product->model }} Düzenle
    @endif
@endsection

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('products.index') }}">Malzemeler</a></li>
    @if($new)
        <li class="breadcrumb-item active">Yeni Malzeme Oluştur</li>
    @else
        <li class="breadcrumb-item active">Malzeme Düzenle #{{ $product->id }}</li>
    @endif
@endsection

@section('css')
    <!-- Tempusdominus Bootstrap 4 -->
    <link rel="stylesheet" href="{{asset('plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css')}}">
@endsection

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                @if($new)
                    <h3 class="card-title">Yeni Malzeme oluştur.</h3>
                @else
                    <h3 class="card-title">#{{ $product->id }} {{ $product->make }} {{ $product->model }} malzemesinin bilgilerini düzenle</h3>
                @endif
            </div>
            <!-- /.card-header -->
            @if($new)
                <form action="{{ action('App\Http\Controllers\ProductController@store') }}" method="post">
                    {{ method_field('POST') }}
            @else
                <form action="{{ action('App\Http\Controllers\ProductController@update', ['product' => $product]) }}" method="post">
                    {{ method_field('PUT') }}
            @endif
                {!! csrf_field() !!}
                <div class="card-body">
                    <div class="form-group">
                        <label for="category_id">Kategori <i class="text-danger">*</i></label>
                        <select class="form-control  @error('category_id') is-invalid @enderror" name="category_id" id="category_id" required>
                            <option value="">Seçiniz</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}" @if(!empty($product) && $category->id === $product->category->id ?? 0) selected @endif>{{ $category->name }}</option>
                            @endforeach
                        </select>
                        @error('category_id')
                        <span class="error invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="serial_number">Seri Numarası</label>
                        <input class="form-control @error('serial_number') is-invalid @enderror" type="text" name="serial_number" id="serial_number" value="{{ old('serial_number') ?? $product->serial_number ?? '' }}" placeholder="Seri Numarası">
                        @error('serial_number')
                        <span class="error invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="make">Marka <i class="text-danger">*</i></label>
                        <input class="form-control @error('make') is-invalid @enderror" type="text" name="make" id="make" value="{{ old('make') ?? $product->make ?? '' }}" placeholder="Marka" required>
                        @error('make')
                        <span class="error invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="model">Model <i class="text-danger">*</i></label>
                        <input class="form-control @error('model') is-invalid @enderror" type="text" name="model" id="model" value="{{ old('model') ?? $product->model ?? '' }}" placeholder="Model"required >
                        @error('model')
                        <span class="error invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="shelf_no">Raf Numarası</label>
                        <input class="form-control @error('shelf_no') is-invalid @enderror" type="text" name="shelf_no" id="shelf_no" value="{{ old('shelf_no') ?? $product->shelf_no ?? '' }}" placeholder="Raf Numarası">
                        @error('shelf_no')
                        <span class="error invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="row_no">Sıra Numarası</label>
                        <input class="form-control @error('row_no') is-invalid @enderror" type="text" name="row_no" id="row_no" value="{{ old('row_no') ?? $product->row_no ?? '' }}" placeholder="Sıra Numarası">
                        @error('row_no')
                        <span class="error invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="count">Adet (<i>Sadece adetle satılan malzemeler için giriniz.</i>)</label>
                        <input class="form-control @error('count') is-invalid @enderror" type="text" name="count" id="count" value="{{ old('count') ?? $product->count ?? '' }}" placeholder="Adet">
                        @error('count')
                        <span class="error invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="description">Açıklama</label>
                        <input class="form-control @error('description') is-invalid @enderror" type="text" name="description" id="description" value="{{ old('description') ?? $product->description ?? '' }}" placeholder="Açıklama">
                        @error('description')
                        <span class="error invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="buy_price">Satın Alma Fiyatı ($)</label>
                        <input class="form-control @error('buy_price') is-invalid @enderror" type="text" name="buy_price" id="buy_price" value="{{ old('buy_price') ?? $product->buy_price ?? '' }}" placeholder="Satın Alma fiyatı">
                        @error('buy_price')
                        <span class="error invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label>Satın Alma Tarihi:</label>
                        <div class="input-group date" id="buy_date" data-target-input="nearest">
                            <input type="text" name="buy_date" class="form-control datetimepicker-input @error('buy_date') is-invalid @enderror" data-target="#buy_date" value="@if(!empty(old('buy_date'))) {{ old('buy_date') }} @elseif(!empty($product) && !empty($product->buy_date)) {{ $product->buy_date->format('d/m/Y') }} @endif"/>
                            <div class="input-group-append" data-target="#buy_date" data-toggle="datetimepicker">
                                <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                            </div>
                        </div>
                        @error('buy_date')
                        <span class="error invalid-feedback">{{ $message }}</span>
                        @enderror
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
    </div>
</div>
@endsection

@section('js')
    <!-- Tempusdominus Bootstrap 4 -->
    <script src="{{asset('plugins/moment/moment.min.js')}}"></script>
    <script src="{{asset('plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js')}}"></script>

    <script>
        $(function () {
            $('#buy_date').datetimepicker({
                locale: 'tr',
                format: 'DD/MM/YYYY'
            });
        });
    </script>
@endsection
