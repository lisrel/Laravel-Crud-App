@extends('master')

@section('content')

<br />

<div class="container box">
	<h3 align="center"> List of People </h3><br>
    <br>

    <div  align="right">
        <button type="button" name="add" id="add_data" class="btn btn-success btn-sm">Add</button>
    </div>

    <br>

    <div class="table-responsive">
        <table id="details_table" class="table table-striped table-bordered" width="100%">
            <thead>
            <tr>
                <th class="sorting" data-sorting_type ="asc" data-column_name="first_name">First Name<span id="first_name_icon"></span></th>
                <th class="sorting" data-sorting_type ="asc" data-column_name="surname">Surname <span id="surname_icon"></span></th>
                <th>Date Of Birth</th>
                <th>Age</th>
                <th>Edit / Delete</th>
            </tr>
            </thead>
            <tbody>

            </tbody>
        </table>
    </div>
    <div id="detailsModal" class="modal fade" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <form method="post" id="details_form">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title">Add Details Data</h4>
                    </div>
                    <div class="modal-body">
                        {{csrf_field()}}
                        <span id="form_output"></span>
                        <div class="form-group">
                            <label for="first_name">Enter First Name</label>
                            <input type="text" id="first_name" name="first_name" class="form-control" placeholder="Enter First Name" />
                        </div>

                        <div class="form-group">
                            <label for="last_name"> Enter Surname</label>
                            <input type="text" id="surname" name="surname" class="form-control" placeholder="Enter Surname" />
                        </div>

                        <div class="form-group">
                            <label for="dob"> Enter Date of Birth</label>
                            <input type="date" id="dob" name='dob' class="form-control" placeholder="Enter D.O.B" />
                        </div>

                        <div class="form-group">
                            <input type="hidden" id="age" name="age" class="form-control" placeholder="Age" />
                        </div>

                        <div class="form-group">
                            <label for="dob"> Enter Weight</label>
                            <input type="text" id="weight" name="weight" class="form-control" placeholder="Enter Weight" />
                        </div>

                        <div class="form-group">
                            <label for="dob"> Enter Height</label>
                            <input type="text" id="height" name="height" class="form-control" placeholder="Enter Height" />
                        </div>

                        <div class="form-group">
                            <label for="hair_colour"> Enter Hair Colour</label>
                            <input type="text" id="hair_colour" name="hair_colour" class="form-control" placeholder="Enter Hair_Colour" />
                        </div>

                    </div>

                    <div class="modal-footer">
                        <input type="hidden" name="hidden_column_name" id="hidden_column_name" value="id" />
                        <input type="hidden" name="hidden_sorting_type" id="hidden_sort_type" value="asc"/>
                        <input type="hidden" name="detail_id" id="detail_id" value=""/>
                        <input type="hidden" name="button_action" id="button_action" value="insert" />
                        <input type="submit" name="submit" id="action" value="Add Details" class="btn  btn-info" />
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>

                    </div>
                </form>
            </div>

        </div>

    </div>
</div>



<script>

    $(document).ready(function () {



        $('#details_table').DataTable({
            "processing": true,
            "serverSide": true,
            "ajax": "{{ route('details.fetch') }}",
            "columns":[
                { "data": "first_name" },
                { "data": "surname" },
                { "data": "dob", orderable:false, searchable: false },
                { "data": "age", orderable: false, searchable: false },
                {"data": "action", orderable: false, searchable: false},
            ]
        });


        fetch_data();
        function fetch_data() {

        }

        $(document).on('keyup','#search', function () {
            var query = $(this).val();
            fetch_data(query);
        });

        $('#add_data').click(function () {
           $('#detailsModal').modal('show');
            $('.modal-title').text('Add Data');
           $('#details_form')[0].reset();
           $('#form_output').html('');
           $('#button_action').val('insert');
           $('#action').val('Add');
        });

        $('#details_form').on('submit', function (event) {
           event.preventDefault();
           var form_data= $(this).serialize();
           $.ajax({
               url: "{{route('details.postdata')}}",
               method: "POST",
               data: form_data,
               dataType: "json",
               success: function (data) {
                   if(data.error.length > 0){
                       var error_html ='';
                       for(var count =0; count < data.error.length; count++){
                           error_html += '<div class="alert alert-danger">'+data.error[count]+'</div>';
                       }
                       $('#form_output').html(error_html);
                   }else{
                        $('#form_output').html(data.success);
                        $('#details_form')[0].reset();
                        $('#action').val('Add');
                        $('.modal-title').text('Add Data');
                        $('#button_action').val('insert');
                        $('#details_table').DataTable().ajax.reload();
                   }
               }
           })
        });

        $(document).on('click', '.edit', function () {
            var id = $(this).attr("id");
            $.ajax({
                url:"{{route('details.fetchAll')}}",
                method: 'GET',
                data:{id:id},
                dataType:'json',
                success: function (data) {
                    $('#first_name').val(data.first_name);
                    $('#surname').val(data.surname);
                    $('#dob').val(data.dob);
                    $('#weight').val(data.weight);
                    $('#height').val(data.height);
                    $('#hair_colour').val(data.hair_color);
                    $('#detail_id').val(id);
                    $('#detailsModal').modal('show');
                    $('#action').val('Edit');
                    $('.modal-title').text('Edit Data');
                    $('#button_action').val('update');
                    $('#form_output').html('');
                }
            })
        });

        $(document).on('click', '.delete', function () {
            var id = $(this).attr('id');
            if (confirm("Are you sure you want to delete this data?")){
                $.ajax({
                    url: "{{route('details.deletedata')}}",
                    method: "GET",
                    data: {id:id},
                    success: function (data) {
                        alert(data);
                        $('#details_table').DataTable().ajax.reload();
                    }
                })

            }else {
                return false;
            }
        });

    });


</script>

@endsection