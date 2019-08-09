<div class="container text-left">
    <div class="py-5 text-center">
        <h2>Редактирование пользователя</h2>
    </div>

    <div class="row">
        <div class="col-md-4 order-md-2 mb-4">
            <h4 class="d-flex justify-content-between align-items-center mb-3">
                <span class="text-muted">Роли</span>
            </h4>
            <ul class="list-group mb-3">
                <?php foreach ($roles as $role):?>
                    <li class="list-group-item d-flex justify-content-between lh-condensed">
                        <div>
                            <h6 class="my-0"><?=$role->name?></h6>
                            <small class="text-muted"><?=$role->description?></small>
                        </div>
                        <div class="custom-control custom-checkbox">
                            <input type="checkbox" class="custom-control-input" id="role_<?=$role->id?>" <?php if ($role->checked): ?>checked<?php endif; ?>>
                            <label class="custom-control-label custom-control-label-relative" for="role_<?=$role->id?>"></label>
                        </div>
                    </li>
                <?php endforeach;?>
            </ul>
        </div>
        <div class="col-md-8 order-md-1">
            <h4 class="mb-3">Данные пользователя</h4>
            <form class="needs-validation" novalidate>

                <div class="mb-3">
                    <label for="secondName">Фамилия</label>
                    <input type="text" class="form-control" id="secondName" placeholder="" value="<?=$secondname?>" required>
                    <div class="invalid-feedback">
                        Фамилия обязательна
                    </div>
                </div>
                <div class="mb-3">
                    <label for="firstName">Имя</label>
                    <input type="text" class="form-control" id="firstName" placeholder="" value="<?=$firstname?>" required>
                    <div class="invalid-feedback">
                        Имя обязательно
                    </div>
                </div>
                <div class="mb-3">
                    <label for="middleName">Отчество</label>
                    <input type="text" class="form-control" id="middleName" placeholder="" value="<?=$middlename?>">
                </div>

                <div class="mb-3">
                    <label for="email">Email</label>
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text">@</span>
                        </div>
                        <input type="text" class="form-control" id="email" placeholder="Email" value="<?=$email?>" required>
                        <div class="invalid-feedback" style="width: 100%;">
                            Email обязателен
                        </div>
                    </div>
                </div>

                <div class="mb-3">
                    <label for="login">Логин</label>
                    <div class="input-group">
                        <input type="text" class="form-control" id="login" value="<?=$login?>" required>
                        <div class="invalid-feedback" style="width: 100%;">
                            Логин обязателен
                        </div>
                    </div>
                </div>

                <div class="mb-3">
                    <label for="password">Пароль</label>
                    <div class="input-group">
                        <input type="text" class="form-control" id="password" required>
                        <div class="invalid-feedback" style="width: 100%;">
                            Пароль обязателен
                        </div>
                    </div>
                </div>

                <hr class="mb-4">
                <button class="btn btn-primary btn-lg btn-block" type="submit">Сохранить</button>
            </form>
        </div>
    </div>

    <footer class="my-5 pt-5 text-muted text-center text-small">
    </footer>
</div>