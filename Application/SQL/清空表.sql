
TRUNCATE TABLE em_task;#任务表
TRUNCATE TABLE em_user_task;#用户任务表
TRUNCATE TABLE em_user_task_log;#用户任务日志表
TRUNCATE TABLE em_user;#用户表
TRUNCATE TABLE em_user_card_list;#银行卡列表
TRUNCATE TABLE em_user_real_refuse;#用户实名认证拒绝
TRUNCATE TABLE em_message;#消息
TRUNCATE TABLE em_message_group;#群发消息

TRUNCATE TABLE em_attachment;#附件
TRUNCATE TABLE em_banner;#banner








#结算
UPDATE em_user_task_settlement set `status`=0;
UPDATE em_settlement SET status=0,split_status=0;
UPDATE em_user_card_list set money=0,split_status=0,last_money=0;
TRUNCATE TABLE em_settlement_split_card;
TRUNCATE TABLE em_settlement_split_user;
TRUNCATE TABLE em_settlement_split_wages;