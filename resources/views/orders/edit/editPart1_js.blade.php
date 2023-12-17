<!-- Bootstrap & JQuery core JavaScript -->
<!-- Placed at the end of the document so the pages load faster -->

<script type="text/javascript" src="{{asset('js/jquery.min.js')}}"
        integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>
<script type="text/javascript" src="{{ asset('js/jquery-ui.min.js')}}"></script>
<script type="text/javascript" src="{{ asset('js/popper.min.js')}}"
        integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN"
        crossorigin="anonymous"></script>
<script>window.jQuery || document.write('<script src="{{ asset('js\/jquery.min.js')}}"><\/script>')</script>

<script type="text/javascript" src="{{asset('js/moment.js')}}"></script>
<script type="text/javascript" src="{{asset('js/moment_uk_locale.js')}}"></script>

<script type="text/javascript" src="{{asset('js/bootstrap-select.min.js')}}"></script>
<script type="text/javascript" src="{{asset('js/bootstrap-select_defaults-ua_UA.js')}}"></script>

<script type="text/javascript" src="{{asset('js/bootstrap.min.js')}}"
        integrity="sha384-B4gt1jrGC7Jh4AgTPSdUtOBvfO8shuf57BaghqFfPlYxofvL8/KUEfYiJOMMV+rV"
        crossorigin="anonymous"></script>
<script type="text/javascript" src="{{asset('js/tempusdominus-bootstrap-4.min.js')}}"></script>


<script type="text/javascript">
    $(document).ready(function () { // що виконується "автоматом"
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        brig_engr_checked(); //в режимі клонування (редагування) прописуємо id членів бригади в приховані поля для запису в db
// set default dates
        var dateFormat = "DD-MM-YYYY HH:mm";
        var today = new Date();
//             для прикладу - якщо захочемо зразу задати кінцеву дату - цю саму, але на рік пізніше:
//             var Date222 = new Date(new Date().setYear(Datу222.getFullYear()+1));
        var todayStr = today.getDate() + '.' + ('0' + (today.getMonth() + 1)).slice(-2) + '.' + today.getFullYear() + ' ' + today.getHours() + ":" + today.getMinutes();

//    прописуємо поточну дату в усі календарики
        $("#datetime_work_begin").datetimepicker({
            format: dateFormat,
            locale: 'uk',
            date: moment(todayStr, dateFormat)
        });
        $("#datetime_work_end").datetimepicker({format: dateFormat, locale: 'uk', date: moment(todayStr, dateFormat)});
    });

    var task_txt = '';
    var obj_txt = '';

    //  Визначаємо обране із випадаючого списку завдання
    function getSelectedTask() {
//   отримуємо індекс обраного елемента
        var selind = document.getElementById("selectTask").options.selectedIndex;
        task_txt = task_txt + ',' + document.getElementById("selectTask").options[selind].text;
        workslist.value = 'На ' + obj_txt + ' виконати ' + task_txt.replace(/^,*/, "");  //Видалення всіх ком на початку        Приклад : s = s.replace(/^,*/,"");
    }

    //  Визначаємо обрану із випадаючого  списку підстанцію
    function getSelectedSubstation() {
//   отримуємо індекс обраного елемента
        var selind = document.getElementById("substationDialer").options.selectedIndex;
        obj_txt = document.getElementById("substationDialer").options[selind].text;
        workslist.value = 'На ' + obj_txt + ' виконати ' + task_txt;

    }

    //  Визначаємо обрану із випадаючого списку лінію
    function getSelectedLine() {
//   отримуємо індекс обраного елемента
        var selind = document.getElementById("selectLine").options.selectedIndex;
        obj_txt = obj_txt + ', ПЛ ' + document.getElementById("selectLine").options[selind].text;
        workslist.value = 'На ' + obj_txt + ' виконати ' + task_txt;
    }


    $(function () {
        $("#datetime_work_begin").on("change.datetimepicker", function (e) {
            $('#datetime_work_end').datetimepicker('minDate', e.date);
        });

        $('#datetime_work_end').on('change.datetimepicker', function (e) {
            $("#datetime_work_begin").datetimepicker('maxDate', e.date);
        });
    });


    // очистка полів календариків
    $("body").on("click", ".datetimepickerClear1", function (e) {
        e.preventDefault();
        var $date_work_begin = $(this).closest('.input-group.date1');
        $date_work_begin.datetimepicker('clear');
    });
    $("body").on("click", ".datetimepickerClear2", function (e) {
        e.preventDefault();
        var $date_work_end = $(this).closest('.input-group.date2');
        $date_work_end.datetimepicker('clear');
    });


    // Заповнення текстового поля "з членами бригади" тиканням чекбоксів у правй частині форми
    function brig_engr_checked() {
        var i1 = 0;
        var i2 = 0;
        // check-нувся якийсь член бригади
        var text_br_all = '';
        var text_br_all_id_to_write_on_db = '';
        var text_engr_all = '';
        var text_engr_all_id_to_write_on_db = '';

        @foreach($allPossibleTeamMembers as $teamMember)
        if (document.getElementById("teamMember{{$teamMember['id']}}").checked == true) {
            i1++;
            text_br_all = text_br_all + ', {{$teamMember['body'] . ' ' . $teamMember['group']}}';
            text_br_all_id_to_write_on_db = text_br_all_id_to_write_on_db + ',{{$teamMember['id']}}';
        }
        @endforeach

        // check-нувся якийсь стропальщик
        @foreach($allPossibleTeamEngineer as $engineer)
        if (document.getElementById("engineer{{$engineer['id']}}").checked == true) {
            i2++;
            text_engr_all = text_engr_all + ', {{$engineer['specialization'] . ' ' . $engineer['body'] . ' ' . $engineer['group']}}';
            text_engr_all_id_to_write_on_db = text_engr_all_id_to_write_on_db + ',{{$engineer['id']}}';
        }
        @endforeach
        document.getElementById("countBrigade").textContent = i1 + i2;
//                        //Видалення всіх ком на початку        Приклад : s = s.replace(/^,*/,"");
        text_br_all = text_br_all.replace(/^,*/, "");
        if (text_br_all.length > 0) {
            text_engr_all = ', ' + text_engr_all;
        }
        text_br_all = text_br_all + text_engr_all.replace(/^,*/, "");

        document.getElementById("brigade_members").value = text_br_all.trim();
        document.getElementById("write_to_db_brigade").value = text_br_all_id_to_write_on_db.replace(/^,*/, "");
        document.getElementById("write_to_db_engineers").value = text_engr_all_id_to_write_on_db.replace(/^,*/, "");
    }
    // кінець "Заповнення текстового поля "з членами бригади" тиканням чекбоксів у правй частині форми"


    // Example starter JavaScript for disabling form submissions if there are invalid fields
    (function () {
        window.addEventListener('load', function () {

        }, false);
    })();

</script>
