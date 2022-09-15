import "../main.css";
import React from "react";
import { useLocation } from "react-router-dom";
import Header from "../Header.js";

import Filter from "./Filter.js";

import Highbal from "./Highbal.js";
const Highbalwrap = () => {
  const location = useLocation();
  const [highbal, setHighbal] = React.useState([]);
  const [searchhighbal, setSearchhighbal] = React.useState(highbal);
  React.useEffect(() => {
    setTimeout(() => {
      document.querySelector("#highbaldiv").classList.remove("scale-up-center");
    }, 1000);
  }, []);
  // console.log(location);
  var propname = {
    propname: location.state.propname,
    propcity: location.state.propcity,
  };

  var propid = location.state.propid;

  return (
    <>
      <div
        id="highbaldiv"
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
          header="High Balance"
          showfilter={false}
          showsearch={true}
          highbal={highbal}
          searchhighbal={searchhighbal}
          setSearchhighbal={setSearchhighbal}
          fromchkinlist={false}
        />
        <Highbal
          propid={propid}
          propname={propname}
          highbal={highbal}
          setHighbal={setHighbal}
          setSearchhighbal={setSearchhighbal}
          searchhighbal={searchhighbal}
        />
      </div>
    </>
  );
};
export default Highbalwrap;
