import React, { useState, useEffect } from "react";
import "./Main.css";
import Grid from "@mui/material/Grid";
import Box from "@mui/material/Box";
import Areaimage from "./ic_acrestaurant.svg";
import _ from 'underscore';
import DataTable from './Pitemsdatagrid.js'
import Toggleswitch from './Toggleswitch.js'
import Urlobjmaker from './Urlobjmaker';
import Apicallprocess from './Apicallprocess';
import Nformat from './Nformat';
import ButtonToolbar from 'rsuite/ButtonToolbar';
import Animation from 'rsuite/Animation';
import IconButton from 'rsuite/IconButton';
import PlusIcon from '@rsuite/icons/Plus';
import MinusIcon from '@rsuite/icons/Minus';
import Posskeleton_item from './Posskeleton_item.js';

const Positemcard = (props) => {
    //console.log(props);

    var areaname = props.areadetail.areaname;
    var areavalue = Number(props.areavalue).toFixed(2);
    var areaid = props.areadetail.areaid;
    var propid = props.propcmpdetails.propid;
    var cmpid = props.propcmpdetails.cmpid;
    var contextdetails = props.contextval.details;
    var contextvalues = props.contextval.values;
    var postdetails = contextdetails.postdetails;
    var cpostdetails = postdetails;

    //console.log(cpostdetails);

    const resetitemsasone = (itemdetails, groupmode = 0) => {
        var nw_itemdetails = {};
        if (groupmode == 0) {
            _.each(itemdetails, function (itemdetail) {
                var itemid = itemdetail.itemid;
                if (!_.keys(nw_itemdetails).includes(itemid)) {
                    nw_itemdetails[itemid] = {};
                    nw_itemdetails[itemid].qty = 0;
                    nw_itemdetails[itemid].amount = 0;
                }
                nw_itemdetails[itemid].itemid = itemid;
                nw_itemdetails[itemid].itemname = itemdetail.itemname;
                nw_itemdetails[itemid].qty += Number(itemdetail.qty);
                nw_itemdetails[itemid].amount += Number(itemdetail.amount);
            });
            _.each(nw_itemdetails, function (itemdetail, itemid) {
                nw_itemdetails[itemid].amount = Number(nw_itemdetails[itemid].amount / 1).toFixed(2);
            });
        }
        else {
            _.each(itemdetails, function (itemdetail) {
                var grpid = itemdetail.grpid;
                if (!_.keys(nw_itemdetails).includes(grpid)) {
                    nw_itemdetails[grpid] = {};
                    nw_itemdetails[grpid].qty = 0;
                    nw_itemdetails[grpid].amount = 0;
                }
                nw_itemdetails[grpid].grpid = grpid;
                nw_itemdetails[grpid].grpname = itemdetail.grpname;
                nw_itemdetails[grpid].qty += Number(itemdetail.qty);
                nw_itemdetails[grpid].amount += Number(itemdetail.amount);
            });
            _.each(nw_itemdetails, function (itemdetail, grpid) {
                nw_itemdetails[grpid].amount = Number(nw_itemdetails[grpid].amount / 1).toFixed(2);
            });
        }
        return nw_itemdetails;
    }

    const [groupmode, setGroupMode] = React.useState(0);

    //const [groupmode_c, setGroupMode_c] = React.useState(0);

    //const [groupmode_c, setGroupMode_c] = React.useState(0);

    //console.log(groupmode);

    function dtcolumns_cons(field, headername, width) {
        this.field = field;
        this.headername = headername;
        this.width = width;
    }

    function dtrows_cons(id, itemname, qty, amount, areavalue) {
        this.id = id;
        this.itemname = itemname;
        this.qty = Number(qty);
        this.amount = Number(amount);
        this.areavalue = Number(areavalue);
        this.contribution = Number(((this.amount * 100) / (this.areavalue)).toFixed(2))
    }

    var dtcolumns = [];
    var dtrows = [];
    const makefirstcap = function (str) {
        return str.charAt(0).toUpperCase() + str.slice(1).toLowerCase();
    };

    const [switchvalues, setSwitchValues] = useState(
        {
            areaid: areaid,
            propid: propid,
            cmpid: cmpid,
            fromdate: postdetails.fromdate,
            todate: postdetails.todate,
            viewmode: postdetails.viewmode,
            itemsfilter: postdetails.itemsfilter,
            groupmode: 0,
            dtrows: [],
            dtcolumns: []
        }
    );

    const changegroupmode = async (postdetails, noset = 0) => {
        //console.log(postdetails);
        //console.log(cpostdetails);

        postdetails.fromdate = cpostdetails.fromdate;
        postdetails.todate = cpostdetails.todate;
        var urlobj = new Urlobjmaker(postdetails, "posareagroupkotdetails");
        var response = await Apicallprocess(urlobj.madeurl, urlobj.postdata);
        //console.log(urlobj);
        //console.log(response);
        var dtrows = [];
        var dtcolumns = [];
        if (response) {
            var pgroupmode = postdetails.groupmode;
            if (_.keys(response).includes('values')) {
                var contextvalues = response.values;
                cardvalue = contextvalues[areaid];
                let datefilterobj = { 0: 'Today', 1: 'Last 7 days', 2: 'Last 30 days', 3: 'Current Month', 4: 'Last Month', 5: 'Current Year' };
                let itemsfilterobj = { 0: 'Items Sold', 1: 'Items Cancelled', 2: 'Most Sold Items', 3: 'Least Sold Items' };
                var itemsfilter = postdetails.itemsfilter;
                //console.log(itemsfilter)
                var itemvalues = (itemsfilter == 1) ? cardvalue.cancel : cardvalue.nocancel;
                if (itemsfilter == 0) {
                    itemvalues = resetitemsasone(itemvalues, pgroupmode);
                    //console.log(itemvalues);
                    _.each(itemvalues, function (itemvalue) {
                        var dtrow = new dtrows_cons(itemvalue.grpid, itemvalue.grpname, itemvalue.qty, itemvalue.amount, props.areavalue);
                        dtrows.push(dtrow);
                    });
                    //console.log(dtrows);
                    var dtcolumns = [
                        { field: 'itemname', headerName: 'Group', width: 150 },
                        { field: 'qty', headerName: 'Qty', width: 58 },
                        { field: 'amount', headerName: 'Amount', width: 74 },
                        { field: 'contribution', headerName: 'Contrib%', width: 73 }
                    ];
                    //switchvalues.dtrows = dtrows;
                    //switchvalues.dtcolumns = dtcolumns;
                } else if (itemsfilter == 3) { //least sold
                    itemvalues = resetitemsasone(itemvalues, pgroupmode);
                    var sort_itemvalues = [];
                    _.each(itemvalues, function (itemvalue) {
                        sort_itemvalues.push(itemvalue)
                    });
                    sort_itemvalues.sort((a, b) => {
                        return a.qty - b.qty;
                    });
                    itemvalues = sort_itemvalues;
                    //console.log(itemvalues);
                    _.each(itemvalues, function (itemvalue) {
                        var dtrow = new dtrows_cons(itemvalue.grpid, itemvalue.grpname, itemvalue.qty, itemvalue.amount, props.areavalue);
                        dtrows.push(dtrow);
                    });
                    var dtcolumns = [
                        { field: 'itemname', headerName: 'Group', width: 150 },
                        { field: 'qty', headerName: 'Qty', width: 58 },
                        { field: 'amount', headerName: 'Amount', width: 74 },
                        { field: 'contribution', headerName: 'Contrib%', width: 73 }
                    ];
                } else if (itemsfilter == 2) { //most sold
                    itemvalues = resetitemsasone(itemvalues, pgroupmode);
                    var sort_itemvalues = [];
                    _.each(itemvalues, function (itemvalue) {
                        sort_itemvalues.push(itemvalue)
                    });
                    sort_itemvalues.sort((a, b) => {
                        return b.qty - a.qty;
                    });
                    itemvalues = sort_itemvalues;
                    _.each(itemvalues, function (itemvalue) {
                        var dtrow = new dtrows_cons(itemvalue.grpid, itemvalue.grpname, itemvalue.qty, itemvalue.amount, props.areavalue);
                        dtrows.push(dtrow);
                    });
                    var dtcolumns = [
                        { field: 'itemname', headerName: 'Item', width: 150 },
                        { field: 'qty', headerName: 'Qty', width: 58 },
                        { field: 'amount', headerName: 'Amount', width: 74 },
                        { field: 'contribution', headerName: 'Contrib%', width: 73 }
                    ];
                } else if (itemsfilter == 1) { //Items cancelled
                    itemvalues = resetitemsasone(itemvalues, pgroupmode);
                    var dtcolumns = [
                        { field: 'itemname', headerName: 'Group', width: 150 },
                        { field: 'qty', headerName: 'Qty', width: 58 },
                        { field: 'amount', headerName: 'Amount', width: 74 },
                    ];
                    _.each(itemvalues, function (itemvalue) {
                        var dtrow = new dtrows_cons(itemvalue.grpid, itemvalue.grpname, itemvalue.qty, itemvalue.amount, props.areavalue);
                        dtrows.push(dtrow);
                    });
                }
            }
        }
        //console.log(switchvalues);
        //console.log(pgroupmode);
        if (noset == 0) {
            setGroupMode(pgroupmode);
            setSwitchValues(
                {
                    areaid: switchvalues.areaid,
                    propid: switchvalues.propid,
                    cmpid: switchvalues.cmpid,
                    fromdate: switchvalues.fromdate,
                    todate: switchvalues.todate,
                    viewmode: switchvalues.viewmode,
                    itemsfilter: switchvalues.itemsfilter,
                    groupmode: pgroupmode,
                    dtrows: dtrows,
                    dtcolumns: dtcolumns
                }
            );
        } else {
            switchvalues.groupmode = 1;
            switchvalues.dtrows = dtrows;
            switchvalues.dtcolumns = dtcolumns;
            return switchvalues;
            //console.log(switchvalues);
            // setSwitchValues(
            //     {
            //         areaid: switchvalues.areaid,
            //         propid: switchvalues.propid,
            //         cmpid: switchvalues.cmpid,
            //         fromdate: switchvalues.fromdate,
            //         todate: switchvalues.todate,
            //         viewmode: switchvalues.viewmode,
            //         itemsfilter: switchvalues.itemsfilter,
            //         groupmode: pgroupmode,
            //         dtrows: dtrows,
            //         dtcolumns: dtcolumns
            //     }
            // );
            //setGroupMode(1);
        }

        //console.log(switchvalues);
    }

    //console.log(contextvalues);
    //console.log(groupmode)

    var cardvalue = {};

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

    //console.log(contextvalues);

    if (!_.keys(contextvalues).length) {
        return (<Posskeleton_item></Posskeleton_item>);
    } else {
        if (contextvalues && groupmode == 0) {
            if (_.keys(contextvalues).includes(areaid)) {
                cardvalue = contextvalues[areaid];
                let datefilterobj = { 0: 'Today', 1: 'Last 7 days', 2: 'Last 30 days', 3: 'Current Month', 4: 'Last Month', 5: 'Current Year' };
                let itemsfilterobj = { 0: 'Items Sold', 1: 'Items Cancelled', 2: 'Most Sold Items', 3: 'Least Sold Items' };
                var itemsfilter = postdetails.itemsfilter;
                //console.log(itemsfilter)
                var itemvalues = (itemsfilter == 1) ? cardvalue.cancel : cardvalue.nocancel;
                if (itemsfilter == 0) {
                    itemvalues = resetitemsasone(itemvalues, groupmode);
                    _.each(itemvalues, function (itemvalue) {
                        var dtrow = new dtrows_cons(itemvalue.itemid, itemvalue.itemname, itemvalue.qty, itemvalue.amount, props.areavalue);
                        dtrows.push(dtrow);
                    });
                    var dtcolumns = [
                        { field: 'itemname', headerName: 'Item', width: 150 },
                        { field: 'qty', headerName: 'Qty', width: 58 },
                        { field: 'amount', headerName: 'Amount', width: 74 },
                        { field: 'contribution', headerName: 'Contrib%', width: 73 }
                    ];
                } else if (itemsfilter == 3) { //least sold
                    itemvalues = resetitemsasone(itemvalues, groupmode);
                    var sort_itemvalues = [];
                    _.each(itemvalues, function (itemvalue) {
                        sort_itemvalues.push(itemvalue)
                    });
                    sort_itemvalues.sort((a, b) => {
                        return a.qty - b.qty;
                    });
                    itemvalues = sort_itemvalues;
                    //console.log(itemvalues);
                    _.each(itemvalues, function (itemvalue) {
                        var dtrow = new dtrows_cons(itemvalue.itemid, itemvalue.itemname, itemvalue.qty, itemvalue.amount, props.areavalue);
                        dtrows.push(dtrow);
                    });
                    var dtcolumns = [
                        { field: 'itemname', headerName: 'Item', width: 150 },
                        { field: 'qty', headerName: 'Qty', width: 58 },
                        { field: 'amount', headerName: 'Amount', width: 74 },
                        { field: 'contribution', headerName: 'Contrib%', width: 73 }
                    ];
                } else if (itemsfilter == 2) { //most sold
                    itemvalues = resetitemsasone(itemvalues, groupmode);
                    var sort_itemvalues = [];
                    _.each(itemvalues, function (itemvalue) {
                        sort_itemvalues.push(itemvalue)
                    });
                    sort_itemvalues.sort((a, b) => {
                        return b.qty - a.qty;
                    });
                    itemvalues = sort_itemvalues;
                    _.each(itemvalues, function (itemvalue) {
                        var dtrow = new dtrows_cons(itemvalue.itemid, itemvalue.itemname, itemvalue.qty, itemvalue.amount, props.areavalue);
                        dtrows.push(dtrow);
                    });
                    var dtcolumns = [
                        { field: 'itemname', headerName: 'Item', width: 150 },
                        { field: 'qty', headerName: 'Qty', width: 58 },
                        { field: 'amount', headerName: 'Amount', width: 74 },
                        { field: 'contribution', headerName: 'Contrib%', width: 73 }
                    ];
                } else if (itemsfilter == 1) { //Items cancelled
                    itemvalues = resetitemsasone(itemvalues, groupmode);
                    var dtcolumns = [
                        { field: 'itemname', headerName: 'Item', width: 180 },
                        { field: 'qty', headerName: 'Qty', width: 76 },
                        { field: 'amount', headerName: 'Amount', width: 85 },
                    ];
                    _.each(itemvalues, function (itemvalue) {
                        var dtrow = new dtrows_cons(itemvalue.itemid, itemvalue.itemname, itemvalue.qty, itemvalue.amount, props.areavalue);
                        dtrows.push(dtrow);
                    });
                }
            }
            switchvalues.dtrows = dtrows;
            switchvalues.dtcolumns = dtcolumns;
            var gridtableid = "gridtable-" + areaid;
            return (
                <div>
                    <Box id={gridtableid} className="gridtable fadeinfwd" style={{ padding: "12px", marginBottom: "0px", position: 'relative', top: '-0.7rem' }}>
                        <Box className="pos-revenue-section-pos">
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
                                <Grid item xs={4} className="fsec-body-header1"></Grid>
                            </Grid>
                            <Grid container style={{ paddingBottom: "15px" }}>
                                <Grid item xs={1}></Grid>
                                <Grid
                                    item
                                    xs={11}
                                    className="fsec-body-header"
                                    style={{ paddingLeft: "23px" }}
                                >
                                    <span className="sales-section-amount">&#8377; {Nformat(areavalue)}</span>
                                    <Toggleswitch changegroupmode={changegroupmode} details={switchvalues}></Toggleswitch>
                                    <ButtonToolbar id="collapsetoolbar-item" className="collapsetoolbar">
                                        <IconButton size="md" onClick={handleCollapseToggle} icon={collapseIcon} />
                                    </ButtonToolbar>
                                </Grid>
                            </Grid>
                        </Box>
                    </Box >
                    <Animation.Collapse in={collapseshow}>
                        <div id={collapsetagid} className="collapsetag">
                            {
                                (switchvalues.dtrows.length && switchvalues.dtcolumns.length)
                                    ? <DataTable groupmode={switchvalues.groupmode} postdetails={postdetails} areaid={props.areadetail.areaid} rows={switchvalues.dtrows} columns={switchvalues.dtcolumns}></DataTable>
                                    : ''
                            }
                        </div>
                    </Animation.Collapse>

                </div>
            );
            //setGroupMode(1)
        } else if (contextvalues && groupmode == 1) {

            // var postdetails = {
            //     areaid: switchvalues.areaid,
            //     propid: switchvalues.propid,
            //     cmpid: switchvalues.cmpid,
            //     fromdate: cpostdetails.fromdate,
            //     todate: cpostdetails.todate,
            //     viewmode: switchvalues.viewmode,
            //     itemsfilter: cpostdetails.itemsfilter,
            //     datefilter: cpostdetails.datefilter,
            //     groupmode: 1
            // }
            // console.log(postdetails);
            //changegroupmode(postdetails, 1);
            //console.log(cgvalues)
            //console.log('2323');
            //console.log(response);
            var dtrows = [];
            var dtcolumns = [];
            if (contextvalues) {
                var pgroupmode = 1;
                //console.log('45645');
                //console.log(contextvalues);
                if (_.keys(contextvalues).includes(areaid)) {
                    //console.log('789789');
                    var cardvalue = contextvalues[areaid];
                    let datefilterobj = { 0: 'Today', 1: 'Last 7 days', 2: 'Last 30 days', 3: 'Current Month', 4: 'Last Month', 5: 'Current Year' };
                    let itemsfilterobj = { 0: 'Items Sold', 1: 'Items Cancelled', 2: 'Most Sold Items', 3: 'Least Sold Items' };
                    var itemsfilter = postdetails.itemsfilter;
                    //console.log(itemsfilter)
                    var itemvalues = (itemsfilter == 1) ? cardvalue.cancel : cardvalue.nocancel;
                    //console.log(itemvalues);
                    if (itemsfilter == 0) {
                        itemvalues = resetitemsasone(itemvalues, pgroupmode);
                        //console.log(itemvalues);
                        _.each(itemvalues, function (itemvalue) {
                            var dtrow = new dtrows_cons(itemvalue.grpid, itemvalue.grpname, itemvalue.qty, itemvalue.amount, props.areavalue);
                            dtrows.push(dtrow);
                        });
                        //console.log(dtrows);
                        var dtcolumns = [
                            { field: 'itemname', headerName: 'Group', width: 150 },
                            { field: 'qty', headerName: 'Qty', width: 58 },
                            { field: 'amount', headerName: 'Amount', width: 74 },
                            { field: 'contribution', headerName: 'Contrib%', width: 73 }
                        ];
                        //switchvalues.dtrows = dtrows;
                        //switchvalues.dtcolumns = dtcolumns;
                    } else if (itemsfilter == 3) { //least sold
                        itemvalues = resetitemsasone(itemvalues, pgroupmode);
                        var sort_itemvalues = [];
                        _.each(itemvalues, function (itemvalue) {
                            sort_itemvalues.push(itemvalue)
                        });
                        sort_itemvalues.sort((a, b) => {
                            return a.qty - b.qty;
                        });
                        itemvalues = sort_itemvalues;
                        //console.log(itemvalues);
                        _.each(itemvalues, function (itemvalue) {
                            var dtrow = new dtrows_cons(itemvalue.grpid, itemvalue.grpname, itemvalue.qty, itemvalue.amount, props.areavalue);
                            dtrows.push(dtrow);
                        });
                        var dtcolumns = [
                            { field: 'itemname', headerName: 'Group', width: 150 },
                            { field: 'qty', headerName: 'Qty', width: 58 },
                            { field: 'amount', headerName: 'Amount', width: 74 },
                            { field: 'contribution', headerName: 'Contrib%', width: 73 }
                        ];
                    } else if (itemsfilter == 2) { //most sold
                        itemvalues = resetitemsasone(itemvalues, pgroupmode);
                        var sort_itemvalues = [];
                        _.each(itemvalues, function (itemvalue) {
                            sort_itemvalues.push(itemvalue)
                        });
                        sort_itemvalues.sort((a, b) => {
                            return b.qty - a.qty;
                        });
                        itemvalues = sort_itemvalues;
                        _.each(itemvalues, function (itemvalue) {
                            var dtrow = new dtrows_cons(itemvalue.grpid, itemvalue.grpname, itemvalue.qty, itemvalue.amount, props.areavalue);
                            dtrows.push(dtrow);
                        });
                        var dtcolumns = [
                            { field: 'itemname', headerName: 'Item', width: 150 },
                            { field: 'qty', headerName: 'Qty', width: 58 },
                            { field: 'amount', headerName: 'Amount', width: 74 },
                            { field: 'contribution', headerName: 'Contrib%', width: 73 }
                        ];
                    } else if (itemsfilter == 1) { //Items cancelled
                        itemvalues = resetitemsasone(itemvalues, pgroupmode);
                        var dtcolumns = [
                            { field: 'itemname', headerName: 'Group', width: 180 },
                            { field: 'qty', headerName: 'Qty', width: 76 },
                            { field: 'amount', headerName: 'Amount', width: 85 },
                        ];
                        _.each(itemvalues, function (itemvalue) {
                            var dtrow = new dtrows_cons(itemvalue.grpid, itemvalue.grpname, itemvalue.qty, itemvalue.amount, props.areavalue);
                            dtrows.push(dtrow);
                        });
                    }
                }
            }

            return (
                <div>
                    <Box id={gridtableid} className="gridtable fadeinfwd" style={{ padding: "12px", marginBottom: "0px", position: 'relative', top: '-0.7rem' }}>
                        <Box className="pos-revenue-section-pos">
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
                                </Grid>
                            </Grid>
                            <Grid container style={{ paddingBottom: "15px" }}>
                                <Grid item xs={1}></Grid>
                                <Grid
                                    item
                                    xs={11}
                                    className="fsec-body-header"
                                    style={{ paddingLeft: "23px" }}
                                >
                                    <span className="sales-section-amount">&#8377; {Nformat(areavalue)}</span>
                                    <Toggleswitch changegroupmode={changegroupmode} details={switchvalues}></Toggleswitch>
                                    <ButtonToolbar id="collapsetoolbar-item" className="collapsetoolbar">
                                        <IconButton size="md" onClick={handleCollapseToggle} icon={collapseIcon} />
                                    </ButtonToolbar>
                                </Grid>
                            </Grid>
                        </Box>
                    </Box >
                    <Animation.Collapse in={collapseshow}>
                        <div id={collapsetagid} className="collapsetag">
                            {
                                (dtrows.length && dtcolumns.length)
                                    ? <DataTable groupmode={1} postdetails={postdetails} areaid={props.areadetail.areaid} rows={dtrows} columns={dtcolumns}></DataTable>
                                    : ''
                            }
                        </div>
                    </Animation.Collapse>

                </div >

            );
        }
    }




    //console.log(props);


}

export default Positemcard;
