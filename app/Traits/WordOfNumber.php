<?php 
namespace App\Traits;

function wordOfNumber($number)
{
    $number = abs($number);
    $huruf = array("", "Satu", "Dua", "Tiga", "Empat", "Lima", "Enam", "Tujuh", "Delapan", "Sembilan", "Sepuluh", "Sebelas");
    $temp = "";
    if ($number < 12) {
        $temp = " ". $huruf[$number];

        
    } else if ($number <20) {
        $temp = wordOfNumber($number - 10). " Belas ";
    } else if ($number < 100) {
        $temp = wordOfNumber($number/10)." Puluh ". wordOfNumber($number % 10);
    } else if ($number < 200) {
        $temp = " Seratus " . wordOfNumber($number - 100);
    } else if ($number < 1000) {
        $temp = wordOfNumber($number/100) . " Ratus " . wordOfNumber($number % 100);
    } else if ($number < 2000) {
        $temp = " Seribu " . wordOfNumber($number - 1000);
    } else if ($number < 1000000) {
        $temp = wordOfNumber($number/1000) . " Ribu " . wordOfNumber($number % 1000);
    } else if ($number < 1000000000) {
        $temp = wordOfNumber($number/1000000) . " Juta " . wordOfNumber($number % 1000000);
    } else if ($number < 1000000000000) {
        $temp = wordOfNumber($number/1000000000) . " Milyar " . wordOfNumber(fmod($number,1000000000));
    } else if ($number < 1000000000000000) {
        $temp = wordOfNumber($number/1000000000000) . " Trilyun " . wordOfNumber(fmod($number,1000000000000));
    }

    $word = trim($temp);
    return $word;
}

?>