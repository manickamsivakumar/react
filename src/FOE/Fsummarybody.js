import React from "react";
import "../main.css";
import Grid from "@mui/material/Grid";
import Box from "@mui/material/Box";
import Room from "../images/ic_roomstatus.svg";
import Chart from "react-apexcharts";
import Table from "./Foesummarytable.js";
import Arrow from "../images/right_arrow.svg";
import moment from "moment";
import $ from "jquery";
import { DateTime } from "luxon";
import Calender from "../images/calendar.svg";
import Skeletons from '../Skeleton/Skeleton5.js';
function occupencycalculation(totelrooms, occupencytotel, from, to) {
  //console.log(from+''+to);
  if (from === to) {
    var differnce = 1;
  } else {
    var differnce = differncedate(from, to) + 1;
  }
  //console.log(differnce);
  var fistdividend = (totelrooms * differnce) / 100;
  var percentage = occupencytotel / fistdividend;
  return Math.ceil(percentage);
}
function differncedate(from, to) {
  var to = moment(to, "YYYY-MM-DD");
  var from = moment(from, "YYYY-MM-DD");
  var diff = to.diff(from, "days"); // 1

  return diff;
}
function otacalculation(totalrooms, value) {
  var fistdividend = Number(totalrooms) / 100;
  var percentage = Number(value) / fistdividend;
  return Math.round(percentage);
}
export default function Fsummarybody({ menuval, value, propid, propname }) {
  const [arrival, setArrival] = React.useState({});
  const [showskeletons, setShowskeletons] = React.useState(true);
  React.useEffect(() => {
    getfoedata(menuval, +value + 1);
  }, [menuval]);
  const getfoedata = (index, filtervalue) => {
    //  var dates = get_all_duration(+index + 1);
    var fromdate = index.fromdates;
    var todate = index.todates;
    $.ajax({
      url: "https://dev.skyhms.in/mob_mis_v2/arrival_filters",
      type: "post",
      data: {
        fromdate,
        todate,
        filtervalue,
        propid,
      },
      datatype: "JSON",
      beforeSend: function () {
        setShowskeletons(true);
      },
      success: function (res) {
        setArrival(JSON.parse(res));
      },
      complete: function () {
       setShowskeletons(false);
      },
      error: function () { },
    });
  };
  if (Object.keys(arrival).length > 0) {
    var totel_arrival_details = {};
    totel_arrival_details["Walk-in"] = {};
    totel_arrival_details["ota"] = {};
    totel_arrival_details["company"] = {};
    totel_arrival_details["others"] = {};
    var sales = arrival.sales;
    var occupency = arrival.occupency;
    var totalrooms = arrival.totalrooms;
    var ota_count = arrival.ota;
    //	var ota_totalcount = 0;
    //	$.each(ota_count, function (key, value) {
    //	ota_totalcount += Number(value);
    //	});

    //var totalota = [];

    var otaname = Object.keys(ota_count);
    var otacount = [];

    $.each(ota_count, function (key, value) {
      otacount.push(Number(value));
    });

    $.each(sales, function (key, value) {
      if (Number(key) == 1) {
        totel_arrival_details["Walk-in"]["sales"] = value["sales"];
      } else if (Number(key) == 3) {
        totel_arrival_details["ota"]["sales"] = value["sales"];
      } else if (Number(key) == 5) {
        totel_arrival_details["company"]["sales"] = value["sales"];
      } else {
        totel_arrival_details["others"]["sales"] = value["sales"];
      }
    });

    $.each(occupency, function (key, value) {
      if (Number(key) == 1) {
        totel_arrival_details["Walk-in"]["arr"] = Math.ceil(
          Number(value["totel"]) / Number(value["count"])
        );
        //totel_arrival_details['Walk-in']['sales']=value['sales'];totalrooms
        totel_arrival_details["Walk-in"]["occu"] = occupencycalculation(
          totalrooms,
          Number(value["count"]),
          menuval.fromdates,
          menuval.todates
        );
      } else if (Number(key) == 3) {
        totel_arrival_details["ota"]["arr"] = Math.ceil(
          Number(value["totel"]) / Number(value["count"])
        );
        totel_arrival_details["ota"]["occu"] = occupencycalculation(
          totalrooms,
          Number(value["count"]),
          menuval.fromdates,
          menuval.todates
        );
      } else if (Number(key) == 5) {
        totel_arrival_details["company"]["arr"] = Math.ceil(
          Number(value["totel"]) / Number(value["count"])
        );
        totel_arrival_details["company"]["occu"] = occupencycalculation(
          totalrooms,
          Number(value["count"]),
          menuval.fromdates,
          menuval.todates
        );
      } else {
        totel_arrival_details["others"]["arr"] = Math.ceil(
          Number(value["totel"]) / Number(value["count"])
        );
        totel_arrival_details["others"]["occu"] = occupencycalculation(
          totalrooms,
          Number(value["count"]),
          menuval.fromdates,
          menuval.todates
        );
      }
    });
  }
  console.log(totel_arrival_details, "arrivaldetails");
  var tabledata = [];
  var donut_occu = [];
  var donut_label = [];

  $.each(totel_arrival_details, function (key, value) {
    var occupency = !value["occu"] ? 0 : value["occu"];
    donut_label.push(key);
    donut_occu.push(occupency);
    var sales = !value["sales"] ? 0 : value["sales"];
    var arr = !value["arr"] ? 0 : value["arr"];
    tabledata.push(
      <tr>
        <td style={{ textAlign: "left" }}>{key}</td>
        <td style={{ textAlign: "right" }}>{occupency}</td>
        <td style={{ textAlign: "right" }}>{Math.round(sales)}</td>
        <td style={{ textAlign: "right" }}>{Math.round(arr)}</td>
      </tr>
    );
  });
  var otadata = {};
  if (arrival.hasOwnProperty("ota")) {
    if (Object.keys(arrival.ota).length > 5) {
      var fst4data = Object.entries(arrival.ota).filter(([skey, sval], key) => {
        if (key <= 3) {
          return [skey, Number(sval)];
        }
      });
      fst4data = Object.fromEntries(fst4data);
      var lastdata = Object.entries(arrival.ota).filter(([skey, sval], key) => {
        if (key > 3) {
          return [skey, Number(sval)];
        }
      });

      lastdata = Object.fromEntries(lastdata);
      var othersdata = Object.values(lastdata).reduce((acc, current) => {
        return Number(acc) + Number(current);
      });

      otadata = { ...fst4data, OTHERS: othersdata };
    } else {
      otadata = { ...arrival.ota };
    }
  }

  var otavalues = [];
  if (Object.keys(otadata).length > 0) {
    otavalues = Object.values(otadata).map((val, key) => {
      return Number(val);
    });
  }

  const data = {
    series: donut_occu,
    options: {
      dataLabels: {
        enabled: false,
      },
      colors: ["#F5D5BA", "#F5BABE", "#D1BAF5", "#84F590", "#7FEAF5"],
      labels: donut_label,
      chart: {
        type: "donut",
      },
      legend: {
        show: false,
        position: "bottom",
        width: 120,
      },
      plotOptions: {
        pie: {
          donut: {
            size: "75%",
            labels: {
              show: true,
              style: {
                fontSize: "18px",
              },
              total: {
                show: true,
                label: "Occupancy",
                fontSize: 12,
                formatter: () => "32%",
              },
            },
          },
        },
      },
      responsive: [
        {
          breakpoint: 480,
          options: {
            chart: {
              width: 200,
            },
            legend: {
              position: "bottom",
            },
          },
        },
      ],
    },
  };
  const otagraphdata = {
    series: otavalues,
    options: {
      dataLabels: {
        enabled: false,
      },
      colors: ["#F5D5BA", "#F5BABE", "#D1BAF5", "#84F590", "#7FEAF5"],
      labels: Object.keys(otadata),
      chart: {
        type: "donut",
      },
      legend: {
        show: false,
        position: "bottom",
        width: 120,
      },
      plotOptions: {
        pie: {
          donut: {
            size: "75%",
            labels: {
              show: true,
              style: {
                fontSize: "18px",
              },
            },
          },
        },
      },
      responsive: [
        {
          breakpoint: 480,
          options: {
            chart: {
              width: 190,
            },
            legend: {
              position: "bottom",
            },
          },
        },
      ],
    },
  };

  var colors = ["#F5D5BA", "#F5BABE", "#D1BAF5", "#84F590", "#7FEAF5"];
  var i = 0;
  var count = Object.values(otadata).length;
  function wraptext(text, maxlen) {
    var str = text;
    if (text.length > maxlen) {
      str = text.substring(0, maxlen) + "...";
    }
    return str;
  }
  var daterangespan =
    DateTime.fromISO(new Date(menuval.fromdates).toJSON()).toFormat(
      "MMM d, yyyy"
    ) +
    "-" +
    DateTime.fromISO(new Date(menuval.todates).toJSON()).toFormat(
      "MMM d, yyyy"
    );
  
  return (
  <>
    { showskeletons ? <Skeletons/> :
  <Box style={{ margin: "10px 10px 75px 10px" }}>
    <Grid
      container
      item
      xs={12}
      className="daterange-header"
      style={{ width: "fit-content", marginBottom: "15px" }}
    >
      <div>
        <img height="25" width="25" src={Calender} alt="calender" />
        <span
          className="hotel-header-title1"
          style={{ textAlign: "center", marginLeft: "10px" }}
        >
          {daterangespan}
        </span>
      </div>
    </Grid>
         
    <Box className="fsummay-section">
      <Box style={{ padding: "10px" }}>
        <Grid container style={{ padding: "15px 15px 0px 15px" }}>
          <Grid item xs={1}>
            <div className="roomsection1">
              <img src={Room} />
            </div>
          </Grid>
          <Grid
            item
            xs={7}
            className="fsec-body-header"
            style={{ paddingLeft: "10px" }}
          >
            <span className="sales-section-text">Arrival Details</span>
          </Grid>
          <Grid item xs={4} className="fsec-body-header1"></Grid>
        </Grid>
      </Box>
      <Box>
        <Grid
          container
          direction="column"
          alignItems="center"
          justifyContent="center"
        >
          <Grid item xs={6}>
            <Chart options={data.options} series={data.series} type="donut" />
          </Grid>
        </Grid>
      </Box>
      <Box>
        <Grid container item xs={12}>
          <table style={{ width: "100%" }}>
            <thead className="table-thead">
              <tr>
                <th className="text-left">Mode</th>
                <th className="text-right">Occu %</th>
                <th className="text-right">Sales</th>
                <th className="text-right">ARR</th>
              </tr>
            </thead>
            <tbody className="table-tbody">{tabledata}</tbody>
          </table>
        </Grid>
      </Box>
    </Box>

    {Object.keys(otavalues).length > 0 ? (
      <Box className="fsec-body">
        <Grid container item xs={12}>
          <Grid container className="">
            <Grid item xs={1} className="fsec-body-header11">
              <div className="roomsection1">
                <img src={Room} />
              </div>
            </Grid>
            <Grid
              item
              xs={8}
              className="fsec-body-header"
              style={{ paddingLeft: "10px" }}
            >
              <span className="Room-status"> OTA performance</span>
            </Grid>

            <Grid item xs={3} className="fsec-body-header1"></Grid>
          </Grid>
        </Grid>
        <Grid container item xs={12} style={{alignItems:'center',minHeight:'210px'}}>
          <Grid item xs={6}>
            <div className="fsec-body-header2" style={{ height: "100%" }}>
              <Chart
                options={otagraphdata.options}
                series={otagraphdata.series}
                type="donut"
              />
            </div>
          </Grid>
          <Grid item xs={6}>
            {Object.keys(otadata).map((sts, key) => {
              i++;
              return (
                <Grid
                  container
                  className={i != count ? "border-bottom" : ""}
                  style={{ margin: "15px 0px", padding: "1px 0px" }}
                >
                  <Grid item xs={2} className="fsec-body-header">
                    <div>
                      <div
                        className="circle"
                        style={{ backgroundColor: colors[key] }}
                      ></div>
                    </div>
                  </Grid>
                  <Grid item xs={6} className="fsec-body-header">
                    <span className="Room-status-text">
                      {wraptext(sts, 15)}
                    </span>
                  </Grid>

                  <Grid item xs={4} className="fsec-body-header1">
                    <span className="roomstatus_count">{otavalues[key]}</span>
                  </Grid>
                </Grid>
              );
            })}
          </Grid>
        </Grid>
      </Box>
    ) : (
      ""
    )}
  </Box>
  }
  </>
  );
}
