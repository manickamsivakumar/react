import React from "react";
// import TextField from "@mui/material/TextField";
// import { AdapterDateFns } from "@mui/x-date-pickers/AdapterDateFns";
// import { LocalizationProvider } from "@mui/x-date-pickers/LocalizationProvider";
// import { DatePicker } from "@mui/x-date-pickers/DatePicker";
// import { MobileDatePicker } from "@mui/x-date-pickers/MobileDatePicker";
// import { DesktopDatePicker } from "@mui/x-date-pickers/DesktopDatePicker";
// import Stack from "@mui/material/Stack";
// import CalendarMonthIcon from '@mui/icons-material/CalendarMonth';
// import InputAdornment from '@mui/material/InputAdornment';

import 'rsuite/dist/rsuite.min.css'
import DatePicker from 'rsuite/DatePicker';
import $ from 'jquery';

export default function DatePickers({ setDaysettledate, daysettledate }) {
  React.useEffect(() => {
    $(".rs-picker-toggle-wrapper").css("top", '0px');
    $(".rs-picker-toggle-wrapper").css("left", '0px');
    $(".rs-picker-menu").css("top", '184px');
  }, [])
  const handleDateRangeFilterChange = (dateval, event) => {
   // alert(dateval);
    if (dateval) {
      var sel_date = dateval.toJSON().substring(0, 10);
      setDaysettledate(sel_date);
    }
    
  }
  return (
    <>
      
    <DatePicker placement="bottomEnd"  format='dd-MM-yyyy' placeholder="Select Date..." onOk={handleDateRangeFilterChange} />    
    </>

    // <LocalizationProvider dateAdapter={AdapterDateFns}>
    //   <Stack spacing={3} style={{ width: "100px" }}>
    //     <MobileDatePicker
    //       variant="standard"
    //       InputProps={{
    //         startAdornment: (
    //           <InputAdornment position="start">
    //             <CalendarMonthIcon />
    //           </InputAdornment>
    //         ),
    //       }}
    //       value={daysettledate}
    //       inputFormat="dd-MM-yyyy"
    //       inputProps={{ style: { textAlign: "center" } }}
    //       onChange={(newValue) => {
    //         setDaysettledate(newValue);
    //       }}
    //       renderInput={(params) => <TextField  className='datepicker-text' variant="standard" {...params} />}
    //     />
    //   </Stack>
    // </LocalizationProvider>
  );
}
