# Text2Video Project website



## Table of contents

- [Install](#install)
- [Feautures](#features)
- [How to use](#how-to-use)


## Features

- [x] Cho phép tải về các video đã xử lý.
- [x] Hiện thị lịch sử tất cả các tác vụ đã yêu cầu và xử lý.

## Install
    
- Cài đặt framework laravel, mysql
    - php>8.0
    - Tạo 1 database trong mysql.
    - Taọ file .env `cp .env.example .env`
    - Tạo khoá ứng dụng `php artisan key:generate`
    - Điền các tham số (database name, user, pass) vào trong file config .env để kết nối với mysql.
    - Chạy lệnh `php artisan migrate` để tạo bảng dữ liệu cần thiết cho ứng dụng.
    - Chạy lệnh `php artisan config:cache` để cập nhập các cấu hình.
      
- Note: Do khi gửi data (video, promt) sang AI back-end cần sửa đổi lại địa chỉ của server trên local được config bởi ngrok (hoặc ip, domain cụ thể):
    - Trong file `App\Http\Controllers\Videocontroller` thay thế biến $serverUrl bằng url cần gửi dữ liệu. </br>
   `$serverUrl = 'http://7b48-185-32-161-60.ngrok.io/';`


## How to use
- Giao diện trang chủ
<div align="center">
    <img src="https://github-production-user-asset-6210df.s3.amazonaws.com/44583838/275184004-b23d1fda-6f7b-48ca-8faf-5e1ea5a4d15b.png" width="400" alt="Giao diện web">
</div>

- Giao diện trang tạo video (chọn video > nhập Prompt mô tả > trang kết quả).
<div align="center">
    <img src="https://github-production-user-asset-6210df.s3.amazonaws.com/44583838/274682831-0e671bd3-24ce-4466-938b-5434bd470954.png" width="300" alt="Giao diện web">
    <img src="https://github-production-user-asset-6210df.s3.amazonaws.com/44583838/274684180-ba13800c-c873-494b-b747-e6506e9870df.png" width="300" alt="Giao diện web">
    <img src="https://github-production-user-asset-6210df.s3.amazonaws.com/44583838/275183941-7ffd6ca7-b2fe-4d2e-85fb-9e9f53f4baa8.png" width="300" alt="Giao diện web">
</div>






