<?php

namespace App\Exports;

use App\Models\Order;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;
use Carbon\Carbon;
use PhpOffice\PhpSpreadsheet\Style\Color;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;

class OrderExport implements FromQuery, 
WithHeadings, WithMapping, ShouldAutoSize, WithStyles, WithEvents, WithColumnFormatting
{
    // use Exportable;
    private $index = 0;
    /**
     * @return \Illuminate\Support\Collection
     */
    public function query()
    {
        //
        $order = Order::query();
        return $order;
    }

    public function headings(): array
    {
        return [
            '#',
            'Tên khách hàng',
            'Số điện thoại',
            'Địa chỉ',      
            'Tổng thanh toán',
            'Đã thanh toán',
            'Nợ công',
            'Ngày tạo đơn',
            'Ngày giao hàng',
            'Ngày cập nhật',
            'Người tạo đơn',
            'Yêu cầu khách hàng',
            'Trạng thái'
        ];
    }

    public function map($order): array
    {
        return [
            ++$this->index,
            $order->customer->name,
            $order->customer->phone_number,
            $order->customer->address,
            $order->total ?? 0,
            $order->paid ?? 0,
            $order->total - $order->paid ?? 0,
            Carbon::parse($order->created_at)->timezone('Asia/Ho_Chi_Minh')->format('d-m-Y H:i:s'),
            Carbon::parse($order->NgayTraDon)->timezone('Asia/Ho_Chi_Minh')->format('d-m-Y'),
            Carbon::parse($order->updated_at)->timezone('Asia/Ho_Chi_Minh')->format('d-m-Y H:i:s'),
            $order->user->name,
            $order->note,
            $this->getStatus($order->status)
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
                $event->sheet->getDelegate()->getStyle('A1:M1')
                ->getFill()
                ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
                ->getStartColor()
                ->setARGB('DD4B39');

                $event->sheet->getDelegate()->getStyle('A1:M1')
                ->getFont()
                ->getColor()
                ->setARGB('FFFFFF');

                $event->sheet->getStyle('A1:M25')->applyFromArray([
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

    public function columnFormats(): array
    {
        return [
            'E' => NumberFormat::FORMAT_CURRENCY_VI_SIMPLE,
            'F' => NumberFormat::FORMAT_CURRENCY_VI_SIMPLE,
            'G' => NumberFormat::FORMAT_CURRENCY_VI_SIMPLE,
            'H' => NumberFormat::FORMAT_DATE_DDMMYYYY,
            'I' => NumberFormat::FORMAT_DATE_DDMMYYYY,
            'J' => NumberFormat::FORMAT_DATE_DDMMYYYY
        ];
    }

    public function getStatus($status)
    {
        switch($status)
        {
            case -1: return "Không duyệt";break;
            case 1: return "Chờ duyệt";break;
            case 2: return "Đã duyệt";break;
            case 3: return "Hoàn tất";break;
            case 4: return "Đã hủy";break;
            default: return "Không xác định";
        }
    }
}
