<?php

function show($stuff){
    echo "<pre>";
    print_r($stuff);
    echo "</pre>";
}

function page($file){
    return "../app/pages/".$file.".php";
}


function db_connect(){
    $string = DBDRIVER.":hostname=".DBHOST.";dbname=".DBNAME;
    $con = new PDO($string, DBUSER, DBPASS);

    return $con;
}

function db_query($query, $data = array())
{
	$con = db_connect();

	$stm = $con->prepare($query);
	if($stm)
	{
		$check = $stm->execute($data);
		if($check){
			$result = $stm->fetchAll(PDO::FETCH_ASSOC);

			if(is_array($result) && count($result) > 0)
			{
				return $result;
			}
		}
	}
	return false;
}


function db_query_one($query, $data = array()){
    
    $con = db_connect();
    
    $stm = $con-> prepare($query);
    if ($stm) {
        $check = $stm->execute($data);
        if ($check) {
            $result = $stm->fetchAll((PDO::FETCH_ASSOC));
            if(is_array($result) && count($result) > 0){
                return $result[0];
            }
        }
    }

    return false;
}

function message($message = '', $clear = false)
{
	if(!empty($message)){
		$_SESSION['message'] = $message;
	}else{

		if(!empty($_SESSION['message'])){

			$msg = $_SESSION['message'];
			if($clear){
				unset($_SESSION['message']);
			}
			return $msg;
		}

	}
	return false;
}

function redirect($page){
    header("Location: ".ROOT."/".$page);
    die;
}


function set_value($key, $default = ""){

	if(!empty($_POST[$key]))
	{
		return $_POST[$key];
	}else{

		return $default;
	}

	return '';
}

function set_select($key, $value, $default = ""){
	
    if(!empty($_POST[$key]))
	{
		if($_POST[$key] == $value){
			return " selected ";
		}
	}else{
		if($default == $value){
			return " selected ";
		}
	}

	return '';
}

function get_date($date){
    return date("jS M, Y", strtotime($date));
}

function loggined (){
    if (!empty($_SESSION["USER"]) && is_array($_SESSION["USER"])) {
        return true;
    }

    return false;
}

function admin_is (){
    
    if (!empty($_SESSION['USER']['role']) && $_SESSION["USER"]['role'] == 'admin') {
        return true;
    }

    return false;
}


function user ($column){
    if (!empty($_SESSION["USER"][$column])) {
        return $_SESSION["USER"][$column];
    }

    return "new guys";
}

function authenticcate($row){
    $_SESSION["USER"] = $row;   
}

function str_to_url($link){

	$link = str_replace("'", "", $link);
	$link = preg_replace('~[^\\pL0-9_]+~u', '-', $link);
	$link = trim($link, "-");
	$link = iconv("utf-8", "us-ascii//TRANSLIT", $link);
	$link = strtolower($link);
	$link = preg_replace('~[^-a-z0-9_]+~', '', $link);

	return $link;
}


function getCategory($id){

	$query = "select category from categories where id = :id limit 1";
	$row = db_query_one($query, ['id'=>$id]);

	if (!empty($row['category'])) {
		return $row['category'];
	}

	return "None";
}

function getArtists($id){

	$query = "select name from artists where id = :id limit 1";
	$row = db_query_one($query, ['id'=>$id]);

	if (!empty($row['name'])) {
		return $row['name'];
	}

	return "None";
}

function esc($str){
	return nl2br(htmlspecialchars($str)); 
}