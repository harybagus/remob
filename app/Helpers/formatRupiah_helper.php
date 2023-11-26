<?php

function formatRupiah($price)
{
    $rupiah = "Rp" . number_format($price, 0, ",", ".");
    return $rupiah;
}
