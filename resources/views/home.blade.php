@extends('layouts.app')

@section('title') Anasayfa @endsection

@section('content-title') Anasayfa @endsection

@section('breadcrumb')
    <li class="breadcrumb-item active">Anasayfa</li>
@endsection

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">Anasayfa</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
                    <p>Giriş yapıldı. Hoşgeldiniz.</p>
                    <p>Sol menüden istediğiniz bölümü kullanabilirsiniz.</p>
                </div>
            </div>
        </div>
    </div>
@endsection
