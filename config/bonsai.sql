SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--  ---  ---  ---  ---  ---  ---  ---  ---  ---  ---  ---  ---  ---  ---  ---  ---  ---  ---  ---  ---  ---  ---  ---  ---  ---  ---  ---  ---  ---  ---  ---  ---  -


drop database bonsai;
create database bonsai;
use bonsai;

--  -Tạo bảng Accounts (bảng tài khoản người dùng)--  -
create table accounts(
   account_id int auto_increment,
   email varchar(50),
   username varchar(50),
   pwd varchar(50),
   account_role int,
   primary key(account_id,email)
   
);

--  -Tạo bảng Customers (bảng thông tin người dùng)--  -
create table customers(
	customer_id int auto_increment,
	account_id int,
    phone char(15),
    email varchar(50),
    fullname varchar(50),
    birthday date,
    sex varchar(10),
    address varchar(50),
    identity_id varchar(50),

    primary key(customer_id,account_id,email)
);

--  -Tạo bảng Bonsai (bảng thông tin cây kiểng)--  -
create table bonsai(
	bonsai_id int primary key auto_increment,
    bonsai_name varchar(50),
    bonsai_img varchar(50),
    type_id int,
    describe_bonsai varchar(500),
    amount int,
    price float,
    status_id int
);

--  -Tạo bảng Loại cây kiểng--  -
create table bonsaiType(
	type_id int primary key auto_increment,
	type_name varchar(50)
);

--  -Tạo bảng Giỏ hàng--  -
create table cart(
	cart_id int auto_increment,
	customer_id int,
    bonsai_id int,
    amount int,
    constraint pk primary key(cart_id,customer_id)
);

--  -Tạo bảng Hóa đơn--  -
create table receipt(
	receipt_id int auto_increment,
    customer_id int,
    cart_id int,
    day_buy date,
    sum_price double,
    receipt_status int,
    constraint pk primary key(receipt_id,customer_id,cart_id)
);

--  -Tạo bảng Thanh toán--  -
create table payment(
	payment_id int auto_increment,
    receipt_id int,
    payment_date int,
    payment_type int,
    payment_status int,
    constraint pk primary key(payment_id,receipt_id)
);

--  -Tạo bảng phương thức thanh toán--  -
create table banking(
	id_card char(15) primary key,
    ccv int,
    card_status int
);

--  -Thêm khóa ngoại cho bảng customers--  -
alter table customers
add constraint account_id_fk foreign key(account_id,email) references accounts(account_id,email);

--  -Thêm khóa ngoại cho bảng bonsai--  -
alter table bonsai
add constraint type_id_fk foreign key(type_id) references bonsaiType(type_id);

--  -Thêm khóa ngoại cho bảng cart--  -
alter table cart
add constraint customer_id_fk foreign key(customer_id) references customers(customer_id),
add constraint bonsai_id_fk foreign key(bonsai_id) references bonsai(bonsai_id);

--  -Thêm khóa ngoại cho bảng receipt--  -
alter table receipt
add constraint customer_id2_fk foreign key(customer_id) references customers(customer_id),
add constraint cart_id_fk foreign key(cart_id) references cart(cart_id);

--  -Thêm khóa ngoại cho bảng payment--  -
alter table payment
add constraint receipt_id_fk foreign key(receipt_id) references receipt(receipt_id);


--  -Thêm dữ liệu(tài khoản người dùng) vào bảng account--  -
insert into accounts(email,username,pwd,account_role) values
('admin@gmail.com','admin','123456',1),
('user1@gmail.com','user1','123456',0),
('user2@gmail.com','user2','123456',0),
('user3@gmail.com','user3','123456',0),
('user4@gmail.com','user4','123456',0),
('user5@gmail.com','user5','123456',0),
('user6@gmail.com','user6','123456',0),
('user7@gmail.com','user7','123456',0),
('user8@gmail.com','user8','123456',0),
('user9@gmail.com','user9','123456',0),
('user10@gmail.com','user10','123456',0),
('user11@gmail.com','user11','123456',0),
('khacvanone@gmail.com','user12','123456',0);

--  -Hiện tất cả dữ liệu trong bảng accounts--  -
select * from accounts;

