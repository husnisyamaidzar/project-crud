<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equive="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <style>
        table.static {
            position: relative;
            border: 1px solid #543535;
        }
    </style>
    <title>Laporan Agenda Kegiatan</title>
</head>

<body>
    <div class="form-group">
        <p align="center"><b>Data Agenda Kegiatan</b></p>
        <table class="static" align="center" rules="all" border="1px" style="width: 95%">
            <tr>
                <th>No</th>
                <th>ID Kegiatan</th>
                <th>Nama Kegiatan</th>
                <th>Tanggal Kegiatan</th>
                <th>Lokasi</th>
                <th>Penyelenggara</th>
            </tr>
            @foreach ($kegiatans as $item)
                <tr>
                    <td>{{$loop->iteration}}</td>
                    <td>{{$item->id_kegiatan}}</td>
                    <td>{{$item->nama_kegiatan}}</td>
                    <td>{{$item->tanggal_kegiatan}}</td>
                    <td>{{$item->lokasi}}</td>
                    <td>{{$item->penyelenggara}}</td>
                </tr>
            @endforeach
        </table>
    </div>
</body>

</html>