this.$js.confirmDelete = (id, name) => {
    $wireui.confirmDialog({
        title: 'Hapus ' + name + '?',
        description: 'Data yang dihapus tidak dapat dikembalikan',
        icon: 'error',
        accept: {
            label: 'Ya, Hapus',
            execute: () => {
                $wire.delete(id)
            }
        },
        reject: {
            label: 'Batal',
        }
    })
}