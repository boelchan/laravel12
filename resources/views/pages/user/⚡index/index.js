this.$js.confirmDelete = (id, nama) => {
    $interaction('dialog')
        .wireable()
        .question('Hapus ' + nama + ' ?', 'Data yang sudah dihapus tidak dapat dikembalikan')
        .cancel('Tutup')
        .confirm('Ya', 'delete', id)
        .send();
}