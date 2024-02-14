<?php
$pagetitle = "Users";
$userImage = $_SESSION['image'];
require 'assets/partials/header.php'; ?>

<?php if ($action == 'add') : ?>

    <h1 class="txt-col-white">Add User</h1>
    <form method="post" enctype="multipart/form-data" >
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
        <label class="form-label" for="user-name">User Name</label>
        <input class="form-input form-control" value="<?= old_value('username') ?>" type="text" name="username" id="" placeholder="Enter your Full Name">
        <?php if (!empty($errors['username'])) : ?>
            <div class="text-danger"><?= $errors['username'] ?></div>
        <?php endif; ?>



        <label class="form-label" for="email">Email</label>
        <input class="form-input form-control" value="<?= old_value('email') ?>" type="text" name="email" id="" placeholder="Enter your Email">
        <?php if (!empty($errors['email'])) : ?>
            <div class="text-danger"><?= $errors['email'] ?></div>
        <?php endif; ?>

        <label class="form-label" for="role">Role</label>
        <select name="role" id="" class="form-select">
            <option value="user">normal-user</option>
            <option value="admin">Admin</option>
        </select>
        <?php if (!empty($errors['role'])) : ?>
            <div class="text-danger"><?= $errors['role'] ?></div>
        <?php endif; ?>


        <label class="form-label" for="password">Password</label>
        <input class="form-input form-control" value="<?= old_value('password') ?>" type="text" name="password" id="" placeholder="Enter your Password">
        <?php if (!empty($errors['password'])) : ?>
            <div class="text-danger"><?= $errors['password'] ?></div>
        <?php endif; ?>


        <label class="form-label" for="confirm-password">Confirm Password</label>
        <input class="form-input form-control" value="<?= old_value('username') ?>" type="text" name="retype_password" id="" placeholder="Confirm your Password">



        <button type="submit" class="btn btn-primary mt">Submit</button>


    </form>


<?php elseif ($action == 'edit') : ?>

    <h1 class="txt-col-white">Edit Account</h1>
    <form method="post" enctype="multipart/form-data" >
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
            <label class="form-label" for="user-name">User Name</label>
            <input class="form-input form-control" value="<?= old_value('username', $row['0']['username']) ?>" type="text" name="username" id="" placeholder="Enter your Full Name">
            <?php if (!empty($errors['username'])) : ?>
                <div class="text-danger"><?= $errors['username'] ?></div>
            <?php endif; ?>


            <label class="form-label" for="email">Email</label>
            <input class="form-input form-control" value="<?= old_value('email', $row['0']['email']) ?>" type="text" name="email" id="" placeholder="Enter your Email">
            <?php if (!empty($errors['email'])) : ?>
                <div class="text-danger"><?= $errors['email'] ?></div>
            <?php endif; ?>

            <label class="form-label" for="role">Role</label>
            <select name="role" id="" class="form-select">
                <option value="user">normal-user</option>
                <option value="admin">Admin</option>
            </select>
            <?php if (!empty($errors['role'])) : ?>
                <div class="text-danger"><?= $errors['role'] ?></div>
            <?php endif; ?>

            <label class="form-label" for="password">Password</label>
            <input class="form-input form-control" value="<?= old_value('password') ?>" type="text" name="password" id="" placeholder="Leave for no change">
            <?php if (!empty($errors['password'])) : ?>
                <div class="text-danger"><?= $errors['password'] ?></div>
            <?php endif; ?>


            <label class="form-label" for="confirm-password">Confirm Password</label>
            <input class="form-input form-control" value="<?= old_value('username') ?>" type="text" name="retype_password" id="" placeholder="Leave for no change">

            <button type="submit" class="btn btn-primary mt">Save</button>

        <?php else : ?>
            <div class="alert-danger alert">Record Not Found</div>
        <?php endif; ?>
    </form>

<?php elseif ($action == 'delete') : ?>
    <h1 class="txt-col-white">Delete Account</h1>
    <form method="post">
        <?php if (!empty($row)) : ?>

            <?php if (!empty($errors)) : ?>
                <div class="alert alert-danger">Please fix the errors below</div>
            <?php endif; ?>

            <label class="form-label" for="user-name">User Name</label>
            <div class="form-control"><?= old_value('username', $row['0']['username']) ?>
            </div>
            <?php if (!empty($errors['username'])) : ?>
                <div class="text-danger"><?= $errors['username'] ?></div>
            <?php endif; ?>


            <label class="form-label" for="email">Email</label>
            <div class="form-control"> <?= old_value('email', $row['0']['email']) ?>
            </div>
            <?php if (!empty($errors['email'])) : ?>
                <div class="text-danger"><?= $errors['email'] ?></div>
            <?php endif; ?>

            <button type="submit" class="btn btn-danger mt">Delete</button>

        <?php else : ?>
            <div class="alert-danger alert">Record Not Found</div>
        <?php endif; ?>
    </form>
<?php else : ?>

    <h1 class="txt-col-white">Users</h1>
    <a href="<?= ROOT ?>/admin/users/add"><button class="btn btn-light"> Add new</button></a>
    <table>
        <tr>
            <th>ID</th>
            <th>Username</th>
            <th>Email</th>
            <th>Role</th>
            <th>Image</th>
            <th>Date</th>
            <th>Actions</th>
        </tr>
        <?php
        $query = "select * from users order by id desc";
        $rows = query_2($query);
        ?>
        <?php if (!empty($rows)) : ?>
            <?php foreach ($rows as $row) : ?>
                <tr>
                    <td><?= $row['id'] ?></td>
                    <td><?= $row['username'] ?></td>
                    <td><?= $row['email'] ?></td>
                    <td><?= $row['role'] ?></td>
                    <td>
                        <img src="<?= get_image($row['image'])?>" alt="" style="width: 100px; height:100px;">
                    </td>
                    <td><?= date("jS M, Y", strtotime($row['user_date'])) ?></td>
                    <td>
                        <a href="<?= ROOT ?>/admin/users/edit/<?= $row['id']; ?>">
                            <button class="btn btn-warning "><i class="fa-solid fa-pen-to-square"></i></button>
                        </a>
                        <a href="<?= ROOT ?>/admin/users/delete/<?= $row['id']; ?>">
                            <button class="btn btn-danger "><i class="fa-solid fa-trash"></i></button>
                        </a>
                    </td>
                </tr>
            <?php endforeach; ?>
        <?php endif; ?>


    </table>


<?php endif; ?>