@extends('admin.layouts.app')
@push('tiptapscript')
<script src="https://cdn.jsdelivr.net/npm/@editorjs/editorjs@2.28.2"></script>

<script src="https://cdn.jsdelivr.net/npm/@editorjs/header@2.8.1"></script>
<script src="https://cdn.jsdelivr.net/npm/@editorjs/list@1.10.0"></script>
<script src="https://cdn.jsdelivr.net/npm/@editorjs/paragraph@2.11.3"></script>
<script src="https://cdn.jsdelivr.net/npm/@editorjs/quote@2.6.0"></script>
<script src="https://cdn.jsdelivr.net/npm/@editorjs/table@2.3.0"></script>
<script src="https://cdn.jsdelivr.net/npm/@editorjs/checklist@1.6.0"></script>
<script src="https://cdn.jsdelivr.net/npm/@editorjs/delimiter@1.4.0"></script>
<script src="https://cdn.jsdelivr.net/npm/@editorjs/image@2.9.0"></script>
<link href="https://cdn.jsdelivr.net/npm/tom-select/dist/css/tom-select.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/tom-select/dist/js/tom-select.complete.min.js"></script>

@endpush
@section('content')
<div class="min-h-screen flex items-center justify-center p-4 md:p-8">
    <div class="w-full max-w-[850px] bg-white rounded-[24px] p-8 md:p-12 flex flex-col gap-12">
        <!-- Header -->
        <div class="flex justify-between items-center">
            <h1 class="text-[22px] font-bold text-[#0A1629] font-nunito">
                Create New Blog Post
            </h1>
            <a href="{{ route('admin.blogs.index') }}" class="flex items-center gap-3 h-12 px-4 rounded-[14px] bg-blue-500 text-white shadow-[0_6px_12px_0_rgba(63,140,255,0.26)] hover:bg-blue-600 transition-colors">
                <span class="text-base font-bold">See All Blog Posts</span>
            </a>
        </div>

        <!-- Form -->
        <form action="{{ route('admin.blogs.store') }}" method="POST" enctype="multipart/form-data" class="flex flex-col gap-12">
            @csrf

            <!-- Image Banner -->
            <div class="flex flex-col gap-[10px]">
                <label class="text-sm font-bold text-[#7D8592] font-nunito leading-6">
                    Image Banner (Optional)
                </label>

                <label class="relative h-[300px] md:h-[400px] w-full rounded-[14px] overflow-hidden border border-[#D8E0F0] cursor-pointer hover:bg-[#F8FAFB] transition-colors">
                    <input type="file" accept="image/*" name="image" id="imageInput" class="hidden" onchange="previewImage(event)" />

                    <!-- Default placeholder -->
                    <div id="defaultIconContainer" class="absolute inset-0 flex items-center justify-center bg-gray-100 text-gray-400 transition-opacity duration-300">
                        <svg width="48" height="48" viewBox="0 0 24 24" fill="none" class="mb-2">
                            <path d="M19 3H5C3.89543 3 3 3.89543 3 5V19C3 20.1046 3.89543 21 5 21H19C20.1046 21 21 20.1046 21 19V5C21 3.89543 20.1046 3 19 3Z" stroke="currentColor" stroke-width="2" />
                            <path d="M8.5 10C9.32843 10 10 9.32843 10 8.5C10 7.67157 9.32843 7 8.5 7C7.67157 7 7 7.67157 7 8.5C7 9.32843 7.67157 10 8.5 10Z" stroke="currentColor" stroke-width="2" />
                            <path d="M21 15L16 10L5 21" stroke="currentColor" stroke-width="2" />
                        </svg>
                        <p class="text-lg font-semibold">No image selected</p>
                    </div>

                    <!-- Preview image -->
                    <img id="imagePreview" src="#" alt="Preview" class="w-full h-full object-cover object-center transition-transform duration-500 hover:scale-105 hidden" />
                </label>
            </div>

            <!-- Title -->
            <div class="flex flex-col gap-[10px]">
                <label class="text-sm font-bold text-[#7D8592] font-nunito leading-6">Title</label>
                <input type="text" name="title" placeholder="Update Blog Post Title" class="h-[54px] px-[13px] rounded-[14px] border border-[#D8E0F0] bg-white text-sm text-[#7D8592] focus:outline-none focus:border-[#3F8CFF]" required />
            </div>
            <!-- Categories -->
            <div class="flex flex-col gap-[10px]">
                <label class="text-sm font-bold text-[#7D8592] font-nunito leading-6">
                    Categories
                </label>

                <select id="categories" name="categories[]" multiple class="rounded-[14px] border border-[#D8E0F0] p-3">
                </select>
            </div>


            <!-- Details -->
            <div class="flex flex-col gap-[10px]" x-data="editorJsWrapper()" x-init="initEditor()">
                <label class="text-sm font-bold text-[#7D8592] font-nunito leading-6">Content</label>

                <div class="rounded-[14px] border border-[#D8E0F0] bg-white p-6 focus-within:border-[#3F8CFF] transition-colors">
                    <div id="editorjs_holder" class="prose max-w-none"></div>
                </div>

                <input type="hidden" name="body" x-ref="hiddenBody">
            </div>

            <!-- Status Buttons -->
            <div class="flex items-center gap-[30px] flex-wrap">
                <button type="submit" name="status" value="draft" class="h-[53px] px-[22px] bg-black rounded-[14px] text-white font-bold hover:bg-[#1a1a1a]">Save as Draft</button>
                <button type="submit" name="status" value="published" class="h-12 px-[39px] bg-[#3F8CFF] rounded-[14px] text-white font-bold hover:bg-[#2D7AEB]">Publish</button>
            </div>
        </form>
    </div>
