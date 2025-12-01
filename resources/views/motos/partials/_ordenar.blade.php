<div class="d-flex justify-content-between align-items-center mb-3">

    <small class="text-muted">
        Resultados filtrados ({{ $motos->total() }})
    </small>

    {{-- Mostrar cantidad --}}
    <div>
        <span class="me-2 text-muted">Mostrar:</span>

        @foreach([9,12,18,24] as $cantidad)
            <a href="{{ request()->fullUrlWithQuery(['show' => $cantidad]) }}"
               class="{{ request('show') == $cantidad ? 'fw-bold text-success' : '' }}">
               {{ $cantidad }}
            </a>@if(!$loop->last) / @endif
        @endforeach
    </div>

    {{-- Ordenar --}}
    <form method="GET" class="d-inline">
        {{-- Mantener filtros activos --}}
        @foreach(request()->except('order') as $key => $value)
            <input type="hidden" name="{{ $key }}" value="{{ $value }}">
        @endforeach

        <select name="order" class="form-select w-auto" onchange="this.form.submit()">
            <option value="">Ordenar por recientes</option>
            <option value="precio_asc" {{ request('order')=='precio_asc' ? 'selected':'' }}>
                Precio menor a mayor
            </option>
            <option value="precio_desc" {{ request('order')=='precio_desc' ? 'selected':'' }}>
                Precio mayor a menor
            </option>
        </select>
    </form>
</div>
