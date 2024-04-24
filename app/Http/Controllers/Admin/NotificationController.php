<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\addpay;
use App\Models\general_ledger;
use App\Models\result_ledger;
use App\Models\employee;
use App\Models\notification;
use Illuminate\Support\Facades\DB;
use Auth;
class NotificationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    function __construct()
    {
        $this->middleware('role_or_permission:shownotification', ['only' => ['index']]);
        
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
       return view('notification.index');
    }

    public function totalrecord()
    {
        $data_general1=notification::where('markasread', 'false')->get();
        $recordCount = $data_general1->count();
       return view('dashboard',['number'=> $recordCount]);
    }

    public function tabledata()
    {
        $data_general1=notification::where('markasread', 'false')->get();
        if($data_general1){
            return response()->json([
                'message' => "Data Found",
                "code"    => 200,
                "data"  => $data_general1
                
            ]);
        } else  {
            return response()->json([
                'message' => "Internal Server Error",
                "code"    => 500
            ]);
        }             


    }


    public function mark(Request $req)
    {
    
        $sql= DB::table('notifications')
        ->where('id', $req->id)
        ->update(['markasread' => 'true']);

        if($sql){
            return response()->json([
                'message' => "Data Found",
                "code"    => 200,
                
            ]);
        } else  {
            return response()->json([
                'message' => "Internal Server Error",
                "code"    => 500
            ]);
        }
       

    }


    public function deletedata(Request $req)
    {
    
        $sql= DB::table('notifications')
        ->where('id', $req->id)
        ->delete();

        if($sql){
            return response()->json([
                'message' => "Data Found",
                "code"    => 200,
                
            ]);
        } else  {
            return response()->json([
                'message' => "Internal Server Error",
                "code"    => 500
            ]);
        }
       

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
            

        $sql2=DB::table('employees')->where('id', $id)->delete();

        if($sql2){
               
       return redirect()->back()->with('message','delete successfuly');
        
          }else{
            return redirect()->back()->with('message','failed to delete');

          }

       
        
    }
}