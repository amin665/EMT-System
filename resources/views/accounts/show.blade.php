@extends('layouts.app')

@section('header', 'ملف المريض')

@section('content')
    <a href="{{ route('patients.index') }}" class="link mb-4 inline-block">&larr; العودة للقائمة</a>

    <!-- Patient Details -->
    <div class="card p-6 mb-6">
        <h2 class="text-2xl font-bold text-gray-100 mb-2">{{ $patient->fullName }}</h2>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-gray-300">
            <p><strong>الهاتف:</strong> {{ $patient->phoneNumber }}</p>
            <p><strong>تاريخ الميلاد:</strong> {{ $patient->dob->format('Y-m-d') }}</p>
            <div class="col-span-2 card-muted p-3 rounded-lg">
                <strong>التاريخ الطبي:</strong> {{ $patient->medicalHistory ?? 'لا يوجد' }}
            </div>
        </div>
    </div>

    <!-- Medical Records Section -->
    <div class="flex justify-between items-center mb-4">
        <h3 class="section-title">السجلات الطبية</h3>
        <button onclick="document.getElementById('addRecordForm').classList.toggle('hidden')" class="btn btn-primary">
            + إضافة سجل جديد
        </button>
    </div>

    <!-- Add Form (Hidden by default) -->
    <div id="addRecordForm" class="hidden card p-6 mb-6">
        <form action="{{ route('medical-records.store-for-patient', $patient->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            <input type="hidden" name="patientID" value="{{ $patient->id }}">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                <div>
                    <label class="label">التشخيص</label>
                    <input type="text" name="diagnosis" class="input" required>
                </div>
                <div>
                    <label class="label">الوصفة الطبية</label>
                    <input type="text" name="prescription" class="input" required>
                </div>
                <div class="md:col-span-2">
                    <label class="label">الادوية</label>
                    <input type="text" name="medicines" class="input">
                </div>
                <div class="md:col-span-2">
    <label class="label">ملاحظات</label>
    <div class="relative">
        <textarea id="followUpNotes" name="followUpNotes" class="textarea w-full pr-3 pl-12" 
            placeholder="...اكتب الملاحظات هنا أو استخدم الميكروفون"></textarea>
        
        <button type="button" id="micBtn" 
            class="absolute bottom-3 left-3 p-2 rounded-full transition-all duration-300 text-pink-500 hover:bg-white/10 flex items-center justify-center">
            <svg id="micIcon" xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11a7 7 0 01-7 7m0 0a7 7 0 01-7-7m7 7v4m0 0H8m4 0h4m-4-8a3 3 0 01-3-3V5a3 3 0 116 0v6a3 3 0 01-3 3z" />
            </svg>
            <span id="recordingStatus" class="hidden text-xs mr-2 font-bold">LIVE</span>
        </button>
    </div>
