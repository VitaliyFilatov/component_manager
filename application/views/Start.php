<link rel="stylesheet" href="../media/css/bootstrap.min.css">
<script src="../media/js/bootstrap.min.js"></script>
<div class="container" style="margin-top:10px;">
    <div class="row justify-content-md-center">
        <div class="col col-lg-2">

        </div>
        <div class="col-md-auto">
            <div style="text-align: center;">
                <div class="form-inline" method="get" action="../manager">
                    <div class="form-group">
                        <label for="sel" style="margin-right:10px;">Выбрать пользователя:</label>
                        <select class="form-control" id="sel" style="margin-right:10px;">
                            <? foreach ($users as $user) { ?>
                                <option><?= $user->id ?>) <?= $user->device_id ?></option>
                            <? } ?>
                        </select>
                    </div>
                    <button id="send" class="btn btn-primary">Отправить</button>
                </div>
            </div>
        </div>
        <div class="col col-lg-2"></div>
    </div>
</div>

<script>
    function getTables()
    {
        var loc = window.location;
        var parameter = document.getElementById("sel").value;
        parameter = parameter.substr(parameter.indexOf(")")+2);
        window.location = loc.protocol + '//' + loc.host + "/manager?device_id="+parameter;
    }
    document.getElementById("send").addEventListener("click", getTables);
</script>