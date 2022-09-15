<?php

class Alertsmodel extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        //$this->load->database();
        $this->connectdatabase();
    }

    public function connectdatabase()
    {        
        $data['logindetails'] = $this->session->userdata('logindetails');
        $dbserverip = $dbserveruserid = $dbserverpwd = $databasename = "";
        $dbserverip = $data['logindetails']['dbserverip'];
        $dbserveruserid = $data['logindetails']['dbserveruserid'];
        $dbserverpwd = $data['logindetails']['dbserverpwd'];
        $databasename = $data['logindetails']['databasename'];
        
        if($dbserverip != "" && $dbserveruserid !="" && $dbserverpwd !="" && $databasename !="")
        {
            $dbchange = $this->loaddatabase($dbserveruserid,$dbserverpwd,$dbserverip,$databasename);
            $this->db=$this->load->database($dbchange,true);
        }
        /*$name = $this->house->getdbname();
        echo "<pre>";
        print_r($name);
        echo "</pre>";*/
    }
    public function loaddatabase($userid="",$password="",$hostname="",$dbname="")
    {
        if(($userid!="")&&($password!="")&&($hostname!="")&&($dbname!=""))
        {
            $dsn = 'mysqli://'.$userid.':'.$password.'@'.$hostname.'/'.$dbname;            
            //$this->load->database($dsn,true);            
            //return $dsn;
            return $dsn;
        }
        else
        {
            //$this->load->database();
            return 'raspmaster';
        }
    }
    
    function getpropdbname () {
        $propid = $this->session->userdata('singlepropid');
        $propdetails = $this->session->userdata('propdetails');
        $dbname = '';
        foreach($propdetails as $key => $pdetail) {
            if($key==$propid) {
                $dbname=$pdetail['databasename'];
            }
        }
        return $dbname;
    }
    
    function getalertsresult($alertsresultfilter)
    {
        
        $dbname = $this->getpropdbname();
        
        $psql = $alertsresultfilter['propid']==0 ? '' : " AND ".$dbname.".tbl_gen_alert_trans.propid = ".$alertsresultfilter["propid"];
        $msql = $alertsresultfilter['mode']==2 ? " AND ".$dbname.".tbl_gen_alert_trans.status in (0,1)" : " AND ".$dbname.".tbl_gen_alert_trans.status = ".$alertsresultfilter["mode"];

        $sql = 'SELECT
        '.$dbname.'.tbl_gen_alert_trans.alerttrnid,
        '.$dbname.'.tbl_gen_alert_trans.cmpid,
        '.$dbname.'.tbl_gen_alert_trans.propid,
        '.$dbname.'.tbl_gen_alert_trans.alertid,
        '.$dbname.'.tbl_gen_alert_trans.userid,
        '.$dbname.'.tbl_gen_alert_trans.`status`,
        '.$dbname.'.tbl_gen_alert_header.messagedetails,
        '.$dbname.'.tbl_gen_alert_trans.alertdate,
        '.$dbname.'.tbl_gen_alert_trans.readdate,
        '.$dbname.'.tbl_gen_alert_header.alerthtrnid,
        '.$dbname.'.tbl_gen_alert_master.alertname,
        '.$dbname.'.tbl_gen_alert_master.alertmod,
        '.$dbname.'.tbl_gen_alert_master.authid,
        '.$dbname.'. module_list.modulename
        FROM
        '.$dbname.'.tbl_gen_alert_trans
        INNER JOIN '.$dbname.'.tbl_gen_alert_header ON '.$dbname.'.tbl_gen_alert_header.alertid = '.$dbname.'.tbl_gen_alert_trans.alertid
        INNER JOIN '.$dbname.'.tbl_gen_alert_master ON '.$dbname.'.tbl_gen_alert_master.alertid = '.$dbname.'.tbl_gen_alert_header.alertid
        INNER JOIN '.$dbname.'.module_list ON '.$dbname.'.tbl_gen_alert_master.alertmod = '.$dbname.'.module_list.modid
        WHERE
        '.$dbname.'.tbl_gen_alert_trans.userid = '.$alertsresultfilter["userid"].'
        AND '.$dbname.'.tbl_gen_alert_trans.cmpid = '.$alertsresultfilter["cmpid"].$psql.$msql;
        //echo $sql;
        $query = $this->db->query($sql);
        $result = $query->result_array();
        return $result;
    }

    function alertsprocess($data)
    {
        $alertdatavals = $data['alertdatavals'];
        $processmode = $data['processmode'];
        $nowdt = "'".date('Y-m-d H:i:s')."'";
        $dbname = $this->getpropdbname();
        if($processmode==1 || $processmode==2) {
            $alerttrnids = [];
            $alerttrnidsbysts = [];
            foreach($alertdatavals as $alertdataval) {
                array_push($alerttrnids,$alertdataval['alerttrnid']);
                $status = $alertdataval['status'];
                if(!array_key_exists($status,$alerttrnidsbysts))
                {
                    $alerttrnidsbysts[$status] = [];
                }
                array_push($alerttrnidsbysts[$status],$alertdataval['alerttrnid']);
            }
            $alerttrnids = implode(",",$alerttrnids);
            if($processmode==1) {
                if(array_key_exists(0,$alerttrnidsbysts)) {
                    $alerttrnids = $alerttrnidsbysts[0];
                    if(count($alerttrnids)) {
                        $alerttrnids = implode(",",$alerttrnids);
                        $sql = 'UPDATE '.$dbname.'.tbl_gen_alert_trans
                        SET '.$dbname.'.tbl_gen_alert_trans.`status` = '.$processmode.','.$dbname.'.tbl_gen_alert_trans.readdate = '.$nowdt.'
                        WHERE
                        '.$dbname.'.tbl_gen_alert_trans.alerttrnid IN ('.$alerttrnids.')';
                        $query = $this->db->query($sql);
                    }
                }
                else {
                    $query = 1;
                }                
            }
            else if($processmode==2) {
                $sql = 'UPDATE '.$dbname.'.tbl_gen_alert_trans
                SET '.$dbname.'.tbl_gen_alert_trans.`status` = '.$processmode.'
                WHERE
                '.$dbname.'.tbl_gen_alert_trans.alerttrnid IN ('.$alerttrnids.')';
                $query = $this->db->query($sql);
            }
            
            if($query) {
                $psql = $data['propid']==0 ? '' : " AND ".$dbname.".tbl_gen_alert_trans.propid = ".$data["propid"];
                $msql = 1 ? " AND ".$dbname.".tbl_gen_alert_trans.status in (0,1)" : " AND ".$dbname.".tbl_gen_alert_trans.status = ".$data["mode"];
                $sql = 'SELECT
                '.$dbname.'.tbl_gen_alert_trans.alerttrnid,
                '.$dbname.'.tbl_gen_alert_trans.cmpid,
                '.$dbname.'.tbl_gen_alert_trans.propid,
                '.$dbname.'.tbl_gen_alert_trans.alertid,
                '.$dbname.'.tbl_gen_alert_trans.userid,
                '.$dbname.'.tbl_gen_alert_trans.`status`,
                '.$dbname.'.tbl_gen_alert_header.messagedetails,
                '.$dbname.'.tbl_gen_alert_trans.alertdate,
                '.$dbname.'.tbl_gen_alert_trans.readdate,
                '.$dbname.'.tbl_gen_alert_header.alerthtrnid,
                '.$dbname.'.tbl_gen_alert_master.alertname,
                '.$dbname.'.tbl_gen_alert_master.alertmod,
                '.$dbname.'.tbl_gen_alert_master.authid,
                '.$dbname.'.module_list.modulename
                FROM
                '.$dbname.'.tbl_gen_alert_trans
                INNER JOIN '.$dbname.'.tbl_gen_alert_header ON '.$dbname.'.tbl_gen_alert_header.alertid = '.$dbname.'.tbl_gen_alert_trans.alertid
                INNER JOIN '.$dbname.'.tbl_gen_alert_master ON '.$dbname.'.tbl_gen_alert_master.alertid = '.$dbname.'.tbl_gen_alert_header.alertid
                INNER JOIN '.$dbname.'.module_list ON '.$dbname.'.tbl_gen_alert_master.alertmod = '.$dbname.'.module_list.modid
                WHERE
                '.$dbname.'.tbl_gen_alert_trans.userid = '.$data["userid"].'
                AND '.$dbname.'.tbl_gen_alert_trans.cmpid = '.$data["cmpid"].$psql.$msql;
                $query = $this->db->query($sql);
                $result = $query->result_array();
                return $result;
            }
            return 0;
        }
    }

    function getauthcount($data)
	{

		$propid = $data['propid'];
		$cmpid = $data['cmpid'];
		$userid = $data['userid'];

		$dbname = $this->getpropdbname();

		$authtransresult = $authmainresult = $authresult = [];

		$sql = 'SELECT
		'.$dbname.'.tbl_gen_auth_req_header.authstatus,
		'.$dbname.'.tbl_gen_auth_req_header.authreasonid,
		'.$dbname.'.tbl_gen_auth_req_header.authremark,
		'.$dbname.'.tbl_gen_auth_req_header.authcheckinroomtrnid,
		'.$dbname.'.tbl_gen_auth_req_header.authdatetime,
		'.$dbname.'.tbl_gen_auth_req_header.authtypeid,
		'.$dbname.'.tbl_gen_auth_req_header.authreqrollno,
		'.$dbname.'.tbl_gen_auth_req_header.authreqtrnid,
		'.$dbname.'.tbl_gen_auth_req_header.authreqoldvalue as messagedetails,
		'.$dbname.'.tbl_gen_auth_req_user_trans.authtrnid,
		'.$dbname.'.tbl_gen_auth_req_user_trans.authmode,
		'.$dbname.'.tbl_gen_auth_req_user_trans.authusertrnid,
		'.$dbname.'.tbl_gen_auth_req_user_trans.authuserid,
		'.$dbname.'.tbl_gen_auth_req_user_trans.authstatus as authstatustype,
		'.$dbname.'.tbl_gen_auth_req_user_trans.authreadsts,
		'.$dbname.'.tbl_gen_auth_req_user_trans.authreaddatetime,
		'.$dbname.'.tbl_gen_authorization_master.module,
		'.$dbname.'.tbl_gen_authorization_master.authmode as authmodetype,
		'.$dbname.'.tbl_gen_authorization_master.authname,
		'.$dbname.'.tbl_gen_authorization_master.authtype,
		'.$dbname.'.tbl_gen_authorization_master.cmpid,
		'.$dbname.'.tbl_gen_authorization_master.propid,
		'.$dbname.'.tbl_gen_authorization_master.requiredauthby,
		'.$dbname.'.tbl_gen_authorization_master.verificationby,
		'.$dbname.'.tbl_gen_authorization_users.authvaltrnid,
		'.$dbname.'.tbl_gen_authorization_valuesauth.authstartvalue,
		'.$dbname.'.tbl_gen_authorization_valuesauth.authendvalue,
		'.$dbname.'.tbl_gen_authorization_valuesauth.verificationby as value_verificationby,
		'.$dbname.'.tbl_gen_authorization_valuesauth.verifiuserid as value_verifiuserid,
		'.$dbname.'.tbl_gen_authorization_valuesauth.verifigroupid as value_verifigroupid,
		'.$dbname.'.tbl_gen_authorization_valuesauth.requiredauthby as value_requiredauthby,
		'.$dbname.'.user_master.username as requestusername,
		'.$dbname.'.module_list.modulename
		FROM
		'.$dbname.'.tbl_gen_auth_req_user_trans
		INNER JOIN '.$dbname.'.tbl_gen_auth_req_header ON '.$dbname.'.tbl_gen_auth_req_header.authreqtrnid = '.$dbname.'.tbl_gen_auth_req_user_trans.authtrnid
		INNER JOIN '.$dbname.'.user_master ON '.$dbname.'.tbl_gen_auth_req_header.authrequserid = '.$dbname.'.user_master.userid
		LEFT JOIN '.$dbname.'.tbl_gen_authorization_master ON '.$dbname.'.tbl_gen_auth_req_header.authtypeid = '.$dbname.'.tbl_gen_authorization_master.authtrnid
		LEFT JOIN '.$dbname.'.tbl_gen_authorization_users ON '.$dbname.'.tbl_gen_authorization_users.authid = '.$dbname.'.tbl_gen_authorization_master.authtrnid
		LEFT JOIN '.$dbname.'.tbl_gen_authorization_valuesauth ON '.$dbname.'.tbl_gen_authorization_valuesauth.authvaltrnid = '.$dbname.'.tbl_gen_authorization_users.authvaltrnid
		INNER JOIN '.$dbname.'.module_list ON '.$dbname.'.tbl_gen_authorization_master.module = '.$dbname.'.module_list.modid
		WHERE
		'.$dbname.'.tbl_gen_authorization_master.cmpid = ' . $cmpid . '
		AND	'.$dbname.'.tbl_gen_authorization_master.propid = ' . $propid . '
		AND '.$dbname.'.tbl_gen_auth_req_user_trans.authuserid = ' . $userid;

		//echo $sql;

		$query = $this->db->query($sql);
		$result = $query->result_array();

		if ($result) {

			$authreqtrnids = [];

			foreach ($result as $values) {
				array_push($authreqtrnids, $values['authreqtrnid']);
				$authmainresult[$values['authreqtrnid']] = $values;
			}

			$authreqtrnids = array_unique($authreqtrnids);

			$sql = 'SELECT
			'.$dbname.'.tbl_gen_auth_req_user_trans.authusertrnid,
			'.$dbname.'.tbl_gen_auth_req_user_trans.authtrnid,
			'.$dbname.'.tbl_gen_auth_req_user_trans.authmode,
			'.$dbname.'.tbl_gen_auth_req_user_trans.authuserid,
			'.$dbname.'.tbl_gen_auth_req_user_trans.authstatus as authstatustype,
			'.$dbname.'.tbl_gen_auth_req_user_trans.authreadsts,
			'.$dbname.'.tbl_gen_auth_req_user_trans.authreaddatetime,
			'.$dbname.'.tbl_gen_auth_req_user_trans.authdatetime,
			'.$dbname.'.tbl_gen_authorization_master.requiredauthby,
			'.$dbname.'.tbl_gen_authorization_master.verificationby,
			'.$dbname.'.user_master.username
			from '.$dbname.'.tbl_gen_auth_req_user_trans 
			INNER JOIN '.$dbname.'.tbl_gen_auth_req_header ON '.$dbname.'.tbl_gen_auth_req_header.authreqtrnid = '.$dbname.'.tbl_gen_auth_req_user_trans.authtrnid
			INNER JOIN '.$dbname.'.tbl_gen_authorization_master ON '.$dbname.'.tbl_gen_authorization_master.authtrnid = '.$dbname.'.tbl_gen_auth_req_header.authtypeid
			left JOIN '.$dbname.'.user_master ON '.$dbname.'.tbl_gen_auth_req_user_trans.authuserid = '.$dbname.'.user_master.userid
			where
			'.$dbname.'.tbl_gen_authorization_master.cmpid = ' . $cmpid . '
			AND	'.$dbname.'.tbl_gen_authorization_master.propid = ' . $propid . ' 
			AND '.$dbname.'.tbl_gen_auth_req_user_trans.authtrnid in (' . implode(",", $authreqtrnids) . ')';

			//echo $sql;

			$query = $this->db->query($sql);
			$result = $query->result_array();

			foreach ($result as $values) {

				$authtrnid = $values['authtrnid'];
				//$authusertrnid = $values['authusertrnid'];
				$authmode = $values['authmode'];

				if (!array_key_exists($authtrnid, $authtransresult)) {
					$authtransresult[$authtrnid] = [];
					$authtransresult[$authtrnid]['verifiyer'] = [];
					$authtransresult[$authtrnid]['authuser'] = [];
				}

				array_push($authtransresult[$authtrnid][strtolower($authmode)], $values);
			}
		}

		$authresult['authmainresult'] = $authmainresult;

		$authresult['authtransresult'] = $authtransresult;

		/*echo '<pre>';
		print_r($authmainresult);
		echo '</pre>';
		
		echo '<pre>';
		print_r($authtransresult);
		echo '</pre>';*/

		return $authresult;
	}
}
