@extends('master')

@section('content')
    <br>
    <h3> Edit Data</h3>
    <br>

    <form method="post">
        <div class="col-md-6" style="padding-left: 0px;">

                {{csrf_field()}}
                <div class="form-group">
                    <input type="text" name="first_name" class="form-control" placeholder="Enter First Name" />
                </div>

                <div class="form-group">
                    <input type="text" name="surname" class="form-control" placeholder="Enter Surname" />
                </div>

                <div class="form-group">
                    <input type="date" name='dob' class="form-control" placeholder="Enter dob" />
                </div>

                <div class="form-group">
                    <input type="hidden" name="age" class="form-control" placeholder="Age" />
                </div>
        </div>

        <div class="col-md-6" style="padding-right: 0px;">
            <div class="form-group">
                <input type="text"  />

            </div>


        </div>




    </form>




@endsection



$query = $request->get('query');
if($query!=''){
$data = DB::table('details')
->where('first_name', 'like', '%'.$query.'%')
->orWhere('surname', 'like', '%'.$query.'%')
->get();

}else{
$data = DB::table('details')
->orderBy('id', 'asc')
->get();

}
$total_row= $data->count();
if ($total_row > 0){
$output='';
foreach ($data as $row){
$output .= '

<tr>
    <td>'.$row->first_name.'</td>
    <td>'.$row->surname.'</td>
    <td>'.$row->dob.'</td>
    <td>'.$row->age.'</td>
    <td>
        <a href="#" class="btn btn-warning btn-sm edit" id="'.$row->id.'"><i class="glyphicon glyphicon-edit"></i>Edit</a>
        <a href="#" class="btn btn-danger btn-sm delete" id="'.$row->id.'"><i class="glyphicon glyphicon-edit"></i>Delete</a>
    </td>
</tr>

';
}
}else{
$output = '
<tr>
    <td align="center" colspan="5"> No Data </td>
</tr>
';
}
$data = array(
'table_data'=> $output,
'total_data'=> $total_row
);

echo json_encode($data);







function fetch_data(query = '') {
$.ajax({
url:"{{route('details.fetch')}}",
method:'GET',
data: {query:query},
dataType:'json',
success: function (data) {
$('tbody').html(data.table_data);
$('total_records').text(data.total_data);
}
})
}