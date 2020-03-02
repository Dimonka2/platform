@switch($element->getTag())
    @case('stack')
        @stack($element->name)
        @break
    @case('include')
        @include($element->name, $element->with ?? [])
        @break
    @case('yield')
        @yield($element->name)
        @break
    @case('section')
        @section($element->name)
            @isset($element->items)
                {!! $element->items->renderItems() !!}
            @endisset
        @endsection
        @break
    @case('push')
        @push($element->name)
            @isset($element->items)
                {!! $element->items->renderItems() !!}
            @endisset
            {!! $element->getText() !!}
        @endpush
        @break
@endswitch
