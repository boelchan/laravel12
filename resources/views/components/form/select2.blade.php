<fieldset class="fieldset w-full" x-data="select2Keyboard($refs.originalSelect, @entangle($model){{ @$live ? '.live' : '' }})" @click.outside="open = false">
    @if ($label)
        <legend class="fieldset-legend">{{ $label }}
            @if ($required)
                <span class="text-red-500">*</span>
            @endif
        </legend>
    @endif

    <select x-ref="originalSelect" class="hidden">
        @foreach ($options as $key => $value)
            <option value="{{ $key }}" @selected($model == $key)>{{ $value }}</option>
        @endforeach
    </select>

    {{-- UI --}}
    <div class="select w-full cursor-pointer" @click="toggleOpen()" @keydown="onKey($event)" tabindex="0">
        <span x-text="selectedLabel ?? 'Pilih'" :class="selectedLabel ? '' : 'text-gray-400'"></span>
    </div>

    {{-- DROPDOWN --}}
    <div class="relative">
        <div x-show="open" x-transition class="absolute w-full bg-base-100 border border-gray-300 rounded shadow-lg z-50" @keydown.stop="onKey($event)">

            {{-- SEARCH --}}
            <div class="border-b border-gray-300 px-3 flex items-center">
                <i class="ti ti-search text-lg text-gray-500"></i>
                <input type="text" x-model="search" x-ref="searchInput" class="h-9 w-full px-2 text-sm outline-hidden" placeholder="Cari..." />
            </div>

            {{-- LIST --}}
            <div class="max-h-60 overflow-y-auto p-2" x-ref="listBox">
                <template x-for="(opt,idx) in filteredOptions" :key="opt.value">
                    <div class="flex items-center px-1 py-2 cursor-pointer rounded" :class="highlightIndex == idx ? 'bg-base-300' : 'hover:bg-base-200'" @mouseenter="highlightIndex = idx" @click="choose(opt.value)" :data-index="idx">
                        <div class="w-6 flex justify-center">
                            <template x-if="opt.value == selectedValue">
                                <i class="ti ti-check text-lg"></i>
                            </template>
                        </div>

                        <span class="text-sm" x-text="opt.label"></span>
                    </div>
                </template>
            </div>

        </div>
    </div>

    <x-form.error :name="$model" />

</fieldset>

<script>
    function select2Keyboard(selectEl, livewireModel) {
        return {
            open: false,
            search: "",
            highlightIndex: 0,

            // entangled Livewire value
            selectedValue: livewireModel,
            selectedLabel: null,

            options: [],

            init() {
                // load awal
                this.reloadOptions();
                // // load options from the select element
                // this.options = [...selectEl.options].map(o => ({
                //     value: o.value,
                //     label: o.text
                // }));

                // // initial label
                // const initOpt = this.options.find(o => o.value == this.selectedValue);
                // this.selectedLabel = initOpt?.label ?? null;

                // watch Livewire-entangled value
                this.$watch('selectedValue', () => {
                    const found = this.options.find(o => o.value == this.selectedValue);
                    this.selectedLabel = found?.label ?? null;
                });
                // === OBSERVER UNTUK UPDATE DARI LIVEWIRE ===
                const observer = new MutationObserver(() => {
                    // ketika livewire update <select>, reload semua option
                    this.reloadOptions();
                });

                // observe perubahan child list <select>
                observer.observe(selectEl, {
                    childList: true,
                    subtree: true
                });


            },

            reloadOptions() {
                // ambil ulang options dari tag <select>
                this.options = [...selectEl.options].map(o => ({
                    value: o.value,
                    label: o.text
                }));

                // update selected label
                const found = this.options.find(o => o.value == this.selectedValue);
                this.selectedLabel = found?.label ?? null;
            },


            // open/close dropdown and scroll logic
            toggleOpen() {
                this.open = !this.open;

                if (this.open) {
                    this.search = "";
                    this.setInitialHighlight();

                    this.$nextTick(() => {
                        if (this.$refs.searchInput) this.$refs.searchInput.focus();
                        // scroll to highlighted item or top
                        this.scrollToHighlightOrTop();
                    });
                }
            },

            setInitialHighlight() {
                // find index in filteredOptions (so respects search)
                const idx = this.filteredOptions.findIndex(o => o.value == this.selectedValue);
                this.highlightIndex = idx >= 0 ? idx : 0;
                // ensure highlightIndex not out of bounds
                if (this.highlightIndex > this.filteredOptions.length - 1) {
                    this.highlightIndex = Math.max(0, this.filteredOptions.length - 1);
                }
            },

            // computed-like getter for filtered options
            get filteredOptions() {
                const q = (this.search || "").toLowerCase();
                return this.options.filter(o => o.label.toLowerCase().includes(q));
            },

            choose(value) {
                this.selectedValue = value; // entangled -> Livewire updated automatically
                this.open = false;
            },

            // robust scroll: find element by data-index
            scrollToHighlightOrTop() {
                this.$nextTick(() => {
                    const list = this.$refs.listBox;
                    if (!list) return;

                    // ensure highlightIndex within bounds
                    const maxIdx = this.filteredOptions.length - 1;
                    if (this.highlightIndex < 0) this.highlightIndex = 0;
                    if (this.highlightIndex > maxIdx) this.highlightIndex = maxIdx;

                    // find element using data-index attr
                    const sel = list.querySelector(`[data-index="${this.highlightIndex}"]`);

                    if (sel) {
                        // scroll element into view nearest
                        sel.scrollIntoView({
                            block: 'nearest'
                        });
                    } else {
                        // fallback: scroll to top
                        list.scrollTop = 0;
                    }
                });
            },

            // keyboard support
            onKey(e) {
                if (!this.open && ['ArrowDown', 'ArrowUp', 'Enter'].includes(e.key)) {
                    this.toggleOpen();
                    return;
                }

                if (e.key === 'ArrowDown') {
                    if (this.highlightIndex < this.filteredOptions.length - 1) {
                        this.highlightIndex++;
                        this.scrollToHighlightOrTop();
                    }
                }

                if (e.key === 'ArrowUp') {
                    if (this.highlightIndex > 0) {
                        this.highlightIndex--;
                        this.scrollToHighlightOrTop();
                    }
                }

                if (e.key === 'Enter') {
                    e.preventDefault(); // ⛔ cegah form submit
                    e.stopPropagation(); // ⛔ cegah bubbling
                    const item = this.filteredOptions[this.highlightIndex];
                    if (item) this.choose(item.value);
                }

                if (e.key === 'Escape') {
                    this.open = false;
                }
            }
        }
    }
</script>
