@props([
    'label' => '',
    'model' => '',
    'required' => false,
    'class' => '',
    'height' => '100px',     // default tinggi editor
    'editorClass' => 'mb-10', // default margin bottom
])

<fieldset class="fieldset">
    <legend class="fieldset-legend">
        {{ $label }}
        @if ($required)
            <span class="text-red-500">*</span>
        @endif
    </legend>

    <div
        x-data="{
            value: @entangle($model),
            quill: null
        }"
        x-init="
            quill = new Quill($refs.editor, {
                theme: 'snow',
                modules: {
                    toolbar: [
                        ['bold', 'italic', 'underline', 'strike'],
                        [{ list: 'ordered' }, { list: 'bullet' }],
                        ['clean']
                    ]
                }
            });

            quill.root.innerHTML = value ?? '';

            quill.on('text-change', () => {
                value = quill.root.innerHTML;
            });

            $watch('value', (html) => {
                if (quill.root.innerHTML !== html) {
                    quill.root.innerHTML = html ?? '';
                }
            });
        "
        class="relative {{ $editorClass }}"
    >
        <div
            x-ref="editor"
            class="bg-white border rounded-md"
            style="min-height: {{ $height }};"
        ></div>
    </div>

    <x-form.error :name="$model" />
</fieldset>
