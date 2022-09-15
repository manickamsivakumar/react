import "../main.css";
import { useState,useEffect } from "react";
import Header from "../Header.js";
import Footer from "../Footer.js";
import Filter from "./Filter.js";
import Fsummarybody from "./Fsummarybody.js";
import Daterangewrapper from "./DaterangeWrapper.js";
import { useLocation } from "react-router-dom";

const Fsummary = () => {
  useEffect(() => {
    setTimeout(() => {
      document.querySelector("#currentchksection").classList.remove("scale-up-center");

     window.scrollTo(0, 0);
    }, 1000);
  }, []);
 
  const [value, setValue] = useState(0);
  var fromdate = new Date().toJSON().substring(0, 10);
  const [selectedIndex, setSelectedIndex] = useState({
    fromdates: fromdate,
    todates: fromdate,
  });
  const locations = useLocation();
  var propname = {
    propname: locations.state.propname,
    propcity: locations.state.propcity,
  };
  return (
    
      <div id="currentchksection" className="scale-up-center" style={{minHeight:'100vh'}}>
      <Header
        showfilter={false}
        setSelectedIndex={setSelectedIndex}
        selectedIndex={selectedIndex}
        value={value}
        propname={propname}
        showdrawer={false}
        backurl="/foe"
        stateval={{ propid: locations.state.propid, propdtls: propname }}
      />
      <Filter
        header="Front Office"
        setSelectedIndex={setSelectedIndex}
        setValue={setValue}
        value={value}
        showfilter={true}
      />
      {value == 6 ? (
        <Daterangewrapper
          setSelectedIndex={setSelectedIndex}
          selectedIndex={selectedIndex}
        />
      ) : (
        ""
      )}
      <Fsummarybody
        menuval={selectedIndex}
        value={value}
        propid={locations.state.propid}
        propname={propname}
      />
        <Footer propname={propname} propid={locations.state.propid}/>
        </div>
    
  );
};
export default Fsummary;
