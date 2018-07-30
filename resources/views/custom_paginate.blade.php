@if(!empty($data))
    <ul class="pagination">
	@foreach($data as $item)
	    @if(!empty($item['href']))
	    @endif
	    @if(!empty($item['name']) and ($item['name'] == '«' or $item['name'] == '»'))
		@if(!empty($item['active']) and ($item['active'] == 'disabled'))
		    <li class="disabled">
			<span>{{ $item['name'] }}</span>
		    </li>
		@else
		    <li>
			<a class="page-{{ $item['href'] }}" href="javascript:void(0)">{{ $item['name'] }}</a>
		    </li>
		@endif    
	    @elseif(!empty($item['active']) and ($item['active'] == 'active'))
		<li class="active">
		    <span>{{ $item['name'] }}</span>
		</li>
	    @elseif(!empty($item['active']) and ($item['active'] == 'disabled'))
		<li class="disabled">
			<span>{{ $item['name'] }}</span>
		</li>
	    @else
		<li>
		    <a class="page-{{ $item['name'] }}" href="javascript:void(0)">{{ $item['name'] }}</a>
		</li>
	    @endif
	<li>
	@endforeach
    </ul>

    <script>
	$('div#custom-paginate a').each(function(i,elemA){
	    $(elemA).on('click', function(){
		var page = parseInt(($(elemA).attr('class')).split('-')[1], 10) || 1;
		var sure = $('#sure').val(),
		    name = $('#name').val(),
		    middle = $('#middle').val(),
		    position = $('#position').val(),
		    salary = $('#salary').val(),
		    inner = $('#inner').val(),
		    csrf_token = $('#sure').prev().val();

//		if(sure.length > 0 ||
//			name.length > 0  ||
//			middle.length > 0 ||
//			position.length > 0 ||
//			salary.length > 0 ||
//			inner.length > 0 )
//		{
		    var line = 'p='+page+'&name='+name+'&sure='+sure+'&middle='+middle+'&position='+position+'&salary='+salary+'&inner='+inner;
		    getData(line,csrf_token);
//		}

	    });
	});
    </script>
@endif