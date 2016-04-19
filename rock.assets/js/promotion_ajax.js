
$(document).ready(function () {
    $('select.brand').on('change', function () {
        var brand = $(this).val();
        var gender = $("input#gen").val();

        $.ajax({
            type: "POST",
            url: "../rock.admin/?cmd=b_promotion",
            data: {brand: brand, gender: gender},
            dataType: "html", // type of returned data
            success: function (msg) {
                if (msg === "") {
                    console.log("nothing recived " + brand + " " + gender);
                } else if (msg.substr(0, 1) == "1") {
                    $("#showres_mens").html("<div class='alert alert-success' role='alert' id='errors'>" + brand + " was added to the list of top " + gender + " collections.</div>");
                } else if (msg.substr(0, 1) == "2") {
                    $("#showres_mens").html("<div class='alert alert-danger' role='alert' id='errors'>Please select a brand</div>");
                } else if (msg.substr(0, 1) == "3") {
                    $("#showres_mens").html("<div class='alert alert-danger' role='alert' id='errors'>You have already selected 10 brands for "+gender+".</div>");

                } else {
                    $("#showres_mens").html("<div class='alert alert-danger' role='alert' id='errors'>" + brand + " is already in your top " + gender + " collections.</div>");
                }
            }
        })
    });
});



$(document).ready(function () {
    $('select.brand_w').on('change', function () {
        var brand = $(this).val();
        var gender = $("input#gen_w").val();

        $.ajax({
            type: "POST",
            url: "../rock.admin/?cmd=b_promotion",
            data: {brand: brand, gender: gender},
            dataType: "html", // type of returned data
            success: function (msg) {
                if (msg === "") {
                    console.log("nothing recived " + brand + " " + gender);
                } else if (msg.substr(0, 1) == "1") {
                    $("#showres_womens").html("<div class='alert alert-success' role='alert' id='errors'>" + brand + " was added to the list of top " + gender + " collections.</div>");
                } else if (msg.substr(0, 1) == "2") {
                    $("#showres_womens").html("<div class='alert alert-danger' role='alert' id='errors'>Please select a brand</div>");
                } else if (msg.substr(0, 1) == "3") {
                    $("#showres_womens").html("<div class='alert alert-danger' role='alert' id='errors'>You have already selected 10 brands for "+gender+".</div>");

                } else {
                    $("#showres_womens").html("<div class='alert alert-danger' role='alert' id='errors'>" + brand + " is already in your top " + gender + " collections.</div>");
                }
            }
        })
    });
});


$(document).ready(function () {
    $('select.brand_b').on('change', function () {
        var brand = $(this).val();
        var gender = $("input#gen_b").val();

        $.ajax({
            type: "POST",
            url: "../rock.admin/?cmd=b_promotion",
            data: {brand: brand, gender: gender},
            dataType: "html", // type of returned data
            success: function (msg) {
                if (msg === "") {
                    console.log("nothing recived " + brand + " " + gender);
                } else if (msg.substr(0, 1) == "1") {
                    $("#showres_boys").html("<div class='alert alert-success' role='alert' id='errors'>" + brand + " was added to the list of top " + gender + " collections.</div>");
                } else if (msg.substr(0, 1) == "2") {
                    $("#showres_boys").html("<div class='alert alert-danger' role='alert' id='errors'>Please select a brand</div>");
                } else if (msg.substr(0, 1) == "3") {
                    $("#showres_boys").html("<div class='alert alert-danger' role='alert' id='errors'>You have already selected 10 brands for "+gender+".</div>");

                } else {
                    $("#showres_boys").html("<div class='alert alert-danger' role='alert' id='errors'>" + brand + " is already in your top " + gender + " collections.</div>");
                }
            }
        })
    });
});

$(document).ready(function () {
    $('select.brand_g').on('change', function () {
        var brand = $(this).val();
        var gender = $("input#gen_g").val();

        $.ajax({
            type: "POST",
            url: "../rock.admin/?cmd=b_promotion",
            data: {brand: brand, gender: gender},
            dataType: "html", // type of returned data
            success: function (msg) {
                if (msg === "") {
                    console.log("nothing recived " + brand + " " + gender);
                } else if (msg.substr(0, 1) == "1") {
                    $("#showres_girls").html("<div class='alert alert-success' role='alert' id='errors'>" + brand + " was added to the list of top " + gender + " collections.</div>");
                } else if (msg.substr(0, 1) == "2") {
                    $("#showres_girls").html("<div class='alert alert-danger' role='alert' id='errors'>Please select a brand</div>");
                } else if (msg.substr(0, 1) == "3") {
                    $("#showres_girls").html("<div class='alert alert-danger' role='alert' id='errors'>You have already selected 10 brands for "+gender+".</div>");

                } else {
                    $("#showres_girls").html("<div class='alert alert-danger' role='alert' id='errors'>" + brand + " is already in your top " + gender + " collections.</div>");
                }
            }
        })
    });
});