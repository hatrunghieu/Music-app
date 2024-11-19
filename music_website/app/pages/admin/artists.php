<?php 


	if($action == 'add')
	{

		if($_SERVER['REQUEST_METHOD'] == "POST")
		{

			$errors = [];

			//data validation
			if(empty($_POST['name']))
			{
				$errors['name'] = "a name is required";
			}else
			if(!preg_match("/^[a-zA-Z \&\-]+$/", $_POST['name'])){
				$errors['name'] = "a name can only have letters and space";
			}

            // image validation
            if (!empty($_FILES['image']['name'])) {
                
                $folder = "upload/";
                if (!file_exists($folder)) {
                    mkdir($folder, 0777, true);
                    file_put_contents($folder."index.php", "");
                }

                if ($_FILES['image']['error'] == 0 && in_array($_FILES['image']['type'], ['image/jpeg', 'image/png'])) {
                    
                    $destination = $folder.$_FILES['image']['name'];
                    move_uploaded_file($_FILES['image']['tmp_name'], $destination);

                } else{
                    $errors['name'] = "Image not valid * note that jpeg & png allowed.";
                }
                

            } else{
                $errors['name'] = "a image is required";
            }


			if(empty($errors))
			{

				$values = [];
				$values['name'] = trim($_POST['name']);
				$values['bio'] = trim($_POST['bio']);
				$values['image'] 	= $destination;
				$values['user_id'] 	= user('id');



				$query = "insert into artists (name,image, user_id, bio) values (:name,:image,:user_id, :bio)";
				db_query($query,$values);

				message("artists created successfully");
				redirect('admin/artists');
			}
		}
	}else
	if($action == 'edit')
	{

		$query = "select * from artists where id = :id limit 1";
  		$row = db_query_one($query,['id'=>$id]);

		if($_SERVER['REQUEST_METHOD'] == "POST" && $row)
		{

			$errors = [];

			//data validation
			if(empty($_POST['name']))
			{
				$errors['name'] = "a name is required";
			}else
			if(!preg_match("/^[a-zA-Z \&\-]+$/", $_POST['name'])){
				$errors['name'] = "a name can only have letters and space";
			}

            if (!empty($_FILES['image']['name'])) {
                
                $folder = "upload/";
                if (!file_exists($folder)) {
                    mkdir($folder, 0777, true);
                    file_put_contents($folder."index.php", "");
                }

                if ($_FILES['image']['error'] == 0 && in_array($_FILES['image']['type'], ['image/jpeg', 'image/png'])) {
                    
                    $destination = $folder.$_FILES['image']['name'];
                    move_uploaded_file($_FILES['image']['tmp_name'], $destination);

                    //delete the old file
                    if(file_exists($row['image'])){
                        unlink($row['image']);
                    }


                } else{
                    $errors['name'] = "Image not valid * note that jpeg & png allowed.";
                }
                

            }

			if(empty($errors))
			{

				$values = [];
				$values['name'] = trim($_POST['name']);
				$values['bio'] = trim($_POST['bio']);
				$values['user_id'] 	= user('id');
				$values['id'] 		= $id;

                $query = "update artists set name = :name,bio = :bio, user_id = :user_id where id = :id limit 1";

                // checking image exist ornot
                if(!empty($destination)){
                    $query = "update artists set name = :name, bio = :bio, user_id = :user_id , image = :image where id = :id limit 1";
                    $values['image'] = $destination;
                }

				
				db_query($query,$values);

				message("artists edited successfully");
                redirect('admin/artists');
			}
		}
	}else
	if($action == 'delete')
	{

		$query = "select * from artists where id = :id limit 1";
  		$row = db_query_one($query,['id'=>$id]);

		if($_SERVER['REQUEST_METHOD'] == "POST" && $row)
		{

			$errors = [];

			if(empty($errors))
			{

				$values = [];
				$values['id'] 		= $id;

				$query = "delete from artists where id = :id limit 1";
				db_query($query,$values);

                //delete the old file
                if (file_exists($row['image'])) {
                    unlink($row['image']);
                }

				message("artists deleted successfully");
				redirect('admin/artists');
			}
		}
	}
	

?>

