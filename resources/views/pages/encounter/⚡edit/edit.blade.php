<div>
    <h1 class="text-2xl font-medium tracking-tight text-slate-900">Encounter / Kunjungan Pasien</h1>
    <div class="breadcrumbs p-0 text-xs text-slate-500">
        <ul>
            <li><a href="{{ route('dashboard') }}"><i class="ti ti-home"></i></a></li>
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
                    <div class="card overflow-hidden border border-slate-200 bg-white shadow-sm">
                        <div class="border-b border-slate-200 bg-slate-50 px-6 py-4">
                            <h2 class="flex items-center gap-2 text-lg font-semibold text-slate-800">
                                <i class="ti ti-heart-rate-monitor text-primary text-xl"></i> TTV (Tanda Vital)
                            </h2>
                        </div>
                        <div class="card-body space-y-4 p-6">
                            <div class="grid grid-cols-2 gap-4">
                                <x-input type="number" wire:model="systolic" label="Systolic" suffix="mmHg" />
                                <x-input type="number" wire:model="diastolic" label="Diastolic" suffix="mmHg" />
                            </div>
                            <div class="grid grid-cols-2 gap-4">
                                <x-input type="number" wire:model="body_temperature" label="Suhu Tubuh" suffix="°C" />
                            </div>
                        </div>
                    </div>

                    {{-- ANTROPOMETRI CARD --}}
                    <div class="card overflow-hidden border border-slate-200 bg-white shadow-sm">
                        <div class="border-b border-slate-200 bg-slate-50 px-6 py-4">
                            <h2 class="flex items-center gap-2 text-lg font-semibold text-slate-800">
                                <i class="ti ti-ruler-2 text-primary text-xl"></i> Antropometri
                            </h2>
                        </div>
                        <div class="card-body space-y-4 p-6" x-data="{
                            body_weight: @entangle('body_weight'),
                            body_height: @entangle('body_height'),
                            get imt() {
                                if (this.body_weight && this.body_height) {
                                    let tbM = this.body_height / 100;
                                    return (this.body_weight / (tbM * tbM)).toFixed(2);
                                }
                                return '-';
                            }
                        }">
                            <div class="grid grid-cols-2 gap-4">
                                <x-input x-model="body_weight" label="Berat Badan" suffix="kg" />
                                <x-input x-model="body_height" label="Tinggi Badan" suffix="cm" />
                            </div>
                            <div class="mt-2 rounded-xl border border-blue-100 bg-blue-50 p-4">
                                <p class="text-xs font-medium uppercase tracking-wider text-blue-600">Indeks Massa Tubuh (IMT)</p>
                                <div class="flex items-baseline gap-2">
                                    <span class="text-3xl font-bold text-blue-800" x-text="imt"></span>
                                    <span class="text-sm font-medium text-blue-600">kg/m²</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- RIGHT COLUMN: HASIL & RESEP --}}
                <div class="space-y-6 lg:col-span-8">
                    {{-- HASIL PEMERIKSAAN CARD --}}
                    <div class="card overflow-hidden border border-slate-200 bg-white text-slate-800 shadow-sm">
                        <div class="border-b border-slate-200 bg-slate-50 px-6 py-4">
                            <h2 class="flex items-center gap-2 text-lg font-semibold text-slate-800">
                                <i class="ti ti-notes text-primary text-xl"></i> Hasil Pemeriksaan
                            </h2>
                        </div>
                        <div class="card-body space-y-6 p-6">
                            <x-textarea wire:model="hasil_text" label="Catatan / Hasil" rows="4"
                                placeholder="Masukkan hasil pemeriksaan..."
                            />

                            <div class="grid grid-cols-1 gap-6 ">
                                @foreach($hasil_signatures as $index => $sig)
                                    <div class="space-y-2" wire:key="hasil-sig-{{ $index }}">
                                        <label class="block text-sm font-medium text-slate-700">Hasil {{ $index + 1 }}</label>
                                        <div class="signature-container relative" wire:ignore>
                                            <div class="drawpad-dashed h-52 w-full rounded-xl border-2 border-dashed border-slate-300 bg-slate-50 shadow-inner signature-pad"
                                                id="hasil_signature_{{ $index + 1 }}"
                                                data-type="hasil"
                                                data-index="{{ $index }}"
                                            ></div>
                                            <div class="absolute bottom-3 right-3 flex gap-2">
                                                <button
                                                    class="btn btn-xs h-8 border-slate-200 bg-white/90 px-2 text-slate-700 shadow-sm backdrop-blur hover:bg-white"
                                                    type="button" title="Undo" onclick="undoPad('hasil_signature_{{ $index + 1 }}')"
                                                >
                                                    <i class="ti ti-arrow-back-up text-base"></i> <span class="hidden sm:inline">Undo</span>
                                                </button>
                                                <button
                                                    class="btn btn-xs h-8 border-slate-200 bg-white/90 px-2 text-slate-700 shadow-sm backdrop-blur hover:bg-white"
                                                    type="button" title="Redo" onclick="redoPad('hasil_signature_{{ $index + 1 }}')"
                                                >
                                                    <i class="ti ti-arrow-forward-up text-base"></i> <span class="hidden sm:inline">Redo</span>
                                                </button>
                                                <button
                                                    class="btn btn-xs h-8 border-red-100 bg-red-50/90 px-2 text-red-600 shadow-sm backdrop-blur hover:bg-red-100"
                                                    type="button" title="Bersihkan" onclick="clearPad('hasil_signature_{{ $index + 1 }}')"
                                                >
                                                    <i class="ti ti-trash text-base"></i> <span class="hidden sm:inline">Bersihkan</span>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                            <div class="mt-4 flex justify-end">
                                <button type="button" class="btn btn-sm btn-outline btn-primary" wire:click="addSignature('hasil')">
                                    <i class="ti ti-plus"></i> Tambah Signature
                                </button>
                            </div>
                        </div>
                    </div>

                    {{-- RESEP CARD --}}
                    <div class="card overflow-hidden border border-slate-200 bg-white text-slate-800 shadow-sm">
                        <div class="border-b border-slate-200 bg-slate-50 px-6 py-4">
                            <h2 class="flex items-center gap-2 text-lg font-semibold text-slate-800">
                                <i class="ti ti-prescription text-primary text-xl"></i> Resep Obat
                            </h2>
                        </div>
                        <div class="card-body space-y-6 p-6">
                            <x-textarea wire:model="resep_text" label="Daftar Terapi / Obat" rows="4" placeholder="R/ ..." />

                            <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
                                @foreach($resep_signatures as $index => $sig)
                                    <div class="space-y-2" wire:key="resep-sig-{{ $index }}">
                                        <label class="block text-sm font-medium text-slate-700">Resep {{ $index + 1 }}</label>
                                        <div class="signature-container relative" wire:ignore>
                                            <div class="drawpad-dashed h-52 w-full rounded-xl border-2 border-dashed border-slate-300 bg-slate-50 shadow-inner signature-pad"
                                                id="resep_signature_{{ $index + 1 }}"
                                                data-type="resep"
                                                data-index="{{ $index }}"
                                            ></div>
                                            <div class="absolute bottom-3 right-3 flex gap-2">
                                                <button
                                                    class="btn btn-xs h-8 border-slate-200 bg-white/90 px-2 text-slate-700 shadow-sm backdrop-blur hover:bg-white"
                                                    type="button" title="Undo" onclick="undoPad('resep_signature_{{ $index + 1 }}')"
                                                >
                                                    <i class="ti ti-arrow-back-up text-base"></i> <span class="hidden sm:inline">Undo</span>
                                                </button>
                                                <button
                                                    class="btn btn-xs h-8 border-slate-200 bg-white/90 px-2 text-slate-700 shadow-sm backdrop-blur hover:bg-white"
                                                    type="button" title="Redo" onclick="redoPad('resep_signature_{{ $index + 1 }}')"
                                                >
                                                    <i class="ti ti-arrow-forward-up text-base"></i> <span class="hidden sm:inline">Redo</span>
                                                </button>
                                                <button
                                                    class="btn btn-xs h-8 border-red-100 bg-red-50/90 px-2 text-red-600 shadow-sm backdrop-blur hover:bg-red-100"
                                                    type="button" title="Bersihkan" onclick="clearPad('resep_signature_{{ $index + 1 }}')"
                                                >
                                                    <i class="ti ti-trash text-base"></i> <span class="hidden sm:inline">Bersihkan</span>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                            <div class="mt-4 flex justify-end">
                                <button type="button" class="btn btn-sm btn-outline btn-primary" wire:click="addSignature('resep')">
                                    <i class="ti ti-plus"></i> Tambah Signature
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="mt-10 flex items-center justify-between border-t border-slate-200 pt-6">
                <p class="text-sm italic text-slate-500">Pastikan semua data pemeriksaan telah terisi dengan benar.</p>
                <div class="flex gap-3">
                    <a class="btn btn-soft btn-secondary" href="{{ route('encounter.index') }}" wire:navigate>Batal</a>
                    <button
                        class="btn btn-primary"
                        type="button"
                        x-on:click="$dispatch('capture-signatures')"
                    >
                        <i class="ti ti-check"></i> Simpan Pemeriksaan
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>

