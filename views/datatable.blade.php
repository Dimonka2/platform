<table class="table table-hover {{$element->class ?? ''}}" id="{{$element->id}}" width="100%">
</table>

@push($context->getJsStack())

    <script type="text/javascript">
        @php($select = $element->getSelect())

        @if($element->hasDetails())
        @php($details = $element->getDetails())
        function format_{{Str::camel($element->id)}}( rowData ) {
            @if( $details->format_function )
                {!! $details->format_function !!}
            @endif

            var div = $('<div/>').addClass( 'loading' ).text( 'Loading...' );
            var self = this;
            @if( $details->getHasAjax() )
            $.ajax( {
                url: '{{ $details->getUrl() }}',
                data: {
                    '_token': "{{csrf_token()}}",
                    {!! $details->getDataDefinition() ?? ''!!}
                },
                "dataType": "json",
                "method": "{{ $details->getAjaxMethod() }}",
                success: function ( json ) {
                    div.html( json.html ).removeClass( 'loading' );
                    @if( $details->loaded_function )
                        {!! $details->loaded_function !!}
                    @endif
                },
                error: function ( error ) {
                    // console.log(error);
                    div.html( error.responseJSON.error ).removeClass( 'loading' ).addClass('bg-danger text-white p-2');
                }
            } );
            @endif
            return div;
        }

        var detailRows_{{Str::camel($element->id)}} = [];
        function bindDetails() {
            $('#{{$element->id}} tbody tr').on( 'click', 'td.{{trim($details->class)}}', function () {
                var dt = $('#{{$element->id}}').DataTable();
                var tr = $(this).closest('tr');
                var row = dt.row( tr );
                var idx = $.inArray( tr.attr('id'), detailRows_{{Str::camel($element->id)}} );

                if ( row.child.isShown() ) {
                    tr.removeClass( 'details' );
                    row.child.hide();

                    // Remove from the 'open' array
                    detailRows_{{Str::camel($element->id)}}.splice( idx, 1 );
                }
                else {
                    tr.addClass( 'details' );
                    row.child( format_{{Str::camel($element->id)}}( row.data() ) ).show();

                    // Add to the 'open' array
                    if ( idx === -1 ) {
                        detailRows_{{Str::camel($element->id)}}.push( tr.attr('id') );
                    }
                }
            } );
        }
        @endif


        @isset($element->js_variable)
        var {{$element->js_variable}} = false;
        @endisset

        $(document).ready(function () {
            @isset($element->js_variable)
                {{$element->js_variable}} =
            @endisset $('#{{$element->id}}').DataTable({
                "processing": true,
                "serverSide": true,
            @if(config('flatform.assets.datatable_lang', '') != '')
                "language": {
                    "url": "{{ asset(config('flatform.assets.datatable_path'). \App::getLocale() . '.json' ) }}"
                },
            @endif
                {!! $element->getTableOptions() !!}

                "ajax":{
                        "url": "{{ $element->ajax_url }}",
                        "dataType": "{{ $element->ajax_dataType ?? 'json' }}",
                        "type": "{{ $element->ajax_method ?? 'GET' }}",
                        "data": function ( d ) {
                            d._token = "{{csrf_token()}}";
                            {!! $element->ajax_data_function ?? '' !!}
                        }
                }

            });

            @if($element->hasDetails() )
                var dt = $('#{{$element->id}}').DataTable();
                dt.on('draw', function () {
                    bindDetails();
                    $.each( detailRows_{{Str::camel($element->id)}}, function ( i, id ) {
                        $('#'+id+' td.{{trim($details->class)}}').trigger( 'click' );
                    } );
                });
            @endif

    });
    </script>

@endpush


