<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Attendance;
use App\Models\employee;
use Illuminate\Support\Facades\DB;
use Auth;
class AttendanceController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    function __construct()
    {
        $this->middleware('role_or_permission:Post access|Post create|Post edit|Post delete', ['only' => ['index','show']]);
        $this->middleware('role_or_permission:Post create', ['only' => ['create','store']]);
        $this->middleware('role_or_permission:Post edit', ['only' => ['edit','update']]);
        $this->middleware('role_or_permission:Post delete', ['only' => ['destroy']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
       return view('attendance.index');
    }


    public function showData()
    {
        $data_general1=employee::all();
        $attendance= DB::table('attendances')
     //    ->orderBy('date', 'asc')
        ->get();
        if($attendance){
         return response()->json([
             'message' => "Data Found",
             "code"    => 200,
             "data"  => $attendance
         ]);
     } else  {
         return response()->json([
             'message' => "Internal Server Error",
             "code"    => 500
         ]);
     }
    }


    function updateattendance(Request $req){

        $old=DB::table('attendances')->where('id', $req->id)->get();
        $update1=json_encode($old);

        $result = DB::table('attendances')
        ->where('id', $req->id)
        ->update([
            'employee_id' => $req->e_id,
            'name'     => $req->name,
            'status'   => $req->status,
            'reason'   => $req->reason,
            'work_sum'   => $req->summary,
        ]);

        $update=DB::table('attendances')->where('id', $req->id)->get();
        $update2=json_encode($update);
      
        $notification= DB::table('notifications')
        ->insert(
        [
         'user_id'=> Auth::user()->id,
        'user_name'=> Auth::user()->name,
          'action'=>'update',
     'page_affected'=>'attendance',
       'old_data'=> $update1,
       'new_data'=> $update2,
      'markasread'=> 'false',
         ]
       );

        if($result) {
            return response()->json([
                'message' => "Data Found",
                "code"    => 200,
                "data" =>$result
            ]);
        }  else  {
            return response()->json([
                'message' => "Internal Server Error",
                "code"    => 500
            ]);
        }

        }




        function filterattendance(Request $req){

            if(Auth::guest()){
                return redirect('login');
            }

            $data_general1= DB::table('attendances')
            ->where('date','=',$req->date)
            ->get();

             $date=$req->date;
            if($data_general1->count()==0){

                $data_general1=employee::all();
                 
                foreach ($data_general1 as $data_general){
                
                    $affected= DB::table('attendances')
                ->insert(
                [
               'employee_id'=>$data_general->employee_id,
               'name'=>$data_general->name,
               'status'=>'absent',
               'reason'=>'none',
               'work_sum'=>'none',
               'date'=>$date,
                   ]
                );
                    
                   
    
                }


                $data_general1= DB::table('attendances')
                ->where('date','=',$req->date)
                ->get();


                $attendance= DB::table('attendances')
                ->get();
                return view('attendance.index1',['data_general'=> $data_general1,'attendance'=>$attendance,'date'=>$date]);

            }
            $attendance= DB::table('attendances')
            ->get();
            return view('attendance.index1',['data_general'=> $data_general1,'attendance'=>$attendance,'date'=>$date]);

            }


            function action(Request $request)
            {
                if($request->ajax())
                {
                    if($request->action == 'edit')
                    {
                        $data = array(

                            'name'	=>	$request->name,
                            'status'=>	$request->status,
                            'reason' =>	$request->reason,
                            'work_sum' =>	$request->summary,
                           
        
                        );

                        $old=DB::table('attendances')->where('id', $request->id)->get();
                        $update1=json_encode($old);
        
                        DB::table('attendances')
                            ->where('id', $request->id)
                            ->update($data);


                            $update=DB::table('attendances')->where('id', $request->id)->get();
                            $update2=json_encode($update);
                          
                            
                            
                            
                         $notification= DB::table('notifications')
                              ->insert(
                              [
                               'user_id'=> Auth::user()->id,
                              'user_name'=> Auth::user()->name,
                                'action'=>'update',
                           'page_affected'=>'attendance',
                             'old_data'=> $update1,
                             'new_data'=> $update2,
                            'markasread'=> 'false',
                               ]
                             );


                    }
                    if($request->action == 'delete')
                    {
                        $update=DB::table('attendances')->where('id', $request->id)->get();
                        $update1=json_encode($update);

                        DB::table('attendances')
                            ->where('id', $request->id)
                            ->delete();

                            $notification= DB::table('notifications')
                              ->insert(
                              [
                               'user_id'=> Auth::user()->id,
                              'user_name'=> Auth::user()->name,
                                'action'=>'delete',
                           'page_affected'=>'attendance',
                             'old_data'=> $update1,
                             
                            'markasread'=> 'false',
                               ]
                             );
                    }
                    return response()->json($request);
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
    public function store(Request $request)
    {
        $data= $request->all();
        $data['user_id'] = Auth::user()->id;
        $Post = Post::create($data);
        return redirect()->back()->withSuccess('Post created !!!');
    }

    
  
    

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Post $post)
    {

        $post->update($request->all());
        return redirect()->back()->withSuccess('Post updated !!!');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Post $post)
    {

        $post->delete();
        return redirect()->back()->withSuccess('Post deleted !!!');
        
    }
}
