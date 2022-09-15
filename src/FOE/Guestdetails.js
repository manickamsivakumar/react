import React from "react";
import Box from "@mui/material/Box";
import Grid from "@mui/material/Grid";
import "../main.css";
import $ from "jquery";
import FloatBtn from "./Floatingbtn.js";
import Backdrop from '@mui/material/Backdrop';
import CircularProgress from '@mui/material/CircularProgress';

function formatNum(numb) {
  let num = Number(numb).toLocaleString('en-IN', {
    minimumFractionDigits: 2,
    maximumFractionDigits: 2
});
  return num;
}

const Guestdetails = ({ propid, trnid, sts }) => {
  const [open, setOpen] = React.useState(false);
  const handleClose = () => {
    setOpen(false);
  };
  const handleToggle = () => {
    setOpen(!open);
  };
  const [guestdata, setGuestdata] = React.useState({});
  React.useEffect(() => {
    ajaxresult(propid, trnid);
  }, []);
  const ajaxresult = (propid, trnid) => {
    $.ajax({
      url: "https://dev.skyhms.in/mob_mis_v2/indivguest",
      type: "post",
      data: {
        propid,
        trnid,
      },
      datatype: "JSON",
      beforeSend:function(){
        setOpen(true)
      },
      success: function (res) {
        setGuestdata(JSON.parse(res));
      },
      complete:function(){
setOpen(false);
      },
      error: function () {},
    });
  };

  var checkininfo = {
    in_date: "Checkin",
    like_out_date: "Expected Check-Out",
    checkin_user: "Check-In User",
    dayscount: "No.of days",
    pax: "Pax Count",
  };
  var roominfo = {
    roomtypename: "Room Type",
    planname: "Rate Plan",
    netrate: "Net Rate",
    disct: "Discount",
  };
  var guestName =
    guestdata && guestdata.guest && guestdata.guest.chkio
      ? guestdata.guest.chkio[0]["roomguestname"]
      : "";
  var RoomNo =
    guestdata && guestdata.guest && guestdata.guest.chkio
      ? guestdata.guest.chkio[0]["roomno"]
      : "";
  var arrivalMode =
    guestdata && guestdata.guest && guestdata.guest.chkio
      ? guestdata.guest.chkio[0]["arrivalmode"]
      : "";
  var grandtotal = 0;
  var cashtotal = 0;
  var cardbanktotal = 0;
  var credittotal = 0;
  if (sts == 0) {
    if (
      guestdata &&
      guestdata.guest &&
      guestdata.guest["advance"] &&
      guestdata.guest["advance"].length > 0
    ) {
      cashtotal =
        Number(guestdata.guest["advance"][0]["AdvanceCash"]) +
        Number(guestdata.guest["advance"][0]["SettleCash"]);
      cardbanktotal =
        Number(guestdata.guest["advance"][0]["AdvanceCard"]) +
        Number(guestdata.guest["advance"][0]["AdvanceBank"]) +
        Number(guestdata.guest["advance"][0]["SettleCard"]) +
        Number(guestdata.guest["advance"][0]["SettleBank"]);
      credittotal =
        Number(guestdata.guest["advance"][0]["credit"]) +
        Number(guestdata.guest["advance"][0]["SettleCredit"]);
    }
  }
  return (
    <Box style={{ padding: "10px", marginBottom: "50px" }}>
            <Backdrop className='backdrop-spinner'
        sx={{ color: '#028cf3', zIndex: (theme) => theme.zIndex.drawer + 1 }}
        open={open}
        
      >
        <CircularProgress color="inherit" />
      </Backdrop>

      <div className="guest-box">
        <div className="guest-info">
          <Grid container>
            <Grid item xs={12} className="guest-info-title">
              <span className="guest-info-text">Guest Info</span>
            </Grid>
          </Grid>
          <Grid container style={{ padding: "10px" }}>
            <Grid
              item
              xs={12}
              style={{ padding: "7px 0px", borderBottom: "1px solid #007fffa6" }}
            >
              <span
                className="guest-info-common-text"
                style={{ float: "left" }}
              >
                Name:{guestName}
              </span>
            </Grid>
            <Grid
              item
              xs={6}
              style={{ padding: "7px 0px", borderBottom: "1px solid #007fffa6" }}
            >
              <span className="guest-info-common-text">Room No: {RoomNo}</span>
            </Grid>
            <Grid
              item
              xs={6}
              style={{ padding: "7px 0px", borderBottom: "1px solid #007fffa6" }}
            >
              <span
                style={{ float: "left" }}
                className="guest-info-common-text"
              >
                {arrivalMode}
              </span>
            </Grid>
          </Grid>
        </div>
        <div className="check-in-info" style={{ marginBottom: "10px" }}>
          <Grid container>
            <Grid item xs={12} className="check-in-info-title">
              <span className="check-in-info-text">checkIn Info</span>
            </Grid>
          </Grid>
          {guestdata && guestdata.guest && guestdata.guest.chkio
            ? Object.keys(checkininfo).map((key) => {
                return (
                  <Grid
                    key={key}
                    container
                    style={{ minHeight: "35px", padding: "0px 15px" }}
                  >
                    <Grid
                      item
                      xs={6}
                      style={{
                        padding: "7px 0px",
                        borderBottom: "1px solid #007fffa6",
                      }}
                    >
                      <span className="check-in-info-common-text">
                        {checkininfo[key]}
                      </span>
                    </Grid>
                    <Grid
                      item
                      xs={6}
                      style={{
                        padding: "7px 0px",
                        borderBottom: "1px solid #007fffa6",
                      }}
                    >
                      <span
                        style={{ float: "left" }}
                        className="check-in-info-common-text"
                      >
                        {guestdata.guest.chkio[0][key]}
                      </span>
                    </Grid>
                  </Grid>
                );
              })
            : ""}
        </div>
        <div className="room-in-info" style={{ marginBottom: "10px" }}>
          <Grid container>
            <Grid item xs={12} className="check-in-info-title">
              <span className="check-in-info-text">Room Info</span>
            </Grid>
          </Grid>
          {guestdata && guestdata.guest && guestdata.guest.chkio
            ? Object.keys(roominfo).map((key) => {
                return (
                  <Grid
                    key={key}
                    container
                    style={{ minHeight: "35px", padding: "0px 15px" }}
                  >
                    <Grid
                      item
                      xs={6}
                      style={{
                        padding: "7px 0px",
                        borderBottom: "1px solid #007fffa6",
                      }}
                    >
                      <span className="check-in-info-common-text">
                        {roominfo[key]}
                      </span>
                    </Grid>
                    <Grid
                      item
                      xs={6}
                      style={{
                        padding: "7px 0px",
                        borderBottom: "1px solid #007fffa6",
                      }}
                    >
                      <span
                        style={{ float: "left" }}
                        className="check-in-info-common-text"
                      >
                        {guestdata.guest.chkio[0][key]}
                      </span>
                    </Grid>
                  </Grid>
                );
              })
            : ""}
        </div>
        {guestdata &&
        guestdata.guest &&
        guestdata.guest.rent &&
        guestdata.guest.rent.length > 0 ? (
          <>
            <div className="charges-info">
              <Grid container>
                <Grid item xs={12} className="check-in-info-title">
                  <span className="check-in-info-text">Charges Info</span>
                </Grid>
              </Grid>
              {guestdata && guestdata.guest && guestdata.guest.rent ? (
                Object.keys(guestdata.guest.rent).map((key) => {
                  grandtotal += +guestdata.guest.rent[key]["charges"];
                  return (
                    <Grid
                      key={key}
                      container
                      style={{ minHeight: "35px", padding: "0px 15px" }}
                    >
                      <Grid
                        item
                        xs={6}
                        style={{
                          padding: "7px 0px",
                          borderBottom: "1px solid #007fffa6",
                        }}
                      >
                        <span className="check-in-info-common-text">
                          {guestdata.guest.rent[key]["chargename"]}
                        </span>
                      </Grid>
                      <Grid
                        item
                        xs={6}
                        style={{
                          padding: "7px 0px",
                          borderBottom: "1px solid #007fffa6",
                        }}
                      >
                        <span
                          style={{ float: "right" }}
                          className="check-in-info-common-text"
                        >
                          {formatNum(guestdata.guest.rent[key]["charges"])}
                        </span>
                      </Grid>
                    </Grid>
                  );
                })
              ) : (
                <span>No Charges Posted</span>
              )}
            </div>
            <div
              className="total"
              style={{ marginBottom: "10px", padding: "5px 15px" }}
            >
              <Grid container>
                <Grid item xs={8}>
                  <span className="receiveamount-label">
                    {sts == 1 ? "Receivable Amount" : "Total Bill Amount"}
                  </span>
                </Grid>
                <Grid item xs={4}>
                  <span
                    className="receiveamount-number"
                    style={{ float: "right" }}
                  >
                    {grandtotal.toFixed(2)}
                  </span>
                </Grid>
              </Grid>
            </div>
          </>
        ) : (
          ""
        )}
        {sts == 0 &&
        guestdata &&
        guestdata.guest &&
        guestdata.guest.advance &&
        guestdata.guest.advance.length > 0 ? (
          <>
            <div className="charges-info">
              <Grid container style={{ padding: "0px 10px", borderRadius:'5px'  }}>
                <Grid item xs={4} className="collection-in-info-title">
                  <span
                    className="collection-in-info-text"
                    style={{ float: "left", paddingLeft: "10px" }}
                  >
                    Collection
                  </span>
                </Grid>
                <Grid item xs={2} className="collection-in-info-title">
                  <span className="collection-in-info-text">Cash</span>
                </Grid>
                <Grid item xs={4} className="collection-in-info-title">
                  <span className="collection-in-info-text">Card/Bank</span>
                </Grid>
                <Grid item xs={2} className="collection-in-info-title">
                  <span className="collection-in-info-text">Credit</span>
                </Grid>
              </Grid>
              {guestdata &&
              guestdata.guest &&
              guestdata.guest.advance &&
              guestdata.guest.advance.length > 0 ? (
                <>
                  <Grid
                    container
                    style={{ minHeight: "35px", padding: "0px 15px" }}
                  >
                    <Grid
                      item
                      xs={4}
                      style={{
                        padding: "7px 0px",
                        borderBottom: "1px solid #007fffa6",
                      }}
                    >
                      <span className="check-in-info-common-text">Advance</span>
                    </Grid>
                    <Grid
                      item
                      xs={2}
                      style={{
                        padding: "7px 0px",
                        borderBottom: "1px solid #007fffa6",
                      }}
                    >
                      <span className="collection-in-info-common-text">
                        {Number(
                          guestdata.guest.advance[0]["AdvanceCash"]
                        ).toFixed(0)}
                      </span>
                    </Grid>
                    <Grid
                      item
                      xs={4}
                      style={{
                        padding: "7px 0px",
                        borderBottom: "1px solid #007fffa6",
                      }}
                    >
                      <span
                        style={{ float: "right" }}
                        className="collection-in-info-common-text"
                      >
                        {(
                          Number(guestdata.guest.advance[0]["AdvanceBank"]) +
                          Number(guestdata.guest.advance[0]["AdvanceCard"])
                        ).toFixed(0)}
                      </span>
                    </Grid>
                    <Grid
                      item
                      xs={2}
                      style={{
                        padding: "7px 0px",
                        borderBottom: "1px solid #007fffa6",
                      }}
                    >
                      <span className="collection-in-info-common-text">
                        {Number(guestdata.guest.advance[0]["credit"]).toFixed(
                          0
                        )}
                      </span>
                    </Grid>
                  </Grid>
                  <Grid
                    container
                    style={{ minHeight: "35px", padding: "0px 15px" }}
                  >
                    <Grid
                      item
                      xs={4}
                      style={{
                        padding: "7px 0px",
                        borderBottom: "1px solid #007fffa6",
                      }}
                    >
                      <span className="check-in-info-common-text">
                        Bill Settle
                      </span>
                    </Grid>
                    <Grid
                      item
                      xs={2}
                      style={{
                        padding: "7px 0px",
                        borderBottom: "1px solid #007fffa6",
                      }}
                    >
                      <span className="collection-in-info-common-text">
                        {Number(
                          guestdata.guest.advance[0]["SettleCash"]
                        ).toFixed(0)}
                      </span>
                    </Grid>
                    <Grid
                      item
                      xs={4}
                      style={{
                        padding: "7px 0px",
                        borderBottom: "1px solid #007fffa6",
                      }}
                    >
                      <span
                        style={{ float: "right" }}
                        className="collection-in-info-common-text"
                      >
                        {(
                          Number(guestdata.guest.advance[0]["SettleBank"]) +
                          Number(guestdata.guest.advance[0]["SettleCard"])
                        ).toFixed(0)}
                      </span>
                    </Grid>
                    <Grid
                      item
                      xs={2}
                      style={{
                        padding: "7px 0px",
                        borderBottom: "1px solid #007fffa6",
                      }}
                    >
                      <span className="collection-in-info-common-text">
                        {Number(
                          guestdata.guest.advance[0]["SettleCredit"]
                        ).toFixed(0)}
                      </span>
                    </Grid>
                  </Grid>
                </>
              ) : (
                <span>No Charges Posted</span>
              )}
            </div>
            <div
              className="total"
              style={{ marginBottom: "10px", padding: "5px 15px" }}
            >
              <Grid container>
                <Grid item xs={4}>
                  <span className="settleamount-label">Amount</span>
                </Grid>
                <Grid item xs={2}>
                  <span
                    className="settleamount-number"
                    style={{ float: "right" }}
                  >
                    {cashtotal.toFixed(0)}
                  </span>
                </Grid>
                <Grid item xs={4}>
                  <span
                    className="receiveamount-number"
                    style={{ float: "right" }}
                  >
                    {cardbanktotal.toFixed(0)}
                  </span>
                </Grid>
                <Grid item xs={2}>
                  <span
                    className="receiveamount-number"
                    style={{ float: "right" }}
                  >
                    {credittotal.toFixed(0)}
                  </span>
                </Grid>
              </Grid>
            </div>
          </>
        ) : (
          ""
        )}
      </div>
      {sts === 1 ? (
        <FloatBtn guestdata={guestdata} propid={propid} trnid={trnid} />
      ) : (
        ""
      )}
    </Box>
  );
};

export default Guestdetails;
