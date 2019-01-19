@extends('master')

@section('content')
    <br>
    <h3>Add Data</h3>
    <br>
    <form method="post">
        {{csrf_field()}}
        <div class="form-group">
            <input type="text" name="first_name" class="form-control" placeholder="Enter First Name" />
        </div>

        <div class="form-group">
            <input type="text" name="last_name" class="form-control" placeholder="Enter Last Name" />
        </div>

        <div class="form-group">
            <input type="date" name='dob' class="form-control" placeholder="Enter dob" />
        </div>

        <div class="form-group">
            <input type="hidden" name="age" class="form-control" placeholder="Age" />
        </div>

        <div class="form-group">
            <button class="btn btn-primary" id="Add" >Add Data</button>
        </div>

    </form>



@endsection