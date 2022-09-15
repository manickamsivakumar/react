import React from "react";
import Grid from "@mui/material/Grid";
import "../main.css";
import Skeleton from "@mui/material/Skeleton";
import Box from "@mui/material/Box";

export default function Daysettleskele() {
    

    return (
        <Box style={{ padding: "12px", marginBottom: "48px" }}>
        <Box className="daysettle-balance-section" style={{ marginBottom: "15px" }}>
          <Grid container style={{ padding: "15px 15px 0px 15px" }}>
            <Grid item xs={1}>
              <div className="roomsection1">
              <Skeleton
                  animation="wave"
                  className="placeholder-animation"
                  variant="circular"
                  width={30}
                  height={30}
                />
              </div>
            </Grid>
            <Grid
              item
              xs={7}
              className="fsec-body-header"
              style={{ paddingLeft: "10px" }}
            >
                <Skeleton
                    animation="wave"
                    height={30}
                    className="placeholder-animation"
                    width="80%"
                  />
            </Grid>
            <Grid item xs={4} className="fsec-body-header1"></Grid>
          </Grid>
          <Grid container style={{ paddingBottom: "20px" }}>
            <Grid item xs={1}></Grid>
            <Grid
              item
              xs={7}
              className="fsec-body-header"
              style={{ paddingLeft: "23px" }}
            >
               <Skeleton
                    animation="wave"
                    height={35}
                    className="placeholder-animation"
                    width="90%"
                  />
            </Grid>
            <Grid item xs={4} className="fsec-body-header1"></Grid>
          </Grid>
          <Grid item xs={6}></Grid>
        </Box> 
          <Box className="revenue-section" style={{ marginBottom: "25px" }}>
            <Grid container style={{ padding: "15px 15px 0px 15px" }}>
              <Grid item xs={1}>
                <div className="roomsection1">
                <Skeleton
                  animation="wave"
                  className="placeholder-animation"
                  variant="circular"
                  width={30}
                  height={30}
                />
                </div>
              </Grid>
              <Grid
                item
                xs={7}
                className="fsec-body-header"
                style={{ paddingLeft: "10px" }}
              >
  <Skeleton
                    animation="wave"
                    height={30}
                    className="placeholder-animation"
                    width="80%"
                  />
              </Grid>
              <Grid item xs={4} className="fsec-body-header1">
                
              </Grid>
            </Grid>
            <Grid container style={{ paddingBottom: "10px" }}>
              <Grid item xs={1}></Grid>
              <Grid
                item
                xs={7}
                className="fsec-body-header"
                style={{ paddingLeft: "23px" }}
              >
                 <Skeleton
                    animation="wave"
                    height={35}
                    className="placeholder-animation"
                    width="90%"
                  />
              </Grid>
              <Grid item xs={4} className="fsec-body-header1"></Grid>
            </Grid>
            <Grid item xs={6}></Grid>
            <Grid container item xs={12} className="sales-section-details">
            <Grid
              item
              xs={3}
              className="sales-section-amount-details"
              
            >
           
            </Grid>
            <Grid
              item
              xs={3}
              className="sales-section-amount-details"
              
            >
            </Grid>
            <Grid item xs={3} className="sales-section-amount-details">
              
            </Grid>
            <Grid
              item
              xs={3}
              className="sales-section-amount-details"
            
            >
              
            </Grid>
                   
           
            </Grid>
          </Box>
          <Box className="revenue-section" style={{ marginBottom: "25px" }}>
            <Grid container style={{ padding: "15px 15px 0px 15px" }}>
              <Grid item xs={1}>
                <div className="roomsection1">
                <Skeleton
                  animation="wave"
                  className="placeholder-animation"
                  variant="circular"
                  width={30}
                  height={30}
                />
                </div>
              </Grid>
              <Grid
                item
                xs={7}
                className="fsec-body-header"
                style={{ paddingLeft: "10px" }}
              >
  <Skeleton
                    animation="wave"
                    height={30}
                    className="placeholder-animation"
                    width="80%"
                  />
              </Grid>
              <Grid item xs={4} className="fsec-body-header1">
                
              </Grid>
            </Grid>
            <Grid container style={{ paddingBottom: "10px" }}>
              <Grid item xs={1}></Grid>
              <Grid
                item
                xs={7}
                className="fsec-body-header"
                style={{ paddingLeft: "23px" }}
              >
                 <Skeleton
                    animation="wave"
                    height={35}
                    className="placeholder-animation"
                    width="90%"
                  />
              </Grid>
              <Grid item xs={4} className="fsec-body-header1"></Grid>
            </Grid>
            <Grid item xs={6}></Grid>
            <Grid container item xs={12} className="sales-section-details">
            <Grid
              item
              xs={3}
              className="sales-section-amount-details"
              
            >
           
            </Grid>
            <Grid
              item
              xs={3}
              className="sales-section-amount-details"
              
            >
            </Grid>
            <Grid item xs={3} className="sales-section-amount-details">
              
            </Grid>
            <Grid
              item
              xs={3}
              className="sales-section-amount-details"
            
            >
              
            </Grid>
                   
           
            </Grid>
          </Box>
             
        <Box className="daysettle-balance-section" style={{marginBottom:'20px'}}>
          <Grid container style={{ padding: "15px 15px 0px 15px" }}>
            <Grid item xs={1}>
              <div className="roomsection1">
              <Skeleton
                  animation="wave"
                  className="placeholder-animation"
                  variant="circular"
                  width={30}
                  height={30}
                />
              </div>
            </Grid>
            <Grid
              item
              xs={7}
              className="fsec-body-header"
              style={{ paddingLeft: "10px" }}
            >
               <Skeleton
                    animation="wave"
                    height={30}
                    className="placeholder-animation"
                    width="80%"
                  />
            </Grid>
            <Grid item xs={4} className="fsec-body-header1"></Grid>
          </Grid>
          <Grid container style={{ paddingBottom: "15px" }}>
            <Grid item xs={1}></Grid>
            <Grid
              item
              xs={7}
              className="fsec-body-header"
              style={{ paddingLeft: "23px" }}
            >
              <Skeleton
                    animation="wave"
                    height={35}
                    className="placeholder-animation"
                    width="90%"
                  />
            </Grid>
            <Grid item xs={4} className="fsec-body-header1"></Grid>
          </Grid>
          <Grid item xs={6}></Grid>
        </Box>
      </Box>
    );
}