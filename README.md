Ứng dụng quản lý tài chính cá nhân
API List

STT	Method	URI	Mô tả
1	POST	/api/register	Đăng ký tài khoản
2	POST	/api/login	Đăng nhập
3	GET	/api/v1/categories/incomes	Lấy danh mục khoản thu
4	POST	/api/v1/categories/incomes	Thêm danh mục khoản thu
5	PUT	/api/v1/categories/incomes/{id}	Sửa danh mục khoản thu
6	DELETE	/api/v1/categories/incomes/{id}	Xoá danh mục khoản thu
7	GET	/api/v1/categories/expenses	Lấy danh mục khoản chi
8	POST	/api/v1/categories/expenses	Tạo danh mục khoản chi
9	PUT	/api/v1/categories/expenses/{id}	Sửa danh mục khoản chi
10	DELETE	/api/v1/categories/expenses/{id}	Xoá danh mục khoản chi
11	GET	/api/v1/incomes	Lấy danh sách khoản thu
12	POST	/api/v1/incomes	Thêm khoản thu
13	PUT	/api/v1/incomes/{id}	Sửa khoản thu
14	DELETE	/api/v1/incomes/{id}	Xoá khoản thu
15	GET	/api/v1/expenses	Lấy danh sách khoản chi
16	POST	/api/v1/expenses	Thêm khoản chi
17	PUT	/api/v1/expenses/{id}	Sửa khoản chi
18	DELETE	/api/v1/expenses/{id}	Xoá khoản chi
19	GET	/api/v1/report/day-detail	Báo cáo thu chi hàng ngày
20	GET	/api/v1/report/month-summary	Báo cáo tổng tiền thu chi theo tháng
21	GET	/api/v1/report/year-summary/incomes/{year}	Báo cáo tổng thu các tháng trong năm 
22	GET	/api/v1/report/year-summary/expenses/{year}	Báo cáo tổng chi các tháng trong năm
23	GET	/api/v1/report/categories/expenses/{year}/{month?}	Thống kê tiền thu theo loại danh mục thu
24	GET	/api/v1/report/ categories/incomes/{year}/{month?}	Thống kê tiền thu theo danh mục thu
25	POST	/api/v1/reset	Xoá hết dữ liệu về mặc định
