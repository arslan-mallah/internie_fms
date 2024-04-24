<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\addpay;
use App\Models\general_ledger;
use App\Models\result_ledger;
use App\Models\categories;
use Illuminate\Support\Facades\DB;
use Auth;
use Event;
use App\Events\deleteMail;
class AddpayController extends Controller
{
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    function __construct()
    {
        $this->middleware('role_or_permission:addpay',['only' => ['index','show']]);
        $this->middleware('role_or_permission:addpay',['only' => ['create','store']]);
       
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = Auth::user();
        $permissions = $user->getPermissionsViaRoles();
        $data = json_decode($permissions, true); // Convert JSON string to PHP array

        $names = array_column($data, 'name');
        
     $category = DB::table('categories')
     ->distinct()
     ->pluck('category');
      
       $simpleArray = $category->toArray();
       $simpleArray1 = array_values($simpleArray);
       $mutualValues = array_intersect($simpleArray1, $names);

    return view('addpay.index',['category'=> $mutualValues]);
      
        
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */



     function store(Request $req)
     {
     
        $user = Auth::user();
        
        $permissions = $user->getPermissionsViaRoles();
        $data = json_decode($permissions, true); // Convert JSON string to PHP array

        $names = array_column($data, 'name');
        $username = Auth::user()->name;
     $category = DB::table('categories')
     ->distinct()
     ->pluck('category');
      
       $simpleArray = $category->toArray();
       $simpleArray1 = array_values($simpleArray);
       $mutualValues = array_intersect($simpleArray1, $names);

       $originalcategory=[$req->cat];
       $checkcategory = array_intersect($originalcategory, $mutualValues);
         if(count($checkcategory)!== 0){
     /////for general ledger//////
                        $general=new general_ledger;
                        $general->date=$req->date;
                        $general->day=date('l',strtotime($req->date));
                        $general->created_date=date('Y-m-d;h:i:s');
                        $general->created_id=$req->id ;
                        $general->username=$username;
     
                        if ($req->type=='debit') {
                            $general->debit=$req->amt;
     
                        }
                        else{
                            $general->credit=$req->amt;
                        }
     
                        $general->category=$req->cat;
                        $general->detail=$req->detail;
     
     
                        $general->save();
     
                         /////////for result/////
     
     
           if (DB::table('result_ledgers')->where('type',date('F,Y',strtotime($req->date)))->where('category',$req->cat)->exists()) {
                     $data1= DB::table('result_ledgers')
                     ->where([
                         ['category', '=', $req->cat],
                         ['type', '=',date('F,Y',strtotime($req->date))]
                     ])
                    ->get();
                  
     
     
     
                     if($data1->count()==1){
                    foreach ($data1 as $photo) {
     
                        $amount=$req->amt;
                        $debit=$photo->debit_amount;
                        $credit=$photo->credit_amount;
                        $total=$photo->total_amount;
     
                     if ($req->type=='debit') {
                         $edit_debit=$debit+$amount;
                         $edit_total=$total-$amount; 
     
                         $affected= DB::table('result_ledgers')
                         ->where('type',date('F,Y',strtotime($req->date)))
                         ->where('category',$req->cat)
                         ->update(['debit_amount' => $edit_debit,'total_amount' => $edit_total]);
                         // return $edit_total;
                         
                     }
                     if ($req->type=='credit') {
                         $edit_credit=$credit+$amount;
                         $edit_total=$total+$amount;
     
                         $affected= DB::table('result_ledgers')
                         ->where('type',date('F,Y',strtotime($req->date)))
                         ->where('category',$req->cat)
                         ->update(['credit_amount' => $edit_credit,'total_amount' => $edit_total]);
     
                         // return $edit_credit;
                             }
                         }
                       }
                 }  
     else{
                 $amount=$req->amt;
                 $category=$req->cat;
                 $type=date('F,Y',strtotime($req->date));
                 $month3=date('m', strtotime($req->date));
                 $year3=date('Y', strtotime($req->date));
                 $first3="$year3-$month3-01";
                 $date3="$year3-$month3-30";
     
                 if ($req->type=='debit') {
     
                   $affected= DB::table('result_ledgers')
                   ->insert(
                     [
                    'category'=>$category,
                    'type'=>$type,
                    'start_date'=>$first3,
                    'end_date'=>$date3,
                    'debit_amount'=> $amount,
                    'credit_amount'=> 0,
                    'total_amount'=> -$amount,
                        ]
                     );
     
                 }else{
     
                 $affected= DB::table('result_ledgers')
                 ->insert(
                   [
                  'category'=>$category,
                  'type'=>$type,
                  'start_date'=>$first3,
                  'end_date'=>$date3,
                  'debit_amount'=> 0,
                  'credit_amount'=> $amount,
                  'total_amount'=> $amount,
     
     
                   ]
                );
             }
     }
     
     
     
     
     
     
     
     
     return redirect()->back()->with('message','Inserted successfuly');
     
    }else{

        return redirect()->back()->with('message','Something went wrong');
    }
     }


    

    
   

  


    
    

    
  
   
    
}