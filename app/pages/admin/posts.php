<?php
$pagetitle = "posts";
require 'assets/partials/header.php'; ?>

<?php if ($action == 'add') : ?>

    <h1 class="txt-col-white">Add Post</h1>
    <form method="post" enctype="multipart/form-data">
        <div class="my-2">
            <h4 class="txt-col-white">Featured Img:</h4>
            <span style="font-size:15px; color: yellow;">(Leave for no change)</span>
            <label class="d-block">
                <img class="mx-auto d-block image-preview-edit" src="<?= get_image('') ?>" style="cursor: pointer;width: 150px;height: 150px;object-fit: cover;">
                <input onchange="display_image_edit(this.files[0])" type="file" name="image" class="d-none">
            </label>
            <?php if (!empty($errors['image'])) : ?>
                <div class="text-danger"><?= $errors['image'] ?></div>
            <?php endif; ?>

            <script>
                function display_image_edit(file) {
                    document.querySelector(".image-preview-edit").src = URL.createObjectURL(file);
                }
            </script>
        </div>
        <label class="form-label" for="title">Title</label>
        <input class="form-input form-control" value="<?= old_value('title') ?>" type="text" name="title" id="" placeholder="Title of the Post">
        <?php if (!empty($errors['title'])) : ?>
            <div class="text-danger"><?= $errors['title'] ?></div>
        <?php endif; ?>



        <label class="form-label" for="content">Content</label>

        <textarea class="form-input form-control" value="<?= old_value('content') ?>" type="text" name="content" id="" cols="30" rows="10" placeholder="Content Goes Here"></textarea>
        <?php if (!empty($errors['content'])) : ?>
            <div class="text-danger"><?= $errors['content'] ?></div>
        <?php endif; ?>



        <label class="form-label" for="category">Category</label>
        <select name="category_id" id="" class="form-select">
            <option value="">-Select-</option>
            <?php
            $query = "select * from categories order by id desc";
            $categories = query_2($query);

            ?>
            <?php if (!empty($categories)) : ?>
                <?php foreach ($categories as $cat) : ?>
                    <option <?= old_select('category_id', $cat['id']) ?> value="<?= $cat['id'] ?>"><?= $cat['category'] ?></option>
                <?php endforeach; ?>
            <?php endif; ?>

        </select>
        <?php if (!empty($errors['category'])) : ?>
            <div class="text-danger"><?= $errors['category'] ?></div>
        <?php endif; ?>

        <button type="submit" class="btn btn-primary mt">Submit</button>


    </form>


<?php elseif ($action == 'edit') : ?>

   
     <h1 class="txt-col-white">Edit Post</h1>
    <form method="post" enctype="multipart/form-data">
        <?php if (!empty($row)) : ?>

            <?php if (!empty($errors)) : ?>
                <div class="alert alert-danger">Please fix the errors below</div>
            <?php endif; ?>
            <label for=""></label>

            <div class="my-2">
                <label class="d-block">
                    <img class="mx-auto d-block image-preview-edit" src="<?= get_image('') ?>" style="cursor: pointer;width: 150px;height: 150px;object-fit: cover;">
                    <input onchange="display_image_edit(this.files[0])" type="file" name="image" class="d-none">
                </label>
                <?php if (!empty($errors['image'])) : ?>
                    <div class="text-danger"><?= $errors['image'] ?></div>
                <?php endif; ?>

                <script>
                    function display_image_edit(file) {
                        document.querySelector(".image-preview-edit").src = URL.createObjectURL(file);
                    }
                </script>
            </div>
            <label class="form-label" for="title-name">Post Title</label>
            <input class="form-input form-control" value="<?=old_value('title', $row['0']['title']) ?>" type="text" name="title" id="" placeholder="Enter your Full Name">
            <?php if (!empty($errors['title'])) : ?>
                <div class="text-danger"><?= $errors['title'] ?></div>
            <?php endif; ?>



            <label class="form-label" for="content">Content</label>

            <textarea id="summernote" class="form-input form-control" value="<?=old_value('content'),$row['0']['content'] ?>" type="text" name="content" id="" cols="30" rows="10" placeholder="Content Goes Here"></textarea>
            <?php if (!empty($errors['content'])) : ?>
                <div class="text-danger"><?= $errors['content'] ?></div>
            <?php endif; ?>



          
        <label class="form-label" for="category">Category</label>
        <select name="category_id" id="" class="form-select">
            <option value="">-Select-</option>
            <?php
            $query = "select * from categories order by id desc";
            $categories = query_2($query);

            ?>
            <?php if (!empty($categories)) : ?>
                <?php foreach ($categories as $cat) : ?>
                    <option <?= old_select('category_id', $cat['id']) ?> value="<?= $cat['id'] ?>"><?= $cat['category'] ?></option>
                <?php endforeach; ?>
            <?php endif; ?>

        </select>
        <?php if (!empty($errors['category'])) : ?>
            <div class="text-danger"><?= $errors['category'] ?></div>
        <?php endif; ?>
            <button type="submit" class="btn btn-primary mt">Save</button>

        <?php else : ?>
            <div class="alert-danger alert">Record Not Found</div>
        <?php endif; ?>
    </form>
    
 
           
