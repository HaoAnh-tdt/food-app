# Food App - Ứng dụng Ẩm thực

Ứng dụng web Laravel về ẩm thực với các tính năng quản lý món ăn, loại món và hình ảnh.

## Tính năng

- Hiển thị danh sách món ăn
- Phân loại món ăn theo loại
- Quản lý hình ảnh món ăn
- Giao diện responsive

## Cài đặt

### Yêu cầu hệ thống

- PHP 8.1+
- Composer
- MySQL 5.7+
- Node.js & NPM (cho Vite)

### Cài đặt local

1. Clone repository:
```bash
git clone <repository-url>
cd food-app
```

2. Cài đặt dependencies:
```bash
composer install
npm install
```

3. Tạo file .env:
```bash
cp env.example .env
```

4. Cấu hình database trong .env

5. Tạo key ứng dụng:
```bash
php artisan key:generate
```

6. Chạy migrations và seeders:
```bash
php artisan migrate
php artisan db:seed
```

7. Build assets:
```bash
npm run build
```

8. Chạy ứng dụng:
```bash
php artisan serve
```

## Deploy trên Render

### Cách 1: Sử dụng render.yaml (Khuyến nghị)

1. Push code lên GitHub
2. Kết nối repository với Render
3. Render sẽ tự động detect file `render.yaml` và deploy

### Cách 2: Deploy thủ công

1. Tạo Web Service trên Render
2. Chọn Docker environment
3. Cấu hình:
   - Build Command: `composer install --no-dev --optimize-autoloader --no-interaction`
   - Start Command: `php artisan serve --host=0.0.0.0 --port=$PORT`

### Cấu hình Database

1. Tạo MySQL Database trên Render
2. Cập nhật các biến môi trường:
   - `DB_HOST`
   - `DB_PORT`
   - `DB_DATABASE`
   - `DB_USERNAME`
   - `DB_PASSWORD`

## Cấu trúc Database

### Bảng `loaimonan`
- `maloai` (PK): Mã loại món
- `tenloai`: Tên loại món

### Bảng `monan`
- `mamonan` (PK): Mã món ăn
- `tenmonan`: Tên món ăn
- `giamonan`: Giá món ăn
- `maloai` (FK): Mã loại món
- `mota`: Mô tả món ăn

### Bảng `hinhanh`
- `mahinhanh` (PK): Mã hình ảnh
- `tenhinhanh`: Tên file hình ảnh
- `mamonan` (FK): Mã món ăn

## Routes

- `/` - Trang chủ
- `/monan` - Danh sách món ăn
- `/monan/{maloai}` - Món ăn theo loại

## Tác giả

Food App Team

## License

MIT License
