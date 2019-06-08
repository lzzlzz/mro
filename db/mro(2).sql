-- phpMyAdmin SQL Dump
-- version 4.8.4
-- https://www.phpmyadmin.net/
--
-- 主机： 127.0.0.1:3306
-- 生成日期： 2019-06-08 09:12:51
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
-- 表的结构 `mro_admin`
--

DROP TABLE IF EXISTS `mro_admin`;
CREATE TABLE IF NOT EXISTS `mro_admin` (
  `id` int(20) NOT NULL AUTO_INCREMENT COMMENT '管理员id',
  `ad_name` varchar(20) COLLATE utf8_bin NOT NULL COMMENT '管理员名称',
  `ad_password` varchar(30) COLLATE utf8_bin NOT NULL COMMENT '密码',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- 转存表中的数据 `mro_admin`
--

INSERT INTO `mro_admin` (`id`, `ad_name`, `ad_password`) VALUES
(1, 'admin', 'admin');

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
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- 转存表中的数据 `mro_cart`
--

INSERT INTO `mro_cart` (`id`, `cart_pdt_id`, `cart_quantity`, `cart_price`, `cart_addtime`, `cart_cus_id`, `cart_order_id`) VALUES
(6, 4, 7, 28.5, 1559978973, 8, 0);

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
(1, '机械类', '机械类的', 0),
(2, '拆装类', '', 1),
(8, '劳保类', '劳保用品', 0),
(7, '电器类', '', 0),
(9, '防护类', '', 8),
(10, '可编程控制器', '', 7),
(11, '伺服控制', '', 7),
(12, '坠落防护', '', 8),
(13, '液压类', '', 1);

-- --------------------------------------------------------

--
-- 表的结构 `mro_customer`
--

DROP TABLE IF EXISTS `mro_customer`;
CREATE TABLE IF NOT EXISTS `mro_customer` (
  `id` int(20) NOT NULL AUTO_INCREMENT COMMENT '客户id',
  `cus_num` varchar(20) COLLATE utf8_bin NOT NULL COMMENT '客户编号',
  `cus_password` varchar(35) COLLATE utf8_bin NOT NULL COMMENT '登录密码',
  `cus_name` varchar(20) COLLATE utf8_bin NOT NULL COMMENT '客户名称',
  `cus_phone` varchar(20) COLLATE utf8_bin NOT NULL COMMENT '客户电话',
  `cus_address` varchar(50) COLLATE utf8_bin NOT NULL COMMENT '客户地址',
  `cus_email` varchar(30) COLLATE utf8_bin NOT NULL COMMENT '客户邮箱',
  `cus_cls_id` int(20) DEFAULT NULL COMMENT '客户等级ID',
  `cus_score` bigint(200) NOT NULL DEFAULT '0' COMMENT '客户积分',
  `cus_addtime` int(20) NOT NULL COMMENT '客户注册时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- 转存表中的数据 `mro_customer`
--

INSERT INTO `mro_customer` (`id`, `cus_num`, `cus_password`, `cus_name`, `cus_phone`, `cus_address`, `cus_email`, `cus_cls_id`, `cus_score`, `cus_addtime`) VALUES
(1, 'C1558334538', 'c8837b23ff8aaa8a2dde915473ce0991', '张三', '13789653423', '天津市西青区宾水西道391号', 'wang8767@qq.com', 8, 579, 1558334538),
(3, 'C1558337813', 'c8837b23ff8aaa8a2dde915473ce0991', '李四', '15923427654', '天津市南开区', 'asd23123@163.com', 8, 534, 1558337813),
(4, 'C1559035387', 'c8837b23ff8aaa8a2dde915473ce0991', 'test01', '123456', '123', 'asd23123@163.com', 10, 1593, 1559035387),
(7, 'C1559887342', 'c8837b23ff8aaa8a2dde915473ce0991', 'test02', '12332122222', 'sd', 'asd23123@163.com', NULL, 0, 1559887342),
(8, 'C1559889359', 'c8837b23ff8aaa8a2dde915473ce0991', 'test03', '12332222222', '23', 'asd23123@163.com', NULL, 0, 1559889359);

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
) ENGINE=MyISAM AUTO_INCREMENT=12 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- 转存表中的数据 `mro_customer_class`
--

INSERT INTO `mro_customer_class` (`id`, `cls_name`, `cls_low_score`, `cls_high_score`, `cls_discount`) VALUES
(1, '小小小白', 0, 50, 3),
(3, '小白', 100, 150, 1),
(4, '菜鸟', 150, 200, 1.9),
(5, '小小白', 50, 100, 1.5),
(6, '青铜', 200, 300, 2),
(7, '白银', 300, 400, 2),
(8, '黄金', 400, 600, 2),
(9, '王者', 600, 1000, 1.1),
(10, '最强王者', 1000, 1000000, 1);

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
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- 转存表中的数据 `mro_inventory`
--

INSERT INTO `mro_inventory` (`id`, `ivt_pdt_id`, `ivt_quantity`, `ivt_original_cost`, `ivt_min_quantity`, `ivt_max_quantity`, `ivt_wh_id`) VALUES
(1, 6, 11, 4, 0, 10, 1),
(2, 5, 9, 4, 0, 10, 1),
(3, 10, 19, 3, 0, 10, 1),
(4, 4, 35, 3.3285714285714287, 0, 10, 1),
(5, 9, 7, 18, 0, 10, 1),
(6, 8, 11, 51.63636363636363, 0, 10, 1),
(7, 7, 23, 27.61264822134387, 0, 10, 1),
(8, 1, 19, 2, 0, 10, 1);

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
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- 转存表中的数据 `mro_in_storage`
--

INSERT INTO `mro_in_storage` (`id`, `in_num`, `in_sl_id`, `in_time`) VALUES
(1, 'IS1559269180', 1, 1559269180),
(2, 'IS1559269195', 1, 1559269195),
(3, 'IS1559269972', 2, 1559269972),
(4, 'IS1559290013', 3, 1559290013),
(5, 'IS1559290035', 4, 1559290035),
(6, 'IS1559295194', 5, 1559295194),
(7, 'IS1559295260', 6, 1559295260),
(8, 'IS1559819714', 7, 1559819714),
(9, 'IS1559819728', 8, 1559819728),
(10, 'IS1559985003', 9, 1559985003),
(11, 'IS1559985077', 10, 1559985077);

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
  `order_finish` int(5) NOT NULL DEFAULT '0' COMMENT '订单钱款收回 0未 1完成',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=20 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- 转存表中的数据 `mro_order`
--

INSERT INTO `mro_order` (`id`, `order_num`, `order_cus_id`, `order_total_cost`, `order_addtime`, `order_delivery`, `order_finish`) VALUES
(1, 'O1559270027', 3, 318, 1559270027, 1, 1),
(2, 'O1559270146', 3, 216, 1559270146, 2, 1),
(3, 'O1559290089', 1, 579, 1559290089, 3, 1),
(4, 'O1559295338', 4, 255.35, 1559295338, 4, 1),
(5, 'O1559720067', 4, 1699.92, 1559720067, 9, 0),
(6, 'O1559720127', 4, 377.76, 1559720127, 5, 0),
(7, 'O1559807509', 4, 912.2, 1559375429, 10, 0),
(8, 'O1559807604', 4, 387.64, 1559461829, 0, 0),
(9, 'O1559807666', 4, 870.49, 1559548229, 0, 0),
(10, 'O1559807713', 4, 148.91, 1559634629, 7, 0),
(11, 'O1559819551', 4, 1016.4, 1559819551, 6, 1),
(12, 'O1559820493', 4, 32, 1559820493, 0, 0),
(13, 'O1559914101', 8, 12, 1559914101, 0, 0),
(14, 'O1559955996', 1, 7, 1559955996, 11, 0),
(15, 'O1559957214', 1, 8, 1559957214, 14, 0),
(16, 'O1559978918', 8, 94.5, 1559978918, 13, 0),
(17, 'O1559979552', 4, 8, 1559979552, 12, 0),
(19, 'O1559980414', 4, 11.5, 1559980414, 8, 0);

-- --------------------------------------------------------

--
-- 表的结构 `mro_order_item`
--

DROP TABLE IF EXISTS `mro_order_item`;
CREATE TABLE IF NOT EXISTS `mro_order_item` (
  `id` int(20) NOT NULL AUTO_INCREMENT COMMENT '子订单id',
  `odt_order_id` int(20) NOT NULL COMMENT '父订单id',
  `odt_pdt_id` int(20) NOT NULL COMMENT '产品id',
  `odt_num` int(50) NOT NULL COMMENT '购买数量',
  `odt_price` double NOT NULL COMMENT '成交价格',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=58 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- 转存表中的数据 `mro_order_item`
--

INSERT INTO `mro_order_item` (`id`, `odt_order_id`, `odt_pdt_id`, `odt_num`, `odt_price`) VALUES
(1, 1, 4, 1, 6),
(2, 1, 9, 1, 300),
(3, 1, 5, 1, 12),
(4, 2, 6, 1, 12),
(5, 2, 4, 1, 4),
(6, 2, 9, 1, 200),
(7, 3, 4, 1, 6),
(8, 3, 5, 1, 12),
(9, 3, 6, 1, 12),
(10, 3, 7, 1, 150),
(11, 3, 8, 1, 90),
(12, 3, 9, 1, 300),
(13, 3, 10, 1, 9),
(14, 4, 1, 1, 8),
(15, 4, 4, 1, 4),
(16, 4, 5, 1, 8),
(17, 4, 6, 1, 8),
(18, 4, 7, 1, 78.91),
(19, 4, 8, 1, 48),
(20, 4, 9, 1, 94.44),
(21, 4, 10, 1, 6),
(22, 5, 9, 18, 94.44),
(23, 6, 9, 4, 94.44),
(24, 7, 9, 5, 94.44),
(25, 7, 8, 5, 48),
(26, 7, 4, 4, 4),
(27, 7, 5, 6, 16),
(28, 7, 6, 11, 8),
(29, 8, 4, 4, 4),
(30, 8, 1, 4, 8),
(31, 8, 7, 4, 78.91),
(32, 8, 10, 4, 6),
(33, 9, 7, 3, 78.91),
(34, 9, 1, 3, 8),
(35, 9, 6, 3, 8),
(36, 9, 8, 4, 48),
(37, 9, 9, 4, 94.44),
(38, 9, 4, 4, 4),
(39, 10, 1, 1, 8),
(40, 10, 6, 1, 8),
(41, 10, 10, 1, 6),
(42, 10, 8, 1, 48),
(43, 10, 7, 1, 78.91),
(44, 11, 4, 18, 4),
(45, 11, 9, 10, 94.44),
(46, 12, 4, 4, 8),
(47, 13, 1, 1, 12),
(48, 14, 4, 1, 7),
(49, 15, 5, 1, 8),
(50, 16, 8, 1, 72),
(51, 16, 6, 1, 12),
(52, 16, 4, 1, 10.5),
(53, 17, 1, 1, 4),
(54, 17, 6, 1, 4),
(55, 19, 1, 1, 4),
(56, 19, 5, 1, 4),
(57, 19, 4, 1, 3.5);

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
) ENGINE=MyISAM AUTO_INCREMENT=15 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- 转存表中的数据 `mro_out_storage`
--

INSERT INTO `mro_out_storage` (`id`, `out_num`, `out_order_id`, `out_time`) VALUES
(1, 'OS1559270067', 1, 1559270067),
(2, 'OS1559270165', 2, 1559270165),
(3, 'OS1559290119', 3, 1559290119),
(4, 'OS1559295389', 4, 1559295389),
(5, 'OS1559720154', 6, 1559720154),
(6, 'OS1559819740', 11, 1559819740),
(7, 'OS1559819788', 10, 1559819788),
(8, 'OS1559980462', 19, 1559980462),
(9, 'OS1559980855', 5, 1559980855),
(10, 'OS1559980868', 7, 1559980868),
(11, 'OS1559980947', 14, 1559980947),
(12, 'OS1559982414', 17, 1559982414),
(13, 'OS1559982484', 16, 1559982484),
(14, 'OS1559982519', 15, 1559982519);

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
) ENGINE=MyISAM AUTO_INCREMENT=12 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- 转存表中的数据 `mro_product`
--

