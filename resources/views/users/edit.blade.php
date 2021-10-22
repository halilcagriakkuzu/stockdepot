@extends('layouts.app')

@section('title')
    @if($new)
        Yeni Kullanıcı Oluştur
    @else
        #{{ $user->id }} Kullanıcı Düzenle
    @endif
@endsection

@section('content-title')
    @if($new)
        Yeni Kullanıcı Oluştur
    @else
        #{{ $user->id }} {{ $user->email }} Düzenle
    @endif
@endsection

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('users.index') }}">Kullanıcılar</a></li>
    @if($new)
        <li class="breadcrumb-item active">Yeni Kullanıcı Oluştur</li>
    @else
        <li class="breadcrumb-item active">Kullanıcı Düzenle #{{ $user->id }}</li>
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
                    <h3 class="card-title">Yeni kullanıcı oluştur.</h3>
                @else
                    <h3 class="card-title">#{{ $user->id }} {{ $user->name }} Kullanıcısının bilgilerini düzenle</h3>
                @endif
            </div>
            <!-- /.card-header -->
            @if($new)
                <form action="{{ action('App\Http\Controllers\UserController@store') }}" method="post">
                    {{ method_field('POST') }}
            @else
                <form action="{{ action('App\Http\Controllers\UserController@update', ['user' => $user]) }}" method="post">
                    {{ method_field('PUT') }}
            @endif
                {!! csrf_field() !!}
                <div class="card-body">
                    <div class="form-group">
                        <label for="name">İsim Soyisim <i class="text-danger">*</i></label>
                        <input class="form-control @error('name') is-invalid @enderror" type="text" autocomplete="user-name" name="name" id="name" value="{{ old('name') ?? $user->name ?? '' }}" placeholder="İsim Soyisim" required>
                        @error('name')
                        <span class="error invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="email">Eposta <i class="text-danger">*</i></label>
                        <input class="form-control @error('email') is-invalid @enderror" type="email" autocomplete="user-email" name="email" id="email" value="{{ old('email') ?? $user->email ?? '' }}" placeholder="Eposta" required>
                        @error('email')
                        <span class="error invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="new-password">Parola
                            @if($new)
                                <i class="text-danger">*</i>
                            @else
                                <i><small>(Değiştirmek istemiyorsanız boş bırakın)</small></i>
                            @endif
                        </label>
                        <input class="form-control @error('password') is-invalid @enderror" type="password" name="password" id="password" autocomplete="new-password" placeholder="Parola">
                        @error('password')
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
