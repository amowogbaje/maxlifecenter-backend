@extends('admin.layouts.app')

@section('content')
<div class="min-h-screen flex items-center justify-center p-4 md:p-8">
    <div class="w-full max-w-[850px] bg-white rounded-[24px] p-8 md:p-12 flex flex-col gap-12">
        <!-- Header -->
        <div class="flex justify-between items-center">
            <h1 class="text-[22px] font-bold text-[#0A1629] font-nunito">
                Create New Update
            </h1>
            <a href="{{ route('admin.updates.index') }}" class="flex items-center gap-3 h-12 px-4 rounded-[14px] bg-blue-500 text-white shadow-[0_6px_12px_0_rgba(63,140,255,0.26)] hover:bg-blue-600 transition-colors">
                <span class="text-base font-bold">See All Updates</span>
            </a>
        </div>

        <!-- Form -->
        <form action="{{ route('admin.updates.store') }}" method="POST" enctype="multipart/form-data" class="flex flex-col gap-12">
            @csrf

            <!-- Image Banner -->
            <div class="flex flex-col gap-[10px]">
                <label class="text-sm font-bold text-[#7D8592] font-nunito leading-6">
                    Image Banner (Optional)
                </label>
                <label class="flex h-[204px] justify-center items-center border border-[#D8E0F0] rounded-[14px] cursor-pointer hover:bg-[#F8FAFB] transition-colors">
                    <input type="file" accept="image/*" name="image" id="imageInput" class="hidden" onchange="previewImage(event)" />
                    <div id="imagePreviewContainer" class="flex items-center justify-center w-full h-full">
                        <svg id="defaultIcon" width="24" height="24" viewBox="0 0 24 24" fill="none">
                            <path d="M19 3H5C3.89543 3 3 3.89543 3 5V19C3 20.1046 3.89543 21 5 21H19C20.1046 21 21 20.1046 21 19V5C21 3.89543 20.1046 3 19 3Z" stroke="#0A1629" stroke-width="2"/>
                            <path d="M8.5 10C9.32843 10 10 9.32843 10 8.5C10 7.67157 9.32843 7 8.5 7C7.67157 7 7 7.67157 7 8.5C7 9.32843 7.67157 10 8.5 10Z" stroke="#0A1629" stroke-width="2"/>
                            <path d="M21 15L16 10L5 21" stroke="#0A1629" stroke-width="2"/>
                        </svg>
                        <img id="imagePreview" src="#" alt="Preview" class="max-h-full max-w-full object-contain rounded-[10px] hidden"/>
                    </div>
                </label>
            </div>

            <!-- Title -->
            <div class="flex flex-col gap-[10px]">
                <label class="text-sm font-bold text-[#7D8592] font-nunito leading-6">Title</label>
                <input type="text" name="title" placeholder="Update Title" class="h-[54px] px-[13px] rounded-[14px] border border-[#D8E0F0] bg-white text-sm text-[#7D8592] focus:outline-none focus:border-[#3F8CFF]" required />
            </div>

            <!-- Details -->
            <div class="flex flex-col gap-[10px]">
                <label class="text-sm font-bold text-[#7D8592] font-nunito leading-6">Update Details</label>
                <textarea name="body" placeholder="Update details..." class="h-[216px] p-[14px] rounded-[14px] border border-[#D8E0F0] bg-white text-sm text-[#7D8592] focus:outline-none focus:border-[#3F8CFF]" required></textarea>
            </div>

            <!-- Status Buttons -->
            <div class="flex items-center gap-[30px] flex-wrap">
                <button type="submit" name="status" value="draft" class="h-[53px] px-[22px] bg-black rounded-[14px] text-white font-bold hover:bg-[#1a1a1a]">Save as Draft</button>
                <button type="submit" name="status" value="published" class="h-12 px-[39px] bg-[#3F8CFF] rounded-[14px] text-white font-bold hover:bg-[#2D7AEB]">Publish</button>
            </div>
        </form>
    </div>
</div>

<script>
function previewImage(event) {
    const input = event.target;
    const preview = document.getElementById('imagePreview');
    const defaultIcon = document.getElementById('defaultIcon');

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
</script>
@endsection
