DROP TABLE IF EXISTS `tp_alipay_person`;
CREATE TABLE `tp_alipay_person` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `alipayname` varchar(100) CHARACTER SET utf8 DEFAULT NULL COMMENT '支付宝名称',
  `tokenTall` varchar(20) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;


DROP TABLE IF EXISTS `tp_alipay_biz`;
CREATE TABLE `tp_alipay_biz` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `alipayname` varchar(100) CHARACTER SET utf8 DEFAULT NULL COMMENT '支付宝名称',
  `partner` varchar(100) CHARACTER SET utf8 DEFAULT NULL COMMENT '合作身份者id',
  `key` varchar(100) CHARACTER SET utf8 DEFAULT NULL COMMENT '安全检验码',
  `tokenTall` varchar(20) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

//前台用户增加联系人、联系方式、联系地址
alter table tp_users add `contact` varchar(255) NOT NULL DEFAULT '';
alter table tp_users add `phone` varchar(255) NOT NULL DEFAULT '';
alter table tp_users add `address` varchar(255) NOT NULL DEFAULT '';
