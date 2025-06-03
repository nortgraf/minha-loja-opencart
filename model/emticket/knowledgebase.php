<?php
class ModelEmticketKnowledgebase extends Model {    
	
	public function deleteSection($section_id) {
		
		$this->db->query("DELETE FROM " . DB_PREFIX . "emknowledge_sec WHERE section_id = '" . (int)$section_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "emknowledge_secdescription WHERE section_id = '" . (int)$section_id . "'");
		$this->db->query("DELETE " . DB_PREFIX . "emknowledge_article," . DB_PREFIX . "emknowledge_articledescription  FROM  " . DB_PREFIX . "emknowledge_article INNER JOIN " . DB_PREFIX . "emknowledge_articledescription ON " . DB_PREFIX . "emknowledge_article.article_id = " . DB_PREFIX . "emknowledge_articledescription.article_id WHERE " . DB_PREFIX . "emknowledge_article.section_id = '" . (int)$section_id . "'");
		
	}
	
	public function deleteArticle($article_id) {
		
		$this->db->query("DELETE FROM " . DB_PREFIX . "emknowledge_article WHERE article_id = '" . (int)$article_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "emknowledge_articledescription WHERE article_id = '" . (int)$article_id . "'");
	    $this->cache->delete('emknowledge_article');
	}
	
	
	public function add_Section($data)
	{
	
		$this->db->query("INSERT INTO " . DB_PREFIX . "emknowledge_sec SET  sort_order = '" . (int)$data['sort_order'] . "', status = '" . (int)$data['status'] . "', image = '" . $this->db->escape($data['image']) . "', date_added = NOW()");
		
		$section_id = $this->db->getLastId();
		
		
		
		foreach($data['knowledge_section_description'] as $lang_id => $value)
		{		
			$this->db->query("INSERT INTO " . DB_PREFIX . "emknowledge_secdescription SET section_id = '" . (int)$section_id . "', language_id = '" . (int)$lang_id . "', name = '" . $this->db->escape($value['name']) . "', description = '" . $this->db->escape($value['description']) . "', meta_title = '" . $this->db->escape($value['meta_title']) . "', meta_description = '" . $this->db->escape($value['meta_description']) . "', meta_keyword = '" . $this->db->escape($value['meta_keyword']) . "'");
		
		}	
		
	}

	public function edit_Section($section_id, $data) {
		
		$this->db->query("UPDATE " . DB_PREFIX . "emknowledge_sec SET  sort_order = '" . (int)$data['sort_order'] . "', status = '" . (int)$data['status'] . "', image = '" . $this->db->escape($data['image']) . "', date_modified = NOW() where section_id = '" . (int)$section_id . "'");
		
		
		
		
		$this->db->query("DELETE FROM " . DB_PREFIX . "emknowledge_secdescription WHERE section_id = '" . (int)$section_id . "'");
		
		foreach($data['knowledge_section_description'] as $lang_id => $value)
		{		
			$this->db->query("INSERT INTO " . DB_PREFIX . "emknowledge_secdescription SET section_id = '" . (int)$section_id . "', language_id = '" . (int)$lang_id . "', name = '" . $this->db->escape($value['name']) . "', description = '" . $this->db->escape($value['description']) . "', meta_title = '" . $this->db->escape($value['meta_title']) . "', meta_description = '" . $this->db->escape($value['meta_description']) . "', meta_keyword = '" . $this->db->escape($value['meta_keyword']) . "'");
		
		}	
	}
	
	public function getSections($data = array()) {				
		
		$sql = "SELECT * FROM ".DB_PREFIX."emknowledge_sec qus LEFT JOIN ".DB_PREFIX."emknowledge_secdescription mfd ON (qus.section_id=mfd.section_id) where  mfd.language_id = '" . (int)$this->config->get('config_language_id') . "'";

		 if (!empty($data['filter_name'])) {
			$sql .= " WHERE mfd.name LIKE '" . $this->db->escape($data['filter_name']) . "%'";
		}

		$sort_data = array('name','status','sort_order');

		if (isset($data['sort']) && in_array($data['sort'], $sort_data)) {
			 $sql .= " ORDER BY " . $data['sort'];
		} else {
			$sql .= " ORDER BY name";
		}

		if (isset($data['order']) && ($data['order'] == 'DESC')) {
			$sql .= " DESC";
		} else {
			$sql .= " ASC";
		} 

		if (isset($data['start']) || isset($data['limit'])) {
			if ($data['start'] < 0) {
				$data['start'] = 0;
			}

			if ($data['limit'] < 1) {
				$data['limit'] = 20;
			}

			$sql .= " LIMIT " . (int)$data['start'] . "," . (int)$data['limit'];
		} 

		$query = $this->db->query($sql);

		return $query->rows;
	}
	public function getSection($section_id) {
		
		$sql = "SELECT * FROM ".DB_PREFIX."emknowledge_sec mfc LEFT JOIN ".DB_PREFIX."emknowledge_secdescription mcd ON (mfc.section_id=mcd.section_id) where  mcd.language_id = '" . (int)$this->config->get('config_language_id') . "' and mfc.section_id = '" . $section_id . "'";
		
		$query = $this->db->query($sql);

		return $query->row;
	}
	
