<?php

class Testmodel extends CI_Model
{
    public function getpropname($cmpid, $propid)
    {
        $sql = "select propname from property_master where cmpid=" . $cmpid . " and propid=" . $propid . "";
        $query = $this->db->query($sql);
        return $query->result_array();
    }
    public function getdata()
    {

        $db = $this->db->query("select *,sum(st.totamt) as srvamt from
		 (select *,sum(tt.amount) as totamt from
		 (SELECT
			 tbl_pos_billpay_trans.paymodeid,
			 tbl_pos_billpay_trans.amount,
			 tbl_pos_area.areaid,
			 tbl_pos_billheader.billtrnid,
			 tbl_pos_billheader.billno,
			 tbl_pos_settlementmaster.settletype,
			 tbl_pos_settlementmaster.settleid,
			 tbl_pos_area.areaname,
			 tbl_pos_billheader.srvid,
			 user_master.username,
		 tbl_pos_billpay_trans.bankid,
			 tbl_pos_servicetypemaster.servicetypename,
			 tbl_pos_billheader.billdatetime
		 FROM
			 tbl_pos_billcharges
		 INNER JOIN tbl_pos_billheader ON tbl_pos_billheader.billtrnid = tbl_pos_billcharges.billtrnid
		 INNER JOIN tbl_pos_billpay_header ON tbl_pos_billheader.billpayhdrid = tbl_pos_billpay_header.billpayhdrid
		 INNER JOIN tbl_pos_billpay_trans ON tbl_pos_billpay_header.billpayhdrid = tbl_pos_billpay_trans.billpayhdrid
		 INNER JOIN tbl_pos_settlementmaster ON tbl_pos_billpay_trans.paymodeid = tbl_pos_settlementmaster.settleid
		 INNER JOIN tbl_pos_servicetypemaster ON tbl_pos_servicetypemaster.servicetypeid = tbl_pos_billheader.srvid
		 INNER JOIN user_master ON tbl_pos_billheader.added_userid = user_master.userid
		 INNER JOIN tbl_pos_area ON tbl_pos_billheader.areaid = tbl_pos_area.areaid
		 WHERE
			 date(tbl_pos_billheader.billdatetime) BETWEEN '2022-01-01'
		 AND '2022-01-10'
		 AND tbl_pos_billheader.propid = 13
		 AND tbl_pos_billheader.billcancelled = 0
		 and tbl_pos_settlementmaster.settletype!='Complimentary'
         and tbl_pos_settlementmaster.settletype!='NC'
		 GROUP BY
		 tbl_pos_billheader.areaid,
		 tbl_pos_billheader.srvid,
		 tbl_pos_billpay_trans.billpaytrnid
		 ORDER BY
			 tbl_pos_billheader.billtrnid)as tt
		 GROUP BY
		 tt.areaid,
		 tt.srvid,
		 tt.billtrnid,
		 tt.settleid) as st
		 GROUP BY
		 st.areaid,
		 st.srvid,
		 st.settleid order by field(settleid,'5') desc");
        return $db->result_array();
    }
}
