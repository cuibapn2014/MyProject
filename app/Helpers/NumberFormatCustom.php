<?php
namespace App\Helpers;

use PhpOffice\PhpSpreadsheet\Style\NumberFormat;

class NumberFormatCustom extends NumberFormat{
    const FORMAT_CURRENCY_VI_SIMPLE = '#,###';
}