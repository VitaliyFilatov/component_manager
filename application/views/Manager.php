<!DOCTYPE html>
<html>
<head>
    <style>
        .wrap-content {
            word-wrap: break-word;
        }
    </style>
    <!--    <link rel="stylesheet" href="../media/css/bootstrap.min.css">-->
    <!--    <script src="../media/js/bootstrap.min.js"></script>-->
    <link rel="stylesheet" href="../media/bootstrap-table-dependencies/css/bootstrap.min.css">
    <link rel="stylesheet" href="../media/bootstrap-table-dependencies/css/bootstrap-table.css">
    <script type="text/javascript" src="../media/bootstrap-table-dependencies/js/jquery-2.1.0.js"></script>
    <script type="text/javascript" src="../media/bootstrap-table-dependencies/js/bootstrap.min.js"></script>
    <script type="text/javascript" src="../media/bootstrap-table-dependencies/js/bootstrap-table.js"></script>
    <!--    <script type="text/javascript" src="js/main.js"></script>-->
</head>
<body style="text-align: center">

<div class="container" style="margin-bottom: 50px;">
    <div class="row justify-content-md-center">
        <div class="col-md-auto">
            <h2>Объекты</h2>

            <table class="table table-striped table-bordered">
                <thead>
                <tr>
                    <th>Идентификатор</th>
                    <th>Имя</th>
                </tr>
                </thead>
                <tbody>
                <? foreach ($objects as $object) { ?>
                    <tr>
                        <td><?= $object->inner_id ?></td>
                        <td><?= $object->name ?></td>
                    </tr>
                <? } ?>
                </tbody>
            </table>
        </div>
    </div>

    <div class="row justify-content-md-center">
        <div class="col-md-auto">
            <h2>Адреса</h2>

            <table class="table table-striped table-bordered">
                <thead>
                <tr>
                    <th>Идентификатор</th>
                    <th>Город</th>
                    <th>Улица</th>
                    <th>Здание</th>
                    <th>Объект</th>
                </tr>
                </thead>
                <tbody>
                <? foreach ($addresses as $address) { ?>
                    <tr>
                        <td><?= $address->inner_id ?></td>
                        <td><?= $address->city ?></td>
                        <td><?= $address->street ?></td>
                        <td><?= $address->building ?></td>
                        <td><?= $address->object->name ?></td>
                    </tr>
                <? } ?>
                </tbody>
            </table>
        </div>
    </div>


    <div class="row justify-content-md-center">
        <div class="col-md-auto">
            <h2>Кабинеты</h2>

            <table class="table table-striped table-bordered">
                <thead>
                <tr>
                    <th>Идентификатор</th>
                    <th>Наименование</th>
                    <th>Адрес</th>
                </tr>
                </thead>
                <tbody>
                <? foreach ($rooms as $room) { ?>
                    <tr>
                        <td><?= $room->inner_id ?></td>
                        <td><?= $room->name ?></td>
                        <td><?= $room->address->city ?>, <?= $room->address->street ?>
                            , <?= $room->address->building ?></td>
                    </tr>
                <? } ?>
                </tbody>
            </table>
        </div>
    </div>

    <div class="row justify-content-md-center">
        <div class="col-md-auto">

            <h2>Компоненты</h2>

            <table class="table table-striped table-bordered">
                <thead>
                <tr>
                    <th>Идентификатор</th>
                    <th>Имя</th>
                </tr>
                </thead>
                <tbody>
                <? foreach ($components as $component) { ?>
                    <tr>
                        <td><?= $component->inner_id ?></td>
                        <td><?= $component->name ?></td>
                    </tr>
                <? } ?>
                </tbody>
            </table>
        </div>
    </div>

    <div class="row justify-content-md-center">
        <div class="col-md-auto">
            <h2>Типы Комплексов</h2>

            <table id="tableComplexType">
            </table>

            <!--            <table class="table table-striped table-bordered">-->
            <!--                <thead>-->
            <!--                <tr>-->
            <!--                    <th>Идентификатор</th>-->
            <!--                    <th>Имя</th>-->
            <!--                </tr>-->
            <!--                </thead>-->
            <!--                <tbody>-->
            <!--                --><?// foreach ($complexTypes as $complexType) { ?>
            <!--                    <tr>-->
            <!--                        <td>--><?//= $complexType->inner_id ?><!--</td>-->
            <!--                        <td>--><?//= $complexType->name ?><!--</td>-->
            <!--                    </tr>-->
            <!--                    <tr>-->
            <!--                        <th>Идентификатор</th>-->
            <!--                        <th>Компонента</th>-->
            <!--                    </tr>-->
            <!--                    --><?// $componentsOfCT = $complexType->complex_type_has_components->find_all(); ?>
            <!--                    --><?// foreach ($componentsOfCT as $componentOfCT) { ?>
            <!--                        <tr>-->
            <!--                            <td>--><?//= $componentOfCT->inner_id ?><!--</td>-->
            <!--                            <td>--><?//= $componentOfCT->component->name ?><!--</td>-->
            <!--                        </tr>-->
            <!--                    --><?// } ?>
            <!--                --><?// } ?>
            <!--                </tbody>-->
            <!--            </table>-->
        </div>
    </div>

    <div class="row justify-content-md-center">
        <div class="col-md-auto">
            <h2>Комплексы</h2>
            <table id="tableComplex">
            </table>
        </div>
    </div>
