import $ from "jquery";

const Apicallprocess = (callurl, data = {}, method = "POST") => {
    return new Promise((resolve) => {
        var retkval = false;
        $.ajax({
            url: callurl,
            async: false,
            type: method,
            data: { postdetails: data },
            dataType: "json",
            success: function (response) {
                if (response) {
                    retkval = response;
                } else {
                    retkval = 0;
                }
            },
            error: function () {
                retkval = 0;
            },
            beforeSend: function (log) {
                //loadfunc(1);
            },
            complete: function (log) {
                //loadfunc(0);
            },
        });
        resolve(retkval);
    });
};

export default Apicallprocess;

