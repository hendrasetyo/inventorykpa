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

<body style="font-family: sans-serif;">
    @for($i = 1; $i <= $totalPage; $i++) <table width=" 100%" style="margin-top: 0px; border-collapse:collapse">
        <tr>
            <td colspan="4" style=" border-bottom: 1px solid black;">FAKTUR PENJUALAN</td>
            <td colspan="2" style=" border-bottom: 1px solid black; text-align:right">No. Faktur :
                {{ $fakturpenjualan->no_kpa }}</td>
        </tr>
        <tr>
            <td colspan="6" style="text-align: center; border-bottom: 1px solid black;">
                <h1 style="margin-top: 5px; margin-bottom: 10px;">PT KARYA PUTRA ANDALAN</h1>
                <h5 style="margin-top: 0px; margin-bottom: 5px;">Ruko Purimas - Rungkut Madya Jl. Raya I gusti Ngurah
                    Rai Kav. A1. No. 11-12
                    Surabaya</h5>
                <h5 style="margin-top: 0px;margin-bottom: 5px;">NPWP : 03.113.119.6-615.000</h5>
            </td>

        </tr>
        <tr>
            <td colspan="6" style="border-bottom: 1px solid black;">
                <table border="0" width="100%">
                    <tr>
                        <td style="font-size: 80%;" colspan="3">PEMBELI BKP</td>
                    </tr>
                    <tr>
                        <td style="font-size: 75%; width:10%">Nama</td>
                        <td style="font-size: 75%; width:5%">:</td>
                        <td style="font-size: 75%;">{{ $fakturpenjualan->customers->nama }}</td>
                    </tr>
                    <tr>
                        <td style="font-size: 75%;width:10%">Alamat</td>
                        <td style="font-size: 75%; width:5%">:</td>
                        <td style="font-size: 75%;">{{ $fakturpenjualan->customers->alamat }}, Blok {{
                            $fakturpenjualan->customers->blok
                            }}, No. {{ $fakturpenjualan->customers->nomor
                            }}, {{ $fakturpenjualan->customers->namakota->name
                            }}</td>
                    </tr>
                    <tr>
                        <td style="font-size: 75%;width:10%">NPWP</td>
                        <td style="font-size: 75%; width:5%"> :</td>
                        <td style="font-size: 75%;">{{ $fakturpenjualan->customers->npwp }}</td>
                    </tr>
                    <tr>
                        <td style="font-size: 75%;width:10%">SO Customer</td>
                        <td style="font-size: 75%; width:5%"> :</td>
                        <td style="font-size: 75%;">{{ $fakturpenjualan->SO->no_so }}</td>
                    </tr>
                </table>
            </td>
        </tr>
        <tr>
            <td colspan="6" style="vertical-align: top; ">
                <div class="isi" style="height: 400px;">
                    <table border="0" class="xyz" style="width:100%; ">
                        <tr>
                            <td colspan="6">
                                <hr style="margin-bottom: 0px; margin-top: 0px; border-width: 1px 0px 0px;">
                            </td>
                        </tr>
                        <tr style="">
                            <td style="font-size: 75%; border:none; width:10%;">KWANTUM</td>
                            <td style="font-size: 75%; border:none;">NAMA BARANG</td>
                            <td style="font-size: 75%; border:none; width:10%;text-align:center">HARGA</td>
                            <td style="font-size: 75%; border:none; width:15%;text-align:center">SUBTOTAL</td>
                            <td style="font-size: 75%; border:none; width:10%;text-align:center">DISKON</td>
                            <td style=" font-size: 75%; border:none; width:15%;text-align:center">JUMLAH</td>
                        </tr>
                        <tr>
                            <td colspan="6">
                                <hr style="margin-bottom: 0px; margin-top: 0px; border-width: 0.3px 0px 0px;">
                            </td>
                        </tr>

                        @php
                        $n=1;
                        @endphp
                        @foreach($fakturpenjualandetails as $a)
                        @if($n > (($i-1)*$perBaris) && $n <= ($i)*$perBaris) <tr class="">
                            <td style="font-size: 60%; ">{{ $a->qty }} {{ $a->satuan }}</td>
                            <td style="font-size: 60%; ">{{ $a->products->nama }}</td>
                            <td style="font-size: 60%; text-align:right">{{ number_format($a->hargajual, 2, ',', '.')
                                }}</td>
                            <td style="font-size: 60%; text-align:right">{{ number_format($a->subtotal, 2, ',', '.')
                                }}</td>
                            <td style="font-size: 60%; text-align:right">{{ number_format($a->total_diskon, 2, ',',
                                '.') }}</td>
                            <td style="font-size: 60%; text-align:right">{{ number_format($a->total, 2, ',',
                                '.') }}</td>


        </tr>

        @endif
        @php
        $n++;
        @endphp
        @endforeach
        </table>
        </div>
        </td>
        </tr>

        </table>
        <br /><br /><br />


        <hr style="margin-bottom: 0px; margin-top: 0px; border-width: 1px 0px 0px;">
        <table width="100%">
            <tr>
                @if ($i==$totalPage)
                <td style="text-align: right">
                    <table width="100%">
                        <tr>
                            <td style='font-size: 70%; width: 75%; line-height:90%'><b>Total Jumlah</b></td>
                            <td style='font-size: 70%; width: 5%;'><b>: Rp.</b></td>
                            <td style='font-size: 70%; line-height:90%; text-align:right'><b>
                                    {{ number_format($fakturpenjualan->subtotal, 2, ',', '.') }}
                                </b></td>
                        </tr>
                        <tr>
                            <td style='font-size: 70%; width: 75%; line-height:90%'><b>Potongan Harga</b></td>
                            <td style='font-size: 70%; width: 5%;'><b>: Rp.</b></td>
                            <td style='font-size: 70%; line-height:90%; text-align:right'><b>
                                    {{ number_format($fakturpenjualan->total_diskon_header, 2, ',', '.') }}
                                </b></td>
                        </tr>
                        <tr>
                            <td style='font-size: 70%; width: 75%; line-height:90%'><b>Dasar Pengenaan Pajak</b></td>
                            <td style='font-size: 70%; width: 5%;'><b>: Rp.</b></td>
                            <td style='font-size: 70%; line-height:90%; text-align:right'><b>
                                    {{ number_format($fakturpenjualan->total, 2, ',', '.') }}
                                </b></td>
                        </tr>
                        <tr>
                            <td style='font-size: 70%; width: 75%;'><b>PPN</b></td>
                            <td style='font-size: 70%; width: 5%;'><b>: Rp.</b></td>
                            <td style='font-size: 70%; text-align:right'><b>
                                    {{ number_format($fakturpenjualan->ppn, 2, ',', '.') }}
                                </b></td>
                        </tr>
                        <tr>
                            <td style='font-size: 70%; width: 75%;'><b>Biaya Pengiriman</b></td>
                            <td style='font-size: 70%; width: 5%;'><b>: Rp.</b></td>
                            <td style='font-size: 70%; text-align:right'><b>
                                    {{ number_format($fakturpenjualan->ongkir, 2, ',', '.') }}
                                </b></td>
                        </tr>
                        <tr>
                            <td style='font-size: 70%; width: 25%;'><b>Jumlah Yang Harus Dibayar</b></td>
                            <td style='font-size: 70%; width: 5%;'><b>: Rp.</b></td>
                            <td style='font-size: 70%; text-align:right'><b>
                                    {{ number_format($fakturpenjualan->grandtotal, 2, ',', '.') }}
                                </b></td>
                        </tr>
                    </table>


                </td>
                @else
                <td style="text-align: right">
                    <table width="100%">
                        {{-- <tr>
                            <td style='font-size: 70%; width: 75%; line-height:90%'><b>Total Jumlah</b></td>
                            <td style='font-size: 70%; width: 5%;'><b>: Rp.</b></td>
                            <td style='font-size: 70%; line-height:90%; text-align:right'><b>
                                    -
                                </b></td>
                        </tr>
                        <tr>
                            <td style='font-size: 70%; width: 75%; line-height:90%'><b>Potongan Harga</b></td>
                            <td style='font-size: 70%; width: 5%;'><b>: Rp.</b></td>
                            <td style='font-size: 70%; line-height:90%; text-align:right'><b>
                                    -
                                </b></td>
                        </tr>
                        <tr>
                            <td style='font-size: 70%; width: 75%; line-height:90%'><b>Dasar Pengenaan Pajak</b></td>
                            <td style='font-size: 70%; width: 5%;'><b>: Rp.</b></td>
                            <td style='font-size: 70%; line-height:90%; text-align:right'><b>
                                   -
                                </b></td>
                        </tr>
                        <tr>
                            <td style='font-size: 70%; width: 75%;'><b>PPN</b></td>
                            <td style='font-size: 70%; width: 5%;'><b>: Rp.</b></td>
                            <td style='font-size: 70%; text-align:right'><b>
                                   -
                                </b></td>
                        </tr>
                        <tr>
                            <td style='font-size: 70%; width: 75%;'><b>Biaya Pengiriman</b></td>
                            <td style='font-size: 70%; width: 5%;'><b>: Rp.</b></td>
                            <td style='font-size: 70%; text-align:right'><b>
                                 -
                                </b></td>
                        </tr>
                        <tr>
                            <td style='font-size: 70%; width: 25%;'><b>Jumlah Yang Harus Dibayar</b></td>
                            <td style='font-size: 70%; width: 5%;'><b>: Rp.</b></td>
                            <td style='font-size: 70%; text-align:right'><b>
                                -
                                </b></td>
                        </tr> --}}

                        <tr>
                            <td style='font-size: 70%; width: 25%;text-align:center'><i>( HALAMAN SELANJUTNYA )</i></td>
                        </tr>
                    </table>


                </td>
                @endif
              

            </tr>
        </table>
        <hr style="margin-bottom: 0px; margin-top: 0px; border-width: 1px 0px 0px;">
        <br /><br />
        <table width="100%">
            <tr>
                <td style='font-size: 70%; width: 15%; line-height:90%; vertical-align:top'>PENERIMA,

                    <br /><br /> <br /><br /> <br /> <br />
                    <u>(...............................)</u> <br />
                    <br />
                    <i>Hal. :
                        {{ $i }}
                        {{ $totalPage }}<br />
                        User : {{ Auth::user()->name }}</i>
                </td>
                <td style='font-size: 70%; width: 55%; line-height:90%; vertical-align:top'><b>KETERANGAN : <br />{{
                        $fakturpenjualan->keterangan }}</b>
                    <br /> <br /><br /> <br /> <br /><br /><br /> <br /><br /> <br /> <br />


                </td>

                <td style='font-size: 70%; text-align:center; vertical-align:top'>Surabaya, {{
                    $fakturpenjualan->tanggal->format("d
                    F Y")
                    }}

                    <br /><br /> <br /><br /> <br /> <br />
                    <u>AHMAD MUHTAROM</u> <br />
                    Direktur
                </td>
            </tr>
        </table>



        @if($totalPage <> $i)
            <div style="page-break-after: always;"></div>
            @endif



            @endfor

</body>

</html>