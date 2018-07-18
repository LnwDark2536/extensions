<?php
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <style>
        body {
            font-family: "Garuda";
        }

        .mainpage {
            height: 49%;
            width: 100%;
            border: 1px solid black;
        }

        #senderBlock{
            border: 1px solid black;
            height: 30px;
            width: 310px;
            margin-left: 20px;
            margin-top: 30px;
        }
        .sendhead {
            border-bottom: 1px solid black;
            /*height: 30px;*/
            /*width: 310px;*/
            /*margin-left: 20px;*/
            /*margin-top: 30px;*/
        }

        .sender {
            /*height: 150px;*/
            /*width: 300px;*/
            /*!*padding-top: 1px;*!*/
            /*margin-left: 20px;*/
            /*border: 1px solid black;*/
        }

        #receiveBlock{
            border: 1px solid black;
            height: 180px;
            width: 390px;
            margin-left: 350px;
            margin-top: 10px
        }



        .receviehead {
            /*border-bottom: 1px solid black;*/
            /*height: 30px;*/
            /*width: 330px;*/
            /*margin-left: 380px;*/
            border-bottom: 1px solid black;
        }
        th {
            text-align: left;
        }

        .table > thead > tr > th {
            vertical-align: bottom;
            border-bottom: 2px solid #ddd;
        }
        .shirts{
            /*margin-top: -160px;*/
            /*margin-left: 600px;*/
            /*padding     -left: 500px;*/
        }
        .row {
             margin-left: -15px;
             margin-right: -15px;
         }
        .col-xs-1, .col-sm-1, .col-md-1, .col-lg-1, .col-xs-2, .col-sm-2, .col-md-2, .col-lg-2, .col-xs-3, .col-sm-3, .col-md-3, .col-lg-3, .col-xs-4, .col-sm-4, .col-md-4, .col-lg-4, .col-xs-5, .col-sm-5, .col-md-5, .col-lg-5, .col-xs-6, .col-sm-6, .col-md-6, .col-lg-6, .col-xs-7, .col-sm-7, .col-md-7, .col-lg-7, .col-xs-8, .col-sm-8, .col-md-8, .col-lg-8, .col-xs-9, .col-sm-9, .col-md-9, .col-lg-9, .col-xs-10, .col-sm-10, .col-md-10, .col-lg-10, .col-xs-11, .col-sm-11, .col-md-11, .col-lg-11, .col-xs-12, .col-sm-12, .col-md-12, .col-lg-12 {
            position: relative;
            min-height: 1px;
            padding-left: 15px;
            padding-right: 15px;
        }
        .col-xs-1, .col-xs-2, .col-xs-3, .col-xs-4, .col-xs-5, .col-xs-6, .col-xs-7, .col-xs-8, .col-xs-9, .col-xs-10, .col-xs-11, .col-xs-12 {
            float: left;
        }
        .col-xs-12 {
            width: 100%;
        }
        .col-xs-11 {
            width: 91.66666667%;
        }
        .col-xs-10 {
            width: 83.33333333%;
        }
        .col-xs-9 {
            width: 75%;
        }
        .col-xs-8 {
            width: 66.66666667%;
        }
        .col-xs-7 {
            width: 58.33333333%;
        }
        .col-xs-6 {
            width: 50%;
        }
        .col-xs-5 {
            width: 41.66666667%;
        }
        .col-xs-4 {
            width: 33.33333333%;
        }
        .col-xs-3 {
            width: 25%;
        }
        .col-xs-2 {
            width: 16.66666667%;
        }
        .col-xs-1 {
            width: 8.33333333%;
        }
    </style>
</head>
<body>


