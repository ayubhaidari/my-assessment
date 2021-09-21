<!-- text input -->
@include('crud::fields.inc.wrapper_start')
    @include('crud::fields.inc.translatable_icon')

    @if(isset($field['prefix']) || isset($field['suffix'])) <div class="input-group"> @endif
        @if($entry->reciept != null)
            @if(File::exists(public_path(substr($entry->reciept,7))))
                <a id="bCard" target="_blank" href="{{ url(substr($entry->reciept,7)) }}">
                    <img src="{{ asset(substr($entry->reciept,7)) }}" width="280" height="240">
                </a>
            @endif
        @endif
    @if(isset($field['prefix']) || isset($field['suffix'])) </div> @endif

    {{-- HINT --}}
    @if (isset($field['hint']))
        <p class="help-block">{!! $field['hint'] !!}</p>
    @endif
@include('crud::fields.inc.wrapper_end')
