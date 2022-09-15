import React from "react";
import ReactDOM from "react-dom";
import { BrowserRouter as Router, Routes, Route } from "react-router-dom";

import App from "./App"; // from main dashboard
import Foe from "./FOE/Foe"; // for front office
import Daysettle from "./FOE/Daysettle.js"; // day settlement
import Fsummay from "./FOE/Fsummary.js";
import Frontview from "./Frontview.js";
import Frontviewdash from "./Frontviewdash.js";
ReactDOM.render(
  <Router>
    <Routes>
      <Route path="/" element={<App />} exact />
      <Route path="/frontoffice" element={<Foe />} exact />
    </Routes>
  </Router>,
  document.getElementById("root")
);
