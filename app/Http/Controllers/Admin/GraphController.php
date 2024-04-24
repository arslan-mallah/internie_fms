<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\addpay;
use App\Models\general_ledger;
use App\Models\result_ledger;
use Illuminate\Support\Facades\DB;
use Auth;
class GraphController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    function __construct()
    {
        
        $this->middleware('role_or_permission:showgraph', ['only' => ['index']]);
    
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


        ///////////////////
        $sqll= DB::table('result_ledgers')
        ->select('category',  DB::raw('SUM(debit_amount) as sum_debit'),DB::raw('SUM(credit_amount) as sum_credit'))
        ->groupBy('category')
        ->whereIn('category', $mutualValues)
        ->get();


        if($sqll->count()>0){
            $expenses_p=array(); 
            $revenue_p=array();
            $category_p=array();
            foreach ($sqll as $sqll) {
                
                $expenses_p[]=$sqll->sum_debit;
                $revenue_p[]=$sqll->sum_credit;
                $category_p[]=$sqll->category;


            }
        }

        $max= DB::table('result_ledgers')->whereIn('category', $mutualValues)->max('start_date');
        $min= DB::table('result_ledgers')->whereIn('category', $mutualValues)->min('start_date');

////////////////month report///////////
        $sqlll= DB::table('result_ledgers')
        ->select('start_date', DB::raw('SUM(debit_amount) as month_debit'),DB::raw('SUM(credit_amount) as month_credit'))
        ->whereBetween('start_date', [$min, $max])
        ->whereIn('category', $mutualValues)
        ->groupBy('start_date')
        ->get();

        if($sqlll->count()>0){
            $expenses_m=array(); 
            $revenue_m=array();
            $type_m=array();
            foreach ($sqlll as $sqlll){
                
                $expenses_m[]=$sqlll->month_debit;
                $revenue_m[]=$sqlll->month_credit;
                $type_m[]=date('F,Y',strtotime($sqlll->start_date));


            }
        }


        //////////////weekly//////
        $firstElement1 = reset($mutualValues);
        $firstElement = str_replace('"', '', $firstElement1);
// dd($firstElement);
        $start= DB::table('general_ledgers')
        ->where('category','=',$firstElement)
        ->min('date');

        $end= DB::table('general_ledgers')
        ->where('category','=',$firstElement)
        ->max('date');

      



        $byweek = DB::select("
        with recursive Dates AS (
            SELECT DATE(?) AS date
            UNION ALL
            SELECT Dates.date + INTERVAL 1 DAY
            FROM Dates
            WHERE Dates.date < ?
        )
        SELECT Dates.date, 'category', WEEK(Dates.date) AS Week, YEAR(Dates.date) AS year,
            COALESCE(SUM(general_ledgers.debit), 0) AS debit1,
            COALESCE(SUM(general_ledgers.credit), 0) AS credit1
        FROM Dates
        LEFT JOIN general_ledgers ON Dates.date = general_ledgers.date AND category = '$firstElement'
        GROUP BY Week, year
        ORDER BY Dates.date
    ", [$start, $end]);
       


        if(count($byweek)>0){
           $expenses3=array(); 
           $revenue3=array();
           $type3=array();
           foreach ($byweek  as $byweek ) {
               
               $expenses3[]=$byweek ->debit1;
               $revenue3[]=$byweek ->credit1;
               $type3[]=date("Y-m-d", strtotime('next sunday', strtotime($byweek->date)));;


           }
       }


       $cat='miscellaneous payment';
       $firstDate=$type3[0];
       $lastDate=$type3[array_key_last($type3)];

       $amount=DB::table('general_ledgers')
       ->select(DB::raw('SUM(debit) as debit_t'), (DB::raw('SUM(credit) as total_t')))
       ->where('category','=',$firstElement)
       ->get();
    
       if($amount->count()==1){
        foreach ($amount as $amount) {

            $total_d=$amount->debit_t;
            $total_c=$amount->total_t;
        }
    }

/////////////////////end week////////////
          if($sqll){
            if($sqlll){
            return view('graph_analysis.index',['graph_data'=> $sqll,'category'=>$mutualValues,'month_data'=>$sqlll,'expenses'=>$expenses_p,'revenue'=> $revenue_p,'category'=>$category_p,'min'=>$min,'max'=>$max,'expense_m'=>$expenses_m,'revenue_m'=>$revenue_m,'type_m'=>$type_m,'expenses3'=>$expenses3,'revenue3'=>$revenue3,'type3'=>$type3,'cat'=>$firstElement,'total_d'=>$total_d,'total_c'=>$total_c,'firstDate'=>$firstDate,'lastDate'=>$lastDate]);
           
        }
          }
    }






    ///////////////filter the data//////////

    function filter(Request $req){

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


    
//////////////////////////progress report////////////////

        $sqll= DB::table('result_ledgers')
        ->select('category',  DB::raw('SUM(debit_amount) as sum_debit'),DB::raw('SUM(credit_amount) as sum_credit'))
        ->whereIn('category', $mutualValues)
        ->groupBy('category')
        ->get();


        if($sqll->count()>0){
            $expenses_p=array(); 
            $revenue_p=array();
            $category_p=array();
            foreach ($sqll as $sqll) {
                
                $expenses_p[]=$sqll->sum_debit;
                $revenue_p[]=$sqll->sum_credit;
                $category_p[]=$sqll->category;


            }
        }

        $min=$req->startDate;
        $max=$req->endDate;

        $month_graph=date('m', strtotime($req->startDate));
        $year_graph=date('Y', strtotime($req->startDate));
        $modify_date="$year_graph-$month_graph-01";

        $month_graph1=date('m', strtotime($req->endDate));
        $year_graph1=date('Y', strtotime($req->endDate));
        $modify_date1="$year_graph1-$month_graph1-30";

////////////////month report///////////
        $sqlll= DB::table('result_ledgers')
        ->select('start_date', DB::raw('SUM(debit_amount) as month_debit'),DB::raw('SUM(credit_amount) as month_credit'))
        ->whereBetween('start_date', [$modify_date, $modify_date1])
        ->whereIn('category', $mutualValues)
        ->groupBy('start_date')
        ->get();

        if($sqlll->count()>0){
            $expenses_m=array(); 
            $revenue_m=array();
            $type_m=array();
            foreach ($sqlll as $sqlll) {
                
                $expenses_m[]=$sqlll->month_debit;
                $revenue_m[]=$sqlll->month_credit;
                $type_m[]=date('F,Y',strtotime($sqlll->start_date));


            }
        }

    //////////////week//////////
    $firstElement1 = reset($mutualValues);
    $firstElement = str_replace('"', '', $firstElement1);

    $start= DB::table('general_ledgers')
    ->where('category','=',$firstElement)
   
    ->min('date');
    $end= DB::table('general_ledgers')
    ->where('category','=',$firstElement)
  
    ->max('date');


    $byweek = DB::select("
    with recursive Dates AS (
        SELECT DATE(?) AS date
        UNION ALL
        SELECT Dates.date + INTERVAL 1 DAY
        FROM Dates
        WHERE Dates.date < ?
    )
    SELECT Dates.date, 'category', WEEK(Dates.date) AS Week, YEAR(Dates.date) AS year,
        COALESCE(SUM(general_ledgers.debit), 0) AS debit1,
        COALESCE(SUM(general_ledgers.credit), 0) AS credit1
    FROM Dates
    LEFT JOIN general_ledgers ON Dates.date = general_ledgers.date AND category = '$firstElement'
    GROUP BY Week, year
    ORDER BY Dates.date
", [$start, $end]);
   


    if(count($byweek)>0){
        $expenses3=array(); 
        $revenue3=array();
        $type3=array();
        foreach ($byweek  as $byweek ) {
            
            $expenses3[]=$byweek ->debit1;
            $revenue3[]=$byweek ->credit1;
            $type3[]=date("Y-m-d", strtotime('next sunday', strtotime($byweek->date)));;


        }
    }


    $cat='miscellaneous payment';

    $firstDate=$type3[0];
    $lastDate=$type3[array_key_last($type3)];

    $amount=DB::table('general_ledgers')
    ->select(DB::raw('SUM(debit) as debit_t'), (DB::raw('SUM(credit) as total_t')))
    ->where('category','=',$firstElement)
    ->get();
 
    if($amount->count()==1){
     foreach ($amount as $amount) {

         $total_d=$amount->debit_t;
         $total_c=$amount->total_t;
     }
 }




//////////////end week//////////
          if($sqll){
            if($sqlll){
        return view('graph_analysis.index',['graph_data'=> $sqll,'month_data'=>$sqlll,'expenses'=>$expenses_p,'revenue'=> $revenue_p,'category'=>$category_p,'min'=>$min,'max'=>$max,'expense_m'=>$expenses_m,'revenue_m'=>$revenue_m,'type_m'=>$type_m,'expenses3'=>$expenses3,'revenue3'=>$revenue3,'type3'=>$type3,'cat'=>$firstElement,'total_d'=>$total_d,'total_c'=>$total_c,'firstDate'=>$firstDate,'lastDate'=>$lastDate]);

           
        }
          }

               }



////////////ajax when change////////


function ajaxData(Request $req){
    $cat1=$req->value;
/////////////////////////

$user = Auth::user();
$permissions = $user->getPermissionsViaRoles();
  $data = json_decode($permissions, true); // Convert JSON string to PHP array

  $names = array_column($data, 'name');

 $category = DB::table('categories')
   ->distinct()
 ->pluck('category');

   $simpleArray = $category->toArray();
 $simpleArray1 = array_values($simpleArray);

 $simpleArray2 = [$cat1];
////////for all categories
 $mutualValues1 = array_intersect($simpleArray1,$names);

 //////for particular
$mutualValues2 = array_intersect($simpleArray1, $names, $simpleArray2);
if(count($mutualValues2)!== 0){
$firstElement1 = reset($mutualValues2);
$firstElement = str_replace('"', '', $firstElement1);

////////////////////////
    $start= DB::table('general_ledgers')
    ->where('category','=',$firstElement)
    ->min('date');
    $end= DB::table('general_ledgers')
    ->where('category','=',$firstElement)
    ->max('date');
   
/////////////
$byweek = DB::select("
with recursive Dates AS (
    SELECT DATE(?) AS date
    UNION ALL
    SELECT Dates.date + INTERVAL 1 DAY
    FROM Dates
    WHERE Dates.date < ?
)
SELECT Dates.date, 'category', WEEK(Dates.date) AS Week, YEAR(Dates.date) AS year,
    COALESCE(SUM(general_ledgers.debit), 0) AS debit1,
    COALESCE(SUM(general_ledgers.credit), 0) AS credit1
FROM Dates
LEFT JOIN general_ledgers ON Dates.date = general_ledgers.date AND category = '$firstElement'
GROUP BY Week, year
ORDER BY Dates.date
", [$start, $end]);



if(count($byweek)>0){
   
       $expenses4=array(); 
       $revenue4=array();
       $type4=array();
       foreach ($byweek  as $byweek ) {
           
           $expenses4[]=$byweek ->debit1;
           $revenue4[]=$byweek ->credit1;
           $type4[]=date("Y-m-d", strtotime('next sunday', strtotime($byweek->date)));


       }
   }


  $cat=$req->value;

   $firstDate=$type4[0];
   $lastDate=$type4[array_key_last($type4)];

   $amount=DB::table('general_ledgers')
   ->select(DB::raw('SUM(debit) as debit_t'), (DB::raw('SUM(credit) as total_t')))
   ->where('category','=',$mutualValues2)
   ->get();

   if($amount->count()==1){
    foreach ($amount as $amount) {

        $total_d=$amount->debit_t;
        $total_c=$amount->total_t;
    }
}



return response()->json(['expenses4'=>$expenses4,'revenue4'=> $revenue4,'type4'=>$type4,'cat'=>$firstElement,'total_d'=>$total_d,'total_c'=>$total_c,'firstDate'=>$firstDate,'lastDate'=>$lastDate]);
}
}
////////////end ajax1///////


//////////////ajax2//////////


function ajaxDataa(Request $req){




    $start=date("Y-m-d", strtotime('-6 day', strtotime($req->start)));
    $end=date("Y-m-d", strtotime('-1 day', strtotime($req->end)));
    $cat1=$req->category_w;


/////////////////////////

$user = Auth::user();
$permissions = $user->getPermissionsViaRoles();
  $data = json_decode($permissions, true); // Convert JSON string to PHP array

  $names = array_column($data, 'name');

 $category = DB::table('categories')
   ->distinct()
 ->pluck('category');

   $simpleArray = $category->toArray();
 $simpleArray1 = array_values($simpleArray);

 $simpleArray2 = [$cat1];
////////for all categories
 $mutualValues1 = array_intersect($simpleArray1,$names);

 //////for particular
$mutualValues2 = array_intersect($simpleArray1, $names, $simpleArray2);

$firstElement1 = reset($mutualValues2);
$firstElement = str_replace('"', '', $firstElement1);







//////////////////


    $byweek = DB::select("
with recursive Dates AS (
    SELECT DATE(?) AS date
    UNION ALL
    SELECT Dates.date + INTERVAL 1 DAY
    FROM Dates
    WHERE Dates.date < ?
)
SELECT Dates.date, 'category', WEEK(Dates.date) AS Week, YEAR(Dates.date) AS year,
    COALESCE(SUM(general_ledgers.debit), 0) AS debit1,
    COALESCE(SUM(general_ledgers.credit), 0) AS credit1
FROM Dates
LEFT JOIN general_ledgers ON Dates.date = general_ledgers.date AND category = '$firstElement'
GROUP BY Week, year
ORDER BY Dates.date
", [$start, $end]);



if(count($byweek)>0){
       $expenses4=array(); 
       $revenue4=array();
       $type4=array();
       foreach ($byweek  as $byweek ) {
           
           $expenses4[]=$byweek ->debit1;
           $revenue4[]=$byweek ->credit1;
           $type4[]=date("Y-m-d", strtotime('next sunday', strtotime($byweek->date)));;


       }
   }


  $cat=$req->category_w;

   $firstDate=$type4[0];
   $lastDate=$type4[array_key_last($type4)];

   $amount=DB::table('general_ledgers')
   ->select(DB::raw('SUM(debit) as debit_t'), (DB::raw('SUM(credit) as total_t')))
   ->whereBetween('date', [$start,$req->end])
   ->where('category','=',$firstElement)
   ->get();

   if($amount->count()==1){
    foreach ($amount as $amount) {

        $total_d=$amount->debit_t;
        $total_c=$amount->total_t;
    }
}



return response()->json(['expenses4'=>$expenses4,'revenue4'=> $revenue4,'type4'=>$type4,'cat'=>$cat,'total_d'=>$total_d,'total_c'=>$total_c,'firstDate'=>$firstDate,'lastDate'=>$lastDate]);

}





////////end ajax2/////////

//////////start ajax3////


function ajaxDataaa(Request $req){

   

    $cat1=$req->category_w;

    $user = Auth::user();
$permissions = $user->getPermissionsViaRoles();
  $data = json_decode($permissions, true); // Convert JSON string to PHP array

  $names = array_column($data, 'name');

 $category = DB::table('categories')
   ->distinct()
 ->pluck('category');

   $simpleArray = $category->toArray();
 $simpleArray1 = array_values($simpleArray);

 $simpleArray2 = [$cat1];
////////for all categories
 $mutualValues1 = array_intersect($simpleArray1,$names);

 //////for particular
$mutualValues2 = array_intersect($simpleArray1, $names, $simpleArray2);

$firstElement1 = reset($mutualValues2);
$firstElement = str_replace('"', '', $firstElement1);
  
$start= DB::table('general_ledgers')
->where('category','=',$firstElement)
->min('date');
$end= DB::table('general_ledgers')
->where('category','=',$firstElement)
->max('date');

    $byweek = DB::select("
with recursive Dates AS (
    SELECT DATE(?) AS date
    UNION ALL
    SELECT Dates.date + INTERVAL 1 DAY
    FROM Dates
    WHERE Dates.date < ?
)
SELECT Dates.date, 'category', WEEK(Dates.date) AS Week, YEAR(Dates.date) AS year,
    COALESCE(SUM(general_ledgers.debit), 0) AS debit1,
    COALESCE(SUM(general_ledgers.credit), 0) AS credit1
FROM Dates
LEFT JOIN general_ledgers ON Dates.date = general_ledgers.date AND category = '$firstElement'
GROUP BY Week, year
ORDER BY Dates.date
", [$start, $end]);



if(count($byweek)>0){
     $expenses4=array(); 
     $revenue4=array();
     $type4=array();
     foreach ($byweek  as $byweek ) {
         
         $expenses4[]=$byweek ->debit1;
         $revenue4[]=$byweek ->credit1;
         $type4[]=date("Y-m-d", strtotime('next sunday', strtotime($byweek->date)));;


     }
 }



 $firstDate=$type4[0];
 $lastDate=$type4[array_key_last($type4)];
// dd($firstElement);
 $amount=DB::table('general_ledgers')
 ->select(DB::raw('SUM(debit) as debit_t'), (DB::raw('SUM(credit) as total_t')))
 ->where('category', '=', $firstElement)
 ->get();

 if($amount->count()==1){
  foreach ($amount as $amount) {

      $total_d=$amount->debit_t;
      $total_c=$amount->total_t;
  }
}



return response()->json(['expenses4'=>$expenses4,'revenue4'=> $revenue4,'type4'=>$type4,'cat'=>$cat1,'total_d'=>$total_d,'total_c'=>$total_c,'firstDate'=>$firstDate,'lastDate'=>$lastDate]);

}



///////////end ajax3/////

//////////start ajax4//////////



function ajaxDataaaa(Request $req){




    $start=date("Y-m-d", strtotime('-7 day', strtotime($req->start)));
    $end=date("Y-m-d", strtotime('-2 day', strtotime($req->end)));
    
    $cat1=$req->category_w;

    $user = Auth::user();
    $permissions = $user->getPermissionsViaRoles();
      $data = json_decode($permissions, true); // Convert JSON string to PHP array
    
      $names = array_column($data, 'name');
    
     $category = DB::table('categories')
       ->distinct()
     ->pluck('category');
    
       $simpleArray = $category->toArray();
     $simpleArray1 = array_values($simpleArray);
    
     $simpleArray2 = [$cat1];
    ////////for all categories
     $mutualValues1 = array_intersect($simpleArray1,$names);
    
     //////for particular
    $mutualValues2 = array_intersect($simpleArray1, $names, $simpleArray2);
    
    $firstElement1 = reset($mutualValues2);
    $firstElement = str_replace('"', '', $firstElement1);
      






    $byweek = DB::select("
    with recursive Dates AS (
        SELECT DATE(?) AS date
        UNION ALL
        SELECT Dates.date + INTERVAL 1 DAY
        FROM Dates
        WHERE Dates.date < ?
    )
    SELECT Dates.date, 'category', WEEK(Dates.date) AS Week, YEAR(Dates.date) AS year,
        COALESCE(SUM(general_ledgers.debit), 0) AS debit1,
        COALESCE(SUM(general_ledgers.credit), 0) AS credit1
    FROM Dates
    LEFT JOIN general_ledgers ON Dates.date = general_ledgers.date AND category = '$firstElement'
    GROUP BY Week, year
    ORDER BY Dates.date
    ", [$start, $end]);
    

   
    if(count($byweek)>0){
       $expenses4=array(); 
       $revenue4=array();
       $type4=array();
       foreach ($byweek  as $byweek ) {
           
           $expenses4[]=$byweek ->debit1;
           $revenue4[]=$byweek ->credit1;
           $type4[]=date("Y-m-d", strtotime('next sunday', strtotime($byweek->date)));;


       }
   }


  $cat=$req->category_w;

   $firstDate=$type4[0];
   $lastDate=$type4[array_key_last($type4)];

   $amount=DB::table('general_ledgers')
   ->select(DB::raw('SUM(debit) as debit_t'), (DB::raw('SUM(credit) as total_t')))
   ->whereBetween('date', [$start,$req->end])
   ->where('category','=',$firstElement)
   ->get();

   if($amount->count()==1){
    foreach ($amount as $amount) {

        $total_d=$amount->debit_t;
        $total_c=$amount->total_t;
    }
}



return response()->json(['expenses4'=>$expenses4,'revenue4'=> $revenue4,'type4'=>$type4,'cat'=>$cat,'total_d'=>$total_d,'total_c'=>$total_c,'firstDate'=>$firstDate,'lastDate'=>$lastDate]);

}



///////////////end ajax 4//////
    
   
}
