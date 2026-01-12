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
@endpush

@section('content')
<div class="min-h-screen flex items-center justify-center p-4 md:p-8">
    <div class="w-full max-w-[850px] bg-white rounded-[24px] p-8 md:p-12 flex flex-col gap-12">
        <div class="flex justify-between items-center">
            <h1 class="text-[22px] font-bold text-[#0A1629] font-nunito">Edit Update</h1>
            <a href="{{ route('admin.updates.index') }}" class="flex items-center gap-3 h-12 px-4 rounded-[14px] bg-gray-500 text-white hover:bg-gray-600 transition-colors">
                <span class="text-base font-bold">Back to List</span>
            </a>
        </div>

        <form action="{{ route('admin.updates.update', $update->id) }}" method="POST" enctype="multipart/form-data" class="flex flex-col gap-12">
            @csrf
            @method('PUT')

            <div class="flex flex-col gap-[10px]">
                <label class="text-sm font-bold text-[#7D8592] font-nunito leading-6">
                    Image Banner
                </label>

                <label class="relative h-[300px] md:h-[400px] w-full rounded-[14px] overflow-hidden border border-[#D8E0F0] cursor-pointer hover:bg-[#F8FAFB] transition-colors">
                    <input type="file" accept="image/*" name="image" id="imageInput" class="hidden" onchange="previewImage(event)" />

                    <!-- Default / placeholder icon -->
                    <div id="defaultIconContainer" class="absolute inset-0 flex flex-col items-center justify-center bg-gray-100 text-gray-400 transition-opacity duration-300
            {{ $update->image ? 'hidden' : '' }}">
                        <svg width="48" height="48" viewBox="0 0 24 24" fill="none" class="mb-2">
                            <path d="M19 3H5C3.89543 3 3 3.89543 3 5V19C3 20.1046 3.89543 21 5 21H19C20.1046 21 21 20.1046 21 19V5C21 3.89543 20.1046 3 19 3Z" stroke="currentColor" stroke-width="2" />
                            <path d="M8.5 10C9.32843 10 10 9.32843 10 8.5C10 7.67157 9.32843 7 8.5 7C7.67157 7 7 7.67157 7 8.5C7 9.32843 7.67157 10 8.5 10Z" stroke="currentColor" stroke-width="2" />
                            <path d="M21 15L16 10L5 21" stroke="currentColor" stroke-width="2" />
                        </svg>
                        <p class="text-lg font-semibold">No image selected</p>
                    </div>

                    <!-- Preview / existing image -->
                    <img id="imagePreview" src="{{ $update->image ? asset($update->image) : '#' }}" alt="Preview" class="w-full h-full object-cover object-center transition-transform duration-500 hover:scale-105
             {{ $update->image ? '' : 'hidden' }}" />
                </label>
            </div>

            <div class="flex flex-col gap-[10px]">
                <label class="text-sm font-bold text-[#7D8592] font-nunito leading-6">Title</label>
                <input type="text" name="title" value="{{ old('title', $update->title) }}" class="h-[54px] px-[13px] rounded-[14px] border border-[#D8E0F0] bg-white text-sm text-[#7D8592] focus:outline-none focus:border-[#3F8CFF]" required />
            </div>

            <div class="flex flex-col gap-[10px]" x-data="editorJsWrapper({{ json_encode($update->body) }})" x-init="initEditor()">
                <label class="text-sm font-bold text-[#7D8592] font-nunito leading-6">Update Details</label>
                <div class="rounded-[14px] border border-[#D8E0F0] bg-white p-6 focus-within:border-[#3F8CFF] transition-colors">
                    <div id="editorjs_holder" class="prose max-w-none"></div>
                </div>
                <input type="hidden" name="body" x-ref="hiddenBody" value="{{ json_encode($update->body) }}">
            </div>

            <div class="flex items-center gap-[30px] flex-wrap">
                <button type="submit" name="status" value="draft" class="h-[53px] px-[22px] {{ $update->status == 'draft' ? 'bg-blue-100 text-blue-600 border-2 border-blue-600' : 'bg-black text-white' }} rounded-[14px] font-bold hover:opacity-80">Update as Draft</button>
                <button type="submit" name="status" value="published" class="h-12 px-[39px] {{ $update->status == 'published' ? 'bg-green-500' : 'bg-[#3F8CFF]' }} rounded-[14px] text-white font-bold hover:opacity-80">Update & Publish</button>
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
        }
    }

    function editorJsWrapper(initialData) {
        return {
            editor: null
            , retryCount: 0
            , maxRetries: 30,

            initEditor() {
                const requiredTools = ['EditorJS', 'Header', 'List', 'Paragraph', 'Quote', 'Table', 'Checklist', 'Delimiter', 'ImageTool'];
                const allToolsReady = requiredTools.every(tool => typeof window[tool] !== 'undefined');

                if (!allToolsReady) {
                    if (this.retryCount >= this.maxRetries) return;
                    this.retryCount++;
                    setTimeout(() => this.initEditor(), 100);
                    return;
                }

                this.editor = new window.EditorJS({
                    holder: 'editorjs_holder'
                    , placeholder: 'Press "/" for commands...',
                    // Load the existing data here
                    data: typeof initialData === 'string' ? JSON.parse(initialData) : initialData
                    , tools: {
                        header: {
                            class: window.Header
                            , inlineToolbar: true
                        }
                        , list: {
                            class: window.List
                            , inlineToolbar: true
                        }
                        , paragraph: {
                            class: window.Paragraph
                            , inlineToolbar: true
                            , config: {
                                preserveBlank: true
                            }
                        }
                        , checklist: {
                            class: window.Checklist
                            , inlineToolbar: true
                        }
                        , quote: {
                            class: window.Quote
                            , inlineToolbar: true
                        }
                        , delimiter: window.Delimiter
                        , table: {
                            class: window.Table
                            , inlineToolbar: true
                        }
                        , image: {
                            class: window.ImageTool
                            , config: {
                                endpoints: {
                                    byFile: "{{ route('admin.updates.upload') }}"
                                }
                                , additionalRequestHeaders: {
                                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                                }
                            }
                        }
                    }
                    , onChange: () => this.saveData()
                });
            },

            saveData() {
                if (!this.editor) return;
                this.editor.save().then(outputData => {
                    this.$refs.hiddenBody.value = JSON.stringify(outputData);
                });
            }
        };
    }

</script>
@endpush
