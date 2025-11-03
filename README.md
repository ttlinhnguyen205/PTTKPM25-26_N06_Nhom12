# BookStore Management
## Thành viên:
| STT       | Thành viên            | Mã sinh viên         | Vai trò |    
|-----------|-----------------------|----------------------|--------- |
| 1         | Nguyễn Thị Thùy Linh  | 23010633             |          |
| 2         | Nguyễn Anh Quân       | 23010375             |          |

## Tổng quan dự án:
### 1. Yêu cầu:
Trong những năm gần đây, nhu cầu mua sắm trực tuyến ngày càng phổ biến, đặc biệt là trong lĩnh vực sách – một mặt hàng có lượng tiêu thụ lớn và ổn định. Việc bán sách theo hình thức truyền thống gặp nhiều hạn chế như tốn chi phí mặt bằng, khó mở rộng quy mô và hạn chế khả năng tiếp cận khách hàng ở xa. Do đó, các website bán sách trực tuyến đã trở thành giải pháp ưu việt, giúp tối ưu hóa việc phân phối sách đến tay người đọc một cách nhanh chóng và thuận tiện. Tuy nhiên, nhiều hệ thống hiện nay vẫn còn rườm rà, thiếu trực quan, gây khó khăn trong việc tìm kiếm sách, theo dõi đơn hàng hoặc thanh toán. Điều này làm giảm trải nghiệm người dùng, ảnh hưởng đến doanh thu và mức độ hài lòng của khách hàng.
Xuất phát từ thực tế đó, nhóm chúng em tiến hành xây dựng dự án “Website bán sách trực tuyến” với mục tiêu mô phỏng đầy đủ các chức năng cơ bản của một hệ thống thương mại điện tử, đồng thời tối ưu hóa trải nghiệm người dùng.
Dự án được triển khai bằng Laravel Framework – một nền tảng PHP mạnh mẽ, dễ mở rộng và phù hợp cho các dự án web quy mô trung bình đến lớn.
### 2. Mục tiêu của dự án:
Xây dựng một hệ thống website bán sách có đầy đủ chức năng cơ bản: tìm kiếm sách, xem chi tiết, thêm vào giỏ hàng, đăng ký – đăng nhập, đặt hàng và thanh toán.
### 3. Đối tượng sử dụng:
Hệ thống website bán sách được thiết kế để phục vụ quá trình mua – bán sách trực tuyến một cách hiệu quả, tiện lợi và nhanh chóng. Hệ thống đáp ứng nhu cầu cho cả hai nhóm người dùng chính bao gồm quản trị viên và khách hàng sử dụng website. Người dùng sẽ cần đăng nhập tài khoản để có thể truy cập và sử dụng các chức năng trên hệ thống. Tài khoản admin chỉ có thể được tạo và cấp quyền bởi quản trị viên hệ thống, và mỗi loại tài khoản sẽ có những giới hạn riêng về quyền truy cập như sau:
Khách hàng cuối (End-users) – Người mua sách: Là người dùng chính của hệ thống, bao gồm các cá nhân muốn mua sách trực tuyến. Họ có thể là học sinh, sinh viên, giáo viên, phụ huynh hoặc độc giả yêu thích sách. Người dùng sẽ cần đăng nhập để sử dụng các chức năng như tìm kiếm sách theo nhu cầu, xem chi tiết sản phẩm, thêm sách vào giỏ hàng, thanh toán, theo dõi đơn hàng và lịch sử mua. Khách hàng không có quyền chỉnh sửa thông tin sản phẩm hay dữ liệu hệ thống.
Quản trị viên (Admin): Là tài khoản do hệ thống cấp quyền riêng biệt, có toàn quyền truy cập và chỉnh sửa hệ thống. Admin có thể thêm, sửa, xóa thông tin sách, quản lý danh mục sản phẩm, xử lý đơn hàng của khách hàng, và quản lý dữ liệu người dùng. Admin cũng có thể xem thống kê doanh thu và hoạt động bán hàng trên hệ thống.
Việc phân chia quyền hạn rõ ràng giữa hai loại người dùng giúp hệ thống hoạt động ổn định, bảo mật và hiệu quả hơn trong môi trường bán hàng trực tuyến.
### 4. Các Actor trong hệ thống
Nhóm người dùng	Chức năng
##### Khách hàng (User)	
- Đăng ký/Đăng nhập
- Xem danh sách sách
- Lọc sách
- Xem chi tiết sách
- Thêm vào giỏ hàng
- Thanh toán
- Xem lịch sử đơn hang
- Cập nhật thông tin cá nhân
- Đăng xuất
#### Quản trị viên (Admin)	
- Đăng nhập
- Quản lý sách (thêm/sửa/xoá)
- Quản lý người dùng
- Quản lý đơn hàng
- Cập nhật thông tin admin
- Đăng xuất
