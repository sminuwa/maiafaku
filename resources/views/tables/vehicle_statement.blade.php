<table class="table table-bordered table-striped">
    <thead>
    <tr>
    		<th>Vehicle Dispatch Form Id </th>
		<th>Type </th>
		<th>Amount </th>
		<th>Status </th>
		<th>&nbsp;</th>
    </tr>
    </thead>
    <tbody>
    @foreach($records as $record)
    <tr>	 	<td> {{$record->vehicle_dispatch_form_id }} </td>
	 	<td> {{$record->type }} </td>
	 	<td> {{$record->amount }} </td>
	 	<td> {{$record->status }} </td>
	<td><a class="btn btn-secondary" href="{{route('vehicle_statements.show',$record->id)}}">
    <span class="fa fa-eye"></span>
</a><a class="btn btn-secondary" href="{{route('vehicle_statements.edit',$record->id)}}">
    <span class="fa fa-pencil"></span>
</a>
<form onsubmit="return confirm('Are you sure you want to delete?')"
      action="{{route('vehicle_statements.destroy',$record->id)}}"
      method="post"
      style="display: inline">
    {{csrf_field()}}
    {{method_field('DELETE')}}
    <button type="submit" class="btn btn-secondary cursor-pointer">
        <i class="text-danger fa fa-remove"></i>
    </button>
</form></td></tr>

    @endforeach
    </tbody>
    <tfoot>
    <tr>
        <td colspan="3">
            {{{$records->render()}}}
        </td>
    </tr>
    </tfoot>
</table>