CREATE TABLE `em_user_task_settlement` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT 'ID',
  `user_id` int(10) NOT NULL DEFAULT '0' COMMENT '用户id',
  `task_id` int(10) NOT NULL DEFAULT '0' COMMENT '任务id',
  `money` decimal(9,2) DEFAULT '0.00' COMMENT '金额',
  `status` tinyint(1) NOT NULL DEFAULT '0' COMMENT '0->默认，1=>结算中,2->未到账，3->已到账',
  `serialize` text COMMENT '序列化信息',
  `remark` text COMMENT '备注',
  `create_uid` int(10) DEFAULT '0' COMMENT '创建人id',
  `create_time` int(10) NOT NULL DEFAULT '0' COMMENT '创建时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COMMENT='用户任务结算表';

CREATE TABLE `em_user_task_settlement_log` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT 'ID',
  `user_id` int(10) NOT NULL DEFAULT '0' COMMENT '用户id',
  `task_id` int(10) NOT NULL DEFAULT '0' COMMENT '任务id',
  `money` decimal(9,2) DEFAULT '0.00' COMMENT '金额',
  `status` tinyint(1) NOT NULL DEFAULT '0' COMMENT '0->默认，1=>结算中,2->未到账，3->已到账',
  `serialize` text COMMENT '序列化信息',
  `remark` text COMMENT '备注',
  `create_uid` int(10) DEFAULT '0' COMMENT '创建人id',
  `create_time` int(10) NOT NULL DEFAULT '0' COMMENT '创建时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COMMENT='用户任务结算日志表';


CREATE TABLE `em_user_money_record` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT 'ID',
  `user_id` int(10) NOT NULL DEFAULT '0' COMMENT '用户id',
  `task_money_ids` int(10) NOT NULL DEFAULT '0' COMMENT 'ids',
  `money` decimal(9,2) DEFAULT '0.00' COMMENT '金额',
  `tax` decimal(9,2) DEFAULT '0.00' COMMENT '税',
  `status` tinyint(1) NOT NULL DEFAULT '1' COMMENT '1->未到账，2->已到账',
  `serialize` text NOT NULL COMMENT '序列化信息',
  `confirm_time` int(10) DEFAULT '0' COMMENT '确认到账时间',
  `confirm_uid` int(10) DEFAULT '0' COMMENT '确认到账人id',
  `create_time` int(10) NOT NULL DEFAULT '0' COMMENT '创建时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COMMENT='用户提现表';

CREATE TABLE `em_user_level` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT 'ID',
  `name` VARCHAR(32) NOT NULL DEFAULT '' COMMENT '名称',
  `status` tinyint(1) NOT NULL DEFAULT '1' COMMENT '0->禁用，1->正常',
  `create_uid` int(10) DEFAULT '0' COMMENT '创建人id',
  `create_time` int(10) NOT NULL DEFAULT '0' COMMENT '创建时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COMMENT='用户层级表';

CREATE TABLE `em_settlement` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT 'ID',
  `settlement_time` int(10) NOT NULL DEFAULT '0' COMMENT '结算时间（半月为单位，15号、30号）',
  `user_id` int(10) DEFAULT '0' COMMENT '用户id',
  `person_count` int(10) DEFAULT '0' COMMENT '人数',
  `money` decimal(9,2) DEFAULT '0.00' COMMENT '金额',
  `settlement_uid` int(10) DEFAULT '0' COMMENT '结算人id',
  `pay_time` int(10) DEFAULT '0' COMMENT '打款时间',
  `pay_uid` int(10) DEFAULT '0' COMMENT '打款人ID',
  `split_status` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否分账',
  `status` tinyint(1) NOT NULL DEFAULT '0' COMMENT '0->未结算，1->已结算，2=>已打款',
  `month` tinyint(1) NOT NULL DEFAULT '0' COMMENT '0->15号 1->30号',
  `create_uid` int(10) DEFAULT '0' COMMENT '创建人id',
  `create_time` int(10) NOT NULL DEFAULT '0' COMMENT '创建时间',
  `time` varchar(32) DEFAULT '',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COMMENT='结算表';

