@extends('admin.layout')
@section('content')
<!--start page wrapper -->
<div class="page-wrapper">
	<div class="page-content">
		<!--breadcrumb-->
		<div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
			<div class="breadcrumb-title pe-3">Tax</div>
			<div class="ps-3">
				<nav aria-label="breadcrumb">
					<ol class="breadcrumb mb-0 p-0">
						<li class="breadcrumb-item"><a href="{{ url('/admin/tax') }}"><i class="bx bx-home-alt"></i></a>
						</li>
						<li class="breadcrumb-item active" aria-current="page">Tax</li>
					</ol>
				</nav>
			</div>

			<div class="ms-auto">
				<div class="row">
					<div class="col-12">
						<button type="button" class="btn btn-outline-info px-5 radius-30" data-bs-toggle="modal" data-bs-target="#exampleModal">+ Add</button>
					</div>
				</div>
			</div>

		</div>
		<!--end breadcrumb-->
		<div class="container">
			<div class="main-body">
				<div class="row">
					<div class="card-body">
						<div class="table-responsive">
							<div id="example2_wrapper" class="dataTables_wrapper dt-bootstrap5">

								<div class="row">
									<div class="col-sm-12">
										<table id="example2" class="table table-striped table-bordered dataTable" role="grid" aria-describedby="example2_info">
											<thead>
												<tr role="row">
													<th class="sorting_asc" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-sort="ascending" aria-label="Name: activate to sort column descending" style="width: 173.162px;">ID</th>
													<th class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-label="Position: activate to sort column ascending" style="width: 275.975px;">Tax</th>
													<th class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-label="Salary: activate to sort column ascending" style="width: 104.975px;">Action</th>
												</tr>
											</thead>
											<tbody>
												@foreach ( $data as $tax )
												<tr role="row" id="{{ $tax->id }}" class="@if($tax->id % 2) odd @else even @endif">
													<td class="sorting_1">{{ $tax->id }}</td>	
													<td class="title">{{ $tax->tax }}</td>
													<td> <button type="button" class="btn btn-outline-info px-5 radius-30" data-bs-toggle="modal" data-bs-target="#exampleModal" data-id="{{ $tax->id }}" data-val="{{ $tax->name }}" onclick="editTaxs('{{ $tax }}');">Edit</button> </td>
													<td> <button type="button" class="btn btn-outline-danger px-5 radius-30"  data-id="{{ $tax->id }}" data-val="{{ $tax->name }}" onclick="deleteTaxs('{{ $tax->id }}');">Delete</button> </td>
												@endforeach

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
</div>
<!--end page wrapper -->
@endsection



<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" style="display: none;" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
				<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
			</div>
			<div class="modal-body">
				<form id="tax-form" method="post" action="{{ url('/admin/tax/store') }}" enctype="multipart/form-data">
					@csrf
					<div class="mb-3">
						<label for="exampleInputEmail1" class="form-label
						">Tex</label>
						<input type="hidden" name="id" id="id">
						<input name="tax" type="number" class="form-control" min="0" max="100" id="exampleInputEmail1" aria-describedby="emailHelp">
					</div>
				</form>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
				<button type="submit" class="btn btn-primary" id="modal-submit-button" form="tax-form">Add Tax</button>
			</div>
		</div>
	</div>
</div>


<script>
		document.querySelector('button[type="submit"]').addEventListener('click', function(e) {
		e.preventDefault();
		console.log('clicked');
		var form = document.querySelector('#tax-form');
		var formData = new FormData(form);
		var xhr = new XMLHttpRequest();
		xhr.open('POST', form.action, true);	
		xhr.onload = function() {
			if (xhr.status === 200) {
				alert('Success');
				window.location.reload();
			} else {
				alert('Something went wrong');
			}
		};
		xhr.send(formData);
	});

	function deleteTaxs(id) {
		var xhr = new XMLHttpRequest();
		xhr.open('GET', '/admin/tax/delete/' + id, true);
		xhr.onload = function() {
			let data = JSON.parse(xhr.responseText);
			if (xhr.status === 200) {
				if (data.status === 200) {
					alert('Success');
					window.location.reload();
				}else{
					alert(data.error);
				}
			} else {
				alert('Something went wrong');
			}
		};
		xhr.send();
	}
	function editTaxs(data) {
		document.querySelector('input[name="tax"]').value = JSON.parse(data).tax;	
		document.querySelector('input[name="id"]').value = JSON.parse(data).id;
		document.getElementById('modal-submit-button').innerText = 'Update Tax';
		document.querySelector('.modal-title').innerText = 'Edit Tax';
	}
</script>