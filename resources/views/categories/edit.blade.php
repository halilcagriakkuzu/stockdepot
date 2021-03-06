@extends('layouts.app')

@section('title')
    @if($new)
        Yeni Kategori Oluştur
    @else
        #{{ $category->id }} Kategori Düzenle
    @endif
@endsection

@section('content-title')
    @if($new)
        Yeni Kategori Oluştur
    @else
        #{{ $category->id }} {{ $category->name }} Düzenle
    @endif
@endsection

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('categories.index') }}">Kategorilar</a></li>
    @if($new)
        <li class="breadcrumb-item active">Yeni Kategori Oluştur</li>
    @else
        <li class="breadcrumb-item active">Kategori Düzenle #{{ $category->id }}</li>
    @endif
@endsection

@section('css')
@endsection

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                @if($new)
                    <h3 class="card-title">Yeni Kategori oluştur.</h3>
                @else
                    <h3 class="card-title">#{{ $category->id }} {{ $category->name }} Kategorisinin bilgilerini düzenle</h3>
                @endif
            </div>
            <!-- /.card-header -->
            @if($new)
                <form action="{{ action('App\Http\Controllers\CategoryController@store') }}" method="post">
                    {{ method_field('POST') }}
            @else
                <form action="{{ action('App\Http\Controllers\CategoryController@update', ['category' => $category]) }}" method="post">
                    {{ method_field('PUT') }}
            @endif
                {!! csrf_field() !!}
                <div class="card-body">
                    <div class="form-group">
                        <label for="name">Kategori Adı <i class="text-danger">*</i></label>
                        <input class="form-control @error('name') is-invalid @enderror" type="text" autocomplete="cat-name" name="name" id="name" value="{{ old('name') ?? $category->name ?? '' }}" placeholder="Kategori Adı" required>
                        @error('name')
                        <span class="error invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="description">Açıklama</label>
                        <input class="form-control @error('description') is-invalid @enderror" type="text" autocomplete="cat-description" name="description" id="description" value="{{ old('description') ?? $category->description ?? '' }}" placeholder="Açıklama">
                        @error('description')
                        <span class="error invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="depot_id">Depo <i class="text-danger">*</i></label>
                        <select class="form-control  @error('depot_id') is-invalid @enderror" name="depot_id" id="depot_id" required>
                            <option value="">Seçiniz</option>
                            @foreach($depots as $depot)
                            <option value="{{ $depot->id }}" @if(!empty($category) && $depot->id === $category->depot->id ?? 0) selected @endif>{{ $depot->name }}</option>
                            @endforeach
                        </select>
                        @error('depot_id')
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

    <script>
        $(function () {
        });
    </script>
@endsection
