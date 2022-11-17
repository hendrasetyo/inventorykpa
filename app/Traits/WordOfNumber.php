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
        $temp = wordOfNumber($number/10,0)." Puluh ". wordOfNumber($number % 10);
    } else if ($number < 200) {
        $temp = " Seratus " . wordOfNumber($number - 100);
    } else if ($number < 1000) {
        $temp = wordOfNumber($number/100,0) . " Ratus " . wordOfNumber($number % 100);
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

    function textKoma($data)
    {   
        for ($i=0; $i <count($data) ; $i++) { 
            if ($i>0) {
                if ($data[$i] == '1') {
                    $response[$i] = 'Satu';
                }else if ($data[$i] == '2') {
                    $response[$i] = 'Dua';
                }else if ($data[$i] == '3') {
                    $response[$i] = 'Tiga';
                }else if ($data[$i] == '4') {
                    $response[$i] = 'Empat';
                }else if ($data[$i] == '5') {
                    $response[$i] = 'Lima';
                }else if ($data[$i] == '6') {
                    $response[$i] = 'Enam';
                }else if ($data[$i] == '7') {
                    $response[$i] = 'Tujuh';
                }else if ($data[$i] == '8') {
                    $response[$i] = 'Delapan';
                }else if ($data[$i] == '9') {
                    $response[$i] = 'Sembilan';
                }else if ($data[$i] == '0') {
                    $response[$i] = 'Nol';
                }
            }
        }

        return $response;
        
    }

?>