<?php

namespace App\Exports;

use App\Models\Order;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Maatwebsite\Excel\Concerns\WithEvents;
use Carbon\Carbon;

class OrderExport implements FromQuery, WithHeadings, WithMapping, ShouldAutoSize, WithStyles, WithEvents
{
    // use Exportable;

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
            'Tiền cọc',
            'Nợ công',
            'Đã thanh toán',
            'Tổng tiền',
            'Ngày tạo đơn',
            'Ngày trả đơn',
            'Ngày cập nhật',
            'Người tạo đơn',
            'Yêu cầu khách hàng'
        ];
    }

    public function map($order): array
    {
        return [
            $order->id,
            $order->TenKhachHang,
            $order->SoDienThoai,
            $order->DiaChi,
            $order->detail->TienCoc,
            $order->TongTien - $order->detail->ThanhToanBS - $order->detail->TienCoc,
            $order->detail->ThanhToanBS,
            $order->TongTien,
            Carbon::parse($order->created_at)->timezone('Asia/Ho_Chi_Minh')->format('d-m-Y H:i:s'),
            Carbon::parse( $order->NgayTraDon)->timezone('Asia/Ho_Chi_Minh')->format('d-m-Y'),
            Carbon::parse($order->updated_at)->timezone('Asia/Ho_Chi_Minh')->format('d-m-Y H:i:s'),
            $order->user->name,
            $order->detail->GhiChu
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