</div>
                <div class="md:col-span-2">
                    <label class="label">مرفق (صورة او PDF)</label>
                    <input type="file" name="attachment" class="input" accept="image/*,.pdf">
                </div>
            </div>
            <button type="submit" class="btn btn-primary">حفظ السجل</button>
        </form>
    </div>

    <!-- Records Timeline -->
    <div class="space-y-4">
        @forelse($patient->medicalRecords->sortByDesc('created_at') as $record)
            <div class="card p-6 relative">
                <div class="flex justify-between">
                    <span class="text-gray-400 text-sm">{{ $record->created_at->format('Y-m-d H:i') }}</span>
                    <div class="space-x-2 space-x-reverse">
                        <a href="{{ route('medical-records.edit', $record->id) }}" class="link text-sm">تعديل</a>
                        <form id="delete-record-{{ $record->id }}" action="{{ route('medical-records.destroy', $record->id) }}" method="POST" class="inline">
                            @csrf @method('DELETE')
                            <button type="button" class="link link-danger text-sm" onclick="confirmDelete('delete-record-{{ $record->id }}')">حذف</button>
                        </form>
                    </div>
                </div>
                <h4 class="font-bold text-lg mt-2 text-gray-100">{{ $record->diagnosis }}</h4>
                <p class="text-gray-300 mb-2"><strong>Rx:</strong> {{ $record->prescription }}</p>
                @if(!empty($record->medicines))
                    <p class="text-gray-300 mb-2"><strong>الادوية:</strong> {{ $record->medicines }}</p>
                @endif
                <p class="text-gray-400 text-sm card-muted p-2 rounded">{{ $record->followUpNotes }}</p>
                @if(!empty($record->attachment_path))
                    <div class="mt-3">
                        <a href="{{ asset('storage/' . $record->attachment_path) }}" class="link" target="_blank" rel="noopener">
                            عرض المرفق ({{ $record->attachment_original_name }})
                        </a>
                        @if(!empty($record->attachment_mime) && str_starts_with($record->attachment_mime, 'image/'))
                            <div class="mt-3">
                                <img src="{{ asset('storage/' . $record->attachment_path) }}" alt="Attachment" class="rounded-lg max-w-full">
                            </div>
                        @endif
                    </div>
                @endif
            </div>
        @empty
            <p class="text-gray-400 text-center py-4">لا توجد سجلات طبية.</p>
        @endforelse
    </div>
    <script>
    const micBtn = document.getElementById('micBtn');
    const recordingStatus = document.getElementById('recordingStatus');
    const followUpNotes = document.getElementById('followUpNotes'); // Targeted the notes textarea
    let mediaRecorder;
    let audioChunks = [];

    micBtn.onclick = async () => {
        if (mediaRecorder && mediaRecorder.state === "recording") {
            mediaRecorder.stop();
            return;
        }

        if (!navigator.mediaDevices || !navigator.mediaDevices.getUserMedia) {
            alert("المتصفح لا يدعم التسجيل. يرجى استخدام HTTPS أو localhost.");
            return;
        }

        try {
            const stream = await navigator.mediaDevices.getUserMedia({ audio: true });
            mediaRecorder = new MediaRecorder(stream);
            audioChunks = [];

            mediaRecorder.ondataavailable = e => audioChunks.push(e.data);

            mediaRecorder.onstart = () => {
                micBtn.classList.add('bg-red-500/20', 'text-red-500', 'animate-pulse');
                recordingStatus.classList.remove('hidden');
                followUpNotes.placeholder = "جاري الاستماع... اضغط مجدداً للتوقف";
            };

            mediaRecorder.onstop = async () => {
                micBtn.classList.remove('bg-red-500/20', 'text-red-500', 'animate-pulse');
                recordingStatus.classList.add('hidden');
                followUpNotes.placeholder = "جاري تحليل الملاحظات الطبية...";

                const audioBlob = new Blob(audioChunks, { type: 'audio/webm' });
                const formData = new FormData();
                formData.append('audio', audioBlob);

                try {
                    const response = await fetch("{{ route('transcribe') }}", {
                        method: 'POST',
                        body: formData,
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}',
                            'Accept': 'application/json'
                        }
                    });

                    const data = await response.json();
                    
                    if (data.success && data.text) {
                        const currentVal = followUpNotes.value.trim();
                        followUpNotes.value = currentVal + (currentVal ? " \n" : "") + data.text;
                    } else {
                        alert("خطأ: " + (data.message || "فشلت المعالجة"));
                    }
                } catch (err) {
                    console.error("Connection failed", err);
                    alert("تعذر الاتصال بالخادم.");
                } finally {
                    followUpNotes.placeholder = "...اكتب الملاحظات هنا أو استخدم الميكروفون";
                }
            };

            mediaRecorder.start();
        } catch (err) {
            alert("يرجى تفعيل صلاحية الوصول إلى الميكروفون");
            console.error(err);
        }
    };

    // Confirm Delete function
    function confirmDelete(formId) {
        if (confirm('هل أنت متأكد من حذف هذا السجل؟')) {
            document.getElementById(formId).submit();
        }
    }
</script>

<style>
    @keyframes pulse {
        0%, 100% { opacity: 1; }
        50% { opacity: 0.5; }
    }
    .animate-pulse {
        animation: pulse 2s cubic-bezier(0.4, 0, 0.6, 1) infinite;
    }
</style>
@endsection