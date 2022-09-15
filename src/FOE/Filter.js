import React from "react";
import Box from "@mui/material/Box";
import Grid from "@mui/material/Grid";
import SearchBar from "material-ui-search-bar";
import "../main.css";
import Menu from "../Menu.js";
import Datepicker from "../Datepicker.js";
export default function Filter({
  header,
  setSelectedIndex,
  setValue,
  value,
  showfilter,
  showdate,
  daysettledate,
  setDaysettledate,
  showsearch,
  highbal,
  searchhighbal,
  setSearchhighbal,
  checkinlist,
  setSrchlist,
  fromchkinlist,
}) {
  // console.log(showdate, "showdate");
  const options = [
    "Today",
    "Last 7 Days",
    "Last 30 Days",
    "Current Month",
    "Last Month",
    "Current Year",
    "Date Range",
  ];

  const [searched, setSearched] = React.useState("");

  const requestSearch = (searchedVal) => {
    if (fromchkinlist) {
      if (searchedVal == "") {
        return setSrchlist(checkinlist);
      }
      const filteredItems = checkinlist.filter((value, key) => {
        if (
          value["roomno"].toLowerCase().indexOf(searchedVal.toLowerCase()) >=
            0 ||
          value["arrivalmode"]
            .toLowerCase()
            .indexOf(searchedVal.toLowerCase()) >= 0 ||
          value["roomguestname"]
            .toLowerCase()
            .indexOf(searchedVal.toLowerCase()) >= 0 ||
          value["planname"].toLowerCase().indexOf(searchedVal.toLowerCase()) >=
            0
        ) {
          return value;
        }
      });
      setSrchlist(filteredItems);
    } else {
      if (searchedVal == "") {
        return setSearchhighbal(highbal);
      }
      const filteredItems = highbal.filter((value, key) => {
        if (
          value["roomno"].toLowerCase().indexOf(searchedVal.toLowerCase()) >=
            0 ||
          value["roomguestname"]
            .toLowerCase()
            .indexOf(searchedVal.toLowerCase()) >= 0 ||
          value["balance"].toLowerCase().indexOf(searchedVal.toLowerCase()) >= 0
        ) {
          return value;
        }
      });
      setSearchhighbal(filteredItems);
    }
  };

  const cancelSearch = () => {
    setSearched("");
    requestSearch("");
  };
  return (
    <Box sx={{ width: "100%", height: "56px" }}>
      <Box className="tab-body-filter">
        <Grid container style={{ height: "100%" }}>
          <Grid item xs={6} className="propname-section">
            <p className="propname-section-text">{header}</p>
          </Grid>
          <Grid item xs={6} className="Filtersection">
            {showfilter === true ? (
              <div style={{ display: "flex", justifyContent: "center" }}>
                <div style={{ margin: "7px 0px" }}>
                  <span className="Filtersection-text">{options[value]}</span>
                </div>
                <Menu
                  isdash={false}
                  setSelectedIndex={setSelectedIndex}
                  setValue={setValue}
                />
              </div>
            ) : (
              ""
            )}
            {showdate === true ? (
              <div>
                <Datepicker
                  setDaysettledate={setDaysettledate}
                  daysettledate={daysettledate}
                />
              </div>
            ) : (
              ""
            )}
            {showsearch === true ? (
              <SearchBar
                value={searched}
                onChange={(searchVal) => requestSearch(searchVal)}
                onCancelSearch={() => cancelSearch()}
                className="search-filter"
                placeholder="Search..."
              />
            ) : (
              ""
            )}
          </Grid>
        </Grid>
      </Box>
    </Box>
  );
}
