@extends('admin.layout')
@section('content')
<!--start page wrapper -->
<div class="page-wrapper">
	<div class="page-content">
		<!--breadcrumb-->
		<div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
			<div class="breadcrumb-title pe-3">Brands</div>
			<div class="ps-3">
				<nav aria-label="breadcrumb">
					<ol class="breadcrumb mb-0 p-0">
						<li class="breadcrumb-item"><a href="{{ url('/admin/brands') }}"><i class="bx bx-home-alt"></i></a>
						</li>
						<li class="breadcrumb-item active" aria-current="page">Brand</li>
					</ol>
				</nav>
			</div>

			<div class="ms-auto">
				<div class="row">
					<div class="col-12">
						<button type="button" class="btn btn-outline-info px-5 radius-30" data-bs-toggle="modal" data-bs-target="#exampleModal" onclick="resetForm();">+ Add</button>
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
													<th class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-label="Position: activate to sort column ascending" style="width: 275.975px;">Title</th>
													<th class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-label="Age: activate to sort column ascending" style="width: 42.0875px;">Image</th>
													<th class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-label="Salary: activate to sort column ascending" style="width: 104.975px;">Action</th>
												</tr>
											</thead>
											<tbody>
												@foreach ( $brands as $brand )
												<tr role="row" id="{{ $brand->id }}" class="@if($brand->id % 2) odd @else even @endif">
													<td class="sorting_1">{{ $brand->id }}</td>
													<td class="title">{{ $brand->title }}</td>
													<td class="image">
														<img height="50" width="50" src="@if ($brand->image) {{ url('/uploads/brands/') }}/{{ $brand->image }} @else {{ asset('assets/images/avatars/not-found.png') }} @endif" alt="brand image">
													</td>
													<td> <button type="button" class="btn btn-outline-info px-5 radius-30" data-bs-toggle="modal" data-bs-target="#exampleModal" data-id="{{ $brand->id }}" data-val="{{ $brand->name }}" onclick="editAttributes('{{ $brand }}');">Edit</button> </td>
													<td> <button type="button" class="btn btn-outline-danger px-5 radius-30" data-id="{{ $brand->id }}" data-val="{{ $brand->name }}" onclick="deleteAttributes('{{ $brand->id }}');">Delete</button> </td>
													@endforeach

											</tbody>
											<!-- <tfoot>
												<tr>
													<th rowspan="1" colspan="1">Name</th>
													<th rowspan="1" colspan="1">Position</th>
													<th rowspan="1" colspan="1">Office</th>
													<th rowspan="1" colspan="1">Age</th>
													<th rowspan="1" colspan="1">Start date</th>
													<th rowspan="1" colspan="1">Salary</th>
												</tr>
											</tfoot> -->
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
				<form id="color-form" method="post" action="{{ url('/admin/brands/store') }}" enctype="multipart/form-data">
					@csrf
					<div class="mb-3">
						<label for="exampleInputEmail1" class="form-label
						">Brand Name</label>
						<input type="hidden" name="id" id="id">
						<input name="title" type="text" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp">
					</div>

					<div class="mb-3">
						<label for="exampleInputEmail1" class="form-label
						">Value</label>
						<input name="image" type="file" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" onchange="previewImage(event)">

						<div id="image_preview" class="mt-2">
						
							<!-- <img id="preview" src="{{ asset('/uploads/profile/' . Auth::user()->profile) }}" alt="Profile Picture" class="img-thumbnail" style="max-width: 200px;"> -->
							
							<img id="preview" src="{{ asset('assets/images/avatars/not-found.png') }}" alt="Profile Picture" class="img-thumbnail" style="max-width: 200px;">

						</div>

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
				} else {
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
		xhr.open('GET', '/admin/brands/delete/' + id, true);
		xhr.onload = function() {
			let data = JSON.parse(xhr.responseText);
			if (xhr.status === 200) {
				if (data.status === 200) {
					alert('Success');
					window.location.reload();
				} else {
					alert(data.error);
				}
			} else {
				alert('Something went wrong');
			}
		};
		xhr.send();
	}

	function editAttributes(data) {
		console.log(data);
		document.querySelector('input[name="title"]').value = JSON.parse(data).title;
		if(JSON.parse(data).image){
			document.querySelector('img[id="preview"]').src = "{{ url('/uploads/brands/') }}"+"/"+JSON.parse(data).image;
		}
		document.querySelector('input[name="id"]').value = JSON.parse(data).id;
		document.getElementById('modal-submit-button').innerText = 'Update Attribute';
		document.querySelector('.modal-title').innerText = 'Edit Attribute';
	}

	function previewImage(event) {
		var file = event.target.files[0]; // Get the file from the input
		if (file) {
			var reader = new FileReader();
			reader.onload = function() {
				var output = document.getElementById('preview');
				if (output) {
					output.src = reader.result; // Set the image source to the result
				}
			}
			reader.readAsDataURL(file); // Make sure this is a valid file
		} else {
			var output = document.getElementById('preview');
			output.src = "{{ asset('assets/images/avatars/not-found.png') }}";
			console.error('No file selected');
		}
	}
	function resetForm(){
		document.querySelector('input[name="title"]').value = '';
		document.querySelector('input[name="id"]').value = '';
		document.getElementById('preview').src = "{{ asset('assets/images/avatars/not-found.png') }}";
		document.getElementById('modal-submit-button').innerText = 'Add Attribute';
		document.querySelector('.modal-title').innerText = 'Add Attribute';
	}

</script>