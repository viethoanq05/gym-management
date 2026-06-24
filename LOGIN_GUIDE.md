# 🔐 Login Test Accounts - IRON CORE GYM

## Database Setup Status: ✅ Ready

Database đã được reset và seed dữ liệu test. Dưới đây là các tài khoản có thể sử dụng:

---

## 👥 Test Accounts

### 🔑 Admin Account

```
Email:    admin@ironcore.test
Password: admin1234
Role:     Admin
```

**Truy cập:** `/admin/dashboard`

---

### 💪 Trainer Accounts (2)

#### Trainer 1 - Vinh

```
Email:    vinhtrainer@ironcore.test
Password: vinh1234
Role:     Trainer
Phone:    0987654320
```

**Truy cập:** `/trainer/dashboard`

- Dashboard
- Xem lịch làm việc
- Quản lý lịch đặt
- Theo dõi thể trạng hội viên

#### Trainer 2 - Tuấn

```
Email:    tuantrainer@ironcore.test
Password: tuan1234
Role:     Trainer
Phone:    0987654321
```

---

### 👤 Member Accounts (2)

#### Member 1 - Đắc Đại

```
Email:    daitruong@ironcore.test
Password: daitr1234
Role:     Member
Phone:    0900000001
```

#### Member 2 - Văn Tuyên

```
Email:    tuyen@ironcore.test
Password: vantuyen1234
Role:     Member
Phone:    0900000002
```

---

### 👔 Staff Account

```
Email:    staff@ironcore.test
Password: hung1234
Role:     Staff
Phone:    0912345678
```

---

## 🚀 Cách Đăng Nhập

1. Truy cập: `http://localhost/login`
2. Nhập **Email** từ danh sách trên
3. Nhập **Password** tương ứng
4. Chọn "Ghi nhớ đăng nhập" (tuỳ chọn)
5. Nhấn **Đăng nhập**

---

## ✅ Troubleshooting

### Nếu vẫn không đăng nhập được:

1. **Xóa cache:**

    ```bash
    php artisan cache:clear
    php artisan config:clear
    ```

2. **Xóa session:**

    ```bash
    php artisan session:clear
    ```

3. **Reset database:**

    ```bash
    php artisan migrate:fresh --seed
    ```

4. **Kiểm tra .env file:**
    - `APP_DEBUG=true`
    - `APP_ENV=local`
    - `SESSION_DRIVER=file` hoặc `database`
    - Database connection đúng

5. **Kiểm tra logs:**
    ```bash
    tail -f storage/logs/laravel.log
    ```

---

## 📊 Database Status

✅ Users Table: **6 users created**

- 1 Admin
- 2 Trainers
- 2 Members
- 1 Staff

✅ All tables migrated successfully
✅ All seeders executed

---

## 🎯 Quá trình Đăng Nhập

1. Form → `POST /login`
2. AuthController→ `login()` method
3. `Auth::attempt($credentials)` → Kiểm tra email + password
4. Nếu đúng → Tạo session → Redirect theo role
5. Nếu sai → Hiển thị lỗi "Thông tin đăng nhập không hợp lệ"

---

## 🔍 Kiểm Tra Lỗi

Nếu mã lỗi xuất hiện:

- **419 Página Expirada:** Xóa cookies, thử lại
- **500 Server Error:** Kiểm tra `storage/logs/laravel.log`
- **CSRF Token Mismatch:** Clear cookies và cache
- **Invalid Credentials:** Kiểm tra email/password đúng

---

**Created:** 2026-06-24  
**Status:** ✅ Ready for Testing
