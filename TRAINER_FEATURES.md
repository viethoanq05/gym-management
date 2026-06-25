# Trainer Feature - Quick Reference Guide

## 📋 Tổng Quan Tính Năng

Hệ thống quản lý phòng tập gym đã được tích hợp các tính năng cho huấn luyện viên (Trainer).

---

## 🎯 Các Tính Năng Chính

### 1️⃣ Dashboard (Bảng Điều Khiển)

**Hiển thị:**

- ⏱️ Số giờ dạy tổng cộng
- ⭐ Điểm cộng (bonus)
- ❌ Điểm trừ (penalty)
- 🏆 Tổng điểm = (bonus - penalty)
- 📅 Lịch sắp tới 7 ngày

**URL:** `GET /trainer/dashboard`

---

### 2️⃣ Xem Lịch Làm Việc

**Tính năng:**

- 📆 Danh sách lịch làm việc từ ngày hôm nay trở đi
- ⏰ Thời gian bắt đầu - kết thúc
- 📊 Tính toán thời lượng tự động

**URL:** `GET /trainer/schedule`

**Phân trang:** 15 mục/trang

---

### 3️⃣ Quản Lý Lịch Đặt

#### a) Xem Lịch Đặt

**Tính năng:**

- 📋 Danh sách hội viên đặt lịch
- 👤 Thông tin hội viên
- 📞 Số điện thoại liên hệ
- ✅ Trạng thái: Chờ xác nhận, Đã xác nhận, Đã hủy

**URL:** `GET /trainer/schedule/bookings`

#### b) Nhận Lịch (Accept)

**Action:** Thay đổi trạng thái lịch từ "Chờ xác nhận" (status 2) → "Đã xác nhận" (status 1)

**URL:** `POST /trainer/schedule/accept/{bookingId}`

**Phản hồi:** ✅ "Đã nhận lịch thành công" hoặc ❌ "Không tìm thấy lịch đặt"

#### c) Hủy Lịch (Cancel)

**Điều kiện:**

- ❌ Không thể hủy nếu lịch bắt đầu trong vòng **24 giờ** tới
- ⚠️ Hệ thống sẽ hiển thị thông báo lỗi với số giờ còn lại

**URL:** `POST /trainer/schedule/cancel/{bookingId}`

**Phản hồi:**

- ✅ "Đã hủy lịch thành công"
- ❌ "Không thể hủy lịch. Phải hủy trước tối thiểu 24 giờ..."

---

### 4️⃣ Theo Dõi Thể Trạng Hội Viên

#### a) Danh Sách Hội Viên

**Tính năng:**

- 👥 Hiển thị danh sách hội viên đã làm việc
- 👤 Thông tin: Tên, Giới tính, Năm sinh, Chiều cao, Cân nặng
- 📅 Ngày tham gia

**URL:** `GET /trainer/members`

**Phân trang:** 15 hội viên/trang

#### b) Chi Tiết Thể Trạng Hội Viên

**Thông tin cá nhân:**

- 📋 Tên, Email, Điện thoại
- 👫 Giới tính
- 📏 Chiều cao (cm)
- ⚖️ Cân nặng (kg)

**Chỉ số sức khỏe:**

- 🏃 **BMI** - Được tính tự động
    - < 18.5: Thiếu cân (xanh lá)
    - 18.5-24.9: Bình thường (xanh dương)
    - 25-29.9: Thừa cân (cam)
    - ≥ 30: Béo phì (đỏ)

**Thống kê:**

- 🔔 Lần check-in gần nhất
- 📈 Số lần check-in tháng này
- 📊 Tổng thời gian tập tính trong tháng

**Lịch sử Check-In:**

- 📅 Ngày
- 🕐 Giờ vào (Check-in)
- 🕑 Giờ ra (Check-out)
- ⏱️ Thời lượng tập (h:m)

**URL:** `GET /trainer/members/{memberId}`

**Phân trang:** 20 lần check-in/trang

---

## 📊 Model & Database Schema

### Trainers Table

```
- id (PK)
- user_id (FK)
- description (TEXT)
- specialization (STRING)
- experience_years (INT)
- timestamps
```

### Trainer Points Table

```
- id (PK)
- trainer_id (FK)
- points (INT)
- type (ENUM: 'bonus', 'penalty')
- reason (STRING)
- timestamps
```

### Bookings Table (Updated)

```
- id (PK)
- member_id (FK)
- trainer_id (FK)
- booking_date (DATE)
- start_time (TIME)
- end_time (TIME)
- status (INT: 1=confirmed, 0=cancelled, 2=pending)
- cancellation_hours_before (INT, default: 24)
- cancelled_at (DATETIME, nullable)
- timestamps
```

