# Session 06: Database Design

## Part 1: Normalization
Dưới đây là kết quả chuẩn hóa dữ liệu (từ 1NF → 3NF) cho hai hệ thống Blog và Hospital. Toàn bộ bảng đã loại bỏ transitive dependency, partial dependency và đạt 3NF.

| Table Name          | Primary Key     | Foreign Key                  | Normal Form | Description |
|---------------------|-----------------|------------------------------|-------------|-------------|
| users               | user_id         | None                         | 3NF         | Lưu thông tin người dùng (blog) |
| posts               | post_id         | user_id                      | 3NF         | Lưu nội dung bài viết |
| categories          | category_id     | None                         | 3NF         | Danh mục bài viết |
| post_categories     | (post_id, category_id) | post_id, category_id | 3NF         | Bảng trung gian Many-to-Many |
| comments            | comment_id      | post_id, user_id             | 3NF         | Bình luận bài viết |
| departments         | dept_id         | None                         | 3NF         | Khoa/phòng bệnh viện |
| doctors             | doctor_id       | dept_id                      | 3NF         | Thông tin bác sĩ |
| patients            | patient_id      | None                         | 3NF         | Thông tin bệnh nhân |
| appointments        | appointment_id  | patient_id, doctor_id        | 3NF         | Lịch hẹn khám |
| medical_records     | record_id       | patient_id, doctor_id        | 3NF         | Hồ sơ bệnh án |

## Part 2: Relationships
- **Users → Posts**: One-to-Many (1:N). Một user có thể viết nhiều post.
- **Posts ↔ Categories**: Many-to-Many (N:N) qua bảng `post_categories`.
- **Posts → Comments**: One-to-Many (1:N).
- **Departments → Doctors**: One-to-Many (1:N).
- **Patients → Appointments**: One-to-Many (1:N).
- **Doctors → Appointments**: One-to-Many (1:N).
- **Patients ↔ Medical_records**: One-to-Many (1:N).
- **Doctors ↔ Medical_records**: One-to-Many (1:N).

Tất cả relationship đều được triển khai bằng Foreign Key + ON DELETE CASCADE / ON UPDATE CASCADE trong SQL.
