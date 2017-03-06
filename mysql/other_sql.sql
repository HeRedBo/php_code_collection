
# 用户互为好友的SNS 存储数据结果如何设计 （亿邮）
-- user table
create table `user`
(
    `id` int(11) unsigned not null auto_increment,
    `username` varchar(30) not null default '' comment '用户名',
    `email` varchar(50) not null default '' comment '邮箱地址',
    `password` char(64) not null default '' comment '密码',
    `face_img` varchar(255) not null default '' comment '用户头像',
    primary key (`id`)
)engine= MyISAM charset=utf8 comment ='用户表';

-- 用户间用户关表
create table `relation` (
    `rel_id` int(11) unsigned not null auto_increment,
    `fuid` int(11) unsigned not null comment '关注人的ID',
    `suid` int(11) unsigned not null comment '被关注人的ID',
    `relation_type` ENUM('S','D') not null default 'S' comment '关注类型, s 位关注，d 表示为好友',
    primary key(`rel_id`)
) engine = MyISAM charset = utf8 comment = '用户关系表'