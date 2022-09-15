import React from "react";
import Grid from "@mui/material/Grid";
import Box from "@mui/material/Box";
import "../main.css";
import Skeleton from "@mui/material/Skeleton";
import Stack from "@mui/material/Stack";

export default function Skeletondiv3() {
  return (
    <Box style={{ padding: "12px", marginBottom: "68px" }}>
      <Grid
        container
        item
        xs={12}
        className="daterange-header"
        style={{ width: "250px", marginBottom: "15px" }}
      ></Grid>
      <Box className="nottoday-graph-section">
        <Grid container item xs={12} style={{ padding: "10px 10px" }}>
          <Skeleton
            animation="wave"
            className="placeholder-animation"
            variant="circular"
            width={30}
            height={30}
            style={{ marginRight: "20px" }}
          />
          <Skeleton
            animation="wave"
            height={30}
            className="placeholder-animation"
            width="40%"
            style={{ marginBottom: 16 }}
          />
        </Grid>
        <Grid container item xs={12}>
          <Grid
            item
            xs={6}
            style={{
              display: "flex",
              justifyContent: "center",
              alignItems: "center",
            }}
          >
            <Skeleton
              animation="wave"
              className="placeholder-animation"
              variant="circular"
              width={100}
              height={100}
            />
          </Grid>
          <Grid
            item
            xs={6}
            style={{
              display: "flex",
              justifyContent: "center",
              alignItems: "center",
            }}
          >
            <Stack direction="column" style={{ width: "100%" }}>
              <Skeleton
                animation="wave"
                height={30}
                className="placeholder-animation"
                width="80%"
                style={{ marginBottom: 16 }}
              />

              <Skeleton
                animation="wave"
                className="placeholder-animation"
                height={30}
                width="80%"
                style={{ marginBottom: 16 }}
              />
            </Stack>
          </Grid>
        </Grid>
      </Box>
      <Box className="sales-section">
        <Grid container style={{ padding: "1px", height: "34px" }}>
          <Skeleton
            animation="wave"
            className="placeholder-animation"
            variant="circular"
            width={30}
            height={30}
            style={{ margin: "10px 10px 0 10px" }}
          />
          <Skeleton
            animation="wave"
            height={30}
            className="placeholder-animation"
            width="30%"
          />
        </Grid>
        <Grid container style={{ padding: "1px" }}>
          <Skeleton
            animation="wave"
            height={30}
            className="placeholder-animation"
            width="40%"
            style={{ margin: "0px 10px 14px 52px" }}
          />
        </Grid>

        <Grid container item xs={12} className="sales-section-details">
          <Grid
            item
            xs={6}
            className="sales-section-amount-details"
            style={{ borderRight: "3px solid white" }}
          ></Grid>
          <Grid item xs={6} className="sales-section-amount-details"></Grid>
        </Grid>
      </Box>
      <Box className="sales-section">
        <Grid container style={{ padding: "1px", height: "34px" }}>
          <Skeleton
            animation="wave"
            className="placeholder-animation"
            variant="circular"
            width={30}
            height={30}
            style={{ margin: "10px 10px 0 10px" }}
          />
          <Skeleton
            animation="wave"
            height={30}
            className="placeholder-animation"
            width="30%"
          />
        </Grid>
        <Grid container style={{ padding: "1px" }}>
          <Skeleton
            animation="wave"
            height={30}
            className="placeholder-animation"
            width="40%"
            style={{ margin: "0px 10px 14px 52px" }}
          />
        </Grid>

        <Grid container item xs={12} className="sales-section-details">
          <Grid
            item
            xs={6}
            className="sales-section-amount-details"
            style={{ borderRight: "3px solid white" }}
          ></Grid>
          <Grid item xs={6} className="sales-section-amount-details"></Grid>
        </Grid>
      </Box>
      <Box>
        <Grid container item xs={12} spacing={1} style={{ marginTop: "10px" }}>
          <Grid item xs={6}>
            <div className="checkin-box">
              <Grid
                container
                style={{ padding: "15px 15px 15px 15px", height: "100%" }}
              >
                <Grid
                  item
                  xs={3}
                  style={{
                    display: "flex",
                    justifyContent: "center",
                    alignItems: "center",
                  }}
                >
                  <Skeleton
                    animation="wave"
                    className="placeholder-animation"
                    variant="circular"
                    width={30}
                    height={30}
                  />
                </Grid>
                <Grid item xs={7} className="checkin-box-text1">
                  <Stack direction="column" style={{ width: "100%" }}>
                    <Skeleton
                      animation="wave"
                      height={20}
                      className="placeholder-animation"
                      width="80%"
                    />

                    <Skeleton
                      animation="wave"
                      height={20}
                      className="placeholder-animation"
                      width="100%"
                    />
                  </Stack>
                </Grid>
              </Grid>
            </div>
          </Grid>
          <Grid item xs={6}>
            <div className="checkin-box">
              <Grid
                container
                style={{ padding: "15px 15px 15px 15px", height: "100%" }}
              >
                <Grid
                  item
                  xs={3}
                  style={{
                    display: "flex",
                    justifyContent: "center",
                    alignItems: "center",
                  }}
                >
                  <Skeleton
                    animation="wave"
                    className="placeholder-animation"
                    variant="circular"
                    width={30}
                    height={30}
                  />
                </Grid>
                <Grid item xs={7} className="checkin-box-text1">
                  <Stack direction="column" style={{ width: "100%" }}>
                    <Skeleton
                      animation="wave"
                      height={20}
                      className="placeholder-animation"
                      width="80%"
                    />

                    <Skeleton
                      animation="wave"
                      height={20}
                      className="placeholder-animation"
                      width="100%"
                    />
                  </Stack>
                </Grid>
              </Grid>
            </div>
          </Grid>
        </Grid>
      </Box>
    </Box>
  );
}
