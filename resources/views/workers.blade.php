@if(!empty($data['workers']))
    @foreach($data['workers'] as $item)
	<tr>
	    <td><a href="{{ route('see_item', ['ident' => $item->id ]) }}">{{ $item->surname }}</a></td>
	    <td><a href="{{ route('see_item', ['ident' => $item->id ]) }}">{{ $item->name }}</a></td>
	    <td><a href="{{ route('see_item', ['ident' => $item->id ]) }}">{{ $item->middle_name }}</a></td>
	    <td>{{ $item->position }}</td>
	    <td>{{ $item->salary }}</td>
	    <td>{{ $item->employment }}</td>
	    <td><img style="width: 70px; border-radius: 15px;" title="{{ $item->avatar['title'] }}" src="{{ $item->avatar['url'] }}"></td>
	    <td>
		<a class="btn btn-sm btn-primary" href="{{ route('edit_item', ['edit' => $item->id ]) }}">
		    <b>Edit</b>
		</a>
		<a class="btn btn-sm btn-danger" onclick="dellItem({{ $item->id }}, '{{ route('dell_worker') }}');return false;" href="javascript:void(0)">
		    <b>Delete</b>
		</a>
	    </td>
	</tr>
    @endforeach
@endif