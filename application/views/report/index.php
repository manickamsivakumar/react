<?php
$curdate=date('Y-m-d');
$prevdate = date("d M Y",strtotime($curdate.'-1 day'));

$pad=3;
$temphead= '<!DOCTYPE html>
<head>
    <title>Report</title>
   
</head>
<body style="font-family:Calibri;color:black">

    <div class="report_card" style="width: 95%;margin: auto;">
    <h2 style="text-align:center;color: #557EC0;">'.$propname.'</h2>
        <div class="report_date"style="background:#93cddd">
           <div style="padding: 5px;"> <h4 style="margin:0px">Day Report : '.$prevdate.'</h4></div>
           
        </div>';
        $footer ='<div style="display:flex;">
    	  <div style="width:50%;text-align:initial;margin-top:30px;">
    	  <span style="font-size: 13px; margin-left:10px;">Powerd By:</span>
		  </div>
          </div>
		  <div style="width:100%;display:flex;">
          <div style="width:100%;"><img src="https://login.skyhms.in/emailer/skylogo.png" alt="" height="50px" width="170px"><br/>
		  </div>
 	      </div>
      	  </body>
    	  </html>';
    $occ_head='<div>
        <table style="width: 100%;border-spacing: 0px;">
                <thead style="background:#dbeef4;height: 32px;">
                    <tr>
                        <th style="width:40%;text-align:left;padding-left: '.$pad.'px">Occupancy</th>
                        <th style="width:30%;text-align:right">Today</th>
                        <th style="width:30%;text-align:right">Month</th>
                    </tr>
                </thead><tbody>';
          $occ_body='';
               $occ_body .=' <tr>
                        <td style="padding-left: '.$pad.'px">Sold Rooms</td>
                        <td style="text-align:right">'.$soldnight.'('.$dsoldper.'%)</td>
                        <td style="text-align:right;padding-right: '.$pad.'px">'.$mnightsold.'('.$msoldper.'%)</td>
                    
                    </tr>';
                    $occ_body .='  <tr>
                        <td style="padding-left: '.$pad.'px">Occupied</td>
                        <td style="text-align:right">'.$occupancy.'</td>
                        <td style="text-align:right;padding-right: '.$pad.'px"></td>
                    
                    </tr>';
                   
                    $occ_body .='  <tr>
                        <td style="padding-left: '.$pad.'px">Checked In</td>
                        <td style="text-align:right">'.$chkin.'</td>
                        <td style="text-align:right;padding-right: '.$pad.'px"></td>
                    
                    </tr>';
                    $occ_body .=' <tr>
                        <td style="padding-left: '.$pad.'px">Checked Out</td>
                        <td style="text-align:right">'.$chkout.'</td>
                        <td style="text-align:right;padding-right: '.$pad.'px"></td>
                    
                    </tr>';
                    $occ_body .='<tr>
                        <td style="padding-left: '.$pad.'px">Arr</td>
                        <td style="text-align:right">'.$darr.'</td>
                        <td style="text-align:right;padding-right: '.$pad.'px">'.$marr.'</td>
                    
                    </tr>';

               $occ_foot=' </tbody>
            </table>
        </div>';
        $occ=$occ_head.$occ_body.$occ_foot;
     $room_sales_head='   <div>
        <table style="width: 100%;border-spacing: 0px;">
                <thead style="background:#c3d69b;height: 32px;">
                    <tr>
                        <th style="width:40%;text-align:left ;padding-left: '.$pad.'px">Room Sales</th>
                        <th style="width:30%;text-align:right">Today</th>
                        <th style="width:30%;text-align:right;padding-right: '.$pad.'px">Month</th>
                    </tr>
                </thead>
                <tbody>';
                $room_sales_body='';
            $room_sales_body.= '   <tr>
                        <td style="padding-left: '.$pad.'px">Rooms</td>
                        <td style="text-align:right">'.$dsales.'</td>
                        <td style="text-align:right;padding-right: '.$pad.'px">'.$msales.'</td>
                    
                    </tr>';
            $room_sales_body.= ' <tr>
                        <td style="padding-left: '.$pad.'px">Extra Pax</td>
                        <td style="text-align:right">'.$d_extrapax.'</td>
                        <td style="text-align:right;padding-right: '.$pad.'px">'.$m_extrapax.'</td>
                    
                    </tr>';
                   
            $room_sales_body.= '<tr>
                        <td style="padding-left: '.$pad.'px">Others</td>
                        <td style="text-align:right">'.$d_others.'</td>
                        <td style="text-align:right;padding-right: '.$pad.'px">'.$m_others.'</td>
                    
                    </tr>';
                    $room_sales_body.= '<tr style="background:#ebf1de">
                        <td style="padding-left: '.$pad.'px"><b>Total</b></td>
                        <td style="text-align:right"><b>'.$d_total.'</b></td>
                        <td style="text-align:right;padding-right: '.$pad.'px"><b>'.$m_total.'</b></td>
                    
                    </tr>';
                   
                    $room_sales_foot = ' </tbody>
            </table>
        </div>';
        $roomsales=$room_sales_head.$room_sales_body.$room_sales_foot;
       $revenue_head=' <div>
        <table style="width: 100%;border-spacing: 0px;">
                <thead style="height: 32px;background:#ccc1da">
                    <tr>
                        <th style="width:40%;text-align:left;padding-left: '.$pad.'px">Revenue</th>
                        <th style="width:30%;text-align:right">Today</th>
                        <th style="width:30%;text-align:right;padding-right: '.$pad.'px">Month</th>
                    </tr>
                </thead>
                <tbody>';
                $revenue_body='';
                if($m_allarea_cash !=0){
               $revenue_body .=' <tr>
                        <td style="padding-left: '.$pad.'px">Cash</td>
                        <td style="text-align:right">'.$d_allarea_cash.'</td>
                        <td style="text-align:right;padding-right: '.$pad.'px">'.$m_allarea_cash.'</td>
                    
                    </tr>';
                }
                if($m_allarea_cc !=0){
                    $revenue_body .='<tr>
                        <td style="padding-left: '.$pad.'px">Card</td>
                        <td style="text-align:right">'.$d_allarea_cc.'</td>
                        <td style="text-align:right;padding-right: '.$pad.'px">'.$m_allarea_cc.'</td>
                    
                    </tr>';
                }
                if($m_allarea_cr !=0){
                    $revenue_body .=' <tr>
                    <td style="padding-left: '.$pad.'px">Credit</td>
                    <td style="text-align:right">'.$d_allarea_cr.'</td>
                    <td style="text-align:right;padding-right: '.$pad.'px">'.$m_allarea_cr.'</td>
                
                </tr>';
                }
                if($m_allarea_comp !=0){
                $revenue_body .=' <tr>
                <td style="padding-left: '.$pad.'px">Complimentory</td>
                <td style="text-align:right">'.$d_allarea_comp.'</td>
                <td style="text-align:right;padding-right: '.$pad.'px">'.$m_allarea_comp.'</td>
            
            </tr>';
                }
                if($m_allarea_rt !=0){
                    $revenue_body .='<tr>
                        <td style="padding-left: '.$pad.'px">Transfer</td>
                        <td style="text-align:right">'.$d_allarea_rt.'</td>
                        <td style="text-align:right;padding-right: '.$pad.'px">'.$m_allarea_rt.'</td>
                    
                    </tr>';
                }
                if($m_allarea_nc !=0){
                    $revenue_body .=' <tr>
                    <td style="padding-left: '.$pad.'px">Complimentory</td>
                    <td style="text-align:right">'.$d_allarea_nc.'</td>
                    <td style="text-align:right;padding-right: '.$pad.'px">'.$m_allarea_nc.'</td>
                
                </tr>';
                    }
                if($m_allarea_upi !=0){
                    $revenue_body .='<tr>
                        <td style="padding-left: '.$pad.'px">UPI</td>
                        <td style="text-align:right">'.$d_allarea_upi.'</td>
                        <td style="text-align:right;padding-right: '.$pad.'px">'.$m_allarea_upi.'</td>
                    
                    </tr>';
                }
                if($m_allarea_pod !=0){
                    $revenue_body .='<tr>
                    <td style="padding-left: '.$pad.'px">POD</td>
                    <td style="text-align:right">'.$d_allarea_pod.'</td>
                    <td style="text-align:right;padding-right: '.$pad.'px">'.$m_allarea_pod.'</td>
                
                </tr>';
                }
                    $revenue_body .=' <tr style="background:#e6e0ec">
                        <td style="padding-left: '.$pad.'px"><b>Total</b></td>
                        <td style="text-align:right"><b>'.number_format($d_allarea_tot,2).'</b></td>
                        <td style="text-align:right;padding-right: '.$pad.'px"><b>'.number_format($m_allarea_tot,2).'</b></td>
                    
                    </tr>';
                   
                    $revenue_foot=' </tbody>
            </table>
        </div>';
        $revenue=$revenue_head.$revenue_body.$revenue_foot;
     
       

  $tempfoot='</div>
