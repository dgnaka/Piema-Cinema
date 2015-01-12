<?php
	// This file is the place to store all basic functions
	
	function mysql_prep($value) {
		global $connection;
		$magic_quotes_active = get_magic_quotes_gpc();
		$new_enough_php = function_exists("mysqli_real_escape_string"); //i.e. PHP >= v4.3.0
		if ($new_enough_php) {
			if($magic_quotes_active) {$value = stripslashes($value);}
			$value = $connection->real_escape_string($value);
		} else { //before PHP v4.3.0
			//if magic quotes aren't already on then add slashes manually
			if(!$magic_quotes_active) {$value = addslashes($value);}
			//if magic quotes are active, then the slashes already exist
		}
		return $value;
	}

	function redirect_to($location = NULL) {
		if($location != NULL) {
			header("Location: {$location}");
			exit;
		}
	}

	function confirm_query($result_set) {
		if (!$result_set) {
			die("Database query failed: " . mysql_error());
		}
	}

	function get_all_subjects() {
		global $connection;
		$query = "SELECT * 
				FROM subjects 
				ORDER BY position ASC";
		$subject_set = $connection->query($query);
		confirm_query($subject_set);
		return $subject_set;
	}

	function get_all_pages() {
		global $connection;
		$query = "SELECT * 
				FROM pages 
				ORDER BY position ASC";
		$page_set = $connection->query($query);
		confirm_query($page_set);
		return $page_set;
	}

	function get_pages_for_subjects($subject_id) {
		global $connection;
		$query = "SELECT * 
				FROM pages 
				WHERE subject_id = {$subject_id} 
				ORDER BY position ASC";
		$page_set = $connection->query($query);
		confirm_query($page_set);
		return $page_set;
	}

	function get_subject_by_id($subject_id) {
		global $connection;
		$query = "SELECT * ";
		//FROM subjects WHERE id = {$subject_id} LIMIT 1";
		$query .= "FROM subjects ";
		$query .= "WHERE id=" . $subject_id . " ";
		$query .= "LIMIT 1";
		$result_set = $connection->query($query);
		confirm_query($result_set);
		//if no rows are returned, fetch_array will return false
		if ($subject = $result_set->fetch_array()) {
			return $subject;
		} else {
			return NULL;
		}
	}

	function get_page_by_id($page_id) {
		global $connection;
		$query = "SELECT * ";
		$query .= "FROM pages ";
		$query .= "WHERE id=" . $page_id . " ";
		$query .= "LIMIT 1";
		$result_set = $connection->query($query);
		confirm_query($result_set);
		if ($page = $result_set->fetch_array()) {
			return $page;
		} else {
			return NULL;
		}
	}

	function find_selected_page() {
		global $sel_subject;
		global $sel_page;
		if(isset($_GET['subj'])) {
			$sel_page = NULL;
			$sel_subject = get_subject_by_id($_GET['subj']);
		} elseif (isset($_GET['page'])) {
			$sel_subject = NULL;
			$sel_page = get_page_by_id($_GET['page']);
		} else {
			$sel_subject = NULL;
			$sel_page = NULL;
		}
	}

	function navigation($sel_subject, $sel_page) {
		$output = "<ul class=\"subjects\">";
		$subject_set = get_all_subjects();		
		while ($subject = $subject_set->fetch_array()) {
			$output .= "<li";
			if ($subject["id"] == $sel_subject['id']) { $output .= " class=\"selected\""; }
			$output .= "><a href=\"edit_subject.php?subj=" . urlencode($subject["id"]) . 
				"\">{$subject["menu_name"]}</a></li>";
			$page_set = get_pages_for_subjects($subject["id"]);
			$output .= "<ul class=\"pages\">";
			while ($page = $page_set->fetch_array()) {
				$output .= "<li";
				if ($page["id"] == $sel_page['id']) {	$output .= " class=\"selected\""; }
				$output .= "><a href=\"content.php?page=" . urlencode($page["id"]) . 
				"\">{$page["menu_name"]}</a></li>";
			}
			$output .= "</ul>";
		}


		$output .= "</ul>";
		return $output;
	}
?>