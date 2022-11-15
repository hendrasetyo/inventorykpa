
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    {{-- <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" /> --}}

    <style type="text/css">
        .tabel {
            border-collapse: collapse;
            border-style: double;
        }

        .tabel td,
        th,
        tr {
            /* border: 1px  double black; */
            border-style: double;
        }

        @media print {
            .tabpage {
                page-break-after: always
            }
        }
    </style>
</head>

<body style="font-family: sans-serif; ">
  <table class="tabel" width="100%" style="font-size:90%;margin-top:100px;">
        <tr>
            <td width="30%" style="text-align: center;">
                <div style="transform: rotate(270deg);">
                   <h2 style="margin-top: 5px; margin-bottom: 10px;">PT KARYA PUTRA ANDALAN</h2>
                   <h5 style="margin-top: 0px; margin-bottom: 5px;">Ruko Purimas - Rungkut Madya Jl. Raya I gusti Ngurah
                    Rai Kav. A1. No. 11-12
                    Surabaya</h5>
                   <h5 style="margin-top: 0px;margin-bottom: 5px;">NPWP : 03.113.119.6-615.000</h5>
                </div>
            </td>
            <td width="70%" style="padding-left:10px">

                <div style="margin-bottom: 20px " >
                   <table style="margin-top:5px;">
                        <tr >
                            <td width="70%" style="padding-left : 10px">
                                <h5>Kwitansi No. {{$faktur}}</h5> <br>
                            </td>
                        </tr>
                   </table>
                </div>  
                <div style="margin-bottom: -20px ">
                    <table width="100%" style="margin-top:5px;">
                        <tr>
                            <td width="20%"  style="border: 1px double white">
                                <h5>Sudah Terima Dari </h5>
                            </td>
                            <td  width="1%" style="border: 1px double white">
                                <h5>:</h5>
                            </td>
                            <td width="78%" style="border: 1px double white">
                                <h5>{{$customer}}.</h5>
                            </td>
                           
                        </tr>

                    </table>
                </div > 
                <div style="margin-bottom: -20px " >
                    <table width="100%" style="margin-top:5px;">
                        <tr>
                            <td width="20%"  style="border: 1px double white">
                                <h5>Yang Sejumlah</h5>
                            </td>
                            <td  width="1%" style="border: 1px double white">
                                <h5>:</h5>
                            </td>
                            <td width="78%" style="border: 1px double white">
                                <h5> <i>{{$text}}</i></h5>
                            </td>
                        </tr>

                    </table>
                </div> 
                <div  style="margin-bottom: 50px">
                    <table width="100%" style="margin-top:5px;">
                        <tr>
                            <td width="20%"  style="border: 1px double white">
                                <h5>Untuk Pembayaran</h5>
                            </td>
                            <td  width="1%" style="border: 1px double white">
                                <h5>:</h5>
                            </td>
                            <td width="78%" style="border: 1px double white">
                                <h5>Atas Faktur No. {{$faktur}} , Sebagaimana Terlampir  : </h5>
                            </td>
                           
                        </tr>

                    </table>
                </div> 
                <div  style="margin-bottom: 10px">
                    <table width="100%" style="margin-top:5px;">
                        <tr>
                            <td width="40%"  style="border-left: 1px double white;border-right : 1px double white">
                                <table width="100%" style="margin-top:5px;">
                                    <tr>
                                        <td width="40%" style="border:1px white">
                                            <h5> Terbilang Rp.</h5> 
                                        </td>
                                        <td style="text-align: right;padding-right:12px">
                                            <h3>{{  number_format($grandtotal, 2, ',', '.')}}</h3>
                                        </td>
                                    </tr>
                                </table>
                                
                            </td>
                            <td width="30%" style="border: 1px double white">

                            </td>
                            <td width="30%" style=' text-align:center; vertical-align:top;border: 1px double white'>Surabaya, 
            
                                <br /><br /> <br /><br /> <br /> <br />
                                <u>AHMAD MUHTAROM</u> <br />
                                Direktur
                            </td>
                        </tr>

                    </table>

                </div> 
                                
            </td>
        </tr>
       

</table>


</body>

</html>