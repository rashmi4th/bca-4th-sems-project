<?php
$pagetitle = "Categories";
require 'assets/partials/header.php'; ?>

<?php if ($action == 'add') : ?>

    <h1 class="txt-col-white">Create Category</h1>
    <form method="post">

        <label class="form-label" for="user-name">Category</label>
        <input class="form-input form-control" value="<?= old_value('category') ?>" type="text" name="category" id="" placeholder="Category Name">
        <?php if (!empty($errors['category'])) : ?>
            <div class="text-danger"><?= $errors['category'] ?></div>
        <?php endif; ?>

        <label class="form-label" for="role">Active</label>
        <select name="disabled" id="" class="form-select">
            <option value="0">Yes</option>
            <option value="1">No</option>
        </select>
        <?php if (!empty($errors['role'])) : ?>
            <div class="text-danger"><?= $errors['role'] ?></div>
        <?php endif; ?>

        <button type="submit" class="btn btn-primary mt">Create</button>


    </form>


<?php elseif ($action == 'edit') : ?>

    <h1 class="txt-col-white">Edit Category</h1>
    <form method="post">
        <?php if (!empty($row)) : ?>

            <?php if (!empty($errors)) : ?>
                <div class="alert alert-danger">Please fix the errors below</div>
            <?php endif; ?>
            <label class="form-label" for="user-name">Categories Name</label>
            <input class="form-input form-control" value="<?= old_value('category', $row['0']['category']) ?>" type="text" name="category" id="" placeholder="Enter your Full Name">
            <?php if (!empty($errors['category'])) : ?>
                <div class="text-danger"><?= $errors['category'] ?></div>
            <?php endif; ?>

            <label class="form-label" for="role">Active</label>
            <select name="disabled" id="" class="form-select">
                <option value="0">Yes</option>
                <option value="1">No</option>
            </select>
            <?php if (!empty($errors['role'])) : ?>
                <div class="text-danger"><?= $errors['role'] ?></div>
            <?php endif; ?>
            
            <button type="submit" class="btn btn-primary mt">Save</button>

        <?php else : ?>
            <div class="alert-danger alert">Record Not Found</div>
        <?php endif; ?>
    </form>

<?php elseif ($action == 'delete') : ?>
    <h1 class="txt-col-white">Delete Category</h1>
    <form method="post">
        <?php if (!empty($row)) : ?>

            <?php if (!empty($errors)) : ?>
                <div class="alert alert-danger">Please fix the errors below</div>
            <?php endif; ?>

            <label class="form-label" for="user-name">Category Name</label>
            <div class="form-control"><?= old_value('category', $row['0']['category']) ?>
            </div>
            <?php if (!empty($errors['category'])) : ?>
                <div class="text-danger"><?= $errors['category'] ?></div>
            <?php endif; ?>


            <label class="form-label" for="slug">Slug</label>
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

    <h1 class="txt-col-white">Categories</h1>
    <a href="<?= ROOT ?>/admin/categories/add"><button class="btn btn-light"> Add new</button></a>
    <table>
        <tr>
            <th>#</th>
            <th>Category</th>
            <th>Slug</th>
            <th>Disabled</th>
            <th>Actions</th>
        </tr>
        <?php
        $query = "select * from categories order by id desc";
        $rows = query_2($query);
        ?>
        <?php if (!empty($rows)) : ?>
            <?php foreach ($rows as $row) : ?>
                <tr>
                    <td><?= $row['id'] ?></td>
                    <td><?= $row['category'] ?></td>
                    <td><?= $row['slug'] ?></td>
                    <td><?=$row['disabled'] ? 'No':'Yes'?></td>
                    <td>
                        <a href="<?= ROOT ?>/admin/categories/edit/<?= $row['id']; ?>">
                            <button class="btn btn-warning "><i class="fa-solid fa-pen-to-square"></i></button>
                        </a>
                        <a href="<?= ROOT ?>/admin/categories/delete/<?= $row['id']; ?>">
                            <button class="btn btn-danger "><i class="fa-solid fa-trash"></i></button>
                        </a>
                    </td>
                </tr>
            <?php endforeach; ?>
        <?php endif; ?>


    </table>


<?php endif; ?>