--  -Thêm dữ liệu(thông tin người dùng) cho bảng customers--  -
insert into customers(account_id,phone,email,fullname,birthday,sex,address,identity_id) value
(2,'0985042415','user1@gmail.com','Nguyễn Văn Khoa','2000/12/12','Nam','Thới An, Quận 7, TP HCM','030404020298'),
(3,'0931234567','user2@gmail.com','Trần Tuyết My','1998/3/4','Nữ','Lê Văn Quới, Quận Bình Tân, TP HCM','030401234567'),
(4,'0334567893','user3@gmail.com','Mai Văn Mạnh','1980/6/3','Nam','Lý Thái Tổ, Quận 5, TP HCM','030401345627'),
(5,'0324567834','user4@gmail.com','Lê Thu Hồng','1997/10/21','Nữ','3 tháng 2, Quận 10, TP HCM','030402341234'),
(6,'0987654321','user5@gmail.com','Nguyễn Hiền','1985/2/12','Nam','Nguyễn Thị Thập, Quận 7, TP HCM','030403453455'),
(7,'0984567891','user6@gmail.com','Trương Tuyết Nhi','1990/1/11','Nữ','Nguyễn Sơn, Quận Bình Tân, TP HCM','030408766789'),
(8,'0334523498','user7@gmail.com','Bùi Mỹ Anh','1993/6/6','Nữ','Vườn Lài, Quận Tân Phú, TP HCM','030409874321'),
(9,'0324564567','user8@gmail.com','Trần Anh Khoa','1999/4/18','Nam','Lê Văn Lương, Quận 7, TP HCM','030405677658'),
(10,'0986540345','user9@gmail.com','Lê Văn Đạt','1992/8/14','Nam','Gò Xoài, Quận Bình Tân, TP HCM','030400986783'),
(11,'0327809743','user10@gmail.com','Phạm Thị Thúy Diễm','1990/12/2','Nữ','Lưu Hữu Phước, Quận 8, TP HCM','030403456787'),
(12,'0324456565','user11@gmail.com','Cao Kiến Hồng','1995/7/4','Nam','Hoàng Diệu, Quận 4, TP HCM','030407654321'),
(13,'0324456565','khacvanone@gmail.com','Khắc Văn','1995/7/4','Nam','Hoàng Diệu, Quận 4, TP HCM','030407654321');

--  -Hiện tất cả dữ liệu trong bảng customers--  -
select * from customers;

--  -Thêm dữ liệu(loại cây kiểng) cho bảng bonsaiType--  -
insert into bonsaiType(type_name) values
('Office Plant'),
('Gift Plant'),
('Bonsai'),
('Home Plant');

