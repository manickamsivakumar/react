import React from "react";

import { Link } from "react-router-dom";
import Box from "@mui/material/Box";

import Grid from "@mui/material/Grid";

import "./main.css";

import Back from "./images/backbtn.png";

import Drawer from "./Drawer.js";
import Authalert from "./Authalert";

const Header = ({
  showfilter,
  setSelectedIndex,
  setValue,
  value,
  propname,
  showdrawer,
  backurl,
  stateval,
  userdtls
}) => {
  console.log()
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
              {showdrawer === true ? (
                <Drawer className="top-menu" />
              ) : (
                <div style={{ padding: "5px 15px 0px 15px" }}>
                  <Link to={backurl} state={stateval}>
                    <img src={Back} alt="n" height="35" width="35" />
                  </Link>
                </div>
              )}
            </Grid>
            <Grid
              className="top-header1"
              item
              xs={6}
              style={{ display: "flex" }}
            >
              {/* {showfilter === false ? <Authalert /> : ""} */}
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
                {showfilter === false ? propname.propname : "Hi "+userdtls.username}
              </h1>
              <h3 className="top-header-text" style={{ fontSize: "15px" }}>
                {showfilter ===false
                  ? propname.propcity
                  : "Welcome to SKYHMS..."}
              </h3>
            </Grid>
          </Grid>
        </Box>
      </Grid>
    </Box>
  );
};
export default Header;
