@extends('layouts.app')

@section('content')
<div class="container">
	<div class="row justify-content-center">
		<div class="col-md-8">
			<div class="card">
				<div class="card-header">{{ __('Dashboard') }}</div>

				<div class="card-body">
					<livewire:phone-crud>
				</div>

				<div class="card-body">
					<livewire:laptop-crud>
				</div>
			</div>
		</div>
	</div>
</div>
@endsection

@section('script')
<script>
	window.addEventListener('close-modal', event => {
		$('[id^=PhoneModal]').modal('hide');
		$('[id^=LaptopModal]').modal('hide');
	})
</script>
@endsection