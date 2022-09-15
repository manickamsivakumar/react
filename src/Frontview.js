import React from "react";
import Box from "@mui/material/Box";
import Splashbg from "./images/ic_splash_bg.svg";
export default function Frontview() {
  return (
    <Box style={{ height: "100vh" }} className="front-view-body">
      <div style={{ height: "50%" }} className="flex-center">
        <div className="flex-center1"></div>
      </div>
      <div style={{ height: "50%" }} className="flex-end">
        <img src={Splashbg} style={{ width: "100%" }} alt="bg" />
      </div>
    </Box>
  );
}
