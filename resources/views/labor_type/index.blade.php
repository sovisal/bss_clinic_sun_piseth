<x-app-layout>
	<x-slot name="header">
		@if (request()->type)
			<x-form.button color="danger" href="{!! route('setting.labor-type.index', ['type' => request()->old]) !!}" label="Back" icon="bx bx-left-arrow-alt" />
		@endif
	</x-slot>
	<x-slot name="js">
		<script>
			$("#datatables-item").DataTable({
				"columnDefs": [{
					"targets": 'no-sort',
					"orderable": false,
				}],
				dom:  "<'row'<'col-sm-8'<'d-flex'<l><'ml-1'B>>><'col-sm-4'f>>" +
						"<'row'<'col-sm-12'tr>>" +
						"<'row'<'col-sm-5'i><'col-sm-7'p>>",
				buttons: [
					{ extend: 'csv', text: '<i class="la la-file-csv"></i> CSV', className: 'btn-sm'},
					{ extend: 'excel', text: '<i class="la la-file-excel"></i> Excel', className: 'btn-sm'},
					{ extend: 'print', text: '<i class="bx bx-printer"></i> Print', className: 'btn-sm'}
				],
			});
		</script>
	</x-slot>
	
	@if (!request()->old) 
		<x-card :foot="false" :actionShow="false">
			<x-slot name="header">
				<h5>Labor Type</h5>
				<x-form.button href="{!! route('setting.labor-type.create', ['type' => request()->type]) !!}" label="Create" icon="bx bx-plus" />
			</x-slot>
			<x-table class="table-hover table-bordered" id="datatables">
				<x-slot name="thead">
					<tr>
						<th width="8%">No</th>
						<th>Name</th>
						@if (request()->type)
						<th>Type</th>
						@endif
						<th>Index</th>
						<th width="15%">Action</th>
					</tr>
				</x-slot>
				@foreach($rows as $i => $row)
				<tr>
					<td class="text-center">{{ ++$i }}</td>
					<td>{{ $row->name_en }}</td>
					@if (request()->type)
					<th>{{ $row->type_name }}</th>
					@endif
					<td class="text-center">{{ $row->index }}</td>
					<td class="text-center">
						<x-form.button class="btn-sm" href="{!! route('setting.labor-type.index', ['type' => $row->id, 'old' => request()->type]) !!}" icon="bx bx-detail" />
						<x-form.button color="secondary" class="btn-sm" href="{!! route('setting.labor-type.edit', ['laborType' => $row->id, 'type' => request()->type]) !!}" icon="bx bx-edit-alt" />
						<x-form.button color="danger" class="confirmDelete btn-sm" data-id="{{ $row->id }}" icon="bx bx-trash" :disabled="(count($row->items) > 0 || count($row->types))" />
						<form class="sr-only" id="form-delete-{{ $row->id }}" action="{!! route('setting.labor-type.delete', ['laborType' => $row->id, 'type' => request()->type]) !!}" method="POST">
							@csrf
							@method('DELETE')
							<button class="sr-only" id="btn-{{ $row->id }}">Delete</button>
						</form>
					</td>
				</tr>
				@endforeach
			</x-table>
		</x-card>
	@endif
	
	@if (request()->type) 
		<x-card :foot="false" :actionShow="false">
			<x-slot name="header">
				<h5>Labor Item</h5>
				<x-form.button href="{!! route('setting.labor-item.create', request()->only(['type', 'old'])) !!}" label="Create" icon="bx bx-plus" />
			</x-slot>
			<x-table class="table-hover table-bordered" id="datatables-item">
				<x-slot name="thead">
					<tr>
						<th>No</th>
						<th>Name</th>
						<th class="text-right">Min</th>
						<th>Max</th>
						<th>Unit</th>
						<th>Category</th>
						<th>Index</th>
						<th>Status</th>
						<th>Syntax</th>
						<th>Action</th>
					</tr>
				</x-slot>
				@foreach($item_rows as $j => $item_row)
				<tr>
					<td class="text-center">{{ ++$j }}</td>
					<td>{{ $item_row->name_en }}</td>
					<td class="text-right">{{ $item_row->min_range }}</td>
					<td>{{ $item_row->max_range }}</td>
					<td class="text-center">{!! apply_markdown_character($item_row->unit) !!}</td>
					<td>{{ $item_row->type_en }}</td>
					<td class="text-center">{{ $item_row->index }}</td>
					<td class="text-center">{{ $item_row->status }}</td>
					<td>{{ $item_row->other }}</td>
					<td class="text-center">
						<x-form.button color="secondary" class="btn-sm" href="{!! route('setting.labor-item.edit', ['laborItem' => $item_row->id, 'type' => request()->type, 'old' => request()->old]) !!}" icon="bx bx-edit-alt" />
						<x-form.button color="danger" class="confirmDelete btn-sm" data-id="{{ $item_row->id }}" icon="bx bx-trash" />
						<form class="sr-only" id="form-delete-{{ $item_row->id }}" action="{!! route('setting.labor-item.delete', ['laborItem' => $item_row->id, 'type' => request()->type, 'old' => request()->old]) !!}" method="POST">
							@csrf
							@method('DELETE')
							<button class="sr-only" id="btn-{{ $item_row->id }}">Delete</button>
						</form>
					</td>
				</tr>
				@endforeach
			</x-table>
		</x-card>
	@endif

	<x-modal-confirm-delete />
</x-app-layout>