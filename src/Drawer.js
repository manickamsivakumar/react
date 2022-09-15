import React from "react";
import Box from "@mui/material/Box";
import SwipeableDrawer from "@mui/material/SwipeableDrawer";
import Button from "@mui/material/Button";
import Grid from "@mui/material/Grid";
import List from "@mui/material/List";
import Divider from "@mui/material/Divider";
import ListItem from "@mui/material/ListItem";
import ListItemIcon from "@mui/material/ListItemIcon";
import ListItemText from "@mui/material/ListItemText";
import InboxIcon from "@mui/icons-material/MoveToInbox";
import MailIcon from "@mui/icons-material/Mail";
import menu from "./images/menu.svg";
import Logo from "./images/logo.png";
export default function SwipeableTemporaryDrawer() {
  const [state, setState] = React.useState({
    left: false,
  });

  const toggleDrawer = (anchor, open) => (event) => {
    if (
      event &&
      event.type === "keydown" &&
      (event.key === "Tab" || event.key === "Shift")
    ) {
      return;
    }

    setState({ ...state, [anchor]: open });
  };

  const list = (anchor) => (
    <Box
      sx={{ width: anchor === "top" || anchor === "bottom" ? "auto" : 250 }}
      style={{
        padding: "10px",
        backgroundColor: "#f2f6fa",
        minHeight: "100vh",
      }}
      role="presentation"
      onClick={toggleDrawer(anchor, false)}
      onKeyDown={toggleDrawer(anchor, false)}
    >
      <Grid container item xs={12}>
        <Grid item xs={8}>
          <img src={Logo} alt="logo" height="50" width="100" />
        </Grid>

        <Grid
          item
          xs={4}
          style={{
            display: "flex",
            justifyContent: "end",
            alignItems: "center",
          }}
        >
          <span className="versionNo">v1.0.0</span>
        </Grid>
      </Grid>
      <Divider />
    </Box>
  );
  const left = "left";
  return (
    <div>
      <React.Fragment key={left}>
        <Button onClick={toggleDrawer(left, true)}>
          <img src={menu} />
        </Button>
        <SwipeableDrawer
          anchor={left}
          open={state[left]}
          onClose={toggleDrawer(left, false)}
          onOpen={toggleDrawer(left, true)}
        >
          {list(left)}
        </SwipeableDrawer>
      </React.Fragment>
    </div>
  );
}
