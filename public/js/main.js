function create_picker_by_id(id) {

    $(function () {
        $("#" + id).datepicker({
            autoclose: true,
            format: 'dd-M-yyyy'
        });
    });


}


function set_picker_date(id, date) {
    if (date.length) {
        $(function () {
            $("#" + id).datepicker('update', date);
        });
    } else {
//        console.log("here");
//        $(function () {
//            /$("#" + id).datepicker('update');
//        });
    }

}

function random_string(n) {
    if (!n) {
        n = 5;
    }
    var text = '';
    var possible = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';

    for (var i = 0; i < n; i++) {
        text += possible.charAt(Math.floor(Math.random() * possible.length));
    }

    return text;
}

$(function () {
    $('.confirm').click(function () {
        return window.confirm("Are you sure?");
    });
});