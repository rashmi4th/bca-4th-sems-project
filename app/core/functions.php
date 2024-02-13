<?php 

function query(string $query, array $data =[]){
    $string ="mysql:hostname=".DBHOST.";dbname=". DBNAME;
    $con=new PDO($string, DBUSER, DBPASS); 

    $stm =$con->prepare($query);
    $stm->execute($data);

    $result = $stm->fetchAll(PDO::FETCH_ASSOC);
    if(is_array(($result) && !empty($result))){
        return $result;
    }
    
    return false;
}
function query_3($query, $params = []) {
    try {
        $connection = new PDO("mysql:host=".DBHOST.";dbname=".DBNAME, DBUSER, DBPASS);
        $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $statement = $connection->prepare($query);
        $statement->execute($params);

        return $statement->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        // Handle the exception (e.g., log the error)
        echo "Error: " . $e->getMessage();
        return false;
    } finally {
        $connection = null; // Close the connection
    }
}

function query_row(string $query, array $data = [])
{

	$string = "mysql:hostname=".DBHOST.";dbname=". DBNAME;
	$con = new PDO($string, DBUSER, DBPASS);

	$stm = $con->prepare($query);
	$stm->execute($data);

	$result = $stm->fetchAll(PDO::FETCH_ASSOC);
	if(is_array($result) && !empty($result))
	{
		return $result[0];
	}

	return false;

}


// Define a function to execute a query and fetch rows
function query_2($query) {
    $connection = mysqli_connect('localhost', 'root', '', 'news2');

    $result = mysqli_query($connection, $query);
    if (!$result) {
        die("Query failed: " . mysqli_error($connection));
    }

    $rows = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $rows[] = $row;
    }

    mysqli_free_result($result);
    mysqli_close($connection);

    return $rows;
}
function query_2_row($query, $data = [])
{
    $string = "mysql:host=" . DBHOST . ";dbname=" . DBNAME;
    $con = new PDO($string, DBUSER, DBPASS);

    $stm = $con->prepare($query);
    $stm->execute($data);

    $rows = $stm->fetchAll(PDO::FETCH_ASSOC);

    return $rows;
}

function get_image($file){
    $file = $file ?? '';
    if (file_exists($file))
    {
        return ROOT.'/'.$file;
    }

    return ROOT.'/images/select_img.png';
}

function redirect($page){
    header('Location: '.ROOT. '/' .$page);
    die;
}
//so that the values wont disapper when form value is wrong
function old_value($key, $default = ''){
    if(!empty($_POST[$key])){

        return $_POST[$key];
    }
    //not empty return it
    //empty return it
    return $default;
}

function old_select($key, $value, $default = '')
{
	if(!empty($_POST[$key]) && $_POST[$key] == $value)
		return " selected ";
	
	if($default == $value)
		return " selected ";
	
	return "";
}

create_tables();
function create_tables(){
    $string ="mysql:hostname=".DBHOST.";";
    $con=new PDO($string, DBUSER, DBPASS);

    $query = "create database if not exists ". DBNAME;
    $stm =$con->prepare($query);
    $stm->execute();

    $query = "use ". DBNAME;
    $stm =$con->prepare($query);
    $stm->execute();

    // user tables 
    $query = "create table if not exists users(
        id int primary key auto_increment,
        username varchar(30) not null,
        email varchar(50) not null,
        password varchar(1000) not null,
        image varchar(1024) null,
        user_date datetime default current_timestamp,
        role varchar(10) not null,

        key email (email),
        key username (username)
    )";
    $stm =$con->prepare($query);
    $stm->execute();


    // category tables
    $query = "create table if not exists categories(
        id int primary key auto_increment,
        category varchar(30) not null,
        slug varchar(100) not null,
        disabled tinyint default 0,

        key slug (slug),
        key category (category)
    )";
    $stm =$con->prepare($query);
    $stm->execute();

    // post table 
    $query = "create table if not exists posts(
        id int primary key auto_increment,
        user_id int,
        category_id int,
        title varchar(50) not null,
        content text null,
        image varchar(1024) null,
        post_date datetime default current_timestamp,
        slug varchar(100) not null,

        key user_id (user_id),
        key category_id (category_id),
        key title (title),
        key slug (slug),
        key post_date (post_date)

    )";
    $stm =$con->prepare($query);
    $stm->execute();

}

//authentication 

function authenticate($row){
    $_SESSION['USER'] = $row;
}


function user($key = ''){
    if(empty($key))
        return $_SESSION['USER'];

        if(!empty($_SESSION['USER'][$key]))
        return $_SESSION['USER'][$key];

        return'';
}


function logged_in(){
   if (!empty ($_SESSION['USER']))
        return true;
    
    return false;
}

//creates a slug
function str_to_url($url)
{

   $url = str_replace("'", "", $url);
   $url = preg_replace('~[^\\pL0-9_]+~u', '-', $url);
   $url = trim($url, "-");
   $url = iconv("utf-8", "us-ascii//TRANSLIT", $url);
   $url = strtolower($url);
   $url = preg_replace('~[^-a-z0-9_]+~', '', $url);
   
   return $url;
}

function resize_image($filename, $max_size = 1000)
{
	
	if(file_exists($filename))
	{
		$type = mime_content_type($filename);
		switch ($type) {
			case 'image/jpeg':
				$image = imagecreatefromjpeg($filename);
				break;
			case 'image/png':
				$image = imagecreatefrompng($filename);
				break;
			case 'image/gif':
				$image = imagecreatefromgif($filename);
				break;
			case 'image/webp':
				$image = imagecreatefromwebp($filename);
				break;
			default:
				return;
		}

		$src_width 	= imagesx($image);
		$src_height = imagesy($image);

		if($src_width > $src_height)
		{
			if($src_width < $max_size)
			{
				$max_size = $src_width;
			}

			$dst_width 	= $max_size;
			$dst_height = ($src_height / $src_width) * $max_size;
		}else{
			
			if($src_height < $max_size)
			{
				$max_size = $src_height;
			}

			$dst_height = $max_size;
			$dst_width 	= ($src_width / $src_height) * $max_size;
		}

		$dst_height = round($dst_height);
		$dst_width 	= round($dst_width);

		$dst_image = imagecreatetruecolor($dst_width, $dst_height);
		imagecopyresampled($dst_image, $image, 0, 0, 0, 0, $dst_width, $dst_height, $src_width, $src_height);
		
		switch ($type) {
			case 'image/jpeg':
				imagejpeg($dst_image, $filename, 90);
				break;
			case 'image/png':
				imagepng($dst_image, $filename, 90);
				break;
			case 'image/webp':
				imagewebp($dst_image, $filename, 90);
				break;

		}

	}
}

function get_category_name($category_id) {
    $query = "SELECT category FROM categories WHERE id = :category_id";
    $category = query($query, ['category_id' => $category_id]);

    if ($category) {
        return $category['category'];
    }

    return '';
}
