<?php

function formatRupiah($number)
{
    return number_format($number, 0, '.', ',');
}
