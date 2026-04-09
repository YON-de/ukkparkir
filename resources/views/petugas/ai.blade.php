@extends('layouts.petugas')
@section('title','AI Chatbot Petugas')
@section('content')

<div class="page-header mb-8">
    <div>
        <h2 class="text-3xl font-bold text-slate-900">AI Chatbot Parkir</h2>
        <p class="subtitle">Gunakan halaman ini untuk bertanya perkiraan biaya, ketersediaan slot, atau jam operasional.</p>
    </div>
    <div class="flex gap-3 flex-wrap">
        <a href="{{ route('petugas.dashboard') }}" class="btn btn-outline-secondary">Kembali Dashboard</a>
        <a href="{{ route('petugas.transaksi') }}" class="btn btn-outline-primary">Lihat Transaksi</a>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-8">
    <div class="bg-white rounded-3xl shadow-sm p-6">
        <h3 class="text-lg font-semibold text-slate-900 mb-3">Instruksi Cepat</h3>
        <ul class="space-y-3 text-sm text-slate-600">
            <li class="rounded-2xl bg-slate-50 p-3">• Tanyakan tarif parkir motor, mobil, atau lainnya.</li>
            <li class="rounded-2xl bg-slate-50 p-3">• Cek sisa slot per area parkir.</li>
            <li class="rounded-2xl bg-slate-50 p-3">• Tanyakan jam operasional atau informasi umum.</li>
        </ul>
    </div>
    <div class="bg-white rounded-3xl shadow-sm p-6 lg:col-span-2">
        <div class="flex items-center justify-between mb-5">
            <div>
                <h3 class="text-xl font-semibold text-slate-900">Chat dengan AI Parkir</h3>
                <p class="text-sm text-slate-500">Buat pesan untuk cek biaya dan ketersediaan area.</p>
            </div>
        </div>
        <div class="bg-white rounded-3xl shadow-sm p-4 mb-4 min-h-[320px] border border-slate-200">
            <div id="chat-messages" class="space-y-4 max-h-[520px] overflow-y-auto">
                <div class="flex justify-start">
                    <div class="max-w-[90%] rounded-br-3xl rounded-tr-3xl rounded-tl-3xl bg-slate-100 text-slate-900 px-4 py-3 shadow-sm">
                        <p class="text-sm leading-6">Halo! Saya siap membantu. Tanyakan tarif atau slot parkir, misalnya: "berapa tarif motor 2 jam?"</p>
                    </div>
                </div>
            </div>
        </div>
        <div class="flex gap-3 flex-col sm:flex-row items-end">
            <input id="chat-input" type="text" placeholder="Tulis pertanyaan Anda..."
                class="flex-1 border rounded-full px-4 py-3 focus:outline-none focus:ring-2 focus:ring-indigo-400 bg-white text-slate-900" />
            <button id="chat-send" class="btn btn-primary flex-shrink-0 px-5 py-3">Kirim</button>
        </div>
        <p class="mt-3 text-xs text-slate-500">Tekan Enter atau klik Kirim untuk melihat jawaban.</p>
    </div>
</div>