</div>



@endsection
@push('script')
<script>
    function previewImage(event) {
        const input = event.target;
        const preview = document.getElementById('imagePreview');
        const defaultIcon = document.getElementById('defaultIconContainer');

        if (input.files && input.files[0]) {
            const reader = new FileReader();
            reader.onload = function(e) {
                preview.src = e.target.result;
                preview.classList.remove('hidden');
                defaultIcon.classList.add('hidden');
            }
            reader.readAsDataURL(input.files[0]);
        } else {
            preview.src = '#';
            preview.classList.add('hidden');
            defaultIcon.classList.remove('hidden');
        }
    }

    function editorJsWrapper() {
        return {
            editor: null
            , retryCount: 0
            , maxRetries: 30,

            initEditor() {
                const requiredTools = [
                    'EditorJS'
                    , 'Header'
                    , 'List'
                    , 'Paragraph'
                    , 'Quote'
                    , 'Table'
                    , 'Checklist'
                    , 'Delimiter'
                    , 'ImageTool'
                , ];

                const allToolsReady = requiredTools.every(
                    tool => typeof window[tool] !== 'undefined'
                );

                if (!allToolsReady) {
                    if (this.retryCount >= this.maxRetries) {
                        console.error('Editor.js tools failed to load.');
                        return;
                    }

                    this.retryCount++;
                    setTimeout(() => this.initEditor(), 100);
                    return;
                }

                this.editor = new window.EditorJS({
                    holder: 'editorjs_holder'
                    , placeholder: 'Press "/" for commands...'
                    , tools: {
                        header: {
                            class: window.Header
                            , inlineToolbar: true
                        , }
                        , list: {
                            class: window.List
                            , inlineToolbar: true
                        , }
                        , paragraph: {
                            class: window.Paragraph
                            , inlineToolbar: true
                            , config: {
                                preserveBlank: true
                            , }
                        , }
                        , checklist: {
                            class: window.Checklist
                            , inlineToolbar: true
                        , }
                        , quote: {
                            class: window.Quote
                            , inlineToolbar: true
                        , }
                        , delimiter: window.Delimiter
                        , table: {
                            class: window.Table
                            , inlineToolbar: true
                        , }
                        , image: {
                            class: window.ImageTool
                            , config: {
                                endpoints: {
                                    byFile: "{{ route('admin.blogs.upload') }}"
                                , }
                                , additionalRequestHeaders: {
                                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                                , }
                            , }
                        , }

                    , }
                    , onChange: () => {
                        this.saveData();
                    }
                , });
            },

            saveData() {
                if (!this.editor) return;

                this.editor
                    .save()
                    .then(outputData => {
                        this.$refs.hiddenBody.value = JSON.stringify(outputData);
                    })
                    .catch(error => {
                        console.error('Saving failed:', error);
                    });
            }
        , };
    }

    new TomSelect('#categories', {
        minChars: 3
        , valueField: 'value'
        , labelField: 'text'
        , searchField: 'text',

        create: function(input) {
            const normalized = input.trim().toLowerCase();

            // prevent duplicate creation in UI
            const exists = Object.values(this.options).some(
                option => option.text.toLowerCase() === normalized
            );

            if (exists) {
                return false;
            }

            return {
                value: normalized
                , text: normalized.replace(/\b\w/g, l => l.toUpperCase())
            };
        },

        load: function(query, callback) {
            if (query.length < 3) return callback();

            fetch(`{{ route('admin.categories.search') }}?q=${encodeURIComponent(query)}`)
                .then(res => res.json())
                .then(json => callback(json))
                .catch(() => callback());
        }
    });

</script>
@endpush
