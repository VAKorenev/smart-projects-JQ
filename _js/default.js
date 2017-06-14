var PosX = 0;
var PosY = 0;

function Update(hWnd) {

    var p_url = {};

    p_url.change_v_o_m = '/get_project_equipment.php';
    p_url.change_o_m = '/get_equipment.php';
    p_url.view_sub_works = '/get_project_works.php';
    p_url.change_sub_works = '/get_price.php';
    p_url.detail = '/get_detail.php';

    $(hWnd + " > table").empty();
    $.ajax({
        url: p_url[hWnd.substring(1)],
        type: "POST",
        data: {ID: $("#detail").data("ID")},
        dataType: "text",
        cache: false,
        success: function (data) {
            $(hWnd + " > table").append(data);
//            console.log(data);
        }});
}

function f_del_o_m(vID) {
    $.ajax({
        url: "/deleteEquipment.php",
        type: "POST",
        data: {ID: vID},
        dataType: "text",
        cache: false,
        success: function (data) {
//            console.log(data);
            Update("#change_v_o_m");
            Update("#detail");
            Load();
        }});
}

function f_delete_position(vID) {
    $.ajax({
        url: "/deleteWork.php",
        type: "POST",
        data: {ID: vID},
        dataType: "text",
        cache: false,
        success: function (data) {
//            console.log(data);
            Update("#view_sub_works");
            Update("#detail");
            Load();
        }});
}

function f_update_position(vID, Value) {
//	console.log("vID: "+vID+", Value: "+Value);
    $.ajax({
        url: "/update_position.php",
        type: "POST",
        data: {pID: vID, NUM: Value},
        dataType: "text",
        cache: false,
        success: function (data) {
//				console.log(data);
            $("#change_numeric").hide();
            Update("#view_sub_works");
            Update("#detail");
            Load();
        }});
}

function f_updateInstallation(vID, Value) {
//	console.log("vID: "+vID+", Value: "+Value);
    $.ajax({
        url: "/updateInstallation.php",
        type: "POST",
        data: {pID: vID, VAL: Value},
        dataType: "text",
        cache: false,
        success: function (data) {
//				console.log(data);
            $("#change_numeric").hide();
            Update("#view_sub_works");
            Update("#detail");
            Load();
        }});
}

function Load() {
    $.ajax({
        url: "/get_all_project.php",
        cache: false,
        success: function (html) {
            $("#data").html(html);
        }});
}


function f_update_o_m(vID, Value) {
//	console.log("vID: "+vID+", Value: "+Value);

    $.ajax({
        url: "/update_equipment_position.php",
        type: "POST",
        data: {pID: vID, NUM: Value},
        dataType: "text",
        cache: false,
        success: function (data) {
//            console.log(data);
            $("#change_numeric").hide();
            Update("#change_v_o_m");
            Update("#detail");
            Load();
        }});
}

/* Меняем Юр. лицо */
function Change_TD(sID, dbID, rParam) {
    $.ajax({
        url: "/updateOrganizationName.php",
        type: "POST",
        data: {ID: dbID, VAL: rParam},
        dataType: "text",
        cache: false,
        success: function (data) {
            $("#" + sID).text(data);
            Update('#detail');
            Load();
        }});
    $('#new_order').hide();
    $('#change_numeric').hide();
    $('#change_firm').hide();
}

/*Меняем числа*/
function f_change_int_type(hWnd) {
    if (hWnd === "#change_v_o_m") {
        $('#change_numeric').hide();
    }
}

function check(value){
    console.log($(value).zIndex());
}

