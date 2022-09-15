import React, { Component, useContext } from 'react'
import _ from 'underscore';
import Header from '../Header.js'
import Pfiltercard from './Pfiltercard.js'
import Possalecard from './Possalecard.js'
import Positemcard from './Positemcard.js'
import Box from "@mui/material/Box";
import Grid from "@mui/material/Grid";
import Calender from "./calendar.svg";


import { DateTime } from 'luxon';

import { PareasrvsettleContext } from './contexts/PareasrvsettleContext';

class Possalesview extends React.Component {

    static contextType = PareasrvsettleContext;

    constructor(props) {
        super(props)
    }

    // if(!this.props.propid){
    //     this.props.propid = 13
    // }

    state = {
        //fromdate: this.gettodaysdate(),
        fromdate: this.gettodaysdate(),
        todate: this.gettodaysdate(),
        areaid: '',
        propid: this.props.propid,
        cmpid: this.props.cmpid,
        viewmode: 'posareasrvsettlevalues',
        firsttime: 0
    }

    gettodaysdate() {
        return DateTime.now().setZone('Asia/Kolkata').toSQL().split(' ')[0];
    }

    componentDidMount() {
        // function calls one time when it is rendered for the first time
        // Good place for data loading
        //console.log('componentDidMount');

        var stateval = this.state;
        var firsttime = this.state.firsttime;
        //console.log(firsttime);
        if (firsttime == 0) {
            var contextobj = {
                'fromdate': stateval.fromdate,
                'todate': stateval.todate,
                'areaid': stateval.areaid,
                'propid': stateval.propid,
                'cmpid': stateval.cmpid,
                'viewmode': 'posareasrvsettlevalues'
            }

            this.context.changecontext(contextobj);
        }

    }

    changeviewmode = (contextobj = 0) => {
        //console.log(contextobj)
        if (contextobj) {
            // this.setState({
            //     fromdate: contextobj.fromdate,
            //     todate: contextobj.todate,
            //     areaid: contextobj.areaid,
            //     propid: contextobj.propid,
            //     cmpid: contextobj.cmpid,
            //     viewmode: contextobj.viewmode,
            //     firsttime: 1
            // });
            this.context.changecontext(contextobj);
        }
    }

    changefooterviewmode = (viewmode) => {
        //console.log(viewmode)
        if (viewmode) {
            var contextobj = this.state;
            // this.setState({
            //     fromdate: contextobj.fromdate,
            //     todate: contextobj.todate,
            //     areaid: contextobj.areaid,
            //     propid: contextobj.propid,
            //     cmpid: contextobj.cmpid,
            //     viewmode: viewmode,
            //     firsttime: 1
            // });
            //contextobj.viewmode = viewmode;
            //this.context.changecontext(contextobj);
        }
    }



    componentDidUpdate() {
        // function called when the state is updated or changd
        // Good place todo more data loading when state and props change
        //console.log('componentDidUpdate');
        //this.context.changecontext(this.state);
    }

    componentWillUnmount() {
        // function called when component disapppers
        // Good place todo clean up
        //console.log('componentWillUnmount');
    }

    getinitdetails(contextval) {
        //console.log(contextval);
    }

