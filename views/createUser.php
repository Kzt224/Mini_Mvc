<?php require_once BASE_PATH . "/views/Components/header.php"; ?>
<div class="container">
    <div class="second-container">
        <div class="table-container">
            <h3 class="text-white">Add User</h3>
            <form class="form" method="POST" action="<?php BASE_URL . '/public/user/create' ?>">
                <?= csrf_field() ?>
                <?php if (error()->any()): ?>
                    <?php foreach (error()->all() as $error): ?>
                        <div class="err-box">
                            <p class="text-danger">*<?= ucwords($error) ?></p>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>
                <div class="input-group">
                    <?php if(cache()->any()){
                        $oldData = cache()->all();
                    } ?>
                    <input type="text" name="userName" value="<?= ($oldData['userName'] ?? '') ?>" placeholder=" ">
                    <label for="userName">Name</label>
                </div>
                <div class="input-group">
                    <input type="text" name="email" value="<?= ($oldData['email'] ?? '') ?>" placeholder=" ">
                    <label for="email">Email</label>
                </div>
                <div class="input-group">
                    <input type="password" name="password" value="<?= ($oldData['password'] ?? '') ?>" placeholder=" ">
                    <label for="password">Password</label>
                </div>
                <div class="check">
                    <input type="checkbox" name="isAdmin" id="" name="Admin">
                    <p class="text-white">Is Admin</p>
                </div>
                <div class="ctn-right">
                    <button class="btn btn-submit">Create</button>
                    <a href="<?= BASE_URL ?>/public/" class="link btn btn-add">
                        Back
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>
<?php require_once BASE_PATH . "/views/components/footer.php"; ?>