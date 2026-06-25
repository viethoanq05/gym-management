@extends('member.layout')

@section('title', 'Đặt lịch PT mới')
@section('header_title', 'Đặt lịch tập luyện')

@section('content')

<!-- Back Link -->
<div class="mb-6">
    <a href="{{ route('member.bookings.index') }}" class="inline-flex items-center gap-2 text-slate-500 hover:text-slate-800 text-sm font-bold transition">
        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" class="w-4 h-4">
            <line x1="19" y1="12" x2="5" y2="12"></line>
            <polyline points="12 19 5 12 12 5"></polyline>
        </svg>
        <span>Quay lại danh sách</span>
    </a>
</div>

<!-- Booking Form Card -->
<div class="max-w-2xl mx-auto bg-white rounded-3xl border border-slate-100 p-8 shadow-sm">
    <div class="mb-6 text-center">
        <h2 class="text-2xl font-extrabold text-slate-800">Đặt lịch với Huấn luyện viên</h2>
        <p class="text-slate-400 text-sm font-semibold mt-1">Vui lòng chọn PT và khung giờ mong muốn.</p>
    </div>

    @if ($errors->any())
        <div class="mb-6 p-4 bg-red-50 border border-red-200 text-red-700 text-xs font-semibold rounded-xl space-y-1">
            <div class="font-bold mb-1">Đã xảy ra lỗi khi đăng ký lịch hẹn:</div>
            <ul class="list-disc pl-4 space-y-0.5">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('member.bookings.store') }}" class="space-y-5" id="booking-form">
        @csrf

        <!-- Trainer Selection -->
        <div>
            <label class="mb-1.5 block text-sm font-bold text-slate-600">Huấn luyện viên cá nhân (PT)</label>
            <select name="trainer_id" id="trainer-select" required class="w-full rounded-xl border border-slate-200 px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-blue-600 bg-white font-semibold text-slate-700">
                <option value="" disabled selected>Chọn huấn luyện viên...</option>
                @foreach($trainers as $trainer)
                    <option value="{{ $trainer->id }}" {{ old('trainer_id') == $trainer->id ? 'selected' : '' }}>
                        {{ $trainer->user->name }} — {{ $trainer->specialization }} ({{ $trainer->experience_years }} năm kinh nghiệm)
                    </option>
                @endforeach
            </select>
            @error('trainer_id') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
        </div>

        <!-- Date Selection -->
        <div>
            <label class="mb-1.5 block text-sm font-bold text-slate-600">Ngày tập luyện</label>
            <input name="booking_date" id="date-input" value="{{ old('booking_date', now()->toDateString()) }}" type="date" required min="{{ now()->toDateString() }}" class="w-full rounded-xl border border-slate-200 px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-blue-600 font-semibold text-slate-700">
            @error('booking_date') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
        </div>

        <!-- ===== AVAILABILITY PANEL ===== -->
        <div id="availability-panel" class="hidden">
            <div class="border border-slate-100 rounded-2xl overflow-hidden">
                <!-- Panel Header -->
                <div class="bg-slate-50 px-5 py-3 flex items-center justify-between border-b border-slate-100">
                    <div class="flex items-center gap-2">
                        <span class="bg-blue-100 text-blue-600 p-1.5 rounded-lg">
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" class="w-4 h-4">
                                <circle cx="12" cy="12" r="10"/>
                                <polyline points="12 6 12 12 16 14"/>
                            </svg>
                        </span>
                        <h3 class="text-sm font-bold text-slate-700">Lịch trống của PT</h3>
                    </div>
                    <span id="availability-date-label" class="text-xs font-semibold text-slate-400"></span>
                </div>

                <!-- Panel Body -->
                <div class="p-5">
                    <!-- Loading State -->
                    <div id="availability-loading" class="hidden flex flex-col items-center py-8">
                        <div class="w-8 h-8 border-3 border-blue-200 border-t-blue-600 rounded-full animate-spin"></div>
                        <p class="text-xs text-slate-400 font-semibold mt-3">Đang tải lịch trống...</p>
                    </div>

                    <!-- Empty State -->
                    <div id="availability-empty" class="hidden flex flex-col items-center py-8 text-center">
                        <div class="text-slate-300 mb-2">
                            <svg width="36" height="36" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" class="w-9 h-9 mx-auto">
                                <rect x="3" y="4" width="18" height="18" rx="2" ry="2"/>
                                <line x1="16" y1="2" x2="16" y2="6"/>
                                <line x1="8" y1="2" x2="8" y2="6"/>
                                <line x1="3" y1="10" x2="21" y2="10"/>
                                <line x1="9" y1="16" x2="15" y2="16"/>
                            </svg>
                        </div>
                        <h4 class="text-sm font-bold text-slate-600">PT không có lịch làm việc</h4>
                        <p class="text-xs text-slate-400 mt-1">Vui lòng chọn ngày khác hoặc huấn luyện viên khác.</p>
                    </div>

                    <!-- Schedule Content -->
                    <div id="availability-content" class="hidden space-y-4">
                        <!-- Legend -->
                        <div class="flex flex-wrap gap-4 text-xs font-semibold">
                            <div class="flex items-center gap-1.5">
                                <span class="w-3 h-3 rounded bg-emerald-100 border border-emerald-300"></span>
                                <span class="text-slate-500">Còn trống</span>
                            </div>
                            <div class="flex items-center gap-1.5">
                                <span class="w-3 h-3 rounded bg-red-100 border border-red-300"></span>
                                <span class="text-slate-500">Đã đặt</span>
                            </div>
                            <div class="flex items-center gap-1.5">
                                <span class="w-3 h-3 rounded bg-slate-100 border border-slate-300"></span>
                                <span class="text-slate-500">Ngoài giờ làm</span>
                            </div>
                            <div class="flex items-center gap-1.5">
                                <span class="w-3 h-3 rounded bg-slate-50 border border-slate-200 opacity-60"></span>
                                <span class="text-slate-500">Đã qua</span>
                            </div>
                        </div>

                        <!-- Slots Container -->
                        <div id="slots-container"></div>

                        <p class="text-[11px] text-slate-400 font-medium mt-2">
                            Nhấn vào các khung giờ <strong class="text-emerald-600">màu xanh</strong> để chọn (có thể chọn nhiều). Nhấn lại để bỏ chọn. Giờ bắt đầu & kết thúc sẽ được tự động tính.
                        </p>
                    </div>
                </div>
            </div>
        </div>
        <!-- ===== END AVAILABILITY PANEL ===== -->

        <!-- Time Range Selection -->
        <div class="grid grid-cols-2 gap-4">
            <div>
                <label class="mb-1.5 block text-sm font-bold text-slate-600">Giờ bắt đầu</label>
                <input name="start_time" id="start-time" value="{{ old('start_time') }}" type="time" required class="w-full rounded-xl border border-slate-200 px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-blue-600 font-semibold text-slate-700">
                @error('start_time') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
            </div>

            <div>
                <label class="mb-1.5 block text-sm font-bold text-slate-600">Giờ kết thúc</label>
                <input name="end_time" id="end-time" value="{{ old('end_time') }}" type="time" required class="w-full rounded-xl border border-slate-200 px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-blue-600 font-semibold text-slate-700">
                @error('end_time') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
            </div>
        </div>

        <!-- Submit Button -->
        <div class="pt-2">
            <button type="submit" class="w-full rounded-xl bg-blue-600 hover:bg-blue-700 text-white py-3.5 font-bold text-sm transition shadow-lg shadow-blue-500/10">
                Xác nhận đặt lịch PT
            </button>
        </div>
    </form>
