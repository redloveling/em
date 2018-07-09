#   支付体系独立于其他业务
#   用户和商户不产生直接的金额交易，所有的交易必须通过平台账户
#
#   平台账户 、商户账户（暂不涉及，现阶段是商户直接打款到平台账户）、用户账户
#    ||                       ||                              ||
#   账户金额                 商户账户金额                      用户账户金额
#                             ||
#                          商户任务支付（用于记录商户某个任务的金额信息，存在多次打款的记录）
#
#  ----------支付流程-----------
#  1、商家付款
#        pay_order(支付订单) 中生成一条唯一的订单号 状态为0（未支付）
#        em_pay_log（支付日志表）写入记录（记录要更新的信息）
#        em_business_task_pay_log（商户任务支付日志表） 写入记录（记录要更新的信息）
#                     |
#					            |
#					            |（余额不足，或者其他原因付款失败） -------->继续支付
#                     |
#       根据支付方返回的信息验证是否支付成功
#                     |
#                     |失败--->信息回滚===》 更新（支付订单）、（支付日志表）、（商户任务支付日志表）的相关状态和相关信息
#                     |
#                     |成功---> 更新（支付订单）、（支付日志表）、（商户任务支付日志表）的相关状态和相关信息
#                               更新em_account（平台账户表）的金额
#                               em_user_account_log (用户账户日志表)写入记录  更新em_user_account（用户账户表）
# 2、用户提现
#        根据em_user_money_record（用户提现记录表）判断当月提现是否超过800（本月累积提现超过800部分将按照国家政策收取税费）
#                 |
#                 | 超过-->提示（如坚持提现）-->扣税规则？（20%） 剩余的税费处理
#                 |
#               未超过
#                 ↓
#        pay_order(支付订单) 中生成一条唯一的订单号 状态为0（未支付）
#        em_pay_log（支付日志表）写入记录（记录要更新的信息）
#        em_user_account_log (用户账户日志表)写入记录
#                     |
#					            |
#					            |（余额不足，或者其他原因付款失败） -------->继续支付
#                     |
#       根据支付方返回的信息验证是否支付成功
#                     |
#                     |失败--->信息回滚===》 更新（支付订单）、（支付日志表）、（用户账户日志表）的相关状态和相关信息
#                     |
#                     |成功---> 更新（支付订单）、（支付日志表）、em_user_account_log (用户账户日志表)的相关状态和相关信息
#                               更新em_account（平台账户表）的金额 更新em_user_account（用户账户表）的金额
#
#订单表
DROP TABLE IF EXISTS em_pay_order;
CREATE TABLE `em_pay_order` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT 'ID',
  `order_no` varchar(50) NOT NULL COMMENT '订单号',
  `money` decimal(9,2) DEFAULT '0' COMMENT '金额',
  `category` tinyint(1) unsigned NOT NULL DEFAULT '1' COMMENT '类别 1=>商户付款,2=>用户提现',
  `pay_way` tinyint(1) unsigned NOT NULL DEFAULT '1' COMMENT '付款方式 1=>支付宝,2=>微信',
  `status` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '状态 0=>未处理,1=>失败,2=>成功',
  `salt` VARCHAR(10)  not NULL COMMENT '加密校验字符',
  `verify_msg` VARCHAR(50)  not NULL COMMENT '校验信息（用户验证订单的准确性）',
  `ext_msg` text COMMENT '需要额外写入的相关支付信息',
  `return_msg` text COMMENT '支付回调返回的信息',
  `update_time` int(10)  DEFAULT '0' COMMENT '验证时间（获取支付回调时间）',
  `create_time` int(10)  DEFAULT '0' COMMENT '创建时间',
  PRIMARY KEY (`id`)
)ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='订单表';

#平台账户表
DROP TABLE IF EXISTS em_account;
CREATE TABLE `em_account` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT 'ID',
  `money` decimal(9,2) DEFAULT '0' COMMENT '金额',
  `ali_money` decimal(9,2) DEFAULT '0' COMMENT '支付宝金额',
  `wx_money` decimal(9,2) DEFAULT '0' COMMENT '微信金额',
  `create_time` int(10)  DEFAULT '0' COMMENT '创建时间',
  PRIMARY KEY (`id`)
)ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='平台账户表';

#支付日志表
DROP TABLE IF EXISTS em_pay_log;
CREATE TABLE `em_pay_log` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT 'ID',
  `order_no` varchar(50) NOT NULL COMMENT '订单号',
  `business_id` int(6)  DEFAULT '0' COMMENT '商户id',
  `task_id` int(10) DEFAULT '0' COMMENT '任务id',
  `user_id` int(10)  DEFAULT '0' COMMENT '用户id',
  `money` decimal(9,2) DEFAULT '0' COMMENT '金额',
  `category` tinyint(1) unsigned NOT NULL DEFAULT '1' COMMENT '类别 1=>商户付款,2=>用户提现',
  `pay_way` tinyint(1) unsigned NOT NULL DEFAULT '1' COMMENT '付款方式 1=>支付宝,2=>微信',
  `status` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '状态 0=>未处理,1=>失败,2=>成功',
  `serialize` text COMMENT '序列化信息',#写入每次更新的具体信息，包括每个人员的信息 工作量 金额及操作人员、操作时间、付款方式 以便以后对账及更新数据
  `operator_id` int(10) DEFAULT '0' COMMENT '操作人id 商家或者用户',
  `create_time` int(10)  DEFAULT '0' COMMENT '创建时间',
  PRIMARY KEY (`id`)
)ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='支付日志表';

