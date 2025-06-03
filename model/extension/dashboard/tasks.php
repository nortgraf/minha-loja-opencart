<?php

class ModelExtensionDashboardTasks extends Model {
  public function install() {
		$this->db->query("
			CREATE TABLE `" . DB_PREFIX . "dashboard_tasks` (
				`task_id` INT(11) NOT NULL AUTO_INCREMENT,
				`task_description` VARCHAR(255) NOT NULL,
				`task_status` TINYINT(1) NOT NULL,
				`task_deadline` DATETIME NOT NULL,
				PRIMARY KEY (`task_id`)
			) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;
		");
    $this->db->query("
      INSERT INTO `" . DB_PREFIX . "dashboard_tasks` (task_id, task_description, task_status, task_deadline)
      VALUES 
        (1, 'Completed, deadline has passed.', '2', '2019-01-01 17:00'),
        (2, 'Completed, deadline has not passed.', '2', '2047-01-01 17:00'),
        (3, 'Pending, deadline has passed.', '1', '2019-01-01 17:00'),
        (4, 'Pending, deadline has not passed.', '1', '2047-01-01 17:00'),
        (5, 'Inactive, deadline has passed.', '0', '2019-01-01 17:00'),
        (6, 'Inactive, deadline has not passed.', '0', '2047-01-01 17:00');
    ");
  }

  public function getTasks($filter) {
		$sql = "SELECT * FROM `" . DB_PREFIX . "dashboard_tasks` ORDER BY " . $filter . " ASC;";

		$query = $this->db->query($sql);

		return $query->rows;
	}

	public function checkTask($task_id) {
		$this->db->query("UPDATE `" . DB_PREFIX . "dashboard_tasks` SET task_status='2' WHERE task_id = '" . (int)$task_id . "';");
	}

  public function deleteChecked() {
		$this->db->query("DELETE FROM `" . DB_PREFIX . "dashboard_tasks` WHERE task_status = '2'");
	}

  public function addTask($status, $description, $deadline) {
		$this->db->query("INSERT INTO `" . DB_PREFIX . "dashboard_tasks` (task_status, task_description, task_deadline)
		                  VALUES ('" . $status . "', '" . $description . "', '" . $deadline . "')");
	}

  public function editTask($task_id, $status, $description, $deadline) {
		$this->db->query("UPDATE `" . DB_PREFIX . "dashboard_tasks`
						SET task_status='" . $status . "', task_description='" . $description . "', task_deadline='" . $deadline . "' 
						WHERE task_id = '" . (int)$task_id . "';");
	}

  public function deleteTask($task_id) {
		$this->db->query("DELETE FROM `" . DB_PREFIX . "dashboard_tasks` WHERE task_id = '" . (int)$task_id . "'");
	}
  
  public function uninstall() {
    $this->db->query("DROP TABLE `" . DB_PREFIX . "dashboard_tasks`;");
  }
}
