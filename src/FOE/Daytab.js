import React from "react";
import Box from "@mui/material/Box";
import Grid from "@mui/material/Grid";

import Tab from "@mui/material/Tab";
import TabContext from "@mui/lab/TabContext";
import TabList from "@mui/lab/TabList";
import TabPanel from "@mui/lab/TabPanel";
import { makeStyles } from "@mui/styles";
import Chip from "@mui/material/Chip";
import "../main.css";
import $ from "jquery";
import SwipeableViews from "react-swipeable-views";
import { useTheme } from "@mui/material/styles";
function formatNum(numb) {
  let num = Number(numb).toLocaleString('en-IN', {
    minimumFractionDigits: 2,
    maximumFractionDigits: 2
});
  return num;
}
function DayTab({ objdata, head }) {
  var overallobj = {};
  var overalltotal = {};
  $.each(objdata, function (key, val) {
    var nameing = key.slice(0, -5);
    if (nameing === "card") {
      nameing = "creditcard";
    }

    overallobj[nameing] = {};
    overalltotal[nameing] = {};
    //   console.log(overallobj[nameing]);
    $.each(val, function (skey, sval) {
      $.each(sval, function (tkey, tval) {
        //  console.log(tval);
        if (Array.isArray(overallobj[nameing][tkey])) {
          overallobj[nameing][tkey].push(tval);
          overalltotal[nameing][tkey] += Number(tval[nameing]);
        } else {
          overallobj[nameing][tkey] = [];
          overallobj[nameing][tkey].push(tval);
          overalltotal[nameing][tkey] = 0;
          overalltotal[nameing][tkey] += Number(tval[nameing]);
        }
      });
    });
  });

  const useStyles = makeStyles({
    root: {
      height: 18,
      width: 30,
      padding: "0 0",
    },
  });
  function a11yProps(index) {
    return {
      id: `simple-tab-${index}`,
      "aria-controls": `simple-tabpanel-${index}`,
    };
  }
  const [value, setValue] = React.useState(0);

  const handleChange = (event, newValue) => {
    setValue(newValue);
  };
  const handleChangeIndex = (index) => {
    setValue(index);
  };
  const theme = useTheme();
  const transitionDuration = {
    enter: theme.transitions.duration.enteringScreen,
    exit: theme.transitions.duration.leavingScreen,
  };

  const classes = useStyles();
  var count = 0;
  var cardcount = 0;
  var bankcount = 0;
  var creditcount = 0;
  return (
    <Box sx={{ width: "100%", typography: "body1" }}>
      <TabContext value={value}>
        <Box className="daysettle-summary-tabs">
          <TabList onChange={handleChange} aria-label="lab API tabs example">
            <Tab label="CASH" className={classes.root} {...a11yProps(1)} />
            <Tab label="CARD" className={classes.root} {...a11yProps(2)} />
            <Tab label="BANK" className={classes.root} {...a11yProps(3)} />
            <Tab label="CREDIT" className={classes.root} {...a11yProps(4)} />
          </TabList>
        </Box>
        <SwipeableViews
          axis={theme.direction === "rtl" ? "x-reverse" : "x"}
          index={value}
          onChangeIndex={handleChangeIndex}
        >
          <TabPanel value={value} index={0}>
            <Box>
              {overallobj.cash && Object.keys(overallobj.cash).length > 0 ? (
                Object.keys(overallobj.cash).map((key) => {
                  count++;
                  return (
                    <>
                      <Grid
                        container
                        key={key}
                        style={{ borderBottom: "1px solid lightgray" }}
                      >
                        <Grid item xs={6}>
                          <span className="contra-in">{key}</span>
                        </Grid>
                        <Grid item xs={6}>
                          <span className="contra-amount">
                            {formatNum(overalltotal["cash"][key].toFixed(2))}
                          </span>
                        </Grid>
                      </Grid>
                      {Object.keys(overallobj.cash[key]).map((skey) => {
                        return [
                          <Grid
                            container
                            key={skey}
                            style={{
                              borderBottom: "1px solid lightgray",
                              padding: "10px 0px",
                            }}
                          >
                            <Grid item xs={6}>
                              <span className="details-header">
                                {overallobj.cash[key][skey]["roomguestname"]}
                              </span>
                            </Grid>
                            <Grid item xs={6}>
                              <span
                                className="details-header-amount"
                                style={{ float: "right" }}
                              >
                                {formatNum(overallobj.cash[key][skey]["cash"])}
                              </span>
                            </Grid>
                            <Grid item xs={8}>
                              <span className="details-body-text">
                                Receipt #:
                                {overallobj.cash[key][skey]["billno"]}
                              </span>
                            </Grid>
                            <Grid item xs={4}>
                              <Chip
                                className="cash-chip"
                                label="Cash"
                                style={{
                                  float: "right",
                                  color: "#7a7d81",
                                  background: "#A2F6FF",
                                  borderRadius: "3px !important",
                                }}
                              />
                            </Grid>
                          </Grid>,
                        ];
                      })}
                      {Object.keys(overallobj.cash).length === count ? (
                        <Grid container>
                          <Grid item xs={9}>
                            <span className="contra-in">
                              {Object.keys(overalltotal["cash"]).join("+")}
                            </span>
                          </Grid>
                          <Grid item xs={3}>
                            <span className="contra-amount">
                              {formatNum(Object.values(overalltotal["cash"]).reduce(
                                (accu, current) =>
                                  Number(current) + Number(accu)
                              ))}
                            </span>
                          </Grid>
                        </Grid>
                      ) : (
                        ""
                      )}
                    </>
                  );
                })
              ) : (
                <div style={{ textAlign: "center" }}>
                  <span className="norecords">No Records Found</span>
                </div>
              )}
            </Box>
          </TabPanel>
          <TabPanel value={value} index={1}>
            <Box>
              {overallobj.creditcard &&
              Object.keys(overallobj.creditcard).length > 0 ? (
                Object.keys(overallobj.creditcard).map((key) => {
                  cardcount++;
                  return (
                    <>
                      <Grid
                        container
                        key={key}
                        style={{ borderBottom: "1px solid lightgray" }}
                      >
                        <Grid item xs={6}>
                          <span className="contra-in">{key}</span>
                        </Grid>
                        <Grid item xs={6}>
                          <span className="contra-amount">
                            {formatNum(overalltotal["creditcard"][key].toFixed(2))}
                          </span>
                        </Grid>
                      </Grid>
                      {Object.keys(overallobj.creditcard[key]).map((skey) => {
                        return [
                          <Grid
                            container
                            key={skey}
                            style={{
                              borderBottom: "1px solid lightgray",
                              padding: "10px 0px",
                            }}
                          >
                            <Grid item xs={6}>
                              <span className="details-header">
                                {
                                  overallobj.creditcard[key][skey][
                                    "roomguestname"
                                  ]
                                }
                              </span>
                            </Grid>
                            <Grid item xs={6}>
                              <span
                                className="details-header-amount"
                                style={{ float: "right" }}
                              >
                                {formatNum(overallobj.creditcard[key][skey]["creditcard"])}
                              </span>
                            </Grid>
                            <Grid item xs={8}>
                              <span className="details-body-text">
                                Receipt #:
                                {overallobj.creditcard[key][skey]["billno"]}
                              </span>
                            </Grid>
                            <Grid item xs={4}>
                              <Chip
                                className="cash-chip"
                                label="Card"
                                style={{
                                  float: "right",
                                  background: "#C0FAC6",
                                  color: "#7a7d81",
                                  borderRadius: "3px !important",
                                }}
                              />
                            </Grid>
                          </Grid>,
                        ];
                      })}
                      {Object.keys(overallobj.creditcard).length ===
                      cardcount ? (
                        <Grid container>
                          <Grid item xs={9}>
                            <span className="contra-in">
                              {Object.keys(overalltotal["creditcard"]).join(
                                "+"
                              )}
                            </span>
                          </Grid>
                          <Grid item xs={3}>
                            <span className="contra-amount">
                              {formatNum(Object.values(overalltotal["creditcard"]).reduce(
                                (accu, current) =>
                                  Number(current) + Number(accu)
                              ))}
                            </span>
                          </Grid>
                        </Grid>
                      ) : (
                        ""
                      )}
                    </>
                  );
                })
              ) : (
                <div style={{ textAlign: "center" }}>
                  <span className="norecords">No Records Found</span>
                </div>
              )}
            </Box>
          </TabPanel>
          <TabPanel value={value} index={2}>
            <Box>
              {overallobj.bank && Object.keys(overallobj.bank).length > 0 ? (
                Object.keys(overallobj.bank).map((key) => {
                  bankcount++;
                  return (
                    <>
                      <Grid
                        container
                        key={key}
                        style={{ borderBottom: "1px solid lightgray" }}
                      >
                        <Grid item xs={6}>
                          <span className="contra-in">{key}</span>
                        </Grid>
                        <Grid item xs={6}>
                          <span className="contra-amount">
                            {formatNum(overalltotal["bank"][key].toFixed(2))}
                          </span>
                        </Grid>
                      </Grid>
                      {Object.keys(overallobj.bank[key]).map((skey) => {
                        return (
                          <Grid
                            container
                            key={skey}
                            style={{
                              borderBottom: "1px solid lightgray",
                              padding: "10px 0px",
                            }}
                          >
                            <Grid item xs={6}>
                              <span className="details-header">
                                {overallobj.bank[key][skey]["roomguestname"]}
                              </span>
                            </Grid>
                            <Grid item xs={6}>
                              <span
                                className="details-header-amount"
                                style={{ float: "right" }}
                              >
                                {formatNum(overallobj.bank[key][skey]["bank"])}
                              </span>
                            </Grid>
                            <Grid item xs={8}>
                              <span className="details-body-text">
                                Receipt #:
                                {overallobj.bank[key][skey]["billno"]}
                              </span>
                            </Grid>
                            <Grid item xs={4}>
                              <Chip
                                className="cash-chip"
                                label="Bank"
                                style={{
                                  float: "right",
                                  color: "#7a7d81",
                                  background: "#E2D0FF",
                                  borderRadius: "3px !important",
                                }}
                              />
                            </Grid>
                          </Grid>
                        );
                      })}

                      {Object.keys(overallobj.bank).length === bankcount ? (
                        <Grid container>
                          <Grid item xs={9}>
                            <span className="contra-in">
                              {Object.keys(overalltotal["bank"]).join("+")}
                            </span>
                          </Grid>
                          <Grid item xs={3}>
                            <span className="contra-amount">
                              {formatNum(Object.values(overalltotal["bank"]).reduce(
                                (accu, current) =>
                                  Number(current) + Number(accu)
                              ))}
                            </span>
                          </Grid>
                        </Grid>
                      ) : (
                        ""
                      )}
                    </>
                  );
                })
              ) : (
                <div style={{ textAlign: "center" }}>
                  <span className="norecords">No Records Found</span>
                </div>
              )}
            </Box>
          </TabPanel>
          <TabPanel value={value} index={3}>
            <Box>
              {overallobj.credit &&
              Object.keys(overallobj.credit).length > 0 ? (
                Object.keys(overallobj.credit).map((key) => {
                  creditcount++;

                  return (
                    <>
                      <Grid
                        container
                        key={key}
                        style={{ borderBottom: "1px solid lightgray" }}
                      >
                        <Grid item xs={6}>
                          <span className="contra-in">{key}</span>
                        </Grid>
                        <Grid item xs={6}>
                          <span className="contra-amount">
                            {formatNum(overalltotal["credit"][key].toFixed(2))}
                          </span>
                        </Grid>
                      </Grid>
                      {Object.keys(overallobj.credit[key]).map((skey) => {
                        return [
                          <Grid
                            container
                            key={skey}
                            style={{
                              borderBottom: "1px solid lightgray",
                              padding: "10px 0px",
                            }}
                          >
                            <Grid item xs={6}>
                              <span className="details-header">
                                {overallobj.credit[key][skey]["roomguestname"]}
                              </span>
                            </Grid>
                            <Grid item xs={6}>
                              <span
                                className="details-header-amount"
                                style={{ float: "right" }}
                              >
                                {formatNum(overallobj.credit[key][skey]["credit"])}
                              </span>
                            </Grid>
                            <Grid item xs={8}>
                              <span className="details-body-text">
                                Receipt #:
                                {overallobj.credit[key][skey]["billno"]}
                              </span>
                            </Grid>
                            <Grid item xs={4}>
                              <Chip
                                className="cash-chip"
                                label="Credit"
                                style={{
                                  float: "right",
                                  color: "#7a7d81",
                                  background: "#F2F4B7",
                                  borderRadius: "3px !important",
                                }}
                              />
                            </Grid>
                          </Grid>,
                        ];
                      })}
                      {Object.keys(overallobj.credit).length === creditcount ? (
                        <Grid container>
                          <Grid item xs={9}>
                            <span className="contra-in">
                              {Object.keys(overalltotal["credit"]).join("+")}
                            </span>
                          </Grid>
                          <Grid item xs={3}>
                            <span className="contra-amount">
                              {formatNum(Object.values(overalltotal["credit"]).reduce(
                                (accu, current) =>
                                  Number(current) + Number(accu)
                              ))}
                            </span>
                          </Grid>
                        </Grid>
                      ) : (
                        ""
                      )}
                    </>
                  );
                })
              ) : (
                <div style={{ textAlign: "center" }}>
                  <span className="norecords">No Records Found</span>
                </div>
              )}
            </Box>
          </TabPanel>
        </SwipeableViews>
      </TabContext>
    </Box>
  );
}
export default DayTab;