</div>

<!-- Tips -->
<div class="max-w-2xl mx-auto mt-6 bg-blue-50/50 rounded-2xl border border-blue-50 p-5 text-xs text-blue-700 leading-relaxed font-semibold">
    <div class="font-extrabold text-sm mb-1">Hướng dẫn & Quy định đặt lịch:</div>
    <ul class="list-disc pl-4 space-y-1 mt-2">
        <li>Vui lòng kiểm tra kỹ khung giờ làm việc trống của PT trước khi đặt lịch hẹn.</li>
        <li>Bạn có thể hủy lịch tập đã đặt bất cứ lúc nào trước khi giờ hẹn diễn ra ít nhất 2 giờ.</li>
        <li>Buổi hẹn sau khi gửi sẽ ở trạng thái <strong>Chờ duyệt</strong> và sẽ chuyển sang <strong>Đã xác nhận</strong> sau khi hệ thống xử lý.</li>
    </ul>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const trainerSelect = document.getElementById('trainer-select');
    const dateInput = document.getElementById('date-input');
    const panel = document.getElementById('availability-panel');
    const loadingEl = document.getElementById('availability-loading');
    const emptyEl = document.getElementById('availability-empty');
    const contentEl = document.getElementById('availability-content');
    const slotsContainer = document.getElementById('slots-container');
    const dateLabel = document.getElementById('availability-date-label');
    const startTimeInput = document.getElementById('start-time');
    const endTimeInput = document.getElementById('end-time');

    let abortController = null;

    function fetchAvailability() {
        const trainerId = trainerSelect.value;
        const date = dateInput.value;

        if (!trainerId || !date) {
            panel.classList.add('hidden');
            return;
        }

        // Show panel + loading
        panel.classList.remove('hidden');
        loadingEl.classList.remove('hidden');
        emptyEl.classList.add('hidden');
        contentEl.classList.add('hidden');

        // Format date for label
        const d = new Date(date + 'T00:00:00');
        const dayNames = ['Chủ Nhật', 'Thứ 2', 'Thứ 3', 'Thứ 4', 'Thứ 5', 'Thứ 6', 'Thứ 7'];
        dateLabel.textContent = dayNames[d.getDay()] + ', ' + d.getDate() + '/' + (d.getMonth() + 1) + '/' + d.getFullYear();

        // Cancel previous request
        if (abortController) abortController.abort();
        abortController = new AbortController();

        const url = `{{ route('member.bookings.trainer-availability') }}?trainer_id=${trainerId}&date=${date}`;

        fetch(url, { signal: abortController.signal })
            .then(res => res.json())
            .then(data => {
                loadingEl.classList.add('hidden');

                if (!data.schedules || data.schedules.length === 0) {
                    emptyEl.classList.remove('hidden');
                    contentEl.classList.add('hidden');
                    return;
                }

                contentEl.classList.remove('hidden');
                renderSlots(data.schedules, data.booked);
            })
            .catch(err => {
                if (err.name !== 'AbortError') {
                    loadingEl.classList.add('hidden');
                    emptyEl.classList.remove('hidden');
                }
            });
    }

    function renderSlots(schedules, booked) {
        slotsContainer.innerHTML = '';

        // Determine current time for "past slot" detection
        const selectedDate = dateInput.value;
        const todayStr = new Date().toLocaleDateString('en-CA'); // YYYY-MM-DD format
        const isToday = selectedDate === todayStr;
        const nowMinutes = isToday ? (new Date().getHours() * 60 + new Date().getMinutes()) : -1;

        schedules.forEach(schedule => {
            const shiftEl = document.createElement('div');
            shiftEl.className = 'mb-3';

            // Shift label
            const label = document.createElement('div');
            label.className = 'text-xs font-bold text-slate-500 mb-2 flex items-center gap-1.5';
            const startH = parseInt(schedule.start.split(':')[0]);
            const shiftName = startH < 12 ? 'Ca sáng' : (startH < 18 ? 'Ca chiều' : 'Ca tối');
            label.innerHTML = `${shiftName} <span class="text-slate-300 font-normal">|</span> <span class="text-slate-400 font-semibold">${schedule.start} – ${schedule.end}</span>`;
            shiftEl.appendChild(label);

            // Generate 1-hour slots within the schedule
            const slotsGrid = document.createElement('div');
            slotsGrid.className = 'grid grid-cols-4 gap-2';

            const schedStart = timeToMinutes(schedule.start);
            const schedEnd = timeToMinutes(schedule.end);

            for (let t = schedStart; t < schedEnd; t += 60) {
                const slotStart = minutesToTime(t);
                const slotEnd = minutesToTime(Math.min(t + 60, schedEnd));

                const isBooked = booked.some(b => {
                    const bStart = timeToMinutes(b.start);
                    const bEnd = timeToMinutes(b.end);
                    return t < bEnd && (t + 60) > bStart;
                });

                // Check if this slot is in the past (only when date is today)
                const isPast = isToday && t < nowMinutes;

                const slot = document.createElement('button');
                slot.type = 'button';
                const freeClass = 'rounded-xl px-3 py-2.5 text-xs font-bold transition text-center border bg-emerald-50 border-emerald-200 text-emerald-700 hover:bg-emerald-100 hover:border-emerald-300 hover:shadow-sm cursor-pointer';
                const selectedClass = 'rounded-xl px-3 py-2.5 text-xs font-bold transition text-center border ring-2 ring-blue-500 bg-blue-50 border-blue-300 text-blue-700';

                if (isPast) {
                    // Past slot - greyed out
                    slot.className = 'rounded-xl px-3 py-2.5 text-xs font-bold transition text-center border bg-slate-50 border-slate-200 text-slate-400 cursor-not-allowed opacity-60';
                    slot.innerHTML = `<div>${slotStart} - ${slotEnd}</div><div class="text-[10px] font-semibold mt-0.5 opacity-70">Đã qua</div>`;
                    slot.disabled = true;
                } else if (isBooked) {
                    slot.className = 'rounded-xl px-3 py-2.5 text-xs font-bold transition text-center border bg-red-50 border-red-200 text-red-400 cursor-not-allowed';
                    slot.innerHTML = `<div>${slotStart} - ${slotEnd}</div><div class="text-[10px] font-semibold mt-0.5 opacity-70">Đã đặt</div>`;
                    slot.disabled = true;
                } else {
                    slot.className = freeClass;
                    slot.innerHTML = `<div>${slotStart} - ${slotEnd}</div><div class="text-[10px] font-semibold mt-0.5 opacity-60">Còn trống</div>`;
                    slot.dataset.slotStart = slotStart;
                    slot.dataset.slotEnd = slotEnd;
                    slot.addEventListener('click', function () {
                        const selected = slotsContainer.querySelectorAll('[data-selected]');

                        // Toggle off: deselect this slot
                        if (slot.hasAttribute('data-selected')) {
                            // If deselecting would create a gap, reset all
                            const slotMin = timeToMinutes(slotStart);
                            const slotMax = timeToMinutes(slotEnd);
                            const remaining = [...selected].filter(el => el !== slot);

                            if (remaining.length > 0 && !isContiguous(remaining)) {
                                // Would break continuity - reset everything
                                resetAllSlots(selected, freeClass);
                            } else {
                                slot.removeAttribute('data-selected');
                                slot.className = freeClass;
                                slot.innerHTML = `<div>${slotStart} - ${slotEnd}</div><div class="text-[10px] font-semibold mt-0.5 opacity-60">Còn trống</div>`;
                            }
                            updateTimeRange();
                            return;
                        }

                        // Select: check adjacency
                        if (selected.length > 0) {
                            const clickedStart = timeToMinutes(slotStart);
                            const clickedEnd = timeToMinutes(slotEnd);
                            let minStart = Infinity, maxEnd = 0;
                            selected.forEach(el => {
                                minStart = Math.min(minStart, timeToMinutes(el.dataset.slotStart));
                                maxEnd = Math.max(maxEnd, timeToMinutes(el.dataset.slotEnd));
                            });

                            // Adjacent = touching the current range
                            const isAdjacent = (clickedEnd === minStart || clickedStart === maxEnd);

                            if (!isAdjacent) {
                                // Not adjacent: reset all, start fresh
                                resetAllSlots(selected, freeClass);
                            }
                        }

                        slot.setAttribute('data-selected', 'true');
                        slot.className = selectedClass;
                        slot.innerHTML = `<div>${slotStart} - ${slotEnd}</div><div class="text-[10px] font-semibold mt-0.5">✓ Đã chọn</div>`;
                        updateTimeRange();
                    });
                }

                slotsGrid.appendChild(slot);
            }

            shiftEl.appendChild(slotsGrid);
            slotsContainer.appendChild(shiftEl);
        });
    }

    function timeToMinutes(t) {
        const [h, m] = t.split(':').map(Number);
        return h * 60 + m;
    }

    function minutesToTime(m) {
        const hh = String(Math.floor(m / 60)).padStart(2, '0');
        const mm = String(m % 60).padStart(2, '0');
        return `${hh}:${mm}`;
    }

    function isContiguous(slots) {
        if (slots.length <= 1) return true;
        const times = [...slots].map(el => ({
            start: timeToMinutes(el.dataset.slotStart),
            end: timeToMinutes(el.dataset.slotEnd),
        })).sort((a, b) => a.start - b.start);

        for (let i = 1; i < times.length; i++) {
            if (times[i].start !== times[i - 1].end) return false;
        }
        return true;
    }

    function resetAllSlots(selected, freeClass) {
        selected.forEach(el => {
            el.removeAttribute('data-selected');
            el.className = freeClass;
            const s = el.dataset.slotStart;
            const e = el.dataset.slotEnd;
            el.innerHTML = `<div>${s} - ${e}</div><div class="text-[10px] font-semibold mt-0.5 opacity-60">Còn trống</div>`;
        });
    }

    function updateTimeRange() {
        const selected = slotsContainer.querySelectorAll('[data-selected]');
        if (selected.length === 0) {
            startTimeInput.value = '';
            endTimeInput.value = '';
            return;
        }

        let minStart = Infinity;
        let maxEnd = 0;
        selected.forEach(el => {
            const s = timeToMinutes(el.dataset.slotStart);
            const e = timeToMinutes(el.dataset.slotEnd);
            if (s < minStart) minStart = s;
            if (e > maxEnd) maxEnd = e;
        });

        startTimeInput.value = minutesToTime(minStart);
        endTimeInput.value = minutesToTime(maxEnd);
    }

    // Listen for changes
    trainerSelect.addEventListener('change', fetchAvailability);
    dateInput.addEventListener('change', fetchAvailability);

    // Auto-fetch if both values exist on page load (e.g. after validation error)
    if (trainerSelect.value && dateInput.value) {
        fetchAvailability();
    }
});
</script>

@endsection
