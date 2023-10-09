@if (count($breadcrumbs))

    <div class="breadcrumbs">
        <ul>
            @foreach ($breadcrumbs as $breadcrumb)
                @if ($breadcrumb->url && !$loop->last)
                    <li><a href="{{ $breadcrumb->url }}">{{ $breadcrumb->title }}</a></li>
                @else
                    <li class="current"><a>{{ $breadcrumb->title }}</a></li>
                @endif
            @endforeach
        </ul>
    </div>

@endif