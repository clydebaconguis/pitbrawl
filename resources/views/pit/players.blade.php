@extends('pit.layouts.app')

@section('content')
	
  	<section class="content">
    <div class="container-fluid">
      	<div class="row pt-3">
          	<div class="col-md-12">
          		<h2>Players</h2>
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
							<input type="text" class="form-control float-right" id="player_filter" placeholder="Search Player" style="text-transform: uppercase">
		                    <div class="input-group-append">
			                    <span class="input-group-text">
			                    	<i class="fas fa-search"></i>
			                    </span>
		                    </div>
		                </div>
	        			
	        		</div>
	        		
	        		<div class="col-md-2">
	        			<button id="player_new" class="btn btn-primary btn-block">Create Player</button>
	        		</div>
		        </div>
        		<div class="row">
        			<div class="col-md-12">
		        		<div class="card card-outline card-dark">
		        			<div id="table_main" class="card-body table-responsive pt-0">
		        				<table class="table table-sm text-sm table-hover table-head-fixed text-nowrap">
		        					<thead>
		        						<tr>
											<th>NAME</th>
		        							<th>UPLINE</th>
		        							<th class="text-center">BALANCE</th>
											<th>TYPE</th>
		        						</tr>
		        					</thead>
		        					<tbody id="player_list" style="cursor:pointer"></tbody>
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
	


    <div class="modal fade show" id="modal-player" aria-modal="true" style="padding-right: 17px; display: none;">
        <div class="modal-dialog modal-md">
          	<div class="modal-content mt-3" style="margin-left: -17px;">
	            <div class="modal-header bg-dark">
	              <h4 class="modal-title">Player</span></h4>
	              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
	                <span aria-hidden="true">×</span>
	              </button>
	            </div>
	            <div class="modal-body text-sm btn-sm">
	              	<div class="row form-group">
						<div class="col-md-12">
							<label>USERNAME</label>
							<input id="player_uname" type="text" class="form-control player_input">
						</div>
	              	</div>
					  <div class="row form-group">
						<div class="col-md-12">
							<label>NAME</label>
							<input id="player_name" type="text" class="form-control player_input">
						</div>
	              	</div>
					<div class="row form-group">
						


						<div class="col-md-12">
							<label>PASSWORD</label>
							<div class="input-group mb-3">
								<input id="player_pword" type="password" class="form-control player_input">
								<div class="input-group-append">
								<span id="player_showpword" class="input-group-text">
									<i id="player_eye" class="fa-solid fa-eye"></i>
								</span>
								</div>
							</div>
							
						</div>
	              	</div>

					<div class="row form-group">
						<div class="col-md-12">
							<label>TYPE</label>
							<select id="player_type" class="select2" style="width: 100%;">
								@foreach(DB::table('usertypes')->where('id', 7)->get() as $utype)
									<option value="{{$utype->utype}}">{{$utype->description}}</option>
								@endforeach
							</select>
						</div>
					</div>

					{{-- <div class="row form-group">
						<div class="col-md-12">
							<label>BALANCE</label>
							<input id="player_balance" type="numeric" class="form-control player_input">
						</div>
					</div> --}}
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
							<button id="player_delete" class="btn btn-danger text-right" style="display:none">Delete</button>
							<button id="player_save" class="btn btn-primary" data-id="0">Save</button>
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

	    function players()
	    {
	    	var filter = $('#player_filter').val()

	    	$.ajax({
	    		url: '{{route('players_read')}}',
	    		type: 'GET',
	    		// dataType: 'default: Intelligent Guess (Other values: xml, json, script, or html)',
	    		data: {
	    			filter:filter
	    		},
	    		success:function(data)
	    		{
	    			$.each(data, function(index, val) {
	    				$('#player_list').append(`
	    				 	<tr data-id="`+val.id+`">
	    				 		<td>`+val.name.toUpperCase()+`</td>
	    				 		<td>`+val.upline.toUpperCase()+`</td>
	    				 		<td class="text-right">`+'0.00'+`</td>
	    				 		<td>`+val.usertype.toUpperCase()+`</td>
	    				 	</tr>
	    				`)
	    			});
	    		}
	    	});
	    	
	    }

	    function clearInputs()
	    {
	    	$('.player_input').val('');
	    }

	    players()
		
	    $(document).on('click', '#player_new', function(){
	    	clearInputs()
	    	$('#modal-player').modal('show')
	    	setTimeout(function(){
	    		$('#player_uname').focus()
	    	}, 300)
	    })

	    $(document).on('click', '#player_showpword', function(){
	    	if($('#player_pword').attr('type') == 'password')
	    	{
	    		$('#player_pword').attr('type', 'text')
	    		$('#player_eye').removeClass('fa-solid fa-eye')
	    		$('#player_eye').addClass('fa-solid fa-eye-slash')
	    	}
	    	else{
	    		$('#player_pword').attr('type', 'password')
	    		$('#player_eye').addClass('fa-solid fa-eye')
	    		$('#player_eye').removeClass('fa-solid fa-eye-slash')	
	    	}
	    })

	    $(document).on('click', '#player_save', function(){
	    	var uname = $('#player_uname').val()
	    	var name = $('#player_name').val()
	    	var pword = $('#player_pword').val()
	    	var type = $('#player_type').val()

	    	$.ajax({
	    		url: '{{route('players_create')}}',
	    		type: 'POST',
	    		headers: {
			        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
			    },
	    		// dataType: 'default: Intelligent Guess (Other values: xml, json, script, or html)',
	    		data: {
	    			uname:uname,
	    			name:name,
	    			pword:pword,
	    			type:type
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
						  title: 'Player has been saved'
						})

						players()
						$('#modal-player').modal('hide');
					}
					else{

					}
	    		}
	    	});	
	    })
	    

		

	})
</script>
@endsection