<?php foreach ($dataProvider as $key => $value): ?>

    <div class="mainpage">
        <div id="senderBlock">
            <div class="sendhead">
                <div style="padding-left: 10px ; float: left; margin-right: 197px">
                    <div style="font-weight: bold; font-size: 14px">ชื่อและที่อยู่ผู้ส่ง
                        <div style="line-height: 1">/SENDER</div>
                    </div>
                </div>

                <div style="font-size: 14px;  height: 30px; width: 150px;margin-left: 20px; float: right; margin-top: 0px;">
                    <div style="font-weight: bold;">สำหรับติดต่อผู้ส่ง/Tel.
                        <div style="line-height: 1">02-3961984</div>
                    </div>
                </div>
            </div>

            <div class="sender" style="padding-left: 10px ; font-size: 14px; float: left"><span></span>
                <div style="font-weight: bold">จาก/From</div>
                <div style="font-weight: bold; font-size: 16px">โรงเรียนสิริรัตนาธร</div>
                <div style="font-weight: normal; line-height: 2">47 หมู่ 0 ซอยอุดมสุข 30 ถนน อุดมสุข</div>
                <div style="font-weight: normal; line-height: 2">แขวงบางนา เขตบางนา กรุงเทพมหานคร</div>
                <div style="font-weight: bold;text-align: center; font-size: 16px; line-height: 2">รหัสไปรษณีย์
                    <span style="text-decoration: underline; font-weight: bold">10260</span>
                </div>
            </div>
        </div>


        <div id="receiveBlock">

            <div class="receviehead">
                <div style="height: 40px; width: 160px;  float: left">
                    <div style="font-weight: bold; font-size: 14px; padding-left: 10px">ชื่อและที่อยู่ผู้รับ
                        <div style="line-height: 1">/ADDRESS</div>
                    </div>
                </div>
                <div style="font-size: 14px; height: 40px; width: 160px;float: right">
                    <div style="font-weight: bold;padding-right: 2px;">สำหรับติดต่อผู้รับ/Tel.
                        <div style="padding-right: 10px;line-height: 1"><?= $value['phone'] ?></div>
                    </div>
                </div>
            </div>

            <!-- ช่องที่อยู่ผู้รับ -->


            <div class="reveiver" style="padding-left: 10px; ">
                <div class="row">
                    <div class="col-xs-7">
                        <div style="font-size: 16px ; font-weight: bold">ถึง/TO<br>
                            <div style="font-weight: bold ; font-size: 14px;"> <?= ' คุณ '.$value['fullname'] ?></div>



                            <div style="font-weight: normal ;font-size: 14px">
                                <?php echo !empty( $value['address'] ) ?  $value['address'] : ''?>
                                <?php echo !empty( $value['house_no'] ) ? ' หมู่ ' . $value['house_no'] : ''?>
                                <?php echo !empty( $value['soi'] ) ? ' ซ. ' . $value['soi'] : ''?>
                                <?php echo !empty( $value['street'] ) ? ' ถ.' . $value['street'].'<br>' : '<br>'?>
                                <?php echo !empty( $value['district'] ) ? ' <strong>ต.</strong>'. $value['district'] : ''?>
                                <?php echo !empty( $value['amphoe'] ) ? ' <strong>อ.</strong>'. $value['amphoe'] : ''?>
                                <?php echo !empty( $value['province'] ) ? ' <strong>จ.</strong>'. $value['province'] : ''?>
                     </div>
                            <div style="font-weight: bold; font-size: 18px;text-align: center">รหัสไปรษณีย์
                                <span style="text-decoration: underline"><?= ' ' . $value['zipcode'] ?></span></div>
                        </div>
                    </div>
                    <div class="col-xs-3">
                        <div style="margin-top: 5px; ">
                            <table class="table"  style="font-size: 12px;">
                                <thead>
                                <tr>
                                    <th>เสื้อ</th>
                                    <th style="text-align: right;">จำนวน</th>
                                </tr>
                                </thead>
                                <?php foreach ( Yii::$app->db->createCommand("SELECT size_shirts,COUNT (size_shirts) AS sum_size FROM register WHERE register_id=:register_id OR ID=:id GROUP BY size_shirts")->bindValues(['register_id' =>  $value['id'] , 'id' =>  $value['id'] ])->queryAll() as $Qmodel): ?>
                                    <tr>
                                        <td><?= @$Qmodel['size_shirts'] ?></td>
                                        <td style="text-align: right;"><?= @$Qmodel['sum_size'] ?> ตัว</td>
                                    </tr>
                                <?php endforeach; ?>
                            </table>
                        </div>
                    </div>
                </div>

            </div>
        </div>

    </div>
<?php endforeach; ?>
</body>
</html>
