import React from "react";
import Approval from "./images/ic_approval.svg";
import Alert from "./images/ic_notification.svg";

export default function Authalert() {
  return (
    <div className="flex-content" style={{ marginRight: "10px" }}>
      <img src={Approval} alt='approval' />
      <img src={Alert}  alt='alert'/>
    </div>
  );
}
