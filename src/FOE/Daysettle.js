import "../main.css";
import { useState, useEffect } from "react";
import { useLocation } from "react-router-dom";
import Header from "../Header.js";
import Footer from "../Footer.js";
import Filter from "./Filter.js";
import Daysettlebody from "./Daysettlebody.js";

const Daysettle = () => {
  const location = useLocation();

  var propname = {
    propname: location.state.propname,
    propcity: location.state.propcity,
  };
  useEffect(() => {
    setTimeout(() => {
      document
        .querySelector("#checkindiv1")
        .classList.remove("scale-up-center");
    }, 500);
  }, []);
  var fromdate = new Date().toJSON().substring(0, 10);

  const [daysettledate, setDaysettledate] = useState(new Date());
  var propid = location.state.propid;

  return (
    <>
      <div
        id="checkindiv1"
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
          header="Day Settlement"
          showfilter={false}
          daysettledate={daysettledate}
          setDaysettledate={setDaysettledate}
          showdate={true}
        />
        <Daysettlebody
          daysettledate={daysettledate}
          propid={propid}
          propname={propname}
        />
        <Footer propname={propname} propid={propid} isdatsettle={true} />
      </div>
    </>
  );
};
export default Daysettle;
