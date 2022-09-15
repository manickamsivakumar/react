import "../main.css";
import React from "react";
import { useLocation } from "react-router-dom";
import Header from "../Header.js";

import Filter from "./Filter.js";

import Ledger from "./Ledger.js";
var fromdate = new Date().toJSON().substring(0, 10);
//console.log(fromdate, "fromdate");

const Ledgerwrap = () => {
  const [daysettledate, setDaysettledate] = React.useState(new Date());
  const location = useLocation();
  // console.log(location);
  var propname = {
    propname: location.state.propname,
    propcity: location.state.propcity,
  };

  var propid = location.state.propid;
  var today = location.state.today;
  var ledgerid = location.state.ledgerid;
  console.log(location);
  React.useEffect(() => {
    setTimeout(() => {
      document
        .querySelector("#duesectiondiv")
        .classList.remove("scale-up-center");
    }, 1000);
  }, []);

  return (
    <>
      <div
        id="duesectiondiv"
        style={{ minHeight: "100vh" }}
        className="scale-up-center"
      >
        <Header
          showfilter={false}
          propname={propname}
          showdrawer={false}
          backurl="/dues"
          stateval={{ ...propname, propid: propid }}
        />
        <Filter header="Ledger Details" showfilter={false} showdate={false} />
        <Ledger propid={propid} ledgerid={ledgerid} today={today} />
      </div>
    </>
  );
};
export default Ledgerwrap;
