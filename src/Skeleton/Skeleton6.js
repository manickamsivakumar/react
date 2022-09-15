

import React from "react";
import Grid from "@mui/material/Grid";
import "../main.css";
import Skeleton from "@mui/material/Skeleton";
import Box from "@mui/material/Box";

export default function Skeleton5() {
    return (
        <Box style={{ margin: "10px 10px 75px 10px" } }>
                  
       <Box className="fsummay-section">
         
                <Box style={{
                    marginTop: '10px', padding:'15px'
                }}>
           <Grid container item xs={12}>
             <table style={{ width: "100%" }}>
               <thead className="table-thead">
                 <tr>
                   <th className="text-left"></th>
                   <th className="text-right"></th>
                   <th className="text-right"></th>
                   
                 </tr>
               </thead>
                            <tbody className="table-tbody">
                                {[1, 2, 3, 4,5,6,7,8,9,10].map((val) => {
                                    return (
                                        <tr key={val}>
                                        <td style={{ textAlign: "left" }}> <Skeleton
                                                    animation="wave"
                                                    height={20}
                                                    className="placeholder-animation"
                                                    width="30%"
                                                  /></td>
                                        <td style={{ textAlign: "right" }}> <Skeleton
                                                    animation="wave"
                                                    height={25}
                                                    className="placeholder-animation"
                                                    width="80%"
                                                  /></td>
                                        <td style={{ textAlign: "right" }}> <Skeleton
                                                    animation="wave"
                                                    height={25}
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
              
     </Box>
    )
}