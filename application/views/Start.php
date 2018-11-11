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
<!--<!DOCTYPE html>-->
<!--<html>-->
<!--<head>-->
<!--    <title>Editable</title>-->
<!--    <meta charset="utf-8">-->
<!--    <link rel="stylesheet" href="../assets/bootstrap/css/bootstrap.min.css">-->
<!--    <link rel="stylesheet" href="../assets/bootstrap-table/src/bootstrap-table.css">-->
<!--    <link rel="stylesheet" href="//rawgit.com/vitalets/x-editable/master/dist/bootstrap3-editable/css/bootstrap-editable.css">-->
<!--    <link rel="stylesheet" href="../assets/examples.css">-->
<!--    <script src="../assets/jquery.min.js"></script>-->
<!--    <script src="../assets/bootstrap/js/bootstrap.min.js"></script>-->
<!--    <script src="../assets/bootstrap-table/src/bootstrap-table.js"></script>-->
<!--    <script src="../assets/bootstrap-table/src/extensions/editable/bootstrap-table-editable.js"></script>-->
<!--    <script src="//rawgit.com/vitalets/x-editable/master/dist/bootstrap3-editable/js/bootstrap-editable.js"></script>-->
<!--    <script src="../ga.js"></script>-->
<!--</head>-->
<!--<body>-->
<!--<div class="container">-->
<!--    <h1>Editable</h1>-->
<!--    <table id="table"-->
<!--           data-toggle="table"-->
<!--           data-pagination="true"-->
<!--           data-show-export="true"-->
<!--           data-url="../json/data1.json">-->
<!--        <thead>-->
<!--        <tr>-->
<!--            <th data-field="id">ID</th>-->
<!--            <th data-field="name" data-editable="true">Item Name</th>-->
<!--            <th data-field="price" data-editable="true">Item Price</th>-->
<!--        </tr>-->
<!--        </thead>-->
<!--    </table>-->
<!--</div>-->
<!--</body>-->
<!--</html>-->