
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
        <tr>
            <td colspan="6" style="text-align: center; border-bottom: 1px solid black;">
                <h1 style="margin-top: 5px; margin-bottom: 10px;">PT KARYA PUTRA ANDALAN</h1>
                <h5 style="margin-top: 0px; margin-bottom: 5px;">Ruko Purimas - Rungkut Madya Jl. Raya I gusti Ngurah
                    Rai Kav. A1. No. 11-12
                    Surabaya</h5>
                <h5 style="margin-top: 0px;margin-bottom: 5px;">NPWP: 03.113.119.6-615.000 | Telp: 0318707111 | Email: karyaputraandalan@yahoo.com</h5>
            </td>

        </tr>
        <tr>
            <td width="40%" style="vertical-align: top;">
                <table >                   
                    <tr style="padding:0px;">
                        <td style="padding:0px;font-size: 70%; ">LAB/RS</td>
                        <td style="padding:0px;font-size: 70%; ">:</td>
                        <td style="padding:0px;font-size: 70%; ">
                            {{$maintenance->nama_lab}}
                        </td>
                    </tr>
                    <tr style="padding:0px;">
                        <td style="padding:0px;font-size: 70%; ">ALAMAT</td>
                        <td style="padding:0px;font-size: 70%; ">:</td>
                        <td style="padding:0px;font-size: 70%; ">
                            {{$maintenance->alamat}}
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
                <table>                   
                    <tr style="padding:0px;">
                        <td style="padding:0px;font-size: 70%; ">PEMOHON</td>
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

                </table>


            </td>
        </tr>
        
        <tr>
            <td colspan="6" style="vertical-align: top; ">
                <span style="font-size: 60%;margin-left:5px">SEBELUM DIKERJAKAN</span>
                <div class="isi" style="height: 320px;">
                    <table border="0" class="xyz" style="width:100%; ">
                       
                        
                        <tr>
                            <td colspan="7">
                                <hr style="margin-bottom: 0px; margin-top: 0px; border-width: 1px 0px 0px;">
                            </td>
                        </tr>
                        <tr style="">
                            <td style="font-size: 65%; border:none; width:3%">NO</td>
                            <td style="font-size: 65%; border:none; width:30%;text-align:left">NAMA ALAT</td>
                            <td style="font-size: 65%; border:none; width:17%;text-align:left">NO SERI</td>
                            <td style="font-size: 65%; border:none; width:50%;text-align:left">KELUHAN/KEPERLUAN</td>                            
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
                        @foreach ($maintenance->sebelumKondisi as $item)
                            <tr class="" style="vertical-align:top">
                                <td style="font-size: 62%;text-align: left">{{ $j}}.</td>
                                <td style="font-size: 67%;font-family:'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;">{{ $item->nama_alat }}</td>
                                <td style="font-size: 62%; text-align:left;">{{$item->no_seri}}</td>
                                <td style="font-size: 62%; text-align:left;">{{$item->keluhan}}</td>                              
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
            <td width="40%" style="vertical-align: top;">    
                <table >
                    
                    <tr style="padding:0px;">
                        <td style="padding:0px;font-size: 70%; ">TEMPAT PENGERJAAN</td>
                        <td style="padding:0px;font-size: 70%; ">:</td>
                        <td style="padding:0px;font-size: 70%; ">
                            {{$maintenance->tempat_pengerjaan}}
                        </td>
                    </tr>
                   
                    <tr style="padding:0px;">
                        <td style="padding:0px;font-size: 70%; " colspan="3"></td>

                    </tr>
                    <tr style="padding:0px;">
                        <td style="padding:0px;font-size: 70%; " colspan="3">
                    </tr>

                </table>
               
            </td>
            <td width="10%" style="font-size: 75%; vertical-align: top; text-align: center;">
                <center><b></b></center>
                <center><b>

                    </b></center>
            </td>

            {{-- <tr>
                <p style="font-size: 60%">SETELAH DIKERJAKAN</p>
            </tr> --}}
           
            <td width="50%" style="vertical-align: top; text-align: left; font-family: sans-serif">
                
                <table>                   
                    <tr style="padding:0px;">
                        <td style="padding:0px;font-size: 70%; ">TANGGAL DIKERJAKAN</td>
                        <td style="padding:0px;font-size: 70%; ">:</td>
                        <td style="padding:0px;font-size: 70%; ">
                            {{\Carbon\Carbon::parse($maintenance->tanggal_dikerjakan)->format('d F Y')}}
                        </td>
                    </tr>
                    <tr style="padding:0px;">
                        <td style="padding:0px;font-size: 70%; ">TANGGAL SELESAI DIKERJAKAN</td>
                        <td style="padding:0px;font-size: 70%; ">:</td>
                        <td style="padding:0px;font-size: 70%; ">
                            {{\Carbon\Carbon::parse($maintenance->tanggal_selesai_dikerjakan)->format('d F Y')}}
                        </td>
                    </tr>
                    <tr style="padding:0px;">
                        <td style="padding:0px;font-size: 70%; "></td>
                        <td style="padding:0px;font-size: 70%; "></td>
                        <td style="padding:0px;font-size: 70%; ">

                        </td>
                    </tr>
                    <tr style="padding:0px;">
                        <td style="padding:0px;font-size: 70%; "></td>
                        <td style="padding:0px;font-size: 70%; "></td>
                        <td style="padding:0px;font-size: 70%; ">

                        </td>
                    </tr>

                </table>


            </td>
        </tr>

        

        <tr>
            <td colspan="6" style="vertical-align: top; ">
                <span style="font-size: 60%;margin-left:5px">SETELAH DIKERJAKAN</span>
                <div class="isi" style="height: 320px;">
                    <table border="0" class="xyz" style="width:100%; ">                        
                       
                        <tr>
                            <td colspan="7">
                                <hr style="margin-bottom: 0px; margin-top: 0px; border-width: 1px 0px 0px;">
                            </td>
                        </tr>
                        <tr style="">
                            <td style="font-size: 65%; border:none; width:3%">NO</td>
                            <td style="font-size: 65%; border:none; width:30%;text-align:left">NAMA SPAREPART</td>
                            <td style="font-size: 65%; border:none; width:17%;text-align:left">QTY</td>
                            <td style="font-size: 65%; border:none; width:50%;text-align:left">PEKERJAAN/PENYELESAIAN</td>                            
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
                        @foreach ($maintenance->setelahKondisi as $item)
                            <tr class="" style="vertical-align:top">
                                <td style="font-size: 62%;text-align: left">{{ $j}}.</td>
                                <td style="font-size: 67%;font-family:'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;">{{ $item->nama_sparepart }}</td>
                                <td style="font-size: 62%; text-align:left;">{{$item->qty}}</td>
                                <td style="font-size: 62%; text-align:left;">{{$item->pekerjaan}}</td>                              
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
                    <p style="font-size: 70%">SARAN : {{$maintenance->saran}} </p><br>
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


        <hr style="margin-bottom: 0px; margin-top: 0px; border-width: 1px 0px 0px;">
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
        <hr style="margin-bottom: 0px; margin-top: 0px; border-width: 1px 0px 0px;">
        <table>
           
        </table>
        <br />    
        <table width="100%">
            <tr>
                <td style='font-size: 70%; width: 15%; line-height:90%; vertical-align:top;text-align: center'>TEKNISI,

                    <br /><br /> <br /><br /> <br /> <br />
                    <u>(...............................)</u> <br />
                    <br />                   
                </td>
                <td style='font-size: 70%; width: 55%; line-height:90%; vertical-align:top'><b><br />
                        {{-- {{
                        $fakturpenjualan->keterangan }}</b> --}}
                    <br /> <br /><br /> <br /> <br /><br /><br /> <br /><br /> <br /> <br />


                </td>

                <td style='font-size: 70%; width: 15%; line-height:90%; vertical-align:top;text-align: center'>CUSTOMER,

                    <br /><br /> <br /><br /> <br /> <br />
                    <u>(...............................)</u> <br />
                    <br />                    
                </td>
            </tr>
        </table>



          @if($totalPage <> $i)
            <div style="page-break-after: always;"></div>
            @endif



            @endfor

</body>

</html>