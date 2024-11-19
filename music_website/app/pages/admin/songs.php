<?php 


	if($action == 'add')
	{

		if($_SERVER['REQUEST_METHOD'] == "POST")
		{

			$errors = [];

			//data validation
			if(empty($_POST['title']))
			{
				$errors['title'] = "a title is required";
			}else
			if(!preg_match("/^[a-zA-Z0-9 \&\-]+$/", $_POST['title'])){
				$errors['title'] = "a name can only have letters and space";
			}

			if(empty($_POST['category_id']))
			{
				$errors['category_id'] = "A Category is required";
			}

			if(empty($_POST['artist_id']))
			{
				$errors['artist_id'] = "An artist is required";
			}
			

            // image validation
            if (!empty($_FILES['image']['name'])) {
                
                $folder = "upload/";
                if (!file_exists($folder)) {
                    mkdir($folder, 0777, true);
                    file_put_contents($folder."index.php", "");
                }

                if ($_FILES['image']['error'] == 0 && in_array($_FILES['image']['type'], ['image/jpeg', 'image/png'])) {
                    
                    $destination_image = $folder.$_FILES['image']['name'];
                    move_uploaded_file($_FILES['image']['tmp_name'], $destination_image);

                } else{
                    $errors['image'] = "Image not valid * note that jpeg & png allowed.";
                }
                

            } else{
                $errors['image'] = "a image is required";
            }

			// files validation 

			if (!empty($_FILES['file']['name'])) {
                
                $folder = "upload/";
                if (!file_exists($folder)) {
                    mkdir($folder, 0777, true);
                    file_put_contents($folder."index.php", "");
                }

                if ($_FILES['file']['error'] == 0 && in_array($_FILES['file']['type'], ['audio/mpeg'])) {
                    
                    $destination_aufile = $folder.$_FILES['file']['name'];
                    move_uploaded_file($_FILES['file']['tmp_name'], $destination_aufile);

                } else{
                    $errors['file'] = "File not valid * note that audio and mepg allowed.";
                }
                

            } else{
                $errors['file'] = "An audido file is required";
            }


			if(empty($errors))
			{

				$values = [];
				$values['title'] = trim($_POST['title']);
				$values['category_id'] = trim($_POST['category_id']);
				$values['artist_id'] = trim($_POST['artist_id']);
				$values['image'] 	= $destination_image;
				$values['file'] 	= $destination_aufile;
				$values['user_id'] 	= user('id');
				$values['date'] 	= date("Y-m-d H:i:s");
				$values['views'] 	= 0;
				$values['slug'] 	= str_to_url($values['title']);


				$query = "insert into songs (title,image,file, user_id, category_id, artist_id, date, views, slug) values (:title,:image,:file,:user_id,:category_id,:artist_id,:date, :views, :slug)";
				db_query($query,$values);

				message("songs created successfully");
				redirect('admin/songs');
			}
		}
	}else
	if($action == 'edit')
	{

		$query = "select * from songs where id = :id limit 1";
  		$row = db_query_one($query,['id'=>$id]);

		if($_SERVER['REQUEST_METHOD'] == "POST" && $row)
		{

			$errors = [];

			//data validation
			if(empty($_POST['title']))
			{
				$errors['title'] = "a title is required";
			}else
			if(!preg_match("/^[a-zA-Z0-9 \.\&\-]+$/", $_POST['title'])){
				$errors['title'] = "a title can only have letters & spaces";
			}

			if(empty($_POST['category_id']))
			{
				$errors['category_id'] = "a category is required";
			}

			if(empty($_POST['artist_id']))
			{
				$errors['artist_id'] = "an artist is required";
			}

 			//image
			if(!empty($_FILES['image']['name']))
			{

				$folder = "uploads/";
				if(!file_exists($folder))
				{
					mkdir($folder,0777,true);
					file_put_contents($folder."index.php", "");
				}

				$allowed = ['image/jpeg','image/png'];
				if($_FILES['image']['error'] == 0 && in_array($_FILES['image']['type'], $allowed))
				{
					
					$destination_image = $folder. $_FILES['image']['name'];

					move_uploaded_file($_FILES['image']['tmp_name'], $destination_image);
					
					//delete old file
					if(file_exists($row['image']))
					{
						unlink($row['image']);
					}

				}else{
					$errors['name'] = "image no valid. allowed types are ". implode(",", $allowed);
				}

			}

			if(!empty($_FILES['file']['name']))
			{

				$folder = "uploads/";
				if(!file_exists($folder))
				{
					mkdir($folder,0777,true);
					file_put_contents($folder."index.php", "");
				}

				$allowed = ['audio/mpeg'];
				if($_FILES['file']['error'] == 0 && in_array($_FILES['file']['type'], $allowed))
				{
					
					$destination_file = $folder. $_FILES['file']['name'];

					move_uploaded_file($_FILES['file']['tmp_name'], $destination_file);
					
					//delete old file
					if(file_exists($row['file']))
					{
						unlink($row['file']);
					}

				}else{
					$errors['name'] = "file not valid. allowed types are ". implode(",", $allowed);
				}

			}

			if(empty($errors))
			{

				$values = [];
				$values['title'] 	= trim($_POST['title']);
				$values['category_id'] 	= trim($_POST['category_id']);
				$values['artist_id'] 	= trim($_POST['artist_id']);
				$values['user_id'] 	= user('id');
				$values['id'] 		= $id;

				$query = "update songs set title = :title,user_id =:user_id,category_id =:category_id,artist_id =:artist_id";
				
				if(!empty($destination_image)){
					$query .= ", image = :image";
					$values['image'] 	= $destination_image;
				}

				if(!empty($destination_file)){
					$query .= ", file = :file";
					$values['file'] 	= $destination_file;
				}

				$query .= " where id = :id limit 1";

				db_query($query,$values);

				message("song edited successfully");
				redirect('admin/songs');
			}
		}
	}else
	if($action == 'delete')
	{

		$query = "select * from songs where id = :id limit 1";
  		$row = db_query_one($query,['id'=>$id]);

		if($_SERVER['REQUEST_METHOD'] == "POST" && $row)
		{

			$errors = [];

			if(empty($errors))
			{

				$values = [];
				$values['id'] 		= $id;

				$query = "delete from songs where id = :id limit 1";
				db_query($query,$values);

                //delete the old file
                if (file_exists($row['image'])) {
                    unlink($row['image']);
                }

				//delete the audio file
				if (file_exists($row['file'])) {
					unlink($row['file']);
				}


				message("songs deleted successfully");
				redirect('admin/songs');
			}
		}
	}
	

