

import React from "react";
import Grid from "@mui/material/Grid";
import "./Main.css";
import Skeleton from "@mui/material/Skeleton";
import Box from "@mui/material/Box";


export default function Posskeleton_sales() {
    return (
        <>
            {
                [1, 2].map((num) => {
                    return (
                        <Box style={{ padding: "12px", height: '390px', marginBottom: '20px' }} key={num}>

                            <Box className="pos-revenue-section-pos">
                                <Grid container style={{ padding: "15px 15px 0px 15px" }}>
                                    <Grid
                                        item
                                        xs={7}
                                        className="fsec-body-header"

                                    >
                                        <Skeleton
                                            animation="wave"
                                            height={30}
                                            className="placeholder-animation"
                                            width="80%"
                                            style={{ paddingLeft: "5px" }}
                                        />
                                    </Grid>
                                    <Grid item xs={1}></Grid>
                                    <Grid item xs={4} className="fsec-body-header1" style={{ position: 'relative', top: '7px' }}>
                                        <Skeleton
                                            animation="wave"
                                            className="placeholder-animation"
                                            variant="rectangular"
                                            width={35}
                                            height={35}
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



                                <div className="collapsetag">

                                    <Box>
                                        <Grid container item xs={12}>
                                            <div className="compare-grap-wrapper" style={{ top: '0px !important' }}>
                                                <Skeleton
                                                    animation="wave"
                                                    className="placeholder-animation"
                                                    variant="rectangular"
                                                    style={{ borderRadius: '5px' }}

                                                    width={240}
                                                    height={140}
                                                />
                                            </div>
                                        </Grid>
                                    </Box>



                                    <Grid container item xs={12} className="sales-section-details1">
                                        {
                                            [1, 2, 3, 4].map((jsx_servicevalue) => {
                                                // let key = jsx_servicevalue.key;
                                                // let amount = jsx_servicevalue.amount;
                                                // let salemode = jsx_servicevalue.salemode;
                                                // alert(salemode);
                                                return (
                                                    <Grid
                                                        key={jsx_servicevalue.key}
                                                        item
                                                        xs={3}
                                                        className="pos-sales-section-amount-details"
                                                        style={{ borderRight: "3px solid white" }}
                                                    >

                                                    </Grid>
                                                )
                                            })
                                        }
                                    </Grid>



                                    <Grid container item xs={12} className="sales-section-details">
                                        {
                                            [1, 2, 3, 4].map((jsx_settlevalue) => {
                                                // let key = jsx_servicevalue.key;
                                                // let amount = jsx_servicevalue.amount;
                                                // let salemode = jsx_servicevalue.salemode;
                                                // alert(salemode);
                                                return (
                                                    <Grid
                                                        key={jsx_settlevalue.key}
                                                        item
                                                        xs={3}
                                                        className="pos-sales-section-amount-details"
                                                        style={{ borderRight: "3px solid white" }}
                                                    >

                                                    </Grid>
                                                )
                                            })
                                        }
                                    </Grid>
                                </div>

                            </Box>
                        </Box >
                    );
                })}
        </>
    );



}