<script>
    const areas = @json($areas);
    const tarifs = @json($tarifs);

    const chatMessages = document.getElementById('chat-messages');
    const chatInput = document.getElementById('chat-input');
    const chatSend = document.getElementById('chat-send');

    const appendMessage = (sender, message) => {
        const wrapper = document.createElement('div');
        wrapper.className = sender === 'user' ? 'flex justify-end' : 'flex justify-start';
        const bubbleClass = sender === 'user'
            ? 'max-w-[85%] rounded-bl-3xl rounded-tl-3xl rounded-tr-3xl bg-blue-600 text-white'
            : 'max-w-[85%] rounded-br-3xl rounded-tr-3xl rounded-tl-3xl bg-slate-100 text-slate-900 border border-slate-200';
        wrapper.innerHTML = `
            <div class="${bubbleClass} px-4 py-3 shadow-sm">
                <p class="text-sm leading-6">${message}</p>
            </div>
        `;
        chatMessages.appendChild(wrapper);
        chatMessages.scrollTop = chatMessages.scrollHeight;
    };

    const showWelcomeMessage = () => {
        if (!chatMessages.hasChildNodes()) {
            appendMessage('assistant', 'Halo! Tanyakan tarif atau ketersediaan slot area parkir di sini. Contoh: "berapa tarif motor 2 jam?"');
        }
    };

    const getAnswer = (text) => {
        const normalized = text.toLowerCase();

        // Check for tarif/biaya
        if (/tarif|biaya|estimasi|harga|cost/.test(normalized)) {
            const jenis = normalized.match(/motor|mobil|lainnya|kendaraan/);
            const jam = normalized.match(/(\d+)\s*(jam|j|hour|hr|menit|minute)/i);
            const jenisKendaraan = jenis ? jenis[0] : null;

            if (!jenisKendaraan || jenisKendaraan === 'kendaraan') {
                return 'Sebutkan jenis kendaraan (motor, mobil, atau lainnya) untuk melihat estimasi biaya.';
            }

            const tarif = tarifs.find(t => t.jenis_kendaraan === jenisKendaraan);
            if (!tarif) {
                return `Tarif untuk ${jenisKendaraan} belum tersedia.`;
            }

            const lama = jam ? Number(jam[1]) : 1;
            const biaya = lama * tarif.tarif_per_jam;
            return `Estimasi biaya parkir ${jenisKendaraan} selama ${lama} jam adalah Rp ${new Intl.NumberFormat('id-ID').format(biaya)}.`;
        }

        // Check for slot/kapasitas
        if (/sisa|slot|kapasitas|tersisa|kosong|penuh/.test(normalized)) {
            const area = normalized.match(/area\\s*([0-9a-zA-Z]+)/);
            if (area) {
                const nama = area[1];
                const target = areas.find(a => a.nama_area.toLowerCase().includes(nama.toLowerCase()));
                if (target) {
                    const status = target.sisa <= 0 ? 'PENUH' : 'tersedia';
                    return `Area ${target.nama_area} memiliki sisa ${target.sisa} slot dari total ${target.kapasitas} (${status}).`;
                }
                return `Area ${nama} tidak ditemukan. Silakan cek nama area.`;
            }

            const list = areas.map(a => {
                const status = a.sisa <= 0 ? '(PENUH)' : `(${a.sisa} tersisa)`;
                return `${a.nama_area}: ${status}`;
            }).join('; ');
            return `Status area parkir saat ini: ${list}.`;
        }

        // Check for operational hours
        if (/jam|operasi|buka|tutup|active|waktu|kapan/.test(normalized)) {
            return 'Jam operasional parkir kami adalah 24/7 sepanjang tahun. Hubungi admin untuk pertanyaan spesifik lainnya.';
        }

        // Check for help/info request
        if (/bantuan|help|tanya|info|apa|bagaimana|siapa|mengapa|dimana/.test(normalized)) {
            return 'Saya dapat membantu Anda dengan: 1) Cek tarif parkir - \"berapa harga motor 2 jam?\", 2) Slot area - \"sisa slot area A?\", 3) Jam operasional, 4) Informasi umum parkir. Tanyakan apa saja yang Anda butuhkan!';
        }

        // Default response - flexible greeting
        return 'Halo! Saya siap membantu. Tanyakan tentang: tarif parkir, ketersediaan slot area, jam operasional, atau informasi parkir lainnya. Contoh: \"berapa tarif motor?\", \"slot area mana yang kosong?\", atau \"kapan parkir buka?\"';
    };

    const handleChat = () => {
        const value = chatInput.value.trim();
        if (!value) return;
        appendMessage('user', value);
        chatInput.value = '';
        setTimeout(() => appendMessage('assistant', getAnswer(value)), 300);
    };

    chatSend.addEventListener('click', handleChat);
    chatInput.addEventListener('keyup', (event) => {
        if (event.key === 'Enter') handleChat();
    });

    showWelcomeMessage();
</script>

@endsection