<?php require page('includes/admin-header')?>

	<section class="admin-content" style="min-height: 200px;">
  
  		<?php if($action == 'add'):?>
  			
  			<div style="max-width: 500px;margin: auto;">
	  			<form method="post" enctype="multipart/form-data">
	  				<h3>Add New Artist Name</h3>

	  				<input class="form-control my-1" value="<?=set_value('name')?>" type="text" name="name" placeholder="name">
	  				<?php if(!empty($errors['name'])):?>
	  					<small class="error"><?=$errors['name']?></small>
	  				<?php endif;?>

                    <input class="form-control my-1" type="file" name="image">

	  				<?php if(!empty($errors['image'])):?>
	  					<small class="error"><?=$errors['image']?></small>
	  				<?php endif;?>
	  				
	  				<button class="btn bg-orange">Save</button>
	  				<a href="<?=ROOT?>/admin/artists">
	  					<button type="button" class="float-end btn">Back</button>
	  				</a>
	  			</form>
	  		</div>

  		<?php elseif($action == 'edit'):?>
 
  			<div style="max-width: 500px;margin: auto;">
	  			<form method="post" enctype="multipart/form-data">
	  				<h3>Edit Artist</h3>

	  				<?php if(!empty($row)):?>

	  				<input class="form-control my-1" value="<?=set_value('name',$row['name'])?>" type="text" name="name" placeholder="name">
	  				<?php if(!empty($errors['name'])):?>
	  					<small class="error"><?=$errors['name']?></small>
	  				<?php endif;?>

                    <img src="<?=ROOT?>/<?=$row['image']?>" alt="" style="width: 200px; height: 200px; object-fit: cover;">
                    
                    <input class="form-control my-1" type="file" name="image">

					<label for="">Artist Bio: </label>
					<textarea name="bio" class="form-control my-1" rows="10"><?= set_value('bio', $row['bio'])?></textarea>
	  				
	  				<button class="btn bg-orange">Save</button>
	  				<a href="<?=ROOT?>/admin/artists">
	  					<button type="button" class="float-end btn">Back</button>
	  				</a>

	  				<?php else:?>
	  					<div class="alert">That record was not found</div>
	  					<a href="<?=ROOT?>/admin/artists">
		  					<button type="button" class="float-end btn">Back</button>
		  				</a>
	  				<?php endif;?>

	  			</form>
	  		</div>

  		<?php elseif($action == 'delete'):?>

  			<div style="max-width: 500px;margin: auto;">
	  			<form method="post">
	  				<h3>Delete Artist</h3>

	  				<?php if(!empty($row)):?>

	  				<div class="form-control my-1" ><?=set_value('name',$row['name'])?></div>
	  				<?php if(!empty($errors['name'])):?>
	  					<small class="error"><?=$errors['name']?></small>
	  				<?php endif;?>
	  		 
	  				<button class="btn bg-red">Delete</button>
	  				<a href="<?=ROOT?>/admin/artists">
	  					<button type="button" class="float-end btn">Back</button>
	  				</a>

	  				<?php else:?>
	  					<div class="alert">That record was not found</div>
	  					<a href="<?=ROOT?>/admin/artists">
		  					<button type="button" class="float-end btn">Back</button>
		  				</a>
	  				<?php endif;?>

	  			</form>
	  		</div>

  		<?php else:?>

  			<?php 
  				$query = "select * from artists order by id desc limit 20";
  				$rows = db_query($query);

  			?>
  			<h3>Artists 
  				<a href="<?=ROOT?>/admin/artists/add">
  					<button class="float-end btn bg-purple">Add New</button>
  				</a>
  			</h3>

  			<table class="table">
  				
  				<tr>
  					<th>ID</th>
  					<th>Artist</th>
  					<th>Image</th>
                    <th>Action</th>
  				</tr>

  				<?php if(!empty($rows)):?>
	  				<?php foreach($rows as $row):?>
		  				<tr>
		  					<td><?=$row['id']?></td>
		  					<td><?=$row['name']?></td>
                            <td>
								<a href="<?=ROOT?>/artist/<?=$row['id']?>">
		  							<img src="<?=ROOT?>/<?=$row['image']?>" style="width:100px;height: 100px;object-fit: cover;">
		  						</a>
                            </td>
		  					<td>
		  						<a href="<?=ROOT?>/admin/artists/edit/<?=$row['id']?>">
		  							<img class="bi" src="<?=ROOT?>/assets/icons/pencil-square.svg">
		  						</a>
		  						<a href="<?=ROOT?>/admin/artists/delete/<?=$row['id']?>">
		  							<img class="bi" src="<?=ROOT?>/assets/icons/trash3.svg">
		  						</a>
		  					</td>
		  				</tr>
	  				<?php endforeach;?>
  				<?php endif;?>

  			</table>
  		<?php endif;?>

	</section>

<?php require page('includes/admin-footer')?>