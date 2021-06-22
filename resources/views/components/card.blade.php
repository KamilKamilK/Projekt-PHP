<div class="card" style="width: 100%;">
    <div class="card-body">
        <h5 class="card-title">{{ $title }}</h5>
        <h6 class="card-subtitle mb-2 text-muted">
            {{ $subtitle  }}
        </h6>
        <ul class="list-group list-group-flush">
{{--            Jeśli jako $item wykorzystujemy kolekcję--}}

            @if(is_a($items, 'Illuminate\Support\Collection'))
            @foreach($items as $item)
                <li class="list-group-item">
                        {{$item}}
                </li>
            @endforeach
{{--                Jeśli jako item wykorzustujemy wybrany kod. Np. chcemy dodać link(a href)--}}
            @else
                {{$items}}
                @endif
        </ul>
    </div>
</div>
