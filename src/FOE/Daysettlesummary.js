import React from "react";
import "../main.css";
import Grid from "@mui/material/Grid";
import Box from "@mui/material/Box";
import Arrow from "../images/right_arrow.svg";
import Balance from "../images/ic_balance.svg";
import Income from "../images/ic_incomes.svg";
import Expenses from "../images/ic_expenses.svg";
import Daytab from "./Daytab.js";
function formatNum(numb) {
  let num = Number(numb).toLocaleString('en-IN', {
    minimumFractionDigits: 2,
    maximumFractionDigits: 2
});
  return num;
}
export default function Daysettlesummary({ objdata, head, total }) {
  console.log(total);
  return (
    <Box style={{ padding: "9px", marginBottom: "48px" }}>
      <Box className="daysettle-summary-section">
        <Grid container style={{ padding: "15px 15px 0px 15px" }}>
          <Grid item xs={1}>
            <div className="roomsection1">
              <img src={head === "Incomes" ? Income : Expenses} />
            </div>
          </Grid>
          <Grid
            item
            xs={7}
            className="fsec-body-header"
            style={{ paddingLeft: "10px" }}
          >
            <span className="sales-section-text">{head}</span>
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
            <span className="sales-section-amount1">&#8377; {formatNum(total.toFixed(2))}</span>
          </Grid>
          <Grid item xs={4} className="fsec-body-header1"></Grid>
        </Grid>

        <Grid container item xs={12}>
          <Daytab objdata={objdata} head={head} />
        </Grid>
      </Box>
    </Box>
  );
}
