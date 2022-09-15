import React from "react";
import Box from "@mui/material/Box";
import Grid from "@mui/material/Grid";
import "../main.css";
import $ from "jquery";
import { Link } from "react-router-dom";
import Alert from "@mui/material/Alert";
const Checkinlist = ({ propid, propname, apiurl }) => {
  let baseurl = process.env.REACT_APP_BASE_URL;
  const [checkinlist, setCheckinlist] = React.useState({});
  React.useEffect(() => {
    ajaxresult(propid);
  }, []);
  const ajaxresult = (propid) => {
    //  var dates = get_all_duration(+index + 1);
    var today = new Date().toJSON().substring(0, 10);
    $.ajax({
      url: baseurl + apiurl,
      type: "post",
      data: {
        propid,
        today,
      },
      datatype: "JSON",
      success: function (res) {
        setCheckinlist(JSON.parse(res));
      },
      error: function () {},
    });
  };

  var sts = 0;
  var backurl = "checkout";
  if (apiurl == "getcheckin") {
    sts = 1;
    backurl = "checkin";
  }
  function wraptext(text, maxlen) {
    var str = text;
    if (text.length > maxlen) {
      str = text.substring(0, maxlen) + "...";
    }
    return str;
  }
  return (
    <Box style={{ padding: "10px", marginBottom: "50px" }}>
      {checkinlist &&
      checkinlist.occupancy &&
      checkinlist.occupancy.length > 0 ? (
        checkinlist["occupancy"].map((val, key) => {
          console.log(val);
          var noted = "";
          if (
            val.hasOwnProperty("chkincancelst") &&
            +val["chkincancelst"] == 1
          ) {
            noted = "-CANCELLED";
          }
          return (
            <Link
              to="/indivguest"
              key={key}
              style={{ textDecoration: "none" }}
              state={{
                ...propname,
                propid: propid,
                trnid: val["checkinroomtrnid"],
                sts: sts,

                backurl: `/${backurl}`,
              }}
            >
              <Grid container>
                <Grid
                  item
                  xs={12}
                  className="chkin-list-box"
                  style={{ padding: "15px", marginBottom: "10px" }}
                >
                  <Grid container item xs={12} style={{ minHeight: "50%" }}>
                    <Grid item xs={6}>
                      <span className="guest-name">
                        {wraptext(val["roomguestname"], 15)}
                      </span>
                    </Grid>
                    <Grid item xs={6}>
                      <span className="guest-plan">{val["planname"]}</span>
                    </Grid>
                  </Grid>
                  <Grid container item xs={12} style={{ height: "50%" }}>
                    <Grid item xs={6}>
                      <span className="guest-roomno">
                        {`${val["roomno"]}${noted}`}
                      </span>
                    </Grid>
                    <Grid item xs={6}>
                      <span className="guest-arrivalmode">
                        {wraptext(val["arrivalmode"], 15)}
                      </span>
                    </Grid>
                  </Grid>
                </Grid>
              </Grid>
            </Link>
          );
        })
      ) : (
        <>
          <Alert
            severity="warning"
            color="info"
            className="alert_div"
            style={{ backgroundColor: "#e5f6fd !important" }}
          >
            No Results Found!
          </Alert>
        </>
      )}
    </Box>
  );
};

export default Checkinlist;
