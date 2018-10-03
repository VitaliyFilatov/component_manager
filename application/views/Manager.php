<!DOCTYPE html>
<html>
<head>
    <!--    <style>-->
    <!--        table {-->
    <!--            font-family: arial, sans-serif;-->
    <!--            border-collapse: collapse;-->
    <!--            width: 100%;-->
    <!--        }-->
    <!---->
    <!--        td, th {-->
    <!--            border: 1px solid #dddddd;-->
    <!--            text-align: left;-->
    <!--            padding: 8px;-->
    <!--        }-->
    <!---->
    <!--        tr:nth-child(even) {-->
    <!--            background-color: #dddddd;-->
    <!--        }-->
    <!--    </style>-->
    <style>
        .wrap-content
        {
            word-wrap: break-word;
        }
    </style>
    <link rel="stylesheet" href="../media/css/bootstrap.min.css">
    <script src="../media/js/bootstrap.min.js"></script>
</head>
<body style="text-align: center">

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
                    <td><?= $room->address->city ?>, <?= $room->address->street ?>, <?= $room->address->building ?></td>
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

        <table class="table table-striped table-bordered">
            <thead>
            <tr>
                <th>Идентификатор</th>
                <th>Имя</th>
            </tr>
            </thead>
            <tbody>
            <? foreach ($complexTypes as $complexType) { ?>
                <tr>
                    <td><?= $complexType->inner_id ?></td>
                    <td><?= $complexType->name ?></td>
                </tr>
                <tr>
                    <th>Идентификатор</th>
                    <th>Компонента</th>
                </tr>
                <? $componentsOfCT = $complexType->complex_type_has_components->find_all(); ?>
                <? foreach ($componentsOfCT as $componentOfCT) { ?>
                    <tr>
                        <td><?= $componentOfCT->inner_id ?></td>
                        <td><?= $componentOfCT->component->name ?></td>
                    </tr>
                <? } ?>
            <? } ?>
            </tbody>
        </table>
    </div>
</div>


<div class="row justify-content-md-center">
    <div class="col col-md-11">
        <h2>Комплексы</h2>

        <table class="table table-striped table-bordered">
            <thead>
            <tr>
                <th>Идентификатор</th>
                <th>Тип комплекса</th>
                <th>Адрес</th>
                <th>Кабинет</th>
                <th>Идентификатор внутри адреса</th>
                <th>Примечание</th>
                <th>IP-адрес</th>
                <th>путь до фото</th>
            </tr>
            </thead>
            <tbody></tbody>
        </table>

        <? foreach ($complexes as $complex) { ?>
            <table class="table table-striped table-bordered">
                <thead>
                <tr>
                    <th>Идентификатор</th>
                    <th>Тип комплекса</th>
                    <th>Адрес</th>
                    <th>Кабинет</th>
                    <th>Идентификатор внутри адреса</th>
                    <th>Примечание</th>
                    <th>IP-адрес</th>
                    <th>путь до фото</th>
                </tr>
                </thead>
                <tbody>
                <tr>
                    <td><?= $complex->inner_id ?></td>
                    <td><?= $complex->complex_type->name ?></td>
                    <td><?= $complex->address->city ?>, <?= $complex->address->street ?>
                        , <?= $complex->address->building ?></td>
                    <td><?= $complex->room->name ?></td>
                    <td><?= $complex->id_by_address ?></td>
                    <td><?= $complex->appendix ?></td>
                    <td><?= $complex->IPADDRESS ?></td>
                    <td><?= $complex->photo_path ?></td>
                </tr>
                <tr>
                    <table class="table table-striped table-bordered">
                        <thead>
                        <tr>
                            <th>Идентификатор</th>
                            <th>Компонента</th>
                            <th>Код</th>
                        </tr>
                        </thead>
                        <tbody>
                        <? $componentsOfComplex = $complex->complex_has_components->find_all(); ?>
                        <? foreach ($componentsOfComplex as $componentOfComplex) { ?>
                            <tr>
                                <td><?= $componentOfComplex->inner_id ?></td>
                                <td><?= $componentOfComplex->component->name ?></td>
                                <td><?= $componentOfComplex->code ?></td>
                            </tr>
                        <? } ?>
                        </tbody>
                    </table>
                </tr>

                </tbody>
            </table>
        <? } ?>
    </div>
</div>


<div class="row justify-content-md-center">
    <div class="col col-md-11">
        <h2>Комплексы</h2>

        <div class="row">
            <div class="col col-md-1 wrap-content">
                Идентификатор
            </div>
            <div class="col col-md-1 wrap-content">
                Тип комплекса
            </div>
            <div class="col col-md-1 wrap-content">
                Адрес
            </div>
            <div class="col col-md-1 wrap-content">
                Кабинет
            </div>
            <div class="col col-md-2 wrap-content">
                Идентификатор внутри адреса
            </div>
            <div class="col col-md-2 wrap-content">
                Примечание
            </div>
            <div class="col col-md-2 wrap-content">
                IP-адрес
            </div>
            <div class="col col-md-2 wrap-content">
                путь до фото
            </div>
        </div>
        <? foreach ($complexes as $complex) { ?>
            <div class="row">
                
            </div>
            <tr>
                <td><?= $complex->inner_id ?></td>
                <td><?= $complex->complex_type->name ?></td>
                <td><?= $complex->address->city ?>, <?= $complex->address->street ?>
                    , <?= $complex->address->building ?></td>
                <td><?= $complex->room->name ?></td>
                <td><?= $complex->id_by_address ?></td>
                <td><?= $complex->appendix ?></td>
                <td><?= $complex->IPADDRESS ?></td>
                <td><?= $complex->photo_path ?></td>
            </tr>
            <tr>
                <table class="table table-striped table-bordered">
                    <thead>
                    <tr>
                        <th>Идентификатор</th>
                        <th>Компонента</th>
                        <th>Код</th>
                    </tr>
                    </thead>
                    <tbody>
                    <? $componentsOfComplex = $complex->complex_has_components->find_all(); ?>
                    <? foreach ($componentsOfComplex as $componentOfComplex) { ?>
                        <tr>
                            <td><?= $componentOfComplex->inner_id ?></td>
                            <td><?= $componentOfComplex->component->name ?></td>
                            <td><?= $componentOfComplex->code ?></td>
                        </tr>
                    <? } ?>
                    </tbody>
                </table>
            </tr>

            </tbody>
            </table>
        <? } ?>
    </div>
</div>


</body>
</html>