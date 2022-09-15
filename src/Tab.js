import React from "react";
import PropTypes from "prop-types";
import Tabs from "@mui/material/Tabs";
import Tab from "@mui/material/Tab";
import Typography from "@mui/material/Typography";
import Box from "@mui/material/Box";
import Grid from "@mui/material/Grid";
import "./main.css";
import $ from "jquery";
import Hotel from "./Hotel.js";
import Hotelgrap from "./Hotelgrap.js";
import SwipeableViews from "react-swipeable-views";
import Menu from "./Menu.js";
import moment from "moment";
import { useTheme } from "@mui/material/styles";
import Dash from "./Frontview.js";
import Skeletondiv from "./Skeleton/Skeletondiv.js";
import { DateTime } from "luxon";
import Calender from "./images/calendar.svg";
function TabPanel(props) {
  const { children, value, index, ...other } = props;

  return (
    <div
      role="tabpanel"
      hidden={value !== index}
      id={`simple-tabpanel-${index}`}
      aria-labelledby={`simple-tab-${index}`}
      {...other}
    >
      {value === index && (
        <Box sx={{ p: 3 }}>
          <Typography component={"span"}>{children}</Typography>
        </Box>
      )}
    </div>
  );
}

TabPanel.propTypes = {
  children: PropTypes.node,
  index: PropTypes.number.isRequired,
  value: PropTypes.number.isRequired,
};

function a11yProps(index) {
  return {
    id: `simple-tab-${index}`,
    "aria-controls": `simple-tabpanel-${index}`,
  };
}