<?php elseif ($action == 'delete') : ?>
    <h1 class="txt-col-white">Delete Post</h1>
    <form method="post">
        <?php if (!empty($row)) : ?>

            <?php if (!empty($errors)) : ?>
                <div class="alert alert-danger">Please fix the errors below</div>
            <?php endif; ?>

            <label class="form-label" for="user-name">Post Title</label>
            <div class="form-control"><?= old_value('title', $row['0']['title']) ?>
            </div>
            <?php if (!empty($errors['title'])) : ?>
                <div class="text-danger"><?= $errors['title'] ?></div>
            <?php endif; ?>


            <label class="form-label" for="email">Slug</label>
            <div class="form-control"> <?= old_value('slug', $row['0']['slug']) ?>
            </div>
            <?php if (!empty($errors['slug'])) : ?>
                <div class="text-danger"><?= $errors['slug'] ?></div>
            <?php endif; ?>

            <button type="submit" class="btn btn-danger mt">Delete</button>

        <?php else : ?>
            <div class="alert-danger alert">Record Not Found</div>
        <?php endif; ?>
    </form>
<?php else : ?>

    <h1 class="txt-col-white">Posts</h1>
    <a href="<?= ROOT ?>/admin/posts/add"><button class="btn btn-light"> Add new</button></a>
    <table>
        <tr>
            <th>ID</th>
            <th>Title</th>
            <th>Slug</th>
            <th>Image</th>
            <th>Date</th>
            <th>Action</th>
        </tr>
        <?php
        $query = "select * from posts order by id desc";
        $rows = query_2($query);
        ?>
        <?php if (!empty($rows)) : ?>
            <?php foreach ($rows as $row) : ?>
                <tr>
                    <td><?= $row['id'] ?></td>
                    <td><?= $row['title'] ?></td>
                    <td><?= $row['slug'] ?></td>

                    <td>
                        <img src="<?= get_image($row['image']) ?>" alt="" style="width: 100px; height:100px;">
                    </td>
                    <td><?= date("jS M, Y", strtotime($row['post_date'])) ?></td>
                    <td>
                        <a href="<?= ROOT ?>/admin/posts/edit/<?= $row['id']; ?>">
                            <button class="btn btn-warning "><i class="fa-solid fa-pen-to-square"></i></button>
                        </a>
                        <a href="<?= ROOT ?>/admin/posts/delete/<?= $row['id']; ?>">
                            <button class="btn btn-danger "><i class="fa-solid fa-trash"></i></button>
                        </a>
                    </td>
                </tr>
            <?php endforeach; ?>
        <?php endif; ?>


    </table>


<?php endif; ?>