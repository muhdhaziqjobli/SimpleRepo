<div>
	@if (session('message'))
		<div class="alert alert-success" role="alert">
			{{ session('message') }}
		</div>
	@endif
	
	<div class="card">
		<div class="card-header">
			<span>Phone</span>
			<button class="btn btn-primary btn-sm float-end" data-bs-toggle="modal" data-bs-target="#PhoneModalAdd">Add</button>
		</div>
	
		<div class="card-body">
			<input class="form-control mb-3" type="search" wire:model="search" placeholder="Search by brand or model">
			<table class="table w-auto">
				<thead>
					<tr>
						<th>Brand</th>
						<th>Model</th>
						<th>Year</th>
						<th>Action</th>
					</tr>
				</thead>
				<tbody>
					@forelse ($phones as $phone)
						<tr>
							<td>{{$phone->brand}}</td>
							<td>{{$phone->model}}</td>
							<td>{{$phone->year}}</td>
							<td class="fit">
								<button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#PhoneModalEdit" wire:click="editPhone({{$phone->id}})">Edit</button>
								<button class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#PhoneModalDelete" wire:click="deletePhone({{$phone->id}})">Delete</button>
							</td>
						</tr>
					@empty
						<tr colspan="4">
							<td>No Records Found</td>
						</tr>
					@endforelse
				</tbody>
			</table>
			<div>
				{{$phones->links()}}
			</div>
		</div>
	</div>
	
	<!-- Modal -->
	<!-- Add -->
	<div wire:ignore.self class="modal fade" id="PhoneModalAdd" tabindex="-1" aria-labelledby="PhoneModalAdd" aria-hidden="true">
		<div class="modal-dialog modal-dialog-centered">
			<div class="modal-content">
				<div class="modal-header">
					<h1 class="modal-title fs-5">Add Phone</h1>
					<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
				</div>
				<form wire:submit.prevent="storePhone">
					<div class="modal-body">
						<div class="row m-3">
							<input type="text" class="form-control" wire:model="brand" placeholder="Brand">
							@error('brand') <span class="text-danger">{{ $message }}</span> @enderror
						</div>
						<div class="row m-3">
							<input type="text" class="form-control " wire:model="model" placeholder="Model">
							@error('model') <span class="text-danger">{{ $message }}</span> @enderror
						</div>
						<div class="row m-3">
							<input type="text" class="form-control " wire:model="year" placeholder="Year">
							@error('year') <span class="text-danger">{{ $message }}</span> @enderror
						</div>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
						<button type="button" type="submit" class="btn btn-primary" wire:click="storePhone">Save</button>
					</div>
				</form>
			</div>
		</div>
	</div>

	<!-- Edit -->
	<div wire:ignore.self class="modal fade" id="PhoneModalEdit" tabindex="-1" aria-labelledby="PhoneModalEdit" aria-hidden="true" data-bs-backdrop="static">
		<div class="modal-dialog modal-dialog-centered">
			<div class="modal-content">
				<div class="modal-header">
					<h1 class="modal-title fs-5">Edit Phone</h1>
					<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" wire:click="resetInput"></button>
				</div>
				<form wire:submit.prevent="updatePhone">
					<div class="modal-body">
						<div class="row m-3">
							<input type="text" class="form-control" wire:model="brand" placeholder="Brand">
							@error('brand') <span class="text-danger">{{ $message }}</span> @enderror
						</div>
						<div class="row m-3">
							<input type="text" class="form-control " wire:model="model" placeholder="Model">
							@error('model') <span class="text-danger">{{ $message }}</span> @enderror
						</div>
						<div class="row m-3">
							<input type="text" class="form-control " wire:model="year" placeholder="Year">
							@error('year') <span class="text-danger">{{ $message }}</span> @enderror
						</div>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-secondary" data-bs-dismiss="modal" wire:click="resetInput">Close</button>
						<button type="button" type="submit" class="btn btn-primary" wire:click="updatePhone">Save</button>
					</div>
				</form>
			</div>
		</div>
	</div>

	<!-- Delete -->
	<div wire:ignore.self class="modal fade" id="PhoneModalDelete" tabindex="-1" aria-labelledby="PhoneModalDelete" aria-hidden="true">
		<div class="modal-dialog modal-dialog-centered">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
				</div>
				<div class="modal-body">
					<h5 class="">Are you sure you want to delete this phone?</h5>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
					<button type="button" type="submit" class="btn btn-primary" wire:click="destroyPhone">Yes</button>
				</div>
			</div>
		</div>
	</div>
</div>