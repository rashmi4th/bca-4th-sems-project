<?php
// Add user
if ($action == 'add') {
    if (!empty($_POST)) {
        // Validation 
        $errors = [];

        // Username validation
        if (empty($_POST['username'])) {
            $errors['username'] = "A username is required";
        } else if (!preg_match("/^[a-zA-Z]+$/", $_POST['username'])) {
            $errors['username'] = "Username can only have letters and no spaces";
        } else if (strlen($_POST['username']) < 3) {
            $errors['username'] = "Username cannot be less than 3 letters";
        }

        // Password and retype password validation
        if (empty($_POST['password'])) {
            $errors['password'] = "A password is required";
        } else if (strlen($_POST['password']) < 8) {
            $errors['password'] = "Password must be 8 characters or more";
        } else if ($_POST['password'] !== $_POST['retype_password']) {
            $errors['password'] = "Passwords do not match";
        }

        // Email validation
        $query = "select id from users where email = :email limit 1";
        $email = query($query, ['email' => $_POST['email']]);

        if (empty($_POST['email'])) {
            $errors['email'] = "An email is required";
        } else if ($email) {
            $errors['email'] = "Email already in use";
        } else if (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
            $errors['email'] = "Email is invalid";
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
        }

        if (empty($errors)) {
            // Save to database
            $data['username'] = $_POST['username'];
            $data['email'] = $_POST['email'];
            $data['password'] = $_POST['password'];
            $data['role'] = "normal_user";

            // Add the :image placeholder even if no image is uploaded
            if (!$imageUpdated) {
                $data['image'] = null; // or $data['image'] = '';
            }
            $query = "insert into users (username,email,password,role,image) values (:username,:email,:password,:role,:image)";
            query($query, $data);

            redirect('admin/users');
        }
    }
}

//edit  user 
else
if ($action == 'edit') {
    $query = "select * from users where id =:id limit 1";
    $row = query_2_row($query, ['id' => $id]);
    if (!empty($_POST)) {
        if ($row) {
            $errors = [];
            //username
            if (empty($_POST['username'])) {
                $errors['username'] = "A username is required";
            } else
        if (!preg_match("/^[a-zA-Z]+$/", $_POST['username'])) {
                $errors['username'] = "Username can only have letters and no spaces";
            } else
        if (strlen($_POST['username']) < 3) {
                $errors['username'] = "Username cannot be less than 3 letters";
            }
            //password and retype password validati on
            if (empty($_POST['password'])) {
            } else
        if (strlen($_POST['password']) < 8) {
                $errors['password'] = "Password must be 8 character or more";
            } else
        if ($_POST['password'] !== $_POST['retype_password']) {
                $errors['password'] = "Passwords do not match";
            }
 
             }
            //email
            $query = "select id from users where email = :email && id != :id limit 1";
            $email = query($query, ['email' => $_POST['email'], 'id' => $id]);

            if (empty($_POST['email'])) {
                $errors['email'] = "A email is required";
            } else
        if ($email) {
                $errors['email'] = "Email already in use";
            } else
        if (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
                $errors['email'] = "Email is invalid";
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
                $data['username'] = $_POST['username'];
                $data['email'] = $_POST['email'];
                $data['role'] = $_POST['role'];

                $query = "UPDATE users SET username = :username, email = :email, role = :role";

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
                redirect('admin/users');
            }
        }
    }

 else
if ($action == 'delete') {
    $query = "select * from users where id =:id limit 1";
    $row = query_2_row($query, ['id' => $id]);
    if (!empty($_SERVER['REQUEST_METHOD']== "POST")) {
        if ($row) {
            $errors = [];
            if (empty($errors)) {
                //delete from database
                $data = [];
                $data['id'] = $id;
                $query = "delete from users where id = :id limit 1";

                query($query, $data);
                redirect('admin/users');
            }
        }
    }
}