--  -Thêm dữ liệu(thông tin cây kiểng) cho bảng bonsai--  -
insert into bonsai(bonsai_name,bonsai_img,type_id,describe_bonsai,amount,price,status_id) values
('Cây Linh Sam','../uploads/Bonsai/bonsai1.jpg',3,'LINH SAM Là một trong những loại cây, được trong giới chơi bonsai đánh giá cao, ưa chuộng nhất hiện nay, và cũng không thể thiếu trong bộ sưu tập bonsai trong vườn kiểng của mọi người',5,1000000,0),
('Cây Kim Ngân','../uploads/Bonsai/bonsai2.jpg',3,'Cây Kim Ngân là loại cây cảnh trong nhà được trồng phổ biến trên khắp thế giới, nó có sức ảnh hưởng tới mức mà hầu như ai cũng tin rằng khi trồng có thể mang lại nhiều may mắn trong cuộc sống, công việc hoặc làm ăn',5,1200000,1),
('Cây trầu bà leo cột','../uploads/Bonsai/bonsai3.jpg',3,'Cây trầu bà leo cột mang dáng vẻ thanh lịch và sang trọng, không chỉ có tác dụng thanh lọc không khí trong nhà mà còn chứa đựng ý nghĩa phong thủy rất tốt.',0,1250000,0),
('Cây phát tài núi hai tầng ','../uploads/Bonsai/bonsai5.jpg',3,'Cây phát tài núi rất thường được lựa chọn để làm quà tặng vào những dịp khai trương, lên nhà mới, văn phòng mới… với mong muốn đem lại nhiều tài lộc và may mắn cho người được tặng,',6,2500000,1),
('Cây Bàng Nhật cẩm thạch','../uploads/Bonsai/bonsai6.jpg',3,'Là dòng cây bóng mát có tán lá xếp tầng mang vẻ đẹp hiện đại, có tốc độ phát triển nhanh.',8,950000,1),
('Cây trầu bà cột chậu đá mài trụ vuông	','../uploads/Bonsai/bonsai4.jpg',3,'Có tác dụng thanh lọc không khí trong nhà mà còn chứa đựng ý nghĩa phong thủy rất tốt, mang dáng vẻ thanh lịch và sang trọng.',4,1250000,1),
('Cây bàng Singapore','../uploads/Bonsai/bonsai7.jpg',3,'Bàng Singapore là loại cây nội thất đang được ưa chuộng nhất hiện nay bởi cây có khả năng cải thiện chất lượng không khí mang lại sự xanh mát và sang trọng cho không gian.',10,420000,1),
('Cây tróc bạc ‘Albo Variegata’','../uploads/GiftPlant/gift1.jpg',2,'Tróc bạc Albo là loại cây có thể phát triển tốt ngay cả trong điều kiện thiếu sáng, do đó bạn sẽ không phải quá lo lắng khi trồng chúng trong nhà',8,360000,1),
('Cây tróc bạc hồng ‘Neon Robusta’','../uploads/GiftPlant/gift2.jpg',2,'Tróc bạc hồng là loài cây có sức sống rất khỏe mạnh, phát triển nhanh và ít cần phải chăm sóc. Cây phát triển theo dạng dây leo, hình dáng lá như mũi tên nên có tên gọi “Arrowhead Plant” trong tiếng Anh.',15,240000,1),
('Cây trầu bà thanh xuân','../uploads/GiftPlant/gift3.jpg',2,'Trầu bà thanh xuân vàng là loại cây có màu sắc gây ấn tượng, bởi chúng hoàn toàn được “phủ” bởi màu vàng rực rỡ. Nếu như bạn đang muốn mang thêm sắc màu vào không gian sống thì hãy cân nhắc tới loại cây này.',10,380000,1),
('Cây cầu nguyện Maranta leuconeura','../uploads/GiftPlant/gift4.jpg',2,'Maranta leuconeura là một loại cây nội thất rất được ưu thích tại các nước Châu Âu. ',12,250000,1),
('Cây hồng hạc thân cam “Billietiae’','../uploads/GiftPlant/gift5.jpg',2,'Cây Hạc Cam đặc trưng bởi những chiếc lá thuôn dài, hình dây đeo có xẻ trái tim sâu, phần cuống cũng được tô điểm bởi màu da cam rất bắt mắt.',8,1500000,1),
('Cây trầu bà đế vương xanh','../uploads/GiftPlant/gift6.jpg',2,'Trầu Bà Đế Vương có tên tiếng Anh là Philodendron Imperial thuộc họ Araceae (Ráy), là dòng cây thân thảo, trong tự nhiên.',7,850000,1),
('Cây đuôi công nữ thần xanh Green Goddess','../uploads/GiftPlant/gift7.jpg',2,'Loài cây đuôi công này được trồng rất phổ biến trong nội thất với mục đích trang trí, tạo thêm mảnh xanh và thanh lọc không khí.',5,850000,1),
('Cây môn quan âm để bàn Alocasia Polly','../uploads/GiftPlant/gift8.jpg',2,'Điểm nổi bật nhất ở Môn Quan Âm là hình dáng lá độc đáo.',8,350000,1),
('Cây Đuôi công xương','../uploads/HomePlant/home1.jpg',4,'Cây đuôi công thường được chọn để mang lại không gian xanh mát cho phòng làm việc, phòng làm việc, văn phòng, quán cafe,…',10,200000,1),
('Cây dương xỉ phượng hoàng','../uploads/HomePlant/home2.jpg',4,'Cây dương xỉ phượng hoàng là một loại cây nội thất có tán lá xòe tròn đẹp mắt, thích hợp đặt trong những không gian hiện đại và sang trọng.',15,200000,1),
('Cây philodendron mayoi leo cột','../uploads/HomePlant/home3.jpg',4,'Philodendron Mayoi là một loại cây nội thất cao cấp có hình dáng lá độc đáo, thích hợp đặt trong những không gian hiện đại và sang trọng.',6,650000,1),
('Cây đuôi công táo xanh','../uploads/HomePlant/home4.jpg',4,'Với tán lá tròn trịa xoè rộng phủ xanh cả khu vườn nhỏ, bạn chỉ cần trồng vài cây Orbifolia là không khí tropical mát mẻ đã về với không gian nhà rồi đó.',8,450000,1),
('Cây đuôi công đốm','../uploads/HomePlant/home5.jpg',4,'Loài cây đuôi công này được trồng rất phổ biến trong nội thất với mục đích trang trí, tạo thêm mảnh xanh và thanh lọc không khí, họa tiết lá rất sang trọng.',10,220000,1),
('Cây Trầu Bà Lỗ','../uploads/HomePlant/home6.jpg',4,'Monstera adansonii là cây thân thảo, thích nghi với bóng râm hoàn toàn, vì vậy chúng thường được trồng trong nhà, sức sống mạnh mẽ.',5,350000,1),
('Cây quà tặng mix','../uploads/HomePlant/home7.jpg',4,'Cây xanh sẽ là món quà tặng tuyệt vời mang lại nhiều ý nghĩa, giúp gắn kết giữa bạn với người được tặng.',7,420000,1),
('Cây lưỡi hổ vàng','../uploads/OfficePlant/office1.jpg',1,'Lưỡi hổ có lẽ là loại cây nội thất quen thuộc nhất đối với những người yêu cây cảnh.',9,860000,1),
('Cây lưỡi hổ vàng chậu đá','../uploads/OfficePlant/office2.jpg',1,'Lưỡi hổ có lẽ là loại cây nội thất quen thuộc nhất đối với những người yêu cây cảnh.',5,780000,1),
('Cây Trầu Bà Tim Xanh','../uploads/OfficePlant/office3.jpg',1,'Trầu bà tim xanh (Philodendron scandens) sở hữu những chiếc lá màu xanh bóng hình trái tim quyến rũ, có thể trồng theo phong cách thả xuống trên kệ trang trí.',10,180000,1),
('Cây kim ngân thắt bính','../uploads/OfficePlant/office4.jpg',1,'Cây kim ngân là loại cây phong thủy tượng trưng cho tiền bạc và tài lộc có tác dụng giúp mang lại tiền tài, sự giàu có, thịnh vượng cho gia chủ.',6,550000,1),
('Cây trúc mây','../uploads/OfficePlant/office5.jpg',1,'Cây trúc mây không chỉ mang lại ý nghĩa phong thủy tốt đẹp mà còn nó đánh giá là có khả năng giúp hấp thụ các loại chất khí độc hại.',9,240000,1),
('Cây lưỡi hổ xanh ‘Zeylanica’','../uploads/OfficePlant/office6.jpg',1,'Loài cây này có khả năng chịu nóng, chịu hạn tốt, sống được trong bóng râm và đặc biệt nó có khả năng lọc không khí rất tuyệt vời.',8,150000,1),
('Cây Đuôi công xương cá Calathea burle-marxii','../uploads/OfficePlant/office7.jpg',1,'Cây đuôi công thường được chọn để mang lại không gian xanh mát cho phòng làm việc, phòng làm việc, văn phòng, quán cafe,…',5,340000,1),
('Cây Vạn Lộc','../uploads/OfficePlant/office8.jpg',1,'Cây vạn lộc (Aglaonema Lady Valentine) là dòng cây cảnh nội thất dễ chăm sóc, có thể sống được trong điều kiện ánh sáng thấp.',15,180000,1);

