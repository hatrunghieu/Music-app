<?php

	if (!admin_is()) {
		
		message("Just admin can access the admin page!");
		redirect("login");
	}

	$session	 = $URL[1] ?? "dashboard";
	$action		 = $URL[2] ?? null;
	$id 		 = $URL[3] ?? null;
	

	switch ($session) {
		case 'dashboard':
			require page('admin/dashboard');
			break;
		case 'users':
			require page('admin/users');
			break;
		case 'categories':
			require page('admin/categories');
			break;
		
		case 'artists':
			require page('admin/artists');
			break;
		
		case 'songs':
			require page('admin/songs');
			break;
		
		default:
			require page("admin/404");
			break;
	}
?>


