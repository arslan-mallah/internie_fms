<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\addpay;
use App\Models\general_ledger;
use App\Models\result_ledger;
use Illuminate\Support\Facades\DB;
use Auth;
class GeneralController extends Controller
{
  
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    function __construct()
    {

        $this->middleware('role_or_permission:showgeneral',['only' => ['index','show']]);
        $this->middleware('role_or_permission:addpay',['only' => ['create','store']]);
        $this->middleware('role_or_permission:editgeneral', ['only' => ['edit','update']]);
        $this->middleware('role_or_permission:deletegeneral', ['only' => ['destroy']]);
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

      // $categories = ['salaries', 'category2', 'pettycash']; // Replace with your array of categories

        
        $data_general1=general_ledger::whereNotNull('date') ->whereIn('category', $mutualValues)->orderByDesc('id')->get();
        $max= DB::table('general_ledgers')->whereIn('category', $mutualValues)->max('date');
        $min= DB::table('general_ledgers')->whereIn('category', $mutualValues)->min('date');

        return view('general_ledger.index',['data_general'=> $data_general1,'category'=>$mutualValues,'max'=>$max,'min'=>$min]);


        
    }



    //////////////filter///////////
    function filter(Request $req){
        $from_date=$req->from_date;
        $to_date=$req->to_date;
        $cat=$req->cat;

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

$data_general= DB::table('general_ledgers')
->where([
['date', '>=', $from_date],
['date', '<=', $to_date],
])
->whereIn('category', $mutualValues2)


->get();
return view('general_ledger.index',['data_general'=> $data_general,'category'=>$mutualValues1,'min'=>$from_date,'max'=>$to_date]);
}

if($cat=='all category'){

$data_general= DB::table('general_ledgers')
->where([
['date', '>=', $from_date],
['date', '<=', $to_date]
])->whereIn('category', $mutualValues1)
->get();

return view('general_ledger.index',['data_general'=> $data_general,'category'=>$mutualValues1,'min'=>$from_date,'max'=>$to_date]);

}


}



    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */





     


    
   
    

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(general_ledger $general_ledger)
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

      
        $data=general_ledger::find($general_ledger->id);
        
       return view('general_ledger.edit',['general_ledger' => $general_ledger,'data'=>$data,'category'=>$mutualValues]);
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

      $username= Auth::user()->name;
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

       $originalcategory=[$req->cat];
       $checkcategory = array_intersect($originalcategory, $mutualValues);
         if(count($checkcategory)!== 0){
      




                    $id=$req->id;

                   $sql2=DB::table('general_ledgers')->where('id',$id)->get();
                   $update2=json_encode($sql2);

                   if($sql2->count()==1){
                      foreach ($sql2 as $sql2) {

                          $date=$sql2->date;
                          $year= date('F,Y', strtotime($sql2->date));
                          $cat_org=$sql2->category;
                          $debit_org=$sql2->debit;
                          $credit_org=$sql2->credit;

                       }}

                          $date = date('Y-m-d',strtotime($req->date));
                          $day=date('D', strtotime($req->date));
                          $amt=$req->amt;
                          $amn_type=$req->type;
                        
                          $create_date = date('Y-m-d',strtotime($req->date));
                         $year_edit= date('F,Y', strtotime($req->date));
                      



                         $sql5=DB::table('result_ledgers')
                         ->where([
                             ['category', 'LIKE', '%'.$cat_org.'%'],
                             ['type', 'LIKE', '%'.$year.'%']
                         ])
                         ->get();

                         if($sql5->count()==1){
                            foreach ($sql5 as $sql5) {
                         $result_amount=$sql5->debit_amount;
                          $result_cramount=$sql5->credit_amount;
                          $result_total=$sql5->total_amount;

                            }}

                         $date5 = date('y-m-d;h:i:s');

                        
                            
                        
           if($debit_org==!0 && $amn_type=='debit'){

              if($debit_org==$amt){
                $data_general1=general_ledger::whereNotNull('date')->orderByDesc('id')->get();
                $max= DB::table('general_ledgers')->max('date');
                $min= DB::table('general_ledgers')->min('date');
              return redirect()->route('admin.general_ledger.index')->with('message', 'Updated successfully');
            
            }


             $sql= DB::table('general_ledgers')
             ->where('id', $id)
             ->update(['date' => $date,'day' => $day,'username'=>$username,'category'=>$req->cat,'detail'=>$req->detail,'debit' => $amt, 'update_id' => $req->sessionid, 'update_time' => $date5 ],);
            $update=DB::table('general_ledgers')->where('id', $id)->get();
            $update1=json_encode($update);
          
            // dd($update);
             if($sql){
            
              $notification= DB::table('notifications')
              ->insert(
              [
               'user_id'=> Auth::user()->id,
              'user_name'=> Auth::user()->name,
                'action'=>'update',
           'page_affected'=>'general ledger',
             'old_data'=> $update2,
             'new_data'=> $update1,
            'markasread'=> 'false',
               ]
             );
  

                if($year_edit==$year && $req->cat==$cat_org){
                    
                
                    $debit_change=$amt-$debit_org;
                    
                    $update_amount=$result_amount+$debit_change;
                    $update_total= $result_total-$debit_change;


                    $sql4= DB::table('result_ledgers')
                    ->where([
                        ['category', 'LIKE', '%'.$cat_org.'%'],
                        ['type', 'LIKE', '%'.$year_edit.'%']
                    ])
                    ->update([ 'debit_amount' =>$update_amount, 'total_amount' => $update_total ],);


                  if($sql4){
                    $data_general1=general_ledger::whereNotNull('date')->orderByDesc('id')->get();
        $max= DB::table('general_ledgers')->max('date');
        $min= DB::table('general_ledgers')->min('date');
                  return redirect()->route('admin.general_ledger.index')->with('message', 'Updated successfully');

                  }
            


                 }


        
//////////////////////next///////
    
elseif($year_edit==$year && $req->cat!==$cat_org){
    
    $debit_change=$amt-$debit_org;

    $update_amount=$result_amount+$debit_change;
    $update_total= $result_total-$debit_change;

    $sql6=DB::table('result_ledgers')
                         ->where([
                             ['category', 'LIKE', '%'.$req->cat.'%'],
                             ['type', 'LIKE', '%'.$year_edit.'%']
                         ])
                         ->get();


                if($sql6->count()==1){
                            foreach ($sql6 as $sql6) {


                                $debit_6amount=$sql6->debit_amount;
                                $debit_6total=$sql6->total_amount;
                                $update_6amount=$debit_6amount+$amt;
                                $update_6tamouunt= $debit_6total-$amt;


                                $sql4= DB::table('result_ledgers')
                                      ->where([
                                   ['category', 'LIKE', '%'.$req->cat.'%'],
                                  ['type', 'LIKE', '%'.$year_edit.'%']
                                                   ])
                                ->update([ 'debit_amount' =>$update_6amount, 'total_amount' => $update_6tamouunt ],);


                                 if($sql4){
                                 $changed_amount=$result_amount-$debit_org;
                                $changed_total= $result_total + $debit_org;
      
                                $sql8= DB::table('result_ledgers')
                                ->where([
                             ['category', 'LIKE', '%'.$cat_org.'%'],
                            ['type', 'LIKE', '%'.$year.'%']
                            ])
                          ->update([ 'debit_amount' =>$changed_amount, 'total_amount' => $changed_total],);




                            
                             if($sql8){
                                $data_general1=general_ledger::whereNotNull('date')->orderByDesc('id')->get();
        $max= DB::table('general_ledgers')->max('date');
        $min= DB::table('general_ledgers')->min('date');
                              return redirect()->route('admin.general_ledger.index')->with('message', 'Updated successfully');
                             }
      
      
                             }
    

                }

            }else{
                $first1= date('Y-m-01');
                $date1= date('d-m-Y');
                $totalAmount=0-$amt;
            $month5=date('m', strtotime($req->date));
            $year5=date('Y', strtotime($req->date));
            $first5="$year5-$month5-01";
            $date5="$year5-$month5-30";


            $sql11= DB::table('result_ledgers')
            ->insert(
              [
             'category'=>$req->cat,
             'type'=>$year_edit,
             'start_date'=>$first5,
             'end_date'=>$date5,
             'debit_amount'=> $amt,
             'credit_amount'=> 0,
             'total_amount'=> $totalAmount,
                 ]
              );



           
            if($sql11){
                $changed1_amount=$result_amount-$debit_org;
                $changed1_total=$result_total+$debit_org;

                $sql12= DB::table('result_ledgers')
                ->where([
             ['category', 'LIKE', '%'.$cat_org.'%'],
            ['type', 'LIKE', '%'.$year.'%']
            ])
          ->update([ 'debit_amount' =>$changed1_amount, 'total_amount' => $changed1_total],);



              if($sql12){
                $data_general1=general_ledger::whereNotNull('date')->orderByDesc('id')->get();
                $max= DB::table('general_ledgers')->max('date');
                $min= DB::table('general_ledgers')->min('date');
              return redirect()->route('admin.general_ledger.index')->with('message', 'Updated successfully');

                } 
                }


            }

    
    }
       
    elseif($year_edit!==$year && $req->cat!==$cat_org){
        $changed2_amount=$result_amount-$debit_org;
        $changed2_total=$result_total + $debit_org; 

        $sql17= DB::table('result_ledgers')
             ->where([
            ['category', 'LIKE', '%'.$cat_org.'%'],
            ['type', 'LIKE', '%'.$year.'%']
            ])
         ->update([ 'debit_amount' =>$changed2_amount, 'total_amount' => $changed2_total],);


        $first1= date('Y-m-01');
         $date1= date('d-m-Y');


         $sql27=DB::table('result_ledgers')
         ->where([
             ['category', 'LIKE', '%'.$req->cat.'%'],
             ['type', 'LIKE', '%'.$year_edit.'%']
         ])
         ->get();

         if($sql27->count()==1){
            foreach ($sql27 as $sql27) {
                $debit_27amount=$sql27->debit_amount;
                $debit_27total=$sql27->total_amount;
                $update_27amount=$debit_27amount+$amt;
                $update_27tamouunt= $debit_27total-$amt;


                $sql4= DB::table('result_ledgers')
                  ->where([
                  ['category', 'LIKE', '%'.$req->cat.'%'],
                  ['type', 'LIKE', '%'.$year_edit.'%']
                  ])
                 ->update([ 'debit_amount' =>$update_27amount, 'total_amount' => $update_27tamouunt],);

           if($sql4){
            $data_general1=general_ledger::whereNotNull('date')->orderByDesc('id')->get();
            $max= DB::table('general_ledgers')->max('date');
            $min= DB::table('general_ledgers')->min('date');
           return redirect()->route('admin.general_ledger.index')->with('message', 'Updated successfully');
      
            }

            }}




        else{

       $change32=0-$amt;
     $month6=date('m', strtotime($req->date));
      $year6=date('Y', strtotime($req->date));
      $first6="$year6-$month6-01";
      $date6="$year6-$month6-30";
  
      $sql32= DB::table('result_ledgers')
      ->insert(
        [
       'category'=>$req->cat,
       'type'=>$year_edit,
       'start_date'=>$first6,
       'end_date'=>$date6,
       'debit_amount'=> $amt,
       'credit_amount'=> 0,
       'total_amount'=> $change32,
           ]
        );

 
   if($sql32){
    $data_general1=general_ledger::whereNotNull('date')->orderByDesc('id')->get();
    $max= DB::table('general_ledgers')->max('date');
    $min= DB::table('general_ledgers')->min('date');
  return redirect()->route('admin.general_ledger.index')->with('message', 'Updated successfully');

      }
   }

}
       
       ///////////////////
       
       elseif($year_edit!==$year && $req->cat==$cat_org){
     

        $sql13=DB::table('result_ledgers')
        ->where([
            ['category', 'LIKE', '%'.$req->cat.'%'],
            ['type', 'LIKE', '%'.$year_edit.'%']
        ])
        ->get();

        if($sql13->count()==1){
           foreach ($sql13 as $sql13) {



// echo "we get";
$debit_13amount=$sql13->debit_amount;
$debit_13total=$sql13->total_amount;
$update_13amount=$debit_13amount+$amt;
$update_13tamouunt= $debit_13total-$amt;


$sql14= DB::table('result_ledgers')
                  ->where([
                  ['category', 'LIKE', '%'.$req->cat.'%'],
                  ['type', 'LIKE', '%'.$year_edit.'%']
                  ])
                 ->update([ 'debit_amount' =>$update_13amount, 'total_amount' => $update_13tamouunt],);





if($sql14){
// echo "updated in result";
$changed_amount=$result_amount-$debit_org;
$changed_total= $result_total+$debit_org;


$sql15= DB::table('result_ledgers')
                  ->where([
                  ['category', 'LIKE', '%'.$cat_org.'%'],
                  ['type', 'LIKE', '%'.$year.'%']
                  ])
                 ->update([ 'debit_amount' =>$changed_amount, 'total_amount' => $changed_total],);


if($sql15){
    $data_general1=general_ledger::whereNotNull('date')->orderByDesc('id')->get();
    $max= DB::table('general_ledgers')->max('date');
    $min= DB::table('general_ledgers')->min('date');
  return redirect()->route('admin.general_ledger.index')->with('message', 'Updated successfully');

}
}

///foreach end'////////////
     }}

       

       else{
        $first1= date('Y-m-01');
        $date1= date('d-m-Y');
        $totalAmount=0-$amt;
        $month7=date('m', strtotime($req->date));
        $year7=date('Y', strtotime($req->date));
        $first7="$year7-$month7-01";
        $date7="$year7-$month7-30";


        $sql16= DB::table('result_ledgers')
        ->insert(
          [
         'category'=>$req->cat,
         'type'=>$year_edit,
         'start_date'=>$first7,
         'end_date'=>$date7,
         'debit_amount'=> $amt,
         'credit_amount'=> 0,
         'total_amount'=> $totalAmount,
             ]
          );




   
    if($sql16){
        $changed1_amount=$result_amount-$debit_org;
        $changed1_total=$result_total+$debit_org;


        $sql17= DB::table('result_ledgers')
        ->where([
        ['category', 'LIKE', '%'.$cat_org.'%'],
        ['type', 'LIKE', '%'.$year.'%']
        ])
       ->update([ 'debit_amount' =>$changed1_amount, 'total_amount' => $changed1_total],);

      if($sql17){
        $data_general1=general_ledger::whereNotNull('date')->orderByDesc('id')->get();
        $max= DB::table('general_ledgers')->max('date');
        $min= DB::table('general_ledgers')->min('date');
      return redirect()->route('admin.general_ledger.index')->with('message', 'Updated successfully');

      } 
    }
  }


}

       





       ////////ye if wala ha////////
 }

        
else{
   
    return view('edit')->with('message','failed to update');

}


}

///////////////////////////when debit is not zero but type is credit

elseif($debit_org==!0 && $amn_type=='credit'){

    $sql= DB::table('general_ledgers')
    ->where('id', $id)
    ->update(['date' => $date,'day' => $day,'username'=>$username,'category'=>$req->cat,'detail'=>$req->detail,'debit' => 0,'credit'=>$amt, 'update_id' => $req->sessionid, 'update_time' => $date5 ],);
   
    $update=DB::table('general_ledgers')->where('id', $id)->get();
    $update1=json_encode($update);
  
    // dd($update);
     if($sql){
    
      $notification= DB::table('notifications')
      ->insert(
      [
       'user_id'=> Auth::user()->id,
      'user_name'=> Auth::user()->name,
        'action'=>'update',
   'page_affected'=>'general ledger',
     'old_data'=> $update2,
     'new_data'=> $update1,
    'markasread'=> 'false',
       ]
     );

        if($year_edit==$year && $req->cat==$cat_org){
            $debit2=$result_amount-$debit_org;
            $credit2=$result_cramount+$amt;
            $total2=$result_total+$amt+$debit_org;

            $sql18= DB::table('result_ledgers')
            ->where([
            ['category', 'LIKE', '%'.$cat_org.'%'],
            ['type', 'LIKE', '%'.$year_edit.'%']
            ])
           ->update([ 'debit_amount' =>$debit2,'credit_amount'=>$credit2 ,'total_amount' => $total2],);
    



                  if($sql18){
                    $data_general1=general_ledger::whereNotNull('date')->orderByDesc('id')->get();
                    $max= DB::table('general_ledgers')->max('date');
                    $min= DB::table('general_ledgers')->min('date');
                  return redirect()->route('admin.general_ledger.index')->with('message', 'Updated successfully');

                   }
        }



       
        elseif($year_edit==$year && $_POST['cat']!==$cat_org){


       

            $debit3=$result_amount - $debit_org;
            $total3=$result_amount - $debit_org;

            $sql19= DB::table('result_ledgers')
            ->where([
            ['category', 'LIKE', '%'.$cat_org.'%'],
            ['type', 'LIKE', '%'.$year.'%']
            ])
           ->update([ 'debit_amount' =>$debit3,'total_amount' => $total3],);
    
           if($sql19){
               // echo "19";
           }
           
           
           $sql20=DB::table('result_ledgers')
           ->where([
               ['category', 'LIKE', '%'.$req->cat.'%'],
               ['type', 'LIKE', '%'.$year_edit.'%']
           ])
           ->get();
           

           
   
           if($sql20->count()==1){


            foreach ($sql20 as $sql20) {



               // echo "we get";
               $credit_20amount=$sql20->credit_amount;
               $amount_20total=$sql20->total_amount;
               $update_20amount=$credit_20amount+$amt;
               $update_20tamouunt= $amount_20total+$amt;

            }

               $sql21= DB::table('result_ledgers')
                    ->where([
                    ['category', 'LIKE', '%'.$req->cat.'%'],
                    ['type', 'LIKE', '%'.$year_edit.'%']
                    ])
                  ->update([ 'credit_amount' =>$update_20amount,'total_amount' => $update_20tamouunt],);

              if($sql21){
                $data_general1=general_ledger::whereNotNull('date')->orderByDesc('id')->get();
                $max= DB::table('general_ledgers')->max('date');
                $min= DB::table('general_ledgers')->min('date');
              return redirect()->route('admin.general_ledger.index')->with('message', 'Updated successfully');

                        }
               }
           
           
           else{
               $first1= date('Y-m-01');
               $date1= date('d-m-Y');
               $totalAmount=$amt;
               $month8=date('m', strtotime($req->date));
               $year8=date('Y', strtotime($req->date));
               $first8="$year8-$month8-01";
               $date8="$year8-$month8-30";

               $sql22= DB::table('result_ledgers')
               ->insert(
                 [
                'category'=>$req->cat,
                'type'=>$year_edit,
                'start_date'=>$first8,
                'end_date'=>$date8,
                'debit_amount'=> 0,
                'credit_amount'=>$amt,
                'total_amount'=> $totalAmount,
                    ]
                 );


                        if($sql22){
                            $data_general1=general_ledger::whereNotNull('date')->orderByDesc('id')->get();
                            $max= DB::table('general_ledgers')->max('date');
                            $min= DB::table('general_ledgers')->min('date');
                       return redirect()->route('admin.general_ledger.index')->with('message', 'Updated successfully');

                         }
                }

           }




           elseif($year_edit!==$year && $_POST['cat']==$cat_org){


                           $changed4=$result_amount-$debit_org;
                           $total4= $result_total+$debit_org;
     

                           $sql23= DB::table('result_ledgers')
                           ->where([
                           ['category', 'LIKE', '%'.$cat_org.'%'],
                           ['type', 'LIKE', '%'.$year.'%']
                           ])
                         ->update([ 'debit_amount' =>$changed4,'total_amount' => $total4],);



                         $sql24=DB::table('result_ledgers')
                         ->where([
                             ['category', 'LIKE', '%'.$req->cat.'%'],
                             ['type', 'LIKE', '%'.$year_edit.'%']
                         ])
                         ->get();



       
                         if($sql24->count()==1){


                            foreach ($sql24 as $sql24) {

                       //  echo "we get";
                        $credit_24amount=$sql24->credit_amount;
                        $total=$sql24->total_amount;;
                        $update_24amount=$credit_24amount+$amt;
                        $update_24tamouunt= $total+$amt;

                            }
                        $sql25= DB::table('result_ledgers')
                        ->where([
                        ['category', 'LIKE', '%'.$req->cat.'%'],
                        ['type', 'LIKE', '%'.$year_edit.'%']
                        ])
                      ->update([ 'credit_amount' =>$update_24amount,'total_amount' => $update_24tamouunt],);



                       if($sql25){
                        $data_general1=general_ledger::whereNotNull('date')->orderByDesc('id')->get();
        $max= DB::table('general_ledgers')->max('date');
        $min= DB::table('general_ledgers')->min('date');
      return redirect()->route('admin.general_ledger.index')->with('message', 'Updated successfully');
                        }
                       }
        
          else{
                    $first1= date('Y-m-01');
                    $date1= date('d-m-Y');
                    $totalAmount=$amt;
                    $month9=date('m', strtotime($_POST['date']));
                    $year9=date('Y', strtotime($_POST['date']));
                    $first9="$year9-$month9-01";
                    $date9="$year9-$month9-30";


                    $sql26= DB::table('result_ledgers')
                    ->insert(
                      [
                     'category'=>$req->cat,
                     'type'=>$year_edit,
                     'start_date'=>$first9,
                     'end_date'=>$date9,
                     'debit_amount'=> 0,
                     'credit_amount'=>$amt,
                     'total_amount'=> $totalAmount,
                         ]
                      );



                if($sql26){
                    $data_general1=general_ledger::whereNotNull('date')->orderByDesc('id')->get();
                    $max= DB::table('general_ledgers')->max('date');
                    $min= DB::table('general_ledgers')->min('date');
                  return redirect()->route('admin.general_ledger.index')->with('message', 'Updated successfully');

                    }
                }

    }



 

    elseif($year_edit!==$year && $_POST['cat']!==$cat_org){



                  $debit4=$result_amount-$debit_org;
                  $total4=$result_total + $debit_org; 

                  $sql30= DB::table('result_ledgers')
                  ->where([
                  ['category', 'LIKE', '%'.$cat_org.'%'],
                  ['type', 'LIKE', '%'.$year.'%']
                  ])
                 ->update([ 'debit_amount' =>$debit4,'total_amount' => $total4],);


                  if($sql30){
                   // echo "sql30";
                  }

                 $first1= date('Y-m-01');
                 $date1= date('d-m-Y');

                 $sql28=DB::table('result_ledgers')
                         ->where([
                             ['category', 'LIKE', '%'.$req->cat.'%'],
                             ['type', 'LIKE', '%'.$year_edit.'%']
                         ])
                         ->get();

    
                         if($sql28->count()==1){
                            foreach ($sql28 as $sql28) {

                                $credit_28amount=$sql28->credit_amount;
                               $total28=$sql28->total_amount;
                                $update_credit28=$credit_28amount+$amt;
                                 $update_28tamount= $total28+$amt;

                            }
                       $sql29= DB::table('result_ledgers')
                       ->where([
                       ['category', 'LIKE', '%'.$req->cat.'%'],
                       ['type', 'LIKE', '%'.$year_edit.'%']
                       ])
                      ->update([ 'credit_amount' =>$update_credit28,'total_amount' => $update_28tamount],);


                  if($sql29){
                    $data_general1=general_ledger::whereNotNull('date')->orderByDesc('id')->get();
        $max= DB::table('general_ledgers')->max('date');
        $min= DB::table('general_ledgers')->min('date');
              return redirect()->route('admin.general_ledger.index')->with('message', 'Updated successfully');
                      }
                }
      else{

                $total_insert=$amt;
                $month10=date('m', strtotime($_POST['date']));
                $year10=date('Y', strtotime($_POST['date']));
                $first10="$year10-$month10-01";
                $date10="$year10-$month10-30";

                $sql33= DB::table('result_ledgers')
                ->insert(
                  [
                 'category'=>$req->cat,
                 'type'=>$year_edit,
                 'start_date'=>$first10,
                 'end_date'=>$date10,
                 'debit_amount'=> 0,
                 'credit_amount'=>$amt,
                 'total_amount'=> $totalAmount,
                     ]
                  );


                if( $sql33){
                    $data_general1=general_ledger::whereNotNull('date')->orderByDesc('id')->get();
        $max= DB::table('general_ledgers')->max('date');
        $min= DB::table('general_ledgers')->min('date');
                  return redirect()->route('admin.general_ledger.index')->with('message', 'Updated successfully');
                  }
    
            }
    
       }

       else {
            
        return view('general_ledger.edit')->with('message','failed to update');

      }

      
         }
         else{

            return view('general_ledger.edit')->with('message','failed to update');

         }

        
        }


         ////////////////////////new filter////////////////////


         elseif($credit_org==!0 && $amn_type=='debit'){
            $sql= DB::table('general_ledgers')
            ->where('id', $id)
            ->update(['date' => $date,'day' => $day,'username'=>$username,'category'=>$req->cat,'detail'=>$req->detail,'debit' => $amt,'credit'=>'0', 'update_id' => $req->sessionid, 'update_time' => $date5 ],);
            $update=DB::table('general_ledgers')->where('id', $id)->get();
            $update1=json_encode($update);
          
            // dd($update);
             if($sql){
            
              $notification= DB::table('notifications')
              ->insert(
              [
               'user_id'=> Auth::user()->id,
              'user_name'=> Auth::user()->name,
                'action'=>'update',
           'page_affected'=>'general ledger',
             'old_data'=> $update2,
             'new_data'=> $update1,
            'markasread'=> 'false',
               ]
             );

                if($year_edit==$year && $_POST['cat']==$cat_org){
 
                    $debit7=$result_amount+$amt;
                    $credit7=$result_cramount-$credit_org;
                    $total7=$result_total-$amt-$credit_org;


                    $sql35= DB::table('result_ledgers')
                    ->where([
                    ['category', 'LIKE', '%'.$cat_org.'%'],
                    ['type', 'LIKE', '%'.$year_edit.'%']
                    ])
                   ->update([ 'debit_amount' =>$debit7,'credit_amount' => $credit7,'total_amount'=>$total7],);





                
                           if($sql35){
                            $data_general1=general_ledger::whereNotNull('date')->orderByDesc('id')->get();
                            $max= DB::table('general_ledgers')->max('date');
                            $min= DB::table('general_ledgers')->min('date');
                          return redirect()->route('admin.general_ledger.index')->with('message', 'Updated successfully');

                        }
        
               }



              //////////////


              elseif($year_edit==$year && $_POST['cat']!==$cat_org){


       

                $credit8=$result_cramount - $credit_org;
                $total8=$result_total - $credit_org;

                $sql35= DB::table('result_ledgers')
                ->where([
                ['category', 'LIKE', '%'.$cat_org.'%'],
                ['type', 'LIKE', '%'.$year.'%']
                ])
               ->update([ 'credit_amount' => $credit8,'total_amount'=>$total8],);

            
               
               $sql36=DB::table('result_ledgers')
                         ->where([
                             ['category', 'LIKE', '%'.$req->cat.'%'],
                             ['type', 'LIKE', '%'.$year_edit.'%']
                         ])
                         ->get();

    
                         if($sql36->count()==1){
                            foreach ($sql36 as $sql36) {

                                 $debit_36amount=$sql36->debit_amount;
                                $amount_36total=$sql36->total_amount;
                                $update_36amount=$debit_36amount+$amt;
                                 $update_36tamount= $amount_36total-$amt;

                            }


               
                            $sql37= DB::table('result_ledgers')
                            ->where([
                            ['category', 'LIKE', '%'.$req->cat.'%'],
                            ['type', 'LIKE', '%'.$year_edit.'%']
                            ])
                           ->update([ 'debit_amount' => $update_36amount,'total_amount'=>$update_36tamount],);
               
                   
                         if($sql37){$data_general1=general_ledger::whereNotNull('date')->orderByDesc('id')->get();
                            $max= DB::table('general_ledgers')->max('date');
                            $min= DB::table('general_ledgers')->min('date');
                          return redirect()->route('admin.general_ledger.index')->with('message', 'Updated successfully');

                          }
                 }
               
               else{


                   $first1= date('Y-m-01');
                   $date1= date('d-m-Y');
                   $totalAmount=0-$amt;
                   $month11=date('m', strtotime($req->date));
                   $year11=date('Y', strtotime($req->date));
                   $first11="$year11-$month11-01";
                   $date11="$year11-$month11-30";

                  
                   $sql38= DB::table('result_ledgers')
                ->insert(
                  [
                 'category'=>$req->cat,
                 'type'=>$year_edit,
                 'start_date'=>$first11,
                 'end_date'=>$date11,
                 'debit_amount'=>$amt,
                 'credit_amount'=>0,
                 'total_amount'=> $totalAmount,
                     ]
                  );



               if($sql38){
                $data_general1=general_ledger::whereNotNull('date')->orderByDesc('id')->get();
        $max= DB::table('general_ledgers')->max('date');
        $min= DB::table('general_ledgers')->min('date');
              return redirect()->route('admin.general_ledger.index')->with('message', 'Updated successfully');
                  }
                }

               }
        


               ////////////////////////////////////



               elseif($year_edit!==$year && $_POST['cat']==$cat_org){


                $changed39=$result_cramount-$credit_org;
                $total39= $result_total - $credit_org;
        

                $sql39= DB::table('result_ledgers')
                ->where([
                ['category', 'LIKE', '%'.$cat_org.'%'],
                ['type', 'LIKE', '%'.$year.'%']
                ])
               ->update([ 'credit_amount' => $changed39,'total_amount'=>$total39],);


               $sql40=DB::table('result_ledgers')
               ->where([
                   ['category', 'LIKE', '%'.$req->cat.'%'],
                   ['type', 'LIKE', '%'.$year_edit.'%']
               ])
               ->get();


               if($sql40->count()==1){
                  foreach ($sql40 as $sql40) {

                    //  echo "we get";
                    $debit_40amount=$sql40->debit_amount;
                    $total=$sql40->total_amount;
                   $update_40amount=$debit_40amount+$amt;
                   $update_40tamount= $total-$amt;

                  }


                  $sql41= DB::table('result_ledgers')
                  ->where([
                  ['category', 'LIKE', '%'.$req->cat.'%'],
                  ['type', 'LIKE', '%'.$year_edit.'%']
                  ])
                 ->update([ 'debit_amount' =>$update_40amount,'total_amount'=>$update_40tamount],);



            if($sql41){
                $data_general1=general_ledger::whereNotNull('date')->orderByDesc('id')->get();
                $max= DB::table('general_ledgers')->max('date');
                $min= DB::table('general_ledgers')->min('date');
              return redirect()->route('admin.general_ledger.index')->with('message', 'Updated successfully');

             }
            }
            
            
            else{
                $first1= date('Y-m-01');
                $date1= date('d-m-Y');
                $totalAmount=0-$amt;
                $month12=date('m', strtotime($req->date));
                $year12=date('Y', strtotime($req->date));
                $first12="$year12-$month12-01";
                $date12="$year12-$month12-30";


                $sql42= DB::table('result_ledgers')
                ->insert(
                  [
                 'category'=>$req->cat,
                 'type'=>$year_edit,
                 'start_date'=>$first12,
                 'end_date'=>$date12,
                 'debit_amount'=>$amt,
                 'credit_amount'=>0,
                 'total_amount'=> $totalAmount,
                     ]
                  );

            
            
            if($sql42){
                $data_general1=general_ledger::whereNotNull('date')->orderByDesc('id')->get();
                $max= DB::table('general_ledgers')->max('date');
                $min= DB::table('general_ledgers')->min('date');
            return redirect()->route('admin.general_ledger.index')->with('message', 'Updated successfully');
            }

            }
        
            }


////////////////////////////////////////////////////////////////

   elseif($year_edit!==$year && $_POST['cat']!==$cat_org){



       $credit43=$result_cramount-$credit_org;
      $total43=$result_total - $credit_org; 

      $sql43= DB::table('result_ledgers')
      ->where([
      ['category', 'LIKE', '%'.$cat_org.'%'],
      ['type', 'LIKE', '%'.$year.'%']
      ])
     ->update([ 'credit_amount' =>$credit43,'total_amount'=>$total43],);

   

           $first1= date('Y-m-01');
           $date1= date('d-m-Y');


           $sql44=DB::table('result_ledgers')
           ->where([
               ['category', 'LIKE', '%'.$req->cat.'%'],
               ['type', 'LIKE', '%'.$year_edit.'%']
           ])
           ->get();


           if($sql44->count()==1){
              foreach ($sql44 as $sql44) {

                


         $debit_44amount=$sql44->debit_amount;
         $total44=$sql44->total_amount;
         $update_debit44=$debit_44amount+$amt;
         $update_44tamount= $total44 - $amt;

              }


              $sql45= DB::table('result_ledgers')
              ->where([
              ['category', 'LIKE', '%'.$req->cat.'%'],
              ['type', 'LIKE', '%'.$year_edit.'%']
              ])
             ->update([ 'debit_amount' =>$update_debit44,'total_amount'=>$update_44tamount],);


if($sql45){
    $data_general1=general_ledger::whereNotNull('date')->orderByDesc('id')->get();
    $max= DB::table('general_ledgers')->max('date');
    $min= DB::table('general_ledgers')->min('date');
  return redirect()->route('admin.general_ledger.index')->with('message', 'Updated successfully');

}
     }
else{

 $total_insert=$amt;
 $month13=date('m', strtotime($req->date));
 $year13=date('Y', strtotime($req->date));
 $first13="$year13-$month13-01";
 $date13="$year13-$month13-30";



 $sql46= DB::table('result_ledgers')
 ->insert(
   [
  'category'=>$req->cat,
  'type'=>$year_edit,
  'start_date'=>$first13,
  'end_date'=>$date13,
  'debit_amount'=>$amt,
  'credit_amount'=>0,
  'total_amount'=> $total_insert,
      ]
   );




       if($sql46){
        $data_general1=general_ledger::whereNotNull('date')->orderByDesc('id')->get();
        $max= DB::table('general_ledgers')->max('date');
        $min= DB::table('general_ledgers')->min('date');
      return redirect()->route('admin.general_ledger.index')->with('message', 'Updated successfully');

       }
}




   }


                
                    // ////////yahan if khatam ho ga////////////
                    }

             else{
                return view('general_ledger.edit')->with('message','failed to update');
             }


            
          // // elseif yahan khtamhga//////
         }



       ///////////////////////////////////////newfilter/////////////////////


       elseif($credit_org==!0 && $amn_type=='credit'){
        
        $sql= DB::table('general_ledgers')
        ->where('id', $id)
        ->update(['date' => $date,'day' => $day,'username'=>$username,'category'=>$req->cat,'detail'=>$req->detail,'credit' => $amt, 'update_id' => $req->sessionid, 'update_time' => $date5 ],);
        $update=DB::table('general_ledgers')->where('id', $id)->get();
        $update1=json_encode($update);
      
        // dd($update);
         if($sql){
        
          $notification= DB::table('notifications')
          ->insert(
          [
           'user_id'=> Auth::user()->id,
          'user_name'=> Auth::user()->name,
            'action'=>'update',
       'page_affected'=>'general ledger',
         'old_data'=> $update2,
         'new_data'=> $update1,
        'markasread'=> 'false',
           ]
         );
        


        if($year_edit==$year && $_POST['cat']==$cat_org){
            
          if($credit_org==$amt){
            $data_general1=general_ledger::whereNotNull('date')->orderByDesc('id')->get();
            $max= DB::table('general_ledgers')->max('date');
            $min= DB::table('general_ledgers')->min('date');
          return redirect()->route('admin.general_ledger.index')->with('message', 'Updated successfully');
          }



            $credit_change=$amt-$credit_org;
            $update8_amount=$result_cramount+$credit_change;
            $update8_total= $result_total+$credit_change;


            $sql47= DB::table('result_ledgers')
            ->where([
            ['category', 'LIKE', '%'.$cat_org.'%'],
            ['type', 'LIKE', '%'.$year_edit.'%']
            ])
           ->update([ 'credit_amount' =>$update8_amount,'total_amount'=>$update8_total],);






          if( $sql47){
            $data_general1=general_ledger::whereNotNull('date')->orderByDesc('id')->get();
            $max= DB::table('general_ledgers')->max('date');
            $min= DB::table('general_ledgers')->min('date');
          return redirect()->route('admin.general_ledger.index')->with('message', 'Updated successfully');

          }
    
         }



    /////////////////////////////////

    elseif($year_edit==$year && $_POST['cat']!==$cat_org){
           

            $sql48=DB::table('result_ledgers')
               ->where([
                ['category', 'LIKE', '%'.$req->cat.'%'],
                ['type', 'LIKE', '%'.$year_edit.'%']
             ])
               ->get();




       

                  if($sql48->count()==1){

                       foreach ($sql48 as $sql48) {

            
                          // echo "we get";
                          $credit_48amount=$sql48->credit_amount;
                          $total48=$sql48->total_amount;
                          $update_48amount=$credit_48amount + $amt;
                          $update_48tamouunt= $total48 + $amt;

                     }

                     $sql49= DB::table('result_ledgers')
                     ->where([
                     ['category', 'LIKE', '%'.$req->cat.'%'],
                     ['type', 'LIKE', '%'.$year_edit.'%']
                     ])
                    ->update([ 'credit_amount' =>$update_48amount,'total_amount'=>$update_48tamouunt],);




            
             if($sql49){
                     //   echo "updated in result";
                       $changed49_amount=$result_cramount - $credit_org;
                      $changed49_total= $result_total-$credit_org;

                      $sql50= DB::table('result_ledgers')
                      ->where([
                      ['category', 'LIKE', '%'.$cat_org.'%'],
                      ['type', 'LIKE', '%'.$year.'%']
                      ])
                     ->update([ 'credit_amount' =>$changed49_amount,'total_amount'=>$changed49_total],);


                  
                   if($sql50){
                    $data_general1=general_ledger::whereNotNull('date')->orderByDesc('id')->get();
                    $max= DB::table('general_ledgers')->max('date');
                    $min= DB::table('general_ledgers')->min('date');
                  return redirect()->route('admin.general_ledger.index')->with('message', 'Updated successfully');

                   }
                }


              }
     
            else{

                  $first1= date('Y-m-01');
                  $date1= date('d-m-Y');
                  $totalAmount51=$amt;
                  $month14=date('m', strtotime($_POST['date']));
                  $year14=date('Y', strtotime($_POST['date']));
                  $first14="$year14-$month14-01";
                  $date14="$year14-$month14-30";

                  $sql51= DB::table('result_ledgers')
                  ->insert(
                    [
                   'category'=>$req->cat,
                   'type'=>$year_edit,
                   'start_date'=>$first14,
                   'end_date'=>$date14,
                   'debit_amount'=>0,
                   'credit_amount'=>$amt,
                   'total_amount'=> $totalAmount51,
                       ]
                    );


 
        if($sql51){
            $changed51_amount=$result_cramount - $credit_org;
             $changed51_total= $result_total-$credit_org;


              $sql52= DB::table('result_ledgers')
              ->where([
             ['category', 'LIKE', '%'.$cat_org.'%'],
             ['type', 'LIKE', '%'.$year.'%']
             ])
            ->update([ 'credit_amount' =>$changed51_amount,'total_amount'=>$changed51_total],);

     
          if($sql52){
            $data_general1=general_ledger::whereNotNull('date')->orderByDesc('id')->get();
            $max= DB::table('general_ledgers')->max('date');
            $min= DB::table('general_ledgers')->min('date');
          return redirect()->route('admin.general_ledger.index')->with('message', 'Updated successfully');
     
           } 
       }
     }

 }




/////////////////////////
   if($year_edit!==$year && $_POST['cat']!==$cat_org){
     
                     $changed52_amount=$result_cramount-$credit_org;
                       $changed52_total=$result_total - $credit_org; 

                       $sql52= DB::table('result_ledgers')
                         ->where([
                        ['category', 'LIKE', '%'.$cat_org.'%'],
                        ['type', 'LIKE', '%'.$year.'%']
                      ])
                     ->update([ 'credit_amount' =>$changed52_amount,'total_amount'=>$changed52_total],);


                       $first1= date('Y-m-01');
                       $date1= date('d-m-Y');


                       $sql53=DB::table('result_ledgers')
                       ->where([
                        ['category', 'LIKE', '%'.$req->cat.'%'],
                        ['type', 'LIKE', '%'.$year_edit.'%']
                     ])
                       ->get();
        
        
        
        
               
        
                          if($sql53->count()==1){
        
                               foreach($sql53 as $sql53) {

                                $credit_48amount=$sql48->credit_amount;

                          $credit_53amount=$sql53->credit_amount;
                          $total53=$sql53->total_amount;
                          $update_53amount=$credit_53amount+$amt;
                          $update_53tamouunt= $total53+$amt;
                               }



                               $sql54= DB::table('result_ledgers')
                               ->where([
                              ['category', 'LIKE', '%'.$req->cat.'%'],
                              ['type', 'LIKE', '%'.$year_edit.'%']
                            ])
                           ->update([ 'credit_amount' =>$update_53amount,'total_amount'=>$update_53tamouunt],);
      
 
                    if($sql54){
                        $data_general1=general_ledger::whereNotNull('date')->orderByDesc('id')->get();
        $max= DB::table('general_ledgers')->max('date');
        $min= DB::table('general_ledgers')->min('date');
                      return redirect()->route('admin.general_ledger.index')->with('message', 'Updated successfully');
                    }
                }
      else{

               $month15=date('m', strtotime($_POST['date']));
               $year15=date('Y', strtotime($_POST['date']));
               $first15="$year15-$month15-01";
               $date15="$year15-$month15-30";


               $sql55= DB::table('result_ledgers')
               ->insert(
                 [
                'category'=>$req->cat,
                'type'=>$year_edit,
                'start_date'=>$first15,
                'end_date'=>$date15,
                'debit_amount'=>0,
                'credit_amount'=>$amt,
                'total_amount'=> $amt
                    ]
                 );



         if($sql55){
            $data_general1=general_ledger::whereNotNull('date')->orderByDesc('id')->get();
            $max= DB::table('general_ledgers')->max('date');
            $min= DB::table('general_ledgers')->min('date');
          return redirect()->route('admin.general_ledger.index')->with('message', 'Updated successfully');

           }
        }

       }



       ///////////////////////////////////////



       if($year_edit!==$year && $_POST['cat']==$cat_org){
    


        $sql56=DB::table('result_ledgers')
        ->where([
         ['category', 'LIKE', '%'.$req->cat.'%'],
         ['type', 'LIKE', '%'.$year_edit.'%']
      ])
        ->get();






           if($sql56->count()==1){

                foreach($sql56 as $sql56) {

                    
        $credit_56amount=$sql56->credit_amount;
        $total56=$sql56->total_amount;
        $update_56amount=$credit_56amount+$amt;
        $update_56tamouunt= $total56+$amt;

                }

                $sql57= DB::table('result_ledgers')
                ->where([
               ['category', 'LIKE', '%'.$req->cat.'%'],
               ['type', 'LIKE', '%'.$year_edit.'%']
             ])
            ->update([ 'credit_amount' =>$update_56amount,'total_amount'=>$update_56tamouunt],);




       
       if($sql57){
                   // echo "updated in result";
                   $changed57_amount=$result_cramount-$credit_org;
                  $changed57_total= $result_total-$credit_org;
    


                  $sql58= DB::table('result_ledgers')
                  ->where([
                 ['category', 'LIKE', '%'.$cat_org.'%'],
                 ['type', 'LIKE', '%'.$year.'%']
               ])
              ->update([ 'credit_amount' =>$changed57_amount,'total_amount'=>$changed57_total],);


    
              if($sql58){
                $data_general1=general_ledger::whereNotNull('date')->orderByDesc('id')->get();
                $max= DB::table('general_ledgers')->max('date');
                $min= DB::table('general_ledgers')->min('date');
              return redirect()->route('admin.general_ledger.index')->with('message', 'Updated successfully');

              }
        }
        }
    else
        {
        $first1= date('Y-m-01');
        $date1= date('d-m-Y');
        $totalAmount=$amt;
        $month16=date('m', strtotime($req->date));
        $year16=date('Y', strtotime($req->date));
        $first16="$year16-$month16-01";
        $date16="$year16-$month16-30";

        $sql59= DB::table('result_ledgers')
        ->insert(
          [
         'category'=>$req->cat,
         'type'=>$year_edit,
         'start_date'=>$first16,
         'end_date'=>$date16,
         'debit_amount'=>0,
         'credit_amount'=>$amt,
         'total_amount'=> $totalAmount

             ]
          );




    
          if($sql59){
                 $changed59_amount=$result_cramount-$credit_org;
                  $changed59_total= $result_total-$credit_org;
     

                  $sql60= DB::table('result_ledgers')
                  ->where([
                 ['category', 'LIKE', '%'.$cat_org.'%'],
                 ['type', 'LIKE', '%'.$year.'%']
               ])
              ->update([ 'credit_amount' =>$changed59_amount,'total_amount'=>$changed59_total],);


               if($sql60){
    
                $data_general1=general_ledger::whereNotNull('date')->orderByDesc('id')->get();
                $max= DB::table('general_ledgers')->max('date');
                $min= DB::table('general_ledgers')->min('date');
              return redirect()->route('admin.general_ledger.index')->with('message', 'Updated successfully');

                }
    }
    }
       
    
    }


    
// yahan if khatam hoga//////////
    }

    else{
        return view('general_ledger.edit')->with('message','failed to update');
   }


// yahan elseif khatam hoga//////////
       }



       else{


        return view('general_ledger.edit')->with('message','failed to update');


        }
      }else{

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

    // $categories = ['salaries', 'category2', 'pettycash']; // Replace with your array of categories

      
      $data_general1=general_ledger::whereNotNull('date') ->whereIn('category', $mutualValues)->orderByDesc('id')->get();
      $max= DB::table('general_ledgers')->max('date');
      $min= DB::table('general_ledgers')->min('date');

              return redirect()->route('admin.general_ledger.index')->with('message', 'You dont have access to edit this');

      // return view('general_ledger.index',['data_general'=> $data_general1,'category'=>$mutualValues,'max'=>$max,'min'=>$min])->with('message','failed to update');
      }


}


    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $req)
    {

        // $post->delete();
        // return redirect()->back()->withSuccess('Post deleted !!!');

        $del_id=$req->delete_id;
        /////////////////for result delete/////////
         $result_del1=DB::table('general_ledgers')->where('id', $del_id)->get();

         $old=json_encode($result_del1);

    if($result_del1->count()==1){
       foreach ($result_del1 as $result1) {


           $year= date('F,Y', strtotime($result1->date));

           $cat_result=$result1->category;
           // // global $cat_general,$year;
           $debit=$result1->debit;
           $credit=$result1->credit;

           if($debit==!0 ){
               $result_del2=DB::table('result_ledgers')
               ->where([
                   ['category', 'LIKE', '%'.$cat_result.'%'],
                   ['type', 'LIKE', '%'.$year.'%']
               ])
               ->get();

               if($result_del2->count()==1){
                   foreach ($result_del2 as $result2) {
                $updatedebit=$result2->debit_amount - $debit;
                $updatetotal=$result2->total_amount + $debit;

                $update_result= DB::table('result_ledgers')
                ->where('type', $year)
                ->where('category',$cat_result)
                ->update(['debit_amount' => $updatedebit,'total_amount' => $updatetotal],);


                   }}

           }

          if($credit==!0 ){
              $result_del2=DB::table('result_ledgers')
              ->where([
                  ['category', 'LIKE', '%'.$cat_result.'%'],
                  ['type', 'LIKE', '%'.$year.'%']
              ])
             ->get();

              if($result_del2->count()==1){
                  foreach ($result_del2 as $result2) {
               $updatecredit=$result2->credit_amount - $credit;
               $updatetotal=$result2->total_amount - $credit;

               $update_result= DB::table('result_ledgers')
               ->where('type', $year)
               ->where('category',$cat_result)
               ->update(['credit_amount' => $updatecredit,'total_amount' => $updatetotal],);
              

              }}

            }
       }}

       
      






///////////for general delete///////////
      
      DB::table('general_ledgers')->where('id', $del_id)->delete();

      $notification= DB::table('notifications')
      ->insert(
        [
       'user_id'=> Auth::user()->id,
       'user_name'=> Auth::user()->name,
       'action'=>'delete',
       'page_affected'=>'general ledger',
       'old_data'=> $old,
       'markasread'=> 'false',
           ]
        );

         $data_general1=general_ledger::all();
         $max= DB::table('general_ledgers')->max('date');
         $min= DB::table('general_ledgers')->min('date');
         return redirect()->back()->with('mesage','Entry deleted !!!');

    }
}