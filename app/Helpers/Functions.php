<?php
function number_format_str($number)
{
    return strrev(implode('.', str_split(strrev($number), 3)));
}
