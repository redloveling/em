CREATE TABLE `em_user_real_audit` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT 'ID',
  `uid` int(10) NOT NULL DEFAULT '0' COMMENT '用户id',
  `audit_uid` int(10) DEFAULT '0' COMMENT '审核人员id',
  `audit_username` varchar(50) DEFAULT NULL COMMENT '审核人员',
  `attach_ids` varchar(255) DEFAULT NULL COMMENT '附件id逗号拼接',
  `status` tinyint(1) NOT NULL DEFAULT '0' COMMENT '0->审核中，1->认证通过，2->认证失败',
  `refuse_type` tinyint(1) unsigned DEFAULT '1' COMMENT '拒绝错误类型',
  `refuse_name` varchar(255) DEFAULT NULL COMMENT '类型名字',
  `description` varchar(300) DEFAULT NULL COMMENT '具体备注',
  `serialize` text,
  `audit_time` int(10) DEFAULT '0' COMMENT '审核时间',
  `create_time` int(10) NOT NULL DEFAULT '0' COMMENT '申请时间',
  PRIMARY KEY (`id`),
  KEY `audit_username` (`audit_username`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COMMENT='用户实名认证表';

CREATE TABLE `em_user_log` (
  `id` int(6) unsigned NOT NULL AUTO_INCREMENT COMMENT 'ID',
  `user_id` int(6) NOT NULL DEFAULT '0' COMMENT '用户id',
  `username` varchar(50) NOT NULL COMMENT '用户名',
  `operator_id` int(10) NOT NULL COMMENT '操作人id',
  `create_time` int(10) NOT NULL DEFAULT '0' COMMENT '申请时间',
  `msg` varchar(255) DEFAULT NULL COMMENT '操作内容',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='用户任务历史表';

CREATE TABLE `em_user_task_log` (
  `id` int(6) unsigned NOT NULL AUTO_INCREMENT COMMENT 'ID',
  `user_id` int(6) NOT NULL DEFAULT '0' COMMENT '用户id',
  `username` varchar(50) NOT NULL COMMENT '用户名',
  `task_id` int(6) unsigned NOT NULL DEFAULT '0' COMMENT '任务ID',
  `business_id` int(6) NOT NULL DEFAULT '0' COMMENT '商家ID',
  `title` varchar(50) NOT NULL COMMENT '任务标题',
  `operator_id` int(10) DEFAULT '0' COMMENT '操作人id',
  `create_time` int(10) NOT NULL DEFAULT '0' COMMENT '申请时间',
  `msg` varchar(255) DEFAULT NULL COMMENT '操作内容',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='用户任务历史表';