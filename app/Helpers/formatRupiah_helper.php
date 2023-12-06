<?php

/**
 * Membuat function formatRupiah untuk menampilkan harga dengan format rupiah.
 */
function formatRupiah($price)
{
    $rupiah = "Rp" . number_format($price, 0, ",", ".");
    return $rupiah;
}
