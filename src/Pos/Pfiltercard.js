import React, { useState, useEffect } from 'react';
import Card from '@mui/material/Card';
import CardActions from '@mui/material/CardActions';
import CardContent from '@mui/material/CardContent';
import InputLabel from '@mui/material/InputLabel';
import FormControl from '@mui/material/FormControl';
import MenuItem from '@mui/material/MenuItem';
import Select from '@mui/material/Select';
import _ from 'underscore';
import $ from 'jquery';
import { DateTime } from 'luxon';
import DateRangeMaker from './DateRangeMaker';
import Button from '@mui/material/Button';
import Grid from "@mui/material/Grid";
import Itemimg from "./ic_menu_item_active.svg";
import Salesimg from "./ic_menu_sales_active.svg";
import Itemimg_noactive from "./ic_menu_item_noactive.svg";
import Salesimg_noactive from "./ic_menu_sales_noactive.svg";
import { ReactComponent as Dfilterimg } from './ic_filter.svg';
import FilterAltIcon from '@mui/icons-material/CategoryOutlined';
import SvgIcon from '@mui/material/SvgIcon';
import KeyboardArrowDownIcon from '@mui/icons-material/KeyboardArrowDown';
import Mclose from "./ic_close.svg";
import Box from '@mui/material/Box';
import Modal from '@mui/material/Modal';

import 'rsuite/dist/rsuite.min.css'
import DateRangePicker from 'rsuite/DateRangePicker';

const modalboxstyle = {
    position: 'absolute',
    top: '42%',
    left: '50%',
    transform: 'translate(-50%, -50%)',
    bgcolor: 'background.paper',
    border: '1px solid #e4dfdf',
    boxShadow: 24,
    p: 4,
    height: '72%',
    width: '78%',
    borderRadius: '10px',
    padding: '15px'

};

