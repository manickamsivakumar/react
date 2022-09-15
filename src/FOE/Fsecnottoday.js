import React, { useState } from "react";
import "../main.css";
import Grid from "@mui/material/Grid";
import Box from "@mui/material/Box";

import Arrow from "../images/right_arrow.svg";
import Sales from "../images/ic_sales.svg";
import Revenue from "../images/ic_revenue.svg";
import Room from "../images/ic_roomstatus.svg";
import Skelt1 from "../Skeleton/Skeletondiv3.js";
import Chart from "react-apexcharts";
import $ from "jquery";
import moment from "moment";
import { DateTime } from "luxon";
import Calender from "../images/calendar.svg";

function formatNum(numb) {
  let num = Number(numb).toLocaleString('en-IN', {
    minimumFractionDigits: 2,
    maximumFractionDigits: 2
});
  return num;
}
export default function Fsecnottoday({ menuval, value, propid }) {
  const [nottodaysales, setNottodaysales] = useState({});
  const [showskel, setShowskel] = useState(1);
  React.useEffect(() => {
    getfoedata(menuval, +value + 1);
  }, [menuval]);
  const getfoedata = (index, filtervalue) => {
    //  var dates = get_all_duration(+index + 1);
    var fromdate = index.fromdates;
    var todate = index.todates;
    var diffday = getdiffernce(menuval.fromdates, menuval.todates);
    //  console.log(diffday, "3");
    var groupbyflag = 0;
    if (diffday > 31 && diffday <= 365) {
      groupbyflag = 1;
    } else if (diffday > 365) {
      groupbyflag = 2;
    } else {
      groupbyflag = 0;
    }
    $.ajax({
      url: "https://dev.skyhms.in/mob_mis_v2/subfilters",
      type: "post",
      data: {
        fromdate,
        todate,
        filtervalue,
        propid,
        groupbyflag,
      },
      datatype: "JSON",
      beforeSend: function () {
        setShowskel(1);
      },
      success: function (res) {
        setNottodaysales(JSON.parse(res));
      },
      complete: function () {
        setShowskel(0);
      },
      error: function () {},
    });
  };
  console.log(showskel, "slet");
  var sales = 0;
  if (nottodaysales.hasOwnProperty("checkout")) {
    sales = Object.values(nottodaysales.sales).reduce((total, current) => {
      return Number(current) + Number(total);
    }, 0);
  }
  var othersales = 0;
  if (nottodaysales.hasOwnProperty("othersales")) {
    othersales = Object.values(nottodaysales.othersales).reduce(
      (total, current) => {
        return Number(current) + Number(total);
      },
      0
    );
  }
  var revenuetotal = 0;
  var cash = 0;
  var card = 0;
  var bank = 0;
  if (nottodaysales.hasOwnProperty("revenue")) {
    $.each(nottodaysales.revenue, function (key, val) {
      if (val.hasOwnProperty("cash")) {
        cash += Number(val["cash"]);
      }
      if (val.hasOwnProperty("card")) {
        card += Number(val["card"]);
      }
      if (val.hasOwnProperty("bank")) {
        bank += Number(val["bank"]);
      }
      if (val.hasOwnProperty("totel")) {
        revenuetotal += Number(val["totel"]);
      }
    });
  }
  var totalsales = Number(sales) + Number(othersales);
  var soldnights = 0;
  var noofdays = 0;
  if (nottodaysales.hasOwnProperty("sales")) {
    noofdays = Object.keys(nottodaysales.sales).length;
  }
  if (nottodaysales.hasOwnProperty("occupiedroomcount")) {
    soldnights = Object.values(nottodaysales.occupiedroomcount).reduce(
      (total, current) => {
        return Number(current) + Number(total);
      },
      0
    );
  }
  var arrtotal = 0;
  if (nottodaysales.arr) {
    arrtotal = Number(nottodaysales.arr);
  }
  var arr = +arrtotal / +soldnights;

  var totalrooms = Number(nottodaysales.totalrooms);

  var percentagecal = Number(totalrooms) * Number(noofdays);
  var perc = (Number(soldnights) / percentagecal) * 100;
  perc = perc.toFixed(0);
  perc = Number(perc);
  const rmsts = ["Dirty", "Vacant", "Occupied", "Block", "Maintenance"];
  var colors = ["#F5D5BA", "#F5BABE", "#D1BAF5", "#84F590", "#7FEAF5"];
  function getWeekOfMonth(date) {
    var eightFeb2014 = moment(date);
    return Math.ceil(eightFeb2014.date() / 7);
  }
  function getdiffernce(from, to) {
    //console.log(from);
    // console.log(to);
    if (from === to) {
      var differnce = 1;
    } else {
      var differnce = differncedate(from, to) + 1;
    }
    return differnce;
  }
  function differncedate(from, to) {
    var to = moment(to, "YYYY-MM-DD");
    var from = moment(from, "YYYY-MM-DD");
    var diff = to.diff(from, "days"); // 1

    return diff;
  }
  Date.prototype.addDays = function (days) {
    var date = new Date(this.valueOf());
    date.setDate(date.getDate() + days);
    //alert(date);
    return date;
  };
  function getYears(from, to) {
    var d1 = new Date(from),
      d2 = new Date(to),
      yr = [];

    for (var i = d1.getFullYear(); i <= d2.getFullYear(); i++) {
      yr.push(i);
    }

    return yr;
  }

  function getDates(startDate, endDate) {
    // console.log(startDate,endDate);
    var addFn = Date.prototype.addDays;
    var interval = 1;

    var retVal = [];
    var current = new Date(startDate);
    endDate = new Date(endDate);
    while (current <= endDate) {
      var d = new Date(current).toJSON().slice(0, 10).replace(/-/g, "-");
      retVal.push(d);
      current = addFn.call(current, interval);
    }
    return retVal;
  }
  Date.prototype.addMonth = function (days) {
    var date = new Date(this.valueOf());
    date.setMonth(date.getMonth() + days);
    //alert(date);
    return date;
  };

  function getMonth(startDate, endDate) {
    var addFn = Date.prototype.addMonth;
    var interval = 1;

    var retVal = [];
    var current = new Date(startDate);
    endDate = new Date(endDate);
    while (current <= endDate) {
      var d = new Date(current).toJSON().slice(0, 7).replace(/-/g, "-");
      retVal.push(d);
      current = addFn.call(current, interval);
    }
    return retVal;
  }
  var diffday = getdiffernce(menuval.fromdates, menuval.todates);

  var groupbyflag = 0;
  if (diffday > 31 && diffday <= 365) {
    groupbyflag = 1;
  } else if (diffday > 365) {
    groupbyflag = 2;
  } else {
    groupbyflag = 0;
  }
  switch (Number(groupbyflag)) {
    case 0:
      var datearray = getDates(menuval.fromdates, menuval.todates); // create a array of from to todate array for graphlabel

      break;

    case 1:
      var datearray = getMonth(menuval.fromdates, menuval.todates);

      break;
    case 2:
      var datearray = getYears(menuval.fromdates, menuval.todates);

      break;
  }
  //console.log(filterdata, "filterdata");
  var alldata = {};
  if (nottodaysales.hasOwnProperty("occupiedroomcount")) {
    if (diffday >= 1 && diffday <= 7) {
      var dayobj = {
        0: "Sun",
        1: "Mon",
        2: "Tue",
        3: "Wed",
        4: "Thu",
        5: "Fri",
        6: "Sat",
      };

      // console.log(graphmode);
      var proprdata = {};
      var category = [];

      $.each(datearray, function (datekey, dateval) {
        var dayname = new Date(dateval);
        var dayval = dayname.getDay();
        if (Object.keys(nottodaysales.occupiedroomcount).includes(dateval)) {
          proprdata[dayobj[dayval]] = +nottodaysales.occupiedroomcount[dateval];
        } else {
          proprdata[dayobj[dayval]] = 0;
        }
      });

      var category = Object.keys(proprdata);

      alldata = {
        series: [
          {
            name: "Occupancy",
            data: Object.values(proprdata),
          },
        ],
        options: {
          chart: {
            type: "bar",
            height: 350,
            width: "400px",
            toolbar: {
              show: false,
            },
          },
          plotOptions: {
            bar: {
              horizontal: false,
              columnWidth: "80%",
              endingShape: "rounded",
            },
          },
          dataLabels: {
            enabled: false,
          },
          stroke: {
            show: true,
            width: 2,
            colors: ["transparent"],
          },
          yaxis: {
            tickAmount: 3,

            labels: {
              show: true,
              align: "right",

              style: {
                colors: ["#ccc"],
                fontSize: "12px",
                fontFamily: "Sofia Pro",
                fontWeight: 400,
                cssClass: "apexcharts-yaxis-label",
              },
              offsetX: 0,
              offsetY: 0,
              rotate: 0,
              formatter: (value) => {
                var cnt = value.toString().length;
                var str = value;
                if (cnt === 4 || cnt === 5) {
                  str = Number(value / 1000).toFixed(0) + "K";
                } else if (cnt === 7 || cnt === 6) {
                  str = Number(value / 100000).toFixed(0) + "L";
                } else if (cnt > 7) {
                  str = Number(value / 10000000).toFixed(0) + "Cr";
                }
                return str;
              },
            },
          },
          xaxis: {
            categories: category,

            show: false,

            labels: {
              show: true,
              style: {
                fontFamily: "Sofia Pro",

                cssClass: "apexcharts-xaxis-label",
              },
            },
            axisBorder: {
              show: false,
            },
            axisTicks: {
              show: false,
            },
          },

          legend: {
            position: "top",
            horizontalAlign: "right",
            markers: {
              width: 8,
              height: 8,
            },
          },
          fill: {
            opacity: 0.7,
          },

          grid: {
            show: false,
          },
          bar: {
            borderRadius: "10%",
          },
          tooltip: {
            y: {
              formatter: function (val) {
                return "" + val;
              },
            },
            x: {
              show: true,

              formatter: function (val) {
                return "" + val;
              },
            },
          },
        },
      };
    } else if (diffday >= 8 && diffday <= 31) {
      var proprdata = {};
      var category = [];

      $.each(datearray, function (datekey, dateval) {
        if (Object.keys(nottodaysales.occupiedroomcount).includes(dateval)) {
          proprdata[dateval] = +nottodaysales.occupiedroomcount[dateval];
        } else {
          proprdata[dateval] = 0;
        }
      });

      var getweekarray = {};
      var monthobj = {
        "01": "Jan",
        "02": "Feb",
        "03": "Mar",
        "04": "Apr",
        "05": "May",
        "06": "Jun",
        "07": "Jul",
        "08": "Aug",
        "09": "Sept",
        10: "Oct",
        11: "Nov",
        12: "Dec",
      };

      $.each(datearray, function (key, value) {
        var splivaluee = value.split("-");
        getweekarray[value] =
          monthobj[value.substring(5, 7)] +
          "-" +
          getWeekOfMonth(
            splivaluee[0] + "-" + splivaluee[1] + "-" + splivaluee[2]
          );
      });

      var getweekgroupedarray = {};
      $.each(getweekarray, function (key, value) {
        if (!Array.isArray(getweekgroupedarray[value])) {
          getweekgroupedarray[value] = [];
          getweekgroupedarray[value].push(key);
        } else {
          getweekgroupedarray[value].push(key);
        }
      });

      var weekprop = {};
      var category = [];
      $.each(getweekgroupedarray, function (week, weekarr) {
        var dayspan =
          weekarr[0].split("-")[2] +
          "-" +
          weekarr[weekarr.length - 1].split("-")[2];
        var monwithdaterangespan = week + " " + week.split("-")[0] + dayspan;
        weekprop[monwithdaterangespan] = 0;
        if (!category.includes(monwithdaterangespan)) {
          category.push(monwithdaterangespan);
        }
        $.each(proprdata, function (key, value) {
          if (weekarr.includes(key)) {
            weekprop[monwithdaterangespan] += +value;
          }
        });
      });
      //console.log(weekprop);
//console.log()
      var alldata = {
        series: [
          {
            name: "Occupancy",
            data: Object.values(weekprop),
          },
        ],
        options: {
          chart: {
            type: "bar",
            height: 350,
            width: "400px",
            toolbar: {
              show: false,
            },
          },
          plotOptions: {
            bar: {
              horizontal: false,
              columnWidth: "80%",
              endingShape: "rounded",
            },
          },
          dataLabels: {
            enabled: false,
          },
          stroke: {
            show: true,
            width: 2,
            colors: ["transparent"],
          },
          yaxis: {
            tickAmount: 3,

            labels: {
              show: true,
              align: "right",

              style: {
                colors: ["#ccc"],
                fontSize: "12px",
                fontFamily: "Sofia Pro",
                fontWeight: 400,
                cssClass: "apexcharts-yaxis-label",
              },
              offsetX: 0,
              offsetY: 0,
              rotate: 0,
              formatter: (value) => {
                var cnt = value.toString().length;
                var str = value;
                if (cnt === 4 || cnt === 5) {
                  str = Number(value / 1000).toFixed(0) + "K";
                } else if (cnt === 7 || cnt === 6) {
                  str = Number(value / 100000).toFixed(0) + "L";
                } else if (cnt > 7) {
                  str = Number(value / 10000000).toFixed(0) + "Cr";
                }
                return str;
              },
            },
          },
          xaxis: {
            categories: category,

            show: false,

            labels: {
              show: true,
              style: {
                fontFamily: "Sofia Pro",

                cssClass: "apexcharts-xaxis-label",
              },
              formatter: function (val) {
                return val.split(" ")[0];
              },
            },
            axisBorder: {
              show: false,
            },
            axisTicks: {
              show: false,
            },
          },

          legend: {
            position: "top",
            horizontalAlign: "right",
            markers: {
              width: 8,
              height: 8,
            },
          },
          fill: {
            opacity: 0.7,
          },

          grid: {
            show: false,
          },
          bar: {
            borderRadius: "10%",
          },
          tooltip: {
            y: {
              formatter: function (val) {
                return val;
              },
            },
            x: {
              show: true,

              formatter: function (val) {
                return val.split(" ")[1];
              },
            },
          },
        },
      };
    } else if (diffday >= 32 && diffday <= 365) {
      // console.log(datearray);
      var monthobj = {
        "01": "Jan",
        "02": "Feb",
        "03": "Mar",
        "04": "Apr",
        "05": "May",
        "06": "Jun",
        "07": "Jul",
        "08": "Aug",
        "09": "Sept",
        10: "Oct",
        11: "Nov",
        12: "Dec",
      };
      var proprdata = {};
      var category = [];

      $.each(datearray, function (datekey, dateval) {
        var dayname = new Date(dateval);
        var dayval = dayname.getDay();
        if (Object.keys(nottodaysales.occupiedroomcount).includes(dateval)) {
          proprdata[monthobj[dateval.split("-")[1]]] =
            +nottodaysales.occupiedroomcount[dateval];
        } else {
          proprdata[monthobj[dateval.split("-")[1]]] = 0;
        }
      });

      //console.log(proprdata);

      var alldata = {
        series: [
          {
            name: "Occupancy",
            data: Object.values(proprdata),
          },
        ],
        options: {
          chart: {
            type: "bar",
            height: 350,
            width: "400px",
            toolbar: {
              show: false,
            },
          },
          plotOptions: {
            bar: {
              horizontal: false,
              columnWidth: "80%",
              endingShape: "rounded",
            },
          },
          dataLabels: {
            enabled: false,
          },
          stroke: {
            show: true,
            width: 2,
            colors: ["transparent"],
          },
          yaxis: {
            tickAmount: 3,

            labels: {
              show: true,
              align: "right",

              style: {
                colors: ["#ccc"],
                fontSize: "12px",
                fontFamily: "Sofia Pro",
                fontWeight: 400,
                cssClass: "apexcharts-yaxis-label",
              },
              offsetX: 0,
              offsetY: 0,
              rotate: 0,
              formatter: (value) => {
                var cnt = value.toString().length;
                var str = value;
                if (cnt === 4 || cnt === 5) {
                  str = Number(value / 1000).toFixed(0) + "K";
                } else if (cnt === 7 || cnt === 6) {
                  str = Number(value / 100000).toFixed(0) + "L";
                } else if (cnt > 7) {
                  str = Number(value / 10000000).toFixed(0) + "Cr";
                }
                return str;
              },
            },
          },
          xaxis: {
            categories: Object.keys(proprdata),

            show: false,

            labels: {
              show: true,
              style: {
                fontFamily: "Sofia Pro",
                fontSize: "9px",
                cssClass: "apexcharts-xaxis-label",
              },
            },
            axisBorder: {
              show: false,
            },
            axisTicks: {
              show: false,
            },
          },

          legend: {
            position: "top",
            horizontalAlign: "right",
            markers: {
              width: 8,
              height: 8,
            },
          },
          fill: {
            opacity: 0.7,
          },

          grid: {
            show: false,
          },
          bar: {
            borderRadius: "10%",
          },
          tooltip: {
            y: {
              formatter: function (val) {
                return "" + val;
              },
            },
            x: {
              formatter: function (val) {
                return "" + val;
              },
            },
          },
        },
      };
    } else {
      var proprdata = {};
      var category = [];

      $.each(datearray, function (datekey, dateval) {
        if (
          Object.keys(nottodaysales.occupiedroomcount).includes(
            dateval.toString()
          )
        ) {
          proprdata[dateval] = +nottodaysales.occupiedroomcount[dateval];
        } else {
          proprdata[dateval] = 0;
        }
      });

      var alldata = {
        series: [
          {
            name: "Occupancy",
            data: Object.values(proprdata),
          },
        ],
        options: {
          chart: {
            type: "bar",
            height: 350,
            width: "400px",
            toolbar: {
              show: false,
            },
          },
          plotOptions: {
            bar: {
              horizontal: false,
              columnWidth: "80%",
              endingShape: "rounded",
            },
          },
          dataLabels: {
            enabled: false,
          },
          stroke: {
            show: true,
            width: 2,
            colors: ["transparent"],
          },
          yaxis: {
            tickAmount: 3,

            labels: {
              show: true,
              align: "right",

              style: {
                colors: ["#ccc"],
                fontSize: "12px",
                fontFamily: "Sofia Pro",
                fontWeight: 400,
                cssClass: "apexcharts-yaxis-label",
              },
              offsetX: 0,
              offsetY: 0,
              rotate: 0,
              formatter: (value) => {
                var cnt = value.toString().length;
                // console.log(cnt);
                var str = value;
                if (cnt === 4 || cnt === 5) {
                  str = Number(value / 1000).toFixed(0) + "K";
                } else if (cnt === 7 || cnt === 6) {
                  str = Number(value / 100000).toFixed(0) + "L";
                } else if (cnt > 7) {
                  str = Number(value / 10000000).toFixed(0) + "Cr";
                }
                return str;
              },
            },
          },
          xaxis: {
            categories: Object.keys(proprdata),

            show: false,

            labels: {
              show: true,
              style: {
                fontFamily: "Sofia Pro",
                fontSize: "9px",
                cssClass: "apexcharts-xaxis-label",
              },
            },
            axisBorder: {
              show: false,
            },
            axisTicks: {
              show: false,
            },
          },

          legend: {
            position: "top",
            horizontalAlign: "right",
            markers: {
              width: 8,
              height: 8,
            },
          },
          fill: {
            opacity: 0.7,
          },

          grid: {
            show: false,
          },
          bar: {
            borderRadius: "10%",
          },
          tooltip: {
            y: {
              formatter: function (val) {
                return "" + val;
              },
            },
            x: {
              formatter: function (val) {
                return "" + val;
              },
            },
          },
        },
      };
    }
  }
  var state = {
    series: [perc],
    options: {
      chart: {
        height: 350,
        type: "radialBar",
        toolbar: {
          show: false,
        },
      },
      plotOptions: {
        radialBar: {
          startAngle: 0,
          endAngle: 360,
          hollow: {
            margin: 0,
            size: "70%",
            background: "#fff",
            image: undefined,
            imageOffsetX: 0,
            imageOffsetY: 0,
            position: "back",
            dropShadow: {
              enabled: true,
              top: 3,
              left: 0,
              blur: 4,
              opacity: 0.24,
            },
          },
          track: {
            background: "#fff",
            strokeWidth: "67%",
            margin: 0, // margin is in pixels
          },

          dataLabels: {
            show: true,
            name: {
              offsetY: -10,
              show: true,
              color: "#888",
              fontSize: "14px",
            },
            value: {
              formatter: function (val) {
                return val + "%";
              },
              color: "#111",
              fontSize: "24px",
              show: true,
            },
          },
        },
      },
      fill: {
        type: "gradient",
        gradient: {
          shade: "dark",
          type: "horizontal",
          shadeIntensity: 0.5,
          gradientToColors: ["#2FEAA8"],
          inverseColors: true,
          opacityFrom: 1,
          opacityTo: 1,
          stops: [0, 100],
        },
      },
      stroke: {
        lineCap: "round",
      },
      labels: ["Occupied"],
    },
  };
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
      {showskel ? (
        <Skelt1 />
      ) : (
        <Box style={{ padding: "12px", marginBottom: "68px" }}>
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
          <Box className="nottoday-graph-section">
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
                <span className="sales-section-text">Room Status</span>
              </Grid>
              <Grid item xs={4} className="fsec-body-header1"></Grid>
            </Grid>
            <Grid container item xs={12}>
              <Grid item xs={6}>
                <div className="fsec-body-header1" style={{ height: "100%" }}>
                  <Chart
                    options={state.options}
                    series={state.series}
                    type="radialBar"
                    height={180}
                  />
                </div>
              </Grid>
              <Grid item xs={6} className="nottoday-first-section-arr">
                <div style={{ width: "100%" }}>
                  <Grid container style={{ width: "100%" }}>
                    <Grid item xs={6} style={{ width: "50%" }}>
                      <span className="nottoday-first-section-arr-text">
                        Sold Nights
                      </span>
                    </Grid>
                    <Grid
                      item
                      xs={6}
                      style={{ width: "50%", textAlign: "right" }}
                    >
                      <span className="nottoday-first-section-arr-value">
                        {soldnights}
                      </span>
                    </Grid>
                  </Grid>
                  <hr
                    className="hr-break"
                    style={{
                      borderBottom: "1px solid #EBEEF6",

                      position: "relative",

                      margin: "0px 2px !important",
                    }}
                  />
                  <Grid container>
                    <Grid item xs={6} style={{ width: "50%" }}>
                      <span className="nottoday-first-section-arr-text">
                        ARR
                      </span>
                    </Grid>
                    <Grid
                      item
                      xs={6}
                      style={{ width: "50%", textAlign: "right" }}
                    >
                      <span className="nottoday-first-section-arr-value">
                        {formatNum(arr.toFixed(2))}
                      </span>
                    </Grid>
                  </Grid>
                </div>
              </Grid>
            </Grid>
          </Box>
          <Box className="sales-section">
            <Grid container style={{ padding: "15px 15px 0px 15px" }}>
              <Grid item xs={1}>
                <div className="roomsection1">
                  <img src={Sales} />
                </div>
              </Grid>
              <Grid
                item
                xs={7}
                className="fsec-body-header"
                style={{ paddingLeft: "10px" }}
              >
                <span className="sales-section-text">Sales</span>
              </Grid>
              <Grid item xs={4} className="fsec-body-header1">
                {/* { <img src={Arrow} />} */}
              </Grid>
            </Grid>
            <Grid container style={{ paddingBottom: "15px" }}>
              <Grid item xs={1}></Grid>
              <Grid
                item
                xs={7}
                className="fsec-body-header"
                style={{ paddingLeft: "23px" }}
              >
                <span className="sales-section-amount1">
                  {formatNum(totalsales.toFixed(2))}
                </span>
              </Grid>
              <Grid item xs={4} className="fsec-body-header1"></Grid>
            </Grid>
            <Grid item xs={6}></Grid>
            <Grid container item xs={12} className="sales-section-details">
              <Grid
                item
                xs={6}
                className="sales-section-amount-details"
                style={{ borderRight: "3px solid white" }}
              >
                <div>
                  <div className="sales-section-amount-details-name">
                    By Room
                  </div>
                  <div className="sales-section-amount-details-value">
                    {formatNum(sales.toFixed(2))}
                  </div>
                </div>
              </Grid>
              <Grid item xs={6} className="sales-section-amount-details">
                <div>
                  <div className="sales-section-amount-details-name">
                    By Others
                  </div>
                  <div className="sales-section-amount-details-value">
                    {formatNum(othersales.toFixed(2))}
                  </div>
                </div>
              </Grid>
            </Grid>
          </Box>
          <Box className="revenue-section">
            <Grid container style={{ padding: "15px 15px 0px 15px" }}>
              <Grid item xs={1}>
                <div className="roomsection1">
                  <img src={Revenue} />
                </div>
              </Grid>
              <Grid
                item
                xs={7}
                className="fsec-body-header"
                style={{ paddingLeft: "10px" }}
              >
                <span className="sales-section-text">Revenue</span>
              </Grid>
              <Grid item xs={4} className="fsec-body-header1">
                {/* {<img src={Arrow} />} */}
              </Grid>
            </Grid>
            <Grid container style={{ paddingBottom: "15px" }}>
              <Grid item xs={1}></Grid>
              <Grid
                item
                xs={7}
                className="fsec-body-header"
                style={{ paddingLeft: "23px" }}
              >
                <span className="sales-section-amount1">
                  {formatNum(revenuetotal.toFixed(2))}
                </span>
              </Grid>
              <Grid item xs={4} className="fsec-body-header1"></Grid>
            </Grid>
            <Grid item xs={6}></Grid>
            <Grid container item xs={12} className="sales-section-details">
              <Grid
                item
                xs={4}
                className="sales-section-amount-details"
                style={{ borderRight: "3px solid white" }}
              >
                <div>
                  <div className="sales-section-amount-details-name">
                    By Cash
                  </div>
                  <div className="sales-section-amount-details-value">
                    {formatNum(cash.toFixed(2))}
                  </div>
                </div>
              </Grid>
              <Grid
                item
                xs={4}
                className="sales-section-amount-details"
                style={{ borderRight: "3px solid white" }}
              >
                <div>
                  <div className="sales-section-amount-details-name">
                    By Card
                  </div>
                  <div className="sales-section-amount-details-value">
                    {formatNum(card.toFixed(2))}
                  </div>
                </div>
              </Grid>
              <Grid item xs={4} className="sales-section-amount-details">
                <div>
                  <div className="sales-section-amount-details-name">
                    By Bank
                  </div>
                  <div className="sales-section-amount-details-value">
                    {formatNum(bank.toFixed(2))}
                  </div>
                </div>
              </Grid>
            </Grid>
          </Box>
          <Box style={{ marginTop: "15px" }}>
            <Grid container item xs={12} className="compare-graph">
              <div className="compare-graph-wrapper">
                {Object.keys(alldata).length > 0 ? (
                  <Chart
                    options={alldata.options}
                    series={alldata.series}
                    type="bar"
                  />
                ) : (
                  ""
                )}
              </div>
            </Grid>
          </Box>
        </Box>
      )}
    </>
  );
}
