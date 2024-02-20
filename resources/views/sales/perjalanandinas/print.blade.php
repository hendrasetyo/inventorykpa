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
    @for($i = 1; $i <= $totalPage; $i++) <table width=" 100%" style="margin-top: 0px; border-collapse:collapse">
        <tr style="width: 75%">
            <td colspan="6" style="text-align: center; border-bottom: 1px solid black;">
                <h4 style="margin-top: 5px; margin-bottom: 7px;">Permohonan Perjalanan Dinas (PPD)</h4>
                <h6 style="margin-top: 2px; margin-bottom: 10px;text-align:center">Lengkapi semua kolom kuning di bawah ini dan dapatkan persetujuan yang diperlukan.
                    Tujuan Perjalanan Dinas
                    Tempat Asal dan Tujuan
                    Dari
                    Perlu diketahui bahwa satu PPD hanya digunakan untuk satu kali perjalanan dinas.</h6>                
            </td>

        </tr>
        <tr>
            <td width="40%" style="vertical-align: top;">
                <table >                   
                    <tr style="padding:0px;">
                        <td style="padding:0px;font-size: 70%; ">Nama</td>
                        <td style="padding:0px;font-size: 70%; ">:</td>
                        <td style="padding:0px;font-size: 70%; ">
                            {{$karyawan->nama}}
                        </td>
                    </tr>
                    <tr style="padding:0px;">
                        <td style="padding:0px;font-size: 70%; ">Jabatan</td>
                        <td style="padding:0px;font-size: 70%; ">:</td>
                        <td style="padding:0px;font-size: 70%; ">
                            {{$karyawan->jabatan->nama}}
                        </td>
                    </tr>

                    <tr style="padding:0px;">
                        <td style="padding:0px;font-size: 70%; ">Tujuan Perjalanan Dinas</td>
                        <td style="padding:0px;font-size: 70%; ">:</td>
                        <td style="padding:0px;font-size: 70%; ">
                            {{$dinas->tujuan_dinas}}
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
                <span style="font-size: 80%;margin-left:5px"><strong>Transportasi & Hotel</strong></span>
                <div class="isi" style="height: 320px;">
                    <table border="0" class="xyz" style="width:100%; ">
                       
                        
                        <tr>
                            <td colspan="7">
                                <hr style="margin-bottom: 0px; margin-top: 0px; border-width: 1px 0px 0px;">
                            </td>
                        </tr>
                        <tr style="">
                            <td style="font-size: 65%; border:none; width:5%">Tanggal</td>
                            <td style="font-size: 65%; border:none; width:20%;text-align:left">Perjalanan</td>
                            <td style="font-size: 65%; border:none; width:7%;text-align:left">Waktu</td>
                            <td style="font-size: 65%; border:none; width:15%;text-align:left">Jenis Transportasi</td>                            
                            <td style="font-size: 65%; border:none; width:15%;text-align:left">Penyedia Transportasi</td>                            
                            <td style="font-size: 65%; border:none; width:8%;text-align:left">Waktu Berangkat</td>
                            <td style="font-size: 65%; border:none; width:15%;text-align:left">Nama Hotel</td>                            
                        </tr>
                        <tr>
                            <td colspan="7">
                                <hr style="margin-bottom: 0px; margin-top: 0px; border-width: 0.3px 0px 0px;">
                            </td>
                        </tr>

                        @php
                        $n=1;
                        $j=1;
                        @endphp
                        @foreach ($dinas->perjalanandinas as $item)
                            <tr class="" style="vertical-align:top">
                                <td style="font-size: 62%;text-align: left"> {{\Carbon\Carbon::parse($item->tanggal)->format('d/m/Y')}}.</td>
                                <td style="font-size: 67%;font-family:'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;">{{ $item->asal_mana . '-' . $item->tujuan }}</td>
                                <td style="font-size: 62%;text-align: left"> {{\Carbon\Carbon::parse($item->waktu_mulai)->format('H:i') . ' - ' . \Carbon\Carbon::parse($item->selesai)->format('H:i')}}.</td>                                
                                <td style="font-size: 62%; text-align:left;">{{$item->jenis_transportasi}}</td>
                                <td style="font-size: 62%; text-align:left;">{{$item->penyedia_transportasi}}</td> 
                                <td style="font-size: 62%;text-align: left"> {{\Carbon\Carbon::parse($item->waktu_berangkat)->format('H:i') }}.</td>                                
                                <td style="font-size: 62%; text-align:left;">{{$item->nama_hotel}}</td>                              
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
                <span style="font-size: 80%;margin-left:5px"><strong>Entertainment</strong></span>
                <div class="isi" style="height: 320px;">
                    <table border="0" class="xyz" style="width:100%; ">                        
                       
                        <tr>
                            <td colspan="7">
                                <hr style="margin-bottom: 0px; margin-top: 0px; border-width: 1px 0px 0px;">
                            </td>
                        </tr>
                        <tr style="">
                            <td style="font-size: 65%; border:none; width:20%">Perusahaan / Institusi</td>
                            <td style="font-size: 65%; border:none; width:20%;text-align:left">Nama</td>
                            <td style="font-size: 65%; border:none; width:20%;text-align:left">Jenis Entertainment</td>
                            <td style="font-size: 65%; border:none; width:40%;text-align:left">Tujuan</td>                            
                        </tr>
                        <tr>
                            <td colspan="7">
                                <hr style="margin-bottom: 0px; margin-top: 0px; border-width: 0.3px 0px 0px;">
                            </td>
                        </tr>

                        @php
                        $n=1;
                        $j=1;
                        @endphp
                        @foreach ($dinas->entertaindinas as $item)
                            <tr class="" style="vertical-align:top">
                                <td style="font-size: 62%;text-align: left">{{ $item->nama_perusahaan}}.</td>
                                <td style="font-size: 67%;font-family:'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;">{{ $item->nama }}</td>
                                <td style="font-size: 62%; text-align:left;">{{$item->jenis_entertainment}}</td>
                                <td style="font-size: 62%; text-align:left;">{{$item->tujuan_entertainment}}</td>                              
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

        <tr>
            <td colspan="6" style="vertical-align: top; ">
                <div class="isi" style="height: 50px;">
                    <p style="font-size: 70%">KETERANGAN : {{$dinas->keterangan}} </p><br>
                    <p style="font-size: 70%"> </p>
                </div> 
            </td>    
        </tr>
       

        {{-- @endif
        @php
        $n++;
        $j++;
        @endphp
        @endforeach --}}
        </table>
        </div>
        </td>
        </tr>

        </table>
        <br /><br /><br />


        
        <table width="100%">
            <tr>
                @if ($i==$totalPage)               
                @else
                <td style="text-align: right;page-break-after:always;">
                    <table width="100%">
                        <tr>
                            <td style='font-size: 70%; width: 25%;text-align:center'><i>( HALAMAN SELANJUTNYA )</i></td>
                        </tr>
                    </table>

                </td>
                @endif
              

            </tr>
        </table>
        
        
        <table width="100%">
            <tr>    
                <td style='font-size: 70%; width: 20%; line-height:90%; vertical-align:top;text-align: center'>PEMBERI TUGAS, <br>

                    <br /><br /> <br /><br /> <br /> <br />
                    <u>(...............................)</u> <br />
                    <br />                   
                </td>          
                <td style='font-size: 70%; width: 20%; line-height:90%; vertical-align:top'><b><br />                       
                    <br /> <br /><br /> <br /> <br /><br /><br /> <br /><br /> <br /> <br />
                </td>
             
                <td style='font-size: 70%; width: 20%; line-height:90%; vertical-align:top ;text-align: center'> <span> Mengetahui <br> <i>(GENERAL MANAGER)</i></span> 

                    <br /><br /> <br /><br /> <br /> <br />
                    <u>(...............................)</u> <br />
                    <br />                      
                </td>
                <td style='font-size: 70%; width: 20%; line-height:90%; vertical-align:top'><b><br />                       
                    <br /> <br /><br /> <br /> <br /><br /><br /> <br /><br /> <br /> <br />
                </td>

                <td style='font-size: 70%; width: 20%; line-height:90%; vertical-align:top;text-align: center'> Menyetujui <br> <i>(DIREKTUR)</i>

                    <br /><br /> <br /><br /> <br /> <br />
                    <u>(...............................)</u> <br />
                    <br />                    
                </td>
            </tr>
        </table>

        <hr style="margin-bottom: 0px; margin-top: 0px; border-width: 1px 0px 0px;">



          @if($totalPage <> $i)
            <div style="page-break-after: always;"></div>
            @endif



            @endfor

</body>

</html>