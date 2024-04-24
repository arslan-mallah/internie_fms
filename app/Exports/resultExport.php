<?php

namespace App\Exports;

use App\Models\result;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithCustomCsvSettings;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromQuery;

class resultExport implements FromCollection, WithCustomCsvSettings, WithHeadings
{

    public function __construct($startDate, $endDate, $category)
    {
        $this->startDate = $startDate;
        $this->endDate = $endDate;
        $this->category = $category;
    }
    
    public function getCsvSettings(): array
    {
        return [
            'delimiter' => ','
        ];
    }

    public function headings(): array
    {
        return ["id", "Category","Type","Start date","End date","Debit amount","Credit amount","Total amount"];
    }

    /**
    * @return \Illuminate\Support\Collection
    */
    
    public function collection()
    {
        
        return result::query()
            ->whereBetween('start_date', [$this->startDate, $this->endDate])
            ->where('category', $this->category)
            ->select("id", "category", "type", "start_date", "end_date", "debit_amount", "credit_amount","total_amount")
            ->get();
            
    }
    
}