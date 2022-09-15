import React from "react";

import { Link } from "react-router-dom";
import Box from "@mui/material/Box";

import Grid from "@mui/material/Grid";

import "./main.css";
import Menudaysettle from "./images/ic_menu_daysettle_inactive.svg";
import Menusales from "./images/ic_menu_sales_active.svg";
import Menudaysettle_a from "./images/ic_menu_daysettle_active.svg";
import Menusales_ia from "./images/ic_menu_sales_inactive.svg";

const Footer = ({ propname, propid, isdatsettle }) => {
  return (
    <Box sx={{ flexGrow: 1 }}>
      <Grid container className="footer" item xs={12}>
        <Grid item xs={6} className="footer-box">
          <div>
            <Link
              to="/foe"
              state={{ propid: propid, propdtls: propname }}
              style={{ color: "inherit", textDecoration: "inherit" }}
            >
              {isdatsettle ? (
                <img src={Menusales_ia} alt="inactive" />
              ) : (
                <img src={Menusales} alt="sales" />
              )}
              <span
                className={isdatsettle ? "footer-text" : "footer-text-active"}
              >
                Sales
              </span>
            </Link>
          </div>
        </Grid>
        <Grid item xs={6} className="footer-box">
          <Link
            to="/Daysettle"
            state={{ ...propname, propid: propid }}
            style={{ color: "inherit", textDecoration: "inherit" }}
          >
            <div>
              {isdatsettle ? (
                <img src={Menudaysettle_a} alt="active" />
              ) : (
                <img src={Menudaysettle} alt="sales" />
              )}
              <span
                className={isdatsettle ? "footer-text-active" : "footer-text"}
              >
                Day Settle
              </span>
            </div>
          </Link>
        </Grid>
      </Grid>
    </Box>
  );
};
export default Footer;
