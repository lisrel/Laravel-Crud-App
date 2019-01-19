<?php

namespace App\Http\Controllers;

use Validator;
use Illuminate\Http\Request;
use DB;
use DataTables;
use App\details;
use App\attributes;
use Carbon\Carbon;


class DataController extends Controller
{
    public function master(){
       return view('master');
    }

    public function index(){
        return view('details');
    }

    function fetch(Request $request){
        if ($request->ajax()){
            $selected = details::select('id','first_name','surname','dob','age');
            return DataTables::of($selected)
                ->addColumn('action',function($details){
                    return
                        '
                        <a href="#" class="btn btn-warning btn-sm edit" id="'.$details->id.'"><i class="glyphicon glyphicon-edit"></i>Edit</a>
                        <a href="#" class="btn btn-danger btn-sm delete" id="'.$details->id.'"><i class="glyphicon glyphicon-edit"></i>Delete</a>
                        ';
                })
                ->make(true);
        }
    }

   public function edit(){
        return view('edit');
    }

    function postdata(Request $request){
       $validation = Validator::make($request->all(), [
         'first_name' =>'required',
           'surname' => 'required',
           'dob'=> 'required',
           'weight'=> 'required',
           'height'=>'required',
           'hair_colour' => 'required'
       ]);
       $error_array = array();
       $success_output = '';

       if ($validation->fails()){
           foreach ($validation->messages()->getMessages()as $field_name=>$messages){
               $error_array[]= $messages;
           }
       }else{
            if ($request->get('button_action')== "insert"){
                $student = new details([
                    'first_name'=> $request->get('first_name'),
                    'surname'=> $request->get('surname'),
                    'dob'=> Carbon::parse($request->get('dob')),
                    'age'=> \Carbon::parse(Carbon::parse($request->get('dob')))->age,
                ]);
                $student->save();

                $attributes = new attributes([
                   'hair_color' =>$request->get('hair_colour'),
                    'weight'=> $request->get('weight'),
                    'height'=>$request->get('height'),

                ]);
                $student->attributes()->save($attributes);

                $success_output = '<div class="alert alert-success"> Data Has Been Saved</div>';

            }
            if ($request->get('button_action')=='update'){
                $details = details::find($request->get('detail_id'));
                $details->first_name = $request->get('first_name');
                $details->surname = $request->get('surname');
                $details->dob = Carbon::parse($request->get('dob'));
                $details->age = \Carbon::parse(Carbon::parse($request->get('dob')))->age;
                $details->save();

                $details->attributes->weight = $request->get('weight');
                $details->attributes->height = $request->get('height');
                $details->attributes->hair_color = $request->get('hair_colour');
                $details->attributes->save();


                $success_output = '<div class="alert alert-success"> Data Has Been Updated</div>';

            }
       }
       $output =array(
           'error' => $error_array,
           'success'=> $success_output,
       );
       echo json_encode($output);
    }
    function fetchAll(Request $request){
        $id = $request->input('id');
        $student= details::find($id);
        //$attribute = attributes::find($id);
        $users = DB::table('attributes')
            ->join('details', 'attributes.details_id', '=', 'details.id')
            ->select('attributes.*', 'details.*')
            ->where('details.id', $id)
            ->first();

        $output = array(
            'first_name' => $student->first_name,
            'surname' => $student->surname,
            'dob' => $student->dob,
            'weight' => $users->weight,
            'height'=> $users->height,
            'hair_color'=> $users->hair_color
        );

        echo json_encode($output);
    }

    function destroy(Request $request){
        $details = details::find($request->input('id'));
        if($details->delete()){
            echo 'Data has been Deleted';
        }
    }
}
