@extends('layouts.app')

@section('content')
    
    <div class="container">
	<h1>{{ $data->surname.' '.$data->name.' '.$data->middle_name }}</h1>
	<hr>
	<form class="form-horizontal">
        <div class="row">
          <!-- left column -->
          <div class="col-md-3  text-center">
		<img src="@if(!empty($data->avatar)){{ $data->avatar->url }}@else{{ '/img/no-image.png' }} @endif" id="item_img" style="max-width: 100%;border-radius: 50%;" />
          </div>

          <!-- edit form column -->
          <div class="col-md-9 personal-info">
            <h3>Личный данные</h3>
	    <div class="form-group">
                <div class="col-lg-3">Фамилия:</div>
                <div class="col-lg-9">
		    {{ $data->surname }}
                </div>
	    </div>
	    <div class="form-group">
                <div class="col-lg-3">Имя:</div>
                <div class="col-lg-9">
		    {{ $data->name }}
                </div>
	    </div>
	    <div class="form-group">
                <div class="col-lg-3">Отчество:</div>
                <div class="col-lg-9">
		    {{ $data->middle_name }}
                </div>
	    </div>
	    <div class="form-group">
                <div class="col-lg-3">Должность:</div>
                <div class="col-lg-9">
		    {{ $data->position }}
                </div>
	    </div>
	    <div class="form-group">
                <div class="col-lg-3">Оклад:</div>
                <div class="col-lg-9">
		    {{ $data->salary }}
                </div>
	    </div>
	    @if(!empty($data->header))
	      <div id="work-lines-isset" class="form-group">
                <div class="col-lg-3">Руководитель:</div>
		<div class="col-lg-9">
		    {{ $data->header->surname }} {{ $data->header->name }} {{ $data->header->middle_name }}<br>{{ $data->header->position }}
		</div>
              </div>
	    @endif
	    <div class="form-group">
                <div class="col-lg-3">Дата принятия на работу:</div>
                <div class="col-lg-9">
		    {{ Carbon::createFromFormat('Y-m-d H:i:s',$data['employment'])->format('Y-m-d') }}
                </div>
	    </div>
	    
	    
	    <div class="form-group">
                <div class="col-lg-3"></div>
                <div class="col-lg-9">
		    <a class="col-lg-3 btn btn-primary" href="{{ route('edit_item', ['ident' => $data->id ]) }}">Изменить</a>
                </div>
	    </div>
	    
	    
	    
          </div>
      </div>
	    </form>
	 <hr>
    </div>

@endsection