<x-app-layout>

    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="{{ asset('assets/bootstrap.min.css') }}">
        <link rel="stylesheet" href="{{ asset('assets/DataTables-1.13.3/css/jquery.dataTables.min.css') }}">
        <link rel="stylesheet" href="{{ asset('assets/font-awesome/css/all.min.css') }}">
        <link rel="stylesheet" href="{{ asset('assets/custom-style.css') }}">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    </head>
    <style>
        body {
            background-color: #f4f6f9;
            font-family: 'Arial', sans-serif;
            padding: 20px;
        }

        .card {
            border-radius: 12px;
            box-shadow: 0 6px 10px rgba(0, 0, 0, 0.15);
            border: none;
            overflow: hidden;
        }

        .card-header {
            background: linear-gradient(45deg, #4caf50, #66bb6a);
            color: white;
            padding: 15px;
            font-size: 1.2rem;
            font-weight: bold;
        }

        table th {
            background-color: #4a5568;
            color: #ffffff;
            text-align: center;
            border: none;
        }

        table tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        table tr:hover {
            background-color: #e2f0ff;
            transition: all 0.3s ease-in-out;
        }

        .btn {
            border-radius: 10px;
        }

        .btn:hover {
            transform: scale(1.05);
        }

        footer {
            background-color: #4a5568;
            color: #ffffff;
            padding: 10px;
            border-radius: 10px;
            text-align: center;
        }

        .modal-content {
            border-radius: 15px;
        }

        .modal-header {
            background: #66bb6a;
            color: white;
        }

        .modal-footer .btn {
            border-radius: 12px;
        }
        h1 {
            text-align: center;
            font-size: 2.5rem;
            font-weight: bold;
            margin-top: 20px;
            color: #495057;
            text-shadow: 2px 2px 5px rgba(0, 0, 0, 0.1);
        }
    </style>
</head>

<body class="container-fluid">
    <h1>Manajemen Kegiatan</h1>
    <div class="container py-4">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <span>Data Agenda Kegiatan</span>
                <div>
                    <button id="btn_add" class="btn btn-info me-2">Add Data <i class="fa-solid fa-square-plus"></i></button>
                    <a href="{{ route('report') }}" target="_blank" class="btn btn-danger">Report Data <i class="fas fa-print"></i></a>
                </div>
            </div>

            <div class="card-body">
                <table id="table_kegiatan" class="table table-bordered table-striped table-hover">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>ID Kegiatan</th>
                            <th>Nama Kegiatan</th>
                            <th>Tanggal Kegiatan</th>
                            <th>Lokasi</th>
                            <th>Penyelenggara</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>

        <footer class="mt-4">
            <span>&copy; 2025 | Agenda Kegiatan | Husni Syamaidzar</span>
        </footer>
    </div>

    <!-- Modal -->
    <div id="modal_add" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Tambah Data Agenda Kegiatan</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="form_add_data">
                        <div class="mb-3">
                            <label for="id_kegiatan" class="form-label">ID Kegiatan</label>
                            <input type="text" class="form-control" name="id_kegiatan" id="id_kegiatan" required>
                        </div>
                        <div class="mb-3">
                            <label for="nama_kegiatan" class="form-label">Nama Kegiatan</label>
                            <input type="text" class="form-control" name="nama_kegiatan" id="nama_kegiatan" required>
                        </div>
                        <div class="mb-3">
                            <label for="tanggal_kegiatan" class="form-label">Tanggal Kegiatan</label>
                            <input type="date" class="form-control" name="tanggal_kegiatan" id="tanggal_kegiatan" required>
                        </div>
                        <div class="mb-3">
                            <label for="lokasi" class="form-label">Lokasi</label>
                            <input type="text" class="form-control" name="lokasi" id="lokasi" required>
                        </div>
                        <div class="mb-3">
                            <label for="penyelenggara" class="form-label">Penyelenggara</label>
                            <input type="text" class="form-control" name="penyelenggara" id="penyelenggara" required>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" id="btn_simpan" class="btn btn-primary">Save</button>
                    <button type="button" id="btn_edit" class="btn btn-warning">Edit</button>
                </div>
            </div>
        </div>
    </div>

            <script src="{{ asset('assets/jquery-3.6.1.js') }}"></script>
            <script src="{{ asset('assets/bootstrap.min.js') }}"></script>
            <script src="{{ asset('assets/DataTables-1.13.3/js/jquery.dataTables.min.js') }}"></script>

            <script>
                $(document).ready(function () {
                    let table = $('#table_kegiatan').DataTable();

                    function tampilData() {
                        $.ajax({
                            url: '/api/kegiatans',
                            method: 'GET',
                            dataType: 'json',
                            success: function (response) {
                                table.clear().draw();
                                if (Array.isArray(response)) {
                                    let no = 1;
                                    response.forEach(function (post) {
                                        table.row.add([
                                            no++,
                                            post.id_kegiatan,
                                            post.nama_kegiatan,
                                            post.tanggal_kegiatan,
                                            post.lokasi,
                                            post.penyelenggara,
                                            `
                                    <div style="display: flex; align-items: center; gap: 5px;">
                                        <button class="btn btn-success btn-sm editBtn" data-id="${post.id}">Edit</button>|
                                        <button class="btn btn-danger btn-sm deleteBtn" data-id="${post.id}">Delete</button>
                                    </div>
                                    `
                                        ]).draw();
                                    })
                                } else {
                                    alert('gagal memuat data.');
                                }
                            }
                        });
                    }

                    tampilData();

                    $('#btn_add').click(function () {
                        $('#modal_add').modal('show');
                        $('#btn_simpan').show();
                        $('#btn_edit').hide();
                        reset();
                    });

                    function reset() {
                        $('#id_kegiatan').val('')
                        $('#nama_kegiatan').val('')
                        $('#tanggal_kegiatan').val('')
                        $('#lokasi').val('')
                        $('#penyelenggara').val('')
                    }

                    $('#btn_simpan').click(function () {
                        const method = 'POST';
                        const url = '/api/kegiatans';

                        const formData = new FormData();
                        formData.append('id_kegiatan', $('#id_kegiatan').val());
                        formData.append('nama_kegiatan', $('#nama_kegiatan').val());
                        formData.append('tanggal_kegiatan', $('#tanggal_kegiatan').val());
                        formData.append('lokasi', $('#lokasi').val());
                        formData.append('penyelenggara', $('#penyelenggara').val());

                        $.ajax({
                            url: url,
                            method: method,
                            data: formData,
                            processData: false,
                            contentType: false,
                            success: function (response) {
                                if (response.success) {
                                    $('#modal_add').modal('hide');
                                    alert(response.message);
                                    tampilData();
                                } else {
                                    alert('Gagal menyimpan data');
                                }
                            }
                        });

                    });

                    $(document).on('click', '.deleteBtn', function () {
                        let id = $(this).data('id');

                        if (confirm('Apakah data ini akan dihapus?')) {
                            $.ajax({
                                url: '/api/kegiatans/' + id,
                                method: 'DELETE',
                                success: function (response) {
                                    if (response.success) {
                                        alert(response.message);
                                        tampilData();
                                    } else {
                                        alert(response.message);
                                    }
                                }
                            })
                        }
                    });
                    $(document).on('click', '.editBtn', function () {
                        let id = $(this).data('id');
                        $.ajax({
                            url: '/api/kegiatans/' + id,
                            method: 'GET',
                            success: function (response) {
                                $('#id_kegiatan').val(response.id_kegiatan);
                                $('#nama_kegiatan').val(response.nama_kegiatan);
                                $('#tanggal_kegiatan').val(response.tanggal_kegiatan);
                                $('#lokasi').val(response.lokasi);
                                $('#penyelenggara').val(response.penyelenggara);
                                $('#btn_edit').data('id', id);
                                $('#modal_add').modal('show');
                                $('.modal-title').text('Edit Data Agenda Kegiatan');
                                $('#btn_simpan').hide();
                                $('#btn_edit').show();
                            }
                        })
                    });
                    $('#btn_edit').click(function () {
                        const id = $(this).data('id');
                        const formData = new FormData();
                        formData.append('id_kegiatan', $('#id_kegiatan').val());
                        formData.append('nama_kegiatan', $('#nama_kegiatan').val());
                        formData.append('tanggal_kegiatan', $('#tanggal_kegiatan').val());
                        formData.append('lokasi', $('#lokasi').val());
                        formData.append('penyelenggara', $('#penyelenggara').val());
                        formData.append('_method', 'PUT');

                        $.ajax({
                            url: '/api/kegiatans/' + id,
                            method: 'POST',
                            data: formData,
                            processData: false,
                            contentType: false,
                            success: function (response) {
                                if (response.success) {
                                    $('#modal_add').modal('hide');
                                    alert(response.message);
                                    tampilData();
                                } else {
                                    alert('Gagal memperbarui data');
                                }
                            },
                            error: function () {
                                alert('Terjadi kesalahan saat memperbarui data.');
                            }
                        });
                    });
                });

            </script>

    </body>

    </html>
</x-app-layout>