?>

<?php require page('includes/admin-header')?>

	<section class="admin-content" style="min-height: 200px;">
  
  		<?php if($action == 'add'):?>
  			
  			<div style="max-width: 500px;margin: auto;">
	  			<form method="post" enctype="multipart/form-data">
	  				<h3>Add New Song</h3>

	  				<input class="form-control my-1" value="<?=set_value('title')?>" type="text" name="title" placeholder="Song title">
	  				<?php if(!empty($errors['title'])):?>
	  					<small class="error"><?=$errors['title']?></small>
	  				<?php endif;?>


					<?php
						$query = "select * from categories order by category asc";
						$categories = db_query($query);
					?>
					<!-- Choosing Category-->
					<select name="category_id" class="form-control my-1">
	  					<option value="">--Select Category--</option>

						<?php if(!empty($categories)):?>
							<?php foreach($categories as $cat):?>
								<option <?=set_select('category_id',$cat['id'])?> value="<?=$cat['id']?>"><?=$cat['category']?></option>
							<?php endforeach;?>
						<?php endif;?>
	  				</select>
	  				<?php if(!empty($errors['category_id'])):?>
	  					<small class="error"><?=$errors['category_id']?></small>
	  				<?php endif;?>

					<?php
						$query = "select * from artists order by name asc";
						$categories = db_query($query);
					?>
					<!-- Choosing Artist -->
					<select name="artist_id" class="form-control my-1">
	  					<option value="">--Select Artist--</option>
						  <?php if(!empty($categories)):?>
							<?php foreach($categories as $ar):?>
								<option <?=set_select('artist_id',$ar['id'])?> value="<?=$ar['id']?>"><?=$ar['name']?></option>
							<?php endforeach;?>
						<?php endif;?>
	  				</select>
	  				<?php if(!empty($errors['artist_id'])):?>
	  					<small class="error"><?=$errors['artist_id']?></small>
	  				<?php endif;?>

					<div class="form-control my-1">
						<div><label for="">Image: </label></div>
						<input class="form-control my-1" type="file" name="image">

						<?php if(!empty($errors['image'])):?>
	  						<small class="error"><?=$errors['image']?></small>
	  					<?php endif;?>
					</div>

					<div class="form-control my-1">
						<div><label for="">Audio file: </label></div>
						<input class="form-control my-1" type="file" name="file">
					
						<?php if(!empty($errors['file'])):?>
	  						<small class="error"><?=$errors['file']?></small>
	  					<?php endif;?>
					</div>
	  				
	  				<button class="btn bg-orange">Save</button>
	  				<a href="<?=ROOT?>/admin/songs">
	  					<button type="button" class="float-end btn">Back</button>
	  				</a>
	  			</form>
	  		</div>

  		<?php elseif($action == 'edit'):?>
 
  			<div style="max-width: 500px;margin: auto;">
	  			<form method="post" enctype="multipart/form-data">
	  				<h3>Edit Song</h3>

	  				<?php if(!empty($row)):?>

						<input class="form-control my-1" value="<?=set_value('title', $row['title'])?>" type="text" name="title" placeholder="Song title">
						<?php if(!empty($errors['title'])):?>
							<small class="error"><?=$errors['title']?></small>
						<?php endif;?>


						<?php
							$query = "select * from categories order by category asc";
							$categories = db_query($query);
						?>
						<!-- Choosing Category-->
						<select name="category_id" class="form-control my-1">
							<option value="">--Select Category--</option>

							<?php if(!empty($categories)):?>
								<?php foreach($categories as $cat):?>
									<option <?=set_select('category_id',$cat['id'], $row['category_id'])?> value="<?=$cat['id']?>"><?=$cat['category']?></option>
								<?php endforeach;?>
							<?php endif;?>
						</select>
						<?php if(!empty($errors['category_id'])):?>
							<small class="error"><?=$errors['category_id']?></small>
						<?php endif;?>

						<?php
							$query = "select * from artists order by name asc";
							$categories = db_query($query);
						?>
						<!-- Choosing Artist -->
						<select name="artist_id" class="form-control my-1">
							<option value="">--Select Artist--</option>
							<?php if(!empty($categories)):?>
								<?php foreach($categories as $ar):?>
									<option <?=set_select('artist_id',$ar['id'], $row['artist_id'])?> value="<?=$ar['id']?>"><?=$ar['name']?></option>
								<?php endforeach;?>
							<?php endif;?>
						</select>
						<?php if(!empty($errors['artist_id'])):?>
							<small class="error"><?=$errors['artist_id']?></small>
						<?php endif;?>

						<div class="form-control my-1">
							<div><label for="">Image: </label></div>

							<img src="<?=ROOT?>/<?=$row['image']?>" alt="" style="width: 100px; height: 100px; object-fit: cover; border-radius: 30px;">
							<input class="form-control my-1" type="file" name="image">

							<?php if(!empty($errors['image'])):?>
								<small class="error"><?=$errors['image']?></small>
							<?php endif;?>
						</div>

						<div class="form-control my-1">
							<div><label for="">Audio file: </label></div>
							<div>
								<?=$row['file']?>
							</div>
							<input class="form-control my-1" type="file" name="file">
						
							<?php if(!empty($errors['file'])):?>
								<small class="error"><?=$errors['file']?></small>
							<?php endif;?>
						</div>
	  				
	  				<button class="btn bg-orange">Save</button>
	  				<a href="<?=ROOT?>/admin/songs">
	  					<button type="button" class="float-end btn">Back</button>
	  				</a>

	  				<?php else:?>
	  					<div class="alert">That record was not found</div>
	  					<a href="<?=ROOT?>/admin/songs">
		  					<button type="button" class="float-end btn">Back</button>
		  				</a>
	  				<?php endif;?>

	  			</form>
	  		</div>

  		<?php elseif($action == 'delete'):?>

  			<div style="max-width: 500px;margin: auto;">
	  			<form method="post">
	  				<h3>Delete Song</h3>

	  				<?php if(!empty($row)):?>

	  				<div class="form-control my-1" ><?=set_value('title',$row['title'])?></div>
	  				<?php if(!empty($errors['title'])):?>
	  					<small class="error"><?=$errors['title']?></small>
	  				<?php endif;?>
	  		 
	  				<button class="btn bg-red">Delete</button>
	  				<a href="<?=ROOT?>/admin/songs">
	  					<button type="button" class="float-end btn">Back</button>
	  				</a>

	  				<?php else:?>
	  					<div class="alert">That record was not found</div>
	  					<a href="<?=ROOT?>/admin/songs">
		  					<button type="button" class="float-end btn">Back</button>
		  				</a>
	  				<?php endif;?>

	  			</form>
	  		</div>

  		<?php else:?>

  			<?php 
  				$query = "select * from songs order by id desc limit 20";
  				$rows = db_query($query);

  			?>
  			<h3>Songs Lists
  				<a href="<?=ROOT?>/admin/songs/add">
  					<button class="float-end btn bg-purple">Add New</button>
  				</a>
  			</h3>

  			<table class="table">
  				
  				<tr>
  					<th>ID</th>
  					<th>Tittle</th>
  					<th>Image</th>
  					<th>Category</th>
  					<th>Artist</th>
  					<th>Audio</th>
                    <th>Action</th>
  				</tr>

  				<?php if(!empty($rows)):?>
	  				<?php foreach($rows as $row):?>
		  				<tr>
		  					<td><?=$row['id']?></td>
		  					<td><?=$row['title']?></td>
                            <td>
                                <img src="<?=ROOT?>/<?=$row['image']?>" alt="" style="width: 100px; height: 100px; object-fit: cover; border-radius: 30px;">
                            </td>
							<td><?=getCategory($row['category_id'])?></td>
							<td><?=getArtists($row['artist_id'])?></td>
							<td>
								<audio controls>
									<source src="<?=ROOT?>/<?=$row['file']?>" type="audio/mpeg">
								</audio>
                            </td>
		  					<td>
		  						<a href="<?=ROOT?>/admin/songs/edit/<?=$row['id']?>">
		  							<img class="bi" src="<?=ROOT?>/assets/icons/pencil-square.svg">
		  						</a>
		  						<a href="<?=ROOT?>/admin/songs/delete/<?=$row['id']?>">
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