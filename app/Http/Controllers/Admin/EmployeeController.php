<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\addpay;
use App\Models\general_ledger;
use App\Models\result_ledger;
use App\Models\employee;
use Illuminate\Support\Facades\DB;
use Auth;
class EmployeeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    function __construct()
    {
        $this->middleware('role_or_permission:showemployee', ['only' => ['index']]);
        $this->middleware('role_or_permission:showemployee', ['only' => ['store']]);
        $this->middleware('role_or_permission:editemployee', ['only' => ['update']]);
        $this->middleware('role_or_permission:deleteemployee', ['only' => ['destroy']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data_general1=employee::all();
                         
        return view('employee.index',['data_general'=> $data_general1]);


    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
   

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $req)
    {
        $general=new employee;
        $general->name=$req->name;
        $general->email=$req->email;
        $general->mobile_no=$req->contact1;
        $general->contact_no=$req->contact2;
        $general->address=$req->address;
        $general->cnic=$req->cnic;
        $general->join=$req->joining;
        $general->left=$req->left;
        $general->employee_id=$req->emp_id;
        $general->save();
        if($general->save()){
return redirect()->back()->with('message','Inserted successfuly');
        }
    }

   

    

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $req)
    {

        $id=$req->update_id;
        $name=$req->name;
        $email=$req->email;
        $contact1=$req->contact1;
        $contact2=$req->contact2;
        $address=$req->address;         
        $cnic=$req->cnic;         
        $joining=$req->joining;         
        $left=$req->left;         
        $employee_id=$req->emp_id;    

        $updatee=DB::table('employees')->where('id',$id)->get();
        $update1=json_encode($updatee);

$sql= DB::table('employees')
->where('id', $id)
->update([

  'name' =>$name,
 'email' => $email ,
 'mobile_no' => $contact1, 
 'contact_no' => $contact2 ,
 'address' => $address,
 'cnic' => $cnic, 
 'join' => $joining, 
 'left' => $left, 
 'employee_id' => $employee_id, 

]);  

if($sql){
  $update=DB::table('employees')->where('id',$id)->get();
  $update2=json_encode($update);

  $notification= DB::table('notifications')
  ->insert(
  [
   'user_id'=> Auth::user()->id,
  'user_name'=> Auth::user()->name,
    'action'=>'update',
'page_affected'=>'employee',
 'old_data'=> $update1,
 'new_data'=> $update2,
'markasread'=> 'false',
   ]
 );      

   return redirect()->back()->with('message','updated successfuly');

 }else{
   return redirect()->back()->with('message','failed to update or you enter previous data');

 }
        
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $req )
    {
        
        $id=$req->delete_id;
            
        $update=DB::table('employees')->where('id',$id)->get();
        $update2=json_encode($update);

        $sql2=DB::table('employees')->where('id', $id)->delete();

        if($sql2){
               
         
        
          $notification= DB::table('notifications')
          ->insert(
          [
           'user_id'=> Auth::user()->id,
          'user_name'=> Auth::user()->name,
            'action'=>'delete',
        'page_affected'=>'employee',
         'old_data'=> $update2,
        'markasread'=> 'false',
           ]
         ); 
       return redirect()->back()->with('message','delete successfuly');
        
          }else{
            return redirect()->back()->with('message','failed to delete');

          }

       
        
    }
}