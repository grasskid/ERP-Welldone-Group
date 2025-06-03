<?php

use Endroid\QrCode\Builder\Builder;
use Endroid\QrCode\Encoding\Encoding;
use Endroid\QrCode\ErrorCorrectionLevel\ErrorCorrectionLevelHigh;

function generateQrToFile($text, $filename)
{
    $path = FCPATH . 'qr_service/' . $filename;

    Builder::create()
        ->data($text)
        ->encoding(new Encoding('UTF-8'))
        ->errorCorrectionLevel(new ErrorCorrectionLevelHigh())
        ->size(300)
        ->margin(10)
        ->build()
        ->saveToFile($path);

    return base_url('qr_service/' . $filename);
}
