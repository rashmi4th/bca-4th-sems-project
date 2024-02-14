<?php
// Add user
if ($action == 'add') {
    if (!empty($_POST)) {
        // Validation 
        $errors = [];

        // Username validation
        if (empty($_POST['title'])) {
            $errors['title'] = "A title is required";
        }


        if (empty($_POST['category_id'])) {
            $errors['category_id'] = "A category is required";
        }

        $data = [];
        $imageUpdated = false;

        // Image upload handling
        if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
            $uploadDir = 'uploads/';
            $filename = $_FILES['image']['name'];
            $destination = $uploadDir . $filename;

            if (move_uploaded_file($_FILES['image']['tmp_name'], $destination)) {
                // Image upload successful, add $destination to the $data array
                $data['image'] = $destination;
                $imageUpdated = true;
            } else {
                // Image upload failed, handle the error (e.g., display an error message to the user)
                $errors['image'] = "Error uploading the image";
            }
        } else {
            $errors['image'] = "An image is required";
        }

        $slug = str_to_url($_POST['title']);
        $query = "select id from posts where slug = :slug limit 1";
        $slug_row = query($query, ['slug' => $slug]);


        if ($slug) {
            $slug .= rand(1000, 9999);
        }


        if (empty($errors)) {
            // Save to database
            $data['title'] = $_POST['title'];
            $data['content'] = $_POST['content'];
            $data['category_id'] = $_POST['category_id'];
            $data['slug'] = $slug;
            $data['user_id'] = user('id');


            // Add the :image placeholder even if no image is uploaded
            if (!$imageUpdated) {
                $data['image'] = null; // or $data['image'] = '';
            }
            $query = "insert into posts (title,content,slug,category_id,user_id,image) values (:title,:content,:slug,:category_id,:user_id,:image)";
            query($query, $data);

            redirect('admin/posts');
        }
    }
}

//edit  user 
else
if ($action == 'edit') {
    $query = "select * from posts where id =:id limit 1";
    $row = query_2_row($query, ['id' => $id]);
    if (!empty($_POST)) {
        if ($row) {
            $errors = [];
        
            if (empty($_POST['title'])) {
                $errors['title'] = "A title is required";
            } 
     
            if (empty($_POST['category_id'])) {
         
                $errors['category_id'] = "A category is required";
            } 
      
        }
    
        $data = [];
        $data['id'] = $id;
        $imageUpdated = false;

        if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
            $uploadDir = 'uploads/';
            $filename = $_FILES['image']['name'];
            $destination = $uploadDir . $filename;

            if (move_uploaded_file($_FILES['image']['tmp_name'], $destination)) {
                // Image upload successful, add $destination to the $data array
                $data['image'] = $destination;
                $imageUpdated = true;
            } else {
                // Image upload failed, handle the error (e.g., display an error message to the user)
                $errors['image'] = "Error uploading the image";
            }
        }

        if (empty($errors)) {
            // Save to database
            $data['title'] = $_POST['title'];
            $data['category_id'] = $_POST['category_id'];
            $data['id'] = $id;
            $data['content'] = $_POST['content'];

            $query = "UPDATE posts SET title = :title, content = :content, category_id = :category_id";

            if ($imageUpdated) {
                $query .= ", image = :image";
            }

            if (!empty($_POST['password'])) {
                // If a new password is provided, update the password in the database
                $data['password'] = $_POST['password'];
                $query .= ", password = :password";
            }

            $query .= " WHERE id = :id LIMIT 1";

            query($query, $data);
            redirect('admin/posts');
        }
    }
} else
if ($action == 'delete') {
    $query = "select * from posts where id =:id limit 1";
    $row = query_2_row($query, ['id' => $id]);
    if (!empty($_SERVER['REQUEST_METHOD'] == "POST")) {
        if ($row) {
            $errors = [];
            if (empty($errors)) {
                //delete from database
                $data = [];
                $data['id'] = $id;
                $query = "delete from posts where id = :id limit 1";

                query($query, $data);
                redirect('admin/posts');
            }
        }
    }
}
