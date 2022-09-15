<?php

class Pos_model extends CI_Model

{

    public function __construct()

    {

        parent::__construct();

        //$this->load->database();
        //$this->connectdatabase();

    }

    public function connectdatabase()

    {

        $data['logindetails'] = $this->session->userdata('logindetails');

        $dbserverip = $dbserveruserid = $dbserverpwd = $databasename = "";

        $dbserverip = $data['logindetails']['dbserverip'];

        $dbserveruserid = $data['logindetails']['dbserveruserid'];

        $dbserverpwd = $data['logindetails']['dbserverpwd'];

        $databasename = $data['logindetails']['databasename'];



        if ($dbserverip != "" && $dbserveruserid != "" && $dbserverpwd != "" && $databasename != "") {

            $dbchange = $this->loaddatabase($dbserveruserid, $dbserverpwd, $dbserverip, $databasename);

            $this->db = $this->load->database($dbchange, true);
        }

        /*$name = $this->house->getdbname();

        echo "<pre>";

        print_r($name);

        echo "</pre>";*/
    }

    public function loaddatabase($userid = "", $password = "", $hostname = "", $dbname = "")

    {

        if (($userid != "") && ($password != "") && ($hostname != "") && ($dbname != "")) {

            $dsn = 'mysqli://' . $userid . ':' . $password . '@' . $hostname . '/' . $dbname;

            //$this->load->database($dsn,true);            

            //return $dsn;

            return $dsn;
        } else {

            //$this->load->database();

            return 'raspmaster';
        }
    }

    public function getposareaitemsettlevalues($postdetails)
    {
        $areaid = $postdetails['areaid'];
        $fromdate = '"' . $postdetails['fromdate'] . '"';
        $todate = '"' . $postdetails['todate'] . '"';
        $propid = $postdetails['propid'];
        $cmpid = $postdetails['cmpid'];

        if ($propid && $fromdate && $todate) {
            $databasename = 'rasp_bkg';
            $asql = '';
            if ($areaid) {
                $asql = ' AND ' . $databasename . '.tbl_pos_billheader.areaid IN (' . $areaid . ') ';
            }
            if ($databasename) {
                $sql = "SELECT
                " . $databasename . ".tbl_pos_kotitems.kotitmtrnid,
                " . $databasename . ".tbl_pos_kotitems.propid,
                " . $databasename . ".tbl_pos_kotitems.billid,
                " . $databasename . ".tbl_pos_kotitems.kottrnid,
                " . $databasename . ".tbl_pos_kotitems.itemid,
                " . $databasename . ".tbl_pos_itemgroup.grpid,
                " . $databasename . ".tbl_pos_itemgroup.grpname,
                " . $databasename . ".tbl_pos_kotitems.itemname,
                " . $databasename . ".tbl_pos_kotitems.chargeid,
                " . $databasename . ".tbl_pos_kotitems.qty,
                " . $databasename . ".tbl_pos_kotitems.amount,
                " . $databasename . ".tbl_pos_kotitems.rate,
                " . $databasename . ".tbl_pos_kotitems.cankottrnid,
                " . $databasename . ".tbl_pos_kotitems.added_date,
                " . $databasename . ".tbl_pos_billheader.billcancelled,
                " . $databasename . ".tbl_pos_billheader.billpayhdrid,
                " . $databasename . ".tbl_pos_area.areaid,
                " . $databasename . ".tbl_pos_area.areaname,
                " . $databasename . ".property_master.propid,
                " . $databasename . ".property_master.propname,
                " . $databasename . ".property_master.propcity
                FROM
                " . $databasename . ".tbl_pos_kotitems
                INNER JOIN " . $databasename . ".tbl_pos_kotheader ON " . $databasename . ".tbl_pos_kotheader.kottrnid = " . $databasename . ".tbl_pos_kotitems.kottrnid
                INNER JOIN " . $databasename . ".tbl_pos_area ON " . $databasename . ".tbl_pos_area.areaid = " . $databasename . ".tbl_pos_kotheader.areaid
                INNER JOIN " . $databasename . ".tbl_pos_items ON " . $databasename . ".tbl_pos_items.itmid = " . $databasename . ".tbl_pos_kotitems.itemid
                INNER JOIN " . $databasename . ".tbl_pos_itemgroup ON " . $databasename . ".tbl_pos_items.grpid = " . $databasename . ".tbl_pos_itemgroup.grpid
                INNER JOIN " . $databasename . ".tbl_pos_billheader ON " . $databasename . ".tbl_pos_billheader.billtrnid = " . $databasename . ".tbl_pos_kotitems.billid
                INNER JOIN " . $databasename . ".tbl_pos_billpay_header ON " . $databasename . ".tbl_pos_billheader.billpayhdrid = " . $databasename . ".tbl_pos_billpay_header.billpayhdrid
                INNER JOIN " . $databasename . ".tbl_pos_billpay_trans ON " . $databasename . ".tbl_pos_billpay_header.billpayhdrid = " . $databasename . ".tbl_pos_billpay_trans.billpayhdrid
                INNER JOIN " . $databasename . ".property_master ON " . $databasename . ".property_master.propid = " . $databasename . ".tbl_pos_billheader.propid
                WHERE
                    date(
                        " . $databasename . ".tbl_pos_billheader.billdatetime
                    )BETWEEN " . $fromdate . "
                AND " . $todate . "
                AND " . $databasename . ".tbl_pos_billheader.ncbill = 0
                " . $asql . "
                AND " . $databasename . ".property_master.propid = " . $propid . "
                AND " . $databasename . ".property_master.cmpid = " . $cmpid . "
                ORDER BY
                " . $databasename . ".tbl_pos_kotitems.kotitmtrnid";
                $query = $this->db->query($sql);
                $data = $query->result_array();

                //echo $sql;

                $result = $settledetails = $areadetails = $propdetails = $itemdetails = [];
                $result['details'] = $result['values'] = [];
                //$itemdetails['cancel'] = [];
                //$itemdetails['nocancel'] = [];

                foreach ($data as $values) {
                    if (!array_key_exists($values['areaid'], $itemdetails)) {
                        $itemdetails[$values['areaid']] = [];
                        $itemdetails[$values['areaid']]['cancel'] = [];
                        $itemdetails[$values['areaid']]['nocancel'] = [];
                    }
                    if ($values['billcancelled'] || $values['cankottrnid']) {
                        array_push($itemdetails[$values['areaid']]['cancel'], $values);
                        $propdetails['propname'] = $values['propname'];
                        $propdetails['propcity'] = $values['propcity'];
                    } else {
                        array_push($itemdetails[$values['areaid']]['nocancel'], $values);
                        $propdetails['propname'] = $values['propname'];
                        $propdetails['propcity'] = $values['propcity'];
                    }
                }

                $areasql = 'select * from ' . $databasename . '.tbl_pos_area where ' . $databasename . '.tbl_pos_area.propid = ' . $propid . ' and ' . $databasename . '.tbl_pos_area.ispos = 1 and ' . $databasename . '.tbl_pos_area.cmpid = ' . $cmpid;
                //echo $propsql;
                $areaquery = $this->db->query($areasql);
                $areadata = $areaquery->result_array();

                foreach ($areadata as $value) {
                    $areadetails[$value['areaid']] = $value['areaname'];
                }

                $settlesql = 'select * from ' . $databasename . '.tbl_pos_settlementmaster where ' . $databasename . '.tbl_pos_settlementmaster.propid = ' . $propid;
                //echo $propsql;
                $settlequery = $this->db->query($settlesql);
                $settledata = $settlequery->result_array();

                foreach ($settledata as $value) {
                    $settledetails[$value['settleid']] = $value['settletype'];
                }

                // echo "<pre>";
                // print_r($itemdetails);
                // echo "</pre>";

                $sql = "SELECT
                sum(" . $databasename . ".tbl_pos_billcharges.amount) as areaamount,
                " . $databasename . ".tbl_pos_area.areaid,
                " . $databasename . ".tbl_pos_area.areaname
                FROM
                " . $databasename . ".tbl_pos_billheader
                INNER JOIN " . $databasename . ".tbl_pos_billcharges ON " . $databasename . ".tbl_pos_billcharges.billtrnid = " . $databasename . ".tbl_pos_billheader.billtrnid
                INNER JOIN " . $databasename . ".tbl_pos_area ON " . $databasename . ".tbl_pos_area.areaid = " . $databasename . ".tbl_pos_billheader.areaid
                INNER JOIN " . $databasename . ".tbl_pos_billpay_header ON " . $databasename . ".tbl_pos_billheader.billpayhdrid = " . $databasename . ".tbl_pos_billpay_header.billpayhdrid
                INNER JOIN " . $databasename . ".tbl_pos_billpay_trans ON " . $databasename . ".tbl_pos_billpay_header.billpayhdrid = " . $databasename . ".tbl_pos_billpay_trans.billpayhdrid
                INNER JOIN " . $databasename . ".property_master ON " . $databasename . ".property_master.propid = " . $databasename . ".tbl_pos_billheader.propid
                WHERE
                    date(
                        " . $databasename . ".tbl_pos_billheader.billdatetime
                    )BETWEEN " . $fromdate . "
                AND " . $todate . "
                AND " . $databasename . ".tbl_pos_billheader.ncbill = 0
                AND " . $databasename . ".tbl_pos_billheader.billcancelled = 0
                " . $asql . "
                AND " . $databasename . ".property_master.propid = " . $propid . "
                AND " . $databasename . ".property_master.cmpid = " . $cmpid . "
                GROUP BY
                " . $databasename . ".tbl_pos_billheader.areaid";
                $query = $this->db->query($sql);
                $data = $query->result_array();

                $areavalues = [];

                foreach ($data  as $values) {
                    $areavalues[$values['areaid']] = $values['areaamount'];
                }


                $result['details']['settledetails'] = $settledetails;
                $result['details']['propdetails'] = $propdetails;
                $result['details']['areadetails'] = $areadetails;
                $result['details']['areavalues'] = $areavalues;
                $result['details']['postdetails'] = $postdetails;

                $result['values'] = $itemdetails;

                // echo "<pre>";
                // print_r($result);
                // echo "</pre>";

                return $result;
            }
        }
        return 0;
    }

