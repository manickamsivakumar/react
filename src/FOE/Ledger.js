import React from "react";
import ReactDOM from "react-dom";
import Box from "@mui/material/Box";
import Grid from "@mui/material/Grid";
import DataTable from "react-data-table-component";
import $ from "jquery";
import { Link } from "react-router-dom";
import Backdrop from "@mui/material/Backdrop";
import CircularProgress from '@mui/material/CircularProgress';
function Outstand({ propid, ledgerid, today }) {
  const [spinopen, setSpinopen] = React.useState(true);
  
  console.log(ledgerid);
  var baseurl = process.env.REACT_APP_BASE_URL;
  const [ledgerdtls, setLedgerdtls] = React.useState([]);

  React.useEffect(() => {
    getfoedata(today, propid);
  }, [today]);
  const getfoedata = (today, propid) => {
    $.ajax({
      url: baseurl + "ledgerdtls",
      type: "post",
      data: {
        today,
        propid,
        ledgerid,
      },
      datatype: "JSON",
      beforeSend: function () {

        setSpinopen(true);
      },
      
      success: function (res) {
        setLedgerdtls(JSON.parse(res));
      },
      complete: function () {

        setSpinopen(false);
      },
      
      error: function () {},
    });
  };
  console.log(ledgerdtls);
  const columns = [
    {
      name: "Ledgername",
      selector: (row) => row.ledgername,

      sortable: true,
      right: false,
      cell: (row) => (
        <div style={{ fontSize: 12, fontFamily: "sofia Pro" }}>
          {row.ledgername}
        </div>
      ),
    },
    {
      name: "Credit",
      selector: (row) => row.credit,
      minWidth: "80px",
      sortable: true,
      right: true,
    },
    {
      name: "Debit",
      selector: (row) => row.debit,
      minWidth: "80px",
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
                  <th className="text-left">Vchr No</th>
                  <th className="text-right">Refno</th>
                  <th className="text-right">Voucher Date</th>
                  <th className="text-right">Voucher Type</th>
                </tr>
              </thead>
              <tbody className="table-tbody">
                <tr>
                  <td style={{ textAlign: "left" }}>{data.vchrno}</td>
                  <td style={{ textAlign: "left" }}>{data.refno}</td>
                  <td style={{ textAlign: "right" }}>{data.vchrdate}</td>
                  <td style={{ textAlign: "left" }}>{data.vouchertype}</td>
                </tr>
              </tbody>
            </table>
          </div>
        </Grid>
      );
    };
  return (
    <Box
      className="dues-body"
      style={{ margin: "10px", padding: "10px 10px !important" }}
    >
            <Backdrop className='backdrop-spinner'
        sx={{ color: '#028cf3', zIndex: (theme) => theme.zIndex.drawer + 1 }}
        open={spinopen}
        
      >
        <CircularProgress color="inherit" />
      </Backdrop>
      <Grid container item xs={12}>
        <div style={{ width: "100%" }}>
          {Object.keys(ledgerdtls).length > 0 ? (
            <DataTable
              columns={columns}
              data={Object.values(ledgerdtls).flat()}
              expandableRows
              expandableRowsComponent={ExpandedComponent("HELLO")}
            />
          ) : (
            ""
          )}
        </div>
      </Grid>
    </Box>
  );
}
export default Outstand;
