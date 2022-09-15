import "./App.css";
import { useState, Suspense, useEffect } from "react";
import Header from "./Header.js";
import Tab from "./Tab.js";
import Dash from "./Frontview.js";
import { SwitchTransition, CSSTransition } from "react-transition-group";
import Daterangewrapper from "./FOE/DaterangeWrapper.js";
const App = () => {
  const [value, setValue] = useState(0);
  const [dash, showDash] = useState(true);
  const [userdtls,setUserdtls]=useState({username:'',userid:''})
  var fromdate = new Date().toJSON().substring(0, 10);
  useEffect(() => {
    setTimeout(() => {
      document.getElementById("dashboard").classList.add("scale-up-center");
      showDash((state) => !state);
    }, 1000);
    setTimeout(() => {
      document.getElementById("page-wrap").classList.remove("scale-up-center");
    }, 1800);
  }, []);
  console.log(fromdate, "fromdate");
  const [selectedIndex, setSelectedIndex] = useState({
    fromdates: fromdate,
    todates: fromdate,
  });
  console.log(dash);
  return (
    <>
      {/* <SwitchTransition>
        <CSSTransition
          in={dash}
          addEndListener={(node, done) => {
            node.addEventListener("transitionend", done, false);
          }}
          timeout={1300}
          classNames="fade"
        > */}
      <div>
        {dash ? (
          <div id="dashboard">
            <Dash />
          </div>
        ) : (
          <div id="page-wrap" className="scale-up-center">
            <Header
              showfilter="1"
              setSelectedIndex={setSelectedIndex}
              setValue={setValue}
              showdrawer={true}
              backurl={""}
              userdtls={userdtls}
            />
            {value == 6 ? (
              <Daterangewrapper
                setSelectedIndex={setSelectedIndex}
                selectedIndex={selectedIndex}
              />
            ) : (
              ""
            )}
            <Tab
              selectedIndex={selectedIndex}
              setSelectedIndex={setSelectedIndex}
              setValue={setValue}
              value={value}
              setUserdtls={setUserdtls}
              userdtls={userdtls}
            />
          </div>
        )}
      </div>
      {/* </CSSTransition>
      </SwitchTransition> */}
    </>
  );
};
export default App;