INSERT INTO `mro_product` (`id`, `pdt_num`, `pdt_name`, `pdt_pic`, `pdt_cate_id`, `pdt_brand`, `pdt_desc`) VALUES
(1, 'P1558356646', '螺丝钉', '20190607\\c0007dbdfe07dca351eea6d1e70ebb01.jpg', 2, '金强', ''),
(4, 'P1558443228', '螺丝帽', '20190607\\8e49e8c3515b7593a4b62426f6b5d49c.jpg', 2, '', ''),
(5, 'P1558834626', '安全绳', '20190607\\4d676f002f8ab97f0da2596edb6175bb.jpg', 12, '固安捷', ''),
(6, 'P1558834796', '口罩', '20190607\\225031dfee65fd24b097b7a173995f85.jpg', 9, '3M', '这是一种可以防PM2.5的好口罩'),
(7, 'P1558834838', '伺服机', '20190607\\b817ad6b81e949dfebb8f103d5a663d8.jpg', 11, '西门子', ''),
(8, 'P1558834864', 'CPU', '20190607\\adece04734148497b68165d23fe948f9.jpg', 10, '因特尔', ''),
(9, 'P1558834947', '液压泵', '20190607\\b1bbe6c606d44b19cbd15dc94bdb5d16.jpg', 13, '金强', ''),
(10, 'P1558839909', '手套', '20190607\\af61ad7c42099c16dd36f2b7fd3c36cd.jpg', 9, '', ''),
(11, 'P1559888994', '缓降器', '20190607\\e6367bf12ee90ec37621d86a650c66ba.jpg', 12, '保护伞', '');

