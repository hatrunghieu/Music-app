<?php

if($_SERVER['REQUEST_METHOD'] == "POST")
{

    $errors = [];
    $values = [];

    $values['email'] = trim($_POST['email']);
    $query = "select * from users where email = :email limit 1";
    
    $rows = db_query_one($query, $values);


    if(!empty($rows))
    {

        if (password_verify($_POST['password'], $rows['password'])) {
            
            authenticcate($rows);
            message("Login successful");
            redirect('admin');

        }



    }

    message("Wrong email or password!");
}

?>

<?php	require page('includes/header') ?>
    <section class="content">
	
		<div class="login-holder">
			<?php if (message()):?>

				<div class= "alert"><?=message('', true)?></div>

			<?php endif;?>

        <form action="" method="POST">
            <h2>Login</h2>
            <center> <img src="assets/images/logo.jpg" alt="" style="width: 150px; border-radius: 50%; border: 1px solid black"></center>
            <input value="<?=set_value('email')?>" class="my-1 form-control" type="email" name="email" placeholder="Email">
			<input value="<?=set_value('password')?>" class="my-1 form-control" type="password" name="password" placeholder="Password">
            <button class="my-1 btn bg-blue">Login</button>
        </form>
    </section>

<?php require page('includes/footer') ?>