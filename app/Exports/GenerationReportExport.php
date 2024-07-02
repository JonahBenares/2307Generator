<?php

namespace App\Exports;

use App\Models\generations;
use App\Models\GenerationHead;
use App\Models\GenerationAmount;
use App\Models\Payees;
use App\Models\AmountUpdateLogs;
use App\Models\GenerationTotal;
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
use Maatwebsite\Excel\Concerns\WithCustomStartCell;
// use Maatwebsite\Excel\Concerns\WithDrawings;
use PhpOffice\PhpSpreadsheet\Worksheet\Drawing;
use Maatwebsite\Excel\Concerns\WithStrictNullComparison;

class GenerationReportExport implements FromQuery, WithMapping, ShouldAutoSize, WithHeadings, WithEvents, WithTitle, WithCustomStartCell, WithStrictNullComparison
{
    /**
    * @return \Illuminate\Support\Collection
    */
    protected $date_from;
    protected $date_to;
    protected $date_encoded;
    protected $payee;
    use Exportable;

    public function __construct($date_from,$date_to,$date_encoded,$payee) {
        $this->date_from = $date_from;
        $this->date_to = $date_to;
        $this->date_encoded = $date_encoded;
        $this->payee = $payee;
    }

    public function startCell(): string
    {
        return 'A1';
    }

    public function query()
    {
        $date_from=$this->date_from;
        $date_to=$this->date_to;
        $date_encoded=$this->date_encoded;
        $payee=$this->payee;

        $query=generations::query()->with(['generation_head'])->where('cancelled', '0');
        $query->whereHas('generation_head', function ($query) {
            $query->where('status', '1');
        });

        if ($date_encoded!='null') {
            $query->where('date_encoded', $date_encoded);
        }

        if ($date_from!='null' && $date_to!='null') {
            $query->whereBetween('date_from','date_to', [$date_from, $date_to]);
        }

        if ($payee!=0) {
            $query->where('payee_id', $payee);
        }

        return $query;
    }

    public function GetMonths($sStartDate, $sEndDate){  
        // Firstly, format the provided dates.  
        // This function works best with YYYY-MM-DD  
        // but other date formats will work thanks  
        // to strtotime().  
        $sStartDate = date("Y-m-d", strtotime($sStartDate));  
        $sEndDate = date("Y-m-d", strtotime($sEndDate));  
  
        // Start the variable off with the start date  
       $aDays[] = $sStartDate;  
  
       // Set a 'temp' variable, sCurrentDate, with  
       // the start date - before beginning the loop  
       $sCurrentDate = $sStartDate;  
  
       // While the current date is less than the end date  
       while($sCurrentDate < $sEndDate){  
         // Add a day to the current date  
         $sCurrentDate = date("Y-m-d", strtotime("+1 day", strtotime($sCurrentDate)));  
  
         // Add this new day to the aDays array  
         $aDays[] = date('m',strtotime($sCurrentDate));  
       }  
  
       // Once the loop has finished, return the  
       // array of days.  
       return $aDays;  
     }  

    public function map($gr): array
    {   

        $amount_list = GenerationAmount::where('generation_id',$gr->id)->groupBy('generation_id','quarter_month')->get();

        foreach($amount_list AS $al){
            $total_amount = GenerationAmount::where('generation_id','=',$gr->id)->where('quarter_month','=',$al->quarter_month)->where('cancelled','=','0')->sum('tax_base_amount');

            $ewt = $total_amount * $gr->atc_percentage;

            $date_updated_list = AmountUpdateLogs::where('generation_head_id','=',$al->generation_head_id)->where('generation_id','=',$al->generation_id)->where('quarter_month','=',$al->quarter_month)->get();
            $count_date_update=$date_updated_list->count();

            if($count_date_update == 0){
                $date_encoded = $gr->generation_head->date_encoded;
            }else{
                $date_encoded = AmountUpdateLogs::where('generation_head_id','=',$al->generation_head_id)
                ->where('generation_id','=',$al->generation_id)
                ->where('quarter_month','=',$al->quarter_month)
                ->orderBy('date_updated', 'DESC')->limit(1)->value('date_updated');
            }

        

        $first_quarter = array('01','02','03');
        $second_quarter = array('04','05','06');
        $third_quarter = array('07','08','09');
        $fourth_quarter = array('10','11','12');
        $quarter = $this->GetMonths($gr->date_from, $gr->date_to);
            if(array_intersect($quarter, $first_quarter)){
                $first_month = "January ".date('Y',strtotime($gr->date_to));
                $second_month = "February ".date('Y',strtotime($gr->date_to));
                $third_month = "March ".date('Y',strtotime($gr->date_to));
            }else if(array_intersect($quarter, $second_quarter)){
                $first_month = "April ".date('Y',strtotime($gr->date_to));
                $second_month = "May ".date('Y',strtotime($gr->date_to));
                $third_month = "June ".date('Y',strtotime($gr->date_to));
            } else if(array_intersect($quarter, $third_quarter)){
                $first_month = "July ".date('Y',strtotime($gr->date_to));
                $second_month = "August ".date('Y',strtotime($gr->date_to));
                $third_month = "September ".date('Y',strtotime($gr->date_to));
            } else if(array_intersect($quarter, $fourth_quarter)){
                $first_month = "October ".date('Y',strtotime($gr->date_to));
                $second_month = "November ".date('Y',strtotime($gr->date_to));
                $third_month = "December ".date('Y',strtotime($gr->date_to));
            }

        if($gr->quarter_month == 1){
            $quarter_month = $first_month;
        }else if($gr->quarter_month == 2){
            $quarter_month = $second_month;
        }else{
            $quarter_month = $third_month;
        }

    }

        return [
            date("Y-m-d", strtotime($date_encoded)),
            $quarter_month,
            $gr->date_from.' - '.$gr->date_to,
            $gr->payee_name,
            $gr->tin,
            $gr->tax_type,
            $gr->atc_code,
            number_format($total_amount,2),
            number_format($ewt,2),
        ];

    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function(AfterSheet $event) { 
                $event->sheet->getStyle('A1:I1')->applyFromArray([
                    'font'=> [
                        'bold'=>true
                    ]
                ]);

                $totalRows = $event->sheet->getHighestRow();
                for($i=1;$i<=$totalRows;$i++){
                    $event->sheet->getStyle('A'.$i.':I'.$i)->applyFromArray([
                        'borders' => [
                            'allBorders' => [
                                'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                            ]
                        ]
                        
                    ]);

                    $event->sheet->getStyle('A'.$i.':G'.$i)->applyFromArray([
                        'alignment' => [
                            'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                        ]
                        
                    ]);

                    $event->sheet->getStyle('H'.$i.':I'.$i)->applyFromArray([
                        'alignment' => [
                            'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT,
                        ]
                        
                    ]);
                }
                $event->sheet->getStyle('A1:I1')->getAlignment()->setHorizontal('center');
            }
            
        ];
    }

    public function headings(): array
    {
        return [
            'A1'=>'DATE ENCODED',
            'B1'=>'MONTH OF THE QUARTER',
            'C1'=>'PERIOD',
            'D1'=>'PAYEES NAME',
            'E1'=>'TIN',
            'F1'=>'BUSINESS TAX',
            'G1'=>'AT CODE',
            'H1'=>'TAX BASE',
            'I1'=>'EWT',
        ];
    }
    


    public function title(): string
    {
        return '2307 Generation Report';
    }
}
