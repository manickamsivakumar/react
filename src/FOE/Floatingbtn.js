import React from "react";
import Box from "@mui/material/Box";
import Backdrop from "@mui/material/Backdrop";
import SpeedDial from "@mui/material/SpeedDial";
import SpeedDialIcon from "@mui/material/SpeedDialIcon";
import SpeedDialAction from "@mui/material/SpeedDialAction";
import FileCopyIcon from "@mui/icons-material/FileCopyOutlined";
import SaveIcon from "@mui/icons-material/Save";
import PrintIcon from "@mui/icons-material/Print";
import FactCheckIcon from '@mui/icons-material/FactCheck';
import ShareIcon from "@mui/icons-material/Share";
import CloseIcon from '@mui/icons-material/Close';
import CurrencyRupeeIcon from '@mui/icons-material/CurrencyRupee';
import LockClockIcon from '@mui/icons-material/LockClock';
import PercentIcon from '@mui/icons-material/Percent';
import Dialog from "@mui/material/Dialog";
import DialogActions from "@mui/material/DialogActions";
import DialogContent from "@mui/material/DialogContent";
import DialogContentText from "@mui/material/DialogContentText";
import DialogTitle from "@mui/material/DialogTitle";
import TextField from "@mui/material/TextField";
import Slider from "./Rangeslider.js";
import PersonIcon from '@mui/icons-material/Person';
import Button from "@mui/material/Button";
import Grid from "@mui/material/Grid";

import AppBar from "@mui/material/AppBar";
import Toolbar from "@mui/material/Toolbar";
import IconButton from "@mui/material/IconButton";
import Typography from "@mui/material/Typography";
import Slide from "@mui/material/Slide";
import Datagrid from "./Datagrid.js";


import CircularProgress from '@mui/material/CircularProgress';
import $ from "jquery";
const Transition = React.forwardRef(function Transition(props, ref) {
  return <Slide direction="up" ref={ref} {...props} />;
});
const actions = [
  { icon: <CurrencyRupeeIcon />, name: "Allow Credit" },
  { icon: <CloseIcon />, name: "Checkin Cancel" },
  { icon: <PersonIcon />, name: "Complimentary" },
  { icon: <PercentIcon />, name: "Discount" },
  { icon: <LockClockIcon />, name: "Grace time" },
  { icon: <FactCheckIcon />, name: "Manage Charges" },
];
function reducer(state, action) {
  switch (action.type) {
    case "gracetime":
      return { ...state, gracetime: action.val };
      break;
    case "Allow Credit":
      return { ...state, credit: action.val };
      break;
    case "Checkin Cancel":
      // console.log("sdfdfgdffg", 23123);
      return { ...state, cancelchkin: action.val };
      break;
    case "complimentary":
      return { ...state, compl: action.val };
      break;
    case "discount":
      return { ...state, discount: action.val };
      break;
    case "managecharges":
      return { ...state, mancharges: action.val };
      break;
    case "alert":
      return { ...state, alert: action.val };
      break;
  }
}

