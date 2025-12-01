@extends('layout')

@section('content')
<div class="container py-4">
    <h3>📱 Redes Sociales</h3>

    <form action="{{ route('admin.config.redes.update') }}" method="POST">
        @csrf

        <div class="mb-3">
            <label>Facebook</label>
            <input class="form-control" type="url" name="facebook" value="{{ $settings->facebook }}">
        </div>

        <div class="mb-3">
            <label>Instagram</label>
            <input class="form-control" type="url" name="instagram" value="{{ $settings->instagram }}">
        </div>

        <div class="mb-3">
            <label>TikTok</label>
            <input class="form-control" type="url" name="tiktok" value="{{ $settings->tiktok }}">
        </div>

        <div class="mb-3">
            <label>WhatsApp (wa.me link)</label>
            <input class="form-control" type="url" name="whatsapp" value="{{ $settings->whatsapp }}">
        </div>

        <button class="btn btn-primary">Actualizar</button>
    </form>
</div>
@endsection