export default function Pfiltercard(props) {

    let datefilterobj = { 0: 'Today', 1: 'Last 7 days', 2: 'Last 30 days', 3: 'Current Month', 4: 'Last Month', 5: 'Current Year', 6: 'Date Range' };

    let itemsfilterobj = { 0: 'Items Sold', 1: 'Items Cancelled', 2: 'Most Sold Items', 3: 'Least Sold Items' };

    let arealist = props.arealist;

    let viewmodeid = props.viewmodeid;



    //let propid = props.propcmpdetails.propid;

    //let cmpid = props.propcmpdetails.cmpid;

    //let cmpid = props.propcmpdetails.cmpid;

    //const [datefilter, setDateFilter] = React.useState(0);

    //console.log(props)
    const [open, setOpen] = React.useState(false);
    const handleOpen = () => setOpen(true);
    const handleClose = () => {
        setOpen(false)
    }

    const [datefilter, setDateFilter] = useState(
        {
            fromdate: DateTime.now().setZone('Asia/Kolkata').toSQL().split(' ')[0],
            todate: DateTime.now().setZone('Asia/Kolkata').toSQL().split(' ')[0],
            value: 0,
            rangeclsname: 'hideme'
        }
    );

    function dtfilterimg(props) {
        return (
            <SvgIcon {...props}>
                <Dfilterimg />
            </SvgIcon>
        );
    }

    function areafilterimg(props) {
        return (
            <SvgIcon {...props}>
                <KeyboardArrowDownIcon color="primary" />
            </SvgIcon>
        );
    }

    function itemfilterimg(props) {
        return (
            <SvgIcon {...props}>
                <FilterAltIcon color="primary" />
            </SvgIcon>
        );
    }


    const [areafilter, setAreaFilter] = React.useState(0);

    const [pagefilter, setPageFilter] = React.useState(0);

    const [itemsfilter, setItemsFilter] = React.useState(0);

    const [daterangeinit, setDateRangeInit] = React.useState(0);

    const handlePageFilterChange = (event) => {
        //console.log(event.target.value);
        var oldpagemode = pagefilter;
        //console.log(oldpagemode);
        setPageFilter(event.target.value);
        var pagemode = event.target.value;
        var viemode = pagemode == 0 ? 'posareasrvsettlevalues' : 'posareaitemsettlevalues';
        if (oldpagemode != pagemode) {
            var contextobj = {
                'fromdate': datefilter.fromdate,
                'todate': datefilter.todate,
                'areaid': areafilter,
                'propid': props.propcmpdetails.propid,
                'cmpid': props.propcmpdetails.cmpid,
                'viewmode': viemode,
                'itemsfilter': itemsfilter,
                'datefilter': datefilter.value
            }
            //console.log(props);
            props.changeviewmode(contextobj);
        }
    };

    const handleDateFilterChange = (event) => {
        //console.log(DateRangeMaker(event.target.value));

        if (event.target.value) {
            if (event.target.value != 6) {
                datefilter.rangeclsname = 'hideme';
                setDateFilter(
                    DateRangeMaker(event.target.value)
                );
                changepsalesview(props, DateRangeMaker(event.target.value), 'no');
            }
            else if (event.target.value == 6) {
                //alert(event.target.value);
                datefilter.rangeclsname = 'nohideme';
                handleOpen();
                setDateFilter({
                    fromdate: datefilter.fromdate,
                    todate: datefilter.todate,
                    value: event.target.value,
                    rangeclsname: 'nohideme'
                });

            }
            //console.log(datefilter.rangeclsname);
        }
    };

    useEffect(() => {
        //console.log('use effect', todos, count);
        //console.log(datefilter.rangeclsname);
        setTimeout(() => {
            $('#daterangepicker').trigger('click');
        }, 150);
        return () => {

        }
    }, [datefilter])

    const handleItemsFilterChange = (event) => {
        setItemsFilter(event.target.value);
        var viemode = pagefilter == 0 ? 'posareasrvsettlevalues' : 'posareaitemsettlevalues';
        var contextobj = {
            'fromdate': datefilter.fromdate,
            'todate': datefilter.todate,
            'areaid': areafilter,
            'propid': props.propcmpdetails.propid,
            'cmpid': props.propcmpdetails.cmpid,
            'viewmode': viemode,
            'itemsfilter': event.target.value,
            'datefilter': datefilter.value
        }
        //console.log(props);
        props.changeviewmode(contextobj);
    };

    const handleAreaFilterChange = (event) => {
        setAreaFilter(event.target.value);
        let areaid = event.target.value;
        if (areaid == 0) {
            areaid = (_.keys(props.arealist)).join(",");
        }
        changepsalesview(props, 'no', areaid);
    };

    const handleDateRangeFilterChange = (daterangearr, event) => {
        var daterange = {};
        handleClose();
        if (daterangearr.length == 2) {
            daterange.fromdate = daterangearr[0].toJSON().substring(0, 10);
            daterange.todate = daterangearr[1].toJSON().substring(0, 10);
            daterange.value = 6;
            setDateFilter({
                fromdate: daterange.fromdate,
                todate: daterange.todate,
                value: daterange.value,
                rangeclsname: 'nohideme'
            });
            var viemode = pagefilter == 0 ? 'posareasrvsettlevalues' : 'posareaitemsettlevalues';
            var contextobj = {
                'fromdate': daterange.fromdate,
                'todate': daterange.todate,
                'areaid': areafilter,
                'propid': props.propcmpdetails.propid,
                'cmpid': props.propcmpdetails.cmpid,
                'viewmode': viemode,
                'itemsfilter': itemsfilter,
                'datefilter': daterange.value
            }
            //console.log(contextobj);
            props.changeviewmode(contextobj);
            //alert(DateTime.set(daterange.fromdate).plus({ days: 1 }).toISODate());
        }
    }

    const changepsalesview = (props, datefilterobj, areaid) => {
        if (areaid == "no") { areaid = areafilter; }
        if (datefilterobj == "no") { datefilterobj = datefilter; }
        var viemode = pagefilter == 0 ? 'posareasrvsettlevalues' : 'posareaitemsettlevalues';
        var contextobj = {
            'fromdate': datefilterobj.fromdate,
            'todate': datefilterobj.todate,
            'areaid': areaid,
            'propid': props.propcmpdetails.propid,
            'cmpid': props.propcmpdetails.cmpid,
            'viewmode': viemode,
            'itemsfilter': itemsfilter,
            'datefilter': datefilterobj.value
        }
        props.changeviewmode(contextobj);
    }

    // useEffect(() => {
    //     //console.log('use effect', todos, count);
    //     //var instance = new NiceSelect(document.getElementById("filterlist"), options);
    //     var contextobj = {
    //         'fromdate': datefilter.fromdate,
    //         'todate': datefilter.todate,
    //         'areaid': areafilter,
    //         'propid': propid,
    //         'cmpid': cmpid
    //     }

    //     //props.changecontext(contextobj);

    //     //console.log(props);

    //     return () => {

    //     }
    // })

    //console.log(viewmodeid)

    var itemviewimg = viewmodeid == 1 ? Itemimg : Itemimg_noactive;
    var srvviewimg = viewmodeid == 0 ? Salesimg : Salesimg_noactive;

    var itemviewclsname = viewmodeid == 1 ? "Pbtnview itemviewblu" : "Pbtnview itemviewbla";
    var srvviewclsname = viewmodeid == 0 ? "Pbtnview srvviewblu" : "Pbtnview srvviewbla";

    //console.log(srvviewclsname);

    return (
        <div >
            <Card id="filtercard-div" sx={{}}>
                <CardContent>
                    <div id="filtercard-div-div">
                        <FormControl id="filtercard-areafilter" variant="standard" sx={{ m: 1, minWidth: 100 }}>
                            <InputLabel id="areafilter-label">Area</InputLabel>
                            <Select
                                labelId="areafilter-label"
                                id="areafilter"
                                value={areafilter}
                                label="AreaFilter"
                                onChange={handleAreaFilterChange}
                                IconComponent={areafilterimg}
                            >
                                <MenuItem key={0} value={0}>All</MenuItem>
                                {
                                    _.keys(arealist).map((areaid) => {
                                        return (
                                            <MenuItem key={areaid} value={areaid}>{arealist[areaid]}</MenuItem>
                                        )
                                    })
                                }
                            </Select>

                        </FormControl>

                        {
                            (viewmodeid == 0) ? '' : <FormControl id="filtercard-itemfilter" variant="standard" sx={{ m: 1, minWidth: 100 }}>
                                <InputLabel id="itemsfilter-label">Items</InputLabel>
                                <Select
                                    labelId="itemsfilter-label"
                                    id="itemsfilter"
                                    value={itemsfilter}
                                    label="ItemsFilter"
                                    onChange={handleItemsFilterChange}
                                    IconComponent={itemfilterimg}
                                >
                                    <MenuItem key={0} value={0}>Items Sold</MenuItem>
                                    <MenuItem key={1} value={1}>Items Cancelled</MenuItem>
                                    <MenuItem key={2} value={2}>Most Sold Items</MenuItem>
                                    <MenuItem key={3} value={3}>Least Sold Items</MenuItem>
                                </Select>
                            </FormControl>
                        }



                        <FormControl id="filtercard-datefilter" variant="standard" sx={{ m: 1, minWidth: 100 }}>
                            <Select
                                labelId="datetimefilter-label"
                                id="datetimefilter"
                                value={datefilter.value}
                                label="DateFilter"
                                onChange={handleDateFilterChange}
                                IconComponent={dtfilterimg}
                            >
                                {
                                    _.keys(datefilterobj).map((filterkey) => {
                                        return (
                                            <MenuItem key={filterkey} value={filterkey}>{datefilterobj[filterkey]}</MenuItem>
                                        )
                                    })
                                }
                            </Select>
                        </FormControl>
                    </div>

                    <div className={datefilter.rangeclsname} id="filtercard-div-cldiv">

                        <Modal
                            open={open}
                            onClose={handleClose}
                            aria-labelledby="modal-modal-title"
                            aria-describedby="modal-modal-description"
                        >

                            <Box sx={modalboxstyle}>
                                <img src={Mclose} onClick={handleClose} className="modalclosebtn-daterange" />
                                <Grid container style={{ padding: "0px 0px 0px 15px" }}>
                                    <FormControl className="daterangepicker-div">
                                        <DateRangePicker placement="bottomStart" id="daterangepicker" format='dd-MM-yyyy' placeholder="Select Date Range" onOk={handleDateRangeFilterChange} showOneCalendar />
                                    </FormControl>
                                </Grid>
                            </Box>
                        </Modal>

                    </div>

                </CardContent>

                <CardActions>
                </CardActions>
            </Card>
            <Card className="slideinbottom" id="Pfooter" sx={{}}>
                <CardContent>
                    <Grid container style={{ padding: "15px 15px 0px 15px" }}>
                        <Grid item xs={6}>
                            <Button onClick={handlePageFilterChange} value={0} className={srvviewclsname} id="Pbtnsalesview" variant="text"><img src={srvviewimg} className="Pbtnview-img" />Sales</Button>
                        </Grid>
                        <Grid item xs={6}>

                            <Button onClick={handlePageFilterChange} value={1} className={itemviewclsname} id="Pbtnitemsview" variant="text"><img src={itemviewimg} className="Pbtnview-img" />Items</Button>
                        </Grid>
                    </Grid>
                </CardContent>
                <CardActions>

                </CardActions>
            </Card>
        </div>
    );
}



