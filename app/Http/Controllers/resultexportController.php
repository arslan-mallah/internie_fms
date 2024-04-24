<?php
namespace App\Http\Controllers;
use App\Models\result;
use App\Exports\resultExport;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Http\Request;

class resultexportController extends Controller
{

   
    public function export(Request $request) 
    {
        $startDate = $request->input('from_date1');
    $endDate = $request->input('to_date1');
    $category = $request->input('cat1');
    return Excel::download(new resultExport($startDate, $endDate, $category), 'result.xlsx');
        // return Excel::download(new generalExport, 'general.csv');
    }
}