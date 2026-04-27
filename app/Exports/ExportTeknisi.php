<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use App\Models\Barang;

class ExportTeknisi implements FromCollection, WithHeadings, WithMapping
{
    private $count = 0;
    /**
    * @return \Illuminate\Support\Collection
    */
    public function __construct($startDate, $endDate)
    {
        $this->startDate = $startDate;
        $this->endDate = $endDate;        
    }

    public function collection()
    {        
        return Barang::with(['tandater', 'teknisi', 'customer'])
            ->whereBetween('detailbarang.created_at', [$this->startDate, $this->endDate])
            ->get();    
    }

    public function headings():array{
        return [
            'No',
            'ID',
            'Nama Customer',
            'Nama Teknisi',
            'Nama Barang',
            'Serial Number',
            'Garansi',
            'Tanggal'
        ];
    }

    public function map($row):array{
        return [   
            ++$this->count,
            $row->id_tandater,
            $row->customer ? $row->customer->nama_toko : $row->id_customer,
            $row->teknisi ? $row->teknisi->nama_teknisi : " -", 
            $row->nama_barang,
            $row->SN ? $row->SN : $row->sn,
            $row->garansi == 0 ? "Tidak Garansi" : "Garansi",
            $row->created_at->format('d M y'),
        ];
    }
}
