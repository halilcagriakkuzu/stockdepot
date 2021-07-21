@extends('layouts.app')

@section('title')Malzeme Durumu Değiştir@endsection

@section('content-title')
    @if($status->name == 'IN_MAINTENANCE')
        Malzemeyi Ölçü/Bakım'a Gönder
    @elseif($status->name == 'DISABLED')
        Malzemeyi Kullanım Dışı Olarak İşaretle
    @elseif($status->name == 'IN_DEPOT')
        Malzemeyi Depoya Gönder
    @endif
@endsection

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('products.index') }}">Malzemeler</a></li>
    @if($status->name == 'IN_MAINTENANCE')
        <li class="breadcrumb-item active">Malzemeyi Ölçü/Bakım'a Gönder</li>
    @elseif($status->name == 'DISABLED')
        <li class="breadcrumb-item active">Malzemeyi Kullanım Dışı Olarak İşaretle</li>
    @elseif($status->name == 'IN_DEPOT')
        <li class="breadcrumb-item active">Malzemeyi Depoya Gönder</li>
    @endif
@endsection

@section('css')
@endsection

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                @if($status->name == 'IN_MAINTENANCE')
                    <h3 class="card-title">Malzemeyi Ölçü/Bakım'a Gönder.</h3>
                @elseif($status->name == 'DISABLED')
                    <h3 class="card-title">Malzemeyi Kullanım Dışı Olarak İşaretle.</h3>
                @elseif($status->name == 'IN_DEPOT')
                    <h3 class="card-title">Malzemeyi Depoya Gönder.</h3>
                @endif
            </div>
            <!-- /.card-header -->
            @if($status->name == 'IN_MAINTENANCE')
                <form action="{{ action('App\Http\Controllers\ProductStatusController@sendToMaintenance', ['id' => $product->id]) }}" method="post">
            @elseif($status->name == 'DISABLED')
                <form action="{{ action('App\Http\Controllers\ProductStatusController@markAsDisabled', ['id' => $product->id]) }}" method="post">
            @elseif($status->name == 'IN_DEPOT')
                <form action="{{ action('App\Http\Controllers\ProductStatusController@sendToDepot', ['id' => $product->id]) }}" method="post">
            @endif
                    {{ method_field('POST') }}
                    {!! csrf_field() !!}
                <div class="card-body">
                    @if($status->name == 'IN_MAINTENANCE')
                        <p class="alert alert-info">
                            Malzeme ölçü/bakım'a gönderildikten sonra kiralamalarda kullanılamaz. Tekrar kiralayabilmek için malzemeyi tekrar depoya taşımak ve durumunu düzenlemek gereklidir.
                        </p>
                    @elseif($status->name == 'DISABLED')
                        <p class="alert alert-danger">
                            Malzeme kullanım dışı olarak işaretlendikten sonra kullanılamaz, kiralama formlarında görünmez. Depodan çıkartılan, tamiri mümkün olmayacak şekilde bozulan, hasar gören ve bir daha kullanılmayacak ürünleri kullanım dışı olarak işaretlemelisiniz.
                        </p>
                    @endif
                    @if($status->name == 'IN_MAINTENANCE')
                        <div class="form-group">
                            <label for="count">Bakıma Gönderilecek Adet <i>(Kullanılabilir: <b>{{ $product->count - $product->unavailable_count }}</b>)</i> <i class="text-danger">*</i></label>
                            <input class="form-control @error('count') is-invalid @enderror" type="number" min="1" max="{{ $product->count - $product->unavailable_count }}" name="count" id="count" value="{{ old('count') ?? '' }}" placeholder="Gönderilecek Adet" required>
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
                    <button class="btn btn-success" type="submit"><span class="fas fa-plus"></span> Gönder</button>
                </div>
            </form>
            <!-- /.card-body -->
        </div>
    </div>
</div>
@endsection

@section('js')
@endsection