### Check-ins Table

```
- id (PK)
- member_id (FK)
- checkin_time (DATETIME)
- checkout_time (DATETIME, nullable)
- timestamps
```

---

## 🔧 API Endpoints Tóm Tắt

| Method | Endpoint                        | Mô Tả                   |
| ------ | ------------------------------- | ----------------------- |
| GET    | `/trainer/dashboard`            | Dashboard chính         |
| GET    | `/trainer/schedule`             | Xem lịch làm việc       |
| GET    | `/trainer/schedule/bookings`    | Xem lịch đặt            |
| POST   | `/trainer/schedule/accept/{id}` | Nhận lịch               |
| POST   | `/trainer/schedule/cancel/{id}` | Hủy lịch                |
| GET    | `/trainer/members`              | Danh sách hội viên      |
| GET    | `/trainer/members/{id}`         | Chi tiết thể trạng      |
| POST   | `/trainer/members/{id}/note`    | Thêm ghi chú (chuẩn bị) |

---

## ⚙️ Setup & Installation

### 1. Chạy Migrations

```bash
php artisan migrate
```

### 2. Seed Dữ Liệu Test (Tuỳ chọn)

```bash
php artisan db:seed --class=TrainerDataSeeder
```

### 3. Tạo Trainer User

```bash
php artisan tinker

# Trong Tinker shell:
$user = User::create([
    'name' => 'Trainer Name',
    'email' => 'trainer@gym.com',
    'password' => bcrypt('password'),
    'phone' => '0123456789',
    'role' => 'trainer'
]);

Trainer::create([
    'user_id' => $user->id,
    'description' => 'Description',
    'specialization' => 'Specialization',
    'experience_years' => 5
]);

exit
```

---

## 🚀 Cách Sử Dụng Cho Trainer

### Bước 1: Đăng Nhập

1. Truy cập `/login`
2. Nhập email & password
3. Hệ thống sẽ chuyển hướng đến `/trainer/dashboard`

### Bước 2: Xem Dashboard

- Kiểm tra số giờ dạy
- Xem điểm thưởng/phạt
- Xem lịch sắp tới

### Bước 3: Quản Lý Lịch

1. Vào "Lịch đặt" → Xem danh sách hội viên đặt lịch
2. Nhấn **Nhận** để xác nhận lịch
3. Nhấn **Hủy** để hủy lịch (nếu còn > 24h)

### Bước 4: Theo Dõi Hội Viên

1. Vào "Hội viên" → Xem danh sách
2. Nhấn "Xem chi tiết" → Xem thông tin thể trạng
3. Kiểm tra BMI, lịch sử check-in, thống kê

---

## 🔐 Bảo Mật & Quyền Hạn

- ✅ Chỉ Trainer mới có thể xem dashboard trainer
- ✅ Chỉ Trainer có thể xem lịch đặt của mình
- ✅ Chỉ Trainer mới có thể xem thông tin hội viên đã làm việc
- ✅ Middleware `role:trainer` bảo vệ tất cả routes

---

## 📝 Ghi Chú Quan Trọng

1. **Hủy Lịch:** Luôn phải hủy trước **24 giờ** (có thể tùy chỉnh)
2. **Điểm:** Admin quản lý việc cộng/trừ điểm
3. **BMI:** Tính tự động từ chiều cao & cân nặng
4. **Check-in:** Được quản lý bởi hệ thống khác

---

## 🆘 Troubleshooting

### ❌ "Không tìm thấy lịch đặt"

- Kiểm tra xem lịch có tồn tại không
- Kiểm tra xem lịch có thuộc trainer này không

### ❌ "Không thể hủy lịch"

- Kiểm tra thời gian còn lại
- Cần hủy trước **tối thiểu 24 giờ**

### ❌ "Lỗi: Không có quyền xem hội viên"

- Trainer chỉ có thể xem hội viên đã làm việc
- Kiểm tra xem có booking confirmed không

---

## 🔮 Tính Năng Sắp Tới (Future)

- 📝 Ghi chú trainer về hội viên
- 📱 Thông báo khi có lịch đặt mới
- 📊 Báo cáo chi tiết về hiệu suất
- 🏆 Leaderboard trainer
- 📞 Chat với hội viên
- 📸 Gallery hình ảnh tiến bộ

---

**Phiên bản:** 1.0  
**Ngày cập nhật:** 2026-06-24  
**Trạng thái:** ✅ Sản xuất
