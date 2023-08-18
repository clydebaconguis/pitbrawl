@extends('pit.layouts.app')

@section('content')
	
  	<section class="content">
    <div class="container-fluid">
      	<div class="row pt-3">
          	<div class="col-md-12">
          		<h2>Transactions</h2>
          	</div>
        </div>
        <hr>
        <div class="row">
        	<div class="col-md-12">
        		<div class="row mb-2">
					<div class="col-md-5 text-xl">
	        			BALANCE: <span id="trx_bal" class="text-bold text-dark">0.00</span>
	        		</div>
	        		<div class="col-md-3">
	        			<div class="input-group">
							<div class="input-group-prepend">
								<span class="input-group-text">
								<i class="far fa-calendar-alt"></i>
								</span>
							</div>
							<input type="text" class="form-control float-right" id="trx_range">
						</div>
	        		</div>
	        		<div class="col-md-3">
	        			<div class="input-group">
							<input type="text" class="form-control float-right" id="player_filter" placeholder="Search Player" style="text-transform: uppercase">
		                    <div class="input-group-append">
			                    <span class="input-group-text">
			                    	<i class="fas fa-search"></i>
			                    </span>
		                    </div>
		                </div>	
	        		</div>
	        		<div class="col-md-1">
	        			<button id="deposit_new" class="btn btn-primary btn-block">Deposit</button>
	        		</div>
		        </div>
        		<div class="row">
        			<div class="col-md-12">
		        		<div class="card card-outline card-dark">
		        			<div id="table_main" class="card-body table-responsive pt-0">
		        				<table class="table table-sm text-xs table-hover table-head-fixed text-nowrap">
		        					<thead>
		        						<tr>
											<th>DATE</th>
		        							<th>FROM</th>
		        							<th>TO</th>
											<th class="text-center">AMOUNT</th>	
											<th class="text-center">BALANCE</th>	
											<th class="text-center">END BALANCE</th>	
											<th>REMARKS</th>
		        						</tr>
		        					</thead>
		        					<tbody id="trans_list" style="cursor:pointer"></tbody>
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
	


    <div class="modal fade show" id="modal-deposit" aria-modal="true" style="padding-right: 17px; display: none;">
        <div class="modal-dialog modal-md">
          	<div class="modal-content mt-3" style="margin-left: -17px;">
	            <div class="modal-header bg-dark">
	              <h4 class="modal-title">Deposit</span></h4>
	              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
	                <span aria-hidden="true">×</span>
	              </button>
	            </div>
	            <div class="modal-body text-sm btn-sm">
	              	<div class="row form-group">
						<div class="col-md-12">
							<label>USER</label>
							<select id="trx_user" class="select2 form-control">
								
							</select>
						</div>
	              	</div>
					  <div class="row form-group">
						<div class="col-md-12">
							<label>AMOUNT</label>
							<input id="trx_amount" type="numeric" class="form-control player_input" placeholder="0.00">
						</div>
	              	</div>

					<div class="row form-group">
						<div class="col-md-12">
							<label>REMARKS</label>
							<textarea id="trx_remarks" class="form-control player_input"></textarea>
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
							<button id="admin_delete" class="btn btn-danger text-right" style="display:none">Delete</button>
							<button id="trx_deposit" class="btn btn-primary" data-id="0">Deposit</button>
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

	        $('#trx_range').daterangepicker({
	        	startDate:  moment().startOf('month'),
        		endDate: moment().endOf('month')
	        })

	    function gettrx()
	    {
	    	$.ajax({
	    		url: '{{route('trx_gen')}}',
	    		type: 'GET',
	    		success:function(data)
	    		{
	    			$('#trx_bal').text(data.balance)
	    			$('#trans_list').empty();
	    			$.each(data.trx, function(index, val) {
	    				var date = val.createddatetime
	    				date = moment(date).format("MM-DD-YYYY HH:MM A")

	    				var amount = val.amount
	    				var balance = val.balance
	    				var endbalance = val.endbalance
	    				var remarks = val.remarks

	    				amount = parseFloat(amount).toFixed(2).replace(/\d(?=(\d{3})+\.)/g, '$&,')
	    				balance = parseFloat(balance).toFixed(2).replace(/\d(?=(\d{3})+\.)/g, '$&,')
	    				endbalance = parseFloat(endbalance).toFixed(2).replace(/\d(?=(\d{3})+\.)/g, '$&,')
	    				
	    				$('#trans_list').append(`
	    				 	<tr>
	    				 		<td>`+date+`</td>
	    				 		<td>`+val.loadfrom+`</td>
	    				 		<td>`+val.loadto+`</td>
	    				 		<td class="text-right">`+amount+`</td>
	    				 		<td class="text-right">`+balance+`</td>
	    				 		<td class="text-right">`+endbalance+`</td>
	    				 		<td>`+remarks.toUpperCase()+`</td>
	    				 	</tr>
	    				 `)
	    			});
	    		}
	    	});
	    }

	    function emptyinputs()
	    {
	    	$('#player_input').val('')

	    	setTimeout(function(){
	    		$('#trx_user').focus()
	    	}, 300)
	    }

	    gettrx()

	    $(document).on('click', '#deposit_new', function(){
	    	$.ajax({
	    		url: '{{route('trx_getusers')}}',
	    		type: 'GET',
	    		success:function(data)
	    		{
	    			$('#trx_user').empty()

	    			$.each(data, function(index, val) {
	    				 $('#trx_user').append(`
	    				 	<option value="`+val.id+`">`+val.name+`</option>
	    				 `)
	    			});

	    			$('#modal-deposit').modal('show')
	    			emptyinputs()
	    		}
	    	});
	    	
	    })

	    $(document).on('change', '#trx_amount', function(){
	    	var amount = parseFloat($(this).val())
	    	amount = amount.toFixed(2).replace(/\d(?=(\d{3})+\.)/g, '$&,')
	    	$('#trx_amount').val(amount)
	    })

	    $(document).on('click', '#trx_deposit', function(){
	    	var userid = $('#trx_user').val()
	    	var amount = $('#trx_amount').val()
	    	var remarks = $('#trx_remarks').val()

	    	$.ajax({
	    		url: '{{route('trx_deposit')}}',
	    		type: 'POST',
	    		data: {
	    			userid:userid,
	    			amount:amount,
	    			remarks:remarks
	    		},
	    		headers: {
			        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
			    },
			    success:function(data)
			    {
			    	$('#modal-deposit').modal('hide')

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
					  title: 'Load Successfully'
					})

					gettrx();
			    }
	    	});
	    	
	    })

	    
	    

		

	})
</script>
@endsection