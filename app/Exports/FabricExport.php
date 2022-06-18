<?php

namespace App\Exports;

use App\Models\Fabric;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Maatwebsite\Excel\Concerns\WithEvents;

class FabricExport implements FromQuery, WithHeadings, WithMapping, ShouldAutoSize, WithStyles, WithEvents
{
    /**
     * @return \Illuminate\Support\Collection
     */
    public function query()
    {
        //
        $fabric = Fabric::query();
        return $fabric;
    }

    public function headings(): array
    {
        return [
            '#',
            'Tên loại vải',
            'Màu sắc',
            'Tính chất',
            'Giá tiền',
            'Địa chỉ',
            'Số điện thoại',
            'Ghi chú'
        ];
    }

    public function map($fabric): array
    {
        return [
            $fabric->id,
            $fabric->Ten,
            $fabric->MauSac,
            $fabric->TinhChat,
            $fabric->Gia,
            $fabric->DiaChi,
            $fabric->SoDienThoai,
            $fabric->GhiChu
        ];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            // Style the first row as bold text.
            1    => ['font' => ['size' => 12,]],

            // Styling a specific cell by coordinate.
            // 'B2' => ['font' => ['italic' => true]],

            // Styling an entire column.
            // 'C'  => ['font' => ['size' => 16]],
        ];
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class    => function (AfterSheet $event) {

                $event->sheet->getDelegate()->getStyle('A1:F6')
                    ->getFill()
                    ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
                    ->getStartColor()
                    ->setARGB('DD4B39');
            },
        ];
    }
}
