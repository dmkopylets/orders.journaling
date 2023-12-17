<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>наряд</title>
    <link rel="icon" href="{{asset('img/favicons/favicon.ico') }}">
    <link href="{{asset('css/pdf.css')}}" rel="stylesheet">
</head>
<body>
<div class="page">
    <table width="19cm">
        <col width="2.5cm"/>
        <col width="15.5cm"/>
        <tr style="border: none;  line-height: 1pt;">
            <td width="3cm">
                <p style="font-size: 10pt; margin-bottom: 0;">Підприємство</p>
            </td>
            <td width="15.5cm" style="border-bottom: 0.5px solid #000;">
                <p style="font-size: 10pt; text-align: left; margin-bottom:0; padding:2px"><i>&quot;ANYОБЛЕНЕРГО&quot;</i>
                </p>
            </td>
        </tr>
        <tr>
            <td width="3cm" style="border: none;  line-height: 1pt;">
                <p style="font-size: 10pt; margin-bottom: 0;">Підрозділ</p>
            </td>
            <td width="15.5cm" style="border: none;  line-height: 1pt; border-bottom: 0.5px solid #000">
                <p style="font-size: 10pt; text-align: left; margin-bottom:0; padding:2px"><i>{{$branchName}} (дільниця {{$unitName}})</i></p>
            </td>
        </tr>
    </table>
    <h4 style="text-align:center; margin-top: 0; margin-bottom: 0; padding:0;">НАРЯД - ДОПУСК № {{$order->id}}</h4>
    <h5 style="text-align:center; margin-top: 0; margin-bottom: 0; padding:0;">(для виконання робіт в електроустановках)</h5>

    <table width="19cm">
        <col width="4.5cm"/>
        <col width="14cm"/>
        <tr>
            <td width="4.5cm" style="line-height:16pt; border:none;"><p
                    style="font-size: 10pt; margin-top: 0; margin-bottom:0; vertical-align: bottom">Керівнику робіт
                    (наглядачу)</p></td>
            <td width="14cm" style="line-height:16pt; border-bottom:0.5px solid #000; vertical-align: bottom;">
                <p style="font-size: 10pt; text-align: center; margin-top:0; margin-bottom: 0; line-height: 80%;">
                    <i>{{$wardenTxt}}</i></p>
            </td>
        </tr>
        <tr>
            <td height="8" style="border: none; line-height: 1pt; padding: 0;"><p
                    style="font-size: 8pt; margin-top: 0; margin-bottom: 0;"></p></td>
            <td height="8" style="border: none; line-height: 6pt; padding: 0; vertical-align: top;">
                <p style="font-size:8pt; text-align:center; margin-top:0; margin-bottom:0">(прізвище, ініціали, група з електробезпеки)</p></td>
        </tr>
    </table>

    <table width="19cm">
        <col width="3.5cm"/>
        <col width="15cm"/>
        <tr>
            <td style="line-height:70%; margin-bottom:0; border:none; vertical-align:bottom;"><p
                    style="font-size: 10pt;  margin-top: 0; margin-bottom:0;">допускачу</p></td>
            <td style="line-height:70%; border-bottom:0.5px solid #000; vertical-align: bottom;">
                <p style="font-size:10pt; text-align:center; margin-top:0; margin-bottom:0; line-height:70%;">
                    <i>{{$adjusterTxt}}</i></p></td>
        </tr>
        <tr>
            <td height="8" style="border:none; line-height: 1pt;"><p
                    style="font-size:2pt; margin-top:0; margin-bottom:0;"></p></td>
            <td height="8" style="border:none; line-height: 6pt; vertical-align:top;">
                <p style="font-size: 8pt; text-align: center; margin-top:0; margin-bottom:0; ">(прізвище, ініціали,
                    група з електробезпеки)</p></td>
        </tr>
        <tr>
            <td style="line-height: 70%; margin-bottom:0; border:none; vertical-align: center;"><p
                    style="font-size:10pt; margin-top: 0; margin-bottom:0;">з членами бригади:</p></td>
            <td style="line-height: 70%; border-bottom: 0.5px solid #000; vertical-align:bottom;">
                <p style="font-size: 10pt; text-align: left; margin-top:0; margin-bottom:0; line-height:70%;"><i>
                        <?php $brlist = ''; ?>
                        @foreach($brigadeTxt as $txt1)
                                <?php $brlist = $brlist . $txt1->body . ' ' . $txt1->group . ', '; ?>
                        @endforeach
                        @foreach($engineersTxt as $txt1)
                                <?php $brlist = $brlist . $txt1->specialization . ' ' . $txt1->body . ' ' . $txt1->group . ', '; ?>
                        @endforeach
                        {{ substr($brlist, 0, -2)}}</i></p></td>
        </tr>
        <tr>
            <td height="8" style="line-height:1pt; border:none;"><p
                    style="font-size:2pt; margin-top:0; margin-bottom:0;"></p></td>
            <td height="8" style="line-height:6pt; border:none; vertical-align:top;">
                <p style="font-size: 8pt; text-align: center; margin-top:0; margin-bottom:0;">(прізвище, ініціали, група
                    з електробезпеки)</p></td>
        </tr>
    </table>

    <table width="19cm">
        <tr>
            <td class="statistics_underlines"> доручається на:
                <u><i>{{$substationType.', '.$substationTxt.', '.$order->objects}}</i></td>
        </tr>
        <tr>
            <td style="line-height: 70%; margin-top:0; margin-bottom:0; border:none; vertical-align: center;"><p
                    style="font-size:10pt; margin-top: 0; margin-bottom:0;">виконати: <u><i>
                            {{$order->tasks}}</i></p></td>
        </tr>
    </table>


    <div class="wrap_dates">
        <div class="bblock">Роботу почати: <em>дата</em></div>
        <div class="bblock"
             style="border-bottom: 0.5px solid #000;">{{date_format(DateTime::createFromFormat('Y-m-d H:i:s',$order->w_begin), 'd.m.Y')}}</div>
        <div class="bblock"><em>час</em></div>
        <div class="bblock"
             style="margin-right: 20px; border-bottom: 0.5px solid #000;">{{date_format(DateTime::createFromFormat('Y-m-d H:i:s',$order->w_begin), 'H год. i хв.')}}</div>
        <div class="bblock">Роботу закінчити: <em>дата</em></div>
        <div class="bblock"
             style="border-bottom: 0.5px solid #000;">{{date_format(DateTime::createFromFormat('Y-m-d H:i:s',$order->w_end), 'd.m.Y')}}</div>
        <div class="bblock"><em>час</em></div>
        <div class="bblock"
             style="border-bottom: 0.5px solid #000;">{{date_format(DateTime::createFromFormat('Y-m-d H:i:s',$order->w_end), 'H год. i хв.')}}</div>
    </div>
    <br>
    <h5 style="margin-bottom: 0; line-height: 70%;">Таблиця 1</h5>
    <h5 style="margin-bottom: 0; margin-top: 0; text-align:center; line-height: 70%;">Заходи щодо підготовки робочих місць</h4>
        <table class="table_meashures" style="margin-bottom:0;">
            <thead>
            <tr valign="middle" style="line-height: 70%;">
                <th scope="col" width="280px">Назва електроустановок, у яких треба <br/> провести вимкнення і встановити
                    <br/> заземлення
                </th>
                <th scope="col" width="420px">Що повинно бути вимкнене і де заземлено</th>
            </tr>
            <tr valign="middle" style="line-height: 70%;">
                <th><em> 1 </em></th>
                <th><em> 2 </em></th>
            </tr>
            <tr valign="middle" style="line-height: 70%;">
                <td><em>  </em></td>
                <td><em>  </em></td>
            </tr>
            </thead>
            <tbody>

            @foreach($preparations as $preparation)
                <tr>
                    <td><em>{{$preparation['preparationTargetObj']}}</em></td>
                    <td><em>{{$preparation['preparationBody']}}</em></td>
                </tr>
            @endforeach
            </tbody>
        </table>
        <br>
        <table width="19cm">
            <tr>
                <td class="statistics_underlines"
                >Окремі вказівки : <u><i
                        >{{$order->sep_instrs}}</i></u></td>
            </tr>
        </table>

        <div id="order" class="wrap_dates" style="margin-top: 10px;">
            <div class="bblock">Наряд видав: <em>дата</em></div>
            <div class="bblock"
                 style="border-bottom: 0.5px solid #000;">{{date_format(DateTime::createFromFormat('Y-m-d H:i:s',$order->order_date), 'd.m.Y')}}</div>
            <div class="bblock"><em>час</em></div>
            <div class="bblock"
                 style="margin-right: 56px; border-bottom: 0.5px solid #000;">{{date_format(DateTime::createFromFormat('Y-m-d H:i:s',$order->order_date), 'H год. i хв.')}}</div>
            <div class="bblock">Підпис _______________ Прізвище, ініціали</div>
            <div class="bblock" style="border-bottom: 0.5px solid #000;"><em>{{$order->order_creator}}</em></div>
            <br>
        </div>

        <div id="orderLonged" class="wrap_dates" style="position: absolute; left: 56px; margin-top: 16px;">
            <div class="bblock">Наряд продовжив до: <em>дата</em></div>
            <div class="bblock"
                 style="border-bottom: 0.5px solid #000;">{{$orderLongedDateHtml['date']}}</div>
            <div class="bblock"><em>час</em></div>
            <div class="bblock"
                 style="margin-right: 56px; border-bottom: 0.5px solid #000;">{{$orderLongedDateHtml['time']}}</div>
            <div class="bblock">Підпис _______________ Прізвище, ініціали</div>
            <div class="bblock" style="border-bottom: 0.5px solid #000;"><em>{{$order->order_longer}}</em></div>
            <br>
        </div>
        <br>
        <h5 style="margin-bottom: 0; margin-top: 20px; line-height: 160%;">Таблиця 2</h5>
        <h5 style="margin-bottom: 0; margin-top: 0; text-align:center; line-height: 60%;">Дозвіл на підготовку робочих
            місць і на допуск</h4>

            <table class="table_meashures">
                <thead class="thead-dark">
                <tr valign="middle" style="line-height: 70%;">
                    <th scope="col" width="300px">Дозвіл на підготовку робочих місць і на допуск видав <br/> (посада,
                        прізвище або підпис)
                    </th>
                    <th scope="col" width="120px">Дата, час</th>
                    <th scope="col" width="160px">Підпис працівника, який отримав<br/>дозвіл на підготовку робочих<br/>місць
                        і на допуск
                    </th>
                </tr>
                <tr valign="middle" style="line-height: 70%;">
                    <th><em> 1 </em></th>
                    <th><em> 2 </em></th>
                    <th><em> 3 </em></th>
                </tr>
                </thead>
                <tbody>
                <tr>
                    <td><em>Mark</em></td>
                    <td><em>Otto</em></td>
                    <td><em>@mdo</em></td>
                </tr>
                </tbody>
            </table>

            <div id="end1page1" class="wrap_dates" style="margin-top: 10px;">
                <div class="bblock">Робочі місця підготовлені. Під напругою залишились:</div>
                <div class="bblock">_____________________________________________________________</div>
                <br>
            </div>
            <div id="end2page1" class="wrap_dates" style="margin-top: 30px;">
                <div class="bblock" style="margin-right: 50px;"> Допускач: _______________________</div>
                <div class="bblock"> Керівник робіт (наглядач) _____________________</div>
            </div>
            <div>
                <div style="font-size: 8pt; text-align: top; margin-left: -150px; margin-top: 40px;">(підпис)</div>
            </div>
</div>
</body>
</html>
