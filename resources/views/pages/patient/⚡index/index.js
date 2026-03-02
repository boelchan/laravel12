this.$js.confirmDelete = (id, nama) => {
    $tsui.interaction('dialog')
        .wireable()
        .question('Hapus ' + nama + ' ?', 'Data pasien yang sudah memiliki data kunjungan akan dinonaktifkan')
        .cancel('Tutup')
        .confirm('Ya, Hapus', 'delete', id)
        .send();
}

this.$js.confirmAktifkanPasien = (id, nama) => {
    $tsui.interaction('dialog')
        .wireable()
        .question('Aktifkan ' + nama + ' ?')
        .cancel('Tutup')
        .confirm('Ya, Aktifkan', 'aktifkanPasien', id)
        .send();
}