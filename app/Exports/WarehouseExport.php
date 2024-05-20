<?php

namespace App\Exports;
use App\Models\Warehouse;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;
use Maatwebsite\Excel\Concerns\WithTitle;

class WarehouseExport implements FromQuery, WithMapping, ShouldAutoSize, WithHeadings, WithEvents, WithTitle
{
    /**
    * @return \Illuminate\Support\Collection
    */
    use Exportable;

    public function query()
    {
        return Warehouse::query()->orderBy('id', 'ASC');
    }
    
    public function map($warehouse): array
    {
        return [
            $warehouse->id,
            $warehouse->warehouse_name,
        ];
    }

    public function headings(): array
    {
        return [
            'A1'=>'Warehouse ID',
            'B1'=>'Warehouse Name',
        ];
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function(AfterSheet $event) { 
                $event->sheet->getStyle('A1:B1')->applyFromArray([
                    'font'=> [
                        'bold'=>true
                    ]
                ]);
                $event->sheet->getStyle('A')->getAlignment()->setHorizontal('center');
            }
        ];
    }

    public function title(): string
    {
        return 'Warehouse';
    }
}