</div>

<script src="../media/bootstrap-table-dependencies/js/main.js"></script>
<script>
    var data =
        [
            <? foreach ($complexTypes as $complexType) { ?>
            {
                'id': '<?= $complexType->inner_id ?>',
                'name': '<?= $complexType->name ?>',
                'nested': [
                    <? $componentsOfCT = $complexType->complex_type_has_components->find_all(); ?>
                    <? foreach ($componentsOfCT as $componentOfCT) { ?>
                    {
                        'id': '<a id="a'+'<?= $componentOfCT->inner_id ?>'+'" style="display:none" href="/">'+'<?= $componentOfCT->inner_id ?>'+'</a>'+
                        '<div id="div' + '<?= $componentOfCT->inner_id ?>' + '"><?= $componentOfCT->inner_id ?></div>',
                        'name': '<?= $componentOfCT->component->name ?>',
                    },
                    <? } ?>
                ]
            },
            <? } ?>
        ];

    buildComplexTypeTable(data);

    data =
        [
            <? foreach ($complexes as $complex) { ?>
            {
                'id': '<div><?= $complexType->inner_id ?></div>',
                'name': '<input type="text" class="form-control" id="editNameComplexType_'+'<?= $complexType->inner_id ?>'+'" style="display:none">'+
                '<div id="nameComplexType_' + '<?= $complexType->inner_id ?>' + '"><?= $complexType->name ?></div>',
                'button' : '<button id="changeComplexType_'+'<?= $complexType->inner_id ?>'+'" type="button" class="btn btn-primary" onclick="onBtnChangeClick(this.id)">Изменить</button>'+
                '<div id="groupComplexType_'+'<?= $complexType->inner_id ?>'+'" class="btn-group" role="group" aria-label="First group" style="display:none">' +
                '<button id="saveComplexType_'+'<?= $complexType->inner_id ?>'+'" type="button" class="btn btn-success" onclick="onSaveBtnClick(this.id)">Сохранить</button>' +
                '<button id="cancelComplexType_'+'<?= $complexType->inner_id ?>'+'" type="button" class="btn btn-danger" onclick="onCancelBtnClick(this.id)">Отменить</button>' +
                '</div>',

                'id': '<?= $complex->inner_id ?>',
                'complexTypeName': '<?= $complex->complex_type->name ?>',
                'address': '<?= $complex->address->city ?>, <?= $complex->address->street ?>, <?= $complex->address->building ?>',
                'room': '<?= $complex->room->name ?>',
                'idByAddress': '<?= $complex->id_by_address ?>',
                'appendix': '<?= $complex->appendix ?>',
                'ipAddress': '<input type="text" class="form-control" id="editIpAddressComplex_'+'<?= $complex->inner_id ?>'+'" style="display:none">'+
                '<div id="ipAddressComplex_' + '<?= $complex->inner_id ?>' + '"><?= $complex->IPADDRESS ?></div>',
                'photoPath': '<a href="<?= $complex->photo_path ?>"><?= $complex->photo_path ?></a>',
                'button' : '<button id="changeComplex_'+'<?= $complex->inner_id ?>'+'" type="button" class="btn btn-primary" onclick="onBtnChangeClick(this.id)">Изменить</button>'+
                '<div id="groupComplex_'+'<?= $complex->inner_id ?>'+'" class="btn-group" role="group" aria-label="First group" style="display:none">' +
                '<button id="saveComplex_'+'<?= $complex->inner_id ?>'+'" type="button" class="btn btn-success" onclick="onSaveBtnClick(this.id)">Сохранить</button>' +
                '<button id="cancelComplex_'+'<?= $complex->inner_id ?>'+'" type="button" class="btn btn-danger" onclick="onCancelBtnClick(this.id)">Отменить</button>' +
                '</div>',
                'nested': [
                    <? $componentsOfComplex = $complex->complex_has_components->find_all(); ?>
                    <? foreach ($componentsOfComplex as $componentOfComplex) { ?>
                    {
                        'id': '<?= $componentOfComplex->inner_id ?>',
                        'component': '<?= $componentOfComplex->component->name ?>',
                        'code': '<?= $componentOfComplex->code ?>'
                    },
                    <? } ?>
                ]
            },
            <? } ?>
        ];

    buildComplexTable(data);

</script>

</body>
</html>