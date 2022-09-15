import React from "react";
import Box from "@mui/material/Box";
import Grid from "@mui/material/Grid";
import "./main.css";
import Chart from "react-apexcharts";
import Tab from "@mui/material/Tab";
import TabContext from "@mui/lab/TabContext";
import TabList from "@mui/lab/TabList";
import TabPanel from "@mui/lab/TabPanel";
import { makeStyles } from "@mui/styles";
import $ from "jquery";
import moment from "moment";

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
  // var fistdividend = (totelrooms * differnce) / 100;
  // var percentage = occupencytotel / fistdividend;
  return differnce;
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
const Hotelgrap = ({ filterdata, selectedIndex, modulelist }) => {
  const [value, setValue] = React.useState("1");

  console.log(filterdata);
  const handleChange = (event, newValue) => {
    setValue(newValue);
  };
  const useStyles = makeStyles({
    root: {
      height: 18,
      width: 30,
      padding: "0 0",
    },
  });
  const classes = useStyles();
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
  var diffday = getdiffernce(selectedIndex.fromdates, selectedIndex.todates);

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
      var datearray = getDates(selectedIndex.fromdates, selectedIndex.todates); // create a array of from to todate array for graphlabel

      break;

    case 1:
      var datearray = getMonth(selectedIndex.fromdates, selectedIndex.todates);

      break;
    case 2:
      var datearray = getYears(selectedIndex.fromdates, selectedIndex.todates);

      break;
  }
  console.log(filterdata, "filterdata");
  var stdmodulelist = ["FOE", "POS"];
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

    var graphmode = {};

    var proprdata = {};
    var category = [];
    $.each(filterdata, function (prop, propdetails) {
      proprdata[prop] = {};
      var module = modulelist[prop].filter((val) => {
        if (stdmodulelist.includes(val)) {
          return val.toLowerCase();
        }
      });
      module = module.map((val) => val.toLowerCase());
      graphmode[prop] = [...module, "all"];
      $.each(propdetails, function (skey, sval) {
        if (module.includes(skey)) {
          proprdata[prop][skey] = {};
          $.each(datearray, function (datekey, dateval) {
            var dayname = new Date(dateval);
            var dayval = dayname.getDay();
            if (!category.includes(dayobj[dayval])) {
              category.push(dayobj[dayval]);
            }

            if (sval[dateval]) {
              proprdata[prop][skey][dayobj[dayval]] = +sval[dateval];
            } else {
              proprdata[prop][skey][dayobj[dayval]] = 0;
            }
          });
        }
      });
    });
    console.log(graphmode);
    console.log(proprdata, "proprdata");
    var alldata = {};
    var allpropdata = {};
    var graphmodedata = {};

    $.each(proprdata, function (propid, propval) {
      allpropdata[propid] = {};

      $.each(graphmode[propid], function (key, val) {
        if (val === "all") {
          $.each(propval, function (key, value) {
            $.each(value, function (day, dayval) {
              //  console.log(allpropdata[propid]);
              if (allpropdata[propid].hasOwnProperty(day)) {
                allpropdata[propid][day] += +dayval;
              } else {
                allpropdata[propid][day] = 0;
                allpropdata[propid][day] += +dayval;
              }
            });
          });

          var seriesobj = {
            name: filterdata[propid]["propname"],
            data: Object.values(allpropdata[propid]),
          };

          if (graphmodedata.hasOwnProperty(val)) {
            graphmodedata[val].push(seriesobj);
          } else {
            graphmodedata[val] = [];
            graphmodedata[val].push(seriesobj);
          }
        } else {
          var seriesobj = {
            name: filterdata[propid]["propname"],
            data: Object.values(propval[val]),
          };
          if (graphmodedata.hasOwnProperty(val)) {
            graphmodedata[val].push(seriesobj);
          } else {
            graphmodedata[val] = [];
            graphmodedata[val].push(seriesobj);
          }
        }
      });
    });
    console.log(graphmodedata, "graphmodedata");
    $.each(graphmode, function (propid, prval) {
      $.each(prval, function (key, value) {
        alldata[value] = {
          series: graphmodedata[value],
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
                columnWidth: "50%",
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
              tickAmount: 4,

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
                  return "&#8377;" + val;
                },
              },
            },
          },
        };
      });
    });
  } else if (diffday >= 8 && diffday <= 31) {
    var graphmode = {};
    var proprdata = {};

    $.each(filterdata, function (prop, propdetails) {
      var module = modulelist[prop].filter((val) => {
        if (stdmodulelist.includes(val)) {
          return val.toLowerCase();
        }
      });
      module = module.map((val) => val.toLowerCase());
      graphmode[prop] = [...module, "all"];

      proprdata[prop] = {};
      $.each(propdetails, function (skey, sval) {
        if (module.includes(skey)) {
          proprdata[prop][skey] = {};
          $.each(datearray, function (datekey, dateval) {
            if (sval[dateval]) {
              var temp = Number(sval[dateval]).toFixed(0);
              proprdata[prop][skey][dateval] = Number(temp);
            } else {
              proprdata[prop][skey][dateval] = 0;
            }
          });
        }
      });
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
    //console.log(datearray);
    $.each(datearray, function (key, value) {
      var splivaluee = value.split("-");
      getweekarray[value] =
        monthobj[value.substring(5, 7)] +
        "-" +
        getWeekOfMonth(
          splivaluee[0] + "-" + splivaluee[1] + "-" + splivaluee[2]
        );
    });
    // console.log(getweekarray);
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
    $.each(proprdata, function (prop, propval) {
      weekprop[prop] = {};
      $.each(propval, function (propvalkey, propvalvalue) {
        weekprop[prop][propvalkey] = {};
        $.each(getweekgroupedarray, function (week, weekarr) {
          weekprop[prop][propvalkey][week] = 0;
          $.each(propvalvalue, function (key, value) {
            if (weekarr.includes(key)) {
              weekprop[prop][propvalkey][week] += +value;
            }
          });
        });
      });
    });

    var category = Object.keys(getweekgroupedarray);
    var alldata = {};

    var allpropdata = {};
    var graphmodedata = {};
    $.each(weekprop, function (propid, propval) {
      allpropdata[propid] = {};
      $.each(graphmode[propid], function (key, val) {
        if (val === "all") {
          $.each(propval, function (key, value) {
            $.each(value, function (day, dayval) {
              //  console.log(allpropdata[propid]);
              if (allpropdata[propid].hasOwnProperty(day)) {
                allpropdata[propid][day] += +dayval;
              } else {
                allpropdata[propid][day] = 0;
                allpropdata[propid][day] += +dayval;
              }
            });
          });

          var seriesobj = {
            name: filterdata[propid]["propname"],
            data: Object.values(allpropdata[propid]),
          };

          if (graphmodedata.hasOwnProperty(val)) {
            graphmodedata[val].push(seriesobj);
          } else {
            graphmodedata[val] = [];
            graphmodedata[val].push(seriesobj);
          }
        } else {
          // console.log(val);

          var seriesobj = {
            name: filterdata[propid]["propname"],
            data: Object.values(propval[val]),
          };
          if (graphmodedata.hasOwnProperty(val)) {
            graphmodedata[val].push(seriesobj);
          } else {
            graphmodedata[val] = [];
            graphmodedata[val].push(seriesobj);
          }
        }
      });
    });

    $.each(graphmode, function (propid, prval) {
      $.each(prval, function (key, value) {
        alldata[value] = {
          series: graphmodedata[value],
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
                columnWidth: "50%",
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
              tickAmount: 4,

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
                  return "&#8377;" + val;
                },
              },
            },
          },
        };
      });
    });
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

    var graphmode = {};
    var category = [];
    var proprdata = {};
    $.each(filterdata, function (prop, propdetails) {
      proprdata[prop] = {};
      var module = modulelist[prop].filter((val) => {
        if (stdmodulelist.includes(val)) {
          return val.toLowerCase();
        }
      });
      module = module.map((val) => val.toLowerCase());
      graphmode[prop] = [...module, "all"];
      $.each(propdetails, function (skey, sval) {
        if (module.includes(skey)) {
          proprdata[prop][skey] = {};
          $.each(datearray, function (datekey, dateval) {
            if (!category.includes(monthobj[dateval.split("-")[1]])) {
              category.push(monthobj[dateval.split("-")[1]]);
            }
            if (sval[dateval]) {
              var temp = Number(sval[dateval]).toFixed(0);
              proprdata[prop][skey][monthobj[dateval.split("-")[1]]] =
                Number(temp);
            } else {
              proprdata[prop][skey][monthobj[dateval.split("-")[1]]] = 0;
            }
          });
        }
      });
    });

    var alldata = {};
    var allpropdata = {};
    var graphmodedata = {};
    $.each(proprdata, function (propid, propval) {
      allpropdata[propid] = {};

      $.each(graphmode[propid], function (key, val) {
        if (val === "all") {
          $.each(propval, function (key, value) {
            $.each(value, function (day, dayval) {
              //  console.log(allpropdata[propid]);
              if (allpropdata[propid].hasOwnProperty(day)) {
                allpropdata[propid][day] += +dayval;
              } else {
                allpropdata[propid][day] = 0;
                allpropdata[propid][day] += +dayval;
              }
            });
          });

          var seriesobj = {
            name: filterdata[propid]["propname"],
            data: Object.values(allpropdata[propid]),
          };
          if (graphmodedata.hasOwnProperty(val)) {
            graphmodedata[val].push(seriesobj);
          } else {
            graphmodedata[val] = [];
            graphmodedata[val].push(seriesobj);
          }
        } else {
          var seriesobj = {
            name: filterdata[propid]["propname"],
            data: Object.values(propval[val]),
          };
          if (graphmodedata.hasOwnProperty(val)) {
            graphmodedata[val].push(seriesobj);
          } else {
            graphmodedata[val] = [];
            graphmodedata[val].push(seriesobj);
          }
        }
      });
    });
    $.each(graphmode, function (propid, prval) {
      $.each(prval, function (key, value) {
        alldata[value] = {
          series: graphmodedata[value],
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
                columnWidth: "50%",
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
              tickAmount: 4,

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
                  return "&#8377;" + val;
                },
              },
            },
          },
        };
      });
    });
  } else {
    var category = [...datearray];
    var proprdata = {};
    var graphmode = {};
    $.each(filterdata, function (prop, propdetails) {
      proprdata[prop] = {};
      var module = modulelist[prop].filter((val) => {
        if (stdmodulelist.includes(val)) {
          return val.toLowerCase();
        }
      });
      module = module.map((val) => val.toLowerCase());
      graphmode[prop] = [...module, "all"];
      $.each(propdetails, function (skey, sval) {
        if (module.includes(skey)) {
          proprdata[prop][skey] = {};
          $.each(datearray, function (datekey, dateval) {
            if (sval[dateval]) {
              var temp = Number(sval[dateval]).toFixed(0);
              proprdata[prop][skey][dateval] = Number(temp);
            } else {
              proprdata[prop][skey][dateval] = 0;
            }
          });
        }
      });
    });

    var alldata = {};
    var allpropdata = {};
    var graphmodedata = {};
    $.each(proprdata, function (propid, propval) {
      allpropdata[propid] = {};

      $.each(graphmode[propid], function (key, val) {
        console.log(val);
        if (val === "all") {
          $.each(propval, function (key, value) {
            $.each(value, function (day, dayval) {
              //  console.log(allpropdata[propid]);
              if (allpropdata[propid].hasOwnProperty(day)) {
                allpropdata[propid][day] += +dayval;
              } else {
                allpropdata[propid][day] = 0;
                allpropdata[propid][day] += +dayval;
              }
            });
          });

          var seriesobj = {
            name: filterdata[propid]["propname"],
            data: Object.values(allpropdata[propid]),
          };
          if (graphmodedata.hasOwnProperty(val)) {
            graphmodedata[val].push(seriesobj);
          } else {
            graphmodedata[val] = [];
            graphmodedata[val].push(seriesobj);
          }
        } else {
          var seriesobj = {
            name: filterdata[propid]["propname"],
            data: Object.values(propval[val]),
          };
          if (graphmodedata.hasOwnProperty(val)) {
            graphmodedata[val].push(seriesobj);
          } else {
            graphmodedata[val] = [];
            graphmodedata[val].push(seriesobj);
          }
        }
      });
    });
    console.log(graphmodedata);
    $.each(graphmode, function (propid, prval) {
      $.each(prval, function (key, value) {
        alldata[value] = {
          series: graphmodedata[value],
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
                columnWidth: "50%",
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
              tickAmount: 4,

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
                  return "&#8377;" + val;
                },
              },
            },
          },
        };
      });
    });
  }
  console.log(alldata);
  return (
    <>
      {true ? (
        <Box className="compare-graph">
          <TabContext value={value}>
            <Box
              className="daysettle-summary-tabs"
              style={{ borderRadius: "16px 16px 0 0" }}
            >
              <TabList
                onChange={handleChange}
                aria-label="lab API tabs example"
              >
                <Tab label="All" value="1" className={classes.root} />
                <Tab label="FOE" value="2" className={classes.root} />
                <Tab label="POS" value="3" className={classes.root} />
                
              </TabList>
            </Box>
            <TabPanel value="1">
              <Grid container item xs={12} className="">
                <div className="compare-grap-wrapper">
                  <Chart
                    options={alldata.all.options}
                    series={alldata.all.series}
                    type="bar"
                  />
                </div>
              </Grid>
            </TabPanel>
            <TabPanel value="2">
              <div className="compare-grap-wrapper">
                <Chart
                  options={alldata.foe.options}
                  series={alldata.foe.series}
                  type="bar"
                />
              </div>
            </TabPanel>
            <TabPanel value="3">
              <div className="compare-grap-wrapper">
                <Chart
                  options={alldata.pos.options}
                  series={alldata.pos.series}
                  type="bar"
                />
              </div>
            </TabPanel>
          
          </TabContext>
        </Box>
      ) : (
        <Box className="compare-graph">
          <div className="compare-grap-wrapper">
            <Chart
              options={alldata[graphmode[0]].options}
              series={alldata[graphmode[0]].series}
              type="bar"
            />
          </div>
        </Box>
      )}
    </>
  );
};

export default Hotelgrap;
