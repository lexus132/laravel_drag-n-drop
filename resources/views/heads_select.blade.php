@if(!empty($data))
    <label class="col-lg-3 control-label"></label>
    <div class="col-lg-9">
      <div class="ui-select">
	<select name="head" class="form-control">
	    @foreach($data as $value)
		<option value="{{ $value->id }}">{{ $value->surname }} {{ $value->name }} {{ $value->middle_name }} {{ $value->position }}</option>
	    @endforeach
	</select>
      </div>
    </div>
@endif