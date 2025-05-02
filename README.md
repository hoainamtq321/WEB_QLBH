# WEB_QLBH
**Bài tập môn học: Phân tích và thiết kế hệ thống**
## Mô tả
- Mục tiêu đề tài:Quản lí bán hàng là một công việc phức tạp, dễ nhầm lẫn và khó kiểm soát. Chính vì vậy, nhằm bắt kịp xu thế thời đại và tiến tới mục tiêu hỗ trợ con người thì các hệ thống quản lí bán hàng đã ra đời giúp đơn giản hóa công việc này.
- Môi trường sử dụng: Web browser.
- 3 actors chính: Manager, Warehouse worker, Sales agent.
- Dữ liệu cần quản lý: Thông tin nhân viên, Thông tin sản phẩm, Thông tin đơn hàng.
- Chức năng Sales agent:
  - Quản lý đơn hàng: Tạo,cập nhật,huỷ đơn.
  - Quản lý khách hàng: Tạo,sửa,xoá.
- Chức năng Warehouse worker:
  - Quản lý sản phẩm: Tạo,sửa,xoá.
  - Quản lý kho: Nhập hàng,kiểm hàng.
- Chức năng Manager:
  - Toàn bộ chức năng: Sales agent và Warehouse worker.
  - Báo cáo và thống kê: Doanh thu,kho hàng.
  - Quản lý nhân sự: thêm,sửa,xoá.
- Chức năng chung:
  - Đăng nhập / đăng xuất.
  - Đổi mật khẩu.
  - Cập nhật thông tin.
 - Usecase tổng quát
![image](https://github.com/user-attachments/assets/b476483e-0468-4589-9e12-c43e80ae4ee4)

 ## Công nghệ sử dụng
 - Font-end:
   - Giao diện sử dụng HTML/CSS/JS tham khảo -> https://themewagon.com/
   - Biểu đồ báo cáo thống kê tham khảo -> https://morrisjs.github.io/morris.js/
   - Tương tác dữ liệu phía client sử dụng Ajax.
 - Backend:
   - Ứng dụng được phát triển trên nền tảng Laravel (PHP).
   - Sử dụng XAMPP để chạy server cục bộ (Apache) và quản lý cơ sở dữ liệu MySQL thông qua phpMyAdmin
   - Laravel Middleware được sử dụng để quản lý phiên làm việc (session), xác thực người dùng và phân quyền truy cập.
 ## Demo
 - Giao diện đăng nhập
![image](https://github.com/user-attachments/assets/9cdc8c12-5a8c-486d-aab6-5f310957cc33)

 - Giao trang chủ
![image](https://github.com/user-attachments/assets/55faac7d-fd1d-4ea3-a8b8-fcd280d89ece)
 - Giao diện quản lý khách hàng
![image](https://github.com/user-attachments/assets/58d752c1-51c8-4db3-bebc-1a6ae58f5464)
   - Thêm khách hàng
     ![image](https://github.com/user-attachments/assets/bf134e24-7349-416e-9509-31a47bdfe57c)

   - Cập nhật thông tin khách hàng
     ![image](https://github.com/user-attachments/assets/ddb3b349-e10e-4a9e-b2b1-6cdb8a75b2e5)

   - dfdf
 - Giao diện quản lý đơn hàng
![image](https://github.com/user-attachments/assets/99c013c4-404a-409f-a164-3746a854f7cd)
   - Tạo đơn
  ![image](https://github.com/user-attachments/assets/030bac90-0b2b-4370-aff5-04e056488bc9)

   - Cập nhật đơn
  ![image](https://github.com/user-attachments/assets/f000c281-35db-4ce7-8882-f41112492284)

 - Giao diện quản lý sản phẩm
![image](https://github.com/user-attachments/assets/903e6830-0459-4f76-bab7-465ac9f1b149)

   - Thêm sản phẩm
   ![image](https://github.com/user-attachments/assets/154119f2-04b5-4d70-9c92-7184a2b2d28f)

   - Sửa sản phẩm
   ![image](https://github.com/user-attachments/assets/29c453fb-b04f-425a-adf1-7abffa24e5da)

   - Danh sách phiếu nhập hàng
  ![image](https://github.com/user-attachments/assets/5898b336-a3a8-4ea8-91e1-103ca1b70432)
   - Tạo phiếu nhập
  ![image](https://github.com/user-attachments/assets/4d6c6cb4-f163-4afe-9bf7-2a9c332eaa77)
   - Cập nhật phiếu nhập
  
   - Danh sách phiếu kiểm hàng
   ![image](https://github.com/user-attachments/assets/70855fd0-2e95-4763-8c12-559914cb0197)
   - Tạo phiếu kiểm hàng
  ![image](https://github.com/user-attachments/assets/d3909c88-9485-42e1-a3d2-53204e2f23dd)
   - Cập nhật phiếu kiểm hàng
   ![image](https://github.com/user-attachments/assets/15c6d666-6d40-4602-bcd2-902793d4e8ea)
   - Danh sách nhà cung cấp
   ![image](https://github.com/user-attachments/assets/6496a52e-602c-4a30-90e3-cc22b83e5af0)
   - Thêm nhà cung cấp
   ![image](https://github.com/user-attachments/assets/e44369b4-b719-46b5-817f-39e26a241063)

 - Giao diện báo cáo
    ![image](https://github.com/user-attachments/assets/2944eb25-4a15-48d6-99e9-56c325198a18)

 - 
 - dfdf
 - fdf
 - dfdf
 
