<?php

namespace App\Exports;

use App\Models\Production;
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

class ProductionExport implements
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
    private $production;

    public function __construct($production)
    {
        $this->production = $production;
    }
    /**
     * @return \Illuminate\Support\Collection
     */
    public function query()
    {
        //
        return $this->production;
    }

    public function headings(): array
    {
        return [
            '#',
            'Mã sản xuất',
            'Lệnh sản xuất',
            'Thành phẩm',
            'Loại',
            'Đơn vị tính',
            'Công đoạn',
            'Số lượng yêu cầu',
            'Đã hoàn thành',
            'Còn lại',
            'Mức ưu tiên',
            'Ngày tạo lệnh'
        ];
    }

    /**
     * @return string
     */
    public function title(): string
    {
        return 'BÁO CÁO THỐNG KÊ LỆNH SẢN XUẤT ' . Carbon::now()->format('d/m/Y');
    }

    public function map($production): array
    {
        return [
            ++$this->index,
            $production->production_request->code,
            $production->code,
            $production->product->Ten,
            $production->product->ingredient_type->name,
            $production->product->unit_cal->name,
            $production->product->stage_product->name,
            $production->require_total . '.0',
            $production->produceds != null ? $production->produceds->sum('amount') . '.0' : 0 . '.0', 
            $production->require_total - $production->produceds->sum('amount') . '.0',
            $this->getPriority($production->priority),
            Carbon::parse($production->created_at)->timezone('Asia/Ho_Chi_Minh')->format('d-m-Y'),
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
            'H' => NumberFormat::FORMAT_NUMBER_0,
            'I' => NumberFormat::FORMAT_NUMBER_0,
            'J' => NumberFormat::FORMAT_NUMBER_0,
            'L' => NumberFormat::FORMAT_DATE_DDMMYYYY,
        ];
    }

    public function registerEvents(): array
    {
        $finishRow = $this->query()->count() + 1;

        return [
            AfterSheet::class    => function (AfterSheet $event) use ($finishRow) {

                $event->sheet->getDelegate()->getStyle('A1:L1')
                    ->getFill()
                    ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
                    ->getStartColor()
                    ->setARGB('DD4B39');

                $event->sheet->getDelegate()->getStyle('A1:L1')
                    ->getFont()
                    ->getColor()
                    ->setARGB('FFFFFF');

                $event->sheet->getStyle('A1:L' . $finishRow)->applyFromArray([
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

    public function getPriority($priority)
    {
        switch ($priority) {
            case 0:
                return "Thấp";
                break;
            case 1:
                return "Bình thường";
                break;
            case 2:
                return "Cao";
                break;
            default:
                return "Không xác định";
        }
    }
}
