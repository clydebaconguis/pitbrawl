@extends('pit.layouts.app')

@section('content')
	
  	<section class="content">
    <div class="container-fluid">
        <div class="row pt-3">
            <div class="col-md-6">
                <h2>{{$event['eventname']}}</h2>
            </div>
            <div class="col-md-6 text-right">
                <button class="btn btn-success">REFRESH ALL</button>
                <button class="btn btn-danger ml-2">END EVENT</button>
            </div>
        </div>
        
        <hr>
        <div class="row">
        	<div class="col-md-6 border">
				<div class="row form-group">
                    <div class="col-md-12" style="height: 30em">
                        <iframe width="100%" height="100%" src="https://www.youtube.com/embed/D36NcdULu_U&pp=ygUSc2Fib25nIHNob3J0IHZpZGVv" frameborder="0" allowfullscreen></iframe>
                    </div>
                </div>
				<div class="row">
					<div class="col-md-12 table-responsive" style="height: 10em">
						<table class="table table-sm text-xs">
							<thead>
								<tr>
									<th>No.</th>
									<th>Name</th>
									<th>Bet</th>
									<th class="text-center">Amount</th>
								</tr>
							</thead>
							<tbody id=""></tbody>
						</table>
					</div>
				</div>
			</div>
			<style>
			.container {
				width: 100%;
				height: 100; /* Adjust the height as needed */
				display: flex;
				align-items: center;
				justify-content: center;
			}

			.grid-container {
				display: grid;
				grid-template-columns: repeat(10, 1fr);
				grid-template-rows: repeat(10, 1fr);
				gap: 2px;
				width: 100%; /* Adjust the width as a percentage of the container */
				max-width: 400px; /* Optional: Add a maximum width to prevent the grid from getting too wide */
				height: 50%; /* Adjust the height as a percentage of the container */
				max-height: 180px; 
                /* Optional: Add a maximum height to prevent the grid from getting too tall */
				overflow: auto;
			}

			.circular-cell {
				width: 20px;
				height: 20px;
				border-radius: 50%;
				display: flex;
				align-items: center;
				justify-content: center;
				font-size: 10px;
				font-weight: bold;
			}

			.blue {
				background-color: blue;
				color: white;
			}

			.red {
				background-color: red;
				color: white;
  			}
			</style>
			<div class="col-md-6">
                Controls
				<div class="row form-group mb-0">
					<div class="col-md-6">
						
						@php
							$totalColumns = 50;
							$totalRows = 20;
							$dummyData = [];

							for ($row = 1; $row <= $totalRows; $row++) {
								for ($col = 1; $col <= $totalColumns; $col++) {
								$dummyData[] = [
									'circular_number' => $col,
									'color' => $col % 2 === 0 ? 'Red' : 'Blue',
									'games_won' => $row * $col,
								];
								}
							}
						@endphp
						
						<div class="card border-primary">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col">
                                        <h5 class="card-title font-weight-bold">WINNING HISTORY</h5>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col">
                                        <hr class="my-3"> <!-- Line Divider -->
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col">
                                        <div class="container mb-2">
                                            <div class="grid-container">
                                                @foreach ($dummyData as $winning)
                                                <div class="circular-cell {{ strtolower($winning['color']) }}">
                                                    {{ $winning['games_won'] }}
                                                </div>
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        
						<!-- <table class="table trend-table">
							<tbody>
								<tr>
									<td>
										<div id="cell0-0" class="trend-item bg-disabled wala">1</div>
									</td>
								</tr>
							</tbody> -->
						<!-- </table> -->
					</div>
					<div class="col-md-6">
						<div class="card border-primary">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col">
                                        <h5 class="card-title font-weight-bold">JUMP TO FIGHT</h5>
                                    </div>
                                </div>
                                <div class="row  border-top mt-3 pt-3">
                                    <div class="col">
                                        <div class="input-group mb-2">
                                            <input type="number" id="event_fightnum" class="form-control form-control-sm" value="0">
                                            <div class="input-group-append">
                                                <button class="btn btn-primary btn-sm text-sm">FIGHT</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
						<div class="card border-primary">
                            <div class="card-body">
                                <div class="row"> 
                                    <div class="col">
                                        <h5 class="card-title font-weight-bold">BET STATUS</h5>
                                    </div>
                                </div>
                                <div class="row border-top mt-3 pt-3">
                                    <div class="col">
                                        <button class="btn btn-success btn-block">OPEN BET</button>
                                    </div>
                                </div>
                            </div>
                        </div>
					</div>
				</div>
                <div class="row">
                    <div class="col">
                        <div class="card border-primary">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col">
                                        <h5 class="card-title font-weight-bold">DECLARE WINNER</h5>
                                    </div>
                                    <div class="col-auto d-flex align-items-center">
                                        <hr class="flex-grow-1 my-0 mx-2"> <!-- Divider Line -->
                                        <h5 class="card-title mb-0 font-weight-bold">FIGHT #4</h5>
                                    </div>
                                </div>
                                <hr class="my-3"> <!-- Line Divider -->
                                <div class="row mt-3 justify-content-center ">
                                    <div class="col-6-max mx-2">
                                        <button class="btn btn-danger btn-block w-100 max-w-xs mb-2">DECLARE <br> MERON</button>
                                    </div>
                                    <div class="col-6-max mx-2">
                                        <button class="btn btn-primary btn-block w-100 max-w-xs mb-2">DECLARE <br> WALA</button>
                                    </div>
                                    <div class="col-6-max mx-2">
                                        <button class="btn btn-warning btn-block w-100 max-w-xs mb-2">DECLARE <br> DRAW</button>
                                    </div>
                                    <div class="col-6-max mx-2">
                                        <button class="btn btn-secondary btn-block w-100 max-w-xs mb-2">DECLARE <br> CANCEL</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col">
                        <div class="card border-primary">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col">
                                        <h5 class="card-title font-weight-bold">BETTING INFO</h5>
                                    </div>
                                </div>
                                <div class="row mt-3">
                                    <div class="col">
                                        <div class="bg-secondary text-white text-center pt-2">
                                            <label for="">TOTAL BETS</label>
                                        </div>
                                        <table class="table table-bordered">
                                            <thead>
                                                <tr class="text-center">
                                                    <th class="bg-danger">MERON</th>
                                                    <th class="bg-primary">WALA</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td>Data 1</td>
                                                    <td>Data 2</td>
                                                </tr>
                                                <!-- Add more rows here -->
                                            </tbody>
                                        </table>
                                    </div>

                                    <div class="col">
                                        <div class="bg-success text-white text-center pt-2">
                                            <label for="">PAYOUT</label>
                                        </div>
                                        <table class="table table-bordered">
                                            <thead>
                                                <tr class="text-center">
                                                    <th class="bg-danger">MERON</th>
                                                    <th class="bg-primary">WALA</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td>Data 1</td>
                                                    <td>Data 2</td>
                                                </tr>
                                                <!-- Add more rows here -->
                                            </tbody>
                                        </table>
                                    </div>                              
                                </div>
                                <div class="row ">
                                    <div class="col">
                                        <div class="bg-info text-white text-center pt-2">
                                            <label for="">ACTUAL BETS</label>
                                        </div>
                                        <table class="table table-bordered">
                                            <thead>
                                                <tr class="text-center">
                                                    <th class="bg-danger">MERON</th>
                                                    <th class="bg-primary">WALA</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td>Data 1</td>
                                                    <td>Data 2</td>
                                                </tr>
                                                <!-- Add more rows here -->
                                            </tbody>
                                        </table>
                                    </div>
                                    <div class="col">
                                        <div class="bg-warning text-white text-center pt-2">
                                            <label for="">GHOST BETS</label>
                                        </div>
                                        <table class="table table-bordered">
                                            <thead>
                                                <tr class="text-center">
                                                    <th class="bg-danger">MERON</th>
                                                    <th class="bg-primary">WALA</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td>Data 1</td>
                                                    <td>Data 2</td>
                                                </tr>
                                                <!-- Add more rows here -->
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
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
@section('jsUP')
<style>
	.trend-item {
		width: 25px;
		height: 25px;
		line-height: 25px;
		font-size: 10px;
		text-align: center;
		border-radius: 50%;
	}

	.wala {
		background-color: #007bff!important;
		color: #ffffff;
	}

	.meron {
		background-color: #dc3545!important;
		color: #ffffff;
	}

</style>
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
			
			
		})
	    

		

	})
</script>
@endsection