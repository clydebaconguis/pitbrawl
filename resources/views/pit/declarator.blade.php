@extends('pit.layouts.app')

@section('content')
	
  	<section class="content">
    <div class="container-fluid">
      	<div class="row pt-3">
          	<div class="col-md-12">
          		<h2>Events</h2>
          	</div>
        </div>
        <hr>
        <div class="row">
        	<div class="col-md-12">
        		<div class="row mb-2">
					<div class="col-md-6">
	        			
	        		</div>
	        		<div class="col-md-4">
	        			<div class="input-group">
							<input type="text" class="form-control float-right" id="event_filter" placeholder="Search Event" style="text-transform: uppercase">
		                    <div class="input-group-append">
			                    <span class="input-group-text">
			                    	<i class="fas fa-search"></i>
			                    </span>
		                    </div>
		                </div>
	        			
	        		</div>
	        		
	        		<div class="col-md-2">
	        			<button id="event_new" class="btn btn-primary btn-block">Create Event</button>
	        		</div>
		        </div>
        		<div class="row">
        			<div class="col-md-12">
		        		<div class="card card-outline card-dark">
		        			<div id="table_main" class="card-body table-responsive pt-0">
		        				<table class="table table-sm text-sm table-hover table-head-fixed text-nowrap">
		        					<thead>
		        						<tr>
											<th>EVENT NAME</th>
		        							<th>DATE OPENED</th>
		        							<th>MAX BET / PLAYER</th>
		        							<th>STATUS</th>
											<th></th>
		        						</tr>
		        					</thead>
		        					<tbody id="event_list" style="cursor:pointer"></tbody>
		        				</table>
		        			</div>
		        		</div>
		        	</div>
	        	</div>
        	</div>
        </div>
    </div>

  </section>
@endsection
@section('modal')
	


    <div class="modal fade show" id="modal-event" aria-modal="true" style="padding-right: 17px; display: none;">
        <div class="modal-dialog modal-md">
          	<div class="modal-content mt-3" style="margin-left: -17px;">
	            <div class="modal-header bg-dark">
	              <h4 class="modal-title">Event</span></h4>
	              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
	                <span aria-hidden="true">×</span>
	              </button>
	            </div>
	            <div class="modal-body text-sm btn-sm">
	              	<div class="row form-group">
						<div class="col-md-12">
							<label>EVENT NAME</label>
							<input id="event_name" type="text" class="form-control player_input">
						</div>
	              	</div>
					<div class="row form-group">
						<div class="col-md-12">
							<label>MAX BET PER PLAYER</label>
							<input id="event_maxbet" type="text" class="form-control player_input">
						</div>
	              	</div>
	              	<div class="row form-group">
						<div class="col-md-12">
							<label>BET MULTIPLIER</label>
							<input id="event_betmultiplier" type="text" class="form-control player_input">
						</div>
	              	</div>
	              	<div class="row form-group">
						<div class="col-md-12">
							<label>LIVE URL</label>
							<input id="event_liveurl" type="text" class="form-control player_input">
						</div>
	              	</div>
	              	<div class="form-group">
						<label for="exampleInputFile">Banner</label>
						<div class="input-group">
							<div class="custom-file">
								<input type="file" class="custom-file-input" id="event_banner">
								<label class="custom-file-label" for="event_banner">Choose file</label>
							</div>
							<div class="input-group-append">
								<span class="input-group-text">Upload</span>
							</div>
						</div>
					</div>

					
					<br>
					<hr>
					<div class="row">
						<div class="col-md-3">
							<button type="button" class="btn btn-default" data-dismiss="modal">
								Close
							</button>
						</div>
						<div class="col-md-3">
							
						</div>
						<div class="col-md-6 text-right">
							<button id="event_delete" class="btn btn-danger text-right" style="display:none">Delete</button>
							<button id="event_save" class="btn btn-primary" data-id="0">Save</button>
						</div>		
	              	</div>
				</div>
        	</div>
        </div>
    </div>


