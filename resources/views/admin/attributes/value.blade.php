@extends('admin.layout')
@section('content')
<!--start page wrapper -->
<div class="page-wrapper">
	<div class="page-content">
		<!--breadcrumb-->
		<div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
			<div class="breadcrumb-title pe-3">Attributes Value</div>
			<div class="ps-3">
				<nav aria-label="breadcrumb">
					<ol class="breadcrumb mb-0 p-0">
						<li class="breadcrumb-item"><a href="{{ url('/admin/attributes-values') }}"><i class="bx bx-home-alt"></i></a>
						</li>
						<li class="breadcrumb-item active" aria-current="page">Attributes Value</li>
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
													<th class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-label="Position: activate to sort column ascending" style="width: 275.975px;">Name</th>
													<th class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-label="Position: activate to sort column ascending" style="width: 275.975px;">Value</th>
													<th class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-label="Salary: activate to sort column ascending" style="width: 104.975px;">Action</th>
												</tr>
											</thead>
											<tbody>
												@foreach ( $attributesValue as $attribute )
												<tr role="row" id="{{ $attribute->id }}" class="@if($attribute->id % 2) odd @else even @endif">
													<td class="sorting_1">{{ $attribute->id }}</td>	
													<td class="title">{{ $attribute->attribute->name }}</td>
													<td class="title" >{{ $attribute->value }}</td>
													<td> <button type="button" class="btn btn-outline-info px-5 radius-30" data-bs-toggle="modal" data-bs-target="#exampleModal" data-id="{{ $attribute->id }}" data-val="{{ $attribute->name }}" onclick="editAttributes('{{ $attribute }}');">Edit</button> </td>
													<td> <button type="button" class="btn btn-outline-danger px-5 radius-30"  data-id="{{ $attribute->id }}" data-val="{{ $attribute->name }}" onclick="deleteAttributes('{{ $attribute->id }}');">Delete</button> </td>
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
				<form id="color-form" method="post" action="{{ url('/admin/attributes-values/store') }}" enctype="multipart/form-data">
					@csrf
					<div class="mb-3">
						<label for="exampleInputEmail1" class="form-label
						">Select Attribute</label>
						<input type="hidden" name="id" id="id">

						<select name="attribute_id" id="attribute_id" class="form-control">
							@foreach ( $attributes as $attribute )
							<option id="attribute-op-{{ $attribute->id }}" value="{{ $attribute->id }}">{{ $attribute->name }}</option>
							@endforeach
						</select>

						<!-- <input name="attribute_id" type="text" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp"> -->
					</div>
	
					<div class="mb-3">
						<label for="exampleInputEmail1" class="form-label
						">Value</label>
						<input name="value" type="text" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp">
					</div>
	
				</form>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
				<button type="submit" class="btn btn-primary" id="modal-submit-button" form="color-form">Add Attribute</button>
			</div>
		</div>
	</div>
</div>


<script>
		document.querySelector('button[type="submit"]').addEventListener('click', function(e) {
		e.preventDefault();
		console.log('clicked');
		var form = document.querySelector('#color-form');
		var formData = new FormData(form);
		var xhr = new XMLHttpRequest();
		xhr.open('POST', form.action, true);	
		xhr.onload = function() {
			if (xhr.status === 200) {
				let data = JSON.parse(xhr.responseText);
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
		xhr.send(formData);
	});

	function deleteAttributes(id) {
		var xhr = new XMLHttpRequest();
		console.log(id);
		xhr.open('GET', '/admin/attributes-values/delete/' + id, true);
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
	function editAttributes(data) {
		console.log(JSON.parse(data).attribute_id);
		document.getElementById('attribute-op-'+JSON.parse(data).attribute_id).selected  = true;
		document.querySelector('input[name="value"]').value = JSON.parse(data).value;
		document.querySelector('input[name="id"]').value = JSON.parse(data).id;
		document.getElementById('modal-submit-button').innerText = 'Update Attribute';
		document.querySelector('.modal-title').innerText = 'Edit Attribute';
	}
</script>