<ol class="breadcrumb m-0">
    @if (!empty($firstItem))
        <li class="breadcrumb-item active fw-bold" aria-current="page">{{ $firstItem }}</li>
    @endif

    @foreach ($items as $breadcrumb)
        <li class="breadcrumb-item" aria-current="page">
            @if (!empty($breadcrumb['url']))
                <a href="{{ $breadcrumb['url'] }}" class="link-light">{{ $breadcrumb['title'] }}</a>
            @else
                {{ $breadcrumb['title'] }}
            @endif
        </li>
    @endforeach

    @if (!empty($lastItem))
        <li class="breadcrumb-item active" aria-current="page">{{ $lastItem }}</li>
    @endif
</ol>

