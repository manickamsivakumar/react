import React from "react";
import { useState } from "react";
import Box from "@mui/material/Box";

import Grid from "@mui/material/Grid";
import "./headercss.css";

import Approval from "./ic_approval.svg";
import Alert from "./ic_notification.svg";

const Header = ({ propname }) => {
  return (
    <Box sx={{ flexGrow: 1 }}>
      <Grid className="header" item xs={12}>
        <Box>
          <Grid container>
            <Grid
              className="top-header"
              item
              xs={6}
              style={{ display: "flex" }}
                      >
                          
            </Grid>
            <Grid
              className="top-header1"
              item
              xs={6}
              style={{ display: "flex" }}
            >
              <div className="flex-content" style={{ marginRight: "10px" }}>
                <img src={Approval} />
                <img src={Alert} />
              </div>
            </Grid>
          </Grid>
          <Grid container>
            <Grid
              className="top-head"
              style={{ paddingLeft: "19px" }}
              item
              xs={12}
            >
              <h1 className="top-header-text" style={{ fontSize: "24px" }}>
                {1 ? propname.propname : "Hi manickam"}
              </h1>
              <h3 className="top-header-text" style={{ fontSize: "15px" }}>
                {1 ? propname.propcity : "You have 2 pending requests"}
              </h3>
            </Grid>
          </Grid>
        </Box>
      </Grid>
    </Box>
  );
};
export default Header;
