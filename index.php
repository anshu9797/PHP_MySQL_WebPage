<?php
    $server = "localhost";
    $username = "anshu";
    $password = "123456";
    $db = "php_form";
    $conn = mysqli_connect($server, $username, $password, $db);
?>
<html>
    <head>
        <title>PHP FORM</title>
		<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
		<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>			
    </head>
    <body>
		<div class='container'>
			<div class='jumbotron'>
				<h2>Simple CRUD (PHP With MySQL)</h2>
			</div>
			<?php
				if( isset($_GET['edit_id']) ){
				$sql = "SELECT * FROM users WHERE id = '$_GET[edit_id]' ";
				$run = mysqli_query($conn, $sql);
				while( $rows = mysqli_fetch_assoc($run) ){
					$user = $rows['name'];
					$email = $rows['email'];
					$password = $rows['password'];
					$contact = $rows['contact'];
				}
				?>
					<h2>Edit User</h2>
				<form class='col-md-6' method='post'>
				<div class='form-group'>
					<label>UserName</label>
					<input type='text' name='edit_user' value ='<?php echo $user; ?>' class='form-control' required>
				</div>
				<div class='form-group'>
					<label>Email</label>
					<input type='email' name='edit_email' value ='<?php echo $email; ?>' class='form-control' required>
				</div>
				<div class='form-group'>
					<label>Password</label>
					<input type='password' name='edit_password' value ='<?php echo $password; ?>' class='form-control' required>
				</div>
				<div class='form-group'>
					<label>Contact</label>
					<input type='text' name='edit_contact' value ='<?php echo $contact; ?>' class='form-control'>
				</div>
				<div class='form-group'>
					<input type='hidden' name='edit_user_id' value='<?php echo $_GET['edit_id']?>'>
					<input type='submit' name='edit_user_btn' value='Done Editing' class='btn btn-primary'>
				</div>
				</form>
			<?php } else{ ?>
				<h2>Insert New User</h2>
				<form class='col-md-6' method='post'>
				<div class='form-group'>
					<label>UserName</label>
					<input type='text' name='user' class='form-control' required>
				</div>
				<div class='form-group'>
					<label>Email</label>
					<input type='email' name='email' class='form-control' required>
				</div>
				<div class='form-group'>
					<label>Password</label>
					<input type='password' name='password' class='form-control' required>
				</div>
				<div class='form-group'>
					<label>Contact</label>
					<input type='text' name='contact' class='form-control'>
				</div>
				<div class='form-group'>
					<input type='submit' name='submit_user' class='btn btn-danger'>
				</div>
				</form>
			<?php }
				$sql = "SELECT * FROM users";
				$run = mysqli_query($conn, $sql);
				echo "
					<table class='table'>
						<thead>
							<tr>
								<th>S.No</th>
								<th>Name</th>
								<th>Email</th>
								<th>Password</th>
								<th>Contact No</th>
								<th>Date</th>
								<th>Edit</th>
								<th>Delete</th>
							</tr>
						</thead>
						<tbody>
				";
				$c = 1;
				while( $rows = mysqli_fetch_assoc($run) ){
					echo "
						<tr>
							<td>$c</td>
							<td>$rows[name]</td>
							<td>$rows[email]</td>
							<td>$rows[password]</td>
							<td>$rows[contact]</td>
							<td>$rows[date]</td>
							<td><a href='index.php?edit_id=$rows[id]' class='btn btn-success'>Edit</a></td>
							<td><a href='index.php?del_id=$rows[id]' class='btn btn-danger'>Delete</a></td>
						</tr>
					";
					$c++;
				}
				echo "</tbody>
					</table>";
			?>
			</div>
    </body>
</html>
<?php
	if( isset($_POST['submit_user']) ){
		$user = mysqli_real_escape_string($conn, strip_tags($_POST['user']));
		$email = mysqli_real_escape_string($conn, strip_tags($_POST['email']));
		$password = mysqli_real_escape_string($conn, strip_tags($_POST['password']));
		if( isset($_POST['contact']) ){
			$contact = mysqli_real_escape_string($conn, strip_tags($_POST['contact']));
		}
		$date = date('Y-m-d');
		$ins_sql = "INSERT INTO users (name, email, password, contact, date) VALUES ('$user', '$email', '$password', '$contact', '$date')";
		if(mysqli_query($conn, $ins_sql)){ ?>
			<script>window.location = "index.php";</script>
		<?php }
	}
	if( isset($_GET['del_id']) ){
		$del_sql = "DELETE FROM users WHERE id = '$_GET[del_id]' ";
		if(mysqli_query($conn, $del_sql)){ ?>
				<script>window.location = "index.php";</script>
		<?php }
	}
	if( isset($_POST['edit_user_btn']) ){
		$edit_user = mysqli_real_escape_string($conn, strip_tags($_POST['edit_user']));
		$edit_email = mysqli_real_escape_string($conn, strip_tags($_POST['edit_email']));
		$edit_password = mysqli_real_escape_string($conn, strip_tags($_POST['edit_password']));
		$edit_contact = mysqli_real_escape_string($conn, strip_tags($_POST['edit_contact']));
		$edit_id = $_POST['edit_user_id'];
		$edit_sql = "UPDATE users SET name = '$edit_user', email = '$edit_email', password = '$edit_password', contact = '$edit_contact' WHERE id = '$edit_id' ";
		if(mysqli_query($conn, $edit_sql)){ ?>
			<script>window.location = 'index.php';</script>
		<?php }
	}
?>




















