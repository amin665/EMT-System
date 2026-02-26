@extends('layouts.app')

@section('header', 'إضافة مريض جديد')

@section('content')
<div class="card p-8 max-w-4xl mx-auto">
    <form action="{{ route('patients.store') }}" method="POST">
        @csrf
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <label class="label">الاسم الكامل</label>
                <input type="text" name="fullName" class="input" required>
            </div>
            <div>
                <label class="label">رقم الهاتف</label>
                <input type="text" name="phoneNumber" class="input" required>
            </div>
            <div>
                <label class="label">تاريخ الميلاد</label>
                <input type="date" name="dob" class="input" required>
            </div>
            <div>
                <label class="label">البريد الإلكتروني</label>
                <input type="email" name="email" class="input">
            </div>
            
            <div class="col-span-2">
                <label class="label">التاريخ الطبي</label>
                <div class="relative">
                    <textarea id="medicalHistory" name="medicalHistory" rows="3" 
                        class="textarea w-full pr-3 pl-12" 
                        placeholder="...اكتب هنا أو استخدم الميكروفون"></textarea>
                    
                    <button type="button" id="micBtn" 
                        class="absolute bottom-3 left-3 p-2 rounded-full transition-all duration-300 text-pink-500 hover:bg-white/10 flex items-center justify-center">
                        <svg id="micIcon" xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11a7 7 0 01-7 7m0 0a7 7 0 01-7-7m7 7v4m0 0H8m4 0h4m-4-8a3 3 0 01-3-3V5a3 3 0 116 0v6a3 3 0 01-3 3z" />
                        </svg>
                        <span id="recordingStatus" class="hidden text-xs mr-2 font-bold">LIVE</span>
                    </button>
                </div>
            </div>
        </div>
        
        <div class="flex justify-start space-x-4 space-x-reverse mt-6">
            <button type="submit" class="btn btn-primary">حفظ المريض</button>
            <a href="{{ route('patients.index') }}" class="btn btn-outline">إلغاء</a>
        </div>
    </form>
</div>

<script>
    const micBtn = document.getElementById('micBtn');
    const recordingStatus = document.getElementById('recordingStatus');
    const medicalHistory = document.getElementById('medicalHistory');
    let mediaRecorder;
    let audioChunks = [];

    micBtn.onclick = async () => {
        // 1. Stop if recording
        if (mediaRecorder && mediaRecorder.state === "recording") {
            mediaRecorder.stop();
            return;
        }

        // 2. Browser check
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
                medicalHistory.placeholder = "جاري الاستماع... اضغط على الميكروفون مجدداً للإرسال";
            };

            mediaRecorder.onstop = async () => {
                micBtn.classList.remove('bg-red-500/20', 'text-red-500', 'animate-pulse');
                recordingStatus.classList.add('hidden');
                medicalHistory.placeholder = "جاري تحليل الملف الصوتي بواسطة Gemini AI...";

                const audioBlob = new Blob(audioChunks, { type: 'audio/webm' });
                const formData = new FormData();
                formData.append('audio', audioBlob);

                try {
                    // This sends the file to your TranscriptionController@transcribe
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
                        const currentVal = medicalHistory.value.trim();
                        // Appends the text result to the textarea
                        medicalHistory.value = currentVal + (currentVal ? " \n" : "") + data.text;
                    } else {
                        alert("خطأ: " + (data.message || "فشلت المعالجة"));
                    }
                } catch (err) {
                    console.error("Connection failed", err);
                    alert("تعذر الاتصال بالخادم.");
                } finally {
                    medicalHistory.placeholder = "...اكتب هنا أو استخدم الميكروفون";
                }
            };

            mediaRecorder.start();
        } catch (err) {
            alert("يرجى تفعيل صلاحية الوصول إلى الميكروفون");
            console.error(err);
        }
    };
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