@push('styles')
    <style>
        /* jQuery Drawpad Styles */
        .drawpad * {
            box-sizing: border-box;
        }

        .drawpad {
            background-color: #fff;
            position: relative;
            cursor: crosshair;
        }

        .drawpad.drawpad-dashed {
            border: 2px dashed #cbd5e1;
            background-color: #f8fafc;
            overflow: hidden;
            border-radius: 0.5rem;
        }

        .drawpad>canvas {
            width: 100%;
            height: 100%;
            touch-action: none;
        }

        .drawpad .drawpad-toolbox {
            width: 32px;
            right: 8px;
            top: 8px;
            position: absolute;
            z-index: 20;
            display: flex;
            height: calc(100% - 16px);
            flex-direction: column;
            transition: all 0.2s;
        }

        .drawpad .drawpad-colors {
            display: flex;
            flex-direction: column;
            gap: 6px;
        }

        .drawpad .drawpad-colorbox {
            width: 24px;
            height: 24px;
            border: 2px solid #fff;
            cursor: pointer;
            border-radius: 50%;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.2);
            transition: transform 0.1s;
        }

        .drawpad .drawpad-colorbox:hover {
            transform: scale(1.2);
        }

        .drawpad .drawpad-colorbox.drawpad-colorbox-active {
            border: 2px solid #3b82f6;
            box-shadow: 0 0 0 2px #fff, 0 0 0 4px #3b82f6;
        }

        .drawpad .drawpad-eraser {
            background-color: #fff;
            border: 1px dashed #94a3b8;
            display: flex;
            align-items: center;
            justify-content: center;
            position: relative;
            font-size: 12px;
            font-weight: bold;
            color: #64748b;
        }

        .drawpad .drawpad-eraser::after {
            content: 'E';
        }

        .signature-container canvas {
            display: block;
            width: 100% !important;
            height: 100% !important;
        }

        .drawpad-dashed {
            background-image:
                linear-gradient(45deg, #f1f5f9 25%, transparent 25%),
                linear-gradient(-45deg, #f1f5f9 25%, transparent 25%),
                linear-gradient(45deg, transparent 75%, #f1f5f9 75%),
                linear-gradient(-45deg, transparent 75%, #f1f5f9 75%);
            background-size: 20px 20px;
            background-position: 0 0, 0 10px, 10px -10px, -10px 0px;
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
        (function($) {
            const pluginSuffix = "drawpad";
            $.drawpad = function(element, options) {
                let defaults = {
                    defaultColor: "#000000",
                    colors: ["#000000", "#e74c3c", "#3498db"],
                    eraserSize: 15,
                };
                let plugin = this;
                let $element = $(element);
                plugin.settings = {};
                const coordinate = {
                    x: 0,
                    y: 0
                };
                let drawing = false;
                let drawingType = "pen";
                let lineStyle = {
                    width: 2,
                    color: "#000000",
                    type: "round"
                };

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
                    // Limit history size to 30 steps
                    if (history.length > 30) {
                        history.shift();
                        historyIndex--;
                    }
                };

                const loadState = (index) => {
                    const img = new Image();
                    img.onload = function() {
                        const ratio = 3; // Match ratio in resizeCanvas
                        plugin.context.setTransform(1, 0, 0, 1, 0, 0);
                        plugin.context.clearRect(0, 0, plugin.canvas.width, plugin.canvas.height);
                        plugin.context.drawImage(img, 0, 0, plugin.canvas.width, plugin.canvas.height);
                        plugin.context.setTransform(ratio, 0, 0, ratio, 0, 0);
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
                    if (rect.width === 0 || rect.height === 0) return;

                    const ratio = 3; // High resolution multiplier
                    const tempState = historyIndex >= 0 ? plugin.canvas.toDataURL() : null;

                    plugin.canvas.width = rect.width * ratio;
                    plugin.canvas.height = rect.height * ratio;

                    plugin.context.setTransform(ratio, 0, 0, ratio, 0, 0);

                    if (tempState) {
                        const img = new Image();
                        img.onload = () => {
                            // Reset transform before drawing to match actual pixels
                            plugin.context.setTransform(1, 0, 0, 1, 0, 0);
                            plugin.context.drawImage(img, 0, 0, plugin.canvas.width, plugin.canvas.height);
                            // Restore transform for subsequent drawing
                            plugin.context.setTransform(ratio, 0, 0, ratio, 0, 0);
                        };
                        img.src = tempState;
                    }
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
                            $cb.addClass(`${pluginSuffix}-colorbox-active`).siblings().removeClass(
                                `${pluginSuffix}-colorbox-active`);
                        });
                        $colors.append($cb);
                    });
                    const $eraser = $(`<div class="${pluginSuffix}-colorbox ${pluginSuffix}-eraser"></div>`);
                    $eraser.click(() => {
                        drawingType = "eraser";
                        $eraser.addClass(`${pluginSuffix}-colorbox-active`).siblings().removeClass(
                            `${pluginSuffix}-colorbox-active`);
                    });
                    $colors.append($eraser);
                    $toolbox.append($colors);
                    return $toolbox;
                };

                const updateCoordinate = (event) => {
                    const rect = plugin.canvas.getBoundingClientRect();
                    const clientX = (event.clientX !== undefined) ? event.clientX : (event.touches ? event.touches[0].clientX : 0);
                    const clientY = (event.clientY !== undefined) ? event.clientY : (event.touches ? event.touches[0].clientY : 0);
                    coordinate.x = clientX - rect.left;
                    coordinate.y = clientY - rect.top;
                };

                const handleStartDraw = (event) => {
                    drawing = true;
                    updateCoordinate(event);
                    plugin.context.beginPath();
                    plugin.context.moveTo(coordinate.x, coordinate.y);
                    // No event.preventDefault() here to allow scrolling if needed, or keep it for better drawing
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
                    ctx.lineWidth = drawingType === "pen" ? 2.5 : plugin.settings.eraserSize;
                    ctx.lineCap = "round";
                    ctx.lineJoin = "round";
                    ctx.strokeStyle = lineStyle.color;
                    updateCoordinate(event);
                    ctx.lineTo(coordinate.x, coordinate.y);
                    ctx.stroke();
                    event.preventDefault(); // Prevent scrolling while drawing
                };

                plugin.init = function() {
                    plugin.settings = $.extend({}, defaults, options);
                    lineStyle.color = plugin.settings.defaultColor;
                    $element.addClass(pluginSuffix).append(createCanvas()).append(createToolbox());
                    
                    // Use ResizeObserver for more robust sizing
                    setTimeout(resizeCanvas, 50); // Initial resize
                    
                    const ro = new ResizeObserver(() => {
                        resizeCanvas();
                    });
                    ro.observe($element[0]);

                    saveState(); // Initial empty state
                    plugin.$canvas.on("mousedown touchstart", handleStartDraw);
                    $(window).on("mouseup touchend", handleStopDraw);
                    plugin.$canvas.on("mousemove touchmove", handleDraw);
                };
                plugin.clear = function() {
                    plugin.context.clearRect(0, 0, plugin.canvas.width, plugin.canvas.height);
                    saveState();
                };
                plugin.undo = function() {
                    if (historyIndex > 0) {
                        historyIndex--;
                        loadState(historyIndex);
                    }
                };
                plugin.redo = function() {
                    if (historyIndex < history.length - 1) {
                        historyIndex++;
                        loadState(historyIndex);
                    }
                };
                plugin.load = function(base64) {
                    const img = new Image();
                    img.onload = function() {
                        const rect = $element[0].getBoundingClientRect();
                        plugin.context.clearRect(0, 0, plugin.canvas.width, plugin.canvas.height);
                        
                        // Reset transform to draw the high-res image 1:1 to canvas pixels
                        plugin.context.setTransform(1, 0, 0, 1, 0, 0);
                        plugin.context.drawImage(img, 0, 0, plugin.canvas.width, plugin.canvas.height);
                        
                        // Restore scaling transform (ratio = 3 as defined in resizeCanvas)
                        plugin.context.setTransform(3, 0, 0, 3, 0, 0);
                        
                        saveState();
                    };
                    img.src = base64;
                };
                plugin.init();
            };
            $.fn.drawpad = function(options) {
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


        function initAllPads() {
            // Slight delay to ensure DOM is settled
            setTimeout(() => {
                $('.signature-pad').each(function() {
                    const $pad = $(this);
                    const id = $pad.attr('id');
                    const type = $pad.data('type');
                    const index = $pad.data('index');
                    
                    if (!$pad.data('drawpad')) {
                        $pad.drawpad();
                        
                        // Access the current signatures from JS arrays (updated on render)
                        const sigData = type === 'hasil' ? 
                            @js($hasil_signatures)[index] : 
                            @js($resep_signatures)[index];
                            
                        if (sigData && sigData.length > 100) {
                            setTimeout(() => loadSignature(id, sigData), 150);
                        }
                    }
                });
            }, 50);
        }

        // Initialize Pads on load
        $(function() {
            initAllPads();
        });

        // Use standard Livewire hooks if available
        document.addEventListener('livewire:initialized', () => {
            Livewire.hook('morph.updated', (el, component) => {
                initAllPads();
            });
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
                const hasilSigs = [];
                const resepSigs = [];

                $('.signature-pad').each(function() {
                    const $pad = $(this);
                    const type = $pad.data('type');
                    const canvas = $pad.find('canvas')[0];
                    const dataUrl = canvas.toDataURL();

                    if (type === 'hasil') {
                        hasilSigs.push(dataUrl);
                    } else {
                        resepSigs.push(dataUrl);
                    }
                });

                @this.setSignatures({
                    'hasil': hasilSigs,
                    'resep': resepSigs
                });
            });
        });
    </script>
@endpush