</body>';

$html_temp= $temphead.$occ.$roomsales.$revenue.$pos_service.$pos_area_service.$area.$cancel_checkin.$compliment.$currentroom.$gracetime.$discount.$tempfoot.$footer;
echo $html_temp;
return;
// print_r($mail);
$sendgrid_apikey = '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';
// $sendgrid = new SendGrid($sendgrid_apikey);
$url = 'https://api.sendgrid.com/';
$pass = $sendgrid_apikey;
$template_id = '<your_template_id>';
$js = array(
  'sub' => array(':name' => array('Elmer')),
  'filters' => array('templates' => array('settings' => array('enable' => 1, 'template_id' => $template_id)))
);

// $prevdate=date("d M Y",strtotime($curdate.'-1 day'));

$subject=$mail[0]['cronname'];

$from=$mail[0]['mlfrm'];
$to=$mail[0]['mlto'];
$propname=$mail[0]['propname'];
$tomails=explode(",",$to);
	
$length=count($tomails);

$i=0;
foreach ($tomails as $val){
	$tomail=$val;
	//echo $tomail;
	//echo $i;
	if($i>0){
		
	$cc="";
		$bcc="";
	
	}else{
	$cc=$mail[0]['mlcc'];
$bcc=$mail[0]['mlbcc'];	
	
	}
	
	$params = array(
   
	// 'to' => $tomail,
    'to'=>'gopalakrishnand28@gmail.com',
    'toname'    => $propname,
		
    'from'      => $from,
    'fromname'  => "SkyHMS",
		
		// 'cc'	=>$cc,
		// 'bcc'	=>$bcc,
    'subject'   => "Daily Status Report ".$prevdate."",
    //'text'      => "I'm text!"
    'html'      => $html_temp
     //'x-smtpapi' => json_encode($js),
  );
	
	

	//return;
	

  $request =  $url.'api/mail.send.json';
// Generate curl request
  $session = curl_init($request);
// Tell PHP not to use SSLv3 (instead opting for TLS)
 curl_setopt($session, CURLOPT_SSLVERSION, 'CURL_SSLVERSION_TLSv1_2');
 curl_setopt($session, CURLOPT_HTTPHEADER, array('Authorization: Bearer ' . $sendgrid_apikey));
// Tell curl to use HTTP POST
 curl_setopt ($session, CURLOPT_POST, true);
 // Tell curl that this is the body of the POST
 curl_setopt ($session, CURLOPT_POSTFIELDS, $params);
 // Tell curl not to return headers, but do return the response
 curl_setopt($session, CURLOPT_HEADER, false);
 curl_setopt($session, CURLOPT_SSL_VERIFYPEER, false);   
 curl_setopt($session, CURLOPT_RETURNTRANSFER, true);
   // obtain response
   $response = curl_exec($session);
   curl_close($session);
	$i++;
	
	}
	
	




  
  if($response)
  {
    echo 'success';
  }
  else
  {
    echo 'failed';
  }
?>