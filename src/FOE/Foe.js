import React from "react";
import "../main.css";
import { useState } from "react";
import Header from "../Header.js";
import Footer from "../Footer.js";
import Filter from "./Filter.js";
import Fsec from "./Fsec.js";
import { useLocation } from "react-router-dom";
import Fsecnottoday from "./Fsecnottoday.js";
import Daterangewrapper from "./DaterangeWrapper.js";
const Foe = () => {
  //const [propname, setPropname] = useState({ propname: "", propcity: "" });

  var fromdate = new Date().toJSON().substring(0, 10);
  //console.log(fromdate, "fromdate");
  const [value, setValue] = useState(0);
  const [selectedIndex, setSelectedIndex] = useState({
    fromdates: fromdate,
    todates: fromdate,
  });
  const locations = useLocation();
  var propname = locations.state.propdtls;
  React.useEffect(() => {
    setTimeout(() => {
      document.querySelector("#foesection").classList.remove("scale-up-center");

      window.scrollTo(0, 0);
    }, 1000);
  }, []);

  //console.log(propname);
  var backurl = "/";
  return (
    <div id="foesection" className="scale-up-center" style={{minHeight:'100vh'}}>
      <Header
        showfilter={false}
        setSelectedIndex={setSelectedIndex}
        setValue={setValue}
        value={value}
        propname={propname}
        showdrawer={false}
        backurl={backurl}
      />
      <Filter
        header="Front Office"
        setSelectedIndex={setSelectedIndex}
        setValue={setValue}
        value={value}
        showfilter={true}
        showdate={false}
      />

      {value === 6 ? (
        <Daterangewrapper
          setSelectedIndex={setSelectedIndex}
          selectedIndex={selectedIndex}
        />
      ) : (
        ""
      )}
      {value != 0 ? (
        <Fsecnottoday
          menuval={selectedIndex}
          value={value}
          propid={locations.state.propid}
        />
      ) : (
        <Fsec
          menuval={selectedIndex}
          value={value}
          propid={locations.state.propid}
          propname={propname}
        />
      )}
      <Footer
        propname={propname}
        propid={locations.state.propid}
        isdatsettle={false}
      />
    </div>
  );
};
export default Foe;
