@extends('pit.layouts.app')

@section('content')
	
  	<section class="content">
    <div class="container-fluid">
		<div class="row">
			<div class="col-md-4">
				<div class="row pt-3">
					<div class="col-md-12">
						<div id="_items" class="small-box bg-info">
							<div id="main_items" class="inner" style="cursor:pointer;">
								@php
									
								@endphp
								

								<h4>PLASADA</h4>
							</div>
							<div class="icon">
								<i class="fas fa-boxes"></i>
							</div>
							<a href="#" class="small-box-footer">
								More info <i class="fas fa-arrow-circle-right"></i>
							</a>
						</div>
					</div>
				</div>

				

    

    </div>

  </section>
@endsection
@section('modal')
	<div class="modal fade show" id="modal-stockin" aria-modal="true" style="padding-right: 17px; display: none;">
		<div class="modal-dialog modal-md">
			<div class="modal-content mt-5" style="margin-left: -17px;">
				<div class="modal-header bg-primary">
				<h4 class="modal-title">Stock In </span> </h4>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">×</span>
				</button>
				</div>
				<div class="modal-body text-sm btn-sm">
					<div class="row form-group">
						<div class="col-md-8">
							<label >Item</label>
							<select id="in_items" class="select2 w-100">
								
							</select>
						</div>
						<div class="col-md-4 text-bold" style="margin-top: 2.5em">QTY: <span id="in_updqty"></span></div>
					</div>
					<div class="row form-group">
						<div class="col-md-12">
							<label>QTY</label>
							<input id="in_qty" type="number" class="form-control in_field">
						</div>
					</div>
					<div class="row form-group">
						<div class="col-md-12">
							<label>Remarks</label>
							<input id="in_remarks" type="text" class="form-control in_field">
						</div>
					</div>

					<div class="row form-group">
						<div class="col-md-3">
							<button type="button" class="btn btn-default" data-dismiss="modal">
								Close
							</button>
						</div>
						<div class="col-md-3">
							
						</div>
						
	              		<div class="col-md-6 text-right">
	              			<button id="in_save" class="btn btn-primary" data-id="0">Post</button>
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
		screenadjust()

		function screenadjust()
		{
			var screen_height = $(window).height()
			var screen_bg = $(window).height() - 59
			
			$('#table_logs').css('height', screen_height - 345)

			// console.log(screen_height)

		}

		
	})
</script>
@endsection