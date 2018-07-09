#用户表
CREATE TABLE `z_user` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '用户的 ID',
  `user_name` varchar(255) DEFAULT NULL COMMENT '用户名',
  `true_name` varchar(255) DEFAULT NULL COMMENT '用户真实姓名',
  `password` varchar(32) DEFAULT NULL COMMENT '用户密码',
  `salt` varchar(16) DEFAULT NULL COMMENT '用户附加混淆码',
  `avatar_file` varchar(128) DEFAULT NULL COMMENT '头像文件',
  `sex` tinyint(1) DEFAULT NULL COMMENT '性别',
  `birthday` int(10) DEFAULT NULL COMMENT '生日',
  `update_time` int(10) DEFAULT NULL,
  `reg_time` int(10) DEFAULT NULL COMMENT '注册时间',
  `reg_ip` bigint(12) DEFAULT NULL COMMENT '注册IP',
  `serialize` text NOT NULL COMMENT '序列化信息',
  PRIMARY KEY (`id`)

) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;

