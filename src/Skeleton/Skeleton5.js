

import React from "react";
import Grid from "@mui/material/Grid";
import "../main.css";
import Skeleton from "@mui/material/Skeleton";
import Box from "@mui/material/Box";

export default function Skeleton5() {
    return (
        <Box style={{ margin: "10px 10px 75px 10px" }}>
        <Grid
             container
             item
             xs={12}
             className="daterange-header"
             style={{ width: "fit-content", marginBottom: "15px" ,width:'180px' }}
           >
           </Grid>
          
       <Box className="fsummay-section">
         <Box style={{ padding: "10px" }}>
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
               style={{ paddingLeft: "30px" }}
             >
                  <Skeleton
                    animation="wave"
                    height={30}
                    className="placeholder-animation"
                    width="80%"
                  />             </Grid>
             <Grid item xs={4} className="fsec-body-header1"></Grid>
           </Grid>
         </Box>
         <Box>
           <Grid
             container
             direction="column"
             alignItems="center"
             justifyContent="center"
           >
             <Grid item xs={6}>
             <Skeleton
                  animation="wave"
                  className="placeholder-animation"
                  variant="circular"
                  width={140}
                  height={140}
                />
             </Grid>
           </Grid>
         </Box>
         <Box style={{marginTop:'10px'}}>
           <Grid container item xs={12}>
             <table style={{ width: "100%" }}>
               <thead className="table-thead">
                 <tr>
                   <th className="text-left"></th>
                   <th className="text-right"></th>
                   <th className="text-right"></th>
                   <th className="text-right"></th>
                 </tr>
               </thead>
                            <tbody className="table-tbody">
                                {[1, 2, 3, 4].map((val) => {
                                    return (
                                        <tr key={val}>
                                        <td style={{ textAlign: "left" }}> <Skeleton
                                                    animation="wave"
                                                    height={20}
                                                    className="placeholder-animation"
                                                    width="80%"
                                                  /></td>
                                        <td style={{ textAlign: "right" }}> <Skeleton
                                                    animation="wave"
                                                    height={20}
                                                    className="placeholder-animation"
                                                    width="80%"
                                                  /></td>
                                        <td style={{ textAlign: "right" }}> <Skeleton
                                                    animation="wave"
                                                    height={20}
                                                    className="placeholder-animation"
                                                    width="80%"
                                                  /></td>
                                        <td style={{ textAlign: "right" }}> <Skeleton
                                                    animation="wave"
                                                    height={20}
                                                    className="placeholder-animation"
                                                    width="80%"
                                                  /></td>
                                      </tr>
                                 )   

                                })}
                        
               </tbody>
             </table>
           </Grid>
         </Box>
       </Box>
       <Box className="fsec-body">
        <Grid container item xs={12}>
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
              width={120}
              height={120}
            />
          </Grid>
          <Grid item xs={6}>
            <Grid container item xs={12}>
              <Skeleton
                animation="wave"
                className="placeholder-animation"
                height={30}
                width="100%"
                style={{ marginBottom: 16 }}
              />
            </Grid>
            <Grid container item xs={12}>
              <Skeleton
                animation="wave"
                height={30}
                width="100%"
                className="placeholder-animation"
                style={{ marginBottom: 16 }}
              />
            </Grid>
            <Grid container item xs={12}>
              <Skeleton
                animation="wave"
                height={30}
                width="100%"
                className="placeholder-animation"
                style={{ marginBottom: 16 }}
              />
            </Grid>
            <Grid container item xs={12}>
              <Skeleton
                animation="wave"
                height={30}
                width="100%"
                className="placeholder-animation"
                style={{ marginBottom: 16 }}
              />
            </Grid>
          </Grid>
        </Grid>
      </Box>
       
     </Box>
    )
}