import React, { useEffect, useState } from 'react';
import { DataGrid, GridCellParams } from '@mui/x-data-grid';
import Box from '@mui/material/Box';
import Modal from '@mui/material/Modal';
import Urlobjmaker from './Urlobjmaker';
import Apicallprocess from './Apicallprocess';
import ChartValues from './GetChartValues';
import Chart from "react-apexcharts";
import _ from 'underscore';
import "./Main.css";
import Areaimage from "./ic_acrestaurant.svg";
import Grid from "@mui/material/Grid";
import Mclose from "./ic_close.svg";
import { DateTime } from 'luxon';
import Nformat from './Nformat';

const modalboxstyle = {
    position: 'absolute',
    top: '50%',
    left: '50%',
    transform: 'translate(-50%, -50%)',
    bgcolor: 'background.paper',
    border: '1px solid #e4dfdf',
    boxShadow: 24,
    p: 4,
    height: '43%',
    width: '78%',
    borderRadius: '10px',
    padding: '15px'

};

export default function DataTable(props) {
    var rows = props.rows;
    var columns = props.columns;
    var areaid = props.areaid;
    var groupmode = props.groupmode;

    //console.log(props)

    const [open, setOpen] = React.useState(false);
    const handleOpen = () => setOpen(true);
    const handleClose = () => {
        setOpen(false)
    }

    const makefirstcap = function (str) {
        return str.charAt(0).toUpperCase() + str.slice(1).toLowerCase();
    };

    const [switchvalues, setSwitchValues] = useState(
        {
            itemid: 0,
            type: "bar",
            dtrows: [],
            dtcolumns: [],
            firstkot: '',
            lastkot: '',
            contribution: 0,
            amount: 0,
            areavalue: 0,
            qty: 0,
            itemname: '',
            jsx_kotvalues: [],
            linedata: {
                options: {},
                series: []
            }

        }
    );

    const resetmodalbox = async (cellvalues, event) => {
        if (cellvalues.field == "itemname") {

            //console.log(cellvalues);

            var rowvalues = cellvalues.row;
            switchvalues.contribution = rowvalues.contribution;
            switchvalues.amount = rowvalues.amount;
            switchvalues.areavalue = rowvalues.areavalue;
            switchvalues.qty = rowvalues.qty;
            switchvalues.itemid = rowvalues.id;
            switchvalues.itemname = rowvalues.itemname;
            var postdetails = props.postdetails;
            postdetails.itemid = cellvalues.id;
            postdetails.m_areaid = props.areaid;
            postdetails.groupmode = props.groupmode;
            var datefilterid = postdetails.datefilter;
            var itemsfilter = postdetails.itemsfilter;
            //console.log(itemsfilter);
            if (itemsfilter != 1) {     //not for cancelled
                //console.log('wewe');
                var urlobj = new Urlobjmaker(postdetails, "posareaitemkotdetails");
                var response = await Apicallprocess(urlobj.madeurl, urlobj.postdata);
                if (response) {
                    var kotdetails = response.kotdetails;
                    var itemvalues = response.values;
                    var itmvalue = 0;
                    _.each(itemvalues[postdetails.m_areaid], function (itemvalue, datekey) {
                        _.each(itemvalue, function (value, timekey) {
                            itmvalue += value;
                        });
                    });
                    itmvalue = Number(itmvalue / 1).toFixed(2);
                    switchvalues.jsx_kotvalues = [];
                    var fdatetime = kotdetails.firstkot.added_date;
                    var ldatetime = kotdetails.lastkot.added_date;
                    if (fdatetime && ldatetime) {
                        fdatetime = fdatetime.split(' ');
                        ldatetime = ldatetime.split(' ');
                        // alert(fdatetime[0]);
                        var fdate = DateTime.fromISO(fdatetime[0]).toFormat('ff').split(',');
                        var ldate = DateTime.fromISO(ldatetime[0]).toFormat('ff').split(',');
                        fdate = fdate[0] + ' ' + fdate[1] + ' ' + fdatetime[1];
                        ldate = ldate[0] + ' ' + ldate[1] + ' ' + ldatetime[1];
                        if (datefilterid == 0) {
                            switchvalues.jsx_kotvalues.push({ key: 1, amount: fdatetime[1], salemode: 'First KOT' });
                            switchvalues.jsx_kotvalues.push({ key: 2, amount: ldatetime[1], salemode: 'Last KOT' });
                        }
                        else {
                            var salemode = groupmode == 0 ? 'Item Total' : 'Group Total';
                            switchvalues.jsx_kotvalues.push({ key: 1, amount: 'Rs ' + (itmvalue * 1), salemode: salemode });
                            switchvalues.jsx_kotvalues.push({ key: 2, amount: 'Rs ' + switchvalues.areavalue, salemode: 'Area Total' });
                        }
                        switchvalues.jsx_kotvalues.push({ key: 3, amount: switchvalues.contribution, salemode: 'Contrib %' });
                    }
                    var datetimevalue = itemvalues[postdetails.m_areaid];
                    var nodatacheck = 0;
                    var datetimefilterid = postdetails.datefilter;
                    _.each(datetimevalue, function (itemvalue, datekey) {
                        _.each(itemvalue, function (value, timekey) {
                            nodatacheck += value;
                        });
                    });
                    //console.log(itemvalues);
                    var chartvalues = ChartValues(datetimefilterid, nodatacheck, datetimevalue, postdetails);
                    //console.log(chartvalues);
                    var ldata = {
                        series: [
                            {
                                name: switchvalues.itemname,
                                data: chartvalues.mdata,
                            },
                        ],
                        options: {
                            chart: {
                                type: "area",
                                height: 400,
                                width: 400,
                                zoom: {
                                    enabled: false,
                                },
                                toolbar: {
                                    show: false,
                                },
                                dropShadow: {
                                    enabled: true,
                                    enabledOnSeries: undefined,
                                    top: 0,
                                    left: 0,
                                    blur: 3,
                                    color: '#000',
                                    opacity: 0.15
                                },
                                background: 'white 0% 0% no-repeat padding-box'
                            },
                            grid: {
                                show: false,
                            },
                            dataLabels: {
                                enabled: false,
                            },
                            stroke: {
                                show: true,
                                curve: 'smooth',
                                lineCap: 'butt',
                                width: 2,
                                dashArray: 0
                            },
                            colors: ["#6BE6F3"],
                            labels: chartvalues.labels,
                            xaxis: {
                                type: "",
                                axisBorder: {
                                    show: true,
                                },
                                axisTicks: {
                                    show: true,
                                },
                            },
                            markers: {
                                size: 2,
                                colors: ["#000524"],
                                strokeColor: "#00BAEC",
                                strokeWidth: 3
                            },
                            yaxis: {
                                tickAmount: 5,
                                opposite: false,
                                axisBorder: {
                                    show: false,
                                },
                                axisTicks: {
                                    show: true,
                                },
                                labels: {
                                    show: true,
                                    align: "right",

                                    style: {
                                        colors: ["rgba(0, 0, 0, .5)"],
                                        fontSize: "12px",
                                        fontFamily: "Sofia Pro",
                                        fontWeight: 400,
                                        cssClass: "apexcharts-yaxis-label",
                                    },
                                    offsetX: 0,
                                    offsetY: 0,
                                    rotate: 0,
                                    formatter: (value) => {
                                        var cnt = value.toString().length;
                                        var str = value;
                                        if (cnt == 4 || cnt == 5) {
                                            str = Number(value / 1000).toFixed(0) + "K";
                                        } else if (cnt == 7 || cnt == 6) {
                                            str = Number(value / 100000).toFixed(0) + "L";
                                        } else if (cnt > 7) {
                                            str = Number(value / 10000000).toFixed(0) + "Cr";
                                        }
                                        return str;
                                    },
                                },
                            },
                            legend: {
                                horizontalAlign: "left",
                            },
                        },
                    };
                    switchvalues.linedata = {
                        series: [
                            {
                                name: switchvalues.itemname,
                                data: chartvalues.mdata,
                            },
                        ],
                        options: {
                            chart: {
                                type: "bar",
                                height: 350,
                                width: "400px",
                                toolbar: {
                                    show: false,
                                },
                            },
                            plotOptions: {
                                bar: {
                                    horizontal: false,
                                    columnWidth: "80%",
                                    endingShape: "rounded",
                                },
                            },
                            dataLabels: {
                                enabled: false,
                            },
                            stroke: {
                                show: true,
                                width: 2,
                                colors: ["transparent"],
                            },
                            yaxis: {
                                tickAmount: 3,

                                labels: {
                                    show: true,
                                    align: "right",

                                    style: {
                                        colors: ["#ccc"],
                                        fontSize: "12px",
                                        fontFamily: "Sofia Pro",
                                        fontWeight: 400,
                                        cssClass: "apexcharts-yaxis-label",
                                    },
                                    offsetX: 0,
                                    offsetY: 0,
                                    rotate: 0,
                                    formatter: (value) => {
                                        var cnt = value.toString().length;
                                        var str = value;
                                        if (cnt === 4 || cnt === 5) {
                                            str = Number(value / 1000).toFixed(0) + "K";
                                        } else if (cnt === 7 || cnt === 6) {
                                            str = Number(value / 100000).toFixed(0) + "L";
                                        } else if (cnt > 7) {
                                            str = Number(value / 10000000).toFixed(0) + "Cr";
                                        }
                                        return str;
                                    },
                                },
                            },
                            xaxis: {
                                categories: chartvalues.labels,

                                show: false,

                                labels: {
                                    show: true,
                                    style: {
                                        fontFamily: "Sofia Pro",

                                        cssClass: "apexcharts-xaxis-label",
                                    },
                                    formatter: function (val) {
                                        return (val + '').split("_|_")[0];
                                    },
                                },
                                axisBorder: {
                                    show: false,
                                },
                                axisTicks: {
                                    show: false,
                                },
                            },

                            legend: {
                                position: "top",
                                horizontalAlign: "right",
                                markers: {
                                    width: 8,
                                    height: 8,
                                },
                            },
                            fill: {
                                opacity: 0.7,
                            },

                            grid: {
                                show: false,
                            },
                            bar: {
                                borderRadius: "10%",
                            },
                            tooltip: {
                                y: {
                                    formatter: function (val) {
                                        return val;
                                    },
                                },
                                x: {
                                    show: true,

                                    formatter: function (val) {
                                        var ival = (val + '').split("_|_");
                                        if (ival.length > 1) {
                                            return (val + '').split("_|_")[1];
                                        } else {
                                            return (val + '').split("_|_")[0];
                                        }
                                    },
                                },
                            },
                        },
                    };
                    setOpen(true);
                }
            }
            //var chartvalues = ChartValues(datetimefilterid, nodatacheck, datetimevalue, postdetails);
            //console.log(ChartValues(response[1]));
        }

    }

    // useEffect(() => {
    //     console.log(props);

    //     return () => {

    //     }
    // }, [open])

    const modalclosefunc = () => {

    }

    return (
        <div style={{ height: 400, width: '100%' }}>

            <DataGrid
                disableColumnFilter
                rows={rows}
                columns={columns}
                pageSize={5}
                rowsPerPageOptions={[5]}
                getRowId={(row) => row.id}
                onCellClick={(params, event) => {
                    resetmodalbox(params, event)
                }}
            />
            <Modal
                open={open}
                onClose={handleClose}
                aria-labelledby="modal-modal-title"
                aria-describedby="modal-modal-description"
            >

                <Box sx={modalboxstyle}>
                    <img src={Mclose} onClick={handleClose} className="modalclosebtn" />
                    <Grid container style={{ padding: "0px 0px 0px 15px" }}>
                        <Grid item xs={1}>
                            <div className="roomsection1">
                                <img src={Areaimage} />
                            </div>
                        </Grid>
                        <Grid
                            item
                            xs={7}
                            className="fsec-body-header"
                            style={{ paddingLeft: "10px" }}
                        >
                            <span className="sales-section-text">{makefirstcap(switchvalues.itemname)}</span>
                        </Grid>
                        <Grid item xs={4} className="fsec-body-header1"></Grid>
                    </Grid>

                    <Chart options={switchvalues.linedata.options} series={switchvalues.linedata.series} type="bar" />

                    <Grid container item xs={12} className="sales-section-details1 kotvalues-swvalues">
                        {
                            switchvalues.jsx_kotvalues.map((jsx_kotvalue) => {
                                // let key = jsx_servicevalue.key;
                                // let amount = jsx_servicevalue.amount;
                                // let salemode = jsx_servicevalue.salemode;
                                //alert(jsx_kotvalue.amount);
                                //console.log(jsx_kotvalue.amount);
                                jsx_kotvalue.amount = ((jsx_kotvalue.amount) + '').replace('Rs ', '');
                                // if (jsx_kotvalue.amount.indexOf(':') > -1) {
                                //     jsx_kotvalue.amount = jsx_kotvalue.amount
                                // } else {
                                //     jsx_kotvalue.amount = 'Rs ' + Nformat(jsx_kotvalue.amount);
                                // }
                                return (
                                    <Grid
                                        key={jsx_kotvalue.key}
                                        item
                                        xs={4}
                                        className="pos-sales-section-amount-details"
                                        style={{ borderRight: "3px solid white" }}
                                    >
                                        <div>
                                            <div className="sales-section-amount-details-name kotitem-header">{makefirstcap(jsx_kotvalue.salemode)}</div>
                                            <div className="sales-section-amount-details-value kotitem-value">
                                                {
                                                    (jsx_kotvalue.amount.indexOf(':') > -1) ? jsx_kotvalue.amount : 'Rs ' + Nformat(jsx_kotvalue.amount)
                                                }
                                            </div>
                                        </div>
                                    </Grid>
                                )
                            })
                        }
                    </Grid>
                </Box>
            </Modal>
        </div>
    );
}
