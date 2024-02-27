@foreach ($data as $key => $value)
    <table>
        <thead>
            <tr style="background-color: turquoise">
                <th colspan="6" style="background-color: turquoise;text-align: center">{{$key}}</th>
            </tr>
            <tr style="background-color: turquoise">                
                <th style="background-color: yellow">Nama</th>
                <th style="background-color: yellow">Tanggal</th>
                <th style="background-color: yellow">Clock In</th>
                <th style="background-color: yellow">Clock Out</th>
                <th style="background-color: yellow">Work Time</th>                              
                <th style="background-color: yellow">Status</th>  
            </tr>
        </thead>
        <tbody>            
            @foreach ($value as $item)
                <tr>
                    <td>{{ ucfirst($item['nama'])}}</td>
                    <td>{{\Carbon\Carbon::parse($item['tanggal'])->format('d/m/Y') }}</td>
                    <td>{{\Carbon\Carbon::parse($item['clock_in'])->format('H:i') }}</td>
                    <td>{{\Carbon\Carbon::parse($item['clock_out'])->format('H:i') }}</td>
                    <td>{{\Carbon\Carbon::parse($item['work_time'])->format('H:i') }}</td>
                    <td>{{ ucfirst($item['status'])}}</td>
                </tr>
            @endforeach
            <tr></tr>
        </tbody>
    </table>
@endforeach

