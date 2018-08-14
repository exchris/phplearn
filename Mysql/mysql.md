<!-- START doctoc generated TOC please keep comment here to allow auto update -->
<!-- DON'T EDIT THIS SECTION, INSTEAD RE-RUN doctoc TO UPDATE -->
## mysql基础

- [登录](#%E7%99%BB%E5%BD%95)
- [退出](#%E9%80%80%E5%87%BA)
- [库操作](#%E5%BA%93%E6%93%8D%E4%BD%9C)
  - [新增数据库](#%E6%96%B0%E5%A2%9E%E6%95%B0%E6%8D%AE%E5%BA%93)
  - [查询数据库](#%E6%9F%A5%E8%AF%A2%E6%95%B0%E6%8D%AE%E5%BA%93)
  - [更新数据库](#%E6%9B%B4%E6%96%B0%E6%95%B0%E6%8D%AE%E5%BA%93)
  - [删除数据库](#%E5%88%A0%E9%99%A4%E6%95%B0%E6%8D%AE%E5%BA%93)
- [表操作](#%E8%A1%A8%E6%93%8D%E4%BD%9C)
  - [获取表数据结构](#%E8%8E%B7%E5%8F%96%E8%A1%A8%E6%95%B0%E6%8D%AE%E7%BB%93%E6%9E%84)
  - [新增表](#%E6%96%B0%E5%A2%9E%E8%A1%A8)
  - [查询表](#%E6%9F%A5%E8%AF%A2%E8%A1%A8)
  - [更新表](#%E6%9B%B4%E6%96%B0%E8%A1%A8)
  - [删除表](#%E5%88%A0%E9%99%A4%E8%A1%A8)
- [列属性](#%E5%88%97%E5%B1%9E%E6%80%A7)
  - [空值](#%E7%A9%BA%E5%80%BC)
  - [描述](#%E6%8F%8F%E8%BF%B0)
  - [默认值](#%E9%BB%98%E8%AE%A4%E5%80%BC)
  - [主键](#%E4%B8%BB%E9%94%AE)
  - [唯一键](#%E5%94%AF%E4%B8%80%E9%94%AE)
  - [自增长](#%E8%87%AA%E5%A2%9E%E9%95%BF)
- [数据操作](#%E6%95%B0%E6%8D%AE%E6%93%8D%E4%BD%9C)
  - [更新数据](#%E6%9B%B4%E6%96%B0%E6%95%B0%E6%8D%AE)
  - [查询数据](#%E6%9F%A5%E8%AF%A2%E6%95%B0%E6%8D%AE)
  - [更新数据](#%E6%9B%B4%E6%96%B0%E6%95%B0%E6%8D%AE-1)
  - [删除数据](#%E5%88%A0%E9%99%A4%E6%95%B0%E6%8D%AE)
- [数据类型](#%E6%95%B0%E6%8D%AE%E7%B1%BB%E5%9E%8B)
  - [整数型](#%E6%95%B4%E6%95%B0%E5%9E%8B)
  - [小数型](#%E5%B0%8F%E6%95%B0%E5%9E%8B)
  - [日期类型](#%E6%97%A5%E6%9C%9F%E7%B1%BB%E5%9E%8B)
  - [字符串型](#%E5%AD%97%E7%AC%A6%E4%B8%B2%E5%9E%8B)
- [连接](#%E8%BF%9E%E6%8E%A5)
  - [内连接](#%E5%86%85%E8%BF%9E%E6%8E%A5)
  - [左连接](#%E5%B7%A6%E8%BF%9E%E6%8E%A5)
  - [右连接](#%E5%8F%B3%E8%BF%9E%E6%8E%A5)
  - [交叉连接(笛卡尔积)](#%E4%BA%A4%E5%8F%89%E8%BF%9E%E6%8E%A5%E7%AC%9B%E5%8D%A1%E5%B0%94%E7%A7%AF)
  - [全连接](#%E5%85%A8%E8%BF%9E%E6%8E%A5)
  - [联合](#%E8%81%94%E5%90%88)
  - [子查询](#%E5%AD%90%E6%9F%A5%E8%AF%A2)
- [高级](#%E9%AB%98%E7%BA%A7)
  - [视图](#%E8%A7%86%E5%9B%BE)
  - [事物](#%E4%BA%8B%E7%89%A9)
  - [触发器](#%E8%A7%A6%E5%8F%91%E5%99%A8)
  - [函数](#%E5%87%BD%E6%95%B0)
  - [存储过程](#%E5%AD%98%E5%82%A8%E8%BF%87%E7%A8%8B)
- [备份与还原](#%E5%A4%87%E4%BB%BD%E4%B8%8E%E8%BF%98%E5%8E%9F)
  - [单数据](#%E5%8D%95%E6%95%B0%E6%8D%AE)
  - [sql备份](#sql%E5%A4%87%E4%BB%BD)
- [参考](#%E5%8F%82%E8%80%83)

<!-- END doctoc generated TOC please keep comment here to allow auto update -->

- DB：Database，数据库；
- DBMS：Database Management System，数据库管理系统；
- DBS：Database System = DBMS + DB，数据库系统；
- DBA：Database Administrator，数据库管理员。
- DDL：Data Definition Language，数据定义语言，用来维护存储数据的结构（数据库、表），代表指令为create、drop和alter等。
- DML：Data Manipulation Language，数据操作语言，用来对数据进行操作（表中的内容）代表指令为insert、delete和update等，不过在 DML 内部又单独进行了一个分类，即 DQL（Data Query Language），数据查询语言，代表指令为select.
- DCL：Data Control Language，数据控制语言，主要是负责（用户）权限管理，代表指令为grant和revoke等。


## 登录
```mql
mysql [-h localhost] [-P 3306] -u root -p[password] [database];
```
<br>[⬆ Back to top](#mysql%E5%9F%BA%E6%9C%AC%E6%93%8D%E4%BD%9C)

## 退出
```sql
exit 或 quit 或 \q
```
<br>[⬆ Back to top](#mysql%E5%9F%BA%E6%9C%AC%E6%93%8D%E4%BD%9C)

## 库操作
### 新增数据库
```sql
create database [database_name] charset utf8;
```
<br>[⬆ Back to top](#mysql%E5%9F%BA%E6%9C%AC%E6%93%8D%E4%BD%9C)

### 查询数据库
```sql
show databases [like 'pattern'];
```
<br>[⬆ Back to top](#mysql%E5%9F%BA%E6%9C%AC%E6%93%8D%E4%BD%9C)

### 更新数据库
```sql
alter database database_name  charset gbk;
```
<br>[⬆ Back to top](#mysql%E5%9F%BA%E6%9C%AC%E6%93%8D%E4%BD%9C)

### 删除数据库
```sql
drop database database_name;
```
<br>[⬆ Back to top](#mysql%E5%9F%BA%E6%9C%AC%E6%93%8D%E4%BD%9C)

## 表操作
### 获取表数据结构
```sql
desc table_name;
show columns from table_name;
```
<br>[⬆ Back to top](#mysql%E5%9F%BA%E6%9C%AC%E6%93%8D%E4%BD%9C)

### 新增表
```sql
CREATE TABLE `users` (
	`id` INT(11) NOT NULL AUTO_INCREMENT COMMENT 'id',
	`username` VARCHAR(50) NULL DEFAULT NULL COMMENT '姓名',
	`password` VARCHAR(50) NULL DEFAULT NULL COMMENT '密码',
	`sex` TINYINT(4) NULL DEFAULT NULL COMMENT '性别',
	`create_time` DATETIME NULL DEFAULT CURRENT_TIMESTAMP COMMENT '创建时间',
	`modified_time` DATETIME NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '修改时间',
	PRIMARY KEY (`id`),
	UNIQUE INDEX `username` (`username`)
)
COMMENT='表名'
ENGINE=InnoDB
;
```
<br>[⬆ Back to top](#mysql%E5%9F%BA%E6%9C%AC%E6%93%8D%E4%BD%9C)

### 查询表
```sql
show tables [like 'pattern'];
```
<br>[⬆ Back to top](#mysql%E5%9F%BA%E6%9C%AC%E6%93%8D%E4%BD%9C)

### 更新表
```sql
rename table old_table_name to new_table_name;
alter table table_name [add | change column | drop ] column_name [column_value] [position];
```
<br>[⬆ Back to top](#mysql%E5%9F%BA%E6%9C%AC%E6%93%8D%E4%BD%9C)

### 删除表
```sql
drop table table_name1 [,table_name2,table_name3...];
```
<br>[⬆ Back to top](#mysql%E5%9F%BA%E6%9C%AC%E6%93%8D%E4%BD%9C)

## 列属性
### 空值
```sql
username varchar(50) [not] null;
```
<br>[⬆ Back to top](#mysql%E5%9F%BA%E6%9C%AC%E6%93%8D%E4%BD%9C)

### 描述
```sql
username varchar(50) null comment '用户名';
```
<br>[⬆ Back to top](#mysql%E5%9F%BA%E6%9C%AC%E6%93%8D%E4%BD%9C)

### 默认值
```sql
username varchar(50) null default null comment '用户名';
```
<br>[⬆ Back to top](#mysql%E5%9F%BA%E6%9C%AC%E6%93%8D%E4%BD%9C)

### 主键
```sql
-- add 
id int(11) not null primary key comment '用户名';
-- OR
PRIMARY KEY (`id`),
-- OR
alter table table_name add primary key(id);
-- delete
alter table table_name  drop primary key;
-- update = delete+add
```
<br>[⬆ Back to top](#mysql%E5%9F%BA%E6%9C%AC%E6%93%8D%E4%BD%9C)

### 唯一键
```sql
username varchar(50) null unique  comment '用户名';
-- or 
unique key(username)
-- or 
alter table table_name add unique key(username);
```
<br>[⬆ Back to top](#mysql%E5%9F%BA%E6%9C%AC%E6%93%8D%E4%BD%9C)

### 自增长
```sql
-- add
id int primary key auto_increment;
-- modified
alter table table_name auto_increment=value;
-- delete
alter table my_auto modify id int ;
```
<br>[⬆ Back to top](#mysql%E5%9F%BA%E6%9C%AC%E6%93%8D%E4%BD%9C)

## 数据操作
### 更新数据
```sql
insert into table_name values(value1,value2...);
insert into table_name(key1, key2) values (value1, value2);
```
<br>[⬆ Back to top](#mysql%E5%9F%BA%E6%9C%AC%E6%93%8D%E4%BD%9C)

### 查询数据
```sql
select * from table_name [where condition] 
[[group by [asc/desc]] [having]] [order by asc/desc]] [limit value];
```
<br>[⬆ Back to top](#mysql%E5%9F%BA%E6%9C%AC%E6%93%8D%E4%BD%9C)

### 更新数据
```sql
update table_name set key=value [where condotion] [limit value];
```
<br>[⬆ Back to top](#mysql%E5%9F%BA%E6%9C%AC%E6%93%8D%E4%BD%9C)

### 删除数据
```sql
delete from table_name [where condition] [limit value];
```
<br>[⬆ Back to top](#mysql%E5%9F%BA%E6%9C%AC%E6%93%8D%E4%BD%9C)

## 数据类型
### 整数型
- tinyint：迷你整型，使用 1 个字节存储数据（常用）；
- smallint：小整型，使用 2 个字节存储数据；
- mediumint：中整型，使用 3 个字节存储数据；
- int：标准整型，使用 4 个字节存储数据（常用）；
- bigint：大整型，使用 8 个字节存储数据。
<br>[⬆ Back to top](#mysql%E5%9F%BA%E6%9C%AC%E6%93%8D%E4%BD%9C)

### 小数型
- float：单精度，占用 4 个字节存储数据，精度范围大概为 7 位左右；
- double：双精度，占用 8 个字节存储数据，精度范围大概为 15 位左右。
- decimal:数字型，128bit，不存在精度损失，常用于银行帐目计算。（28个有效位）
<br>[⬆ Back to top](#mysql%E5%9F%BA%E6%9C%AC%E6%93%8D%E4%BD%9C)

### 日期类型
- datetime：日期时间，其格式为yyyy-MM-dd HH:mm:ss，表示的范围是从 1000 年到 9999 年，有零值，即0000-00-00 0000:00；
- date：日期，就是datetime的date部分；
- time：时间，或者说是时间段，为指定的某个时间区间之间，包含正负时间；
- timestamp：时间戳，但并不是真正意义上的时间戳，其是从1970年开始计算的，格式和datetime一致；
- year：年份，共有两种格式，分别为year(2)和year(4).
<br>[⬆ Back to top](#mysql%E5%9F%BA%E6%9C%AC%E6%93%8D%E4%BD%9C)

### 字符串型
- char(L)：定长字符串,L 表示 Length，即可以存储的长度，单位为字符，最大长度为 255；
- varchar(L)：变长字符串,L 表示 Length，理论长度是 65536，但是会多出 1 到 2 个字节来确定存储的实际长度；
- text：文本字符串,存储文字；
- blob：存储二进制数据（其实际上都是存储路径），通常不用。
- enum：枚举字符串,enum('元素1','元素2','元素3'...)，例如enum('男','女','保密')；
- set:  集合字符串，跟枚举类似，实际存储的是数值而不是字符串。

<br>[⬆ Back to top](#mysql%E5%9F%BA%E6%9C%AC%E6%93%8D%E4%BD%9C)

## 连接
```sql
... FROM table1 INNER|LEFT|RIGHT JOIN table2 ON conditiona;
select A.id,A.name,B.name from A,B where A.id=B.id;
```
<br>[⬆ Back to top](#mysql%E5%9F%BA%E6%9C%AC%E6%93%8D%E4%BD%9C)

### 内连接
```sql
select * from A inner join B on A.name = B.name;
```
<br>[⬆ Back to top](#mysql%E5%9F%BA%E6%9C%AC%E6%93%8D%E4%BD%9C)

### 左连接
```sql
select * from A left join B on A.name = B.name;
```
<br>[⬆ Back to top](#mysql%E5%9F%BA%E6%9C%AC%E6%93%8D%E4%BD%9C)

### 右连接
```sql
select * from A right join B on A.name = B.name;
```
<br>[⬆ Back to top](#mysql%E5%9F%BA%E6%9C%AC%E6%93%8D%E4%BD%9C)

### 交叉连接(笛卡尔积)
```sql
 select * from A cross join B;
 ```
<br>[⬆ Back to top](#mysql%E5%9F%BA%E6%9C%AC%E6%93%8D%E4%BD%9C)

### 全连接
```sql
 select * from A left join B on B.name = A.name;
 ```
<br>[⬆ Back to top](#mysql%E5%9F%BA%E6%9C%AC%E6%93%8D%E4%BD%9C)

### 联合
```sql
(select * from table1 order by )
union [distinct | all]
(select * from table2 order by );
```
<br>[⬆ Back to top](#mysql%E5%9F%BA%E6%9C%AC%E6%93%8D%E4%BD%9C)

### 子查询
```sql
select * from table1 where c_id = (select id from table2 where);
select * from table1 where c_id in (select id from table1);
select * from table1 where (a,b) = (select a,b from table2);
select * from (select * from table2) as t1; 
select * from table1 where exists ( select * from table2);
```
<br>[⬆ Back to top](#mysql%E5%9F%BA%E6%9C%AC%E6%93%8D%E4%BD%9C)

## 高级
### 视图
```sql
-- create
create view view_name as select * from table1;
-- query
desc view_name;
show tables view_name;
show create table view_name;
-- use
select * from view_name;
-- modified
alter view view_name as select * from table2;
-- delete
drop table view_name;
-- insert data
insert into view_name values();
-- delete data
delete from view_name where ;
-- update data
update view_name set a='1' where ;
```
<br>[⬆ Back to top](#mysql%E5%9F%BA%E6%9C%AC%E6%93%8D%E4%BD%9C)

### 事物
```sql
-- 1-openl 0-close
set autocommit = [0|1]
start transaction;
[savepoint spone;
rollback to spone;]
commit;
rollback;
```
<br>[⬆ Back to top](#mysql%E5%9F%BA%E6%9C%AC%E6%93%8D%E4%BD%9C)

### 触发器
```sql
delimiter symbol
create trigger trigger_name [before | after]  [insert| delete | update] on table_name for each row
begin 
sql
end
symbol
delimiter;
```
<br>[⬆ Back to top](#mysql%E5%9F%BA%E6%9C%AC%E6%93%8D%E4%BD%9C)

### 函数
```sql
create function func_name(args) return datatype
begin 
sql
return 
end;
```
<br>[⬆ Back to top](#mysql%E5%9F%BA%E6%9C%AC%E6%93%8D%E4%BD%9C)

### 存储过程
```sql
create procedure name (args)
begin
sql
end;
```
<br>[⬆ Back to top](#mysql%E5%9F%BA%E6%9C%AC%E6%93%8D%E4%BD%9C)

## 备份与还原
### 单数据
```sql
-- backup
select * from table into outfile 'file/to/path';
-- restore
load  data infile 'file/to/path' into table class;
```
<br>[⬆ Back to top](#mysql%E5%9F%BA%E6%9C%AC%E6%93%8D%E4%BD%9C)

### sql备份
```sql
-- backup
mysqldump -uroot -ppassword database table > file/to/path;
source file/to/path
-- restore
mysqldump -uroot -ppassword database table > file/to/path;
```
<br>[⬆ Back to top](#mysql%E5%9F%BA%E6%9C%AC%E6%93%8D%E4%BD%9C)



## 参考
[史上最简单的MySql教程](http:blog.csdn.net/column/details/16138.html)
