<?php
function number_format_str($number)
{
    return strrev(implode('.', str_split(strrev($number), 3)));
}

function generateCode($id, $char = "DH"){
    date_default_timezone_set("Asia/Ho_Chi_Minh");
    $today = date('Y-m-d');
    $code = $char . date('d') . date('m') . date('y') . $id;
    return $code;
}
