import React from "react";
import { styled } from "@mui/material/styles";
import Box from "@mui/material/Box";
import Paper from "@mui/material/Paper";
import Grid from "@mui/material/Grid";
import Logo from "./images/logo.png";
import Splashbg from "./images/ic_splash_bg.svg";
import Frontoffice from "./images/ic_frontoffice.svg";
import HouseKepping from "./images/ic_housekeeping.svg";
import Mis from "./images/ic_MIS.svg";
export default function Frontviewdash() {
  const Item = styled(Paper)(({ theme }) => ({
    backgroundColor: theme.palette.mode === "dark" ? "#1A2027" : "#fff",
    ...theme.typography.body2,
    padding: theme.spacing(1),
    textAlign: "center",
    color: theme.palette.text.secondary,
  }));
  return (
    <Box style={{ height: "100vh" }} className="front-view-body">
      <div style={{ height: "30%" }} className="flex-both-center ">
        <div className="flex-center1"></div>
      </div>
      <div style={{ height: "40%" }}>
        <div>
          <Grid container spacing={1} style={{ padding: "0px 15px" }}>
            <Grid item xs={6} style={{ padding: "0px 0px" }}>
              <div className="frontoffice-logo">
                <Grid container>
                  <Grid
                    item
                    xs={12}
                    className="flex-both-center"
                    style={{
                      padding: "10px",
                    }}
                  >
                    <img src={Frontoffice} alt="foe" />
                  </Grid>
                  <Grid
                    item
                    xs={12}
                    className="flex-both-center"
                    style={{
                      padding: "5px",
                    }}
                  >
                    <span className="frontdash-text">FrontOffice</span>
                  </Grid>
                </Grid>
              </div>
            </Grid>

            <Grid item xs={6}>
              <div className="housekeeping-logo">
                <Grid container>
                  <Grid
                    item
                    xs={12}
                    className="flex-both-center"
                    style={{
                      padding: "10px",
                    }}
                  >
                    <img src={HouseKepping} alt="hsk" />
                  </Grid>
                  <Grid
                    item
                    xs={12}
                    className="flex-both-center"
                    style={{
                      padding: "5px",
                    }}
                  >
                    <span className="frontdash-text">House Keeping</span>
                  </Grid>
                </Grid>
              </div>
            </Grid>
          </Grid>
          <Grid
            container
            spacing={0}
            item
            xs={12}
            className="box-center"
            style={{ padding: "0px 15px" }}
          >
            <Grid item xs={6} style={{ padding: "0px 0px" }}>
              <div className="mis-logo">
                <Grid container>
                  <Grid
                    item
                    xs={12}
                    className="flex-both-center"
                    style={{
                      padding: "10px",
                    }}
                  >
                    <img src={Mis} alt="mis" />
                  </Grid>
                  <Grid
                    item
                    xs={12}
                    className="flex-both-center"
                    style={{
                      padding: "5px",
                    }}
                  >
                    <span className="frontdash-text">MIS</span>
                  </Grid>
                </Grid>
              </div>
            </Grid>
          </Grid>
        </div>
      </div>
      <div style={{ height: "30%" }} className="flex-end">
        <img src={Splashbg} style={{ width: "100%" }} />
      </div>
    </Box>
  );
}