	public function getSectiondescription($section_id) {
		$section_description_data = array();

		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "emknowledge_secdescription WHERE section_id = '" . (int)$section_id . "'");

		foreach ($query->rows as $result) {
			$section_description_data[$result['language_id']] = array(
				'name'             => $result['name'],
				'meta_title'       => $result['meta_title'],
				'meta_description' => $result['meta_description'],
				'meta_keyword'     => $result['meta_keyword'],
				'description'      => $result['description']
				
				
			);
		}

		return $section_description_data;
	}
		

	public function getSectionz($data = array()) {
		
		//print_r($data);
		
	
		$sql = "SELECT * FROM " . DB_PREFIX . "emknowledge_sec mfc LEFT JOIN ".DB_PREFIX."emknowledge_secdescription mcd ON (mfc.section_id=mcd.section_id)";

		if (!empty($data['filter_name'])) {
			$sql .= " WHERE mcd.name LIKE '" . $this->db->escape($data['filter_name']) . "%'";
		}

		$sort_data = array('name','sort_order');

		if (isset($data['sort']) && in_array($data['sort'], $sort_data)) {
			 $sql .= " ORDER BY " . $data['sort'];
		} else {
			$sql .= " ORDER BY name";
		}

		if (isset($data['order']) && ($data['order'] == 'DESC')) {
			$sql .= " DESC";
		} else {
			$sql .= " ASC";
		}

		if (isset($data['start']) || isset($data['limit'])) {
			if ($data['start'] < 0) {
				$data['start'] = 0;
			}

			if ($data['limit'] < 1) {
				$data['limit'] = 20;
			}

			$sql .= " LIMIT " . (int)$data['start'] . "," . (int)$data['limit'];
		} 

		$query = $this->db->query($sql);

		return $query->rows;
	}

	public function getTotalContact() {
		$query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "emknowledge_sec");

		return $query->row['total'];
	}
	

	
	
	public function addArticle($data)
	{
		// print_r($data);die();
		$this->db->query("INSERT INTO " . DB_PREFIX . "emknowledge_article SET  section_id='".$this->db->escape($data['section_id'])."', sort_order = '" . (int)$data['sort_order'] . "', status = '" . (int)$data['status'] . "', date_added = NOW()");
		$article_id = $this->db->getLastId();
		
		foreach($data['article_description'] as $language_id => $value)
		{		
			$sql="INSERT INTO " . DB_PREFIX . "emknowledge_articledescription SET 
			name='".$this->db->escape($value['name'])."',
			meta_title='".$this->db->escape($value['meta_title'])."',
			meta_description='".$this->db->escape($value['meta_description'])."',
			meta_keyword='".$this->db->escape($value['meta_keyword'])."',
			description='".$this->db->escape($value['description'])."',language_id='".(int)$language_id."',article_id='".(int)$article_id."'";
			$this->db->query($sql);
			$this->cache->delete('emknowledge_articledescription');
		}		
	}
	
	public function editArticle($article_id,$data){
				
		$this->db->query("update " . DB_PREFIX . "emknowledge_article SET  section_id='".$this->db->escape($data['section_id'])."', sort_order = '" . (int)$data['sort_order'] . "', status = '" . (int)$data['status'] . "', date_modified = NOW() WHERE article_id = '" . (int)$article_id . "'");
		
		
		$this->db->query("DELETE FROM " . DB_PREFIX . "emknowledge_articledescription WHERE article_id = '" . (int)$article_id . "'");
		
		foreach($data['article_description'] as $language_id => $value)
		{		
			$sql="INSERT INTO " . DB_PREFIX . "emknowledge_articledescription SET 
			name='".$this->db->escape($value['name'])."',
			meta_title='".$this->db->escape($value['meta_title'])."',
			meta_description='".$this->db->escape($value['meta_description'])."',
			meta_keyword='".$this->db->escape($value['meta_keyword'])."',			
			description='".$this->db->escape($value['description'])."',			
			language_id='".(int)$language_id."',article_id='".(int)$article_id."'";
			$this->db->query($sql);
			$this->cache->delete('emknowledge_articledescription');
		}				

		
	}
	
	public function getTotalArticles() {
		$query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "emknowledge_article");

		return $query->row['total'];
	}
	
	public function getSecNameBySectionId($section_id) {	
		$name="";
		$sql = "SELECT * FROM ".DB_PREFIX."emknowledge_sec mfc LEFT JOIN ".DB_PREFIX."emknowledge_secdescription mcd ON (mfc.section_id=mcd.section_id) where  mcd.language_id = '" . (int)$this->config->get('config_language_id') . "' and mfc.section_id = '" . $section_id . "'";
		
		$query = $this->db->query($sql);
			if(isset($query->row['name'])){
				$name = $query->row['name'];
			}
		return $name;
	}
	
	public function getArticle($article_id) {
		
		$sql = "SELECT * FROM ".DB_PREFIX."emknowledge_article qus LEFT JOIN ".DB_PREFIX."emknowledge_articledescription mfd ON (qus.article_id=mfd.article_id) where  mfd.language_id = '" . (int)$this->config->get('config_language_id') . "' and qus.article_id = '" . $article_id . "'";
		
		$query = $this->db->query($sql);

		return $query->row;
	}
	
	
	
	public function getArticles($data = array()) {
		
		$sql = "SELECT * FROM ".DB_PREFIX."emknowledge_article qus LEFT JOIN ".DB_PREFIX."emknowledge_articledescription mfd ON (qus.article_id=mfd.article_id) where  mfd.language_id = '" . (int)$this->config->get('config_language_id') . "'";

		 if (!empty($data['filter_name'])) {
			$sql .= " WHERE section_id LIKE '" . $this->db->escape($data['filter_name']) . "%'";
		}

		$sort_data = array('question','date_added','sort_order');

		if (isset($data['sort']) && in_array($data['sort'], $sort_data)) {
			 $sql .= " ORDER BY " . $data['sort'];
		} else {
			$sql .= " ORDER BY section_id";
		}

		if (isset($data['order']) && ($data['order'] == 'DESC')) {
			$sql .= " DESC";
		} else {
			$sql .= " ASC";
		} 

		if (isset($data['start']) || isset($data['limit'])) {
			if ($data['start'] < 0) {
				$data['start'] = 0;
			}

			if ($data['limit'] < 1) {
				$data['limit'] = 20;
			}

			$sql .= " LIMIT " . (int)$data['start'] . "," . (int)$data['limit'];
		} 

		$query = $this->db->query($sql);

		return $query->rows;
	}
	

	public function getArticleDescriptions($article_id) {
		$article_description_data = array();

		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "emknowledge_articledescription WHERE article_id = '" . (int)$article_id . "'");

		foreach ($query->rows as $result) {
			$article_description_data[$result['language_id']] = array(
				'name'             => $result['name'],
				'meta_title'       => $result['meta_title'],
				'meta_description' => $result['meta_description'],
				'meta_keyword'     => $result['meta_keyword'],
				'description'      => $result['description']
				
			);
		}

		return $article_description_data;
	}
	
	
	public function install() {
		
					/* $sql = "CREATE TABLE IF NOT EXISTS `".DB_PREFIX."emknowledge_sec` (
						  `section_id` int(10) NOT NULL AUTO_INCREMENT,
						  `sort_order` varchar(50) NOT NULL,
						  `status` tinyint(4) NOT NULL,
						  `date_added` datetime NOT NULL,
						  `date_modified` datetime NOT NULL,
						  PRIMARY KEY (`section_id`)
						) ENGINE=MyISAM DEFAULT CHARSET=utf8";
								
								
					
					$query = $this->db->query($sql);
					$this->log->write('Faq Module --> Completed install');
					
					$sql = "CREATE TABLE IF NOT EXISTS `".DB_PREFIX."emknowledge_secdescription` (
					  `section_id` int(10) NOT NULL,
					  `language_id` int(10) NOT NULL,
					  `name` varchar(55) NOT NULL,
					  PRIMARY KEY (`section_id`,`language_id`)
					) ENGINE=MyISAM DEFAULT CHARSET=utf8";
								
								
					
					$query = $this->db->query($sql);
					$this->log->write('Faq Module --> Completed install');
					
					
					$sql = "CREATE TABLE IF NOT EXISTS `".DB_PREFIX."emknowledge_articledescription` (
					  `faq_id` int(10) NOT NULL,
					  `language_id` int(10) NOT NULL,
					  `question` text NOT NULL,
					  `answer` text NOT NULL,
					  PRIMARY KEY (`faq_id`,`language_id`)
					) ENGINE=MyISAM DEFAULT CHARSET=utf8";
										
					
					$query = $this->db->query($sql);
					$this->log->write('Faq Module --> Completed install');
					
					
					$sql = "CREATE TABLE IF NOT EXISTS `".DB_PREFIX."emknowledge_article` (
					  `faq_id` int(10) NOT NULL AUTO_INCREMENT,
					  `category` int(10) NOT NULL,
					  `status` tinyint(4) NOT NULL,
					  `sort_order` varchar(20) NOT NULL,
					  `date_added` datetime NOT NULL,
					  `date_modified` datetime NOT NULL,
					  PRIMARY KEY (`faq_id`)
					) ENGINE=MyISAM DEFAULT CHARSET=utf8";
					
					
					$query = $this->db->query($sql);
					$this->log->write('Faq Module --> Completed install');
					
					 */
					
		
	}
	

	
}