--  -Hiển thị tất cả dữ liệu của bảng bonsai--  -
select * from bonsai;

--  -Thêm dữ liệu cho bảng cart--  -
insert into cart(customer_id,bonsai_id,amount) values
(1,2,1),
(3,16,3),
(2,6,1),
(4,10,2),
(1,3,3),
(5,4,1),
(1,6,2);

--  -Hiển thị tất cả dữ liệu của bảng cart--  -
select * from cart where customer_id=1;

--  -Thêm dữ liệu cho bảng receipt--  -
insert into receipt(customer_id,cart_id,day_buy,sum_price,receipt_status) values
(2,2,'2022/11/19',1200000,2),
(3,2,'2022/11/25',600000,2),
(2,3,'2022/11/30',1250000,1),
(4,4,'2022/12/1',760000,1),
(5,5,'2022/12/3',2500000,0);

--  -Hiển thị tất cả dữ liệu của bảng  rêcipt--  -
select * from receipt;

--  -Thêm dữ liệu cho bảng payment--  -
insert into payment(receipt_id,payment_date,payment_type,payment_status) values
(2,'2022/11/19',2,1),
(2,'2022/11/30',1,1),
(3,'2022/11/30',2,1),
(4,'2022/12/10',1,0),
(5,'2022/12/3',2,1);

--  -Hiển thị tất cả dữ liệu của bảng receipt--  -
select * from receipt;


select * from cart where customer_id 
                            in(select account_id-1 from accounts where username='user1');

--  ---  ---  ---  ---  ---  ---  ---  ---  ---  ---  ---  ---  ---  ---  ---  ---  ---  ---  ---  ---  ---  ---  ---  ---  ---  ---  ---  ---  ---  ---  ---  ---  -
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;









