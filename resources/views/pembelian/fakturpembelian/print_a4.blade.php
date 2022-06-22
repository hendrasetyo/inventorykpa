<!DOCTYPE html>
<html>

<head>
    <style type="text/css">
        .tabel {
            border-collapse: collapse;
        }

        .tabel td,
        th,
        tr {
            border: 1px solid black;
        }

        @media print {
            .tabpage {
                page-break-after: always
            }
        }
    </style>
</head>

<body>
    @for($i = 1; $i <= $totalPage; $i++) <table border="0" width="100%" style="margin-top:-20px;">
        <tr>
            <td width="20%" style="font-size: 70%; vertical-align: top;">
                Customer A<br />
                Jl. Testing ABC No. 17, Surabaya;
                <br />
                Tlp : 02919291291<br />
            </td>
            <td width="25%" style="font-size: 75%; vertical-align: top; text-align: center;">
                <center><b>INVOICE PEMBELIAN</b></center>
                <center><b>No.
                        INVNO0191991199191
                    </b></center>
            </td>
            <td width="20%" style="font-size: 70%; vertical-align: top; text-align: left;">
                <table>
                    <tr style="padding:0px;">
                        <td style="padding:0px;">Tanggal</td>
                        <td style="padding:0px;">:</td>
                        <td style="padding:0px;">
                            20 April 2021
                        </td>
                    </tr>
                    <tr style="padding:0px;">
                        <td style="padding:0px;">Vendor</td>
                        <td style="padding:0px;">:</td>
                        <td style="padding:0px;">
                            PT VENDOR ABC
                        </td>
                    </tr>
                </table>


            </td>
        </tr>
        </table>

        <div style="height:  400px;">
            <table width="100%">
                <tr>
                    <td colspan="10">
                        <hr style="margin-bottom: 0px; margin-top: 0px; border-width: 0.3px 0px 0px;">
                    </td>
                </tr>
                <tr style="">
                    <td style="font-size: 75%; ">NO</td>
                    <td style="font-size: 75%; ">NAMA BARANG</td>
                    <td style="font-size: 75%; ">satuan</td>
                    <td style="font-size: 75%; ">QTY</td>
                    <td style="font-size: 75%; ">HARGA</td>
                    <td style="font-size: 75%; ">DISC(%)</td>
                    <td style="font-size: 75%; ">DISC(Rp.)</td>
                    <td style="font-size: 75%; ">SUBTOTAL</td>
                    <td style="font-size: 75%; ">TOTAL DISC</td>
                    <td style="font-size: 75%; ">TOTAL</td>
                </tr>
                <tr>
                    <td colspan="10">
                        <hr style="margin-bottom: 0px; margin-top: 0px; border-width: 0.3px 0px 0px;">
                    </td>
                </tr>

            </table>
        </div>
        <hr style="margin-bottom: 0px; margin-top: 0px; border-width: 0.3px 0px 0px;">
        <table width="100%">
            <tr>
                <td style="width: 65%;" valign="top">
                    <table class="tabel">

                    </table>
                    <table width="100%">
                        <tr>
                            <td style="font-size: 70%; vertical-align: bottom; text-align: left;">
                                HAL :
                                {{ $i }}
                                {{ $totalPage }}<br />
                                USR :

                            </td>
                        </tr>
                    </table>
                </td>
                <td>
                    <table width="100%">
                        <tr>
                            <td style='font-size: 70%; width: 35%; line-height:90%'><b>Grand Total</b></td>
                            <td width="2%"><b>:</b></td>
                            <td style='font-size: 70%; line-height:90%'><b>Rp.
                                    5.000.000
                                </b></td>
                        </tr>

                        <tr>
                            <td style='font-size: 70%; width: 25%;'><b>PPN</b></td>
                            <td width="2%"><b>:</b></td>
                            <td style='font-size: 70%;'><b>Rp.
                                    600
                                </b></td>
                        </tr>
                        <tr>
                            <td style='font-size: 70%; width: 25%;'><b>Total Bayar</b></td>
                            <td width="2%"><b>:</b></td>
                            <td style='font-size: 70%;'><b>Rp.
                                    500
                                </b></td>
                        </tr>
                    </table>

                </td>

            </tr>
        </table>


        @if($totalPage <> $i)
            <div style="page-break-after: always;"></div>
            @endif



            @endfor

</body>

</html>