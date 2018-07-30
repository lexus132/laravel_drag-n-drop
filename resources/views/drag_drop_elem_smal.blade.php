<div style="border-radius: 5px;background: #8eb4cb;margin: 5px; padding: 3px;" class="draggable">
    {{ $data->surname }} {{ $data->name }} 
    <a style="float: right;" my-data="{{ $data->id }}" title="Подробнее" href="javascript:void(0)" onclick="createNewElement({{ $data->id }});return false;"><span class="ui-icon ui-icon-play"></span>
    </a>
</div>