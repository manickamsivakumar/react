import React, { useEffect } from "react";
import Box from "@mui/material/Box";

import Menu from "@mui/material/Menu";
import MenuItem from "@mui/material/MenuItem";
import ListItemIcon from "@mui/material/ListItemIcon";

import IconButton from "@mui/material/IconButton";

import Tooltip from "@mui/material/Tooltip";

import FilterAltIcon from "@mui/icons-material/FilterAlt";
import Filter from "./images/ic_filter.svg";
function get_all_duration(filtervalue) {
  var dates = {};
  var fromdates = "";
  var todates = "";
  if (filtervalue == 1) {
    todates = new Date().toISOString().slice(0, 10) + "";
    fromdates = new Date().toISOString().slice(0, 10) + "";
  }
  if (filtervalue == 2) {
    todates = new Date().toISOString().slice(0, 10) + "";
    fromdates = determinedate(6);
  }
  if (filtervalue == 3) {
    todates = new Date().toISOString().slice(0, 10) + "";
    fromdates = determinedate(29);
  }
  if (filtervalue == 4) {
    todates = new Date().toISOString().slice(0, 10) + "";
    let date = new Date();
    let year = date.getFullYear();
    let month = date.getMonth() + 1;
    fromdates = year + "-" + "0" + month + "-" + "01";
  }
  if (filtervalue == 5) {
    var now = new Date();
    todates = new Date(now.getFullYear(), now.getMonth(), 0);
    fromdates = new Date(
      now.getFullYear() - (now.getMonth() > 0 ? 0 : 1),
      (now.getMonth() - 1 + 12) % 12,
      1
    );
    var formatDateComponent = function (dateComponent) {
      return (dateComponent < 10 ? "0" : "") + dateComponent;
    };
    var formatDate = function (date) {
      return (
        date.getFullYear() +
        "-" +
        formatDateComponent(date.getMonth() + 1) +
        "-" +
        formatDateComponent(date.getDate())
      );
    };
    fromdates = formatDate(fromdates);
    todates = formatDate(todates);
  }
  if (filtervalue == 6) {
    const currentYear = new Date().getFullYear();
    todates = currentYear + "-12-31";

    fromdates = currentYear + "-01-01";
  }
  dates["fromdates"] = fromdates;
  dates["todates"] = todates;
  return dates;
}
//manicam function-2
function determinedate(value) {
  var date = new Date();
  date.setDate(date.getDate() - value);
  var old = date.toISOString().slice(0, 10) + "";
  return old;
}
export default function AccountMenu({
  isdash,
  setSelectedIndex,
  setValue,
  value,
}) {
  const [anchorEl, setAnchorEl] = React.useState(null);

  const open = Boolean(anchorEl);
  const handleClickListItem = (event) => {
    setAnchorEl(event.currentTarget);
  };

  const handleMenuItemClick = (event, index) => {
    setValue(+index);
    if (+index == 6) {
      console.log("daterange");
      return;
      setSelectedIndex({ fromdates: "", todates: "" });
    }
    var dates = get_all_duration(+index + 1);
    setSelectedIndex(dates);
    setAnchorEl(null);
  };

  const handleClose = () => {
    setAnchorEl(null);
  };
  const handleClick = (event) => {
    setAnchorEl(event.currentTarget);
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

  return (
    <React.Fragment>
      <Box sx={{ display: "flex", alignItems: "center", textAlign: "center" }}>
        <Tooltip title="Account settings">
          <IconButton
            onClick={handleClick}
            size="small"
            sx={{ ml: 2 }}
            aria-controls={open ? "account-menu" : undefined}
            aria-haspopup="true"
            aria-expanded={open ? "true" : undefined}
          >
            <div className="filter-icon-div">
              {isdash == true ? (
                <FilterAltIcon className="filter-icon" />
              ) : (
                <img src={Filter} />
              )}
            </div>
          </IconButton>
        </Tooltip>
      </Box>
      <Menu
        anchorEl={anchorEl}
        id="account-menu"
        open={open}
        onClose={handleClose}
        onClick={handleClose}
        PaperProps={{
          elevation: 0,
          sx: {
            overflow: "visible",
            filter: "drop-shadow(0px 2px 8px rgba(0,0,0,0.32))",
            mt: 1.5,
            "& .MuiAvatar-root": {
              width: 32,
              height: 32,
              ml: -0.5,
              mr: 1,
            },
            "&:before": {
              content: '""',
              display: "block",
              position: "absolute",
              top: 0,
              right: 14,
              width: 10,
              height: 10,
              bgcolor: "background.paper",
              transform: "translateY(-50%) rotate(45deg)",
              zIndex: 0,
            },
          },
        }}
        transformOrigin={{ horizontal: "right", vertical: "top" }}
        anchorOrigin={{ horizontal: "right", vertical: "bottom" }}
      >
        {options.map((option, index) => (
          <MenuItem
            key={option}
            selected={index === value}
            onClick={(event) => handleMenuItemClick(event, index)}
          >
            {option}
          </MenuItem>
        ))}
      </Menu>
    </React.Fragment>
  );
}
