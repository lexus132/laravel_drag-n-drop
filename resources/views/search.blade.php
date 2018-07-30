@extends('layouts.app')

@section('content')
<div class="container">
    @if(!empty($data['search']))
	<div class="row">
	    <h2>Результаты поиска по запросу "{{ $data['search'] }}"</h2>
	</div>
    @endif
    <div class="row">
        <div class="table-responsive">
	    <table class="table table-striped table-hover">
		<tbody>
		    <tr style="border-bottom: 2px solid #000;">
			<th style="text-align: center;">Фамилия</th>
			<th style="text-align: center;">Имя</th>
			<th style="text-align: center;">Отчество</th>
			<th style="text-align: center;">Должность</th>
			<th style="text-align: center;">Оклад</th>
			<th style="text-align: center;">Дата принятия на рабту</th>
			<!--<th class="action-buttons">Actions</th>-->
		    </tr>

		    @if(!empty($data['rezult']))
			@foreach($data['rezult'] as $item)
			
			    <tr>
				<td>{{ $item->surname }}</td>
				<td>{{ $item->name }}</td>
				<td>{{ $item->middle_name }}</td>
				<td>{{ $item->position }}</td>
				<td>{{ $item->salary }}</td>
				<td>{{ $item->employment }}</td>
<!--				<td>
				    <a class="btn btn-sm btn-primary btn-edit" data-id="1">
					<span data-id="1" class="glyphicon glyphicon-pencil"></span>
				    </a>
				    <a class="btn btn-sm btn-danger btn-delete" data-id="1">
					<span data-id="1" class="glyphicon glyphicon-trash"></span>
				    </a>
				</td>-->
			    </tr>

			@endforeach
		    @endif
		</tbody>
	    </table>
	    {{ $data['rezult']->appends(['s' => $data['search']])->links() }}
	</div>
    </div>
</div>

@endsection
