<?php require_once("includes/connection.php"); ?>
<?php require_once("includes/functions.php"); ?>
<?php 
	$errors = array();

	//Form Validation
	$required_fields = array('menu_name', 'position', 'visible', 'content');
	foreach($required_fields as $fieldname) {
		if (!isset($_POST[$fieldname]) || empty($_POST[$fieldname])) { 
			$errors[] = $fieldname;
		}
	}
	$fields_with_lengths = array('menu_name' => 30);
	foreach($fields_with_lengths as $fieldname => $maxlength ) {
		if (strlen(trim(mysql_prep($_POST[$fieldname]))) > $maxlength) { $errors[] = $fieldname; }
	}

	$fields_with_lengths = array('content' => 255);
	foreach($fields_with_lengths as $fieldname => $maxlength ) {
		if (strlen(trim(mysql_prep($_POST[$fieldname]))) > $maxlength) { $errors[] = $fieldname; }
	}

	if (!empty($errors)) {
		redirect_to("new_page.php");
	}
?>
<?php
	$menu_name = mysql_prep($_POST['menu_name']); 
	$position = mysql_prep($_POST['position']);
	$visible = mysql_prep($_POST['visible']);
	$content = mysql_prep($_POST['content']);
?>

<?php 
	$query = "INSERT INTO pages (
				menu_name, position, visible, content
			) VALUES (
				'{$menu_name}', {$position}, {$visible}, {$content}
			)";
	if ($connection->query($query)) {
		//Success!
		header("Location: content.php");
		exit;
	} else {
		//Display error message.
		echo "<p>Page creation failed.</p>";
		echo "<p>" . mysql_error() . "</p>";
	}
?>
<?php mysqli_close($connection); ?>