#商户账户表
DROP TABLE IF EXISTS em_business_account;
CREATE TABLE `em_business_account` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT 'ID',
  `business_id` int(6) NOT NULL DEFAULT '0' COMMENT '商户id',
  `business_name` varchar(50) NOT NULL COMMENT '商户名称',
  `money` decimal(9,2) DEFAULT '0' COMMENT '金额',
  `create_time` int(10)  DEFAULT '0' COMMENT '创建时间',
  PRIMARY KEY (`id`)
)ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='商户账户表';

#商户账户日志表
DROP TABLE IF EXISTS em_business_account_log;
CREATE TABLE `em_business_account_log` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT 'ID',
  `task_id` int(9) NOT NULL DEFAULT '0' COMMENT '任务id',
  `business_id` int(6) DEFAULT '0' COMMENT '商户id',
  `money` decimal(9,2) DEFAULT '0' COMMENT '金额',
  `pay_way` tinyint(1) unsigned NOT NULL DEFAULT '1' COMMENT '付款方式 1=>支付宝,2=>微信',
  `operator_id` int(10) DEFAULT '0' COMMENT '商户操作人id',
  `create_time` int(10)  DEFAULT '0' COMMENT '操作时间',
  PRIMARY KEY (`id`)
)ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='商户账户日志表';

#商户任务支付日志表
DROP TABLE IF EXISTS em_business_task_pay_log;
CREATE TABLE `em_business_task_pay_log` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT 'ID',
  `order_no` varchar(50) NOT NULL COMMENT '订单号',
  `business_id` int(6)  DEFAULT '0' COMMENT '商户id',
  `task_id` int(10)  DEFAULT '0' COMMENT '任务id',
  `money` decimal(9,2) DEFAULT '0' COMMENT '金额',
  `pay_way` tinyint(1) unsigned NOT NULL DEFAULT '1' COMMENT '付款方式 1=>支付宝,2=>微信',
  `status` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '状态 0=>未处理,1=>失败,2=>成功',
  `serialize` text COMMENT '序列化信息',#写入每次更新的具体信息，包括每个人员的信息 工作量 金额及操作人员、操作时间、付款方式 以便以后对账
  `create_time` int(10)  DEFAULT '0' COMMENT '创建时间',
  PRIMARY KEY (`id`)
)ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='商户任务支付日志表';

#用户账户表 支付认证后生成
DROP TABLE IF EXISTS em_user_account;
CREATE TABLE `em_user_account` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT 'ID',
  `user_id` int(9) DEFAULT '0' COMMENT '用户id',
  `money` decimal(9,2) DEFAULT '0' COMMENT '金额',
  `create_time` int(10)  DEFAULT '0' COMMENT '创建时间',
  PRIMARY KEY (`id`)
)ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='用户账户表';

#用户账户日志表
DROP TABLE IF EXISTS em_user_account_log;
CREATE TABLE `em_user_account_log` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT 'ID',
  `order_no` varchar(50) NOT NULL COMMENT '订单号',
  `user_id` int(9)  DEFAULT '0' COMMENT '用户id',
  `task_id` int(9)  DEFAULT '0' COMMENT '任务id',
  `business_id` int(6)  DEFAULT '0' COMMENT '商户id',
  `category` tinyint(1) unsigned NOT NULL DEFAULT '1' COMMENT '类别 1=>商户存入,2=>用户提现',
  `pay_way` tinyint(1) unsigned NOT NULL DEFAULT '1' COMMENT '付款方式 1=>支付宝,2=>微信',
  `status` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '状态 0=>未处理,1=>失败,2=>成功',
  `money` decimal(9,2) DEFAULT '0' COMMENT '金额',
  `operator_id` int(10) DEFAULT '0' COMMENT '操作人id',
  `create_time` int(10)  DEFAULT '0' COMMENT '操作时间',
  PRIMARY KEY (`id`)
)ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='用户账户日志表';

#用户提现记录表
DROP TABLE IF EXISTS em_user_money_record;
CREATE TABLE `em_user_money_record` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT 'ID',
  `user_id` int(9)  DEFAULT '0' COMMENT '用户id',
  `money` decimal(9,2) DEFAULT '0' COMMENT '金额',
  `tax` decimal(9,2) DEFAULT '0' COMMENT '税',
  `month` int(10)  DEFAULT '0' COMMENT '月份（每个月的1号）',
  `create_time` int(10)  DEFAULT '0' COMMENT '创建时间',
  PRIMARY KEY (`id`)
)ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='用户账户表';