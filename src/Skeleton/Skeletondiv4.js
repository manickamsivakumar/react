import React from "react";
import Grid from "@mui/material/Grid";
import "../main.css";
import Skeleton from "@mui/material/Skeleton";
import Stack from "@mui/material/Stack";
var looparray = new Array(20).fill(1);
console.log(looparray);
export default function Skeletondiv4() {
  return (
    <>
      {looparray.map((val, key) => {
        return (
          <Grid
            container
            key={key}
            id="MuiAccordion-rounded"
            style={{ heigth: "100px !important" }}
          >
            <Grid item xs={12}>
              <Grid container item xs={12} style={{ minHeight: "50%" }}>
                <Grid item xs={6} className="flex-left">
                  <Stack direction="column" style={{ width: "100%" }}>
                    <Skeleton
                      animation="wave"
                      height={20}
                      className="placeholder-animation"
                      width="50%"
                    />
                    <Skeleton
                      animation="wave"
                      height={20}
                      className="placeholder-animation"
                      width="80%"
                    />
                  </Stack>
                </Grid>

                <Grid item xs={6} className="flex-right">
                  <Stack
                    direction="column"
                    style={{ width: "100%", alignItems: "end" }}
                  >
                    <Skeleton
                      animation="wave"
                      height={20}
                      className="placeholder-animation"
                      width="50%"
                      style={{ float: "right" }}
                    />
                    <Skeleton
                      animation="wave"
                      height={20}
                      className="placeholder-animation"
                      width="80%"
                    />
                  </Stack>
                </Grid>
              </Grid>
            </Grid>
          </Grid>
        );
      })}
    </>
  );
}