    public function getposareaitemkotdetails($postdetails)
    {
        $areaid = $postdetails['m_areaid'];
        $fromdate = '"' . $postdetails['fromdate'] . '"';
        $todate = '"' . $postdetails['todate'] . '"';
        $propid = $postdetails['propid'];
        $cmpid = $postdetails['cmpid'];
        $itemid = $postdetails['itemid'];
        $groupmode = 0;
        if (array_key_exists('groupmode', $postdetails)) {
            $groupmode = $postdetails['groupmode'];
        }
        if ($propid && $fromdate && $todate) {
            $databasename = 'rasp_bkg';

            $asql = '';
            if (!$areaid) {
                $asql = " AND ' . $databasename . '.tbl_pos_kotheader.areaid IN (' . $areaid . ')";
            }

            if ($databasename) {
                if ($groupmode == 0) {
                    $sql = "SELECT
                    " . $databasename . ".tbl_pos_kotitems.kotitmtrnid,
                    " . $databasename . ".tbl_pos_kotitems.propid,
                    " . $databasename . ".tbl_pos_kotitems.billid,
                    " . $databasename . ".tbl_pos_kotitems.kottrnid,
                    " . $databasename . ".tbl_pos_kotitems.itemid,
                    " . $databasename . ".tbl_pos_kotitems.itemname,
                    " . $databasename . ".tbl_pos_kotitems.chargeid,
                    " . $databasename . ".tbl_pos_kotitems.qty,
                    " . $databasename . ".tbl_pos_kotitems.amount,
                    " . $databasename . ".tbl_pos_kotitems.rate,
                    " . $databasename . ".tbl_pos_kotitems.cankottrnid,
                    " . $databasename . ".tbl_pos_kotitems.added_date,
                    " . $databasename . ".tbl_pos_billheader.billcancelled,
                    " . $databasename . ".tbl_pos_billheader.billpayhdrid,
                    " . $databasename . ".tbl_pos_billheader.billdatetime,
                    " . $databasename . ".tbl_pos_area.areaid,
                    " . $databasename . ".tbl_pos_area.areaname,
                    " . $databasename . ".property_master.propid,
                    " . $databasename . ".property_master.propname,
                    " . $databasename . ".property_master.propcity
                    FROM
                    " . $databasename . ".tbl_pos_kotitems
                    INNER JOIN " . $databasename . ".tbl_pos_kotheader ON " . $databasename . ".tbl_pos_kotheader.kottrnid = " . $databasename . ".tbl_pos_kotitems.kottrnid
                    INNER JOIN " . $databasename . ".tbl_pos_area ON " . $databasename . ".tbl_pos_area.areaid = " . $databasename . ".tbl_pos_kotheader.areaid
                    INNER JOIN " . $databasename . ".tbl_pos_items ON " . $databasename . ".tbl_pos_items.itmid = " . $databasename . ".tbl_pos_kotitems.itemid
                    INNER JOIN " . $databasename . ".tbl_pos_billheader ON " . $databasename . ".tbl_pos_billheader.billtrnid = " . $databasename . ".tbl_pos_kotitems.billid
                    INNER JOIN " . $databasename . ".tbl_pos_billpay_header ON " . $databasename . ".tbl_pos_billheader.billpayhdrid = " . $databasename . ".tbl_pos_billpay_header.billpayhdrid
                    INNER JOIN " . $databasename . ".tbl_pos_billpay_trans ON " . $databasename . ".tbl_pos_billpay_header.billpayhdrid = " . $databasename . ".tbl_pos_billpay_trans.billpayhdrid
                    INNER JOIN " . $databasename . ".property_master ON " . $databasename . ".property_master.propid = " . $databasename . ".tbl_pos_billheader.propid
                    WHERE
                        date(
                            " . $databasename . ".tbl_pos_billheader.billdatetime
                        )BETWEEN " . $fromdate . "
                    AND " . $todate . "
                    AND " . $databasename . ".tbl_pos_billheader.ncbill = 0
                    " . $asql . "
                    AND " . $databasename . ".tbl_pos_kotitems.itemid = " . $itemid . "
                    AND " . $databasename . ".property_master.propid = " . $propid . "
                    AND " . $databasename . ".property_master.cmpid = " . $cmpid . "
                    ORDER BY
                    " . $databasename . ".tbl_pos_kotitems.kotitmtrnid";
                    $query = $this->db->query($sql);
                    $datetimedata = $query->result_array();

                    // echo "<pre>";
                    // print_r($datetimedata);
                    // echo "</pre>";

                    $kotdetails = [];
                    $kotdetails['firstkot'] = $kotdetails['lastkot'] = [];

                    if (count($datetimedata)) {
                        $kotdetails['firstkot'] = $datetimedata[0];
                        $kotdetails['lastkot'] = $datetimedata[count($datetimedata) - 1];
                    }





                    $billdatetimedata = [];
                    foreach ($datetimedata as $value) {
                        $billdatetime = explode(" ", $value['billdatetime']);
                        $areaid = $value['areaid'];
                        $date = $billdatetime[0];

                        $time = explode(":", $billdatetime[1])[0]; //hr mode

                        if (!array_key_exists($areaid, $billdatetimedata)) {
                            $billdatetimedata[$areaid] = [];
                        }
                        if (!array_key_exists($date, $billdatetimedata[$areaid])) {
                            $billdatetimedata[$areaid][$date] = [];
                        }
                        if (!array_key_exists($time, $billdatetimedata[$areaid][$date])) {
                            $billdatetimedata[$areaid][$date][$time] = 0;
                        }
                        $billdatetimedata[$areaid][$date][$time] += $value['amount'];
                    }


                    ///echo $sql;
                    $result = [];
                    $result['values'] = $billdatetimedata;
                    $result['kotdetails'] = $kotdetails;

                    return $result;
                } else {
                    $sql = "SELECT
                " . $databasename . ".tbl_pos_kotitems.kotitmtrnid,
                " . $databasename . ".tbl_pos_kotitems.propid,
                " . $databasename . ".tbl_pos_kotitems.billid,
                " . $databasename . ".tbl_pos_kotitems.kottrnid,
                " . $databasename . ".tbl_pos_kotitems.itemid,
                " . $databasename . ".tbl_pos_kotitems.itemname,
                " . $databasename . ".tbl_pos_kotitems.chargeid,
                " . $databasename . ".tbl_pos_kotitems.qty,
                " . $databasename . ".tbl_pos_kotitems.amount,
                " . $databasename . ".tbl_pos_kotitems.rate,
                " . $databasename . ".tbl_pos_kotitems.cankottrnid,
                " . $databasename . ".tbl_pos_kotitems.added_date,
                " . $databasename . ".tbl_pos_billheader.billcancelled,
                " . $databasename . ".tbl_pos_billheader.billpayhdrid,
                " . $databasename . ".tbl_pos_billheader.billdatetime,
                " . $databasename . ".tbl_pos_area.areaid,
                " . $databasename . ".tbl_pos_area.areaname,
                " . $databasename . ".property_master.propid,
                " . $databasename . ".property_master.propname,
                " . $databasename . ".property_master.propcity
                FROM
                " . $databasename . ".tbl_pos_kotitems
                INNER JOIN " . $databasename . ".tbl_pos_kotheader ON " . $databasename . ".tbl_pos_kotheader.kottrnid = " . $databasename . ".tbl_pos_kotitems.kottrnid
                INNER JOIN " . $databasename . ".tbl_pos_area ON " . $databasename . ".tbl_pos_area.areaid = " . $databasename . ".tbl_pos_kotheader.areaid
                INNER JOIN " . $databasename . ".tbl_pos_items ON " . $databasename . ".tbl_pos_items.itmid = " . $databasename . ".tbl_pos_kotitems.itemid
                INNER JOIN " . $databasename . ".tbl_pos_itemgroup ON " . $databasename . ".tbl_pos_items.grpid = " . $databasename . ".tbl_pos_itemgroup.grpid
                INNER JOIN " . $databasename . ".tbl_pos_billheader ON " . $databasename . ".tbl_pos_billheader.billtrnid = " . $databasename . ".tbl_pos_kotitems.billid
                INNER JOIN " . $databasename . ".tbl_pos_billpay_header ON " . $databasename . ".tbl_pos_billheader.billpayhdrid = " . $databasename . ".tbl_pos_billpay_header.billpayhdrid
                INNER JOIN " . $databasename . ".tbl_pos_billpay_trans ON " . $databasename . ".tbl_pos_billpay_header.billpayhdrid = " . $databasename . ".tbl_pos_billpay_trans.billpayhdrid
                INNER JOIN " . $databasename . ".property_master ON " . $databasename . ".property_master.propid = " . $databasename . ".tbl_pos_billheader.propid
                WHERE
                    date(
                        " . $databasename . ".tbl_pos_billheader.billdatetime
                    )BETWEEN " . $fromdate . "
                AND " . $todate . "
                AND " . $databasename . ".tbl_pos_billheader.ncbill = 0
                " . $asql . "
                AND " . $databasename . ".tbl_pos_itemgroup.grpid = " . $itemid . "
                AND " . $databasename . ".property_master.propid = " . $propid . "
                AND " . $databasename . ".property_master.cmpid = " . $cmpid . "
                ORDER BY
                " . $databasename . ".tbl_pos_kotitems.kotitmtrnid";
                    $query = $this->db->query($sql);
                    $datetimedata = $query->result_array();

                    // echo "<pre>";
                    // print_r($datetimedata);
                    // echo "</pre>";

                    $kotdetails = [];
                    $kotdetails['firstkot'] = $kotdetails['lastkot'] = [];

                    if (count($datetimedata)) {
                        $kotdetails['firstkot'] = $datetimedata[0];
                        $kotdetails['lastkot'] = $datetimedata[count($datetimedata) - 1];
                    }

                    $billdatetimedata = [];
                    foreach ($datetimedata as $value) {
                        $billdatetime = explode(" ", $value['billdatetime']);
                        $areaid = $value['areaid'];
                        $date = $billdatetime[0];

                        $time = explode(":", $billdatetime[1])[0]; //hr mode

                        if (!array_key_exists($areaid, $billdatetimedata)) {
                            $billdatetimedata[$areaid] = [];
                        }
                        if (!array_key_exists($date, $billdatetimedata[$areaid])) {
                            $billdatetimedata[$areaid][$date] = [];
                        }
                        if (!array_key_exists($time, $billdatetimedata[$areaid][$date])) {
                            $billdatetimedata[$areaid][$date][$time] = 0;
                        }
                        $billdatetimedata[$areaid][$date][$time] += $value['amount'];
                    }


                    //echo $sql;
                    $result = [];
                    $result['values'] = $billdatetimedata;
                    $result['kotdetails'] = $kotdetails;

                    return $result;
                }
            }
        }
        return 0;
    }

