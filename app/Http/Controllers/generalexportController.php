<?php



namespace App\Http\Controllers;
use App\Models\general;
use App\Exports\generalExport;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Http\Request;

class generalexportController extends Controller
{

    

   
    public function export(Request $request) 
    {
        $startDate = $request->input('from_date1');
    $endDate = $request->input('to_date1');
    $category = $request->input('cat1');
    return Excel::download(new generalExport($startDate, $endDate, $category), 'general.xlsx');
        // return Excel::download(new generalExport, 'general.csv');
    }
}