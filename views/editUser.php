<?php require_once BASE_PATH . "/views/Components/header.php"; ?>
<div class="container">
    <div class="second-container">
        <div class="table-container">
            <h3 class="text-white">Edit User</h3>
            <?php
            $user = $user[0] ?? [];
            ?>
            <form class="form" method="POST" action="<?php BASE_URL . "/public/user/{$user->id}/update" ?>">
                <?= csrf_field() ?>
                <?php if (error()->any()): ?>
                    <?php foreach (error()->all() as $error): ?>
                        <div class="err-box">
                            <p class="text-danger">*<?= ucwords($error) ?></p>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>
                <?php if (cache()->any()) {
                    $oldData = cache()->all();
                    print_r($oldData);
                } ?>
                <?php print_r($user) ?>
                <div class="input-group">
                    <input type="text" name="userName" value="<?= ($oldData['userName'] ?? $user->userName) ?>" placeholder=" ">
                    <label for="userName">Name</label>
                </div>
                <div class="input-group">
                    <input type="text" name="email" value="<?= ($oldData['email'] ?? $user->email) ?>" placeholder=" ">
                    <label for="email">Email</label>
                </div>
                <div class="input-group">
                    <input type="password" name="password" value="<?= ($oldData['password'] ?? '') ?>" placeholder=" ">
                    <label for="password">Password</label>
                </div>
                <div class="check">
                    <input type="checkbox" name="isAdmin" id="" name="Admin" <?php
                                                                                if ($user->isAdmin === 1) {
                                                                                ?>checked<?php
                                                                                        }
                                                                                            ?>>
                    <p class="text-white">Is Admin</p>
                </div>
                <div class="ctn-right">
                    <button class="btn btn-submit">Update</button>
                    <a href="<?= BASE_URL ?>/public/" class="link btn btn-add">
                        Back
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>
<?php require_once BASE_PATH . "/views/components/footer.php"; ?>