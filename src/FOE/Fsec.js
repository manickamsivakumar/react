import React, { useEffect, useState } from "react";
import "../main.css";
import Grid from "@mui/material/Grid";
import Box from "@mui/material/Box";
import Checkin from "../images/ic_checkin.svg";
import Checkout from "../images/ic_checkout.svg";
import Arrow from "../images/right_arrow.svg";
import Sales from "../images/ic_sales.svg";
import Revenue from "../images/ic_revenue.svg";
import Room from "../images/ic_roomstatus.svg";
import Highbalance from "../images/ic_highbalance.svg";
import Dues from "../images/ic_dues.svg";
import Chart from "react-apexcharts";
import $ from "jquery";
import { Link } from "react-router-dom";
import Skelt from "../Skeleton/Skeletondiv2.js";
import { DateTime } from "luxon";
import Calender from "../images/calendar.svg";
function formatNum(numb) {
  let num = Number(numb).toLocaleString('en-IN', {
    minimumFractionDigits: 2,
    maximumFractionDigits: 2
});
  return num;
}
export default function Fsec({
  menuval,
  value,
  propid,

  propname,
}) {
  const [salesdata, setSalesdata] = useState({});
  const [showskeleton, setShowskeleton] = useState(1);
  React.useEffect(() => {
    getfoedata(menuval, +value + 1);
  }, [menuval]);
  const getfoedata = (index, filtervalue) => {
    //  var dates = get_all_duration(+index + 1);
    var fromdate = index.fromdates;
    var todate = index.todates;
    $.ajax({
      url: "https://dev.skyhms.in/mob_mis_v2/subfilters",
      type: "post",
      data: {
        fromdate,
        todate,
        filtervalue,
        propid,
      },
      datatype: "JSON",
      success: function (res) {
        setSalesdata(JSON.parse(res));
        var jsondata = JSON.parse(res);

        setShowskeleton(0);
      },
      error: function () {},
    });
  };
  var status = {};
  //console.log(salesdata);
  var highbalance = 0;
  if (salesdata.highbalance) {
    highbalance = Number(salesdata.highbalance);
  }
  if (salesdata.hasOwnProperty("status")) {
    $.each(salesdata.status, function (key, value) {
      status[value["roomstatusname"]] = +value["roomstatuscount"];
    });
  }
  var duestotal = 0;
  var duearr = [];
  if (salesdata.hasOwnProperty("dues")) {
    duearr = [...salesdata.dues];
    $.each(salesdata.dues, function (key, value) {
      duestotal += Number(value["closebal"].slice(0, -2));
    });
  }
  var checkincount = 0;
  if (salesdata.hasOwnProperty("checkin")) {
    var checkincount = Object.values(salesdata.checkin).reduce(
      (total, current) => {
        return Number(current) + Number(total);
      },
      0
    );
  }
  var checkoutcount = 0;
  if (salesdata.hasOwnProperty("checkout")) {
    checkoutcount = Object.values(salesdata.checkout).reduce(
      (total, current) => {
        return Number(current) + Number(total);
      },
      0
    );
  }
  var sales = 0;
  if (salesdata.hasOwnProperty("checkout")) {
    sales = Object.values(salesdata.sales).reduce((total, current) => {
      return Number(current) + Number(total);
    }, 0);
  }
  var othersales = 0;
  if (salesdata.hasOwnProperty("othersales")) {
    othersales = Object.values(salesdata.othersales).reduce(
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
  if (salesdata.hasOwnProperty("revenue")) {
    $.each(salesdata.revenue, function (key, val) {
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
  var totalrooms = Number(salesdata.totalrooms);

  //console.log(totalrooms);
  //console.log(status);
  var occupied = Number(status["OCCUPIED"]);
  //console.log(occupied);
  var perc = (occupied / totalrooms) * 100;
  var percentage = perc.toFixed(0);

  const rmsts = ["Dirty", "Vacant", "Occupied", "Block", "Maintenance"];
  var colors = ["#F5D5BA", "#F5BABE", "#D1BAF5", "#84F590", "#7FEAF5"];
  const data = {
    series: Object.values(status).length > 0 ? Object.values(status) : [],
    options: {
      dataLabels: {
        enabled: false,
      },
      colors: ["#F5D5BA", "#F5BABE", "#D1BAF5", "#84F590", "#7FEAF5"],
      labels: Object.keys(status).length > 0 ? Object.keys(status) : [],
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
            labels: {
              show: true,
              total: {
                show: true,
                label: "Stay",
                fontSize: 14,
                color: "#028cf3",
                formatter: () => percentage + "%",
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
              width: 180,
            },
            legend: {
              position: "bottom",
            },
          },
        },
      ],
    },
  };

  let count = rmsts.length;
  var i = 0;

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
      {showskeleton ? (
        <Skelt />
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
          <Grid container item xs={12} spacing={1}>
            <Grid item xs={6}>
              <Link
                to="/checkin"
                state={{ flag: 1, propid: propid, ...propname }}
                style={{ textDecoration: "none" }}
              >
                <div className="checkin-box">
                  <Grid container style={{ padding: "15px 15px 0 15px" }}>
                    <Grid item xs={3}>
                      <img src={Checkin} />
                    </Grid>
                    <Grid item xs={7} className="checkin-box-text1">
                      Check-in
                    </Grid>
                    <Grid item xs={2} className="checkin-box-text2">
                      <img src={Arrow} />
                    </Grid>
                  </Grid>
                  <Grid container item xs={12}>
                    <Grid item xs={3}></Grid>
                    <Grid item xs={7}>
                      <div className="checkin-count">{checkincount}</div>
                    </Grid>
                    <Grid item xs={2}></Grid>
                  </Grid>
                </div>
              </Link>
            </Grid>
            <Grid item xs={6}>
              <Link
                to="/checkout"
                state={{ flag: 0, propid: propid, ...propname }}
                style={{ textDecoration: "none" }}
              >
                <div className="checkin-box">
                  <Grid container style={{ padding: "15px 15px 0 15px" }}>
                    <Grid item xs={3}>
                      <img src={Checkout} />
                    </Grid>
                    <Grid item xs={7} className="checkin-box-text1">
                      Check-out
                    </Grid>
                    <Grid item xs={2} className="checkin-box-text2">
                      <img src={Arrow} />
                    </Grid>
                  </Grid>
                  <Grid container item xs={12}>
                    <Grid item xs={3}></Grid>
                    <Grid item xs={7}>
                      <div className="checkin-count">{checkoutcount}</div>
                    </Grid>
                    <Grid item xs={2}></Grid>
                  </Grid>
                </div>
              </Link>
            </Grid>
          </Grid>
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
                  <span className="Room-status"> Room Status</span>
                </Grid>

                <Grid item xs={3} className="fsec-body-header1">
                  <Link
                    to="/foearrival"
                    state={{ propid: propid, ...propname }}
                  >
                    <img src={Arrow} />
                  </Link>
                </Grid>
              </Grid>
            </Grid>
            <Grid container item xs={12}>
              <Grid item xs={6}>
                <Link
                  to="/currentcheckin"
                  style={{
                    textDecoration: "none",
                  }}
                  state={{ propid: propid, ...propname }}
                >
                  <div className="fsec-body-header1" style={{ height: "87%" }}>
                    <Chart
                      options={data.options}
                      series={data.series}
                      type="donut"
                    />
                  </div>
                  <div className="arrowset">
                    <img src={Arrow} />
                  </div>
                </Link>
              </Grid>

              <Grid item xs={6}>
                {Object.keys(status).map((sts, key) => {
                  i++;
                  return (
                    <Grid
                      container
                      key={key}
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
                        <span className="Room-status-text"> {sts}</span>
                      </Grid>

                      <Grid item xs={4} className="fsec-body-header1">
                        <span className="roomstatus_count">{status[sts]}</span>
                      </Grid>
                    </Grid>
                  );
                })}
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
                  &#8377; {formatNum(totalsales.toFixed(2))}
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
                  <div className="sales-section-amount-details-value1">
                    &#8377; {formatNum(sales.toFixed(2))}
                  </div>
                </div>
              </Grid>
              <Grid item xs={6} className="sales-section-amount-details">
                <div>
                  <div className="sales-section-amount-details-name">
                    By Others
                  </div>
                  <div className="sales-section-amount-details-value1">
                    &#8377; {formatNum(othersales.toFixed(2))}
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
                  &#8377; {formatNum(revenuetotal.toFixed(2))}
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
                  <div className="sales-section-amount-details-value1">
                    &#8377; {formatNum(cash.toFixed(2))}
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
                  <div className="sales-section-amount-details-value1">
                    &#8377; {formatNum(card.toFixed(2))}
                  </div>
                </div>
              </Grid>
              <Grid item xs={4} className="sales-section-amount-details">
                <div>
                  <div className="sales-section-amount-details-name">
                    By Bank
                  </div>
                  <div className="sales-section-amount-details-value1">
                    &#8377; {formatNum(bank.toFixed(2))}
                  </div>
                </div>
              </Grid>
            </Grid>
          </Box>
          <Box>
            <Grid
              container
              item
              xs={12}
              spacing={1}
              style={{ marginTop: "10px" }}
            >
              <Grid item xs={6}>
                <Link
                  to="/highbalance"
                  state={{ ...propname, propid: propid }}
                  style={{ textDecoration: "none" }}
                >
                  <div className="checkin-box">
                    <Grid container style={{ padding: "15px 15px 0 15px" }}>
                      <Grid item xs={3}>
                        <img src={Highbalance} />
                      </Grid>
                      <Grid item xs={7} className="checkin-box-text1">
                        High Bal
                      </Grid>
                      <Grid item xs={2} className="checkin-box-text2">
                        <img src={Arrow} />
                      </Grid>
                    </Grid>
                    <Grid container item xs={12}>
                      <Grid item xs={2}></Grid>
                      <Grid item xs={10}>
                        <div className="checkin-count">
                          &#8377; {formatNum(highbalance.toFixed(2))}
                        </div>
                      </Grid>
                    </Grid>
                  </div>
                </Link>
              </Grid>
              <Grid item xs={6}>
                <Link
                  to="/dues"
                  state={{ ...propname, propid: propid }}
                  style={{ textDecoration: "none" }}
                >
                  <div className="checkin-box">
                    <Grid container style={{ padding: "15px 15px 0 15px" }}>
                      <Grid item xs={3}>
                        <img src={Dues} />
                      </Grid>
                      <Grid item xs={7} className="checkin-box-text1">
                        Dues
                      </Grid>
                      <Grid item xs={2} className="checkin-box-text2">
                        <img src={Arrow} />
                      </Grid>
                    </Grid>
                    <Grid container item xs={12}>
                      <Grid item xs={2}></Grid>
                      <Grid item xs={10}>
                        <div className="checkin-count">
                          &#8377; {formatNum(duestotal.toFixed(2))}
                        </div>
                      </Grid>
                    </Grid>
                  </div>
                </Link>
              </Grid>
            </Grid>
          </Box>
        </Box>
      )}
    </>
  );
}
