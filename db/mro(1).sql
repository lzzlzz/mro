-- phpMyAdmin SQL Dump
-- version 4.8.4
-- https://www.phpmyadmin.net/
--
-- 主机： 127.0.0.1:3306
-- 生成日期： 2019-05-30 02:55:18
-- 服务器版本： 5.7.24
-- PHP 版本： 7.2.14

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- 数据库： `mro`
--

-- --------------------------------------------------------

--
-- 表的结构 `mro_cart`
--

DROP TABLE IF EXISTS `mro_cart`;
CREATE TABLE IF NOT EXISTS `mro_cart` (
  `id` int(20) NOT NULL AUTO_INCREMENT COMMENT '购物车id',
  `cart_pdt_id` int(20) NOT NULL COMMENT '购买商品id',
  `cart_quantity` bigint(200) NOT NULL COMMENT '购买的件数',
  `cart_price` double NOT NULL COMMENT '购买的价格',
  `cart_addtime` int(20) NOT NULL COMMENT '添加时间',
  `cart_cus_id` int(20) NOT NULL COMMENT '顾客id',
  `cart_order_id` int(20) NOT NULL DEFAULT '0' COMMENT '所属订单id 未提交为0 形成订单后为订单id',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- --------------------------------------------------------

--
-- 表的结构 `mro_cate`
--

DROP TABLE IF EXISTS `mro_cate`;
CREATE TABLE IF NOT EXISTS `mro_cate` (
  `id` int(20) NOT NULL AUTO_INCREMENT COMMENT '类别id',
  `cate_name` varchar(20) COLLATE utf8_bin NOT NULL COMMENT '类别名称',
  `cate_desc` varchar(30) COLLATE utf8_bin NOT NULL COMMENT '类别描述',
  `pid` int(11) NOT NULL DEFAULT '0' COMMENT '父类id',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=14 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- 转存表中的数据 `mro_cate`
--

INSERT INTO `mro_cate` (`id`, `cate_name`, `cate_desc`, `pid`) VALUES
(1, '机械', '机械类的', 0),
(2, '螺丝刀', '拧螺丝的顶顶顶顶', 1),
(8, '劳保类', '劳保用品', 0),
(7, '电器', '', 0),
(9, '防护类', '', 8),
(10, '可编程控制器', '', 7),
(11, '伺服控制', '', 7),
(12, '坠落防护', '', 8),
(13, '齿轮', '', 1);

-- --------------------------------------------------------

--
-- 表的结构 `mro_customer`
--

DROP TABLE IF EXISTS `mro_customer`;
CREATE TABLE IF NOT EXISTS `mro_customer` (
  `id` int(20) NOT NULL AUTO_INCREMENT COMMENT '客户id',
  `cus_num` varchar(20) COLLATE utf8_bin NOT NULL COMMENT '客户编号',
  `cus_password` varchar(20) COLLATE utf8_bin NOT NULL COMMENT '登录密码',
  `cus_name` varchar(20) COLLATE utf8_bin NOT NULL COMMENT '客户名称',
  `cus_phone` varchar(20) COLLATE utf8_bin NOT NULL COMMENT '客户电话',
  `cus_address` varchar(50) COLLATE utf8_bin NOT NULL COMMENT '客户地址',
  `cus_email` varchar(30) COLLATE utf8_bin NOT NULL COMMENT '客户邮箱',
  `cus_cls_id` int(20) DEFAULT NULL COMMENT '客户等级ID',
  `cus_score` bigint(200) NOT NULL DEFAULT '0' COMMENT '客户积分',
  `cus_addtime` int(20) NOT NULL COMMENT '客户注册时间',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- 转存表中的数据 `mro_customer`
--

INSERT INTO `mro_customer` (`id`, `cus_num`, `cus_password`, `cus_name`, `cus_phone`, `cus_address`, `cus_email`, `cus_cls_id`, `cus_score`, `cus_addtime`) VALUES
(1, 'C1558334538', '', '张三', '13789653423', '天津市西青区宾水西道391号', 'wang8767@qq.com', 1, 0, 1558334538),
(3, 'C1558337813', '123', '李四', '15923427654', '天津市南开区', 'asd23123@163.com', 1, 0, 1558337813),
(4, 'C1559035387', '123456', 'test01', '123456', '123', 'asd23123@163.com', NULL, 0, 1559035387);

-- --------------------------------------------------------

--
-- 表的结构 `mro_customer_class`
--

DROP TABLE IF EXISTS `mro_customer_class`;
CREATE TABLE IF NOT EXISTS `mro_customer_class` (
  `id` int(20) NOT NULL AUTO_INCREMENT COMMENT '等级id',
  `cls_name` varchar(20) COLLATE utf8_bin NOT NULL COMMENT '等级名称',
  `cls_low_score` bigint(200) NOT NULL DEFAULT '0' COMMENT '等级最低分',
  `cls_high_score` bigint(200) NOT NULL COMMENT '最高分 ',
  `cls_discount` double NOT NULL COMMENT '等级折扣率',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- 转存表中的数据 `mro_customer_class`
--

INSERT INTO `mro_customer_class` (`id`, `cls_name`, `cls_low_score`, `cls_high_score`, `cls_discount`) VALUES
(1, '小小白', 0, 4, 2),
(3, '小白', 5, 10, 1),
(4, '菜鸟', 11, 15, 1.9);

-- --------------------------------------------------------

--
-- 表的结构 `mro_inventory`
--

DROP TABLE IF EXISTS `mro_inventory`;
CREATE TABLE IF NOT EXISTS `mro_inventory` (
  `id` int(20) NOT NULL AUTO_INCREMENT COMMENT '库存单id',
  `ivt_pdt_id` int(20) NOT NULL COMMENT '产品id',
  `ivt_quantity` bigint(200) NOT NULL COMMENT '在库数量',
  `ivt_original_cost` double NOT NULL COMMENT '产品原价',
  `ivt_min_quantity` int(100) NOT NULL DEFAULT '0' COMMENT '预警库存量',
  `ivt_max_quantity` bigint(200) NOT NULL DEFAULT '10' COMMENT '最大库存量',
  `ivt_wh_id` int(20) NOT NULL COMMENT '仓库id',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=20 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- 转存表中的数据 `mro_inventory`
--

INSERT INTO `mro_inventory` (`id`, `ivt_pdt_id`, `ivt_quantity`, `ivt_original_cost`, `ivt_min_quantity`, `ivt_max_quantity`, `ivt_wh_id`) VALUES
(18, 6, 5, 8, 0, 10, 1),
(19, 10, 13, 4.764705882352941, 0, 10, 1);

-- --------------------------------------------------------

--
-- 表的结构 `mro_in_storage`
--

DROP TABLE IF EXISTS `mro_in_storage`;
CREATE TABLE IF NOT EXISTS `mro_in_storage` (
  `id` int(20) NOT NULL AUTO_INCREMENT COMMENT '入库单id',
  `in_num` varchar(20) COLLATE utf8_bin NOT NULL COMMENT '入库单编号',
  `in_sl_id` int(20) NOT NULL COMMENT '供货单id',
  `in_time` int(20) NOT NULL COMMENT '入库时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=34 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- 转存表中的数据 `mro_in_storage`
--

INSERT INTO `mro_in_storage` (`id`, `in_num`, `in_sl_id`, `in_time`) VALUES
(32, 'IS1559008620', 62, 1559008620),
(33, 'IS1559178111', 64, 1559178111);

-- --------------------------------------------------------

--
-- 表的结构 `mro_order`
--

DROP TABLE IF EXISTS `mro_order`;
CREATE TABLE IF NOT EXISTS `mro_order` (
  `id` int(20) NOT NULL AUTO_INCREMENT COMMENT '订单ID',
  `order_num` varchar(20) COLLATE utf8_bin NOT NULL COMMENT '订单编号',
  `order_cus_id` int(20) NOT NULL COMMENT '客户ID',
  `order_total_cost` double NOT NULL,
  `order_addtime` int(20) NOT NULL COMMENT '下单时间',
  `order_delivery` int(20) NOT NULL DEFAULT '0' COMMENT '出库单id 未出库时为0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- 转存表中的数据 `mro_order`
--

INSERT INTO `mro_order` (`id`, `order_num`, `order_cus_id`, `order_total_cost`, `order_addtime`, `order_delivery`) VALUES
(6, 'O1559131218', 4, 0, 1559131218, 1),
(7, 'O1559131753', 4, 0, 1559131753, 0),
(8, 'O1559131843', 4, 0, 1559131843, 0),
(9, 'O1559132107', 4, 0, 1559132107, 0),
(10, 'O1559132553', 4, 0, 1559132553, 0),
(11, 'O1559132616', 4, 0, 1559132616, 0),
(12, 'O1559132680', 4, 0, 1559132680, 0),
(13, 'O1559132742', 4, 0, 1559132742, 0),
(14, 'O1559133324', 4, 0, 1559133324, 0),
(15, 'O1559135549', 4, 10, 1559135549, 2),
(17, 'O1559181775', 4, 64, 1559181775, 3);

-- --------------------------------------------------------

--
-- 表的结构 `mro_order_item`
--

DROP TABLE IF EXISTS `mro_order_item`;
CREATE TABLE IF NOT EXISTS `mro_order_item` (
  `id` int(20) NOT NULL AUTO_INCREMENT COMMENT '子订单id',
  `odt_order_id` int(20) NOT NULL COMMENT '父订单id',
  `odt_pdt_id` int(20) NOT NULL COMMENT '产品id',
  `odt_num` bigint(200) NOT NULL COMMENT '购买数量',
  `odt_price` double NOT NULL COMMENT '成交价格',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- 转存表中的数据 `mro_order_item`
--

INSERT INTO `mro_order_item` (`id`, `odt_order_id`, `odt_pdt_id`, `odt_num`, `odt_price`) VALUES
(1, 6, 6, 8, 80),
(2, 6, 10, 4, 15),
(3, 7, 6, 8, 80),
(4, 7, 10, 4, 15),
(5, 8, 10, 4, 15),
(6, 9, 6, 8, 80),
(7, 10, 10, 4, 15),
(8, 10, 6, 8, 80),
(9, 11, 10, 1, 5),
(10, 11, 6, 1, 10),
(11, 12, 6, 1, 10),
(12, 13, 6, 1, 10),
(13, 13, 10, 1, 5),
(14, 14, 6, 1, 10),
(15, 15, 6, 1, 10),
(16, 17, 6, 8, 8);

-- --------------------------------------------------------

--
-- 表的结构 `mro_out_storage`
--

DROP TABLE IF EXISTS `mro_out_storage`;
CREATE TABLE IF NOT EXISTS `mro_out_storage` (
  `id` int(20) NOT NULL AUTO_INCREMENT COMMENT '出库单id',
  `out_num` varchar(20) COLLATE utf8_bin NOT NULL COMMENT '出库单编号',
  `out_order_id` int(20) NOT NULL COMMENT '订单编号',
  `out_time` int(20) NOT NULL COMMENT '出库时间',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- 转存表中的数据 `mro_out_storage`
--

INSERT INTO `mro_out_storage` (`id`, `out_num`, `out_order_id`, `out_time`) VALUES
(1, 'OS1559181588', 6, 1559181588),
(2, 'OS1559181670', 15, 1559181670),
(3, 'OS1559181801', 17, 1559181801);

-- --------------------------------------------------------

--
-- 表的结构 `mro_product`
--

DROP TABLE IF EXISTS `mro_product`;
CREATE TABLE IF NOT EXISTS `mro_product` (
  `id` int(20) NOT NULL AUTO_INCREMENT COMMENT '产品id',
  `pdt_num` varchar(20) COLLATE utf8_bin NOT NULL COMMENT '产品编号',
  `pdt_name` varchar(20) COLLATE utf8_bin NOT NULL COMMENT '产品名称',
  `pdt_pic` varchar(50) COLLATE utf8_bin NOT NULL COMMENT '产品图片',
  `pdt_cate_id` int(20) NOT NULL COMMENT '产品所属分类id',
  `pdt_brand` varchar(20) COLLATE utf8_bin NOT NULL COMMENT '产品品牌',
  `pdt_desc` text COLLATE utf8_bin NOT NULL COMMENT '产品描述',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=11 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- 转存表中的数据 `mro_product`
--

INSERT INTO `mro_product` (`id`, `pdt_num`, `pdt_name`, `pdt_pic`, `pdt_cate_id`, `pdt_brand`, `pdt_desc`) VALUES
(1, 'P1558356646', '螺丝钉', '20190520\\bdf11dba430071b2a98c2b9a79c59aeb.png', 1, '', ''),
(4, 'P1558443228', '螺丝帽', '20190521\\166a61344eb02b6c46dcbde5b3a77124.png', 2, '', ''),
(5, 'P1558834626', '安全绳', '20190526\\b1cd290066079f01e95d0fc87872bdfc.png', 12, '固安捷', ''),
(6, 'P1558834796', '口罩', '20190526\\0efab070084a5681193440884e788e62.png', 9, '3M', '这是一种可以防PM2.5的好口罩'),
(7, 'P1558834838', '伺服机', '20190526\\83ce1962322a8a266846ddcda999f50a.png', 11, '西门子', ''),
(8, 'P1558834864', 'CPU', '20190526\\e8aa2bfa33a8a4e01ac0f1a3fdb2e7a6.png', 10, '因特尔', ''),
(9, 'P1558834947', '齿轮箱', '20190526\\6b988a1f940a2d4adf1b8c6fe9879acb.png', 13, '金强', ''),
(10, 'P1558839909', '手套', '20190526\\d026ee708c412f181f18d75308335fb0.png', 9, '', '');

-- --------------------------------------------------------

--
-- 表的结构 `mro_stockout`
--

DROP TABLE IF EXISTS `mro_stockout`;
CREATE TABLE IF NOT EXISTS `mro_stockout` (
  `id` int(20) NOT NULL AUTO_INCREMENT COMMENT '缺货单id',
  `sko_num` varchar(25) COLLATE utf8_bin NOT NULL COMMENT '缺货单编号',
  `sko_pdt_id` int(20) NOT NULL COMMENT '缺少产品id',
  `sko_quantity` bigint(200) NOT NULL COMMENT '缺货量',
  `sko_addtime` int(20) NOT NULL COMMENT '生成时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- 转存表中的数据 `mro_stockout`
--

INSERT INTO `mro_stockout` (`id`, `sko_num`, `sko_pdt_id`, `sko_quantity`, `sko_addtime`) VALUES
(1, 'SKO1559181801', 6, 25, 1559181801),
(4, 'SKO1559182624', 6, 3, 1559182624),
(5, 'SKO1559182638', 6, 3, 1559182638);

-- --------------------------------------------------------

--
-- 表的结构 `mro_supplier`
--

DROP TABLE IF EXISTS `mro_supplier`;
CREATE TABLE IF NOT EXISTS `mro_supplier` (
  `id` int(20) NOT NULL AUTO_INCREMENT COMMENT '供应商id',
  `sp_num` varchar(25) COLLATE utf8_bin NOT NULL COMMENT '供应商编号',
  `sp_name` varchar(20) COLLATE utf8_bin NOT NULL COMMENT '名称',
  `sp_phone` varchar(20) COLLATE utf8_bin NOT NULL COMMENT '电话',
  `sp_email` varchar(30) COLLATE utf8_bin NOT NULL COMMENT '邮箱',
  `sp_address` varchar(50) COLLATE utf8_bin NOT NULL COMMENT '地址',
  `sp_cate_id` int(20) NOT NULL COMMENT '所属一级分类id',
  `sp_desc` text COLLATE utf8_bin NOT NULL COMMENT '描述',
  `sp_checked` int(5) DEFAULT '0' COMMENT '0未审 1通过 2 未过',
  `sp_score` bigint(255) DEFAULT '0' COMMENT '积分',
  `sp_addtime` int(20) NOT NULL COMMENT '注册时间',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- 转存表中的数据 `mro_supplier`
--

INSERT INTO `mro_supplier` (`id`, `sp_num`, `sp_name`, `sp_phone`, `sp_email`, `sp_address`, `sp_cate_id`, `sp_desc`, `sp_checked`, `sp_score`, `sp_addtime`) VALUES
(1, 'SP1558406681', '三晖', '321', '312@qq.com', 'wad', 8, 'da', 1, 0, 1558406681),
(3, 'SP1558425849', 'test01', '121212', '312@qq.com', '21212', 7, '21', 2, 0, 1558425849),
(4, 'SP1558426030', '机械供应商', '2131', '123@123.com', '', 1, '', 1, 0, 1558426030),
(5, 'SP1558832654', '永信', '1491892837', '321wqewqe@163.com', '天津市和平区', 7, '一家公司', 0, 0, 1558832654);

-- --------------------------------------------------------

--
-- 表的结构 `mro_supply_list`
--

DROP TABLE IF EXISTS `mro_supply_list`;
CREATE TABLE IF NOT EXISTS `mro_supply_list` (
  `id` int(20) NOT NULL AUTO_INCREMENT COMMENT '供货单id',
  `sl_num` varchar(25) COLLATE utf8_bin NOT NULL COMMENT '供货单编号',
  `sl_sp_id` int(20) NOT NULL COMMENT '供应商id',
  `sl_total_amount` bigint(255) DEFAULT '0' COMMENT '供货单总金额',
  `sl_addtime` int(20) NOT NULL COMMENT '供货时间',
  `sl_storage` int(20) NOT NULL DEFAULT '0' COMMENT '入库单id 0未入库 ',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=65 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- 转存表中的数据 `mro_supply_list`
--

INSERT INTO `mro_supply_list` (`id`, `sl_num`, `sl_sp_id`, `sl_total_amount`, `sl_addtime`, `sl_storage`) VALUES
(62, 'SL1559008598', 1, 175, 1559008598, 1),
(63, 'SL1559009132', 4, 9, 1559009132, 0),
(64, 'SL1559133728', 1, 18, 1559133728, 33);

-- --------------------------------------------------------

--
-- 表的结构 `mro_supply_list_item`
--

DROP TABLE IF EXISTS `mro_supply_list_item`;
CREATE TABLE IF NOT EXISTS `mro_supply_list_item` (
  `id` int(20) NOT NULL AUTO_INCREMENT COMMENT '供货单条目id',
  `slt_sl_id` int(20) NOT NULL COMMENT '所属供货单id',
  `slt_pdt_id` int(20) NOT NULL COMMENT '供应产品id',
  `slt_quantity` bigint(255) DEFAULT NULL COMMENT '数量',
  `slt_price` double DEFAULT NULL COMMENT '供货单价',
  `slt_total_amount` double DEFAULT NULL COMMENT '一种产品的总价',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=106 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- 转存表中的数据 `mro_supply_list_item`
--

INSERT INTO `mro_supply_list_item` (`id`, `slt_sl_id`, `slt_pdt_id`, `slt_quantity`, `slt_price`, `slt_total_amount`) VALUES
(101, 62, 6, 10, 10, 100),
(102, 62, 10, 15, 5, 75),
(103, 63, 4, 3, 3, 9),
(104, 64, 6, 4, 3, 12),
(105, 64, 10, 2, 3, 6);

-- --------------------------------------------------------

--
-- 表的结构 `mro_warehouse`
--

DROP TABLE IF EXISTS `mro_warehouse`;
CREATE TABLE IF NOT EXISTS `mro_warehouse` (
  `id` int(20) NOT NULL AUTO_INCREMENT COMMENT '仓库id',
  `wh_num` varchar(20) COLLATE utf8_bin NOT NULL COMMENT '仓库编号',
  `wh_name` varchar(20) COLLATE utf8_bin NOT NULL,
  `wh_admin_name` varchar(20) COLLATE utf8_bin NOT NULL COMMENT '仓管员姓名',
  `wh_address` varchar(30) COLLATE utf8_bin NOT NULL COMMENT '仓库地址',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- 转存表中的数据 `mro_warehouse`
--

INSERT INTO `mro_warehouse` (`id`, `wh_num`, `wh_name`, `wh_admin_name`, `wh_address`) VALUES
(1, 'WH001', '一号仓库', '王二小', '天津市宝坻区'),
(2, 'WH002', '二号仓库', '王二小', '天津市宝坻区');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
