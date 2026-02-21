<div>
    <h1 class="text-2xl font-bold tracking-tight text-slate-900">Encounter / Kunjungan Pasien</h1>
    <div class="breadcrumbs p-0 text-sm text-slate-500">
        <ul>
            <li><a href="{{ route('dashboard') }}"><i class="ti ti-home mr-1"></i> Dashboard</a></li>
            <li><a href="{{ route('encounter.index') }}">Kunjungan</a></li>
            <li>Edit Pemeriksaan</li>
        </ul>
    </div>

    <div class="mt-8">
        <form wire:submit="update">
            @csrf
            <div class="grid grid-cols-1 gap-8 lg:grid-cols-12">
                
                {{-- LEFT COLUMN: VITAL SIGNS & ANTHROPOMETRY --}}
                <div class="space-y-6 lg:col-span-4">
                    {{-- TTV CARD --}}
                    <div class="card border border-slate-200 bg-white shadow-sm overflow-hidden">
                        <div class="bg-slate-50 border-b border-slate-200 px-6 py-4">
                            <h2 class="text-lg font-semibold text-slate-800 flex items-center gap-2">
                                <i class="ti ti-heart-rate-monitor text-primary text-xl"></i> TTV (Tanda Vital)
                            </h2>
                        </div>
                        <div class="card-body p-6 space-y-4">
                            <div class="grid grid-cols-2 gap-4">
                                <x-input wire:model="td" label="TD (Tensi)" suffix="mmHg" placeholder="120/80" />
                                <x-input wire:model="hr" label="HR (Nadi)" suffix="bpm" placeholder="80" />
                            </div>
                            <div class="grid grid-cols-2 gap-4">
                                <x-input wire:model="rr" label="RR (Nafas)" suffix="x/mnt" placeholder="20" />
                                <x-input wire:model="temp" label="Suhu" suffix="°C" placeholder="36.5" />
                            </div>
                        </div>
                    </div>

                    {{-- ANTROPOMETRI CARD --}}
                    <div class="card border border-slate-200 bg-white shadow-sm overflow-hidden">
                        <div class="bg-slate-50 border-b border-slate-200 px-6 py-4">
                            <h2 class="text-lg font-semibold text-slate-800 flex items-center gap-2">
                                <i class="ti ti-ruler-2 text-primary text-xl"></i> Antropometri
                            </h2>
                        </div>
                        <div class="card-body p-6 space-y-4" x-data="{ 
                            bb: @entangle('bb'), 
                            tb: @entangle('tb'),
                            get imt() {
                                if (this.bb && this.tb) {
                                    let tbM = this.tb / 100;
                                    return (this.bb / (tbM * tbM)).toFixed(2);
                                }
                                return '-';
                            }
                        }">
                            <div class="grid grid-cols-2 gap-4">
                                <x-input x-model="bb" label="BB (Berat)" suffix="kg" placeholder="60" />
                                <x-input x-model="tb" label="TB (Tinggi)" suffix="cm" placeholder="170" />
                            </div>
                            <x-input wire:model="lp" label="Lingkar Perut" suffix="cm" placeholder="80" />
                            
                            <div class="bg-blue-50 p-4 rounded-xl border border-blue-100 mt-2">
                                <p class="text-xs font-medium text-blue-600 uppercase tracking-wider">Indeks Massa Tubuh (IMT)</p>
                                <div class="flex items-baseline gap-2">
                                    <span class="text-3xl font-bold text-blue-800" x-text="imt"></span>
                                    <span class="text-sm text-blue-600 font-medium">kg/m²</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- RIGHT COLUMN: HASIL & RESEP --}}
                <div class="space-y-6 lg:col-span-8">
                    {{-- HASIL PEMERIKSAAN CARD --}}
                    <div class="card border border-slate-200 bg-white shadow-sm overflow-hidden text-slate-800">
                        <div class="bg-slate-50 border-b border-slate-200 px-6 py-4">
                            <h2 class="text-lg font-semibold text-slate-800 flex items-center gap-2">
                                <i class="ti ti-notes text-primary text-xl"></i> Hasil Pemeriksaan
                            </h2>
                        </div>
                        <div class="card-body p-6 space-y-6">
                            <x-textarea wire:model="hasil_text" label="Catatan / Hasil" rows="4" placeholder="Masukkan hasil pemeriksaan..." />
                            
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div class="space-y-2">
                                    <label class="block text-sm font-medium text-slate-700">Tanda Tangan Dokter</label>
                                    <div wire:ignore class="signature-container relative group">
                                        <div id="pad-hasil-dokter" class="drawpad-dashed h-40 w-full rounded-lg border-2 border-dashed border-slate-300 bg-slate-50"></div>
                                        <div class="absolute right-2 bottom-2 flex gap-1 opacity-0 group-hover:opacity-100 transition-opacity">
                                            <button type="button" title="Undo" onclick="undoPad('pad-hasil-dokter')" class="btn btn-xs btn-secondary btn-square">
                                                <i class="ti ti-arrow-back-up"></i>
                                            </button>
                                            <button type="button" title="Redo" onclick="redoPad('pad-hasil-dokter')" class="btn btn-xs btn-secondary btn-square">
                                                <i class="ti ti-arrow-forward-up"></i>
                                            </button>
                                            <button type="button" title="Clear" onclick="clearPad('pad-hasil-dokter')" class="btn btn-xs btn-danger btn-square">
                                                <i class="ti ti-trash"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                                <div class="space-y-2">
                                    <label class="block text-sm font-medium text-slate-700">Tanda Tangan Pasien</label>
                                    <div wire:ignore class="signature-container relative group">
                                        <div id="pad-hasil-pasien" class="drawpad-dashed h-40 w-full rounded-lg border-2 border-dashed border-slate-300 bg-slate-50"></div>
                                        <div class="absolute right-2 bottom-2 flex gap-1 opacity-0 group-hover:opacity-100 transition-opacity">
                                            <button type="button" title="Undo" onclick="undoPad('pad-hasil-pasien')" class="btn btn-xs btn-secondary btn-square">
                                                <i class="ti ti-arrow-back-up"></i>
                                            </button>
                                            <button type="button" title="Redo" onclick="redoPad('pad-hasil-pasien')" class="btn btn-xs btn-secondary btn-square">
                                                <i class="ti ti-arrow-forward-up"></i>
                                            </button>
                                            <button type="button" title="Clear" onclick="clearPad('pad-hasil-pasien')" class="btn btn-xs btn-danger btn-square">
                                                <i class="ti ti-trash"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- RESEP CARD --}}
                    <div class="card border border-slate-200 bg-white shadow-sm overflow-hidden text-slate-800">
                        <div class="bg-slate-50 border-b border-slate-200 px-6 py-4">
                            <h2 class="text-lg font-semibold text-slate-800 flex items-center gap-2">
                                <i class="ti ti-prescription text-primary text-xl"></i> Resep Obat
                            </h2>
                        </div>
                        <div class="card-body p-6 space-y-6">
                            <x-textarea wire:model="resep_text" label="Daftar Terapi / Obat" rows="4" placeholder="R/ ..." />
                            
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div class="space-y-2">
                                    <label class="block text-sm font-medium text-slate-700">Validasi Dokter</label>
                                    <div wire:ignore class="signature-container relative group">
                                        <div id="pad-resep-dokter" class="drawpad-dashed h-40 w-full rounded-lg border-2 border-dashed border-slate-300 bg-slate-50"></div>
                                        <div class="absolute right-2 bottom-2 flex gap-1 opacity-0 group-hover:opacity-100 transition-opacity">
                                            <button type="button" title="Undo" onclick="undoPad('pad-resep-dokter')" class="btn btn-xs btn-secondary btn-square">
                                                <i class="ti ti-arrow-back-up"></i>
                                            </button>
                                            <button type="button" title="Redo" onclick="redoPad('pad-resep-dokter')" class="btn btn-xs btn-secondary btn-square">
                                                <i class="ti ti-arrow-forward-up"></i>
                                            </button>
                                            <button type="button" title="Clear" onclick="clearPad('pad-resep-dokter')" class="btn btn-xs btn-danger btn-square">
                                                <i class="ti ti-trash"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                                <div class="space-y-2">
                                    <label class="block text-sm font-medium text-slate-700">Validasi Apoteker / Pasien</label>
                                    <div wire:ignore class="signature-container relative group">
                                        <div id="pad-resep-apoteker" class="drawpad-dashed h-40 w-full rounded-lg border-2 border-dashed border-slate-300 bg-slate-50"></div>
                                        <div class="absolute right-2 bottom-2 flex gap-1 opacity-0 group-hover:opacity-100 transition-opacity">
                                            <button type="button" title="Undo" onclick="undoPad('pad-resep-apoteker')" class="btn btn-xs btn-secondary btn-square">
                                                <i class="ti ti-arrow-back-up"></i>
                                            </button>
                                            <button type="button" title="Redo" onclick="redoPad('pad-resep-apoteker')" class="btn btn-xs btn-secondary btn-square">
                                                <i class="ti ti-arrow-forward-up"></i>
                                            </button>
                                            <button type="button" title="Clear" onclick="clearPad('pad-resep-apoteker')" class="btn btn-xs btn-danger btn-square">
                                                <i class="ti ti-trash"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="mt-10 flex items-center justify-between border-t border-slate-200 pt-6">
                <p class="text-sm text-slate-500 italic">Pastikan semua data pemeriksaan telah terisi dengan benar.</p>
                <div class="flex gap-3">
                    <a class="btn btn-soft btn-secondary px-6" href="{{ route('encounter.index') }}" wire:navigate>Batal</a>
                    <button class="btn btn-primary px-8" type="button" x-on:click="$dispatch('capture-signatures')">
                        <i class="ti ti-device-floppy mr-2"></i> Simpan Pemeriksaan
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>

