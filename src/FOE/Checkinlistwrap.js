import "../main.css";
import React from "react";
import { useLocation } from "react-router-dom";
import Header from "../Header.js";
import Footer from "../Footer.js";
import Filter from "./Filter.js";
import Checkinlist from "./Checkinlist.js";

const Checkinlistwrap = () => {
  const location = useLocation();
  console.log(location);
  var propname = {
    propname: location.state.propname,
    propcity: location.state.propcity,
  };

  var propid = location.state.propid;

  var flag = location.state.flag;
  var header = "Check In";
  var api_url = "getcheckin";
  if (flag === 0) {
    header = "Check Out";
    api_url = "getcheckout";
  }
  React.useEffect(() => {
    setTimeout(() => {
      document.querySelector("#checkindiv").classList.remove("scale-up-center");
    }, 500);
  }, []);

  return (
    <>
      <div
        id="checkindiv"
        style={{ minHeight: "100vh" }}
        className="scale-up-center"
      >
        <Header
          showfilter={false}
          propname={propname}
          showdrawer={false}
          backurl="/foe"
          stateval={{
            propname: propname,
            propdtls: propname,
            propid: propid,
            flag: flag,
          }}
        />
        <Filter header={header} showfilter={false} showdate={false} />

        <Checkinlist propid={propid} propname={propname} apiurl={api_url} />

        <Footer propname={propname} propid={propid} />
      </div>
    </>
  );
};
export default Checkinlistwrap;
