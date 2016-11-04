-- 两个中划线+空格：表示注释

-- 创建数据库
create database student charset utf8; -- 创建一个叫做叫做student的数据库，字符集是utf8，不支持中划线

-- 查看数据库
show databases;

-- 创建一个关键字数据库
create database database charset gbk;	-- 字符集采用GBK，错误：不能直接使用关键字
create database `database` charset gbk;	-- 字符集采用GBK，采用反引号包裹关键字

-- 创建中文数据库
create database 中国 charset gbk;	-- 中文数据库名字：不行

-- 设定字符集
set names gbk;	-- 告诉服务器：当前给你的数据是gbk编码，接收的时候应该按照gbk来接收

-- 创建数据库
create database student_info charset utf8;
create database studentinfo charset utf8;

-- 查询以student开始的数据库
show databases like 'student%';

-- 查询以student_开始的数据库
show databases like 'student_%';		-- 查到是student开始的所有数据库

-- 如果要匹配下划线，必须使用转义符号
show databases like 'student\_%';

-- 查看数据库创建语句
show create database student_info;

-- 修改数据库的字符集：utf8-gbk
alter database student_info charset gbk;

-- 删除数据库
drop database studentinfo;
drop database 中国;


-- 创建数据表
create table student(
stu_id int,
stu_name varchar(10),
stu_age int		-- 最后一个字段不需要逗号
)charset utf8;		-- 使用默认的存储引擎：InnoDB

-- 显示指定数据库
create table student.student(
stu_id int,
stu_name varchar(10),
stu_age int		-- 最后一个字段不需要逗号
)charset utf8;		-- 使用默认的存储引擎：InnoDB

-- 隐式指定数据库
-- 进入数据库
use student;

-- 创建表
create table class(
c_id int,
c_name varchar(10)
)charset utf8 engine = myisam;

-- 查看表
show tables;

-- 查看部分表
show tables like 'stu%';

-- 查看表创建语句
show create table student;

-- 查看表结构
desc student;

-- 删除表
drop table class;

-- 修改表的存储引擎
alter table student engine = myisam;

-- 更新表名
rename table student to stu_student;

-- 增加字段
alter table stu_student add column stu_height int; -- 字段必须跟数据类型

-- 修改字段名字
alter table stu_student change stu_id id int;

-- 修改数据类型
alter table stu_student modify stu_name varchar(20);

-- 删除字段
alter table stu_student drop stu_height;

-- 增加height字段，在age之前
alter table stu_student add stu_height int after stu_name;

-- 插入数据
-- 不指定字段表示全部字段
insert into stu_student values('1','潘若恒','180',20);

-- 指定部分字段
insert into stu_student (stu_name,stu_height,stu_age) values('樊雷','190','22');

-- 错误：字段与值列表顺序不对
insert into stu_student (stu_name,stu_height,stu_age) values(18,'庄翠萍',180);

-- 查看全部数据
select * from stu_student;

-- 查看部分字段
select stu_name,stu_height,stu_age from stu_student;

-- 查看id为1的数据
select * from stu_student where id = 1; -- where返回的结果是1或者0

-- 更新数据：更改全部的年龄
update stu_student set stu_age = 1;

-- 更新部分结果
update stu_student set id = 2 where id = null; -- null不能使用运算符
update stu_student set id = 2 where id is null;

-- 删除数据
delete from stu_student where id = 1;
