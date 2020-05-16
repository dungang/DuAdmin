-- --------------------------------------------------------
-- 主机:                           127.0.0.1
-- 服务器版本:                        10.4.8-MariaDB - mariadb.org binary distribution
-- 服务器操作系统:                      Win64
-- HeidiSQL 版本:                  11.0.0.5919
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;

-- 导出  表 baiyuan-cms.ma_message 结构
CREATE TABLE IF NOT EXISTS `ma_message` (
  `id` int(11) NOT NULL,
  `language` varchar(16) NOT NULL,
  `translation` text DEFAULT NULL,
  PRIMARY KEY (`id`,`language`),
  KEY `idx_message_language` (`language`),
  CONSTRAINT `fk_message_source_message` FOREIGN KEY (`id`) REFERENCES `ma_source_message` (`id`) ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- 正在导出表  baiyuan-cms.ma_message 的数据：~0 rows (大约)
/*!40000 ALTER TABLE `ma_message` DISABLE KEYS */;
INSERT INTO `ma_message` (`id`, `language`, `translation`) VALUES
	(1, 'zh-CN', '公司产品'),
	(2, 'zh-CN', '多语言消息'),
	(3, 'zh-CN', '语言消息'),
	(4, 'zh-CN', '源语言消息'),
	(5, 'zh-CN', '类别');
/*!40000 ALTER TABLE `ma_message` ENABLE KEYS */;

-- 导出  表 baiyuan-cms.ma_source_message 结构
CREATE TABLE IF NOT EXISTS `ma_source_message` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `category` varchar(255) DEFAULT NULL,
  `message` text DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `idx_source_message_category` (`category`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4;

-- 正在导出表  baiyuan-cms.ma_source_message 的数据：~0 rows (大约)
/*!40000 ALTER TABLE `ma_source_message` DISABLE KEYS */;
INSERT INTO `ma_source_message` (`id`, `category`, `message`) VALUES
	(1, 'app', 'Production'),
	(2, 'app', 'Messages'),
	(3, 'app', 'Message'),
	(4, 'app', 'Source Messages'),
	(5, 'app', 'Category'),
	(6, 'app', 'Operation');
/*!40000 ALTER TABLE `ma_source_message` ENABLE KEYS */;

/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