CREATE TABLE `em_settlement_split_user` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT 'ID',
  `settlement_id` int(10) DEFAULT '0' COMMENT '结算id',
  `user_id` int(10) DEFAULT '0' COMMENT '用户id',
  `username` varchar(32) DEFAULT '' COMMENT '用户名（true_name）',
  `tell` varchar(32) DEFAULT '' COMMENT '电话号码',
  `card_num` varchar(32) DEFAULT '' COMMENT '身份证',
  `total_money` decimal(9,2) DEFAULT '0.00' COMMENT '总金额',
  `money` decimal(9,2) DEFAULT '0.00' COMMENT '金额',
  `reward` decimal(9,2) DEFAULT '0.00' COMMENT '奖励',
  `debit` decimal(9,2) DEFAULT '0.00' COMMENT '扣款',
  `commission` decimal(9,2) DEFAULT '0.00' COMMENT '提成',
  `tax` decimal(9,2) DEFAULT '0.00' COMMENT '税款',
  `status` tinyint(1) DEFAULT '0',
  `serialize` text COMMENT '序列化信息',
  `create_uid` int(10) DEFAULT '0' COMMENT '创建人id',
  `create_time` int(10) NOT NULL DEFAULT '0' COMMENT '创建时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COMMENT='结算分账用户表';


CREATE TABLE `em_settlement_split_card` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT 'ID',
  `settlement_id` int(10) DEFAULT '0' COMMENT '结算id',
  `task_id` int(10) DEFAULT '0' COMMENT '任务id',
  `user_id` int(10) DEFAULT '0' COMMENT '用户id',
  `username` varchar(32) DEFAULT '' COMMENT '用户名（true_name）',
  `tell` varchar(32) DEFAULT '' COMMENT '电话号码',
  `card_num` varchar(32) DEFAULT '' COMMENT '身份证',
  `bank_num` varchar(32) DEFAULT '' COMMENT '银行卡号',
  `bank_id` int(10) DEFAULT '0' COMMENT '银行ID',
  `bank_name` varchar(32) DEFAULT '' COMMENT '银行名称',
  `total_money` decimal(9,2) DEFAULT '0.00' COMMENT '改张银行卡的总金额',
  `true_money` decimal(9,2) DEFAULT '0.00' COMMENT '改张银行卡实得金额',
  `current_money` decimal(9,2) DEFAULT '0.00' COMMENT '本次实得金额',
  `reward` decimal(9,2) DEFAULT '0.00' COMMENT '奖励',
  `debit` decimal(9,2) DEFAULT '0.00' COMMENT '扣款',
  `commission` decimal(9,2) DEFAULT '0.00' COMMENT '提成',
  `tax` decimal(9,2) DEFAULT '0.00' COMMENT '税款',
  `serialize` text COMMENT '序列化信息',
  `status` tinyint(1) DEFAULT '0',
  `remark` text,
  `create_uid` int(10) DEFAULT '0' COMMENT '创建人id',
  `create_time` int(10) NOT NULL DEFAULT '0' COMMENT '创建时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COMMENT='结算分账银行卡表';

CREATE TABLE `em_settlement_split_wages` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT 'ID',
  `settlement_id` int(10) DEFAULT '0' COMMENT '结算id',
  `user_id` int(10) DEFAULT '0' COMMENT 'id',
  `task_ids` text COMMENT '任务ids',
  `task_money` text COMMENT '任务金额',
  `username` varchar(32) DEFAULT '' COMMENT '用户名（true_name）',
  `tell` varchar(32) DEFAULT '' COMMENT '电话号码',
  `card_num` varchar(32) DEFAULT '' COMMENT '身份证',
  `bank_num` varchar(32) DEFAULT '' COMMENT '银行卡号',
  `bank_id` int(10) DEFAULT '0' COMMENT '银行ID',
  `bank_name` varchar(32) DEFAULT '' COMMENT '银行名称',
  `total_money` decimal(9,2) DEFAULT '0.00' COMMENT '总金额',
  `true_money` decimal(9,2) DEFAULT '0.00' COMMENT '实际金额',
  `tax` decimal(9,2) DEFAULT '0.00' COMMENT '税款',
  `status` tinyint(1) DEFAULT '0',
  `serialize` text COMMENT '序列化信息',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COMMENT='分账工资表';

