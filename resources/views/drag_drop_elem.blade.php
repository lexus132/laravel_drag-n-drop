<div head-data="head-{{ $data->id }}" style="border: 1px solid rgb(0, 0, 0); margin: 10px; border-radius: 5px; padding: 10px; left: 0px; top: 0px;" class="ui-widget-content draggable-block col-sm-3 col-md-2 col-xs-3 alert ui-draggable ui-draggable-handle">
    <a style="position: relative;top: -8px;" href="javascript:void(0)" class="close" data-dismiss="alert" aria-label="close" title="Close block">×</a>
    <h3 style="font-size:16px;">
	<a data="{{ route('see_worker', ['ident' => $data->id ]) }}" href="javascript:void(0);" data-geo="">{{ $data->surname }} {{ $data->name }} {{ $data->middle_name }}</a>
    </h3>
    @if(!empty($data->header))
	<a onclick="showHead({{ $data->id }}); return null;" class="btn btn-info show-head" href="javascript:void(0)">Руководитель</a>
	<p id="show-head-{{ $data->id }}" style="padding: 5px;" hidden>
	    <a  data="{{ route('see_worker', ['ident' => $data->header->id ]) }}" href="javascript:void(0);" data-geo="">{{ $data->header->surname }} {{ $data->header->name }}</a></p>
    @endif
    @if(!empty($data->heads) and (count($data->heads) > 0))
	<a onclick="showWorkers({{ $data->id }}); return null;" class="btn btn-info show-workers" href="javascript:void(0)">Подчиненные</a>
	<div id="show-workers-{{ $data->id }}" class="show-workers ui-droppable" style="background: #fff;width: 100%;border-radius: 5px;" hidden>
	    @foreach($data->heads as $worker)
		<div style="border-radius: 5px;background: #8eb4cb;margin: 5px; padding: 3px;" class="draggable ui-draggable ui-draggable-handle">{{ $worker->surname }} {{ $worker->name }} <a style="float: right;" my-data="{{ $worker->id }}" title="Подробнее" href="javascript:void(0)" onclick="createNewElement({{ $worker->id }});return false;"><span class="ui-icon ui-icon-play"></span></a></div>
	    @endforeach
	</div>
    @endif
</div>