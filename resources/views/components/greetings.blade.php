<h3>
    {{ $greeting }}
</h3>
<h5>
    @if (auth()->check())
        {{ auth()->user()->name }}
    @endif
</h5>
<h6 class="date">{{ now()->format('F j, Y') }}</h6>
<h6 id="clock" class="clock"></h6>
