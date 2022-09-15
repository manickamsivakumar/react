import React from "react";
import TextField from "@mui/material/TextField";
import Stack from "@mui/material/Stack";

export default function DateRange({ label, setSelectedIndex, selectedIndex }) {
  console.log(selectedIndex, "sindex");

  return (
    <LocalizationProvider dateAdapter={AdapterDateFns}>
      <Stack spacing={3} style={{ width: "100px" }}>
        <MobileDatePicker
          label={label}
          Variant="standard"
          value={
            label === "Fromdate"
              ? selectedIndex.fromdates
              : selectedIndex.todates
          }
          onChange={(newValue) => {
            var datevalue = new Date(newValue).toJSON().substring(0, 10);
            console.log(datevalue);
            if (label === "Fromdate") {
              setSelectedIndex({ ...selectedIndex, fromdates: datevalue });
            } else {
              setSelectedIndex({ ...selectedIndex, todates: datevalue });
            }
          }}
          inputFormat="dd-MM-yyyy"
          renderInput={(params) => <TextField variant="standard" {...params} />}
        />
      </Stack>
    </LocalizationProvider>
  );
}
