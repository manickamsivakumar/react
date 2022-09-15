import React from "react";
import Box from "@mui/material/Box";
import Grid from "@mui/material/Grid";
import "./main.css";
import ChevronRightIcon from "@mui/icons-material/ChevronRight";
import notify from "./images/notification.svg";
import approval from "./images/approval.svg";
import Chart from "react-apexcharts";
import { NavLink } from "react-router-dom";
import moment from "moment";
function formatNum(numb) {
  let num = Number(numb).toLocaleString('en-IN', {
    minimumFractionDigits: 2,
    maximumFractionDigits: 2
});
  return num;
}
const Hotel = ({ propid, count, filterdata, modulelist, selectedIndex ,userdtls,value}) => {
  let foedata = modulelist.includes("FOE") ? filterdata.foe : {};
  //console.log(filterdata);
  let posdata = modulelist.includes("POS") ? filterdata.pos : {};
  //console.log(posdata);
  let bnqtdata = modulelist.includes("BNQ") ? filterdata.bnq : {};
  let propcity = filterdata.propcity;
  let propname = filterdata.propname;
  let appmodulelist = {
    FOE: "frontoffice",
    POS: "Point of Sale",
    
  };

  var foeamount = 0;
  if (Object.keys(foedata).length > 0) {
    foeamount = Object.values(foedata).reduce(
      (total, current) => {
        return Number(total) + Number(current);
      },
      [0]
    );
  }
  var bnqamount = 0;
  if (Object.keys(bnqtdata).length > 0) {
    bnqamount = Object.values(bnqtdata).reduce(
      (total, current) => {
        return Number(total) + Number(current);
      },
      [0]
    );
  }
  var posamount = 0;
  if (Object.keys(posdata).length > 0) {
    posamount = Object.values(posdata).reduce(
      (total, current) => {
        return Number(total) + Number(current);
      },
      [0]
    );
  }
  var amountdata = {
    FOE: foeamount,
    POS: posamount,
    BNQ: bnqamount,
  };
  var graphdata = [
    Number(foeamount.toFixed(0)),
    Number(posamount.toFixed(0)),
    Number(bnqamount.toFixed(0)),
  ];
  var percentage = occupencycalculation(
    filterdata.front_offize_total_totelrooms,
    filterdata.front_offize_total_occupied,
    selectedIndex.fromdates,
    selectedIndex.todates
  );
  function occupencycalculation(totelrooms, occupencytotel, from, to) {
    if (from === to) {
      var differnce = 1;
    } else {
      var differnce = differncedate(from, to) + 1;
    }

    var fistdividend = (totelrooms * differnce) / 100;
    var percentage = occupencytotel / fistdividend;
    return percentage.toFixed(0);
  }
  function differncedate(from, to) {
    //console.log(from);
    //console.log(to);
    var to = moment(to, "YYYY-MM-DD");
    var from = moment(from, "YYYY-MM-DD");
    var diff = to.diff(from, "days"); // 1
    // console.log(diff);
    return diff;
  }
  
  var label = (+value>0) ? 'SN-'+filterdata.front_offize_total_occupied : filterdata.front_offize_total_occupied +"/" +filterdata.front_offize_total_totelrooms;
  const data = {
    series: graphdata,
    options: {
      dataLabels: {
        enabled: false,
      },
      colors: ["#F5D5BA", "#F5BABE", "#D1BAF5", "#84F590", "#7FEAF5"],
      labels: ["Foe", "POS", "Bnqt"],
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
              total: {
                show: true,
                label:label
                ,
                color: "#111",
                fontSize: "18px",
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
  // console.log(modulelist, "module");
  let filterdmodule = Object.keys(appmodulelist).filter((val) => {
    return modulelist.includes(val);
  });
  let modcount = filterdmodule.length;
  let proptotal = Object.values(amountdata).reduce((acc, current) => acc + current);
  return (
    <div style={{ marginTop: "15px", minHeight: "230px" }}>
      <Grid className="hotel-header" container style={{ padding: "10px" }}>
        <Grid item xs={6} style={{}}>
          <span className="hotel-header-title3">{propname}</span>
          <br />
          <span className="hotel-header-title2">{propcity}</span>
        </Grid>
        <Grid item xs={6}>
          <div style={{ float: "right" }}>
            <span className="prop-header-title1">
              Total: &#8377; {formatNum(proptotal.toFixed(2))}
            </span>

            {/* <img src={approval} style={{ height: "40px" }} alt="approve" />
            <img src={notify} style={{ height: "40px" }} alt="alert" /> */}
          </div>
        </Grid>
      </Grid>
      <Grid className="hotel-body" container style={{ padding: "10px" }}>
        <Grid item xs={6} style={{}}>
          <div
            id="chart"
            className="graphbody"
            style={{ width: "100%", height: "100%" }}
          >
            <Chart options={data.options} series={data.series} type="donut" />
          </div>
        </Grid>
        <Grid item xs={6} style={{}} className="maindash-box-center">
          <div style={{ width: "100%" }}>
            <Box>
              {filterdmodule.map((modname, modindex) => {
                //console.log(modindex);
                // console.log(modcount);
                var borderclass =
                  +modindex + 1 == modcount ? "" : "border-bottom";
                // console.log(borderclass);
                return (
                  <Grid
                    key={modindex}
                    className={`hotel-body-details ${borderclass}`}
                    item
                    xs={12}
                  >
                    <NavLink
                      to={`/${modname.toLowerCase()}`}
                      state={{
                        propid: propid,
                        cmpid:filterdata.cmpid,
                        propdtls: { propname: propname, propcity: propcity },
                        userdtls:userdtls
                      }}
                      style={{ textDecoration: "none" }}
                    >
                      <Grid container>
                        <Grid item xs={8}>
                          <h2
                            className="hotel-body-module-name"
                            style={{ margin: "5px 0 5px 0" }}
                          >
                            {appmodulelist[modname]}
                          </h2>
                          <h2
                            className="hotel-body-module-value"
                            style={{ margin: "5px 0 5px 0" }}
                          >
                            &#8377; {formatNum(amountdata[modname].toFixed(2))}
                          </h2>
                        </Grid>
                        <Grid item xs={4}>
                          <div className="icon-right">
                            <ChevronRightIcon
                              style={{ fontSize: "25px", color: "gray" }}
                            />
                          </div>
                        </Grid>
                      </Grid>
                    </NavLink>
                  </Grid>
                );
              })}
            </Box>
          </div>
        </Grid>
      </Grid>
    </div>
  );
};

export default Hotel;
