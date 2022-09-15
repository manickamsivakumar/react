import React, { } from "react";
import "./Main.css";
import Grid from "@mui/material/Grid";
import Box from "@mui/material/Box";
import Areaimage from "./ic_acrestaurant.svg";
import Chart from "react-apexcharts";
import _ from 'underscore';
import $ from 'jquery';
import ChartValues from './GetChartValues';
import Nformat from './Nformat';
import ButtonToolbar from 'rsuite/ButtonToolbar';
import Animation from 'rsuite/Animation';
import IconButton from 'rsuite/IconButton';
import PlusIcon from '@rsuite/icons/Plus';
import MinusIcon from '@rsuite/icons/Minus';
import Posskeleton_sales from './Posskeleton_sales.js';

//<Button onClick={handleCollapseToggle}>Vertical toggle</Button>
export default function Possalecard(props) {

    //console.log(props);

    //let datefilterobj = { 0: 'Today', 1: 'Last 7 days', 2: 'Last 30 days', 3: 'Current Month', 4: 'Last Month', 5: 'Current Year' }
    var datetimefilterid = 0;
    if ($('#datetimefilter').length) {
        datetimefilterid = $('#datetimefilter')[0].nextElementSibling.value;
    }

    // var rangemaker = {
    //     0: 10,
    //     1: 7,
    //     2: 15,
    //     3: 15,
    //     4: 15,
    //     5: 15
    // }

    var areaname = props.areadetail.areaname;
    var areaid = props.areadetail.areaid
    var areavalue = props.cardvalue.areavalues;
    var datetimevalue = props.datetimevalue;
    var marginbottomval = props.marginbottomval;

    //console.log(props);

    const getservicedetails = (srvdetails, servicevalues, settledetails, settlevalues) => {
        var serviceidobj = {
            table: [],
            room: [],
            take: [],
            others: []
        };
        var servicedetails = {
            table: {},
            room: {},
            take: {},
            others: {},
            cash: {},
            card: {},
            sroom: {},
            sothers: {}
        };
        var result = {
            service: {
                table: 0,
                room: 0,
                take: 0,
                others: 0
            },
            settle: {
                cash: 0,
                card: 0,
                room: 0,
                others: 0
            }
        }
        _.each(srvdetails, function (srvdetail, srvid) {
            var servicetype = srvdetail.servicetype.toLowerCase();
            //console.log(servicetype);
            //console.log(srvid)
            //var servicetypename = srvdetail.servicetypename.toLowerCase().replace(/\s/g, '');
            if (servicetype == "table") {
                serviceidobj.table.push(srvid);
            } else if (servicetype == "room") {
                serviceidobj.room.push(srvid);
            } else if (servicetype == "take") {
                serviceidobj.take.push(srvid);
            } else {
                serviceidobj.others.push(srvid);
            }
        });

        let in_servicekeys = _.keys(servicevalues);
        //console.log(serviceidobj);
        //console.log(in_servicekeys);
        servicedetails.table.values = 0;
        servicedetails.room.values = 0;
        servicedetails.take.values = 0;
        servicedetails.others.values = 0;

        _.each(in_servicekeys, function (in_servicekey, srvid) {
            if (serviceidobj.table.includes(in_servicekey)) {
                servicedetails.table.values += servicevalues[in_servicekey];
            } else if (serviceidobj.room.includes(in_servicekey)) {
                servicedetails.room.values += servicevalues[in_servicekey];
            } else if (serviceidobj.take.includes(in_servicekey)) {
                servicedetails.take.values += servicevalues[in_servicekey];
            } else {
                servicedetails.others.values += servicevalues[in_servicekey];
            }
        });
        servicedetails.table.ids = serviceidobj.table;
        servicedetails.room.ids = serviceidobj.room;
        servicedetails.take.ids = serviceidobj.take;
        servicedetails.others.ids = serviceidobj.others;

        let in_settleids = _.keys(settlevalues);
        // console.log(in_settleids);
        // console.log(settledetails);
        let settle_obj = {
            cash: 0,
            card: 0,
            sroom: 0,
            others: 0
        }

        servicedetails.cash.values = 0;
        servicedetails.card.values = 0;
        servicedetails.sroom.values = 0;
        servicedetails.sothers.values = 0;

        //console.log(settle_obj);

        _.each(in_settleids, function (settleid) {
            var settletype = settledetails[settleid].toLowerCase().replace(/\s/g, '');
            //console.log(settletype);
            if (settletype == "creditcard") {
                settletype = "card";
            }
            else if (settletype == "room") {
                settletype = "sroom";
            }
            if (_.keys(settle_obj).includes(settletype)) {
                servicedetails[settletype].values = settlevalues[settleid];
            } else {
                servicedetails.sothers.values += settlevalues[settleid];
            }

        });

        result.service.table = servicedetails.table.values;
        result.service.room = servicedetails.room.values;
        result.service.take = servicedetails.take.values;
        result.service.others = servicedetails.others.values;
        result.settle.cash = servicedetails.cash.values;
        result.settle.card = servicedetails.card.values;
        result.settle.room = servicedetails.sroom.values;
        result.settle.others = servicedetails.sothers.values;

        return result;
    }

    let srvdetails = props.contextval.details.srvdetails;
    let cardvalue = props.cardvalue;
    let servicevalues = cardvalue.servicevalues;
    let settledetails = props.contextval.details.settledetails;
    let settlevalues = cardvalue.settlevalues;
    let postdetails = props.contextval.details.postdetails;

    let psaledetails = getservicedetails(srvdetails, servicevalues, settledetails, settlevalues);
    let { service, settle } = psaledetails;

    var jsx_servicevalues = [];
    var jsx_settlevalues = [];

    //<h2 className="salesheader">Revenue Wise</h2>

    let key = 1; var nodatacheck = 0;
    _.each(service, function (amount, salemode) {
        jsx_servicevalues.push({ key: key, amount: amount, salemode: salemode });
        key++;
    });
    _.each(settle, function (amount, salemode) {
        jsx_settlevalues.push({ key: key, amount: amount, salemode: salemode });
        nodatacheck += amount;
        key++;
    });

    //console.log(jsx_settlevalues);
    //console.log(jsx_servicevalues);

    var chartvalues = ChartValues(datetimefilterid, nodatacheck, datetimevalue, postdetails);


    //console.log(chartvalues);

    const makefirstcap = function (str) {
        return str.charAt(0).toUpperCase() + str.slice(1).toLowerCase();
    };

    const linedata1 = {
        series: [
            {
                name: areaname,
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
                    show: false,
                },
                axisTicks: {
                    show: false,
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

    const linedata = {
        series: [
            {
                name: areaname,
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

    var data = {};

    //console.log(chartvalues.chartmode);

    //alert(chartvalues.chartmode);

    // if (chartvalues.chartmode == "line") {
    //     data = linedata;
    //     data.chartmode = "bar";
    // } else if (chartvalues.chartmode == "bar") {
    //     data = linedata;
    //     data.chartmode = "bar";
    // }

    data = linedata;
    data.chartmode = "bar";

    var boxstyle = {
        padding: "12px",
        marginBottom: marginbottomval
    }

    // console.log(areavalue);
    // console.log(jsx_servicevalues);
    // console.log(jsx_settlevalues);

    const [collapseshow, setCollapseshow] = React.useState(true);
    const handleCollapseToggle = () => setCollapseshow(!collapseshow);

    //console.log(collapseshow)

    var collapseIcon = (collapseshow == false) ? <PlusIcon rotate={1} flip="horizontal" fill="#028cf3" /> : <MinusIcon rotate={1} flip="horizontal" fill="#028cf3" />;

    function collapsefilterimg(props) {
        //console.log(collapseshow);
        if (collapseshow == true) {
            return (
                <PlusIcon rotate={1} flip="horizontal" fill="#028cf3" />
            );
        } else {
            return (
                <MinusIcon rotate={1} flip="horizontal" fill="#028cf3" />
            );
        }
    }

    var collapsetagid = "collapsetag-" + areaid;

    if (areavalue == 0) {
        return (
            <Box style={boxstyle}>

                <Box className="pos-revenue-section-pos fadeinfwd">
                    <Grid container style={{ padding: "15px 15px 0px 15px" }}>
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
                            <span className="sales-section-text">{makefirstcap(areaname)}</span>
                        </Grid>
                        <Grid item xs={4} className="fsec-body-header1">
                            <ButtonToolbar className="collapsetoolbar">
                                <IconButton size="md" onClick={handleCollapseToggle} icon={collapseIcon} />
                            </ButtonToolbar>
                        </Grid>
                    </Grid>
                    <Grid container style={{ paddingBottom: "15px" }}>
                        <Grid item xs={1}></Grid>
                        <Grid
                            item
                            xs={7}
                            className="fsec-body-header"
                            style={{ paddingLeft: "23px" }}
                        >
                            <span className="sales-section-amount">&#8377; {Nformat(areavalue)}</span>
                        </Grid>
                        <Grid item xs={4} className="fsec-body-header1"></Grid>
                    </Grid>
                    <Grid item xs={6}>

                    </Grid>




                    <Animation.Collapse in={collapseshow}>
                        <div id={collapsetagid} className="collapsetag">

                            <Grid container item xs={12} className="sales-section-details1">
                                {
                                    jsx_servicevalues.map((jsx_servicevalue) => {
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
                                                <div>
                                                    <div className="sales-section-amount-details-name">By {makefirstcap(jsx_servicevalue.salemode)}</div>
                                                    <div className="sales-section-amount-details-value">
                                                        &#8377; {Nformat(jsx_servicevalue.amount)}
                                                    </div>
                                                </div>
                                            </Grid>
                                        )
                                    })
                                }
                            </Grid>



                            <Grid container item xs={12} className="sales-section-details">
                                {
                                    jsx_settlevalues.map((jsx_settlevalue) => {
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
                                                <div>
                                                    <div className="sales-section-amount-details-name">By {makefirstcap(jsx_settlevalue.salemode)}</div>
                                                    <div className="sales-section-amount-details-value">
                                                        &#8377; {Nformat(jsx_settlevalue.amount)}
                                                    </div>
                                                </div>
                                            </Grid>
                                        )
                                    })
                                }
                            </Grid>
                        </div>
                    </Animation.Collapse>


                </Box>
            </Box >
        );
    } else {
        return (
            <Box style={boxstyle}>

                <Box className="pos-revenue-section-pos fadeinfwd">
                    <Grid container style={{ padding: "15px 15px 0px 15px" }}>
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
                            <span className="sales-section-text">{makefirstcap(areaname)}</span>
                        </Grid>
                        <Grid item xs={4} className="fsec-body-header1">
                            <ButtonToolbar className="collapsetoolbar">
                                <IconButton size="md" onClick={handleCollapseToggle} icon={collapseIcon} />
                            </ButtonToolbar>
                        </Grid>
                    </Grid>
                    <Grid container style={{ paddingBottom: "15px" }}>
                        <Grid item xs={1}></Grid>
                        <Grid
                            item
                            xs={7}
                            className="fsec-body-header"
                            style={{ paddingLeft: "23px" }}
                        >
                            <span className="sales-section-amount">&#8377; {Nformat(areavalue)}</span>
                        </Grid>
                        <Grid item xs={4} className="fsec-body-header1"></Grid>
                    </Grid>
                    <Grid item xs={6}></Grid>

                    <Animation.Collapse in={collapseshow}>

                        <div id={collapsetagid} className="collapsetag">

                            <Box style={{ marginTop: "-15px" }}>
                                <Grid container item xs={12}>
                                    <div className="compare-grap-wrapper">
                                        <Chart options={data.options} series={data.series} type={data.chartmode} />
                                    </div>
                                </Grid>
                            </Box>



                            <Grid container item xs={12} className="sales-section-details1">
                                {
                                    jsx_servicevalues.map((jsx_servicevalue) => {
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
                                                <div>
                                                    <div className="sales-section-amount-details-name">By {makefirstcap(jsx_servicevalue.salemode)}</div>
                                                    <div className="sales-section-amount-details-value">
                                                        &#8377; {Nformat(jsx_servicevalue.amount)}
                                                    </div>
                                                </div>
                                            </Grid>
                                        )
                                    })
                                }
                            </Grid>



                            <Grid container item xs={12} className="sales-section-details">
                                {
                                    jsx_settlevalues.map((jsx_settlevalue) => {
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
                                                <div>
                                                    <div className="sales-section-amount-details-name">By {makefirstcap(jsx_settlevalue.salemode)}</div>
                                                    <div className="sales-section-amount-details-value">
                                                        &#8377; {Nformat(jsx_settlevalue.amount)}
                                                    </div>
                                                </div>
                                            </Grid>
                                        )
                                    })
                                }
                            </Grid>
                        </div>
                    </Animation.Collapse>
                </Box>
            </Box >
        );
    }
}

