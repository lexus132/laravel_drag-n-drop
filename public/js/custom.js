jQuery(function ($) {
        $.datepicker.regional['ru'] = {
            closeText: 'Закрыть',
            prevText: '&#x3c;Пред',
            nextText: 'След&#x3e;',
            currentText: 'Сегодня',
            monthNames: ['Январь', 'Февраль', 'Март', 'Апрель', 'Май', 'Июнь',
            'Июль', 'Август', 'Сентябрь', 'Октябрь', 'Ноябрь', 'Декабрь'],
            monthNamesShort: ['Январь', 'Февраль', 'Март', 'Апрель', 'Май', 'Июнь',
            'Июль', 'Август', 'Сентябрь', 'Октябрь', 'Ноябрь', 'Декабрь'],
            dayNames: ['воскресенье', 'понедельник', 'вторник', 'среда', 'четверг', 'пятница', 'суббота'],
            dayNamesShort: ['вск', 'пнд', 'втр', 'срд', 'чтв', 'птн', 'сбт'],
            dayNamesMin: ['Вс', 'Пн', 'Вт', 'Ср', 'Чт', 'Пт', 'Сб'],
            weekHeader: 'Нед',
            dateFormat: 'yy-mm-dd',
            firstDay: 1,
            isRTL: false,
            showMonthAfterYear: false,
            yearSuffix: ''
        };
        $.datepicker.setDefaults($.datepicker.regional['ru']);
    });

function dellItem(id, link){
    $.ajax({
	url:link,
	type: 'POST',
	data: 'ident='+id,
	dataType: 'json',
	headers:{
	    'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content') || ''
	},
	success: function (response) {
//	    console.log(response);
	    if(response.successful){
		window.location.reload();
	    }
	},
	error: function(response){
//	    console.log(response);
	}
    });
}

function createNewElement(ident){
//    console.log(ident);
    $.ajax({
	url: '/add-elem-dragn',
	type: 'POST',
	data: 'ident='+ident,
	dataType: 'json',
	headers:{
	    'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')
	},
	success: function (response) {
//	    console.log(response);
	    if(response.successful){
		$('#containment-wrapper').append(response.successful);
		wenNewItemReady();
	    }
	},
	error: function(response){
//	    console.log(response);
	}
    });
}

function updateHead(ident, head = 0){
    $.ajax({
	url: '/drope-head',
	type: 'POST',
	data: 'ident='+ident+'&head='+head,
	dataType: 'json',
	headers:{
	    'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')
	},
	success: function (response) {
	    if(response.successful){
		if(head > 0){
		    $('div#show-workers-'+head).append(response.successful);
		    wenNewItemReady();
		} else if(head == 0){
		    $('#containment-wrapper').append(response.successful);
		    wenNewItemReady();
		}
//		return true;
	    }
	},
	error: function(response){
//	    console.log(response);
	}
    });
}

function getData(line, token){
    $.ajax({
	url:"/serch-name",
	type: 'POST',
	data: line,
	dataType: 'json',
	headers:{
	    'X-CSRF-Token': token
	},
	success: function (response) {
	    if(response.errors){
		$('#content-workers').html('');
		$('#custom-paginate').html('<div class="alert alert-warning"><strong>По данному запросу</strong> нет результатов!</div>');
	    } else if(response.successful){
		if((response.successful['workers']).length > 0){
		    $('#content-workers').html(response.successful['workers']);
		}
		if((response.successful['counter']).length > 0){
		    $('#custom-paginate').html(response.successful['counter']);
		}
	    }
	},
	error: function(response){
//	    console.log(response);
	}
    });
}

function showHead(ident){
    $('#show-head-'+ident).toggle();
}

function showWorkers(ident){
    $('#show-workers-'+ident).toggle();
}

