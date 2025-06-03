<?php
class ModelEmticketInstall extends Model {
	
	
	public function install() {
		
		$sql = "CREATE TABLE IF NOT EXISTS `".DB_PREFIX."mmfaq_category` (
			  `faqcategory_id` int(10) NOT NULL AUTO_INCREMENT,
			  `sort_order` varchar(50) NOT NULL,
			  `status` tinyint(4) NOT NULL,
			  `date_added` datetime NOT NULL,
			  `date_modified` datetime NOT NULL,
			  PRIMARY KEY (`faqcategory_id`)
			) ENGINE=MyISAM DEFAULT CHARSET=utf8";
					
					
		
		$query = $this->db->query($sql);
		$this->log->write('Faq Module --> Completed install');
		
		$sql = "CREATE TABLE IF NOT EXISTS `".DB_PREFIX."emknowledge_sec` (
			  `section_id` int(11) NOT NULL AUTO_INCREMENT,
			  `image` varchar(255) NOT NULL,
			  `sort_order` int(3) NOT NULL,
			  `status` tinyint(1) NOT NULL,
			  `date_added` datetime NOT NULL,
			  `date_modified` datetime NOT NULL,
			  PRIMARY KEY (`section_id`)
			) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=utf8";
					
					
		
		$query = $this->db->query($sql);
		$this->log->write('Emticket  Sql installed');
		
		$sql = "CREATE TABLE IF NOT EXISTS `".DB_PREFIX."emknowledge_secdescription` (
			  `section_id` int(11) NOT NULL,
			  `language_id` int(11) NOT NULL,
			  `name` varchar(255) NOT NULL,
			  `description` text NOT NULL,
			  `meta_title` varchar(255) NOT NULL,
			  `meta_description` varchar(255) NOT NULL,
			  `meta_keyword` varchar(255) NOT NULL,
			  PRIMARY KEY (`section_id`,`language_id`)
			) ENGINE=MyISAM DEFAULT CHARSET=utf8";
					
					
		
		$query = $this->db->query($sql);
		$this->log->write('Emticket  Sql installed');
		
		
		$sql = "CREATE TABLE IF NOT EXISTS `".DB_PREFIX."emticket_attach` (
			  `attach_id` int(11) NOT NULL AUTO_INCREMENT,
			  `ticket_id` int(11) NOT NULL,
			  `reply_id` int(11) NOT NULL,
			  `code` varchar(255) NOT NULL,
			  PRIMARY KEY (`attach_id`)
			) ENGINE=MyISAM AUTO_INCREMENT=49 DEFAULT CHARSET=utf8";
					
					
		
		$query = $this->db->query($sql);
		$this->log->write('Emticket  Sql installed');
		
		$sql = "CREATE TABLE IF NOT EXISTS `".DB_PREFIX."emticket_department` (
			  `department_id` int(11) NOT NULL AUTO_INCREMENT,
			  `sort_order` int(3) NOT NULL,
			  `status` tinyint(1) NOT NULL,
			  `date_added` datetime NOT NULL,
			  `date_modified` datetime NOT NULL,
			  PRIMARY KEY (`department_id`)
			) ENGINE=MyISAM AUTO_INCREMENT=24 DEFAULT CHARSET=utf8";
					
					
		
		$query = $this->db->query($sql);
		$this->log->write('Emticket  Sql installed');
		
		
		
		$sql = "CREATE TABLE IF NOT EXISTS `".DB_PREFIX."emticket_department_description` (
			  `department_id` int(11) NOT NULL,
			  `language_id` int(11) NOT NULL,
			  `name` varchar(255) NOT NULL,
			  `small_desc` varchar(500) NOT NULL,
			  PRIMARY KEY (`department_id`,`language_id`)
			) ENGINE=MyISAM DEFAULT CHARSET=utf8";
					
					
		
		$query = $this->db->query($sql);
		$this->log->write('Emticket  Sql installed');
					
					
				
		
		$sql = "CREATE TABLE IF NOT EXISTS `".DB_PREFIX."emticket_priority` (
			  `priority_id` int(11) NOT NULL AUTO_INCREMENT,
			  `info` text NOT NULL,
			  `sort_order` int(3) NOT NULL,
			  `status` tinyint(1) NOT NULL,
			  PRIMARY KEY (`priority_id`)
			) ENGINE=MyISAM AUTO_INCREMENT=26 DEFAULT CHARSET=utf8";
					
					
		
		$query = $this->db->query($sql);
		$this->log->write('Emticket  Sql installed');
				
		
		$sql = "CREATE TABLE IF NOT EXISTS `".DB_PREFIX."emticket_status` (
		  `id` int(11) NOT NULL AUTO_INCREMENT,
		  `info` text NOT NULL,
		  `sort_order` int(3) NOT NULL,
		  `status` tinyint(1) NOT NULL,
		  `date_added` datetime NOT NULL,
		  `date_modified` datetime NOT NULL,
		  PRIMARY KEY (`id`)
		) ENGINE=MyISAM AUTO_INCREMENT=8 DEFAULT CHARSET=utf8";
					
					
		
		$query = $this->db->query($sql);
		$this->log->write('Emticket  Sql installed');
		
		
		
		$sql = "CREATE TABLE IF NOT EXISTS `".DB_PREFIX."emtickets` (
		  `ticket_id` int(11) NOT NULL AUTO_INCREMENT,
		  `customer_id` int(11) NOT NULL,
		  `firstname` varchar(32) NOT NULL,
		  `lastname` varchar(32) NOT NULL,
		  `email` varchar(96) NOT NULL,
		  `telephone` varchar(32) NOT NULL,
		  `ip` varchar(40) NOT NULL,
		  `department` int(4) NOT NULL,
		  `ticket_status` int(4) NOT NULL,
		  `priority` int(4) NOT NULL,
		  `subject` varchar(300) NOT NULL,
		  `message` text NOT NULL,
		  `date_added` datetime NOT NULL,
		  `date_modified` datetime NOT NULL,
		  PRIMARY KEY (`ticket_id`)
		) ENGINE=MyISAM AUTO_INCREMENT=25 DEFAULT CHARSET=utf8";
		
		
		$query = $this->db->query($sql);
		$this->log->write('Emticket  Sql installed');
		
		$sql = "CREATE TABLE IF NOT EXISTS `".DB_PREFIX."emtickets_reply` (
		  `reply_id` int(11) NOT NULL AUTO_INCREMENT,
		  `ticket_id` int(11) NOT NULL,
		  `user_identity` tinyint(3) NOT NULL,
		  `admin_id` int(11) NOT NULL,
		  `client_id` int(11) NOT NULL,
		  `message` text NOT NULL,
		  `date_added` datetime NOT NULL,
		  PRIMARY KEY (`reply_id`)
		) ENGINE=MyISAM AUTO_INCREMENT=39 DEFAULT CHARSET=utf8";
		
		
		$query = $this->db->query($sql);
		$this->log->write('Emticket  Sql installed');
		
		
		$sql = "CREATE TABLE IF NOT EXISTS `".DB_PREFIX."emknowledge_article` (
		  `article_id` int(11) NOT NULL AUTO_INCREMENT,
		  `section_id` int(11) NOT NULL,
		  `status` tinyint(1) NOT NULL,
		  `sort_order` int(3) NOT NULL,
		  `date_added` datetime NOT NULL,
		  `date_modified` datetime NOT NULL,
		  PRIMARY KEY (`article_id`)
		) ENGINE=MyISAM AUTO_INCREMENT=7 DEFAULT CHARSET=utf8";
		
		
		$query = $this->db->query($sql);
		$this->log->write('Emticket  Sql installed');
		
		
		$sql = "CREATE TABLE IF NOT EXISTS `".DB_PREFIX."emknowledge_articledescription` (
		  `article_id` int(11) NOT NULL,
		  `language_id` int(11) NOT NULL,
		  `name` varchar(255) NOT NULL,
		  `description` text NOT NULL,
		  `meta_title` varchar(255) NOT NULL,
		  `meta_description` varchar(255) NOT NULL,
		  `meta_keyword` varchar(255) NOT NULL,
		  PRIMARY KEY (`article_id`,`language_id`)
		) ENGINE=MyISAM DEFAULT CHARSET=utf8";
		
		
		$query = $this->db->query($sql);
		$this->log->write('Emticket  Sql installed');
					
					
					
					
					
		
	}
	

}
