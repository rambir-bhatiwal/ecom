@extends('admin.layout')
@section('content')
<!--start page wrapper -->
<div class="page-wrapper">
	<div class="page-content">
		<!--breadcrumb-->
		<div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
			<div class="breadcrumb-title pe-3">Category</div>
			<div class="ps-3">
				<nav aria-label="breadcrumb">
					<ol class="breadcrumb mb-0 p-0">
						<li class="breadcrumb-item"><a href="{{ url('/admin/categories-attributes') }}"><i class="bx bx-home-alt"></i></a>
						</li>
						<li class="breadcrumb-item active" aria-current="page">Category Attributes</li>
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
													<th class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-label="Position: activate to sort column ascending" style="width: 275.975px;">Category</th>
													<th class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-label="Position: activate to sort column ascending" style="width: 275.975px;">Attribute</th>
													<th class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-label="Salary: activate to sort column ascending" style="width: 104.975px;">Action</th>
												</tr>
											</thead>
											<tbody>
												@foreach ( $data as $dataRow )
											
												<tr role="row" id="{{ $dataRow->id }}" class="@if($dataRow->id % 2) odd @else even @endif">
													<td class="sorting_1">{{ $dataRow->id }}</td>	
													<td class="sorting_1">{{ $dataRow->category->name }}</td>	
													<td class="title" >{{ $dataRow->attribute->name }}</td>
													<td> <button type="button" class="btn btn-outline-info px-5 radius-30" data-bs-toggle="modal" data-bs-target="#exampleModal" data-id="{{ $dataRow->id }}"  onclick="editCategory('{{ $dataRow }}');">Edit</button> </td>
													<td> <button type="button" class="btn btn-outline-danger px-5 radius-30"  data-id="{{ $dataRow->id }}"  onclick="deleteCategory('{{ $dataRow->id }}');">Delete</button> </td>
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
				<form id="color-form" method="post" action="{{ url('/admin/categories-attributes/store') }}" enctype="multipart/form-data">
					@csrf
					<input type="hidden" name="id" id="id">
					
					<div class="mb-3">
						<label for="exampleInputEmail1" class="form-label
						">Select Category</label>
						<select name="category_id"  class="form-control" required>
							<option id="category-id-none" value="">Select Category</option>
							@foreach ( $categories as $category )
							<option id="category-id-{{ $category->id }}" value="{{ $category->id }}">{{ $category->name }}</option>
							@endforeach
						</select>
					</div>
					<div class="mb-3">
						<label for="exampleInputEmail1" class="form-label
						">Select Attribute</label>
						<select name="attribute_id"  class="form-control" required>
							<option id="attribute-id-none" value="">Select Attribute</option>
							@foreach ( $attributes as $attribute )
							<option id="attribute-id-{{ $attribute->id }}" value="{{ $attribute->id }}">{{ $attribute->name }}</option>
							@endforeach
						</select>
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

	function deleteCategory(id) {
		var xhr = new XMLHttpRequest();
		console.log(id);
		xhr.open('GET', '/admin/categories-attributes/delete/' + id, true);
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
	function editCategory(data) {
		console.log(JSON.parse(data));
		document.querySelector('input[name="id"]').value = JSON.parse(data).id;
		
		if (JSON.parse(data).category_id && JSON.parse(data).category_id > 0) {
			document.getElementById('category-id-'+JSON.parse(data).category_id).selected  = true;
		}else{
			document.getElementById('category-id-none').selected  = true;
		}
		if (JSON.parse(data).attribute_id && JSON.parse(data).attribute_id > 0) {
			document.getElementById('attribute-id-'+JSON.parse(data).attribute_id).selected  = true;
		}else{
			document.getElementById('attribute-id-none').selected  = true;
		}
		document.getElementById('modal-submit-button').innerText = 'Update Category';
		document.querySelector('.modal-title').innerText = 'Edit Category';;
	}
</script>