import React from "react";
import { DataGrid } from "@material-ui/data-grid";

const columns = [
  { field: "chargename", headerName: "ChargeName", width: 130 },
  { field: "chargeamount", headerName: "Amt", width: 100 },
  {
    field: "chargedate",
    headerName: "ChargeDate",
    width: 130,
    fontSize: 12,
  },
];

export default function Datagrid({
  propid,
  trnid,
  managecharges,
  setMncharges,
}) {
  return (
    <div style={{ width: "100%" }}>
      {managecharges.length > 0 ? (
        <DataGrid
          rows={managecharges}
          columns={columns}
          pageSize={12}
          checkboxSelection
          onSelectionModelChange={(newSelection) => {
            console.log(newSelection.rows);
            setMncharges(newSelection);
          }}
        />
      ) : (
        ""
      )}
    </div>
  );
}
