import React from "react";
import Box from "@mui/material/Box";
import Grid from "@mui/material/Grid";
import Accordion from "@mui/material/Accordion";
import AccordionSummary from "@mui/material/AccordionSummary";
import AccordionDetails from "@mui/material/AccordionDetails";

import ExpandMoreIcon from "@mui/icons-material/ExpandMore";
import "../main.css";
import $ from "jquery";
import Skeleto from "../Skeleton/Skeletondiv4.js";
import Alert from "@mui/material/Alert";
function formatNum(numb) {
  let num = Number(numb).toLocaleString('en-IN', {
    minimumFractionDigits: 2,
    maximumFractionDigits: 2
});
  return num;
}
const Highbal = ({
  propid,
  propname,
  highbal,
  setHighbal,
  setSearchhighbal,
  searchhighbal,
}) => {
  let baseurl = process.env.REACT_APP_BASE_URL;
  const [setskel, sethowSetskele] = React.useState(1);
  React.useEffect(() => {
    ajaxresult(propid);
  }, []);
  const ajaxresult = (propid) => {
    //  var dates = get_all_duration(+index + 1);
    var today = new Date().toJSON().substring(0, 10);
    $.ajax({
      url: baseurl + "gethbreport",
      type: "post",
      data: {
        propid,
      },
      datatype: "JSON",
      success: function (res) {
        setHighbal(JSON.parse(res).hbreport);
        setSearchhighbal(JSON.parse(res).hbreport);
        sethowSetskele(0);
      },
      error: function () {},
    });
  };

  var guesthighbal = {
    roomguestname: "Guest Name",
    balance: "Balance",
    total: "Total Amount",
    advance: "Advance Collected",
    planname: "Plan",
    checkindate: "Arr Date",
    likelycheckoutdate: "Dep Date",
  };

  return (
    <>
      {setskel ? (
        <div style={{ margin: "10px" }}>
          <Skeleto />
        </div>
      ) : (
        <Box style={{ padding: "10px", marginBottom: "50px" }}>
          <Grid
            container
            item
            xs={12}
            className="daterange-header"
            style={{ marginBottom: "15px" }}
          >
            <Grid item xs={6} className="flex-left">
              <span className="guest-plan">Name</span>
            </Grid>
            <Grid item xs={2} className="flex-right">
              <span className="guest-plan">RoomNo</span>
            </Grid>
            <Grid item xs={4} className="flex-right">
              <span className="guest-highbalance">Amount</span>
            </Grid>
          </Grid>
          {searchhighbal && searchhighbal.length > 0 ? (
            searchhighbal.map((val, key) => {
              var count = 0;
              return (
                <div key={key}>
                  <Accordion key={key} style={{ marginBottom: "10px" }}>
                    <AccordionSummary
                      expandIcon={<ExpandMoreIcon />}
                      aria-controls="panel1a-content"
                      id="panel1a-header"
                    >
                      <Grid container key={key}>
                        <Grid item xs={12}>
                          <Grid
                            container
                            item
                            xs={12}
                            style={{ minHeight: "50%" }}
                          >
                            <Grid item xs={6} className="flex-left">
                              <span className="guest-name">
                                {val["roomguestname"]}
                              </span>
                            </Grid>
                            <Grid item xs={2} className="flex-right">
                              <span className="guest-plan">
                                {val["roomno"]}
                              </span>
                            </Grid>
                            <Grid item xs={4} className="flex-right">
                              <span className="guest-highbalance">
                                &#8377;
                                {formatNum(Number(val["total"]).toFixed(2))}
                              </span>
                            </Grid>
                          </Grid>
                        </Grid>
                      </Grid>
                    </AccordionSummary>
                    <AccordionDetails>
                      {Object.keys(guesthighbal).map((key) => {
                        count++;
                        var border = "1px solid #ede4e4";
                        if (count == 7) {
                          border = "1px solid #fff";
                        }
                        return (
                          <Grid container key={key}>
                            <Grid
                              item
                              xs={6}
                              style={{
                                borderBottom: border,
                                padding: "5px 5px",
                              }}
                            >
                              <span
                                className="guest-plan"
                                style={{ float: "left" }}
                              >
                                {guesthighbal[key]}
                              </span>
                            </Grid>
                            <Grid
                              item
                              xs={6}
                              style={{
                                borderBottom: border,
                                padding: "5px 4px",
                              }}
                            >
                              <span
                                className="guest-plan"
                                style={{ float: "left", marginRight: "24px" }}
                              >
                                {val[key]}
                              </span>
                            </Grid>
                          </Grid>
                        );
                      })}
                    </AccordionDetails>
                  </Accordion>
                </div>
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

export default Highbal;
