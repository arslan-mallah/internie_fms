<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\addpay;
use App\Models\general_ledger;
use App\Models\result_ledger;
use Illuminate\Support\Facades\DB;
use Auth;
class ResultController extends Controller
{
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    function __construct()
    {
        $this->middleware('role_or_permission:showresult',['only' => ['index']]);
       
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
        $result_data=result_ledger::whereIn('category', $mutualValues)->orderByDesc('id')->get();

//////////////////////////////
        // $result_data=result_ledger::all();
        $min= DB::table('result_ledgers')->whereIn('category', $mutualValues)->min('start_date');
         $max= DB::table('result_ledgers')->whereIn('category', $mutualValues)->max('end_date');
         $total_debit= DB::table("result_ledgers")->whereIn('category', $mutualValues)->sum('debit_amount');
         $total_credit= DB::table("result_ledgers")->whereIn('category', $mutualValues)->sum('credit_amount');
         $total_amount= DB::table("result_ledgers")->whereIn('category', $mutualValues)->sum('total_amount');
        return view('result_ledger.index',['result_data'=> $result_data,'category'=>$mutualValues,'min'=>$min,'max'=>$max,'debit'=>$total_debit,'credit'=>$total_credit,'total'=>$total_amount]);
    

    }



    function filter(Request $req){
        $from_date=$req->from_date;
        $to_date=$req->to_date;
        $cat=$req->cat;


        $month_1=date('m', strtotime($from_date));
        $year_1=date('Y', strtotime($from_date));
        

        $month_2=date('m', strtotime($to_date));
        $year_2=date('Y', strtotime($to_date));

        $fromdate1="$year_1-$month_1-01";
        $todate1="$year_2-$month_2-30";

/////////check user permissions
        $user = Auth::user();
        $permissions = $user->getPermissionsViaRoles();
          $data = json_decode($permissions, true); // Convert JSON string to PHP array

          $names = array_column($data, 'name');
    
         $category = DB::table('categories')
           ->distinct()
         ->pluck('category');
  
           $simpleArray = $category->toArray();
         $simpleArray1 = array_values($simpleArray);

         $simpleArray2 = [$cat];
////////for all categories
         $mutualValues1 = array_intersect($simpleArray1,$names);

         //////for particular
        $mutualValues2 = array_intersect($simpleArray1, $names, $simpleArray2);






if($cat!=='all category'){
      $result_data= DB::table('result_ledgers')
          ->where([
          ['end_date', '>=', $fromdate1],
          ['end_date', '<=', $todate1],
          ['category', 'LIKE', '%'.$cat.'%']
          ])
          ->whereIn('category', $mutualValues2)
          ->get();

          $total_debit= DB::table("result_ledgers")
          ->where([
              ['end_date', '>=', $fromdate1],
              ['end_date', '<=', $todate1],
              ['category', 'LIKE', '%'.$cat.'%']
              ])
              ->whereIn('category', $mutualValues2)
          ->sum('debit_amount');

          $total_credit= DB::table("result_ledgers")
          ->where([
              ['end_date', '>=', $fromdate1],
              ['end_date', '<=', $todate1],
              ['category', 'LIKE', '%'.$cat.'%']
              ])
              ->whereIn('category', $mutualValues2)
          ->sum('credit_amount');
          $total_amount= DB::table("result_ledgers")
          ->where([
              ['end_date', '>=', $fromdate1],
              ['end_date', '<=', $todate1],
              ['category', 'LIKE', '%'.$cat.'%']
              ])
              ->whereIn('category', $mutualValues2)
          ->sum('total_amount');



          return view('result_ledger.index',['result_data'=> $result_data,'category'=>$mutualValues1,'min'=>$fromdate1,'max'=>$todate1,'debit'=>$total_debit,'credit'=>$total_credit,'total'=>$total_amount]);
          }

if($cat=='all category'){

       $result_data= DB::table('result_ledgers')
          ->where([
            ['end_date', '>=', $fromdate1],
            ['end_date', '<=', $todate1],
          ])->whereIn('category', $mutualValues1)
          ->get();

          $total_debit= DB::table("result_ledgers")
          ->where([
              ['end_date', '>=', $fromdate1],
              ['end_date', '<=', $todate1]
              
              ])->whereIn('category', $mutualValues1)
          ->sum('debit_amount');

          $total_credit= DB::table("result_ledgers")
          ->where([
              ['end_date', '>=', $fromdate1],
              ['end_date', '<=', $todate1]
             
              ])->whereIn('category', $mutualValues1)
          ->sum('credit_amount');
          $total_amount= DB::table("result_ledgers")
          ->where([
              ['end_date', '>=', $fromdate1],
              ['end_date', '<=', $todate1]
            
              ])->whereIn('category', $mutualValues1)
          ->sum('total_amount');


          return view('result_ledger.index',['result_data'=> $result_data,'category'=>$mutualValues1,'min'=>$fromdate1,'max'=>$todate1,'debit'=>$total_debit,'credit'=>$total_credit,'total'=>$total_amount]);

            }


}

}
