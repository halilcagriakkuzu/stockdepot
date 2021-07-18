@extends('layouts.app')

@section('title') Deneme @endsection

@section('content-title') Deneme @endsection

@section('breadcrumb')
    <li class="breadcrumb-item active">Deneme</li>
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

                    {{ __('Giriş yapıldı!') }}
                </div>
            </div>
        </div>
    </div>
@endsection
