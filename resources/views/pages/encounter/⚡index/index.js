this.$js.confirmDelete = (id, nama) => {
    $tsui.interaction('dialog')
        .wireable()
        .question('Hapus ' + nama + ' ?', 'Data yang sudah dihapus tidak dapat dikembalikan')
        .cancel('Kembali')
        .confirm('Ya, Hapus', 'delete', id)
        .send();
}

this.$js.confirmBatal = (id, nama) => {
    $tsui.interaction('dialog')
        .wireable()
        .question('Batalkan ' + nama)
        .cancel('Kembali')
        .confirm('Ya, Batal', 'batalkan', id)
        .send();
}

this.$js.confirmPulihkan = (id, nama) => {
    $tsui.interaction('dialog')
        .wireable()
        .question('Pulihkan Kunjungan ' + nama)
        .cancel('Kembali')
        .confirm('Ya, Pulihkan', 'pulihkanKunjungan', id)
        .send();
}

// Implementasi Text to Speech paling ringan menggunakan Web Speech API
this.$js.speak = (text, options = {}) => {
    if (!window.speechSynthesis) {
        alert('Browser Anda tidak mendukung Text to Speech');
        return;
    }

    // Hentikan suara yang sedang berjalan
    speechSynthesis.cancel();

    // Beri sedikit delay agar cancel selesai di beberapa browser
    setTimeout(() => {
        const utterance = new SpeechSynthesisUtterance(text);
        
        // Konfigurasi dasar
        utterance.lang = options.lang || 'id-ID';
        utterance.rate = options.rate || 0.9;      // Kecepatan sedikit diperlambat agar jelas
        utterance.pitch = options.pitch || 1.0;
        utterance.volume = options.volume || 1.0;

        // Cari suara Bahasa Indonesia
        const voices = speechSynthesis.getVoices();
        const indonesianVoice = voices.find(voice => voice.lang.includes('id-ID') || voice.lang.includes('id_ID'));
        
        if (indonesianVoice) {
            utterance.voice = indonesianVoice;
        }

        // Event listeners
        utterance.onstart = options.onstart || (() => {});
        utterance.onend = options.onend || (() => {});
        utterance.onerror = (event) => {
            console.error('SpeechSynthesisUtterance error', event);
            if (options.onerror) options.onerror(event);
        };

        speechSynthesis.speak(utterance);
    }, 50);
}