export default function Floatingbtn({ guestdata, propid, trnid }) {
  const [spinopen, setSpinopen] = React.useState(false);
  const handlespinClose = () => {
    setSpinopen(false);
  };
  const handleToggle = () => {
    setSpinopen(!spinopen);
  };
  const [gt, setGt] = React.useState(0);
  const [discnt, setDiscnt] = React.useState(0);
  const [mncharges, setMncharges] = React.useState([]);
  React.useEffect(() => {
    var gtime =
      guestdata &&
      guestdata.guest &&
      guestdata.guest.chkio &&
      guestdata.guest.chkio[0]["tim"]
        ? Number(guestdata.guest.chkio[0]["tim"].split(":")[0])
        : gt;
    var dperc =
      guestdata &&
      guestdata.guest &&
      guestdata.guest.chkio &&
      guestdata.guest.chkio[0]["rmdiscntmaxprcnt"]
        ? Number(guestdata.guest.chkio[0]["rmdiscntmaxprcnt"].split(":")[0])
        : discnt;
    setGt(gtime);
    setDiscnt(dperc);
  }, [guestdata]);
  const [msg, setMsg] = React.useState("");
  const [state, dispatch] = React.useReducer(reducer, {
    credit: false,
    compl: false,
    gracetime: false,
    cancelchkin: false,
    discount: false,
    mancharges: false,
    alert: false,
  });
  const [open, setOpen] = React.useState(false);
  const handleOpen = () => setOpen(true);
  const handleClose = () => setOpen(false);
  const determinelabel = (name) => {
    //console.log(name);
    switch (name) {
      case "Allow Credit":
        if (
          guestdata.guest &&
          guestdata.guest.chkio &&
          +guestdata.guest.chkio[0]["creditallowst"] === 1
        ) {
          dispatch({ type: "alert", val: true });
          setMsg("Guest Already  in Credit Status!,No Need to Proceed");
          return;
        }
        dispatch({ type: "Allow Credit", val: true });
        setOpen(false);
        break;
      case "Checkin Cancel":
        //  console.log("ghfghdfghgjgjgh");

        dispatch({ type: "Checkin Cancel", val: true });

        setOpen(false);
        break;
      case "Complimentary":
        // console.log("ghfghdfghgjgjgh");
        if (
          guestdata.guest &&
          guestdata.guest.chkio &&
          +guestdata.guest.chkio[0]["chkincmplmtst"] === 1
        ) {
          dispatch({ type: "alert", val: true });
          setMsg("Guest Already  in Complementary!,No Need to Proceed");
          return;
        }
        dispatch({ type: "complimentary", val: true });

        setOpen(false);
        break;
      case "Grace time":
        dispatch({ type: "gracetime", val: true });
        setOpen(false);
        break;
      case "Discount":
        dispatch({ type: "discount", val: true });
        setOpen(false);
        break;
      case "Manage Charges":
        dispatch({ type: "managecharges", val: true });
        setOpen(false);
        break;
    }
  };
  const makeproceed = (name) => {
   // console.log(name,'switch');
    switch (name) {
      case "credit":
        var callurl = process.env.REACT_APP_BASE_URL + "credit_allow";
        var data = {};
        if (Object.keys(guestdata).length > 0) {
          data = {
            guestid: guestdata.guest.chkio[0]["guestid"],
            ledger: guestdata.guest.chkio[0]["ledgerid"],
            trnid: guestdata.guest.chkio[0]["checkinroomtrnid"],
            propid: propid,
            cmpid: 8,
          };
        }
        break;
      case "complimentary":
        var callurl = process.env.REACT_APP_BASE_URL + "allow_chkin_cancel";
        var data = {};
        if (Object.keys(guestdata).length > 0) {
          data = {
            roomid: guestdata.guest.chkio[0]["roomid"],
            reason: document.getElementById("complementary").value,
            trnid: guestdata.guest.chkio[0]["checkinroomtrnid"],
            propid: propid,
            type: 2,
          };
        }
        break;
      case "cancelcheckin":
        var callurl = process.env.REACT_APP_BASE_URL + "allow_chkin_cancel";
        var data = {};
        if (Object.keys(guestdata).length > 0) {
          data = {
            roomid: guestdata.guest.chkio[0]["roomid"],
            reason: document.getElementById("cancelcheckin").value,
            trnid: guestdata.guest.chkio[0]["checkinroomtrnid"],
            propid: propid,
            type: 1,
          };
        }
        break;
      case "gracetime":
        var callurl = process.env.REACT_APP_BASE_URL + "gracetime_discount";
        var data = {};
        if (Object.keys(guestdata).length > 0) {
          data = {
            trnid: guestdata.guest.chkio[0]["checkinroomtrnid"],
            propid: propid,
            dnt: 0,
            prednt: 0.0,
            gt: gt,
            pregt: gt,
            distype: guestdata.guest.chkio[0]["discounttype"],
            amt: 0,
            processmode: "gracetime",
          };
        }
        break;
      case "discount":
        var callurl = process.env.REACT_APP_BASE_URL + "gracetime_discount";
        var data = {};
        if (Object.keys(guestdata).length > 0) {
          data = {
            trnid: guestdata.guest.chkio[0]["checkinroomtrnid"],
            propid: propid,
            dnt: discnt,
            prednt: "",
            gt: guestdata.guest.chkio[0]["tim"].split(":")[0],
            pregt: guestdata.guest.chkio[0]["tim"].split(":")[0],
            distype: guestdata.guest.chkio[0]["discounttype"],
            amt: (+guestdata.guest.chkio[0]["roomrent"] / 100) * Number(discnt),
            processmode: "discount",
          };
        }
        break;
      case "managecharges":
        var callurl = process.env.REACT_APP_BASE_URL + "deletecharges";
        var data = {};
        if (Object.keys(guestdata).length > 0) {
          data = {
            trnid: guestdata.guest.chkio[0]["checkinroomtrnid"],
            propid: propid,
            tav: mncharges,
            charge: guestdata.guest["mncharges"]
              .filter((val) => {
                if (mncharges.includes(val["id"])) {
                  return val;
                }
              })
              .map(function (obj) {
                return obj.chargeid;
              }),
            night: guestdata.guest["mncharges"]
              .filter((val) => {
                if (mncharges.includes(val["id"])) {
                  return val;
                }
              })
              .map(function (obj) {
                return obj.nightaudit;
              }),
            bill: guestdata.guest["mncharges"]
              .filter((val) => {
                if (mncharges.includes(val["id"])) {
                  return val;
                }
              })
              .map(function (obj) {
                return obj.billid;
              }),
            date: guestdata.guest["mncharges"]
              .filter((val) => {
                if (mncharges.includes(val["id"])) {
                  return val;
                }
              })
              .map(function (obj) {
                return obj.chargedate;
              }),
          };
        }
        break;
    }

    $.ajax({
      url: callurl,
      type: "post",
      data: data,
      datatype: "JSON",
      beforeSend: function () {

        setSpinopen(true);
      },
      success: function (resposne) {
        setMsg(JSON.parse(resposne));
        dispatch({ type: "alert", val: true });
        setTimeout(() => {
          window.location.reload();
        }, 1500);
      },
      complete: function () {
        setSpinopen(false);
      },
      error: function () {},
    });
  };

  return (
    <>
            <Backdrop className='backdrop-spinner'
        sx={{ color: '#028cf3', zIndex: (theme) => theme.zIndex.drawer + 1 }}
        open={spinopen}
        
      >
        <CircularProgress color="inherit" />
      </Backdrop>
      <Dialog
        fullScreen
        open={state.mancharges}
        onClose={() => dispatch({ type: "managecharges", val: false })}
        TransitionComponent={Transition}
      >
        <AppBar sx={{ position: "relative" }} className="mangecharges-header">
          <Toolbar>
            <IconButton
              edge="start"
              color="inherit"
              onClick={() => dispatch({ type: "managecharges", val: false })}
              aria-label="close"
            >
              <CloseIcon />
            </IconButton>
            <Typography sx={{ ml: 2, flex: 1 }} variant="h6" component="div">
              Manage Charges
            </Typography>
            <Button
              autoFocus
              color="inherit"
              onClick={() => {
                makeproceed("managecharges");
                dispatch({ type: "managecharges", val: false });
              }}
            >
              Delete
            </Button>
          </Toolbar>
        </AppBar>
        <Grid container item xs={12} style={{ padding: "10px" }}>
          <Datagrid
            propid={propid}
            trnid={trnid}
            managecharges={
              guestdata && guestdata.guest && guestdata.guest["mncharges"]
                ? guestdata.guest["mncharges"]
                : {}
            }
            setMncharges={setMncharges}
          />
        </Grid>
      </Dialog>
      <Dialog
        open={state.discount}
        
        fullWidth={true}
      >
        <DialogTitle>Discount</DialogTitle>
        <DialogContent>
          <DialogContentText>
            Room No:
            {guestdata.guest &&
            guestdata.guest.chkio &&
            guestdata.guest.chkio[0]["roomno"]
              ? guestdata.guest.chkio[0]["roomno"]
              : ""}
          </DialogContentText>
          <Slider
            maxval="100"
            type="discnt"
            discnt={discnt}
            setDiscnt={setDiscnt}
          />
        </DialogContent>
        <DialogActions>
          <Button onClick={() => dispatch({ type: "discount", val: false })}>
            Cancel
          </Button>
          <Button
            onClick={() => {
              makeproceed("discount");
              dispatch({ type: "discount", val: false });
            }}
          >
            Proceed
          </Button>
        </DialogActions>
      </Dialog>
      <Dialog
        open={state.gracetime}
        
        fullWidth={true}
      >
        <DialogTitle>Grace Time</DialogTitle>
        <DialogContent>
          <DialogContentText>
            Room No:
            {guestdata.guest &&
            guestdata.guest.chkio &&
            guestdata.guest.chkio[0]["roomno"]
              ? guestdata.guest.chkio[0]["roomno"]
              : ""}
          </DialogContentText>
          <Slider maxval="24" type="gt" gt={gt} setGt={setGt} />
        </DialogContent>
        <DialogActions>
          <Button onClick={() => dispatch({ type: "gracetime", val: false })}>
            Cancel
          </Button>
          <Button
            onClick={() => {
              makeproceed("gracetime");
              dispatch({ type: "gracetime", val: false });
            }}
          >
            Proceed
          </Button>
        </DialogActions>
      </Dialog>
      <Dialog
        open={state.cancelchkin}
      
        fullWidth={true}
      >
        <DialogTitle>Cancel Checkin</DialogTitle>
        <DialogContent>
          <DialogContentText>
            Room No:
            {guestdata.guest &&
            guestdata.guest.chkio &&
            guestdata.guest.chkio[0]["roomno"]
              ? guestdata.guest.chkio[0]["roomno"]
              : ""}
          </DialogContentText>
          <TextField
            margin="dense"
            id="cancelcheckin"
            label="Cancel Reason"
            autoComplete="off"
            type="text"
            fullWidth
            variant="standard"
          />
        </DialogContent>
        <DialogActions>
          <Button
            onClick={() => dispatch({ type: "Checkin Cancel", val: false })}
          >
            Cancel
          </Button>
          <Button
            onClick={() => {
              makeproceed("cancelcheckin");
              dispatch({ type: "Checkin Cancel", val: false });
            }}
          >
            Proceed
          </Button>
        </DialogActions>
      </Dialog>
      <Dialog
        open={state.compl}
        
        fullWidth={true}
      >
        <DialogTitle>complimentary Request</DialogTitle>
        <DialogContent>
          <DialogContentText>
            Room No:
            {guestdata.guest &&
            guestdata.guest.chkio &&
            guestdata.guest.chkio[0]["roomno"]
              ? guestdata.guest.chkio[0]["roomno"]
              : ""}
          </DialogContentText>
          <TextField
            margin="dense"
            id="complementary"
            label="complimentary Reason"
            autoComplete="off"
            type="text"
            fullWidth
            variant="standard"
          />
        </DialogContent>
        <DialogActions>
          <Button
            onClick={() => dispatch({ type: "complimentary", val: false })}
          >
            Cancel
          </Button>
          <Button
            onClick={() => {
              makeproceed("complimentary");
              dispatch({ type: "complimentary", val: false });
            }}
          >
            Proceed
          </Button>
        </DialogActions>
      </Dialog>
      <Dialog
        open={state.credit}
        
        aria-labelledby="alert-dialog-title"
        aria-describedby="alert-dialog-description"
        style={{ width: "300px !important" }}
        fullWidth={true}
      >
        <DialogTitle id="alert-dialog-title">{"Allow Credit"}</DialogTitle>
        <DialogContent>
          <DialogContentText id="alert-dialog-description">
            Are your sure?
          </DialogContentText>
        </DialogContent>
        <DialogActions>
          <Button
            onClick={() => dispatch({ type: "Allow Credit", val: false })}
          >
            Cancel
          </Button>
          <Button
            onClick={() => {
              makeproceed("credit");
              dispatch({ type: "Allow Credit", val: false });
              
            }}
            autoFocus
          >
            Proceed
          </Button>
        </DialogActions>
      </Dialog>
      <Dialog
        open={state.alert}
        onClose={() => dispatch({ type: "alert", val: false })}
        aria-labelledby="alert-dialog-title"
        aria-describedby="alert-dialog-description"
        style={{ width: "300px !important" }}
        fullWidth={true}
      >
        <DialogTitle id="alert-dialog-title">Alert</DialogTitle>
        <DialogContent>
          <DialogContentText id="alert-dialog-description">
            {msg}
          </DialogContentText>
        </DialogContent>
        <DialogActions>
          <Button onClick={() => dispatch({ type: "alert", val: false })}>
            Close
          </Button>
        </DialogActions>
      </Dialog>
      <Box
        sx={{ transform: "translateZ(0px)", flexGrow: 1 }}
        style={{ position: "fixed", bottom: "20px", left: "30px" }}
      >
        <Backdrop open={open} />
        <SpeedDial
          ariaLabel="SpeedDial tooltip example"
          sx={{ position: "fixed", bottom: 16, left: 16 }}
          icon={<SpeedDialIcon />}
          onClose={handleClose}
          onOpen={handleOpen}
          open={open}
          className='floating-btn'
        >
          {actions.map((action) => (
            <SpeedDialAction
            className="floating-btn-span"
              key={action.name}
              icon={action.icon}
              tooltipTitle={action.name}
              tooltipPlacement="right"
              tooltipOpen
              onClick={() => {
                determinelabel(action.name);
              }}
            />
          ))}
        </SpeedDial>
      </Box>
    </>
  );
}
