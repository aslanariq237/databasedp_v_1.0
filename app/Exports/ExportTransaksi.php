<?php

namespace App\Exports;

use App\Models\Transaksi;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\FromCollection;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class ExportTransaksi implements fromCollection, WithHeadings, WithMapping, WithStyles
{
    private $count = 0;
    protected $start;
    protected $end;
    /**
    * @return \Illuminate\Support\Collection
    */       

    public function __construct($start, $end)
    {
        $this->start = $start;
        $this->end = $end;
    }
    
    public function collection()
    {
        // return Transaksi::with(['tandater', 'barnis.barang', 'customer'])->get();        
        return Transaksi::query()
            ->whereBetween('created_at', [$this->start, $this->end])
            ->with(['tandater', 'barnis.barang', 'customer'])
            ->orderBy('created_at', 'DESC')
            ->get();        
    }
    
    public function headings():array{
        return[
            'No',
            'Id Transaksi',
            'No Tandater',
            'No Invoice',
            'Cluster',
            'Customer',
            'Barang',
            'Serial Number',
            'Sub Total',
            'PPN',
            'Total',
            'Payment',
            'date'
        ];
    }          

    public function map($trans):array
    {
        $rows = [];

        foreach ($trans->barnis as $key => $data){
            $rows[] = [
                ++$this->count,
                $trans->id_transaksi,
                $trans->tandater ? $trans->id_tandater : '-',
                $trans->no_invoice,
                $trans->tandater ? $trans->tandater->customer : '-',
                $trans->customer ? $trans->customer->nama_toko : $trans->id_customer,            
                $data->barang ? $data->barang->nama_barang : "Barang Tidak Ada",            
                $data->barang ? $data->barang->SN : "Barang Tidak Ada",
                $trans->total_biaya,
                $trans->ppn,
                $trans->total_biaya + $trans->ppn,
                $trans->status_pay != 0 ? "Sudah Bayar" : "Belum Bayar",
                $trans->created_at,
            ];
        }

        return $rows;        
    } 
    
    public function styles(Worksheet $sheet)
    {
        $highestRow = $sheet->getHighestRow(); // Get the last row number
        $highestColumn = $sheet->getHighestColumn(); // Get the last column letter

        return [            
            1 => [
                'font' => ['bold' => true],
                'fill' => [
                    'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                    'startColor' => ['rgb' => 'e67075'],
                ],
                'alignment' => ['horizontal' => 'center'],
            ],

            // Apply border to all data cells
            "A1:{$highestColumn}{$highestRow}" => [
                'borders' => [
                    'allBorders' => [
                        'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                        'color' => ['rgb' => '000000'], // Black border
                    ],
                ],
            ],
        ];
    }
}
