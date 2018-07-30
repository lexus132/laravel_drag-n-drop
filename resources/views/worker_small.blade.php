<div id="rezult" class="container" style="max-width: 270px;">
    <h4>{{ $data->surname.' '.$data->name.' '.$data->middle_name }}</h4>
    @if(!empty($data->avatar))
	<div class="row">
	    <div class="col-md-3  text-center">
		<img style="max-width: 200px;border-radius: 50%; margin: auto;" src="{{ $data->avatar->url }}" id="item_img" />
	    </div>
	</div>
    @endif
    <div class="row" style="padding:5px;">
	<p><b>Должность: </b> {{ $data->position }}</p>
	<p><b>Оклад:</b> {{ $data->salary }}
	<p><b>Дата принятия на работу:</b> {{ Carbon::createFromFormat('Y-m-d H:i:s',$data->employment)->format('d-m-Y') }}
    </div>
</div>