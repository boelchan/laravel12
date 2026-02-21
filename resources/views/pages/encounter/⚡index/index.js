this.$js.confirmBatal = (id, nama) => {
    $interaction('dialog')
        .wireable()
        .question('Batalkan ' + nama + ' ?', 'Data yang sudah dibatalkan tidak dapat dikembalikan')
        .cancel('Tutup')
        .confirm('Ya, Batal', 'batalkan', id)
        .send();
}