$(document).ready(function () {
    
//    $(this).on('mouseover','div',function(e){
//       console.log($(this).zIndex()); 
//    });

    $('#detail').draggable({handle: "ul"});
    $('#change_o_m').draggable({handle: "ul"});
    $('#change_v_o_m').draggable({handle: "ul"});
    $('#view_sub_works').draggable({handle: "ul"});
    $('#change_sub_works').draggable({handle: "ul"});
    $('#newComment').draggable({handle: "ul"});

    $(this).keydown(function (e) { //По Esq закрыть окна

        if (e.keyCode === 27) {

            console.log($('body>div:visible:last').attr("id"));
            $('main>div:visible:last').hide(); 
            
//            $divs = ['#newComment', '#change_sub_works', '#view_sub_works', '#change_o_m', '#change_v_o_m', '#change_operator', '#change_firm', '#change_numeric', "#detail"];
//            $($divs[$divs.findIndex(function (div) {
//                return $(div).is(":visible") === true;
//            })]).hide();
        }
    });

    // Меню слева 
    $('#submenu').on("click", "a", function () {
        console.log($(this).attr("id"));

        switch ($(this).attr("id")) {
            case "get_all_projects":
                Load();
                break;
            case "create_new_project":
                console.log("new_project");
                break;
        }
        ;

    });

//    $('#detail').on("click", "li.close", function () {
//        $('#detail').hide(300);
//    });

    $('#data').on('click', 'td', function () {
        pID = $(this).data('id');
        $("#detail").data("ID", pID);
        Update("#detail");
        $("#detail").show(300,check($(this)));

        return false;
    });

    $('#Projects, #Tarrifs, #Resourses, #Reports').click(function () {
        var page = {};
        page.Projects = './_templates/menu1.html';
        page.Tarrifs = './_templates/menu2.html';
        page.Resourses = './_templates/menu3.html';
        page.Reports = './_templates/menu4.html';

//		console.log($(this).attr("ID"));
        $.ajax({
            url: "/" + page[$(this).attr("ID")],
            cache: false,
            success: function (html) {
                $("#submenu").html(html);
            }
        });
        return false;
    });

    $('#detail').on('click', 'a', function (e) {
        PosX = e.pageX;
        PosY = e.pageY;

        $("#change_numeric").hide();
        $("#change_firm").hide();
        $("#change_operator").hide();

        if ($(this).data("type") === "int") {
            $("#value_id").val($(this).text());
            $("#change_numeric").show();
            $("#change_numeric").offset({top: PosY + 10, left: PosX + 10});
        }

        if ($(this).data("type") === "firm") {
            $("#firm_name").val($(this).text());
            $("#firm_name").data("sID", $(this).attr("id"));
            $("#change_firm").show();
            $("#change_firm").offset({top: PosY + 10, left: PosX + 10});
        }

        if ($(this).data("type") === "operator") {
            $("#change_operator").show();
            $("#change_operator").offset({top: PosY + 10, left: PosX + 10});
        }

        if ($(this).data("type") === "v_o_m") {
            Update("#change_v_o_m");
            $("#change_v_o_m").show(check($(this)));
        }

        if ($(this).data("type") === "sub_works") {
            Update("#view_sub_works");
            $("#view_sub_works").show(300);
        }

        if ($(this).data("type") === "arenda") {
            showModal("#modal", function (value) {
                alert("Было введено: " + value);
            });
        }

        if ($(this).data("type") === "newComments") {
            showModal($("#newComment"), $("#sendNewMessage"), function (value) {
                $.ajax({
                    url: "/addComments.php",
                    type: "POST",
                    data: {pID: $("#detail").data("ID"), VAL: value},
                    dataType: "text",
                    cache: false,
                    success: function (data) {
                        Update('#detail');
                        console.log(data);
                    }});
            });
        }
        if ($(this).data("type") === "string") {
            showModal2($("#change_data_value"), $("#sendButton"), function (value) {
                $.ajax({
                    url: "/updateProjectName.php",
                    type: "POST",
                    data: {pID: $("#detail").data("ID"), VAL: value},
                    dataType: "text",
                    cache: false,
                    success: function (data) {
                        Update('#detail');
                        Load();
                    }});
            });
        }

        return false;
    });

    $('#change_v_o_m').on('click', 'a', function (e) {
        PosX = e.pageX;
        PosY = e.pageY;
//        console.log("TYPE: " + $(this).data("type"));

        $("#change_numeric").hide();
        $("#change_firm").hide();
        $("#change_operator").hide();

        if ($(this).data("type") === "int") {
            $("#value_id").val($(this).text());
            $("#change_numeric input").last().attr("onClick", "f_update_o_m(" + $(this).data("id") + ", $('#value_id').val())");
//			console.log("f_update_o_m("+$(this).data("id")+", $('#value_id').val())");
            $("#change_numeric").show();
            $("#change_numeric").offset({top: PosY + 10, left: PosX + 10});
        }
//        console.log("Кликнули в блоке");
        if ($(this).data("type") === "o_m") {
            Update("#change_o_m");
            $("#change_o_m").show(300);
        }

        if ($(this).data("type") === "del_o_m") {
            f_del_o_m($(this).data("id"));
//            console.log("Удаляем элемент");
        }

        return false;
    });

    $('#change_o_m').on("click", "#o_m_pos", function (e) {

//		console.log('Выбрана позиция: ' + $(this).data('id') + 'ID Проекта' + $("#detail").data("ID"));
        $.ajax({
            url: "/insert_equipment_position.php",
            type: "POST",
            data: {pID: $("#detail").data("ID"), prID: $(this).data('id')},
            dataType: "text",
            cache: false,
            success: function (data) {
                Update('#change_v_o_m');
                Update('#detail');
                Load();
//                console.log(data);
            }
        });
        return false;
    });

    $('#view_sub_works').on('click', 'a', function (e) {
        PosX = e.pageX;
        PosY = e.pageY;
//		console.log("TYPE: "+$(this).data("id"));

        $("#change_numeric").hide();
        $("#change_firm").hide();
        $("#change_operator").hide();

        /*!*/		if ($(this).data("type") === "int") {
            $("#value_id").val($(this).text());
            $("#change_numeric input").last().attr("onClick", "f_update_position(" + $(this).data("id") + ", $('#value_id').val())");
//            console.log("f_update_o_m(" + $(this).data("id") + ", $('#value_id').val())");
            $("#change_numeric").show();
            $("#change_numeric").offset({top: PosY + 10, left: PosX + 10});
        }

        if ($(this).data("type") === "change_sub_works_type") {
            Update("#change_sub_works");
            $("#change_sub_works").show(300);
        }

        if ($(this).data("type") === "del_position") {
            f_delete_position($(this).data("id"));
//            console.log("Удаляем элемент: " + $(this).data("id"));
        }

        return false;
    });

    $('#change_sub_works').on("click", "#price_pos", function () {
        $.ajax({
            url: "/insert_works_position.php",
            type: "POST",
            data: {pID: $("#detail").data("ID"), prID: $(this).data('id')},
            dataType: "text",
            cache: false,
            success: function (data) {
                Update('#view_sub_works');
                Update("#detail");
                Load();
//                console.log(data);
            }
        });
        return false;
    });

    $('#change_firm a').click(function () {
        $('#firm_name').val($(this).data("type"));
        return false;
    });
});

