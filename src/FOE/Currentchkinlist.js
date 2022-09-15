import React from "react";
import Box from "@mui/material/Box";
import Grid from "@mui/material/Grid";
import "../main.css";
import $ from "jquery";
import { Link } from "react-router-dom";
import Skeleto from "../Skeleton/Skeletondiv4.js";
import Alert from "@mui/material/Alert";
const Currentchkinlist = ({
  propid,
  propname,
  srchlist,
  setSrchlist,
  setCheckinlist,
}) => {
  const [showskele, setShowskele] = React.useState(1);
  React.useEffect(() => {
    ajaxresult(propid);
  }, []);
  const ajaxresult = (propid) => {
    //  var dates = get_all_duration(+index + 1);
    var today = new Date().toJSON().substring(0, 10);
    $.ajax({
      url: "https://dev.skyhms.in/mob_mis_v2/getoccupancy",
      type: "post",
      data: {
        propid,
        today,
      },
      datatype: "JSON",
      success: function (res) {
        setCheckinlist(JSON.parse(res).occupancy);
        setSrchlist(JSON.parse(res).occupancy);
        setShowskele(0);
      },
      error: function () {},
    });
  };

  function wraptext(text, maxlen) {
    var str = text;
    if (text.length > maxlen) {
      str = text.substring(0, maxlen) + "...";
    }
    return str;
  }
  return (
    <>
      {showskele ? (
        <div style={{ margin: "10px" }}>
          <Skeleto />
        </div>
      ) : (
        <Box style={{ padding: "10px", marginBottom: "50px" }}>
          {srchlist.length > 0 ? (
            srchlist.map((val, key) => {
              return (
                <Link
                  to="/indivguest"
                  key={key}
                  style={{ textDecoration: "none" }}
                  state={{
                    ...propname,
                    propid: propid,
                    trnid: val["checkinroomtrnid"],
                    sts: 1,
                    backurl: "/currentcheckin",
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
                            {val["roomguestname"]}
                          </span>
                        </Grid>
                        <Grid item xs={6}>
                          <span className="guest-plan">{val["planname"]}</span>
                        </Grid>
                      </Grid>
                      <Grid container item xs={12} style={{ height: "50%" }}>
                        <Grid item xs={6}>
                          <span className="guest-roomno">
                            {+val["chkincmplmtst"] == 1
                              ? `${val["roomno"]} => cmpl`
                              : val["roomno"]}
                          </span>
                        </Grid>
                        <Grid item xs={6}>
                          <span className="guest-arrivalmode">
                            {wraptext(val["arrivalmode"], 12)}
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
      )}
    </>
  );
};

export default Currentchkinlist;
