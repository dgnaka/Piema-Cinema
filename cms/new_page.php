<?php require_once("includes/connection.php"); ?>
<?php require_once("includes/functions.php"); ?>
<?php find_selected_page() ?>
<?php include("includes/header.php"); ?>

<table id="structure">
	<tr>
		<td id="navigation">
			<?php echo navigation($sel_subject, $sel_page) ?>
		</td>
		<td id="page">
			<h2>Add Subject</h2>
			<form action="create_page.php" method="post">
				<p>Subject name:
					<input type="text" name="menu_name" value=" " id="menu_name" />
				</p>
				<p>Position
					<select name="position">
						<?php 
							$page_set = get_all_pages();
							$page_count = $page_set->num_rows;
							//$subject_count + 1 because we're adding a subject
							for($count=1; $count <= $page_count+1; $count++) {
								echo "<option value=\"{$count}\">{$count}</option>";
							}
						?>
						<option value="1">1</option>
					</select>
				</p>
				<p>Visible:
					<input type="radio" name="visible" value="0" /> No
					<input type="radio" name="visible" value="1" /> Yes
				</p>
				<p>Content:
					<br>
					<textarea name="content" id="content" cols="30" rows="10"> </textarea>
				</p>
				<input type="submit" value="Add Page" />
			</form>
			<br />
			<a href="content.php">Cancel</a>
		</td>
	</tr>
</table>
<?php require("includes/footer.php"); ?>