function showModal(ids, idButton, callback) {

    $(ids).on("keydown", function (e) {
        if (e.ctrlKey && e.keyCode === 13) {
//            console.log("Нашлась");
            complete($("#comments").val());
        }
        if (e.keyCode === 27) {
//            console.log("Нашлась");
            cancel();
        }
    });

    $(idButton).one("click", function () {
        complete($("#comments").val());
    });

    function cancel() {
//        $(ids).hide();
        $(ids).off("keydown");
        $(idButton).off("click");
        $("#comments").val("");
    }

    function complete(value) {
        $(ids).hide();
        callback(value);
        $(ids).off("keydown");
        $(idButton).off("click");
        $("#comments").val("");
    }
    $(ids).show();
    $('#comments').focus();
    $(ids).offset({top: PosY + 10, left: PosX + 10});

    return false;
}

function showModal2(ids, idButton, callback) {
    $(ids).on("keydown", function (e) {
        if (e.ctrlKey && e.keyCode === 13) {
            complete($(ids).val());
        }
        if (e.keyCode === 27) {
            cancel();
        }
    });

    $(idButton).one("click", function () {
        complete($(ids).val());
    });

    function cancel() {
        $(ids).parent().hide();
        $(ids).off("keydown");
        $(idButton).off("click");
        $(ids).val("");
    }

    function complete(value) {
        console.log('Результат: ' + value);
        $(ids).parent().hide();
        callback(value);
        $(ids).off("keydown");
        $(idButton).off("click");
        $(ids).val("");
    }
    $(ids).parent().show();
    $(ids).focus();
    $(ids).parent().offset({top: PosY + 10, left: PosX + 10});

    return false;
}