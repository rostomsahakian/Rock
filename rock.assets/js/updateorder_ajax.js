$(document).ready(function () {
    $("#do_update_order").click(function () {

        $("input[type='text']").each(function () {
            var new_order = $("input[id='new_order_" + this.id + "']").val();
            console.log(new_order);

            $.ajax({
                type: "POST",
                url: "../rock.admin/?cmd=edit_page",
                data: {new_order: new_order},
                dataType: "html", // type of returned data
                success: function (msg) {
                    if (msg === "") {
                        console.log("nothing recived " + new_order);
                    } else if (msg.substr(0, 1) == "1") {
//                    $("#showres_mens").html("<div class='alert alert-success' role='alert' id='errors'>" + brand + " was added to the list of top " + gender + " collections.</div>");
                    } else if (msg.substr(0, 1) == "2") {
//                    $("#showres_mens").html("<div class='alert alert-danger' role='alert' id='errors'>Please select a brand</div>");
                    } else if (msg.substr(0, 1) == "3") {
//                    $("#showres_mens").html("<div class='alert alert-danger' role='alert' id='errors'>You have already selected 10 brands for " + gender + ".</div>");

                    } else {
//                    $("#showres_mens").html("<div class='alert alert-danger' role='alert' id='errors'>" + brand + " is already in your top " + gender + " collections.</div>");
                    }
                }
            })
        });

    });
});

