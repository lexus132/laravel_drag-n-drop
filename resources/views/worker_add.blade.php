@extends('layouts.app')

@section('content')
    
    <div class="container">
	@if(!empty($data['id']))
	    <h1>{{ 'Изменить запись' }}</h1>
        @else
	    <h1>{{ 'Добавить запись' }}</h1>
	@endif
	<hr>
        <div class="row">
	    {!! Form::open(['url' => route('save_item'), 'id' => "add_worker", 'type' => 'POST',  'class' => "form-horizontal", 'role' => "form", 'enctype' => "multipart/form-data" ]) !!}
	    {!! Form::hidden('ident', (!empty($data['id']))? $data['id'] : '' ) !!}
	    <!-- left column -->
	    <div class="col-md-3  text-center">
		  <a href="@if(!empty($data['avatar'])){{ $data['avatar'] }}@else#@endif" class="media-lightbox" data-gallery>
		      <img src="@if(!empty($data['avatar'])){{ $data['avatar'] }}@else{{ '/img/no-image.png' }} @endif" id="item_img" style="max-width: 100%;border-radius: 50%;" />
		  </a>
		  <br>
		  <a style="font-size: 3em;position: relative;top: -57px;right: 40%;" href="#" class="media-button media-choose"><span class="glyphicon glyphicon-download-alt" aria-hidden="true"></span></a>
		  <a style="font-size: 3em;position: relative;top: -57px;left: 40%;" href="#" class="media-button media-remove @if(empty($data['avatar'])) hidden @endif"><span class="glyphicon glyphicon-trash" aria-hidden="true"></span></a>
	      {!! Form::hidden('remove_img', 0, ['id' => 'remove_img']) !!}
	      {!! Form::file('img', ['id' => 'fileupload', 'class' => 'hidden', 'accept' => implode(',.', Config::get('app.allowed_image_extension')) ]) !!}

	    </div>

          <!-- edit form column -->
          <div class="col-md-9 personal-info">
            <h3>Личный данные</h3>
	    <div class="form-group">
                <label class="col-lg-3 control-label">Фамилия:</label>
                <div class="col-lg-9">
		    {!! Form::text('surname', (!empty($data['surname']))? $data['surname'] : '' , [ 'class' => 'form-control', 'maxlength' => 150 ]) !!}
                </div>
	    </div>
	    <div id="other-errors">
                
	    </div>
	    <div class="form-group">
                <label class="col-lg-3 control-label">Имя:</label>
                <div class="col-lg-9">
		    {!! Form::text('name', (!empty($data['name']))? $data['name'] : '' , [ 'class' => 'form-control', 'maxlength' => 150 ]) !!}
                </div>
	    </div>
	    <div class="form-group">
                <label class="col-lg-3 control-label">Отчество:</label>
                <div class="col-lg-9">
		    {!! Form::text('middle_name', (!empty($data['middle_name']))? $data['middle_name'] : '' , [ 'class' => 'form-control', 'maxlength' => 150 ]) !!}
                </div>
	    </div>
	    <div class="form-group">
                <label class="col-lg-3 control-label">Должность:</label>
                <div class="col-lg-9">
		    {!! Form::text('position', (!empty($data['position']))? $data['position'] : '' , [ 'class' => 'form-control', 'maxlength' => 150 ]) !!}
                </div>
	    </div>
	    <div class="form-group">
                <label class="col-lg-3 control-label">Оклад:</label>
                <div class="col-lg-9">
		    {!! Form::number('salary', (!empty($data['salary']))? $data['salary'] : '' , [ 'class' => 'form-control', 'maxlength' => 150 ]) !!}
                </div>
	    </div>
	    @if(!empty($head))
	      <div id="work-lines-isset" class="form-group">
                <label class="col-lg-3 control-label">Руководитель:</label>
		<div class="col-lg-7">
		    {{ $head }}
		</div>
		<div class="col-lg-2">
		    <a class="btn btn-md btn-info" href="javascript:void(0)">
			<b>Изменить</b>
		    </a>
		</div>
              </div>
	      <div id="work-lines" class="form-group" hidden>
		   <label class="col-lg-3 control-label">Руководитель:</label>
		   @if(!empty($lines))
			<div class="col-lg-9">
			  <div class="ui-select">
			      {!! Form::select('head-lines', (!empty($lines))? $lines : null, null, [ 'class' => 'form-control']) !!}
			  </div>
			</div>
		    @endif
	      </div>
		  <div class="form-group" id="for_work_head">
		      {!! Form::hidden('head', (!empty($data['head']))? $data['head'] : '' ) !!}
		  </div>
	    @else
	      <div id="work-lines" class="form-group">
                <label class="col-lg-3 control-label">Руководитель:</label>
		@if(!empty($lines))
		    <div class="col-lg-9">
			<div class="ui-select">
			    {!! Form::select('head-lines', (!empty($lines))? $lines : null, null, [ 'class' => 'form-control']) !!}
			</div>
		    </div>
		@endif
              </div>
	      <div class="form-group" id="for_work_head">
              </div>
	    @endif
	    <div class="form-group">
                <label class="col-lg-3 control-label">Дата принятия на работу:</label>
                <div class="col-lg-9">
		    {!! Form::text('employment', (!empty($data['employment']))? Carbon::createFromFormat('Y-m-d H:i:s',$data['employment'])->format('Y-m-d') : null , [ 'class' => 'form-control', 'id' => 'date', 'readonly', 'required' ]) !!}
                </div>
	    </div>
	    <div class="form-group">
                <label class="col-md-3 control-label"></label>
                <div class="col-md-9">
		  {{ Form::submit('Сохранить', array('class' => 'btn btn-primary')) }}
                </div>
            </div>
	    
          </div>
	{!! Form::close() !!}
      </div>
	 <hr>
    </div>

@endsection