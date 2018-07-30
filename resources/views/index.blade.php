@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="table-responsive">
	    <table class="table table-striped table-hover">
		<tbody>
		    <tr style="border-bottom: 2px solid #000;">
			<th style="text-align: center;vertical-align:middle;"><a id="ord-s" class="order-by" href="javascript:void(0)">Фамилия</a></th>
			<th style="text-align: center;vertical-align:middle;"><a id="ord-n" class="order-by" href="javascript:void(0)">Имя</a></th>
			<th style="text-align: center;vertical-align:middle;"><a id="ord-m" class="order-by" href="javascript:void(0)">Отчество</a></th>
			<th style="text-align: center;vertical-align:middle;"><a id="ord-p" class="order-by" href="javascript:void(0)">Должность</a></th>
			<th style="text-align: center;vertical-align:middle;"><a id="ord-sal" class="order-by" href="javascript:void(0)">Оклад</a></th>
			<th style="text-align: center;vertical-align:middle;"><a id="ord-in" class="order-by" href="javascript:void(0)">Дата принятия на рабту</a></th>
			<!--<th class="action-buttons">Actions</th>-->
		    </tr>
		    
		    <tr>
			<th style="text-align: center;padding:0px;">
			    <div class="form-group" style="margin-bottom:0px;">{{ csrf_field() }}
				<input id="sure" type="text" class="form-control from-post" placeholder="Фамилия">
			    </div>
			</th>
			<th style="text-align: center;padding:0px;">
			    <div class="form-group" style="margin-bottom:0px;">{{ csrf_field() }}
				<input id="name" type="text" class="form-control from-post" placeholder="Имя">
			    </div>
			</th>
			<th style="text-align: center;padding:0px;">
			    <div class="form-group" style="margin-bottom:0px;">{{ csrf_field() }}
				<input id="middle" type="text" class="form-control from-post" placeholder="Отчество">
			    </div>
			</th>
			<th style="text-align: center;padding:0px;">
			    <div class="form-group" style="margin-bottom:0px;">{{ csrf_field() }}
				<input id="position" type="text" class="form-control from-post" placeholder="Должность">
			    </div>
			</th>
			<th style="text-align: center;padding:0px;">
			    <div class="form-group" style="margin-bottom:0px;">{{ csrf_field() }}
				<input id="salary" type="text" class="form-control from-post" placeholder="Оклад">
			    </div>
			</th>
			<th style="text-align: center;padding:0px;">
			    <div class="form-group" style="margin-bottom:0px;">{{ csrf_field() }}
				<input id="inner" type="text" class="form-control from-post" placeholder="Дата принятия на рабту">
			    </div>
			</th>
			<!--<th class="action-buttons">Actions</th>-->
		    </tr>
		<tbody>
	</table>
	    <table class="table table-striped table-hover">
		<thead>
		    <tr>
			<td style="text-align: center;"><b>Фамилия</b></td>
			<td style="text-align: center;"><b>Имя</b></td>
			<td style="text-align: center;"><b>Отчество</b></td>
			<td style="text-align: center;"><b>Должность</b></td>
			<td style="text-align: center;"><b>Оклад</b></td>
			<td style="text-align: center;"><b>Дата принятия на рабту</b></td>
			<td style="text-align: center;"><b>Фото</b></td>
			<td></td>
		    </tr>
		</thead>
		<tbody id="content-workers">
		</tbody>
	    </table>
	    <div id="custom-paginate">
	    </div>
	</div>
    </div>
</div>

@endsection
