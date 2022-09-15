import "../main.css";
import { useState } from "react";
import { useLocation } from "react-router-dom";
import Header from "../Header.js";
import Footer from "../Footer.js";
import Filter from "./Filter.js";
import Guestdetails from "./Guestdetails.js";

const Indivguest = () => {
  const location = useLocation();
  // console.log(location);
  var propname = {
    propname: location.state.propname,
    propcity: location.state.propcity,
  };

  var propid = location.state.propid;
  var trnid = location.state.trnid;
  return (
    <>
      <Header showfilter={false} propname={propname} />
      <Filter header="Guest Details" showfilter={false} />
      <Guestdetails propid={propid} trnid={trnid} />
     
    </>
  );
};
export default Indivguest;
