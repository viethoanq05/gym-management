# Hướng dẫn Setup Chức Năng Trainer

## Các tính năng đã tạo

### 1. **Dashboard Trainer** (Bảng điều khiển)

- Hiển thị số giờ dạy tổng cộng
- Hiển thị điểm cộng (bonus points)
- Hiển thị điểm trừ (penalty points)
- Tổng điểm (bonus - penalty)
- Lịch sắp tới trong 7 ngày

**Route**: `/trainer/dashboard`

### 2. **Xem Lịch Làm Việc**

- Hiển thị lịch làm việc của trainer (từ TrainerSchedule)
- Phân trang 15 mục trên trang

**Route**: `/trainer/schedule`

### 3. **Xem và Quản Lý Lịch Đặt**

- Hiển thị danh sách lịch đặt từ hội viên
- Nhận lịch (Accept) - thay đổi status thành 1 (Confirmed)
- Hủy lịch (Cancel) - thay đổi status thành 0 (Cancelled)
- Kiểm tra số giờ tối thiểu phải hủy trước (mặc định 24 giờ)
- Xem thông tin chi tiết hội viên trực tiếp từ danh sách lịch

**Route**: `/trainer/schedule/bookings`
**Actions**:

- POST `/trainer/schedule/accept/{bookingId}` - Nhận lịch
- POST `/trainer/schedule/cancel/{bookingId}` - Hủy lịch

### 4. **Theo Dõi Thể Trạng Hội Viên**

- Danh sách hội viên mà trainer đã làm việc
- Chi tiết thông tin cá nhân hội viên
- Tính toán và hiển thị BMI
- Lịch sử check-in
- Thống kê check-in tháng hiện tại
- Lần check-in gần nhất

**Routes**:

- `/trainer/members` - Danh sách hội viên
- `/trainer/members/{memberId}` - Chi tiết thể trạng hội viên

## Cách cài đặt

### 1. Chạy Migrations

```bash
php artisan migrate
```

Migrations được tạo:

- `2026_06_24_000001_create_trainer_points_table.php` - Bảng điểm huấn luyện viên
- `2026_06_24_000002_add_cancellation_hours_to_bookings_table.php` - Thêm cột để tracking hủy lịch

### 2. Tạo Dữ Liệu Test (Tuỳ chọn)

Nếu bạn có Seeders, hãy chạy:

```bash
php artisan db:seed
```

### 3. Tạo Tài Khoản Trainer (Nếu cần)

Bạn có thể tạo trainer thông qua database seeder hoặc tạo trực tiếp:

```bash
php artisan tinker

# Trong Tinker:
$user = User::create([
    'name' => 'Trainer Name',
    'email' => 'trainer@example.com',
    'password' => bcrypt('password'),
    'phone' => '0123456789',
    'role' => 'trainer'
]);

$trainer = Trainer::create([
    'user_id' => $user->id,
    'description' => 'Description',
    'specialization' => 'Fitness',
    'experience_years' => 5
]);
```

## Models được tạo

- **Trainer** - Thông tin huấn luyện viên
    - Relationships: user, schedules, bookings, points
- **TrainerSchedule** - Lịch làm việc của trainer
    - Relationships: trainer
- **TrainerPoint** - Điểm cộng/trừ của trainer
    - Fields: trainer_id, points, type (bonus/penalty), reason
    - Relationships: trainer
- **Member** - Thông tin hội viên
    - Relationships: user
- **Booking** - Lịch đặt của hội viên với trainer
    - Methods: canBeCancelled() - Kiểm tra có thể hủy lịch hay không
    - Relationships: member, trainer
- **CheckIn** - Lịch check-in của hội viên
    - Relationships: member

## Controllers được tạo

1. **TrainerDashboardController** - Quản lý dashboard
2. **TrainerScheduleController** - Quản lý lịch làm việc và lịch đặt
3. **TrainerMemberStatusController** - Theo dõi thể trạng hội viên

## Views được tạo

- `resources/views/trainer/dashboard.blade.php` - Dashboard chính
- `resources/views/trainer/schedule/index.blade.php` - Lịch làm việc
- `resources/views/trainer/schedule/bookings.blade.php` - Lịch đặt
- `resources/views/trainer/members/index.blade.php` - Danh sách hội viên
- `resources/views/trainer/members/show.blade.php` - Chi tiết thể trạng hội viên

## Lưu ý quan trọng

1. **Hủy Lịch**: Trainer chỉ có thể hủy lịch nếu còn lại tối thiểu 24 giờ trước lịch đặt (có thể tùy chỉnh qua `cancellation_hours_before` trong bảng `bookings`)

2. **Xem Thể Trạng**: Trainer chỉ có thể xem thông tin thể trạng của hội viên mà họ đã/đang làm việc

3. **Điểm Trainer**: Điểm cộng/trừ được quản lý qua bảng `trainer_points` và có thể được thêm bởi admin

## Để mở rộng

### Thêm Tính Năng Ghi Chú

Tạo migration để lưu ghi chú trainer về hội viên:

```bash
php artisan make:migration create_trainer_notes_table
```

### Thêm Tính Năng Xây Dựng Lịch

Tạo controller để trainer có thể tạo/chỉnh sửa lịch làm việc của mình.

### Thêm Thông Báo

Sử dụng Laravel Notifications để thông báo khi có lịch đặt mới, hoặc khi lịch bị hủy.

## Troubleshooting

### Lỗi: Role middleware không hoạt động

- Kiểm tra xem middleware `CheckRole` đã được đăng ký trong `bootstrap/app.php`
- Kiểm tra xem user có field `role` không

### Lỗi: Không thể tìm thấy Trainer

- Kiểm tra xem user có bản ghi Trainer liên kết hay không
- Kiểm tra xem `user_id` trong bảng trainers có chính xác không

### Lỗi: Không thể hủy lịch

- Kiểm tra xem hiện tại còn lại bao nhiêu giờ cho tới lịch đặt
- Kiểm tra giá trị `cancellation_hours_before` trong bảng `bookings`
