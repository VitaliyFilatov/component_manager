<main role="main" class="container">
    <div class="d-flex align-items-center p-3 my-3 text-white-50 bg-primary rounded shadow-sm">
        <div class="lh-100">
            <h6 class="mb-0 text-white lh-100">Пользователи</h6>
        </div>
    </div>

    <div class="my-3 p-3 bg-white rounded shadow-sm text-left">
        <?php foreach ($users as $user): ?>
            <div class="media text-muted pt-3">
                <div class="media-body pb-3 mb-0 small lh-125 border-bottom border-gray">
                    <div class="d-flex justify-content-between align-items-center w-100">
                        <strong class="d-block text-gray-dark"><?= $user['login'] ?>, <?= $user['role'] ?></strong>
                        <?php if ($user['editable']): ?><a href="/main/editUser/<?= $user['id'] ?>">Редактировать</a><?php endif; ?>
                    </div>
                    <span class="d-block"><?= $user['secondname'] ?> <?= $user['firstname'] ?> <?= $user['middlename'] ?></span>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</main>
