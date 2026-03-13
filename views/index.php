<?php require_once BASE_PATH . "/views/components/header.php"; ?>
<div class="container">
    <?php if (isset($users)) : ?>
        <div class="second-container">
            <div class="table-container">
                <h3 class="text-white">User list</h3>
                <a href="<?= BASE_URL ?>/public/user" class="link btn btn-add">
                    Add
                </a>
                <table class="data-table">
                    <thead>
                        <tr class="text-white">
                            <th>id</th>
                            <th>name</th>
                            <th>email</th>
                            <th>Role</th>
                            <th>Join Date</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $id = 0; ?>
                        <?php foreach ($users as $user) : ?>
                            <tr class="text-white">
                                <td>
                                    <input class="input" type="text" value="<?= $id + 1 ?>">
                                <td><?= $user->userName ?></td>
                                <td><?= $user->email ?></td>
                                <td><?= $user->isAdmin ? "Admin" : "User" ?></td>
                                <td><?= date("d/m/Y", strtotime($user->created_at)) ?></td>
                                <td class="btn-container">
                                    <a href="<?= BASE_URL ?>/public/user/<?= $user->id ?>/update" class="btn link btn-edit">
                                        Edit
                                    </a>
                                    <form style="margin: 0; padding: 0;" action="<?= BASE_URL . "/public/user/{$user->id}/delete" ?>" method="POST">
                                        <?= csrf_field() ?>
                                        <button class="btn btn-delete">Delete</button>
                                    </form>
                                </td>
                            </tr>
                            <?php $id++; ?>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    <?php endif; ?>
</div>
<?php require_once BASE_PATH . "/views/components/footer.php"; ?>