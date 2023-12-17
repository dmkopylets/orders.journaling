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

// set default dates
        var dateFormat = "DD-MM-YYYY HH:mm";
        var today = new Date();
//             для прикладу - якщо захочемо зразу задати кінцеву дату - цю саму, але на рік пізніше:
//             var Date222 = new Date(new Date().setYear(Datу222.getFullYear()+1));
        var todayStr = today.getDate() + '.' + ('0' + (today.getMonth() + 1)).slice(-2) + '.' + today.getFullYear() + ' ' + today.getHours() + ":" + today.getMinutes();

//    прописуємо поточну дату в усі календарики
        $("#datetime_order_created").datetimepicker({
            format: dateFormat,
            locale: 'uk',
            date: moment(todayStr, dateFormat)
        });
        //    $("#datetime_order_longed").datetimepicker({format: dateFormat, locale: 'uk', date: moment(todayStr, dateFormat)});
    });


    $(function () {
        $('#datetime_order_created').on('change.datetimepicker', function (e) {
            $("#datetime_order_created").datetimepicker('maxDate', e.date);
        });

        $('#datetime_order_longed').on('change.datetimepicker', function (e) {
            $("#datetime_order_longed").datetimepicker('minDate', e.date);
        });
    });


    // очистка полів календариків
    $("body").on("click", ".datetimepickerClear3", function (e) {
        e.preventDefault();
        var $date_order_created = $(this).closest('.input-group.date3');
        $date_order_created.datetimepicker('clear');
    });
    $("body").on("click", ".datetimepickerClear4", function (e) {
        e.preventDefault();
        var $date_order_longed = $(this).closest('.input-group.date4');
        $date_order_longed.datetimepicker('clear');
    });

    // Example starter JavaScript for disabling form submissions if there are invalid fields
    (function () {
        window.addEventListener('load', function () {
        }, false);
    })();
</script>
