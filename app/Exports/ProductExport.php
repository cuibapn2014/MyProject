<?php

namespace App\Exports;

use App\Models\Ingredient;
use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;

class ProductExport implements
    FromQuery,
    WithHeadings,
    WithMapping,
    ShouldAutoSize,
    WithStyles,
    WithEvents,
    WithColumnFormatting,
    WithTitle
{
    private $index = 0;
    private $ingredient;

    public function __construct($ingredient)
    {
        $this->ingredient = $ingredient;
    }
    /**
     * @return \Illuminate\Support\Collection
     */
    public function query()
    {
        //
        return $this->ingredient;
    }

    public function headings(): array
    {
        return [
            '#',
            'Mã thành phẩm',
            'Tên thành phẩm',
            'Đơn vị tính',
            'Công đoạn',
            'Tồn kho',
            'Tồn thực tế',
            'Giá bán',
            'Ghi chú'
        ];
    }

    /**
     * @return string
     */
    public function title(): string
    {
        return 'BÁO CÁO THỐNG KÊ THÀNH PHẨM ' . Carbon::now()->format('d/m/Y');
    }

    public function map($ingredient): array
    {
        return [
            ++$this->index,
            $ingredient->code,
            $ingredient->Ten,
            $ingredient->unit_cal->name,
            $ingredient->stage_product->name,
            $ingredient->amount,
            $ingredient->used_amount,
            $ingredient->GiaThanh,
            $ingredient->GhiChu
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

    public function columnFormats(): array
    {
        return [
            'F' => NumberFormat::FORMAT_NUMBER_0,
            'G' => NumberFormat::FORMAT_NUMBER_0,
            'H' => NumberFormat::FORMAT_CURRENCY_VI_SIMPLE,
        ];
    }

    public function registerEvents(): array
    {
        $finishRow = $this->query()->count() + 1;

        return [
            AfterSheet::class    => function (AfterSheet $event) use ($finishRow) {

                $event->sheet->getDelegate()->getStyle('A1:I1')
                    ->getFill()
                    ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
                    ->getStartColor()
                    ->setARGB('DD4B39');

                $event->sheet->getDelegate()->getStyle('A1:I1')
                    ->getFont()
                    ->getColor()
                    ->setARGB('FFFFFF');

                $event->sheet->getStyle('A1:I' . $finishRow)->applyFromArray([
                    'borders' => [
                        'allBorders' => [
                            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                            'color' => ['argb' => '000000'],
                        ],
                    ],
                ]);
            },
        ];
    }
}
