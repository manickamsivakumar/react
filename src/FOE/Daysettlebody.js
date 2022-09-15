import React from "react";
import "../main.css";
import Grid from "@mui/material/Grid";
import Box from "@mui/material/Box";
import Arrow from "../images/right_arrow.svg";
import Balance from "../images/ic_balance.svg";
import Income from "../images/ic_incomes.svg";
import Expenses from "../images/ic_expenses.svg";
import Skelt from "../Skeleton/Daysettleskele.js";
import $ from "jquery";
import { Link } from "react-router-dom";
function formatNum(numb) {
  let num = Number(numb).toLocaleString('en-IN', {
    minimumFractionDigits: 2,
    maximumFractionDigits: 2
});
  return num;
}

export default function Daysettlebody({ daysettledate, propid, propname }) {
  // console.log(daysettledate);
  // console.log(propid);
  const [showskeleton, setShowskeleton] = React.useState(1);
  var baseurl = process.env.REACT_APP_BASE_URL;
  const [daysettle, setDaysettle] = React.useState({});
  var today = new Date(daysettledate).toISOString().substring(0, 10);

  React.useEffect(() => {
    getfoedata(today, propid);
  }, [daysettledate]);
  const getfoedata = (today, propid) => {
    $.ajax({
      url: baseurl + "Cdaysettle",
      type: "post",
      data: {
        today,
        propid,
      },
      datatype: "JSON",
      beforeSend: function () {
        setShowskeleton(1);
      },
      success: function (res) {
        setDaysettle(JSON.parse(res));
      },
      complete: function () {
        setShowskeleton(0);
      },
      error: function () { },
    });
  };
  var settleobj = {};
  settleobj["expence"] = {};
  settleobj["income"] = {};

  settleobj["income"]["casharray"] = [];
  settleobj["expence"]["casharray"] = [];
  settleobj["income"]["cardarray"] = [];
  settleobj["expence"]["cardarray"] = [];
  settleobj["income"]["bankarray"] = [];
  settleobj["expence"]["bankarray"] = [];

  settleobj["income"]["creditarray"] = [];
  settleobj["expence"]["creditarray"] = [];
  var income = ["advance", "contra-in", "receipt"];
  var expence = ["payment", "contra-out", "refund"];
  var incomecash = 0;
  var incomecard = 0;
  var incomebank = 0;
  var incomecredit = 0;
  var expensecash = 0;
  var expensecard = 0;
  var expensebank = 0;
  var expensecredit = 0;
  $.each(daysettle.settle, function (key, value) {
    //hgh

    var keys = key;
    //console.log(keys);
    $.each(value, function (objkeys, objvalues) {
      // console.log(objvalues);

      if (income.includes(keys)) {
        if (Number(objvalues["cash"])) {
          // console.log(keys);
          var obj = {};
          obj[keys] = objvalues;
          settleobj["income"]["casharray"].push(obj);
          incomecash += +objvalues["cash"];
        }
        if (Number(objvalues["creditcard"])) {
          var obj = {};
          obj[keys] = objvalues;
          settleobj["income"]["cardarray"].push(obj);
          incomecard += +objvalues["creditcard"];
        }
        if (Number(objvalues["bank"])) {
          var obj = {};
          obj[keys] = objvalues;
          settleobj["income"]["bankarray"].push(obj);
          incomebank += +objvalues["bank"];
        }
        if (Number(objvalues["credit"])) {
          var obj = {};
          obj[keys] = objvalues;
          //console.log(objvalues['cash']);
          settleobj["income"]["creditarray"].push(obj);
          incomecredit += +objvalues["credit"];
        }
      } else if (expence.includes(keys)) {
        if (Number(objvalues["cash"])) {
          // console.log(objvalues['cash']);
          var obj = {};
          obj[keys] = objvalues;
          settleobj["expence"]["casharray"].push(obj);
          expensecash += +objvalues["cash"];
        }
        if (Number(objvalues["creditcard"])) {
          var obj = {};
          obj[keys] = objvalues;
          settleobj["expence"]["cardarray"].push(obj);
          expensecard += +objvalues["creditcard"];
        }
        if (Number(objvalues["bank"])) {
          var obj = {};
          obj[keys] = objvalues;
          settleobj["expence"]["bankarray"].push(obj);
          expensebank += +objvalues["bank"];
        }
        if (Number(objvalues["credit"])) {
          var obj = {};
          obj[keys] = objvalues;
          //console.log(objvalues['cash']);
          settleobj["expence"]["creditarray"].push(obj);
          expensecredit += +objvalues["credit"];
        }
      }
    });
  });
  console.log(settleobj);
  console.log(daysettle);
  var openingbalance =
    daysettle && daysettle.props ? daysettle.props.openingbalance : 0;
  var incomes = incomecash + incomecard + incomebank;
  var expenses = expensecash + expensecard + expensebank;
  var closingbalance =
    Number(openingbalance) + Number(incomes) - Number(expenses);
  return (
    <>
    {showskeleton ? <Skelt/> : 
    
    <Box style={{ padding: "12px", marginBottom: "48px" }}>
      { daysettle && daysettle.props && +daysettle.props.openbalcheck ==1 ? <Box className="daysettle-balance-section">
        <Grid container style={{ padding: "15px 15px 0px 15px" }}>
          <Grid item xs={1}>
            <div className="roomsection1">
              <img src={Balance} />
            </div>
          </Grid>
          <Grid
            item
            xs={7}
            className="fsec-body-header"
            style={{ paddingLeft: "10px" }}
          >
            <span className="sales-section-text">Opening Balance</span>
          </Grid>
          <Grid item xs={4} className="fsec-body-header1"></Grid>
        </Grid>
        <Grid container style={{ paddingBottom: "20px" }}>
          <Grid item xs={1}></Grid>
          <Grid
            item
            xs={7}
            className="fsec-body-header"
            style={{ paddingLeft: "23px" }}
          >
            <span className="sales-section-amount1">
              &#8377;
              {daysettle && daysettle.props
                ? formatNum(Number(daysettle.props.openingbalance).toFixed(2))
                : 0}
            </span>
          </Grid>
          <Grid item xs={4} className="fsec-body-header1"></Grid>
        </Grid>
        <Grid item xs={6}></Grid>
      </Box> : '' }
      <Link
        to="/daysummary"
        style={{ textDecoration: "none" }}
        state={{
          ...propname,
          propid: propid,
          obj: settleobj.income,
          head: "Incomes",
          total: incomes,
        }}
      >
        <Box className="revenue-section">
          <Grid container style={{ padding: "15px 15px 0px 15px" }}>
            <Grid item xs={1}>
              <div className="roomsection1">
                <img src={Income} />
              </div>
            </Grid>
            <Grid
              item
              xs={7}
              className="fsec-body-header"
              style={{ paddingLeft: "10px" }}
            >
              <span className="sales-section-text">Income</span>
            </Grid>
            <Grid item xs={4} className="fsec-body-header1">
              <img src={Arrow} />
            </Grid>
          </Grid>
          <Grid container style={{ paddingBottom: "20px" }}>
            <Grid item xs={1}></Grid>
            <Grid
              item
              xs={7}
              className="fsec-body-header"
              style={{ paddingLeft: "23px" }}
            >
              <span className="sales-section-amount1">
                &#8377; {formatNum(incomes.toFixed(2))}
              </span>
            </Grid>
            <Grid item xs={4} className="fsec-body-header1"></Grid>
          </Grid>
          <Grid item xs={6}></Grid>
          <Grid container item xs={12} className="sales-section-details">
            <Grid
              item
              xs={3}
              className="sales-section-amount-details"
              style={{ borderRight: "3px solid white" }}
            >
              <div>
                <div className="sales-section-amount-details-name">By Cash</div>
                <div className="sales-section-amount-details-value1">
                  &#8377; {incomecash.toFixed(2)}
                </div>
              </div>
            </Grid>
            <Grid
              item
              xs={3}
              className="sales-section-amount-details"
              style={{ borderRight: "3px solid white" }}
            >
              <div>
                <div className="sales-section-amount-details-name">By Card</div>
                <div className="sales-section-amount-details-value1">
                  &#8377; {incomecard.toFixed(2)}
                </div>
              </div>
            </Grid>
            <Grid item xs={3} className="sales-section-amount-details">
              <div>
                <div className="sales-section-amount-details-name">By Bank</div>
                <div className="sales-section-amount-details-value1">
                  &#8377; {incomebank.toFixed(2)}
                </div>
              </div>
            </Grid>
            <Grid
              item
              xs={3}
              className="sales-section-amount-details"
              style={{ borderRight: "3px solid white" }}
            >
              <div>
                <div className="sales-section-amount-details-name">
                  By Credit
                </div>
                <div className="sales-section-amount-details-value1">
                  &#8377; {incomecredit.toFixed(2)}
                </div>
              </div>
            </Grid>
          </Grid>
        </Box>
      </Link>
      <Link
        to="/daysummary"
        style={{ textDecoration: "none" }}
        state={{
          ...propname,
          propid: propid,
          obj: settleobj.expence,
          head: "Expenses",
          total: expenses,
        }}
      >
        <Box className="revenue-section">
          <Grid container style={{ padding: "15px 15px 0px 15px" }}>
            <Grid item xs={1}>
              <div className="roomsection1">
                <img src={Expenses} />
              </div>
            </Grid>
            <Grid
              item
              xs={7}
              className="fsec-body-header"
              style={{ paddingLeft: "10px" }}
            >
              <span className="sales-section-text">Expenses</span>
            </Grid>
            <Grid item xs={4} className="fsec-body-header1">
              <img src={Arrow} />
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
                &#8377; {formatNum(expenses.toFixed(2))}
              </span>
            </Grid>
            <Grid item xs={4} className="fsec-body-header1"></Grid>
          </Grid>
          <Grid item xs={6}></Grid>
          <Grid container item xs={12} className="sales-section-details">
            <Grid
              item
              xs={3}
              className="sales-section-amount-details"
              style={{ borderRight: "3px solid white" }}
            >
              <div>
                <div className="sales-section-amount-details-name">By Cash</div>
                <div className="sales-section-amount-details-value1">
                  &#8377; {expensecash.toFixed(2)}
                </div>
              </div>
            </Grid>
            <Grid
              item
              xs={3}
              className="sales-section-amount-details"
              style={{ borderRight: "3px solid white" }}
            >
              <div>
                <div className="sales-section-amount-details-name">By Card</div>
                <div className="sales-section-amount-details-value1">
                  &#8377; {expensecard.toFixed(2)}
                </div>
              </div>
            </Grid>
            <Grid item xs={3} className="sales-section-amount-details">
              <div>
                <div className="sales-section-amount-details-name">By Bank</div>
                <div className="sales-section-amount-details-value1">
                  &#8377; {expensebank.toFixed(2)}
                </div>
              </div>
            </Grid>
            <Grid
              item
              xs={3}
              className="sales-section-amount-details"
              style={{ borderRight: "3px solid white" }}
            >
              <div>
                <div className="sales-section-amount-details-name">
                  By Credit
                </div>
                <div className="sales-section-amount-details-value1">
                  &#8377; {expensecredit.toFixed(2)}
                </div>
              </div>
            </Grid>
          </Grid>
        </Box>
      </Link>
      <Box className="daysettle-balance-section" style={{marginBottom:'20px'}}>
        <Grid container style={{ padding: "15px 15px 0px 15px" }}>
          <Grid item xs={1}>
            <div className="roomsection1">
              <img src={Balance} />
            </div>
          </Grid>
          <Grid
            item
            xs={7}
            className="fsec-body-header"
            style={{ paddingLeft: "10px" }}
          >
            <span className="sales-section-text">Closing Balance</span>
          </Grid>
          <Grid item xs={4} className="fsec-body-header1"></Grid>
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
              &#8377; {formatNum(closingbalance.toFixed(2))}
            </span>
          </Grid>
          <Grid item xs={4} className="fsec-body-header1"></Grid>
        </Grid>
        <Grid item xs={6}></Grid>
      </Box>
    </Box>}
    </>
  );
}
