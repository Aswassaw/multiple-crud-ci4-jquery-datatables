<?= form_open(base_url('UserController/saveAddUser'), ['id' => 'form_tambah']) ?>
<?= csrf_field() ?>

<p>
    <button type="button" class="btn btn-secondary" id="btn_kembali"><i class="fas fa-redo"></i> Kembali</button>
    <button type="submit" class="btn btn-success"><i class="fas fa-save"></i> Simpan</button>
</p>

<div class="table-responsive">
    <table class="table table-bordered">
        <thead class="table-dark">
            <tr>
                <th>Nama<div class="spasi">_</div>User</th>
                <th>Tanggal<div class="spasi">_</div>Lahir</th>
                <th>Kewarganegaraan<div class="spasi">_</div>User</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody id="tabel_tambah">
            <tr>
                <td>
                    <input class="form-control" type="text" name="nama_user[]">
                    <div class="invalid-feedback error-nama-user">

                    </div>
                    <div class="valid-feedback">
                        Nama user benar
                    </div>
                    <small class="form-text">Masukkan nama user dengan benar</small>
                </td>
                <td>
                    <input class="form-control" type="date" name="tgllahir_user[]">
                    <div class="invalid-feedback error-tgllahir-user">

                    </div>
                    <div class="valid-feedback">
                        Tanggal lahir benar
                    </div>
                    <small class="form-text">Masukkan tanggal lahir dengan benar</small>
                </td>
                <td>
                    <select class="form-control" name="kewarganegaraan[]">
                        <?php foreach ($kewarganegaraan as $ngr) { ?>
                            <option value="<?= $ngr['id_kewarganegaraan'] ?>"><?= $ngr['nama_kewarganegaraan'] ?></option>
                        <?php } ?>
                    </select>
                    <div class="invalid-feedback error-kewarganegaraan">

                    </div>
                    <div class="valid-feedback">
                        Kewarganegaraan benar
                    </div>
                    <small class="form-text">Pilih kewarganegaraan dengan benar</small>
                </td>
                <td>
                    <button type="button" class="btn btn-primary" id="btn_tambahform">
                        <i class="fas fa-plus"></i>
                    </button>
                </td>
            </tr>
        </tbody>
    </table>
</div>
<?= form_close() ?>

<script>
    // Ketika document sudah ready
    $(document).ready(function() {
        // Jika form tersubmit
        $('#form_tambah').submit(function(e) {
            e.preventDefault();

            $.ajax({
                type: 'post',
                url: $(this).attr('action'),
                data: $(this).serialize(),
                dataType: 'json',
                success: function(response) {
                    if (response.success) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Berhasil!',
                            text: response.success,
                        }).then((result) => {
                            dataUser();
                        })
                    } else {
                        for (let i = 0; i < response.jumlah_data; i++) {
                            // Mengambil input nama user
                            let ipt_nama = document.getElementById('tabel_tambah').children[i].children[0].children[0];
                            // Menghilangkan element small
                            ipt_nama.nextElementSibling.nextElementSibling.nextElementSibling.style = 'display: none;';
                            // Jika pada input nama user tersebut terdapat error
                            if (response[i].nama_user) {
                                ipt_nama.classList.remove('is-valid');
                                ipt_nama.classList.add('is-invalid');
                                ipt_nama.nextElementSibling.innerHTML = response[i].nama_user;
                            } else {
                                ipt_nama.classList.remove('is-invalid');
                                ipt_nama.classList.add('is-valid');
                            }

                            // Mengambil input tanggal lahir
                            let ipt_tgl = document.getElementById('tabel_tambah').children[i].children[1].children[0];
                            // Menghilangkan element small
                            ipt_tgl.nextElementSibling.nextElementSibling.nextElementSibling.style = 'display: none;';
                            // Jika pada input tanggal lahir tersebut terdapat error
                            if (response[i].tgllahir_user) {
                                ipt_tgl.classList.remove('is-valid');
                                ipt_tgl.classList.add('is-invalid');
                                ipt_tgl.nextElementSibling.innerHTML = response[i].tgllahir_user;
                            } else {
                                ipt_tgl.classList.remove('is-invalid');
                                ipt_tgl.classList.add('is-valid');
                            }

                            // Mengambil input kewarganegaraan
                            let ipt_ngr = document.getElementById('tabel_tambah').children[i].children[2].children[0];
                            // Menghilangkan element small
                            ipt_ngr.nextElementSibling.nextElementSibling.nextElementSibling.style = 'display: none;';
                            // Jika pada input kewarganegaraan tersebut terdapat error
                            if (response[i].kewarganegaraan) {
                                ipt_ngr.classList.remove('is-valid');
                                ipt_ngr.classList.add('is-invalid');
                                ipt_ngr.nextElementSibling.innerHTML = response[i].kewarganegaraan;
                            } else {
                                ipt_ngr.classList.remove('is-invalid');
                                ipt_ngr.classList.add('is-valid');
                            }
                        }
                    }
                },
                error: function(xhr, ajaxOptions, thrownError) {
                    $('#error_message').html(
                        `<strong>${xhr.status + ' ' + thrownError}</strong>
                        <br>
                        <div class="card mt-2">
                            <div class="card-body">
                                ${xhr.responseText}
                            </div>
                        </div>`
                    );
                    $('#error_modal').modal('show');
                }
            })
            return false;
        })

        // Jika tombol kembali ditekan
        $('#btn_kembali').click(function(e) {
            dataUser();
        })

        // Jika tombol tambah form ditekan
        $('#btn_tambahform').click(function(e) {
            // Append form baru
            $('#tabel_tambah').append(
                `<tr>
                <td>
                    <input class="form-control" type="text" name="nama_user[]">
                    <div class="invalid-feedback error-nama-user">

                    </div>
                    <div class="valid-feedback">
                        Nama user benar
                    </div>
                    <small class="form-text">Masukkan nama user dengan benar</small>
                </td>
                <td>
                    <input class="form-control" type="date" name="tgllahir_user[]">
                    <div class="invalid-feedback error-tgllahir-user">

                    </div>
                    <div class="valid-feedback">
                        Tanggal lahir benar
                    </div>
                    <small class="form-text">Masukkan tanggal lahir dengan benar</small>
                </td>
                <td>
                    <select class="form-control" name="kewarganegaraan[]">
                        <?php foreach ($kewarganegaraan as $ngr) { ?>
                            <option value="<?= $ngr['id_kewarganegaraan'] ?>"><?= $ngr['nama_kewarganegaraan'] ?></option>
                        <?php } ?>
                    </select>
                    <div class="invalid-feedback error-kewarganegaraan">

                    </div>
                    <div class="valid-feedback">
                        Kewarganegaraan benar
                    </div>
                    <small class="form-text">Pilih kewarganegaraan dengan benar</small>
                </td>
                <td>
                    <button type="button" class="btn btn-danger" id="btn_hapusform">
                        <i class="fas fa-minus"></i>
                    </button>
                </td>
            </tr>`)
        })
    })

    // Pada dokumen jika ada, dan jalankan ketika btn_hapusform ditekan
    $(document).on('click', '#btn_hapusform', function(e) {
        $(this).parents('tr').remove();
    })
</script>