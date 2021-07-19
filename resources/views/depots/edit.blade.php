@extends('layouts.app')

@section('title')
    @if($new)
        Yeni Depo Oluştur
    @else
        #{{ $depot->id }} Depo Düzenle
    @endif
@endsection

@section('content-title')
    @if($new)
        Yeni Depo Oluştur
    @else
        #{{ $depot->id }} {{ $depot->name }} Düzenle
    @endif
@endsection

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('depots.index') }}">Depolar</a></li>
    @if($new)
        <li class="breadcrumb-item active">Yeni Depo Oluştur</li>
    @else
        <li class="breadcrumb-item active">Depo Düzenle #{{ $depot->id }}</li>
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
                    <h3 class="card-title">Yeni Depo oluştur.</h3>
                @else
                    <h3 class="card-title">#{{ $depot->id }} {{ $depot->name }} Deposunun bilgilerini düzenle</h3>
                @endif
            </div>
            <!-- /.card-header -->
            @if($new)
                <form action="{{ action('App\Http\Controllers\DepotController@store') }}" method="post">
                    {{ method_field('POST') }}
            @else
                <form action="{{ action('App\Http\Controllers\DepotController@update', ['depot' => $depot]) }}" method="post">
                    {{ method_field('PUT') }}
            @endif
                {!! csrf_field() !!}
                <div class="card-body">
                    <div class="form-group">
                        <label for="name">Depo Adı <i class="text-danger">*</i></label>
                        <input class="form-control @error('name') is-invalid @enderror" type="text" name="name" id="name" value="{{ old('name') ?? $depot->name ?? '' }}" placeholder="Depo Adı" required>
                        @error('name')
                        <span class="error invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="description">Açıklama</label>
                        <input class="form-control @error('description') is-invalid @enderror" type="text" name="description" id="description" value="{{ old('description') ?? $depot->description ?? '' }}" placeholder="Açıklama">
                        @error('description')
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
