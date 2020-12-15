<div id="carouselHomeIndicators"  {{ $attributes->merge(['class' => 'carousel slide']) }}  data-ride="carousel">
    <ol class="carousel-indicators">
        @for ($i = 0; $i < $count; $i++)
            <li data-target="#carouselHomeIndicators" data-slide-to="{{$i}}" @if ($i==0) class="active" @endif></li>
        @endfor
    </ol>
    <div class="carousel-inner">
        @foreach ($carousels as $carousel)
            <div class="carousel-item @if ($loop->first) active @endif">
                <a href="{{ $carousel->url }}" target="_blank">
                <img class="d-block w-100" src="{{ $carousel->image }}" alt="{{ $carousel->name }}">
                </a>
            </div>
        @endforeach
    </div>
    <a class="carousel-control-prev" href="#carouselHomeIndicators" role="button" data-slide="prev">
        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
        <span class="sr-only">上一个</span>
    </a>
    <a class="carousel-control-next" href="#carouselHomeIndicators" role="button" data-slide="next">
        <span class="carousel-control-next-icon" aria-hidden="true"></span>
        <span class="sr-only">下一个</span>
    </a>
</div>
