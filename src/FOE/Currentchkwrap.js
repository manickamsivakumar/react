import "../main.css";
import React from "react";
import { useLocation } from "react-router-dom";
import Header from "../Header.js";
import Footer from "../Footer.js";
import Filter from "./Filter.js";
import Chkinlist from "./Currentchkinlist";
const Currentchkerap = () => {
  React.useEffect(() => {
    setTimeout(() => {
      document.querySelector("#currentchksection").classList.remove("scale-up-center");

      window.scrollTo(0, 0);
    }, 1000);
  }, []);
  const location = useLocation();
  console.log(location);
  const [checkinlist, setCheckinlist] = React.useState([]);
  const [srchlist, setSrchlist] = React.useState([]);
  var propname = {
    propname: location.state.propname,
    propcity: location.state.propcity,
  };

  var fromdate = new Date().toJSON().substring(0, 10);

  var propid = location.state.propid;
  return (
    <>
    <div id="currentchksection" className="scale-up-center">
      <Header
        showfilter={false}
        propname={propname}
        showdrawer={false}
        backurl="/foe"
        stateval={{ propid: propid, propdtls: propname }}
      />
      <Filter
        header="Occupancy List"
        showfilter={false}
        showdate={false}
        showsearch={true}
        checkinlist={checkinlist}
        setSrchlist={setSrchlist}
        fromchkinlist={true}
      />
      <Chkinlist
        propid={propid}
        propname={propname}
        srchlist={srchlist}
        setCheckinlist={setCheckinlist}
        setSrchlist={setSrchlist}
      />
      <Footer propname={propname} propid={propid} />
      </div>
    </>
  );
};
export default Currentchkerap;
