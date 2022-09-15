import "../main.css";
import { useState, useEffect } from "react";
import { useLocation } from "react-router-dom";
import Header from "../Header.js";
import Footer from "../Footer.js";
import Filter from "./Filter.js";

import Daysettlesummary from "./Daysettlesummary.js";
import { containerClasses } from "@mui/material";
const Daysummary = () => {
  const location = useLocation();
  //console.log(location);
  var propname = {
    propname: location.state.propname,
    propcity: location.state.propcity,
  };
  useEffect(() => {
    setTimeout(() => {
      document
        .querySelector("#checkindiv3")
        .classList.remove("scale-up-center");
    }, 500);
  }, []);
  var fromdate = new Date().toJSON().substring(0, 10);
  //console.log(fromdate, "fromdate");
  const [daysettledate, setDaysettledate] = useState(new Date());
  var propid = location.state.propid;
  var head = location.state.head;
  var total = location.state.total;
  var objdata = location.state.obj;
  return (
    <>
      <div
        id="checkindiv3"
        style={{ minHeight: "100vh" }}
        className="scale-up-center"
      >
        <Header
          showfilter={false}
          propname={propname}
          showdrawer={false}
          backurl="/Daysettle"
          stateval={{ ...propname, propid: propid }}
        />
        <Filter
          header={head}
          showfilter={false}
          daysettledate={daysettledate}
          setDaysettledate={setDaysettledate}
          showdate={false}
        />
        <Daysettlesummary objdata={objdata} head={head} total={total} />
        {/* <Footer propname={propname} propid={propid} /> */}
      </div>
    </>
  );
};
export default Daysummary;
