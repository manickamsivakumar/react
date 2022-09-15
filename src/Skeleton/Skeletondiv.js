import React from "react";
import Grid from "@mui/material/Grid";
import "../main.css";
import Skeleton from "@mui/material/Skeleton";
export default function Skeletondiv() {
  return (
    <div style={{ marginTop: "20px", height: "230px" }}>
      <Grid
        className="hotel-header"
        container
        style={{ padding: "10px", background: "none !important" }}
      >
        <Grid item xs={12}></Grid>
      </Grid>
      <Grid className="hotel-body" container style={{ padding: "20px" }}>
        <Grid item xs={6}>
          <Skeleton
            animation="wave"
            className="placeholder-animation"
            variant="circular"
            width={120}
            height={120}
          />
        </Grid>
        <Grid item xs={6}>
          <Grid container item xs={12}>
            <Skeleton
              animation="wave"
              height={40}
              className="placeholder-animation"
              width="100%"
              style={{ marginBottom: 16 }}
            />
          </Grid>
          <Grid container item xs={12}>
            <Skeleton
              animation="wave"
              className="placeholder-animation"
              height={40}
              width="100%"
              style={{ marginBottom: 16 }}
            />
          </Grid>
          
        </Grid>
      </Grid>
    </div>
  );
}
