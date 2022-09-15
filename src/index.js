import React from "react";
import ReactDOM from "react-dom";
import { HashRouter as Router, Routes, Route } from "react-router-dom";

import App from "./App"; // from main dashboard
import Foe from "./FOE/Foe"; // for front office
import Daysettle from "./FOE/Daysettle.js"; // day settlement
import Fsummay from "./FOE/Fsummary.js";

import Cchkin from "./FOE/Currentchkwrap.js";
import Guestwrap from "./FOE/Guestwrap.js";
import Highbalwrap from "./FOE/Highbalwrap.js";
import Dueswrap from "./FOE/Dueswrap.js";
import Checkinlist from "./FOE/Checkinlistwrap.js";
import Ledgerwrap from "./FOE/Ledgerwrap.js";
import Daysummary from "./FOE/Daysummary.js";
import Contextpossales from "./Pos/Contextpossales.js";
import Frontview from "./Frontview.js";
import Skele from './Skeleton/Posskeleton1.js';
import Datepicker from "./Datepicker.js";
ReactDOM.render(
  <Router>
    <Routes>
      <Route path="/foe" element={<Foe />} exact />
      <Route path="/daysummary" element={<Daysummary />} exact />
      <Route path="/Daysettle" exact element={<Daysettle />} />
      <Route path="/pos" exact element={<Contextpossales />} />
      <Route path="/foearrival" exact element={<Fsummay />} />
      <Route path="/currentcheckin" exact element={<Cchkin />} />
      <Route path="/indivguest" exact element={<Guestwrap />} />
      <Route path="/checkin" exact element={<Checkinlist />} />
      <Route path="/checkout" exact element={<Checkinlist />} />
      <Route path="/highbalance" exact element={<Highbalwrap />} />
      <Route path="/dues" exact element={<Dueswrap />} />
      <Route path="/ledgerdtls" exact element={<Ledgerwrap />} />
      <Route path="/view" exact element={<Frontview />} />
      <Route path="/date" exact element={<Datepicker />} />
      <Route path="/" element={<App />} />
    </Routes>
  </Router>,
  document.getElementById("root")
);
