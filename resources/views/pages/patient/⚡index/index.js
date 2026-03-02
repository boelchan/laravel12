this.$js.confirmDelete = (id, nama) => {
    $tsui.interaction('dialog')
        .wireable()
        .question('Hapus ' + nama + ' ?', 'Data pasien yang sudah memiliki data kunjungan akan dinonaktifkan')
        .cancel('Kembali')
        .confirm('Ya, Hapus', 'delete', id)
        .send();
}

this.$js.confirmAktifkanPasien = (id, nama) => {
    $tsui.interaction('dialog')
        .wireable()
        .question('Aktifkan ' + nama + ' ?')
        .cancel('Kembali')
        .confirm('Ya, Aktifkan', 'aktifkanPasien', id)
        .send();
}