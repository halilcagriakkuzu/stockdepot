@extends('layouts.app')

@section('title')
    Forma malzeme ekle
@endsection

@section('content-title')
    Forma malzeme ekle
@endsection

@section('breadcrumb')
    <li class="breadcrumb-item active">Forma malzeme ekle</li>
@endsection

@section('css')
@endsection

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Forma malzeme ekle</h3>
            </div>
            <!-- /.card-header -->
            <form action="{{ action('App\Http\Controllers\RentFormController@addFormStore', ['id' => $rentForm->id, 'productId' => $product->id]) }}" method="post">
                {{ method_field('POST') }}
                {!! csrf_field() !!}
                <div class="card-body">
                    <div class="row">
                        <div class="col-12 col-md-6">
                            <div class="card card-primary card-outline">
                                <div class="card-body box-profile">
                                    <h3 class="profile-username text-center">{{ $rentForm->company->name }}</h3>
                                    <p class="text-muted text-center">Kiralama Formu ID: <a target="_blank" href="{{ route('rentForms.edit', ['rentForm' => $rentForm]) }}">#{{ $rentForm->id }}</a></p>
                                    <ul class="list-group list-group-unbordered mb-3">
                                        <li class="list-group-item">
                                            <b>Form Durumu</b> <a class="float-right">
                                                <span class="badge badge-{{ $rentForm->rentFormStatus->color }}">
                                                    {{ __("rentFormStatuses.".$rentForm->rentFormStatus->name) }}
                                                </span>
                                            </a>
                                        </li>
                                        <li class="list-group-item">
                                            <b>Oluşturan</b> <a class="float-right">{{ $rentForm->createdBy->name }}</a>
                                        </li>
                                        <li class="list-group-item">
                                            <b>Oluşturulma Tarihi</b> <a class="float-right">{{ $rentForm->created_at->format('d/m/Y H:i') }}</a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-md-6">
                            <div class="card card-primary card-outline">
                                <div class="card-body box-profile">
                                    <h3 class="profile-username text-center">{{ $product->make }} {{ $product->model }}</h3>
                                    <p class="text-muted text-center">Malzeme ID: <a target="_blank" href="{{ route('products.show', ['product' => $product->id]) }}">#{{ $product->id }}</a></p>
                                    <ul class="list-group list-group-unbordered mb-3">
                                        <li class="list-group-item">
                                            <b>Malzeme Durumu</b> <a class="float-right">
                                                <span class="badge badge-{{ $product->productStatus->color }}">
                                                    {{ __("productStatuses.".$product->productStatus->name) }}
                                                </span>
                                            </a>
                                        </li>
                                        @if(!empty($product->count))
                                            <li class="list-group-item">
                                                <b>Kullanılabilir Adet</b> <a class="float-right">{{ $product->count - $product->unavailable_count }}</a>
                                            </li>
                                        @else
                                            <li class="list-group-item">
                                                <b>Seri Numarası</b> <a class="float-right">{{ $product->serial_number }}</a>
                                            </li>
                                        @endif
                                        <li class="list-group-item">
                                            <b>Açıklama</b> <a class="float-right">{{ $product->description }}</a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>

                    @if(!empty($product->count))
                        <div class="form-group">
                            <label for="count">Kullanılacak Adet <i class="text-danger">*</i></label>
                            <input class="form-control @error('count') is-invalid @enderror" type="number" min="1" max="{{ $product->count - $product->unavailable_count }}" name="count" id="count" value="{{ old('count') ?? '' }}" placeholder="Kullanılacak Adet">
                            @error('count')
                            <span class="error invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>
                    @endif
                    <div class="form-group">
                        <label for="description">Açıklama</label>
                        <input class="form-control @error('description') is-invalid @enderror" type="text" name="description" id="description" value="{{ old('description') ?? '' }}" placeholder="Açıklama">
                        @error('description')
                        <span class="error invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
                <div class="card-footer">
                     <button class="btn btn-success" type="submit"><span class="fas fa-plus"></span> Malzemeyi Forma Ekle</button>
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
    <script>
        $(function () {
        });
    </script>
@endsection
