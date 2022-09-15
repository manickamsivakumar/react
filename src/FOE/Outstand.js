import React from "react";
import ReactDOM from "react-dom";
import Box from "@mui/material/Box";
import Grid from "@mui/material/Grid";
import DataTable from "react-data-table-component";
import $ from "jquery";
import { Link } from "react-router-dom";
import Skelt from "../Skeleton/Skeleton6.js";
function Outstand({ propid, daysettledate, propname }) {
  const [skele, setSkele] = React.useState(true);
  var baseurl = process.env.REACT_APP_BASE_URL;
  const [outstanding, setOutstanding] = React.useState({});
  var today = new Date(daysettledate).toISOString().substring(0, 10);

  React.useEffect(() => {
    getfoedata(today, propid);
  }, [daysettledate]);
  const getfoedata = (today, propid) => {
    $.ajax({
      url: baseurl + "getoutstanding",
      type: "post",
      data: {
        today,
        propid,
      },
      datatype: "JSON",
      beforeSend: function () {
        setSkele(true);
      },
      success: function (res) {
        setOutstanding(JSON.parse(res));
      },
      complete: function () {
       //setSkele(false);
      },
      error: function () {},
    });
  };
  const columns = [
    {
      name: "Ledgername",
      selector: (row) => row.ledgername,
      style: {
        fontSize: 14,
        fontFamily: "sofia Pro",
      },
      sortable: true,
      right: false,
      cell: (row) => (
        <div style={{ fontSize: 12, fontFamily: "sofia Pro" }}>
          {row.ledgername}
        </div>
      ),
    },
    {
      name: "Close Bal",
      selector: (row) => row.closebal,
      style: {
        fontSize: 14,
        fontFamily: "sofia Pro",
      },
      cell: (row) => (
        <div
          style={{ fontSize: 13, color: "#2c3246", fontFamily: "sofia Pro" }}
        >
          {row.closebal}
        </div>
      ),
      minWidth: "100px",
      sortable: true,
      right: true,
    },
  ];

  // data provides access to your row data
  const ExpandedComponent =
    (suppData) =>
    ({ data }) => {
      console.log(data);
      return (
        <Grid container item xs={12} className="dues-expand">
          <div>
            <table style={{ width: "100%" }}>
              <thead className="table-thead">
                <tr>
                  <th className="text-left">Open Bal</th>
                  <th className="text-right">Dbt</th>
                  <th className="text-right">Crdt</th>
                  <th className="text-right">Details</th>
                </tr>
              </thead>
              <tbody className="table-tbody">
                <tr>
                  <td style={{ textAlign: "left" }}>{data.openbal}</td>
                  <td style={{ textAlign: "right" }}>{data.debit}</td>
                  <td style={{ textAlign: "right" }}>{data.credit}</td>
                  <td style={{ textAlign: "right" }}>
                    <Link
                      to="/ledgerdtls"
                      state={{
                        ...data,
                        ...propname,
                        propid: propid,
                        today: today,
                      }}
                    >
                      Dtls
                    </Link>
                  </td>
                </tr>
              </tbody>
            </table>
          </div>
        </Grid>
      );
    };
  return (
    <>
    {skele ? <Skelt/> : 
        
    
    <Box
      className="dues-body"
      style={{ margin: "10px", padding: "10px 10px !important" }}
    >
      <Grid container item xs={12}>
        <div style={{ width: "100%" }}>
          {outstanding.length > 0 ? (
            <DataTable
              columns={columns}
              data={outstanding}
              expandableRows
              expandableRowsComponent={ExpandedComponent("HELLO")}
            />
          ) : (
            ""
          )}
        </div>
      </Grid>
    </Box>}
    </>
  );
}
export default Outstand;