@push('styles')
<style>
    /* jQuery Drawpad Styles */
    .drawpad * { box-sizing: border-box; }
    .drawpad { background-color: #fff; position: relative; cursor: crosshair; }
    .drawpad.drawpad-dashed { border: 2px dashed #cbd5e1; background-color: #f8fafc; overflow: hidden; border-radius: 0.5rem; }
    .drawpad > canvas { width: 100%; height: 100%; touch-action: none; }
    .drawpad .drawpad-toolbox {
        width: 32px; right: 8px; top: 8px; position: absolute; z-index: 20;
        display: flex; height: calc(100% - 16px); flex-direction: column;
        transition: all 0.2s;
    }
    .drawpad .drawpad-colors { display: flex; flex-direction: column; gap: 6px; }
    .drawpad .drawpad-colorbox { 
        width: 24px; height: 24px; border: 2px solid #fff; cursor: pointer; 
        border-radius: 50%; box-shadow: 0 2px 4px rgba(0,0,0,0.2); 
        transition: transform 0.1s;
    }
    .drawpad .drawpad-colorbox:hover { transform: scale(1.2); }
    .drawpad .drawpad-colorbox.drawpad-colorbox-active { 
        border: 2px solid #3b82f6;
        box-shadow: 0 0 0 2px #fff, 0 0 0 4px #3b82f6;
    }
    .drawpad .drawpad-eraser { 
        background-color: #fff; border: 1px dashed #94a3b8; 
        display: flex; align-items: center; justify-content: center; 
        position: relative; font-size: 12px; font-weight: bold; color: #64748b;
    }
    .drawpad .drawpad-eraser::after { content: 'E'; }
    
    .signature-container canvas {
        display: block;
    }
</style>
@endpush

@push('scripts')
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script>
    /* 
        jquery-drawpad.js implementation 
        (Inlined to ensure it works without external file management issues)
    */
    (function ($) {
        const pluginSuffix = "drawpad";
        $.drawpad = function (element, options) {
            let defaults = {
                defaultColor: "#000000",
                colors: ["#000000", "#e74c3c", "#3498db"],
                eraserSize: 15,
            };
            let plugin = this;
            let $element = $(element);
            plugin.settings = {};
            const coordinate = { x: 0, y: 0 };
            let drawing = false;
            let drawingType = "pen";
            let lineStyle = { width: 2, color: "#000000", type: "round" };
            
            // Undo/Redo states
            let history = [];
            let historyIndex = -1;

            const saveState = () => {
                const state = plugin.canvas.toDataURL();
                // If we're not at the end of history, discard future states
                if (historyIndex < history.length - 1) {
                    history = history.slice(0, historyIndex + 1);
                }
                history.push(state);
                historyIndex++;
                // Limit history size to 20 steps
                if (history.length > 20) {
                    history.shift();
                    historyIndex--;
                }
            };

            const loadState = (index) => {
                const img = new Image();
                img.onload = function() {
                    plugin.context.clearRect(0, 0, plugin.canvas.width, plugin.canvas.height);
                    plugin.context.drawImage(img, 0, 0);
                };
                img.src = history[index];
            };

            const createCanvas = () => {
                plugin.$canvas = $("<canvas></canvas>");
                plugin.canvas = plugin.$canvas.get(0);
                plugin.context = plugin.canvas.getContext("2d");
                return plugin.$canvas;
            };
            const resizeCanvas = () => {
                const rect = $element[0].getBoundingClientRect();
                const tempState = plugin.canvas.toDataURL();
                plugin.canvas.width = rect.width;
                plugin.canvas.height = rect.height;
                // Redraw after resize if there was content
                const img = new Image();
                img.onload = () => plugin.context.drawImage(img, 0, 0);
                img.src = tempState;
            };
            const createToolbox = () => {
                const $toolbox = $(`<div class="${pluginSuffix}-toolbox"></div>`);
                const $colors = $(`<div class="${pluginSuffix}-colors"></div>`);
                plugin.settings.colors.forEach((color) => {
                    let $cb = $(`<div class="${pluginSuffix}-colorbox" style="background-color:${color};"></div>`);
                    if (color === plugin.settings.defaultColor) $cb.addClass(`${pluginSuffix}-colorbox-active`);
                    $cb.click(() => {
                        drawingType = "pen";
                        lineStyle.color = color;
                        $cb.addClass(`${pluginSuffix}-colorbox-active`).siblings().removeClass(`${pluginSuffix}-colorbox-active`);
                    });
                    $colors.append($cb);
                });
                const $eraser = $(`<div class="${pluginSuffix}-colorbox ${pluginSuffix}-eraser"></div>`);
                $eraser.click(() => {
                    drawingType = "eraser";
                    $eraser.addClass(`${pluginSuffix}-colorbox-active`).siblings().removeClass(`${pluginSuffix}-colorbox-active`);
                });
                $colors.append($eraser);
                $toolbox.append($colors);
                return $toolbox;
            };

            const updateCoordinate = (event) => {
                const rect = plugin.canvas.getBoundingClientRect();
                coordinate.x = (event.clientX || event.touches[0].clientX) - rect.left;
                coordinate.y = (event.clientY || event.touches[0].clientY) - rect.top;
            };

            const handleStartDraw = (event) => {
                drawing = true;
                updateCoordinate(event);
                plugin.context.beginPath();
                plugin.context.moveTo(coordinate.x, coordinate.y);
                event.preventDefault();
            };
            const handleStopDraw = () => { 
                if (drawing) {
                    drawing = false; 
                    saveState();
                }
            };
            const handleDraw = (event) => {
                if (!drawing) return;
                const ctx = plugin.context;
                ctx.globalCompositeOperation = drawingType === "pen" ? "source-over" : "destination-out";
                ctx.lineWidth = drawingType === "pen" ? lineStyle.width : plugin.settings.eraserSize;
                ctx.lineCap = lineStyle.type;
                ctx.lineJoin = lineStyle.type;
                ctx.strokeStyle = lineStyle.color;
                updateCoordinate(event);
                ctx.lineTo(coordinate.x, coordinate.y);
                ctx.stroke();
                event.preventDefault();
            };

            plugin.init = function () {
                plugin.settings = $.extend({}, defaults, options);
                lineStyle.color = plugin.settings.defaultColor;
                $element.addClass(pluginSuffix).append(createCanvas()).append(createToolbox());
                resizeCanvas();
                saveState(); // Initial empty state
                plugin.$canvas.on("mousedown touchstart", handleStartDraw);
                $(window).on("mouseup touchend", handleStopDraw);
                plugin.$canvas.on("mousemove touchmove", handleDraw);
                $(window).on('resize', resizeCanvas);
            };
            plugin.clear = function () {
                plugin.context.clearRect(0, 0, plugin.canvas.width, plugin.canvas.height);
                saveState();
            };
            plugin.undo = function () {
                if (historyIndex > 0) {
                    historyIndex--;
                    loadState(historyIndex);
                }
            };
            plugin.redo = function () {
                if (historyIndex < history.length - 1) {
                    historyIndex++;
                    loadState(historyIndex);
                }
            };
            plugin.load = function (base64) {
                const img = new Image();
                img.onload = function() {
                    plugin.context.clearRect(0, 0, plugin.canvas.width, plugin.canvas.height);
                    plugin.context.drawImage(img, 0, 0);
                    saveState();
                };
                img.src = base64;
            };
            plugin.init();
        };
        $.fn.drawpad = function (options) {
            return this.each(function() {
                if (!$(this).data(pluginSuffix)) {
                    $(this).data(pluginSuffix, new $.drawpad(this, options));
                }
            });
        };
    })(jQuery);

    function loadSignature(padId, base64) {
        if (!base64 || base64.length < 100) return;
        $(`#${padId}`).data('drawpad').load(base64);
    }

    // Initialize Pads
    $(function() {
        $('#pad-hasil-dokter').drawpad();
        $('#pad-hasil-pasien').drawpad();
        $('#pad-resep-dokter').drawpad();
        $('#pad-resep-apoteker').drawpad();

        // Give it a moment to initialize and resize
        setTimeout(() => {
            loadSignature('pad-hasil-dokter', @js($sig_hasil_dokter));
            loadSignature('pad-hasil-pasien', @js($sig_hasil_pasien));
            loadSignature('pad-resep-dokter', @js($sig_resep_dokter));
            loadSignature('pad-resep-apoteker', @js($sig_resep_apoteker));
        }, 500);
    });

    window.clearPad = function(id) {
        $(`#${id}`).data('drawpad').clear();
    };

    window.undoPad = function(id) {
        $(`#${id}`).data('drawpad').undo();
    };

    window.redoPad = function(id) {
        $(`#${id}`).data('drawpad').redo();
    };

    // Capture signatures before submit
    document.addEventListener('livewire:initialized', () => {
        window.addEventListener('capture-signatures', () => {
            const signatures = {
                'sig_hasil_dokter': $('#pad-hasil-dokter canvas')[0].toDataURL(),
                'sig_hasil_pasien': $('#pad-hasil-pasien canvas')[0].toDataURL(),
                'sig_resep_dokter': $('#pad-resep-dokter canvas')[0].toDataURL(),
                'sig_resep_apoteker': $('#pad-resep-apoteker canvas')[0].toDataURL()
            };
            
            @this.setSignatures(signatures);
        });
    });
</script>
@endpush