    public function getposareagroupkotdetails($postdetails)
    {
        $areaid = $postdetails['areaid'];
        $fromdate = '"' . $postdetails['fromdate'] . '"';
        $todate = '"' . $postdetails['todate'] . '"';
        $propid = $postdetails['propid'];
        $cmpid = $postdetails['cmpid'];
        $groupmode = $postdetails['groupmode'];
        if ($propid && $fromdate && $todate) {
            $databasename = 'rasp_bkg';
            $asql = '';
            if ($areaid) {
                $asql = ' AND ' . $databasename . '.tbl_pos_billheader.areaid IN (' . $areaid . ') ';
            }
            if ($groupmode == 1) {
                if ($databasename) {
                    $sql = "SELECT
                " . $databasename . ".tbl_pos_kotitems.kotitmtrnid,
                " . $databasename . ".tbl_pos_kotitems.propid,
                " . $databasename . ".tbl_pos_kotitems.billid,
                " . $databasename . ".tbl_pos_kotitems.kottrnid,
                " . $databasename . ".tbl_pos_kotitems.itemid,
                " . $databasename . ".tbl_pos_kotitems.itemname,
                " . $databasename . ".tbl_pos_itemgroup.grpid,
                " . $databasename . ".tbl_pos_itemgroup.grpname,
                " . $databasename . ".tbl_pos_kotitems.chargeid,
                " . $databasename . ".tbl_pos_kotitems.qty,
                " . $databasename . ".tbl_pos_kotitems.amount,
                " . $databasename . ".tbl_pos_kotitems.rate,
                " . $databasename . ".tbl_pos_kotitems.cankottrnid,
                " . $databasename . ".tbl_pos_kotitems.added_date,
                " . $databasename . ".tbl_pos_billheader.billcancelled,
                " . $databasename . ".tbl_pos_billheader.billpayhdrid,
                " . $databasename . ".tbl_pos_area.areaid,
                " . $databasename . ".tbl_pos_area.areaname,
                " . $databasename . ".property_master.propid,
                " . $databasename . ".property_master.propname,
                " . $databasename . ".property_master.propcity
                FROM
                " . $databasename . ".tbl_pos_kotitems
                INNER JOIN " . $databasename . ".tbl_pos_kotheader ON " . $databasename . ".tbl_pos_kotheader.kottrnid = " . $databasename . ".tbl_pos_kotitems.kottrnid
                INNER JOIN " . $databasename . ".tbl_pos_area ON " . $databasename . ".tbl_pos_area.areaid = " . $databasename . ".tbl_pos_kotheader.areaid
                INNER JOIN " . $databasename . ".tbl_pos_items ON " . $databasename . ".tbl_pos_items.itmid = " . $databasename . ".tbl_pos_kotitems.itemid
                INNER JOIN " . $databasename . ".tbl_pos_itemgroup ON " . $databasename . ".tbl_pos_items.grpid = " . $databasename . ".tbl_pos_itemgroup.grpid
                INNER JOIN " . $databasename . ".tbl_pos_billheader ON " . $databasename . ".tbl_pos_billheader.billtrnid = " . $databasename . ".tbl_pos_kotitems.billid
                INNER JOIN " . $databasename . ".tbl_pos_billpay_header ON " . $databasename . ".tbl_pos_billheader.billpayhdrid = " . $databasename . ".tbl_pos_billpay_header.billpayhdrid
                INNER JOIN " . $databasename . ".tbl_pos_billpay_trans ON " . $databasename . ".tbl_pos_billpay_header.billpayhdrid = " . $databasename . ".tbl_pos_billpay_trans.billpayhdrid
                INNER JOIN " . $databasename . ".property_master ON " . $databasename . ".property_master.propid = " . $databasename . ".tbl_pos_billheader.propid
                WHERE
                    date(
                        " . $databasename . ".tbl_pos_billheader.billdatetime
                    ) BETWEEN " . $fromdate . "
                AND " . $todate . "
                AND " . $databasename . ".tbl_pos_billheader.ncbill = 0
                " . $asql . "
                AND " . $databasename . ".property_master.propid = " . $propid . "
                AND " . $databasename . ".property_master.cmpid = " . $cmpid . "
                ORDER BY
                " . $databasename . ".tbl_pos_itemgroup.grpid";
                    $query = $this->db->query($sql);
                    $data = $query->result_array();

                    //echo $sql;

                    $result = $settledetails = $areadetails = $propdetails = $itemdetails = [];
                    $result['details'] = $result['values'] = [];
                    //$itemdetails['cancel'] = [];
                    //$itemdetails['nocancel'] = [];

                    foreach ($data as $values) {
                        if (!array_key_exists($values['areaid'], $itemdetails)) {
                            $itemdetails[$values['areaid']] = [];
                            $itemdetails[$values['areaid']]['cancel'] = [];
                            $itemdetails[$values['areaid']]['nocancel'] = [];
                        }
                        if ($values['billcancelled'] || $values['cankottrnid']) {
                            array_push($itemdetails[$values['areaid']]['cancel'], $values);
                            $propdetails['propname'] = $values['propname'];
                            $propdetails['propcity'] = $values['propcity'];
                        } else {
                            array_push($itemdetails[$values['areaid']]['nocancel'], $values);
                            $propdetails['propname'] = $values['propname'];
                            $propdetails['propcity'] = $values['propcity'];
                        }
                    }

                    $areasql = 'select * from ' . $databasename . '.tbl_pos_area where ' . $databasename . '.tbl_pos_area.propid = ' . $propid . ' and ' . $databasename . '.tbl_pos_area.ispos = 1 and ' . $databasename . '.tbl_pos_area.cmpid = ' . $cmpid;
                    //echo $propsql;
                    $areaquery = $this->db->query($areasql);
                    $areadata = $areaquery->result_array();

                    foreach ($areadata as $value) {
                        $areadetails[$value['areaid']] = $value['areaname'];
                    }

                    $settlesql = 'select * from ' . $databasename . '.tbl_pos_settlementmaster where ' . $databasename . '.tbl_pos_settlementmaster.propid = ' . $propid;
                    //echo $propsql;
                    $settlequery = $this->db->query($settlesql);
                    $settledata = $settlequery->result_array();

                    foreach ($settledata as $value) {
                        $settledetails[$value['settleid']] = $value['settletype'];
                    }

                    // echo "<pre>";
                    // print_r($itemdetails);
                    // echo "</pre>";

                    $result['details']['settledetails'] = $settledetails;
                    $result['details']['propdetails'] = $propdetails;
                    $result['details']['areadetails'] = $areadetails;
                    $result['details']['postdetails'] = $postdetails;
                    $result['values'] = $itemdetails;

                    // echo "<pre>";
                    // print_r($result);
                    // echo "</pre>";

                    return $result;
                }
            } else {
                if ($databasename) {
                    $sql = "SELECT
                " . $databasename . ".tbl_pos_kotitems.kotitmtrnid,
                " . $databasename . ".tbl_pos_kotitems.propid,
                " . $databasename . ".tbl_pos_kotitems.billid,
                " . $databasename . ".tbl_pos_kotitems.kottrnid,
                " . $databasename . ".tbl_pos_kotitems.itemid,
                " . $databasename . ".tbl_pos_kotitems.itemname,
                " . $databasename . ".tbl_pos_kotitems.chargeid,
                " . $databasename . ".tbl_pos_kotitems.qty,
                " . $databasename . ".tbl_pos_kotitems.amount,
                " . $databasename . ".tbl_pos_kotitems.rate,
                " . $databasename . ".tbl_pos_kotitems.cankottrnid,
                " . $databasename . ".tbl_pos_kotitems.added_date,
                " . $databasename . ".tbl_pos_billheader.billcancelled,
                " . $databasename . ".tbl_pos_billheader.billpayhdrid,
                " . $databasename . ".tbl_pos_area.areaid,
                " . $databasename . ".tbl_pos_area.areaname,
                " . $databasename . ".property_master.propid,
                " . $databasename . ".property_master.propname,
                " . $databasename . ".property_master.propcity
                FROM
                " . $databasename . ".tbl_pos_kotitems
                INNER JOIN " . $databasename . ".tbl_pos_kotheader ON " . $databasename . ".tbl_pos_kotheader.kottrnid = " . $databasename . ".tbl_pos_kotitems.kottrnid
                INNER JOIN " . $databasename . ".tbl_pos_area ON " . $databasename . ".tbl_pos_area.areaid = " . $databasename . ".tbl_pos_kotheader.areaid
                INNER JOIN " . $databasename . ".tbl_pos_items ON " . $databasename . ".tbl_pos_items.itmid = " . $databasename . ".tbl_pos_kotitems.itemid
                INNER JOIN " . $databasename . ".tbl_pos_billheader ON " . $databasename . ".tbl_pos_billheader.billtrnid = " . $databasename . ".tbl_pos_kotitems.billid
                INNER JOIN " . $databasename . ".tbl_pos_billpay_header ON " . $databasename . ".tbl_pos_billheader.billpayhdrid = " . $databasename . ".tbl_pos_billpay_header.billpayhdrid
                INNER JOIN " . $databasename . ".tbl_pos_billpay_trans ON " . $databasename . ".tbl_pos_billpay_header.billpayhdrid = " . $databasename . ".tbl_pos_billpay_trans.billpayhdrid
                INNER JOIN " . $databasename . ".property_master ON " . $databasename . ".property_master.propid = " . $databasename . ".tbl_pos_billheader.propid
                WHERE
                    date(
                        " . $databasename . ".tbl_pos_billheader.billdatetime
                    )BETWEEN " . $fromdate . "
                AND " . $todate . "
                AND " . $databasename . ".tbl_pos_billheader.ncbill = 0
                " . $asql . "
                AND " . $databasename . ".property_master.propid = " . $propid . "
                AND " . $databasename . ".property_master.cmpid = " . $cmpid . "
                ORDER BY
                " . $databasename . ".tbl_pos_kotitems.kotitmtrnid";
                    $query = $this->db->query($sql);
                    $data = $query->result_array();

                    //echo $sql;

                    $result = $settledetails = $areadetails = $propdetails = $itemdetails = [];
                    $result['details'] = $result['values'] = [];
                    //$itemdetails['cancel'] = [];
                    //$itemdetails['nocancel'] = [];

                    foreach ($data as $values) {
                        if (!array_key_exists($values['areaid'], $itemdetails)) {
                            $itemdetails[$values['areaid']] = [];
                            $itemdetails[$values['areaid']]['cancel'] = [];
                            $itemdetails[$values['areaid']]['nocancel'] = [];
                        }
                        if ($values['billcancelled'] || $values['cankottrnid']) {
                            array_push($itemdetails[$values['areaid']]['cancel'], $values);
                            $propdetails['propname'] = $values['propname'];
                            $propdetails['propcity'] = $values['propcity'];
                        } else {
                            array_push($itemdetails[$values['areaid']]['nocancel'], $values);
                            $propdetails['propname'] = $values['propname'];
                            $propdetails['propcity'] = $values['propcity'];
                        }
                    }

                    $areasql = 'select * from ' . $databasename . '.tbl_pos_area where ' . $databasename . '.tbl_pos_area.propid = ' . $propid . ' and ' . $databasename . '.tbl_pos_area.ispos = 1 and ' . $databasename . '.tbl_pos_area.cmpid = ' . $cmpid;
                    //echo $propsql;
                    $areaquery = $this->db->query($areasql);
                    $areadata = $areaquery->result_array();

                    foreach ($areadata as $value) {
                        $areadetails[$value['areaid']] = $value['areaname'];
                    }

                    $settlesql = 'select * from ' . $databasename . '.tbl_pos_settlementmaster where ' . $databasename . '.tbl_pos_settlementmaster.propid = ' . $propid;
                    //echo $propsql;
                    $settlequery = $this->db->query($settlesql);
                    $settledata = $settlequery->result_array();

                    foreach ($settledata as $value) {
                        $settledetails[$value['settleid']] = $value['settletype'];
                    }

                    // echo "<pre>";
                    // print_r($itemdetails);
                    // echo "</pre>";

                    $result['details']['settledetails'] = $settledetails;
                    $result['details']['propdetails'] = $propdetails;
                    $result['details']['areadetails'] = $areadetails;
                    $result['details']['postdetails'] = $postdetails;

                    $result['values'] = $itemdetails;

                    // echo "<pre>";
                    // print_r($result);
                    // echo "</pre>";

                    return $result;
                }
            }
        }
        return 0;
    }

