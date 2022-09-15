import React from "react";
import Button from "@mui/material/Button";
import Dialog from "@mui/material/Dialog";
import DialogActions from "@mui/material/DialogActions";
import DialogContent from "@mui/material/DialogContent";
import DialogContentText from "@mui/material/DialogContentText";
import DialogTitle from "@mui/material/DialogTitle";
import Slide from "@mui/material/Slide";
import Daterange from "./Daterange.js";
import Modal from '@mui/material/Modal';
import Box from '@mui/material/Box';
import Grid from "@mui/material/Grid";
import FormControl from '@mui/material/FormControl';
import $ from 'jquery';
import 'rsuite/dist/rsuite.min.css'
import DateRangePicker from 'rsuite/DateRangePicker';
const Transition = React.forwardRef(function Transition(props, ref) {
  return <Slide direction="up" ref={ref} {...props} />;
});

export default function DaterangeWrapper({ setSelectedIndex, selectedIndex }) {
  React.useEffect(() => {
    //$("#daterangepicker").trigger("doubleclick");
    console.log("sddfsdfgdfgffg");

    
    setTimeout(() => {
      $(".daterangepicker-div").css('display', 'none');
      $(".rs-picker-toggle-wrapper").css("top", '0px');
      $(".rs-picker-toggle-wrapper").css("left", '0px');
    },20)
    setTimeout(() => {
      $("#daterangepicker").trigger('click');
      // $(".rs-picker-toggle").addClass('rs-picker-toggle-active'); 
      // $(".rs-picker-toggle").attr('aria-expanded', true);  
      // $("#daterangepicker").attr('aria-hidden',false);
    },100)
    
    console.log("sdfdsfdfdfgdfg")
  }, []);
  console.log(selectedIndex, "appsindex");
  const [open, setOpen] = React.useState(true);

  const handleClickOpen = () => {
    setOpen(true);
  };

  const handleClose = () => {
    setOpen(false);
  };
  const handleDateRangeFilterChange = (daterangearr, event) => {
    var daterange = {};
    if (daterangearr.length == 2) {
        daterange.fromdates = daterangearr[0].toJSON().substring(0, 10);
      daterange.todates = daterangearr[1].toJSON().substring(0, 10);
      setSelectedIndex(daterange);
      setOpen(false);
        //alert(DateTime.set(daterange.fromdate).plus({ days: 1 }).toISODate());
    }
  }
  const modalboxstyle = {
    position: 'absolute',
    top: '50%',
    left: '50%',
    transform: 'translate(-50%, -50%)',
    bgcolor: 'background.paper',
  
    
    p: 4,
    height: '72%',
    width: '78%',
    borderRadius: '10px',
    padding: '15px',
    backgroundColor: 'inherit',
boxShadow:'none !important'
};

  return (
    // <div>
    //   <Dialog
    //     fullWidth={true}
    //     open={open}
    //     TransitionComponent={Transition}
    //     keepMounted
    //     onClose={handleClose}
    //     aria-describedby="alert-dialog-slide-description"
        
    //   >
    //     {/* <DialogTitle>Select Date Range..</DialogTitle> */}
    //     <DialogContent style={{height:'fit-content'}}>
    //       <div
    //         style={{
    //           display: "flex",
    //           justifyContent: "center",
    //           alignItems: "baseline",
    //           width: "100%",
    //           height: "450px",
    //         }}
    //       >
    //         {/* <div style={{ marginRight: "10px" }}>
    //           <Daterange
    //             label="Fromdate"
    //             setSelectedIndex={setSelectedIndex}
    //             selectedIndex={selectedIndex}
    //           />
    //         </div>
    //         <div>
    //           <Daterange
    //             label="Todate"
    //             setSelectedIndex={setSelectedIndex}
    //             selectedIndex={selectedIndex}
    //           />
    //         </div> */}
    //            <DateRangePicker placement="bottom" id="daterangepicker" format='dd-MM-yyyy' placeholder="Select Date Range" onOk={handleDateRangeFilterChange} showOneCalendar />
    //       </div>
    //     </DialogContent>
    //     <DialogActions>
    //       {/* <Button onClick={handleClose}>close</Button> */}
    //     </DialogActions>
    //   </Dialog>
    // </div>
    <div  id="filtercard-div-cldiv">

    <Modal
        open={open}
        onClose={handleClose}
        aria-labelledby="modal-modal-title"
        aria-describedby="modal-modal-description"
    >

        <Box sx={modalboxstyle}>
          
            <Grid container style={{ padding: "0px 0px 0px 15px" }}>
                <FormControl className="daterangepicker-div">
                    <DateRangePicker placement="bottomStart" id="daterangepicker" format='dd-MM-yyyy' placeholder="Select Date Range" onOk={handleDateRangeFilterChange} showOneCalendar />
                </FormControl>
            </Grid>
        </Box>
    </Modal>

</div>

  );
}