$(document).ready(function(){
   wenDocReady();
    	
    $('.from-post').keyup(function(){
	var sure = $('#sure').val(),
	    name = $('#name').val(),
	    middle = $('#middle').val(),
	    position = $('#position').val(),
	    salary = $('#salary').val(),
	    inner = $('#inner').val(),
	    csrf_token = $('meta[name="csrf-token"]').attr('content');
	
	    var line = 'name='+name+'&sure='+sure+'&middle='+middle+'&position='+position+'&salary='+salary+'&inner='+inner;
	    getData(line,csrf_token);
    });
    $('.from-post').first().trigger('keyup');
    
    $('a.order-by').each(function(i,elemA){
	$(elemA).on('click', function(){
	    var ord = ($(elemA).attr('id')).split('-')[1] || '';
	    var csrf_token = $('meta[name="csrf-token"]').attr('content');
	    $.ajax({
		url:"/save-ord",
		type: 'POST',
		data: 'ord='+ord,
		dataType: 'json',
		headers:{
		    'X-CSRF-Token': csrf_token
		},
		success: function (response) {
		    $('.from-post').first().trigger('keyup');
		},
		error: function(response){
	//	    console.log(response);
		}
	    });
	});
    });
    
    if(document.getElementById('headline')){
	var shineline = new Shine(document.getElementById('headline'));
	function handleMouseMoveLine(event) {
	    shineline.light.position.x = event.clientX;
	    shineline.light.position.y = event.clientY;
	    shineline.draw();
	}
	window.addEventListener('mousemove', handleMouseMoveLine, false);
    }
    
    if(document.getElementById('work-lines')){
	$('#work-lines select').change(function() {
	    $( "#work-lines option:selected" ).each(function(){
		var line = $(this).val();
		var csrf_token = $('meta[name="csrf-token"]').attr('content');
		if(line != 0){
		    $.ajax({
			url:"/gat-heads",
			type: 'POST',
			data: 'line='+line,
			dataType: 'json',
			beforeSend: function(){
			    $('div#for_work_head').html('');
			},
			headers:{
			    'X-CSRF-Token': csrf_token
			},
			success: function (response) {
//			    console.log(response);
			    if(response.errors){
			    } else if(response.successful){
				if((response.successful['workers']).length > 0){
				    $('div#for_work_head').html(response.successful['workers']);
				}
			    }
			},
			error: function(response){
//			    console.log(response);
			}
		    });
		} else {
		    $('div#for_work_head').html('');
		}
	    });
	});
	
	$('#work-lines-isset a').on('click', function(){
	    $('#for_work_head').html('');
	    $('#work-lines-isset').hide();
	    $('#work-lines').show();
	});
	
	$("#date").datepicker({
            'minView'    : 'month',
            'autoclose'  : true,
	    changeMonth: true,
	    changeYear: true,
        }, $.datepicker.regional['ru']);
	
	// Choose an image
	$('.media-choose').on('click', function(e) {
	    e.preventDefault();
	    $('#fileupload').click();
	});

	// Remove an image
	$('.media-remove').on('click', function(e) {
	    e.preventDefault();
	    $('#item_img').attr('src', '');
	    $('.media-lightbox').attr('href', '#');
	    $('.media-remove').addClass('hidden');
	    $('#remove_img').val(1);
	    $('#fileupload').val('');
	});
            
	// Disable lightbox if there is no image
	$('.media-lightbox').on('click', function(e) {
	    if($(this).attr('href') == '#') {
		e.preventDefault();
		$('#fileupload').click();
		return false;
	    }
	});
            
	// Img preview when user changes it
	$('#fileupload').change(function(e) {
	    loadImage(
		e.target.files[0],
		function(img) {
		    var src = $(img).attr('src');
		    $('#item_img').attr('src', src);
		    $('.media-lightbox').attr('href', src);
		    $('.media-remove').removeClass('hidden');
		    $('#remove_img').val(0);
		},
		{
		    noRevoke: true,
		}
	    );
	});
	
	$('form#add_worker').on('submit', function(e){
	    $('div.error-message').remove();
	    e.preventDefault();
	    var csrf_token = $('meta[name="csrf-token"]').attr('content');
	    var form = new FormData(document.getElementById('add_worker'));
	    if(($('#fileupload').val()).length > 0){
		form.append('img', document.getElementById('fileupload'));
	    }
	    $.ajax($('form#add_worker').attr('action'), {
		type: 'POST',
		data: form,
		processData: false,
		contentType: false,
		headers:{
		    'X-CSRF-Token': csrf_token
		},
		success: function (response) {
		    console.log(response);
		    if(response.errors){
			for(var i in response.errors){
			    if($('form#add_worker').find("input[name=" + i + "]")){
				$('form#add_worker').find("input[name=" + i + "]").after('<div style="color:red;" class="error-message"><span>'+ response.errors[i] +'</span></div>');
			    }
			}
		    } else if(response.successful){
			window.location = response.successful;
		    }
		},
		error: function(response) {
		    console.log(response);
		}
	    });
	    return false;
	});
    }
    
    
});
    