    public function getposareasrvsettlevalues($postdetails)
    {

        $areaid = $postdetails['areaid'];
        $fromdate = '"' . $postdetails['fromdate'] . '"';
        $todate = '"' . $postdetails['todate'] . '"';
        $propid = $postdetails['propid'];
        $cmpid = $postdetails['cmpid'];


        //$areaid = implode(',', $areaid);

        // echo "<pre>";
        // print_r($postdetails);
        // echo "</pre>";

        if ($propid && $fromdate && $todate) {
            //$propdetails = $this->session->userdata('propdetails');
            //$databasename = $propdetails[$propid]['databasename'];
            //$onlinesrvname = "'" . strtolower($onlinesrvname) . "'";

            $databasename = 'rasp_bkg';

            // $asql = '';
            // if (!$areaid) {
            //     $asql = " AND ' . $databasename . '.tbl_pos_billheader.areaid IN (' . $areaid . ')";
            // }

            if ($databasename) {

                $asql = '';
                if ($areaid) {
                    $asql = ' AND ' . $databasename . '.tbl_pos_billheader.areaid IN (' . $areaid . ') ';
                }

                $sql = 'SELECT
                *, sum(st.totamt)AS srvamt
            FROM
                (
                    SELECT
                        *, sum(tt.amount)AS totamt
                    FROM
                        (
                            SELECT
                                ' . $databasename . '.tbl_pos_billpay_trans.paymodeid,
                                ' . $databasename . '.tbl_pos_billpay_trans.amount,
                                ' . $databasename . '.tbl_pos_area.areaid,
                                ' . $databasename . '.tbl_pos_billheader.billtrnid,
                                ' . $databasename . '.tbl_pos_billheader.billno,
                                ' . $databasename . '.tbl_pos_settlementmaster.settletype,
                                ' . $databasename . '.tbl_pos_settlementmaster.settleid,
                                ' . $databasename . '.tbl_pos_area.areaname,
                                ' . $databasename . '.tbl_pos_billheader.srvid,
                                ' . $databasename . '.user_master.username,
                                ' . $databasename . '.tbl_pos_billpay_trans.bankid,
                                ' . $databasename . '.tbl_pos_servicetypemaster.servicetypename,
                                ' . $databasename . '.property_master.propname,
                                ' . $databasename . '.property_master.propcity,
                                ' . $databasename . '.tbl_pos_billheader.billdatetime
                            FROM
                            ' . $databasename . '.tbl_pos_billcharges
                            INNER JOIN ' . $databasename . '.tbl_pos_billheader ON ' . $databasename . '.tbl_pos_billheader.billtrnid = ' . $databasename . '.tbl_pos_billcharges.billtrnid
                            INNER JOIN ' . $databasename . '.tbl_pos_billpay_header ON ' . $databasename . '.tbl_pos_billheader.billpayhdrid = ' . $databasename . '.tbl_pos_billpay_header.billpayhdrid
                            INNER JOIN ' . $databasename . '.tbl_pos_billpay_trans ON ' . $databasename . '.tbl_pos_billpay_header.billpayhdrid = ' . $databasename . '.tbl_pos_billpay_trans.billpayhdrid
                            INNER JOIN ' . $databasename . '.tbl_pos_settlementmaster ON ' . $databasename . '.tbl_pos_billpay_trans.paymodeid = ' . $databasename . '.tbl_pos_settlementmaster.settleid
                            INNER JOIN ' . $databasename . '.tbl_pos_servicetypemaster ON ' . $databasename . '.tbl_pos_servicetypemaster.servicetypeid = ' . $databasename . '.tbl_pos_billheader.srvid
                            INNER JOIN ' . $databasename . '.user_master ON ' . $databasename . '.tbl_pos_billheader.added_userid = ' . $databasename . '.user_master.userid
                            INNER JOIN ' . $databasename . '.tbl_pos_area ON ' . $databasename . '.tbl_pos_billheader.areaid = ' . $databasename . '.tbl_pos_area.areaid
                            INNER JOIN ' . $databasename . '.property_master ON ' . $databasename . '.property_master.propid = ' . $databasename . '.tbl_pos_billheader.propid
                            WHERE
                                date(
                                    ' . $databasename . '. tbl_pos_billheader.billdatetime
                                )BETWEEN ' . $fromdate . '
                            AND ' . $todate . '
                            AND ' . $databasename . '.tbl_pos_billheader.propid = ' . $propid . '
                            AND ' . $databasename . '.property_master.cmpid = ' . $cmpid . '
                            ' . $asql . '
                            AND ' . $databasename . '.tbl_pos_billheader.billcancelled = 0
                            AND ' . $databasename . '.tbl_pos_billheader.billpayhdrid != ""
                            AND ' . $databasename . '.tbl_pos_billheader.ncbill = 0
                            GROUP BY
                            ' . $databasename . '.tbl_pos_billheader.areaid,
                            ' . $databasename . '.tbl_pos_billheader.srvid,
                            ' . $databasename . '.tbl_pos_billpay_trans.billpaytrnid
                            ORDER BY
                            ' . $databasename . '.tbl_pos_billheader.billtrnid
                        )AS tt
                    GROUP BY
                        tt.areaid,
                        tt.srvid,
                        tt.billtrnid,
                        tt.settleid
                )AS st
            GROUP BY
            st.areaid,
            st.srvid,
            st.settleid';
                //st.settleid
                //echo $sql;
                $query = $this->db->query($sql);
                $data = $query->result_array();


                $asql = '';
                if ($areaid) {
                    $asql = ' AND ' . $databasename . '.tbl_pos_billheader.areaid IN (' . $areaid . ') ';
                }

                $sql = 'SELECT
                    ' . $databasename . '.tbl_pos_billpay_trans.paymodeid,
                    ' . $databasename . '.tbl_pos_billpay_trans.amount,
                    ' . $databasename . '.tbl_pos_area.areaid,
                    ' . $databasename . '.tbl_pos_billheader.billtrnid,
                    ' . $databasename . '.tbl_pos_billheader.billno,
                    ' . $databasename . '.tbl_pos_settlementmaster.settletype,
                    ' . $databasename . '.tbl_pos_settlementmaster.settleid,
                    ' . $databasename . '.tbl_pos_area.areaname,
                    ' . $databasename . '.tbl_pos_billheader.srvid,
                    ' . $databasename . '.user_master.username,
                    ' . $databasename . '.tbl_pos_billpay_trans.bankid,
                    ' . $databasename . '.tbl_pos_servicetypemaster.servicetypename,
                    ' . $databasename . '.property_master.propname,
                    ' . $databasename . '.property_master.propcity,
                    ' . $databasename . '.tbl_pos_billheader.billdatetime
                FROM
                ' . $databasename . '.tbl_pos_billcharges
                INNER JOIN ' . $databasename . '.tbl_pos_billheader ON ' . $databasename . '.tbl_pos_billheader.billtrnid = ' . $databasename . '.tbl_pos_billcharges.billtrnid
                INNER JOIN ' . $databasename . '.tbl_pos_billpay_header ON ' . $databasename . '.tbl_pos_billheader.billpayhdrid = ' . $databasename . '.tbl_pos_billpay_header.billpayhdrid
                INNER JOIN ' . $databasename . '.tbl_pos_billpay_trans ON ' . $databasename . '.tbl_pos_billpay_header.billpayhdrid = ' . $databasename . '.tbl_pos_billpay_trans.billpayhdrid
                INNER JOIN ' . $databasename . '.tbl_pos_settlementmaster ON ' . $databasename . '.tbl_pos_billpay_trans.paymodeid = ' . $databasename . '.tbl_pos_settlementmaster.settleid
                INNER JOIN ' . $databasename . '.tbl_pos_servicetypemaster ON ' . $databasename . '.tbl_pos_servicetypemaster.servicetypeid = ' . $databasename . '.tbl_pos_billheader.srvid
                INNER JOIN ' . $databasename . '.user_master ON ' . $databasename . '.tbl_pos_billheader.added_userid = ' . $databasename . '.user_master.userid
                INNER JOIN ' . $databasename . '.tbl_pos_area ON ' . $databasename . '.tbl_pos_billheader.areaid = ' . $databasename . '.tbl_pos_area.areaid
                INNER JOIN ' . $databasename . '.property_master ON ' . $databasename . '.property_master.propid = ' . $databasename . '.tbl_pos_billheader.propid
                WHERE
                    date(
                        ' . $databasename . '. tbl_pos_billheader.billdatetime
                    )BETWEEN ' . $fromdate . '
                AND ' . $todate . '
                AND ' . $databasename . '.tbl_pos_billheader.propid = ' . $propid . '
                AND ' . $databasename . '.property_master.cmpid = ' . $cmpid . '
                ' . $asql . '
                AND ' . $databasename . '.tbl_pos_billheader.billcancelled = 0
                AND ' . $databasename . '.tbl_pos_billheader.billpayhdrid != ""
                AND ' . $databasename . '.tbl_pos_billheader.ncbill = 0
                GROUP BY
                ' . $databasename . '.tbl_pos_billheader.billtrnid,
                ' . $databasename . '.tbl_pos_billpay_trans.paymodeid,
                ' . $databasename . '.tbl_pos_billpay_trans.bankid
                ORDER BY
                ' . $databasename . '.tbl_pos_billheader.billtrnid';
                //st.settleid
                //echo $sql;
                $query = $this->db->query($sql);
                $datetimedata = $query->result_array();

                $billdatetimedata = [];
                foreach ($datetimedata as $value) {
                    $billdatetime = explode(" ", $value['billdatetime']);
                    $areaid = $value['areaid'];
                    $date = $billdatetime[0];

                    $time = explode(":", $billdatetime[1])[0]; //hr mode

                    if (!array_key_exists($areaid, $billdatetimedata)) {
                        $billdatetimedata[$areaid] = [];
                    }
                    if (!array_key_exists($date, $billdatetimedata[$areaid])) {
                        $billdatetimedata[$areaid][$date] = [];
                    }
                    if (!array_key_exists($time, $billdatetimedata[$areaid][$date])) {
                        $billdatetimedata[$areaid][$date][$time] = 0;
                    }
                    $billdatetimedata[$areaid][$date][$time] += $value['amount'];
                }

                // echo "<pre>";
                // print_r($billdatetimedata);
                // echo "</pre>";


                $propsql = 'select * from ' . $databasename . '.property_master where ' . $databasename . '.property_master.propid = ' . $propid . ' and ' . $databasename . '.property_master.cmpid = ' . $cmpid;
                //echo $propsql;
                $propquery = $this->db->query($propsql);
                $propdata = $propquery->result_array();

                $propdetails = [];

                foreach ($propdata as $value) {
                    $propdetails['propname'] = $value['propname'];
                    $propdetails['propcity'] = $value['propcity'];
                }

                $servicesql = 'select * from ' . $databasename . '.tbl_pos_servicetypemaster where ' . $databasename . '.tbl_pos_servicetypemaster.propid = ' . $propid . ' and ' . $databasename . '.tbl_pos_servicetypemaster.servicests = 1';
                //echo $propsql;
                $servicequery = $this->db->query($servicesql);
                $servicedata = $servicequery->result_array();

                $servicevalues = [];

                foreach ($servicedata as $value) {
                    $servicedetails = [];
                    $servicedetails['servicetypename'] = $value['servicetypename'];
                    $servicedetails['servicetype'] = $value['servicetype'];
                    $servicedetails['servicetypeid'] = $value['servicetypeid'];
                    $servicevalues[$value['servicetypeid']] = $servicedetails;
                }


                $areasql = 'select * from ' . $databasename . '.tbl_pos_area where ' . $databasename . '.tbl_pos_area.propid = ' . $propid . ' and ' . $databasename . '.tbl_pos_area.ispos = 1 and ' . $databasename . '.tbl_pos_area.cmpid = ' . $cmpid;
                //echo $propsql;
                $areaquery = $this->db->query($areasql);
                $areadata = $areaquery->result_array();

                $areadetails = [];

                foreach ($areadata as $value) {
                    $areadetails[$value['areaid']] = $value['areaname'];
                }

                $settlesql = 'select * from ' . $databasename . '.tbl_pos_settlementmaster where ' . $databasename . '.tbl_pos_settlementmaster.propid = ' . $propid;
                //echo $propsql;
                $settlequery = $this->db->query($settlesql);
                $settledata = $settlequery->result_array();

                $settledetails = [];

                foreach ($settledata as $value) {
                    $settledetails[$value['settleid']] = $value['settletype'];
                }

                $result = $settlevalues = $srvdetails = [];

                foreach ($data as $key => $value) {
                    $areaid = $value['areaid'];
                    $srvid = $value['srvid'];
                    $settleid = $value['settleid'];
                    $srvamt = $value['srvamt'];
                    //$settledetails[$settleid] = $value['settletype'];
                    $srvdetails[$srvid] = $value['servicetypename'];
                    $settlevalues[$areaid][$srvid][$settleid] = $srvamt;
                }

                $areaamounts = $settleamounts = $srvamounts = [];

                foreach ($settlevalues as $areaid => $areavalues) {
                    foreach ($areavalues as $srvid => $srvvalues) {
                        foreach ($srvvalues as $settleid => $amt) {

                            if (!array_key_exists($areaid, $settleamounts)) {
                                $settleamounts[$areaid] = [];
                            }
                            if (!array_key_exists($settleid, $settleamounts[$areaid])) {
                                $settleamounts[$areaid][$settleid] = 0;
                            }
                            $settleamounts[$areaid][$settleid] += $amt;

                            if (!array_key_exists($areaid, $srvamounts)) {
                                $srvamounts[$areaid] = [];
                            }
                            if (!array_key_exists($srvid, $srvamounts[$areaid])) {
                                $srvamounts[$areaid][$srvid] = 0;
                            }

                            $srvamounts[$areaid][$srvid] += $amt;

                            if (!array_key_exists($areaid, $areaamounts)) {
                                $areaamounts[$areaid] = 0;
                            }
                            $areaamounts[$areaid] += $amt;
                        }
                    }
                }

                $result['values'] = [];

                foreach ($areadata as $value) {
                    if (!array_key_exists($value['areaid'], $result['values'])) {
                        $result['values'][$value['areaid']] = [];
                    }

                    if (!array_key_exists($value['areaid'], $srvamounts)) {
                        $result['values'][$value['areaid']]['servicevalues'] = 0;
                    } else {
                        $result['values'][$value['areaid']]['servicevalues'] = $srvamounts[$value['areaid']];
                    }

                    if (!array_key_exists($value['areaid'], $settleamounts)) {
                        $result['values'][$value['areaid']]['settlevalues'] = 0;
                    } else {
                        $result['values'][$value['areaid']]['settlevalues'] = $settleamounts[$value['areaid']];
                    }

                    if (!array_key_exists($value['areaid'], $areaamounts)) {
                        $result['values'][$value['areaid']]['areavalues'] = 0;
                    } else {
                        $result['values'][$value['areaid']]['areavalues'] = $areaamounts[$value['areaid']];
                    }
                }

                // $result['values']['servicevalues'] = $srvamounts;
                // $result['values']['settlevalues'] = $settleamounts;
                // $result['values']['areavalues'] = $areaamounts;


                $result['details']['srvdetails'] = $servicevalues;
                $result['details']['settledetails'] = $settledetails;

                $result['details']['propdetails'] = $propdetails;
                $result['details']['areadetails'] = $areadetails;
                $result['details']['postdetails'] = $postdetails;

                $result['datetimevalues'] = $billdatetimedata;



                return $result;
            }
        }
        return 0;
    }





    //-----------------------------------------------------------------------------------------------------------------------------
}
