this.$js.confirmDelete = (id, nama) => {
    $interaction('dialog')
        .wireable()
        .question('Batalkan ' + nama + ' ?', 'Data pasien yang sudah memiliki data kunjungan akan dinonaktifkan')
        .cancel('Tutup')
        .confirm('Ya, Hapus', 'delete', id)
        .send();
}

this.$js.confirmAktifkanPasien = (id, nama) => {
    $interaction('dialog')
        .wireable()
        .question('Aktifkan ' + nama + ' ?')
        .cancel('Tutup')
        .confirm('Ya, Aktifkan', 'aktifkanPasien', id)
        .send();
}