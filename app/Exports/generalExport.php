<?php

namespace App\Exports;

use App\Models\general;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithCustomCsvSettings;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromQuery;

class generalExport implements FromCollection, WithCustomCsvSettings, WithHeadings
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
        return ["id", "date","day","category","detail","debit","credit"];
    }

    /**
    * @return \Illuminate\Support\Collection
    */
    
    public function collection()
    {
        
        return general::query()
            ->whereBetween('date', [$this->startDate, $this->endDate])
            ->where('category', $this->category)
            ->select("id", "date", "day", "category", "detail", "debit", "credit")
            ->get();
            
    }
    
}