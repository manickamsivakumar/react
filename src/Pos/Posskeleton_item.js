

import React from "react";
import Grid from "@mui/material/Grid";
import "./Main.css";
import Skeleton from "@mui/material/Skeleton";
import Box from "@mui/material/Box";


export default function Posskeleton_item() {
    return (
        <>
            {
                [1].map((num) => {
                    return (


                        <Box className="pos-revenue-section-pos" style={{ margin: '10px 10px 0px', height: '355px' }} key={num}>
                            <Grid container style={{ padding: "15px 15px 0px 15px" }}>
                                <Grid
                                    item
                                    xs={8}
                                    className="fsec-body-header"

                                >
                                    <Skeleton
                                        animation="wave"
                                        height={30}
                                        className="placeholder-animation"
                                        width="60%"
                                        style={{ paddingLeft: "5px" }}
                                    />
                                </Grid>

                                <Grid item xs={4} className="fsec-body-header1" style={{ position: 'relative', top: '7px' }}>
                                    <Skeleton
                                        animation="wave"
                                        className="placeholder-animation"
                                        variant="rectangular"
                                        width={30}
                                        height={30}
                                        style={{ borderRadius: '10px' }}
                                    />               </Grid>
                            </Grid>
                            <Grid container>

                                <Grid
                                    item
                                    xs={7}
                                    className="fsec-body-header"
                                    style={{ paddingLeft: "15px" }}
                                >
                                    <Skeleton
                                        animation="wave"
                                        height={35}
                                        className="placeholder-animation"
                                        width="90%"
                                    />
                                </Grid>
                                <Grid item xs={4} className="fsec-body-header1">

                                </Grid>
                            </Grid>
                            <Grid item xs={6}></Grid>






                            <Grid container item xs={12}>
                                <div className="compare-grap-wrapper compare-grap-wrapper-skeleton" style={{ height: '250px', position: 'relative', top: '-7px' }}>
                                    <Skeleton
                                        animation="wave"
                                        className="placeholder-animation"
                                        variant="rectangular"
                                        style={{ borderRadius: '5px', width: '90%' }}

                                        width={240}
                                        height={220}
                                    />
                                </div>
                            </Grid>

                            <Grid container item xs={12}>
                                <Grid item xs={8}></Grid>
                                <Grid item xs={4}>  <Skeleton
                                    animation="wave"
                                    height={30}
                                    className="placeholder-animation"
                                    width="80%"
                                    style={{ paddingLeft: "5px", position: 'relative', left: '5px', top: '-16px' }}
                                /></Grid>
                            </Grid>





                        </Box>

                    );
                })}
        </>
    );



}