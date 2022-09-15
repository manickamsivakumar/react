$(document).ready(function () {
    // alert('test');


    defaultfunc();



});


const defaultfunc = () => {
    let today = new Date().toISOString().slice(0, 10)
    var propid = $("#propid").val();
    ajaxcall(today, propid);


};


const ajaxcall = (today, propid) => {


    $.ajax({
        url: "getcheckin",
        type: "POST",
        datatype: "JSON",
        data: {
            today: today,
            propid: propid,
        },
        success: function (response) {
            // console.log(response);

            var response = JSON.parse(response);
            console.log(response);

            if (response) {
                //  const incomeobj=response.income;
                //const expenceobj=response.expence;
                var str="";
                if((Object.keys(response.occupancy).length)>0){
                    $.each(response.occupancy,function(key,value){
                    
                        str += '<div class="row occupancylist" id="guest_'+value['checkinroomtrnid']+'" style="margin-bottom:15px;">';
                        str += '<div class="col-6 fodiv"><span class="occupancyname" style="color:gray;font-size: 18px;">'+ value['roomguestname']+'</span></div>';
                        str += '<div class="col-6 sodiv">Plan:<span class="occupancytext">'+ value['planname']+'</span></div>';
                        str += '<div class="col-6 todiv">Room No:<span class="occupancytext">'+ value['roomno']+'</span></div>';
                        str += '<div class="col-6 ftodiv"><span class="occupancytext">'+ value['arrivalmode']+'</span></div>';
                            
                         str += '</div>';
                         
    
                    });
                }else{


                    str += '<p>No Records Found!!!' ;
                }
              
               
                $("#currentoccupancysection").empty();
                $("#currentoccupancysection").append(str);
                var props = "";
				props += '<div class="hh" id="propname">' +response.data.propname + '</div>';
				props += '<div class="hsh" id="propcity">' +response.data.propcity + '</div>';
				$("#property_details").empty();
				$("#property_details").append(props);
				$(".nbc").css("background-color",response.data.propcolor);

                $(".occupancylist").on("click",function(){
                    
                var trnid=$(this).attr("id").replace("guest_","");
                location.href = 'indivguest?trnid=' + trnid + '&propid=' + propid;
                
                });
                
            }


        },
        error: function (error) {

            alert("alert error");

        }





    });


}

function flcapitalize(string) {
    var cstring = string.charAt(0).toUpperCase() + string.slice(1);
    return cstring;
}
