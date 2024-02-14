<?php
if ($action == 'add') {
    if (!empty($_POST)) {
        //validation 
        $errors = [];
        //category name
        if (empty($_POST['category'])) {
            $errors['category'] = "A category is required";
        } else
        if (strlen($_POST['category']) < 3) {
            $errors['category'] = "category cannot be less than 3 letters";
        }

        $slug = str_to_url($_POST['category']);
        $query = "select id from categories where slug = :slug limit 1";
        $slug_row = query($query, ['slug' => $slug]);


        if ($slug) {
            $slug .= rand(1000, 9999);
        }


        if (empty($errors)) {
            //save to database
            $data = [];
            $data['category'] = $_POST['category'];
            $data['slug'] = $slug;
            $data['disabled'] = $_POST['disabled'];

            $query = "insert into categories (category,slug,disabled) values (:category,:slug,:disabled)";
            query($query, $data);

            redirect('admin/categories');
        }
    }
}
//edit  user 
else
if ($action == 'edit') {
    $query = "select * from categories where id =:id limit 1";
    $row = query_2_row($query, ['id' => $id]);
    if (!empty($_POST)) {
        if ($row) {
            $errors = [];
            //username
            if (empty($_POST['category'])) {
                $errors['category'] = "A category is required";
            } else
             if (strlen($_POST['category']) < 3) {
                $errors['category'] = "category cannot be less than 3 letters";
            }


            if (empty($errors)) {
                //save to database
                $data = [];
                $data['category'] = $_POST['category'];
                $data['disabled'] = $_POST['disabled'];
                $data['id'] = $id;

                    $query = "update categories set category = :category, disabled = :disabled where id = :id limit 1";
               

                query($query, $data);
                redirect('admin/categories');
            }
        }
    }
} else
if ($action == 'delete') {
    $query = "select * from categories where id =:id limit 1";
    $row = query_2_row($query, ['id' => $id]);
    if (!empty($_SERVER['REQUEST_METHOD'] == "POST")) {
        if ($row) {
            $errors = [];
            if (empty($errors)) {
                //delete from database
                $data = [];
                $data['id'] = $id;
                $query = "delete from categories where id = :id limit 1";

                query($query, $data);
                redirect('admin/categories');
            }
        }
    }
}