function wenNewItemReady(){
    $( function() {
	$( "div.draggable-block" ).draggable({
	    containment: "#containment-wrapper",
//		scroll: false,
	    revert: true,
	    cursor: "move",
//		cursorAt: { top: 56, left: 56 },
//		stack: ".draggable-block"
	});

	$( ".draggable" ).draggable({
	    containment: "#containment-wrapper",
//		scroll: false,
	    revert: true,
	    cursor: "move",
//		cursorAt: { top: 56, left: 56 },
	    stack: ".draggable"
	});

	$( "#containment-wrapper, .show-workers" ).droppable({
	    greedy: true,
	    drop: function( event, ui ) {
		var head = '';
		var worker = '';
//		console.log($(this));
//		console.log(ui.draggable);
		if($( this ).hasClass('show-workers')){
		    var tempHead = $( this ).closest('div.draggable-block').find('h3 a').first().attr('data');
			head = parseInt(tempHead.substr(tempHead.lastIndexOf('\/') + 1), 10);
		    var worker = parseInt($( ui.draggable ).find('a').first().attr('my-data'), 10);
		}
		if($( ui.draggable ).find('a').first().attr('my-data')){
		    worker = parseInt($( ui.draggable ).find('a').first().attr('my-data'), 10);
		} else if($( ui.draggable ).find('h3 a').first().attr('data')){
		    var tempWorker = $( ui.draggable ).find('h3 a').first().attr('data');
			worker = parseInt(tempWorker.substr(tempWorker.lastIndexOf('\/') + 1), 10);
		}
		if((head > 0) && (worker > 0)){
		    updateHead(worker, head);
		    $(ui.draggable).remove();
		}
		console.log('head = '+head);
		console.log('worker = '+worker);
	    return false;
	    }
	});

	$( ".sortable" ).sortable({
	    connectWith: ".disableSelection",
	    accept: "ul.sortable li",
//		revert: "invalid",
//		drop: function( event, ui ) {
//		    console.log( ui.draggable )
//		    dropeItem( ui.draggable )
//		}
	}).disableSelection();

	$('#containment-wrapper').droppable({
	    accept: ".draggable-block, .draggable",
//		revert: "invalid",
	    drop: function( event, ui ) {
//		console.log($(ui.draggable).hasClass('draggable'));
		if($(ui.draggable).hasClass('draggable')){
		    var r = confirm("Вы уверены, что хотите убрать выбраного работника из этого списка?");
		    if (r == true) {
			ui.draggable.fadeOut(function() {
			    var item = ui.draggable.find('a[title="Подробнее"]').attr('my-data');
			    updateHead(item);
    //			ui.draggable.remove();
			});
		    } else {
			return false;
		    }
		}
	    }
	});
    });
}

function wenDocReady(){
    if($('.draggable')[0]){
	
	$('div.container').last().attr('style', 'margin:0px;width:100%;');
	
	wenNewItemReady();
	
	$( function() {
	    $( document ).tooltip({
		items: "img, [data-geo], [title]",
		content: function() {
		    var element = $( this );
		    if ( element.is( "[data-geo]" ) ) {
			var text = $('<div></div>').load( element.attr('data')+' #rezult');
			$(element).on('click', function(){ return null; });
			return text;
		    }
		    if ( element.is( "[title]" ) ) {
			return element.attr( "title" );
		    }
		    if ( element.is( "img" ) ) {
			return element.attr( "alt" );
		    }
		},
		position: {
//		    my: "center bottom-20",
//		    at: "center top",
		    using: function( position, feedback ) {
			$( this ).css( position );
			$( "<div>" )
			    .addClass( "arrow" )
			    .addClass( feedback.vertical )
			    .addClass( feedback.horizontal )
			    .appendTo( this );
		    }
		}
	    });
	});
    }
}