@endsection
@section('js')
<script>
	$(document).ready(function(){
		screenadjust();


		function forceKeyPressUppercase(e)
		{
		    var charInput = e.keyCode;
		    if((charInput >= 97) && (charInput <= 122)) { // lowercase
		      	if(!e.ctrlKey && !e.metaKey && !e.altKey) { // no modifier key
			        var newChar = charInput - 32;
			        var start = e.target.selectionStart;
			        var end = e.target.selectionEnd;
			        e.target.value = e.target.value.substring(0, start) + String.fromCharCode(newChar) + e.target.value.substring(end);
			        e.target.setSelectionRange(start+1, start+1);
			        e.preventDefault();
		      	}
		    }
		}

		$(function () {
  			bsCustomFileInput.init();
  		});

		// document.getElementById("items_description").addEventListener("keypress", forceKeyPressUppercase, false);
		// document.getElementById("items_partcode").addEventListener("keypress", forceKeyPressUppercase, false);
		// document.getElementById("items_brand").addEventListener("keypress", forceKeyPressUppercase, false);


	    function screenadjust()
	    {
	        var screen_height = $(window).height();
	        var screen_bg = $(window).height() - 59;
	        
	        $('#table_main').css('height', screen_height - 240);
	        $('table_sub').css('height', screen_height - 125);
	        // $('#table_oxy').css('height', screen_height - 875);
	    }

	    $('.select2').select2({
	        theme: 'bootstrap4'
	    });

	    function events()
	    {
	    	var filter = $('#event_filter').val()

	    	$.ajax({
	    		url: '{{route('event_generate')}}',
	    		type: 'GET',
	    		// dataType: 'default: Intelligent Guess (Other values: xml, json, script, or html)',
	    		data: {
	    			filter:filter
	    		},
	    		success:function(data)
	    		{
	    			$('#event_list').empty()
	    			var dateopened = moment()

	    			$.each(data, function(index, val) {
	    				dateopened = val.startdatetime

	    				$('#event_list').append(`
	    					<tr data-id="`+val.id+`">
	    						<td>`+val.eventname+`</td>
	    						<td>`+moment(dateopened).format('MM/DD/YYYY hh:mm A')+`</td>
	    						<td>`+val.maxbet+`</td>
	    						<td>`+val.eventstatus.toUpperCase()+`</td>
	    						<td>
	    							<button class="btn btn-sm btn-info btn-view">
	    								View
	    							</button>
	    							<button class="btn btn-sm btn-primary btn-edit">
	    								Edit
	    							</button>
	    							<button class="btn btn-sm btn-warning btn-fights">
	    								Fights
	    							</button>
	    						</td>
	    					</tr>
	    				`)
	    			});
	    		}
	    	});
	    	
	    }

	    function clearInputs()
	    {
	    	$('.player_input').val('');
	    	$('#event_save').attr('data-id', 0)
	    }

	    events()
		
	    $(document).on('click', '#event_new', function(){
	    	clearInputs()
	    	$('#modal-event').modal('show')
	    	setTimeout(function(){
	    		$('#event_name').focus()
	    	}, 300)
	    })

	

	    $(document).on('click', '#event_save', function(){
	    	var eventname = $('#event_name').val()
	    	var maxbet = $('#event_maxbet').val()
	    	var betmultiplier = $('#event_betmultiplier').val();
	    	var liveurl = $('#event_liveurl').val()
	    	var banner = $('#event_banner').val()
	    	var id = $('#event_save').attr('data-id')

	    	$.ajax({
	    		url: '{{route('event_save')}}',
	    		type: 'POST',
	    		headers: {
			        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
			    },
	    		// dataType: 'default: Intelligent Guess (Other values: xml, json, script, or html)',
	    		data: {
	    			eventname:eventname,
	    			maxbet:maxbet,
	    			liveurl:liveurl,
	    			banner:banner,
	    			betmultiplier:betmultiplier,
	    			id:id
	    		},
	    		success:function(data)
	    		{
	    			if(data == 'done')
	    			{
		    			const Toast = Swal.mixin({
						  toast: true,
						  position: 'top-end',
						  showConfirmButton: false,
						  timer: 3000,
						  timerProgressBar: true,
						  didOpen: (toast) => {
						    toast.addEventListener('mouseenter', Swal.stopTimer)
						    toast.addEventListener('mouseleave', Swal.resumeTimer)
						  }
						})

						Toast.fire({
						  icon: 'success',
						  title: 'Event has been created'
						})

						events()
						$('#modal-event').modal('hide');
					}
					else{

					}
	    		}
	    	});	
	    })

	    $(document).on('click', '.btn-edit', function(){
	    	var id = $(this).closest('tr').attr('data-id');

	    	$.ajax({
	    		url: '{{route('event_read')}}',
	    		type: 'GET',
	    		// dataType: 'default: Intelligent Guess (Other values: xml, json, script, or html)',
	    		data: {
	    			id:id
	    		},
	    		success:function(data)
	    		{
	    			$('#event_name').val(data.eventname)
	    			$('#event_maxbet').val(data.maxbet)
	    			$('#event_betmultiplier').val(data.betmultiplier)
	    			$('#event_liveurl').val(data.liveurl)
	    			$('#event_banner').val(data.banner)
	    			$('#event_save').attr('data-id', data.id)
	    			$('#modal-event').modal('show')
	    		}
	    	});
	    	
	    })

		$(document).on('click', '.btn-view', function(){
			var id = $(this).closest('tr').attr('data-id');
			window.location.href = '/event_view/' + id
		})
	    

		

	})
</script>
@endsection