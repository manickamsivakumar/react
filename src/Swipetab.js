import React from "react";

import Tabs from "@mui/material/Tabs";
import Tab from "@mui/material/Tab";
// From https://github.com/oliviertassinari/react-swipeable-views
import SwipeableViews from "react-swipeable-views";

const styles = {
  headline: {
    fontSize: 24,
    paddingTop: 16,
    marginBottom: 12,
    fontWeight: 400,
  },
  slide: {
    padding: 10,
  },
};

export default function TabsExampleSwipeable() {
  const [state, setState] = React.useState({ slideIndex: 0, sliderVal: 79 });

  var handleChange = (value, val) => {
    setState({ ...state, slideIndex: val });
  };

  var sliderChange = (value) => {
    setState({ ...state, sliderVal: value });
  };
  console.log(state);
  return (
    <div>
      <Tabs onChange={handleChange} value={state.slideIndex}>
        <Tab label="Tab One" value={0} />
        <Tab label="Tab Two" value={1} />
        <Tab label="Tab Three" value={2} />
      </Tabs>
      <SwipeableViews index={Number(state.slideIndex)} onChange={handleChange}>
        <div>
          <h2 style={styles.headline}>Tabs with slide effect</h2>
          Swipe to see the next slide.
          <br />
        </div>
        <div style={styles.slide}>dfhfgghgh</div>
        <div style={styles.slide}>
          <p>This is a slider example - value={state.sliderVal}</p>
        </div>
      </SwipeableViews>
    </div>
  );
}
