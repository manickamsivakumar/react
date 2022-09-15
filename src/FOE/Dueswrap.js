import "../main.css";
import React from "react";
import { useLocation } from "react-router-dom";
import Header from "../Header.js";

import Filter from "./Filter.js";

import Outstand from "./Outstand.js";
var fromdate = new Date().toJSON().substring(0, 10);
//console.log(fromdate, "fromdate");

const Dueswrap = () => {
  const [daysettledate, setDaysettledate] = React.useState(new Date());
  const location = useLocation();
  // console.log(location);
  var propname = {
    propname: location.state.propname,
    propcity: location.state.propcity,
  };

  var propid = location.state.propid;
  React.useEffect(() => {
    setTimeout(() => {
      document
        .querySelector("#duesectiondiv1")
        .classList.remove("scale-up-center");
    }, 1000);
  }, []);

  return (
    <>
      <div
        id="duesectiondiv1"
        style={{ minHeight: "100vh" }}
        className="scale-up-center"
      >
        <Header
          showfilter={false}
          propname={propname}
          showdrawer={false}
          backurl="/foe"
          stateval={{ propid: propid, propdtls: propname }}
        />
        <Filter
          header="Out Standing"
          showfilter={false}
          daysettledate={daysettledate}
          setDaysettledate={setDaysettledate}
          showdate={true}
        />
        <Outstand
          propid={propid}
          daysettledate={daysettledate}
          propname={propname}
        />
      </div>
    </>
  );
};
export default Dueswrap;
