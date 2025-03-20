@extends('admin.layout')
@section('content')
<!--start page wrapper -->
<div class="page-wrapper">
	<div class="page-content">
		<!--breadcrumb-->
		<div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
			<div class="breadcrumb-title pe-3">Home Banner</div>
			<div class="ps-3">
				<nav aria-label="breadcrumb">
					<ol class="breadcrumb mb-0 p-0">
						<li class="breadcrumb-item"><a href="{{ url('/admin/banner') }}"><i class="bx bx-home-alt"></i></a>
						</li>
						<li class="breadcrumb-item active" aria-current="page">Home Banner</li>
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
													<th class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-label="Position: activate to sort column ascending" style="width: 275.975px;">Title</th>
													<th class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-label="Office: activate to sort column ascending" style="width: 132.85px;">Subtitle</th>
													<th class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-label="Age: activate to sort column ascending" style="width: 42.0875px;">Image</th>
													<th class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-label="Start date: activate to sort column ascending" style="width: 104.95px;">Link</th>
													<th class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-label="Salary: activate to sort column ascending" style="width: 104.975px;">button</th>
													<th class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-label="Salary: activate to sort column ascending" style="width: 104.975px;">Action</th>
												</tr>
											</thead>
											<tbody>
												@foreach ( $banners as $banner )
												<tr role="row" id="{{ $banner->id }}" class="@if($banner->id % 2) odd @else even @endif">
													<td class="sorting_1">{{ $banner->id }}</td>	
													<td class="title">{{ $banner->title }}</td>
													<td class="subtitle">{{ $banner->subtitle }}</td>
													<td class="image">{{ $banner->image }}</td>
													<td class="link">{{ $banner->link }}</td>
													<td class="button">{{ $banner->button }}</td>
													<td> <button type="button" class="btn btn-outline-info px-5 radius-30" data-bs-toggle="modal" data-bs-target="#exampleModal" data-id="{{ $banner->id }}">Edit</button> </td>
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
				<form id="banner-form" method="post" action="{{ url('/admin/banners/store') }}" enctype="multipart/form-data">
					@csrf
					<div class="mb-3">
						<label for="exampleInputEmail1" class="form-label
						">Title</label>
						<input name="title" type="text" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp">
					</div>
					<div class="mb-3">
						<label for="exampleInputPassword1" class="form-label
						">Subtitle</label>
						<input name="subtitle" type="text" class="form-control" id="exampleInputPassword1">
					</div>
					<div class="mb-3">
						<label for="imageinput" class="form-label
						">Image</label>
						<input name="image" type="file" class="form-control" id="imageinput">
					</div>
					<div class="mb-3">
						<label for="linkimput" class="form-label
						">Link</label>
						<input name="link" type="text" class="form-control" id="linkimput">
					</div>
					<div class="mb-3">
						<label for="buttoninut" class="form-label
						">Button</label>
						<input name="button_text" type="text" class="form-control" id="buttoninut">
					</div>

				</form>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
				<button type="submit" class="btn btn-primary" form="banner-form">Add Banner</button>
			</div>
		</div>
	</div>
</div>


<script>
		document.querySelector('button[type="submit"]').addEventListener('click', function(e) {
		e.preventDefault();
		console.log('clicked');
		var form = document.querySelector('#banner-form');
		var formData = new FormData(form);
		var xhr = new XMLHttpRequest();
		xhr.open('POST', form.action, true);	
		xhr.onload = function() {
			if (xhr.status === 200) {
				alert('Banner Added Successfully');
				window.location.reload();
			} else {
				alert('Profile Update Failed');
			}
		};
		xhr.send(formData);
	});


	// document.getElementById('exampleModal').addEventListener('show.bs.modal', function (event) {
    // var button = event.relatedTarget;
	//     var itemId = button.getAttribute('data-id');
	// 	var rowData = document.getElementById(itemId);
	// this.querySelector('input[name="title"]').value = rowData.getElementsByClassName('title')[0].innerText;
	// console.log(rowData.getElementsByClassName('title')[0].innerText, 'title');

	// this.querySelector('input[name="subtitle"]').value = rowData.getElementsByClassName('subtitle')[0].innerText;
	// console.log(rowData.getElementsByClassName('subtitle')[0].innerText, 'subtitle');
	// this.querySelector('input[name="link"]').value = rowData.getElementsByClassName('link')[0].innerText;
	// console.log(rowData.getElementsByClassName('link')[0].innerText, 'link');

	// this.querySelector('input[name="button_text"]').value = rowData.getElementsByClassName('button_text')[0].innerText;
	// console.log(rowData.getElementsByClassName('button_text')[0].innerText, 'button_text');
	// });



</script>