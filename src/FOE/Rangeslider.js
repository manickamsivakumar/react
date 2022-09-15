import React from "react";

import Slider from "@mui/material/Slider";
import { styled } from "@mui/material/styles";

import Box from "@mui/material/Box";

const marks = [
  {
    value: 0,
  },
  {
    value: 6,
  },
  {
    value: 12,
  },
  {
    value: 24,
  },
];

const PrettoSlider = styled(Slider)({
  color: "#028cf3",
  height: 8,
  "& .MuiSlider-track": {
    border: "none",
  },
  "& .MuiSlider-thumb": {
    height: 24,
    width: 24,
    backgroundColor: "#fff",
    border: "2px solid currentColor",
    "&:focus, &:hover, &.Mui-active, &.Mui-focusVisible": {
      boxShadow: "inherit",
    },
    "&:before": {
      display: "none",
    },
  },
  "& .MuiSlider-valueLabel": {
    lineHeight: 1.2,
    fontSize: 12,
    background: "unset",
    padding: 0,
    width: 32,
    height: 32,
    borderRadius: "50% 50% 50% 0",
    backgroundColor: "#52af77",
    transformOrigin: "bottom left",
    transform: "translate(50%, -100%) rotate(-45deg) scale(0)",
    "&:before": { display: "none" },
    "&.MuiSlider-valueLabelOpen": {
      transform: "translate(50%, -100%) rotate(-45deg) scale(1)",
    },
    "& > *": {
      transform: "rotate(45deg)",
    },
  },
});

export default function Rangeslider({
  maxval,
  type,
  gt,
  setGt,
  discnt,
  setDiscnt,
}) {
  console.log(maxval);
  console.log(type);
  const [val, setVal] = React.useState(0);

  return (
    <Box sx={{ width: "100%" }}>
      <PrettoSlider
        aria-label="slider"
        value={type === "gt" ? gt : discnt}
        marks={marks}
        onChange={type === "gt" ? (e, v) => setGt(v) : (e, v) => setDiscnt(v)}
        onChangeCommitted={
          type === "gt" ? (e, v) => setGt(v) : (e, v) => setDiscnt(v)
        }
        valueLabelDisplay="off"
        min={0}
        max={Number(maxval)}
      />
      <span>{type === "gt" ? gt : discnt}</span>
    </Box>
  );
}