export default function BasicTabs({
  selectedIndex,
  setSelectedIndex,
  setValue,
  value,
  setUserdtls,
  userdtls
}) {
  //console.warn(selectedIndex, "tab");
  const theme = useTheme();
  const transitionDuration = {
    enter: theme.transitions.duration.enteringScreen,
    exit: theme.transitions.duration.leavingScreen,
  };

  const [tabvalue, tabsetValue] = React.useState(0);
  const [filterdata, setFilterdata] = React.useState({});
  const [groupflag, setGroupbyflag] = React.useState(0);
  const [diffday, setDiffday] = React.useState(1);
  const [showskeleton, setShowskeleton] = React.useState(1);
  const handleChange = (event, newValue) => {
    tabsetValue(newValue);
  };
  const handleChangeIndex = (index) => {
    tabsetValue(index);
  };
  React.useLayoutEffect(() => {}, [selectedIndex]);
  //console.log(diffday, "sdvdffgghfg");
  React.useEffect(() => {
    // console.log(diffday, "insideuseeffect");
    let ajaxdata = Ajaxresult(selectedIndex);
  }, [selectedIndex]);
  //console.log(diffday, "diff");

  const Ajaxresult = (index) => {
    var fromdate = index.fromdates;
    var todate = index.todates;
    var diff = getdiffernce(selectedIndex.fromdates, selectedIndex.todates);

    var groupbyflag = 0;
    if (diff > 31 && diff <= 365) {
      groupbyflag = 1;
    } else if (diff > 365) {
      groupbyflag = 2;
    } else {
      groupbyflag = 0;
    }

    $.ajax({
      url: "https://dev.skyhms.in/mob_mis_v2/filters",
      type: "post",
      data: {
        fromdate,
        todate,
        groupbyflag,
        value
      },
      datatype: "JSON",
      beforesend: function () {},
      success: function (res) {
        setFilterdata(JSON.parse(res));

        setUserdtls(JSON.parse(res).user_details)
        setDiffday(diff);
        setGroupbyflag(groupbyflag);
setShowskeleton(0);
      },
      complete: function () {},
      error: function () {},
    });
  };
  const options = [
    "Today",
    "Last 7 Days",
    "Last 30 Days",
    "Current Month",
    "Last Month",
    "Current Year",
    "Date Range",
  ];
  function getdiffernce(from, to) {
    if (from === to) {
      var differnce = 1;
    } else {
      var differnce = differncedate(from, to) + 1;
    }

    return differnce;
  }
  function differncedate(from, to) {
    var to = moment(to, "YYYY-MM-DD");
    var from = moment(from, "YYYY-MM-DD");
    var diff = to.diff(from, "days");
    return diff;
  }
  console.log(selectedIndex);
  console.log(new Date(selectedIndex.fromdates));
  // var daterangespan =
  //   moment(new Date(selectedIndex.fromdates).toJSON().substring(0, 10)).format(
  //     "MMMM d, YYYY"
  //   ) +
  //   "-" +
  //   moment(selectedIndex.todates).format("MMMM d, YYYY");

  var daterangespan =
    DateTime.fromISO(new Date(selectedIndex.fromdates).toJSON()).toFormat(
      "MMM d, yyyy"
    ) +
    "-" +
    DateTime.fromISO(new Date(selectedIndex.todates).toJSON()).toFormat(
      "MMM d, yyyy"
    );
  return (
    <>
      <Box sx={{ width: "100%" }}>
        <Box
          className="tab-body"
          style={{ display: "flex", justifyContent: "space-between" }}
        >
          <Tabs
            value={tabvalue}
            onChange={handleChange}
            aria-label="basic tabs example"
            className="tab-container"
          >
            <Tab label="Hotel List" {...a11yProps(0)} />
            <Tab label="Analytics" {...a11yProps(1)} />
          </Tabs>
          <div
            style={{
              display: "flex",
              justifyContent: "initial",
              marginRight: "10px",
            }}
          >
            <div style={{ margin: "12px 5px" }}>
              <span className="Filtersection-text">{options[value]}</span>
            </div>
            <Menu
              isdash={false}
              setSelectedIndex={setSelectedIndex}
              setValue={setValue}
            />
          </div>
        </Box>
        <SwipeableViews
          axis={theme.direction === "rtl" ? "x-reverse" : "x"}
          index={tabvalue}
          onChangeIndex={handleChangeIndex}
        >
          <TabPanel value={tabvalue} index={0}>
            <>
              <Grid
                container
                item
                xs={12}
                className="daterange-header"
                style={{ width: "fit-content" }}
              >
                <div>
                  <img height="25" width="25" src={Calender} alt="calender" />
                  <span
                    className="hotel-header-title1"
                    style={{ textAlign: "center", marginLeft: "10px" }}
                  >
                    {daterangespan}
                  </span>
                </div>
              </Grid>

              {Object.keys(filterdata).length > 0 ? (
                Object.keys(filterdata.amount_details).map((fval, fkey) => {
                  //("vbdfvd");
                  //  console.log(fval, "fval");
                  return (
                    <Hotel
                      key={fkey}
                      propid={fval}
                      count={fkey + 1}
                      filterdata={filterdata["amount_details"][fval]}
                      modulelist={filterdata["module_list"][fval]}
                      selectedIndex={selectedIndex}
                      userdtls={userdtls}
                      value={value}
                    />
                  );
                })
              ) : (
                <>
                  <Skeletondiv style={{ marginBottom: "20px" }} />
                  <Skeletondiv />
                </>
              )}
            </>
          </TabPanel>
          <TabPanel value={tabvalue} index={1}>
            <>
              <Grid
                container
                item
                xs={12}
                className="daterange-header"
                style={{ width: "fit-content", marginBottom: "15px" }}
              >
                <div>
                  <img height="25" width="25" src={Calender} alt="calender" />
                  <span
                    className="hotel-header-title1"
                    style={{ textAlign: "center", marginLeft: "10px" }}
                  >
                    {daterangespan}
                  </span>
                </div>
              </Grid>
              <Hotelgrap
                filterdata={filterdata["amount_details"]}
                selectedIndex={selectedIndex}
                modulelist={filterdata["module_list"]}
              />
            </>
          </TabPanel>
        </SwipeableViews>
      </Box>
    </>
  );
}
