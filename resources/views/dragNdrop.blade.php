@extends('layouts.app')

@section('content')
<div class="container">
    <div id="containment-wrapper" class="row" style="min-height: 550px; border:1px solid #ccc; padding: 10px; margin-bottom: 20px;">
	@if(!empty($data))
	    @foreach($data as $value)
	    <div head-data="head-{{ $value->id }}" style="border: 1px #000 solid;margin: 10px;border-radius: 5px;padding: 10px;" class="ui-widget-content draggable-block col-sm-3 col-md-2 col-xs-3 alert">
		<a style="position: relative;top: -8px;" href="javascript:void(0)" class="close" data-dismiss="alert" aria-label="close" title="Close block">×</a>
		<h3 style="font-size:16px;"><a data="{{ route('see_worker', ['ident' => $value->id ]) }}" href="javascript:void(0);" data-geo="">{{ $value->surname }} {{ $value->name }} {{ $value->middle_name }}</a></h3>
		@if(!empty($value->header))
		    <a onclick="showHead({{ $value->id }}); return null;" class="btn btn-info show-head" href="javascript:void(0)">Руководитель</a>
		    <p id="show-head-{{ $value->id }}"  style="padding: 5px;" hidden>
			<a  data="{{ route('see_worker', ['ident' => $value->header->id ]) }}" href="javascript:void(0);" data-geo="">{{ $value->header->surname }} {{ $value->header->name }}</a></p>
		@endif
		@if(!empty($value->heads) and (count($value->heads) > 0))
		    <a onclick="showWorkers({{ $value->id }}); return null;" class="btn btn-info show-workers" href="javascript:void(0)">Подчиненные</a>
		    <div id="show-workers-{{ $value->id }}" class="show-workers" style="background: #fff;width: 100%;border-radius: 5px;" hidden>
			@foreach($value->heads as $worker)
			    <div style="border-radius: 5px;background: #8eb4cb;margin: 5px; padding: 3px;" class="draggable">{{ $worker->surname }} {{ $worker->name }} <a style="float: right;" my-data="{{ $worker->id }}" title="Подробнее" href="javascript:void(0)" onclick="createNewElement({{ $worker->id }});return false;"><span class="ui-icon ui-icon-play"></span></a></div>
			@endforeach
		    </div>
		@endif
	    </div>
	    @endforeach
	@endif
    </div>
</div>

@endsection
