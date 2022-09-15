import "../main.css";
import { useState } from "react";
import { useLocation } from "react-router-dom";
import Header from "../Header.js";
import Footer from "../Footer.js";
import Filter from "./Filter.js";
import Guestdetails from "./Guestdetails.js";
import FloatBtn from "./Floatingbtn.js";
const Guestwrap = () => {
  const location = useLocation();
  // console.log(location);
  var propname = {
    propname: location.state.propname,
    propcity: location.state.propcity,
  };

  var propid = location.state.propid;
  var trnid = location.state.trnid;
  var sts = location.state.sts;
  var backurl = location.state.backurl;
  return (
    <>
      <Header
        showfilter={false}
        propname={propname}
        showdrawer={false}
        backurl={backurl}
        stateval={{ ...propname, propid: propid, flag: sts }}
      />
      <Filter header="Guest Details" showfilter={false} />
      <Guestdetails propid={propid} trnid={trnid} sts={sts} />
    </>
  );
};
export default Guestwrap;