-- --------------------------------------------------------

--
-- 表的结构 `mro_purchase`
--

DROP TABLE IF EXISTS `mro_purchase`;
CREATE TABLE IF NOT EXISTS `mro_purchase` (
  `id` int(20) NOT NULL AUTO_INCREMENT COMMENT '采购单id',
  `pc_num` varchar(25) COLLATE utf8_bin NOT NULL COMMENT '采购单编号',
  `pc_pdt_id` int(20) NOT NULL COMMENT '采购产品id',
  `pc_quantity` bigint(200) NOT NULL COMMENT '采购数量',
  `pc_sp_id` int(20) NOT NULL COMMENT '采购商id',
  `pc_addtime` int(20) NOT NULL COMMENT '下单时间',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- --------------------------------------------------------

--
-- 表的结构 `mro_replenish`
--

DROP TABLE IF EXISTS `mro_replenish`;
CREATE TABLE IF NOT EXISTS `mro_replenish` (
  `id` int(20) NOT NULL AUTO_INCREMENT COMMENT '补货单id',
  `rep_num` varchar(25) COLLATE utf8_bin NOT NULL COMMENT '补货单编号',
  `rep_cate_id` int(20) NOT NULL COMMENT '缺货产品类型id',
  `rep_addtime` int(20) NOT NULL COMMENT '形成时间',
  `rep_finish` int(5) NOT NULL DEFAULT '0' COMMENT '补货是否发生 0未 1发生',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- 转存表中的数据 `mro_replenish`
--

INSERT INTO `mro_replenish` (`id`, `rep_num`, `rep_cate_id`, `rep_addtime`, `rep_finish`) VALUES
(1, 'RE1559720098', 1, 1559720098, 1),
(2, 'RE1559819585', 1, 1559819585, 1),
(3, 'RE1559819675', 1, 1559819675, 1),
(4, 'RE1559983809', 1, 1559983809, 0);

-- --------------------------------------------------------

--
-- 表的结构 `mro_replenish_item`
--

DROP TABLE IF EXISTS `mro_replenish_item`;
CREATE TABLE IF NOT EXISTS `mro_replenish_item` (
  `id` int(20) NOT NULL AUTO_INCREMENT COMMENT '补货单详情id',
  `rept_rep_id` int(20) NOT NULL COMMENT '对应补货单id',
  `rept_pdt_id` int(20) NOT NULL COMMENT '产品id',
  `rept_quantity` bigint(50) NOT NULL COMMENT '补货数量',
  `rept_sp_id` int(20) NOT NULL COMMENT '供应商id',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- 转存表中的数据 `mro_replenish_item`
--

INSERT INTO `mro_replenish_item` (`id`, `rept_rep_id`, `rept_pdt_id`, `rept_quantity`, `rept_sp_id`) VALUES
(1, 1, 9, 10, 4),
(2, 1, 9, 14, 4),
(3, 2, 4, 6, 4),
(4, 3, 4, 6, 4),
(5, 3, 1, 3, 4),
(6, 3, 1, 4, 4),
(7, 3, 1, 4, 4),
(8, 3, 1, 8, 4);

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
  `sko_rep_id` int(20) NOT NULL DEFAULT '0' COMMENT '该缺货单是够补货 0未 补货就放补货单id',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- 转存表中的数据 `mro_stockout`
--

INSERT INTO `mro_stockout` (`id`, `sko_num`, `sko_pdt_id`, `sko_quantity`, `sko_addtime`, `sko_rep_id`) VALUES
(1, 'SKO1559720087', 9, 10, 1559720087, 1),
(2, 'SKO1559720166', 9, 14, 1559720166, 1),
(3, 'SKO1559819578', 4, 6, 1559819578, 2),
(4, 'SKO1559819660', 4, 6, 1559819660, 3),
(5, 'SKO1559980882', 1, 3, 1559980882, 3),
(6, 'SKO1559982649', 1, 4, 1559982649, 3),
(7, 'SKO1559982667', 1, 4, 1559982667, 3),
(8, 'SKO1559982919', 1, 8, 1559982919, 3),
(9, 'SKO1559983795', 1, 4, 1559983795, 4),
(10, 'SKO1559984898', 1, 4, 1559984898, 4);

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
) ENGINE=MyISAM AUTO_INCREMENT=10 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- 转存表中的数据 `mro_supplier`
--

INSERT INTO `mro_supplier` (`id`, `sp_num`, `sp_name`, `sp_phone`, `sp_email`, `sp_address`, `sp_cate_id`, `sp_desc`, `sp_checked`, `sp_score`, `sp_addtime`) VALUES
(1, 'SP1558406681', '三晖', '321', '312@qq.com', 'wad', 8, 'da', 1, 0, 1558406681),
(3, 'SP1558425849', '电器类供应商', '15922318977', '3331dsd@qq.com', '天津市和平区', 7, '21', 1, 0, 1558425849),
(4, 'SP1558426030', '机械供应商', '2131', '123@123.com', '', 1, '', 1, 0, 1558426030),
(5, 'SP1558832654', '永信', '1491892837', '321wqewqe@163.com', '天津市和平区', 7, '一家公司', 0, 0, 1558832654),
(9, 'SP1559885865', '12', '12892329899', 'dsa@qq.com', '天津市南开区', 1, '圣诞节啊圣诞节啊大家啊', 0, 0, 1559885865);

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
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- 转存表中的数据 `mro_supply_list`
--

INSERT INTO `mro_supply_list` (`id`, `sl_num`, `sl_sp_id`, `sl_total_amount`, `sl_addtime`, `sl_storage`) VALUES
(1, 'SL1559269158', 1, 117, 1559269158, 2),
(2, 'SL1559269958', 4, 722, 1559269958, 3),
(3, 'SL1559283022', 1, 24, 1559283022, 4),
(4, 'SL1559289980', 3, 730, 1559289980, 5),
(5, 'SL1559295182', 3, 144, 1559295182, 6),
(6, 'SL1559295244', 4, 51, 1559295244, 7),
(7, 'SL1559819648', 4, 144, 1559819648, 8),
(8, 'SL1559819705', 4, 261, 1559819705, 9),
(9, 'SL1559984983', 4, 200, 1559984983, 10),
(10, 'SL1559985059', 3, 680, 1559985059, 11);

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
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- 转存表中的数据 `mro_supply_list_item`
--

INSERT INTO `mro_supply_list_item` (`id`, `slt_sl_id`, `slt_pdt_id`, `slt_quantity`, `slt_price`, `slt_total_amount`) VALUES
(1, 1, 6, 11, 4, 44),
(2, 1, 10, 11, 3, 33),
(3, 1, 5, 10, 4, 40),
(4, 2, 9, 7, 100, 700),
(5, 2, 4, 11, 2, 22),
(6, 3, 6, 6, 4, 24),
(7, 4, 8, 11, 30, 330),
(8, 4, 7, 8, 50, 400),
(9, 5, 8, 5, 12, 60),
(10, 5, 7, 4, 21, 84),
(11, 6, 1, 4, 4, 16),
(12, 6, 4, 5, 2, 10),
(13, 6, 9, 5, 5, 25),
(14, 7, 4, 36, 4, 144),
(15, 8, 9, 29, 9, 261),
(16, 9, 1, 19, 2, 38),
(17, 9, 4, 12, 3, 36),
(18, 9, 9, 7, 18, 126),
(19, 10, 8, 4, 100, 400),
(20, 10, 7, 14, 20, 280);

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
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- 转存表中的数据 `mro_warehouse`
--

INSERT INTO `mro_warehouse` (`id`, `wh_num`, `wh_name`, `wh_admin_name`, `wh_address`) VALUES
(1, 'WH001', '一号仓库', '扫地僧', '天津市西青区');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
