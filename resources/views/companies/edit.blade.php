@extends('layouts.app')

@section('title')
    @if($new)
        Yeni Firma Oluştur
    @else
        #{{ $company->id }} Firma Düzenle
    @endif
@endsection

@section('content-title')
    @if($new)
        Yeni Firma Oluştur
    @else
        #{{ $company->id }} {{ $company->name }} Düzenle
    @endif
@endsection

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('companies.index') }}">Firmalar</a></li>
    @if($new)
        <li class="breadcrumb-item active">Yeni Firma Oluştur</li>
    @else
        <li class="breadcrumb-item active">Firma Düzenle #{{ $company->id }}</li>
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
                    <h3 class="card-title">Yeni Firma oluştur.</h3>
                @else
                    <h3 class="card-title">#{{ $company->id }} {{ $company->name }} Firmasının bilgilerini düzenle</h3>
                @endif
            </div>
            <!-- /.card-header -->
            @if($new)
                <form action="{{ action('App\Http\Controllers\CompanyController@store') }}" method="post">
                    {{ method_field('POST') }}
            @else
                <form action="{{ action('App\Http\Controllers\CompanyController@update', ['company' => $company]) }}" method="post">
                    {{ method_field('PUT') }}
            @endif
                {!! csrf_field() !!}
                <div class="card-body">
                    <div class="form-group">
                        <label for="name">Firma Adı <i class="text-danger">*</i></label>
                        <input class="form-control @error('name') is-invalid @enderror" type="text" name="name" id="name" value="{{ old('name') ?? $company->name ?? '' }}" placeholder="Firma Adı" required>
                        @error('name')
                        <span class="error invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label>Durumu <i class="text-danger">*</i></label>
                        <div class="custom-control custom-switch custom-switch-off-secondary custom-switch-on-success">
                            <input type="checkbox" class="custom-control-input @error('is_active') is-invalid @enderror" id="is_active" name="is_active" @if($company->is_active ?? 0 == 1) checked @endif>
                            <label class="custom-control-label" for="is_active"> </label>
                        </div>
                        @error('is_active')
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
