<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />

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
    @for ($i = 1; $i <= $totalPage; $i++)
        <table width=" 100%" style="margin-top: 0px; border-collapse:collapse">
            <tr style="width: 75%">
                <td colspan="6" style="text-align: center; border-bottom: 1px solid black;">
                    <h4 style="margin-top: 5px; margin-bottom: 7px;">Laporan Perjalanan Dinas (LPD)</h4>
                    <h6 style="margin-top: 2px; margin-bottom: 10px;text-align:center">Lengkapi semua kolom kuning di
                        bawah ini,
                        dengan melampirkan semua kuitansi asli
                        Perlu diketahui bahwa satu formulir LPD hanya digunakan untuk satu kali perjalanan dinas.</h6>
                </td>

            </tr>
            <tr>
                <td width="40%" style="vertical-align: top;">
                    <table>
                        <tr style="padding:0px;">
                            <td style="padding:0px;font-size: 70%; ">Nama</td>
                            <td style="padding:0px;font-size: 70%; ">:</td>
                            <td style="padding:0px;font-size: 70%; ">
                                {{ $karyawan->nama }}
                            </td>
                        </tr>

                        <tr style="padding:0px;">
                            <td style="padding:0px;font-size: 70%; ">Jabatan</td>
                            <td style="padding:0px;font-size: 70%; ">:</td>
                            <td style="padding:0px;font-size: 70%; ">
                                {{ $karyawan->jabatan->nama }}
                            </td>
                        </tr>

                        <tr style="padding:0px;">
                            <td style="padding:0px;font-size: 70%; " colspan="3"></td>

                        </tr>
                        <tr style="padding:0px;">
                            <td style="padding:0px;font-size: 70%; " colspan="3"></td>

                        </tr>

                    </table>

                </td>

                <td width="10%" style="font-size: 75%; vertical-align: top; text-align: center;">
                    <center><b></b></center>
                    <center><b>

                        </b></center>
                </td>
                <td width="50%" style="vertical-align: top; text-align: left; font-family: sans-serif">

                    {{-- <table>                   
                    <tr style="padding:0px;">
                        <td style="padding:0px;font-size: 70%; ">Tujuan Perjalanan Dinas</td>
                        <td style="padding:0px;font-size: 70%; ">:</td>
                        <td style="padding:0px;font-size: 70%; ">
                            {{$maintenance->pemohon}}
                        </td>
                    </tr>
                    <tr style="padding:0px;">
                        <td style="padding:0px;font-size: 70%; ">BAGIAN</td>
                        <td style="padding:0px;font-size: 70%; ">:</td>
                        <td style="padding:0px;font-size: 70%; ">
                            {{$maintenance->bagian}}
                        </td>
                    </tr>
                    <tr style="padding:0px;">
                        <td style="padding:0px;font-size: 70%; ">TELPON</td>
                        <td style="padding:0px;font-size: 70%; ">:</td>
                        <td style="padding:0px;font-size: 70%; ">
                            {{$maintenance->telepon}}
                        </td>
                    </tr>
                    <tr style="padding:0px;">
                        <td style="padding:0px;font-size: 70%; ">TANGGAL</td>
                        <td style="padding:0px;font-size: 70%; ">:</td>
                        <td style="padding:0px;font-size: 70%; ">
                            {{\Carbon\Carbon::parse($maintenance->tanggal)->format('d F Y')}}
                        </td>   
                    </tr>
                </table> --}}

                </td>
            </tr>

            <hr style="margin-bottom: 0px; margin-top: 0px; border-width: 1px 0px 0px;">

            <tr>
                <td colspan="6" style="vertical-align: top; ">
                    <span style="font-size: 80%;margin-left:5px"><strong>Biaya Akomodasi</strong></span>
                    <div class="isi" style="height: 400px;">
                        <table border="0" class="xyz" style="width:100%; ">


                            <tr>
                                <td colspan="8">
                                    <hr style="margin-bottom: 0px; margin-top: 0px; border-width: 1px 0px 0px;">
                                </td>
                            </tr>
                            <tr style="">
                                <td style="font-size: 65%; border:none; width:20%">Perjalanan</td>
                                <td style="font-size: 65%; border:none; width:10%;text-align:left">Hotel</td>
                                <td style="font-size: 65%; border:none; width:10%;text-align:left">Transportasi</td>
                                <td style="font-size: 65%; border:none; width:10%;text-align:left">Makan</td>
                                <td style="font-size: 65%; border:none; width:10%;text-align:left">Laundry</td>
                                <td style="font-size: 65%; border:none; width:10%;text-align:left">Entertaint</td>
                                <td style="font-size: 65%; border:none; width:10%;text-align:left">Lainya</td>
                                <td style="font-size: 65%; border:none; width:10%;text-align:left">Total Biaya</td>
                            </tr>
                            <tr>
                                <td colspan="8">
                                    <hr style="margin-bottom: 0px; margin-top: 0px; border-width: 0.3px 0px 0px;">
                                </td>
                            </tr>

                            @php
                                $n = 1;
                                $j = 1;
                            @endphp
                            @foreach ($biayadinas->biayaakomodasi as $item)
                                <tr class="" style="vertical-align:top">
                                    <td
                                        style="font-size: 72%;font-family:'Segoe UI', Tahoma, Geneva, Verdana, sans-serif">
                                        {{ ucfirst($item->perjalanandinas->asal_mana) . ' - ' . ucfirst($item->perjalanandinas->tujuan) }}.
                                    </td>
                                    <td style="font-size: 70%;text-align: left">
                                        {{ number_format($item->biaya_hotel, 0, ',', '.') }}</td>
                                    <td style="font-size: 70%;text-align: left">
                                        {{ number_format($item->biaya_transportasi, 0, ',', '.') }}</td>
                                    <td style="font-size: 70%;text-align:left;">
                                        {{ number_format($item->biaya_makan, 0, ',', '.') }}</td>
                                    <td style="font-size: 70%;text-align:left;">
                                        {{ number_format($item->biaya_laundry, 0, ',', '.') }}</td>
                                    <td style="font-size: 70%;text-align: left">
                                        {{ number_format($item->biaya_entertainment, 0, ',', '.') }}.</td>
                                    <td style="font-size: 70%;text-align:left;">
                                        {{ number_format($item->biaya_lainya, 0, ',', '.') }}</td>
                                    <td style="font-size: 70%;text-align:left;">
                                        {{ number_format($item->total_biaya, 0, ',', '.') }}</td>
                                </tr>
                                @php
                                    $n++;
                                    $j++;
                                @endphp
                            @endforeach
                        </table>
                    </div>
                </td>

            </tr>

            <tr>
                <td colspan="6" style="vertical-align: top; ">
                    <span style="font-size: 80%;margin-left:5px"><strong>Kas Bon</strong></span>
                    <div class="isi" style="height: 150px;">
                        <table border="0" class="xyz" style="width:100%; ">

                            <tr>
                                <td colspan="2">
                                    <hr style="margin-bottom: 0px; margin-top: 0px; border-width: 1px 0px 0px;">
                                </td>
                            </tr>
                            <tr style="">
                                <td style="font-size: 65%; border:none; width:20%">Tanggal</td>
                                <td style="font-size: 65%; border:none; width:20%;text-align:left">Nominal</td>
                            </tr>
                            <tr>
                                <td colspan="2">
                                    <hr style="margin-bottom: 0px; margin-top: 0px; border-width: 0.3px 0px 0px;">
                                </td>
                            </tr>
                            @php
                                $n = 1;
                                $j = 1;
                            @endphp
                            @foreach ($biayadinas->cashadvance as $item)
                                <tr class="" style="vertical-align:top">
                                    <td style="font-size: 70%;text-align: left">
                                        {{ \Carbon\Carbon::parse($item->tanggal)->format('d/m/Y') }}.</td>
                                    <td style="font-size: 70%; text-align:left;">
                                        {{ number_format($item->nominal, 0, ',', '.') }}</td>
                                </tr>
                                @php
                                    $n++;
                                    $j++;
                                @endphp
                            @endforeach
                        </table>
                    </div>
                </td>
            </tr>
            <tr>
                <td colspan="7">
                    <hr style="margin-bottom: 0px; margin-top: 0px; border-width: 1px 0px 0px;">
                </td>
            </tr>

        </table>
        </div>
        </td>
        </tr>
        <br>



        
        <table width="100%">
            <tr>
                <td style="text-align: right;page-break-after:always;">
                    <table width="100%">
                        <tr>
                            <td style='font-size: 80%; width: 75%; line-height:90%'><b>Total Biaya Akomodasi</b></td>
                            <td style='font-size: 80%; width: 5%;'><b>: Rp.</b></td>
                            <td style='font-size: 80%; line-height:90%; text-align:right'><b>
                                    {{ number_format($akomodasi, 0, ',', '.') }}
                                </b></td>
                        </tr>
                        <tr>
                            <td style='font-size: 80%; width: 75%; line-height:90%'><b>Total Kas Bon</b></td>
                            <td style='font-size: 80%; width: 5%;'><b>: Rp.</b></td>
                            <td style='font-size: 80%; line-height:90%; text-align:right'><b>
                                    {{ number_format($cashadvance, 0, ',', '.') }}
                                </b></td>
                        </tr>
                        <tr>
                            <td style='font-size: 80%; width: 75%; line-height:90%'><b>Total Dibayar Perusahaan / Karyawan</b></td>
                            <td style='font-size: 80%; width: 5%;'><b>: Rp.</b></td>
                            <td style='font-size: 80%; line-height:90%; text-align:right'><b>
                                    {{ number_format($total, 0, ',', '.') }}
                                </b></td>
                        </tr>
                    </table>

                </td>
            </tr>

            <tr>
                
                <td colspan="6" style="vertical-align: top; margin-top:30px">
                    <div class="isi" style="height: 50px;">
                        <p style="font-size: 70%"> <b>KETERANGAN :</b> <br>{{ $biayadinas->keterangan }} </p>
                        <p style="font-size: 70%"> </p>
                    </div>
                </td>                
            </tr>
        </table>
        <hr style="margin-bottom: 0px; margin-top: 0px; border-width: 1px 0px 0px;">


        <table width="100%" style="margin-top: 50px">
            <tr>
                <td style='font-size: 70%; width: 20%; line-height:90%; vertical-align:top;text-align: center'>PEMBERI
                    TUGAS, <br>

                    <br /><br /> <br /><br /> <br /> <br />
                    <u>(...............................)</u> <br />
                    <br />
                </td>
                <td style='font-size: 70%; width: 20%; line-height:90%; vertical-align:top'><b><br />
                        <br /> <br /><br /> <br /> <br /><br /><br /> <br /><br /> <br /> <br />
                </td>

                <td style='font-size: 70%; width: 20%; line-height:90%; vertical-align:top ;text-align: center'> <span>
                        Mengetahui <br> <i>(GENERAL MANAGER)</i></span>

                    <br /><br /> <br /><br /> <br /> <br />
                    <u>(...............................)</u> <br />
                    <br />
                </td>
                <td style='font-size: 70%; width: 20%; line-height:90%; vertical-align:top'><b><br />
                        <br /> <br /><br /> <br /> <br /><br /><br /> <br /><br /> <br /> <br />
                </td>

                <td style='font-size: 70%; width: 20%; line-height:90%; vertical-align:top;text-align: center'>
                    Menyetujui <br> <i>(DIREKTUR)</i>

                    <br /><br /> <br /><br /> <br /> <br />
                    <u>(...............................)</u> <br />
                    <br />
                </td>
            </tr>
        </table>

        <hr style="margin-bottom: 0px; margin-top: 0px; border-width: 1px 0px 0px;">



        @if ($totalPage != $i)
            <div style="page-break-after: always;"></div>
        @endif



    @endfor

</body>

</html>
