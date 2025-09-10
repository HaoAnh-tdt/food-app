# Trang Quản Trị FoodApp - AdminLTE

## Tổng quan
Trang quản trị được xây dựng bằng AdminLTE 3 với giao diện hiện đại và đầy đủ tính năng quản lý cho ứng dụng FoodApp.

## Tính năng chính

### 1. Dashboard (Trang chủ)
- **Thống kê tổng quan**: Đơn hàng, người dùng, món ăn, doanh thu
- **Biểu đồ trực quan**: 
  - Biểu đồ khách truy cập theo thời gian
  - Biểu đồ doanh số theo tháng
  - Bảng sản phẩm bán chạy
  - Tỷ lệ chuyển đổi và bán hàng
- **Đơn hàng gần đây**: Hiển thị 10 đơn hàng mới nhất
- **Thao tác nhanh**: Các nút truy cập nhanh đến các chức năng chính

### 2. Quản lý đơn hàng
- **Danh sách đơn hàng**: Xem tất cả đơn hàng với phân trang
- **Chi tiết đơn hàng**: 
  - Thông tin khách hàng
  - Danh sách món ăn đã đặt
  - Cập nhật trạng thái đơn hàng
- **Thống kê trạng thái**: Số lượng đơn hàng theo từng trạng thái

### 3. Quản lý món ăn
- **Danh sách món ăn**: Xem tất cả món ăn với thông tin chi tiết
- **Thống kê**: Số lượng món ăn, loại món, hình ảnh
- **Thao tác**: Thêm, sửa, xóa món ăn

### 4. Quản lý loại món
- **Danh sách loại món**: Xem tất cả loại món ăn
- **Thống kê**: Số lượng món ăn trong từng loại
- **Thao tác**: Thêm, sửa, xóa loại món

### 5. Quản lý người dùng
- **Danh sách người dùng**: Xem tất cả người dùng
- **Phân loại**: Admin, Khách hàng, Nhân viên
- **Biểu đồ**: Phân bố người dùng và thống kê đăng ký
- **Thao tác**: Thêm, sửa, xóa người dùng

## Cấu trúc thư mục

```
resources/views/admin/
├── layouts/
│   └── app.blade.php          # Layout chính AdminLTE
├── dashboard.blade.php        # Trang dashboard
├── orders/
│   ├── index.blade.php        # Danh sách đơn hàng
│   └── detail.blade.php       # Chi tiết đơn hàng
├── monan/
│   └── index.blade.php        # Quản lý món ăn
├── loaimon/
│   └── index.blade.php        # Quản lý loại món
└── users/
    └── index.blade.php        # Quản lý người dùng
```

## Cách sử dụng

### 1. Truy cập trang quản trị
- Đăng nhập với tài khoản admin (loai_taikhoan = 0)
- Bấm vào "Trang quản trị" trong menu dropdown
- Hoặc truy cập trực tiếp: `/admin`

### 2. Điều hướng
- **Sidebar**: Menu điều hướng bên trái với các chức năng chính
- **Breadcrumb**: Hiển thị vị trí hiện tại trong hệ thống
- **Search**: Tìm kiếm nhanh (có thể mở rộng)
- **Notifications**: Thông báo hệ thống

### 3. Thao tác cơ bản
- **Xem**: Bấm nút "Xem" để xem chi tiết
- **Sửa**: Bấm nút "Sửa" để chỉnh sửa
- **Xóa**: Bấm nút "Xóa" để xóa (cần xác nhận)
- **Thêm**: Bấm nút "Thêm" để tạo mới

### 4. Cập nhật trạng thái đơn hàng
- Vào trang chi tiết đơn hàng
- Chọn trạng thái mới từ dropdown
- Bấm "Cập nhật" để lưu thay đổi

## Bảo mật

### Middleware
- **Auth**: Yêu cầu đăng nhập
- **Admin Check**: Chỉ admin mới có quyền truy cập

### Phân quyền
- **Admin (loai_taikhoan = 0)**: Toàn quyền truy cập
- **Khách hàng (loai_taikhoan = 1)**: Không có quyền truy cập
- **Nhân viên (loai_taikhoan = 2)**: Không có quyền truy cập

## Công nghệ sử dụng

### Frontend
- **AdminLTE 3**: Framework giao diện admin
- **Bootstrap 4**: Framework CSS
- **Font Awesome**: Icon library
- **Chart.js**: Thư viện biểu đồ
- **jQuery**: JavaScript library

### Backend
- **Laravel**: Framework PHP
- **Blade**: Template engine
- **Eloquent**: ORM

## Tùy chỉnh

### Thêm trang mới
1. Tạo controller method trong `AdminController`
2. Thêm route trong `routes/web.php`
3. Tạo view trong `resources/views/admin/`
4. Thêm menu item trong layout

### Thay đổi giao diện
- Chỉnh sửa `resources/views/admin/layouts/app.blade.php`
- Thêm CSS tùy chỉnh trong `@stack('styles')`
- Thêm JavaScript tùy chỉnh trong `@stack('scripts')`

## Lưu ý

1. **Dữ liệu mẫu**: Cần có dữ liệu trong database để hiển thị
2. **Quyền truy cập**: Chỉ admin mới có thể truy cập
3. **Responsive**: Giao diện tương thích mobile
4. **Performance**: Sử dụng pagination cho danh sách lớn

## Hỗ trợ

Nếu có vấn đề hoặc cần hỗ trợ, vui lòng liên hệ:
- Email: support@foodapp.com
- Documentation: https://docs.foodapp.com/admin
