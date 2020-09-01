<!DOCTYPE html>
<html>
<head>
	<title>Show User List</title>
	<meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</head>
<body>
	<div class="container mt-5">
		<h4>Users List</h4>
		<table class="table table-bordered table-dark">
			<thead>
				<tr>
					<th>S.No.</th>
					<th>Profile Image</th>
					<th>Full Name</th>
					<th>Email</th>
					<th>Username</th>
				</tr>
			</thead>
			<tbody>
				<?php
				if(isset($user_list) && count($user_list)>0){
					$i = 0;
					foreach ($user_list as $key => $user) {
						$i++;
					?>
						<tr>
							<td><?= $i; ?></td>
							<td align="center">
								<img src="<?= base_url().$user['profile_image']; ?>" height="80" width="80" />
							</td>
							<td><?= $user['first_name'].' '.$user['last_name']; ?></td>
							<td><?= $user['email']; ?></td>
							<td><?= $user['username']; ?></td>
						</tr>					
					<?php
					}
				}
				else{
					?>
					<tr>
						
					</tr>
					<?php
				}
				?>
			</tbody>
		</table>
	</div>
</body>
</html>