    render() {
        //console.log(this.context.posvalues);

        var contextval = this.context.posvalues;




        if (_.keys(contextval).length) {
            //console.log(contextval);
            var contextdetails = contextval.details;
            var contextvalues = contextval.values;
            var viewmode = contextdetails.postdetails.viewmode;
            var viewmodeid = (viewmode == 'posareasrvsettlevalues') ? 0 : 1;
            //var propdetails = contextval.details.propdetails;
            var areaids = contextdetails.postdetails.areaid;
            areaids = (areaids) ? areaids.split(',') : [];
            function Get_propdetails(propdetails) {
                this.propname = propdetails.propname;
                this.propcity = propdetails.propcity;
                this.makeurl = function () {
                    if (1) {
                        return this.propname + '?key=' + this.propcity;
                    } else {
                        return "";
                    }

                }
            }

            //console.log(contextdetails);
            //console.log(contextvalues)

            if (contextdetails && contextvalues) {
                var propdetails = new Get_propdetails(contextdetails.propdetails);
                var areadetails = contextdetails.areadetails;
                var areavalues = 0;
                var postdetails = contextdetails.postdetails;
                if (viewmodeid == 0) {
                    var datetimevalues = contextval.datetimevalues;
                    _.each(areadetails, function (areaname, areaid) {
                        if (!_.keys(datetimevalues).includes(areaid)) {
                            datetimevalues[areaid] = 0;
                        }
                    });
                }
                if (viewmodeid == 1) {
                    areavalues = contextdetails.areavalues;
                }
                areadetails = _.mapObject(areadetails, function (areaname, key) {
                    return areaname.charAt(0).toUpperCase() + areaname.slice(1).toLowerCase();
                });
                var marginbottomval = "-15px";
                var key = 0;
                if (_.keys(areadetails).length < 2) {
                    marginbottomval = "-15px";
                };

                //console.log(postdetails);

                function Daterangespan(fromdate, todate) {
                    this.fromdate = fromdate;
                    this.todate = todate;
                    this.makespan = DateTime.fromISO(this.fromdate).toLocaleString(DateTime.DATE_MED_WITH_WEEKDAY) + ' to ' + DateTime.fromISO(this.todate).toLocaleString(DateTime.DATE_MED_WITH_WEEKDAY);
                }

                var dtrspan = new Daterangespan(postdetails.fromdate, postdetails.todate);

                //console.log(dtrspan);
                var backurl = '/';
                return (
                    <div>
                        <Header propname={propdetails} backurl={backurl} showfilter={false} />
                        <Pfiltercard viewmodeid={viewmodeid} changeviewmode={this.changeviewmode} propcmpdetails={{ propid: postdetails.propid, cmpid: postdetails.cmpid }} arealist={areadetails}></Pfiltercard>


                        <Grid
                            container
                            item
                            xs={12}
                            className="daterange-header"
                            style={{ width: "95%", marginTop: '7px', marginLeft: '10px', marginBottom: "-5px" }}
                        >
                            <div>
                                <img height="25" width="25" src={Calender} alt="calender" />
                                <span
                                    className="hotel-header-title1"
                                    style={{ textAlign: "center", marginLeft: "10px" }}
                                >
                                    {dtrspan.makespan}
                                </span>
                            </div>
                        </Grid>

                        {
                            (viewmodeid == 0) ?
                                _.keys(areadetails).map((areaid) => {
                                    key = key + 1;
                                    marginbottomval = (key == _.keys(areadetails).length) ? "45px" : "-15px";

                                    //console.log(contextvalues[areaid]);
                                    //console.log(_.keys(areadetails).length);
                                    //console.log(areaids);
                                    //console.log(areaid);

                                    if (areaids.length == 0) {
                                        return (
                                            <Possalecard marginbottomval={marginbottomval} datetimevalue={datetimevalues[areaid]} key={areaid} cardvalue={contextvalues[areaid]} areadetail={{ areaid: areaid, areaname: areadetails[areaid] }} contextval={contextval} />
                                        )
                                    } else {
                                        if (areaids[0] == areaid || (areaids.length > 1) || areaids[0] == 0) {
                                            return (
                                                <Possalecard marginbottomval={marginbottomval} datetimevalue={datetimevalues[areaid]} key={areaid} cardvalue={contextvalues[areaid]} areadetail={{ areaid: areaid, areaname: areadetails[areaid] }} contextval={contextval} />
                                            )
                                        }
                                    }



                                })
                                :
                                _.keys(areadetails).map((areaid) => {

                                    var areavalue = _.keys(areavalues).includes(areaid) ? areavalues[areaid] : 0;
                                    key = key + 1;
                                    marginbottomval = (key == _.keys(areadetails).length) ? "45px" : "-15px";
                                    var boxstyle = {
                                        padding: "12px",
                                        marginBottom: marginbottomval
                                    }
                                    if (areaids.length == 0) {
                                        return (
                                            <Box key={areaid} style={boxstyle}>
                                                <Box className="pos-revenue-section-pos pos-itemcard">
                                                    <Positemcard className='positemcard' contextval={contextval} propcmpdetails={{ propid: postdetails.propid, cmpid: postdetails.cmpid }} areavalue={areavalue} areadetail={{ areaid: areaid, areaname: areadetails[areaid] }}></Positemcard>
                                                </Box>
                                            </Box>
                                        )
                                    }
                                    else {
                                        if (areaids[0] == areaid || (areaids.length > 1) || areaids[0] == 0) {
                                            return (
                                                <Box key={areaid} style={boxstyle}>
                                                    <Box className="pos-revenue-section-pos pos-itemcard">
                                                        <Positemcard className='positemcard' contextval={contextval} propcmpdetails={{ propid: postdetails.propid, cmpid: postdetails.cmpid }} areavalue={areavalue} areadetail={{ areaid: areaid, areaname: areadetails[areaid] }}></Positemcard>
                                                    </Box>
                                                </Box>
                                            )
                                        }
                                    }
                                })
                        }
                    </div >
                )
            } else {
                return (<div></div>)
            }
        }
        else {
            return (<div></div>)
        }
    }
}

//(event)=> this.setState({ inpval: event.nativeEvent.target._valueTracker.getValue() })

export default Possalesview;