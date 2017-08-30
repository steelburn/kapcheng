#!/usr/bin/php
<?php
/* Configuration list:- */
$rulefile = "/root/bin/rules.lst";
/* End of configuration */

/* Do not edit this initialization part. Use rule file instead. */
$temp = array();
$defaultpage = '';
$logfile = '';
$defaultblockreason = 'Blocked.';
$ttl = -1;	/* Defaults to not dying. -1:Don't die. 0:Always die. */
$timeformat = "Ymd G:i:s";

//-------- normal part -------------
$redirect = array();
$block = array();
$blockip = array();
$blockrange = array();
$exclude = array();
$excludeip = array();
$excluderange = array();
$replace = array();
$replacedomain = array();

//-------- captive part ------------
$authpage = '';
$authcheck = '';
$authlogout = '';
$authsuccess = 'Authenticated';
$authfail = 'Not authenticated';

#authrequired commands:
$authrequired_config = 'no';
#expected parameter: yes | no | select
$authrequired_ip = array();
#expected parameter: <ip_address>
$authrequired_iprange = array();

/* End init */
openlog('kapcheng',LOG_PID,LOG_LOCAL6);
syslog(LOG_INFO,date($timeformat)." - Starting up!");

$rules = split("\n",file_get_contents($rulefile));
$linenumber = 0;
$starttime = time();
$errortext = "Error at line (%d): %s. Line has been ignored.\n";

foreach ($rules as $rule) {
	$linenumber++;
	$rule = trim($rule);
	if ((strlen(trim($rule))>0) & (substr($rule,0,1) != '#')) {
		$temp = split(' ',$rule,3);
		switch ($temp[0]) {
			#config:
			case 'defaultpage': $defaultpage = $temp[1]; break;
			case 'ttl': $ttl = $temp[1]; break;
			case 'logfile': $logfile = $temp[1]; break;
				
			#captive:
			case 'authpage': $authpage = $temp[1]; break;
			case 'authcheck': $authcheck = $temp[1]; break;
			case 'authlogout': $authlogout = $temp[1]; break;
			case 'authsuccess': $authsuccess = $temp[1]; break;
			case 'authfail': $authfail = $temp[1]; break;
			case 'authrequired':
				switch ($temp[1]) {
					case 'config': $authrequired_config = strtolower(trim($temp[2])); break;
					case 'ip': if (strlen($temp[2])>=8) { $authrequired_ip[] = trim($temp[2]); }; break;
					case 'iprange': if (strlen($temp[2])>=15) { $authrequired_iprange[] = trim($temp[2]); }; break;
				} //end switch ($temp[1]);
				break;
			#filtering:
			case 'redirect':
				if ((strlen($temp[1])>0) & (strlen($temp[2])>0)) {
					$redirect[] = array($temp[1],$temp[2]);
					syslog(LOG_DEBUG,sprintf("%s","Redirect: ".count($redirect)));
				} else {
					syslog(LOG_WARNING,sprintf($errortext,$linenumber,"Incomplete redirection."));
				}
				break;
                        case 'block':
                                if (strlen($temp[1])>0) {
					if (strlen($temp[2])>0) {
                                        	$block[] = array($temp[1],$temp[2]);
					} else {
						$block[] = array($temp[1],$defaultblockreason);
					}
                                } else {
                                        syslog(LOG_WARNING,sprintf($errortext,$linenumber,"Keyword to block not provided."));
                                }
				break;
                        case 'blockip':
                                if (strlen($temp[1])>0) {
                                        if (strlen($temp[2])>0) {
                                                $blockip[] = array($temp[1],$temp[2]);
                                        } else {
                                                $blockip[] = array($temp[1],$defaultblockreason);
                                        }
                                } else {
                                        syslog(LOG_WARNING,sprintf($errortext,$linenumber,"IP address to block not provided."));
                                }
				break;
                        case 'blockrange':
                                if (strlen($temp[1])>0) {
                                        if (strlen($temp[2])>0) {
                                                $blockrange[] = array($temp[1],$temp[2]);
                                        } else {
                                                $blockrange[] = array($temp[1],$defaultblockreason);
                                        }
                                } else {
                                        syslog(LOG_WARNING,sprintf($errortext,$linenumber,"IP range to block not provided."));
                                }
				break;
                        case 'exclude':
                                if (strlen($temp[1])>0) {
                                                $exclude[] = $temp[1];
                                } else {
                                        syslog(LOG_WARNING,sprintf($errortext,$linenumber,"Keyword to exclude not provided."));
                                }
				break;
                        case 'excludeip':
                                if (strlen($temp[1])>=8) {
                                                $excludeip[] = $temp[1];
                                } else {
                                        syslog(LOG_WARNING,sprintf($errortext,$linenumber,"IP address to exclude not provided."));
                                }
				break;
                        case 'excluderange':
                                if (strlen($temp[1])>=17) {
                                                $excluderange[] = $temp[1];
                                } else {
                                        syslog(LOG_WARNING,sprintf($errortext,$linenumber,"IP range to exclude not provided."));
                                }
				break;
                        case 'replace':
                                if ((strlen($temp[1])>0) & (strlen($temp[2])>0)) {
                                                $replace[] = array($temp[1],$temp[2]);
                                } else {
                                        syslog(LOG_WARNING,sprintf($errortext,$linenumber,"Incorrect replace parameter."));
                                }
				break;
                        case 'replacedomain':
                                if ((strlen($temp[1])>0) & (strlen($temp[2])>0)) {
                                                $replacedomain[] = array($temp[1],$temp[2]);
                                } else {
                                        syslog(LOG_WARNING,sprintf($errortext,$linenumber,"Incorrect replacedomain parameter."));
                                }
				break;
			default:
				syslog(LOG_WARNING,sprintf($errortext,$linenumber,"Unknown syntax."));
		}
	} else { $remarks++; };		
} /*endif*/

/* Print out some report:  */
	syslog(LOG_DEBUG,sprintf("---------------------------------\n"));
	syslog(LOG_DEBUG,sprintf("		DefaultPage: %s\n",$defaultpage));
	syslog(LOG_DEBUG,sprintf("		LogFile: %s\n",$logfile));
	syslog(LOG_DEBUG,sprintf("---------------------------------\n"));
	syslog(LOG_DEBUG,sprintf("		AuthPage: %s\n",$authpage));
	syslog(LOG_DEBUG,sprintf("		AuthCheck: %s\n",$authcheck));
	syslog(LOG_DEBUG,sprintf("		AuthSuccess: %s\n",$authsuccess));
	syslog(LOG_DEBUG,sprintf("		AuthFail: %s\n",$authfail));
	syslog(LOG_DEBUG,sprintf("---------------------------------\n"));
	syslog(LOG_DEBUG,sprintf("		Redirect: %d\n",count($redirect)));
	syslog(LOG_DEBUG,sprintf("		Block: %d\n",count($block)));
	syslog(LOG_DEBUG,sprintf("		BlockIP: %d\n",count($blockip)));
	syslog(LOG_DEBUG,sprintf("		BlockRange: %d\n",count($blockrange)));
	syslog(LOG_DEBUG,sprintf("		Exclude: %d\n",count($exclude)));
	syslog(LOG_DEBUG,sprintf("		ExcludeIP: %d\n",count($excludeip)));
	syslog(LOG_DEBUG,sprintf("		ExcludeRange: %d\n",count($excludeip)));
	syslog(LOG_DEBUG,sprintf("		Replace: %d\n",count($replace)));
	syslog(LOG_DEBUG,sprintf("		ReplaceDomain: %d\n",count($replacedomain)));
	syslog(LOG_DEBUG,sprintf("		Remarks: %d\n",$remarks));

while ( $input = fgets(STDIN) ) {
	syslog(LOG_DEBUG,sprintf("%s %s",date($timestamp),$input));
	$found = 0;
	$temp = split(' ',$input);
	$output = $temp[0]."\n";
	$ori_output = $output;
	$source = trim($temp[1]);
	$sourceip_temp = split('/',$source,2);
	$sourceip = $sourceip_temp[0];
	$sourcename = $sourceip_temp[1];
	$longip = ip2long($sourceip);
	syslog(LOG_DEBUG,sprintf("URL: %s | Source: %s\n",trim($output),$source));

	
/***************************/
/*   WEB FILTERING   (part 1) */
/***************************/
/* 1 - Exclusion codes */
	/* Exclude by IP */
	if ((count($excludeip)>0) and ($found==0)) {
		foreach ($excludeip as $check) {
			if ( (strpos($source,$check)!==false) or (strpos($output,$check)!==false) ) {
				$found = 1;
				syslog(LOG_INFO,sprintf("%s Exclusion by IP to %s by %s (match %s).",date($timeformat), trim($output),$source,$check));
                break;
			} /* endif */
		} /* end foreach */
	} /* endif count($excludeip) */
	/* End excludeIP codes */

/* End exclusion part */

/*********************/
/*   CAPTIVE PORTAL  */
/*********************/

if ($authrequired_config == 'select') {
	$check = 0;
	/* Check range */
	foreach ($authrequired_iprange as $range) {
		list($ipbegin,$ipend) = split('-',$range,2);
		$ipbegin = sprintf("%u",ip2long($ipbegin));
		$ipend =  sprintf("%u",ip2long($ipend));
		$ipchk = sprintf("%u",$longip);
		if ( $ipchk <= $ipend and $ipchk >= $ipbegin) { 
			$check = 1; 
			syslog(LOG_DEBUG,sprintf("%s Range matched: %u (%s) < %u (%s) < %u (%s)\n",date($timeformat),$ipbegin,long2ip($ipbegin),$longip,long2ip($longip),$ipend,long2ip($ipend)));
			} else { 
			syslog(LOG_DEBUG,printf("%s Range check: %u (%s) < %u (%s) < %u (%s)\n",date($timeformat),$ipbegin,long2ip($ipbegin),$longip,long2ip($longip),$ipend,long2ip($ipend))); 
			};
		}
	/* Check individual IPs */
	foreach ($authrequired_ip as $ip) {
		if ( $longip == ip2long($ip) ) { $check = 1; break;};
		}
	} elseif ($authrequired_config == 'yes') { $check = 1; };

/* Check and get authenticated */	
if ($check == 1)
	{
		if (strpos($ori_output,$authlogout)!==false) {
			syslog(LOG_INFO,sprintf("%s Logged out %u (%s)\n",date($timeformat),$longip,long2ip($longip)));
			$output = $ori_output;
			} else {
			syslog(LOG_DEBUG,sprintf("%s Trying to check access for %u (%s/%s)",date($timeformat), $longip, long2ip($longip),$sourcename));
			$chkurl = sprintf("%s?src=%u",$authcheck,$longip);
			$htpointer = fopen($chkurl,'r');
			$authresult = fread($htpointer,8192);
			syslog(LOG_DEBUG,sprintf(" - Check result: %s\n",$authresult));
			fclose($htpointer);
			if (trim($authresult)!='Authenticated') { 
				$output = sprintf("%s?src=%u&url=%s&msg=%s\n",$authpage,$longip,trim($ori_output),$authresult); 
				syslog(LOG_WARNING,sprintf("User not authenticated. Sent to: %s (Msg: %s)\n",trim($output),$authresult));
				$found = 1; 
				if (( strpos($ori_output,$authpage)!==false) 
						or (strpos($ori_output,$authcheck)!==false) 
						or (strpos($ori_output,$authlogout)!==false)) 
					{ 
					$output = $ori_output; 
					$found = 1; 
					syslog(LOG_DEBUG,sprintf("Checking from authentication page... %s\n",trim($ori_output)));
					};
				} else { 
					$found = 0; 
					syslog(LOG_DEBUG,sprintf("Authenticated: %s\n",$authresult));
				};
			};
	} //endif ($check == 1)



/***************************/
/*   WEB FILTERING (part 2) */
/**************************/

/* 2 - Replacement codes */
	/* No blocking, just replace keyword found */
	if ((count($replace)>0) and ($found==0)) {
		$ori_output = $output;
		foreach ($replace as $check) {
			$output = str_replace($check[0],$check[1],$output);
		} /*end foreach*/
		if ($ori_output != $output) syslog(LOG_INFO,sprintf("%s Replacement: %s -> %s\n",date($timeformat),trim($ori_output),trim($output)));
	} /*endif*/
/* End replacement part */

/* 3 - Blocking codes */
        /* Block by keyword: */
        if ((count($block)>0) & ($found==0)) {
		foreach ($block as $check) {
			if (strpos($output,$check[0])) {
					$found = 1;
					if (strlen($check[1])>0) {$blockreason = urlencode($check[1]);} 
					else {$blockreason = urlencode($defaultblockreason); };
					$output = sprintf($defaultpage,$blockreason)."\n";
					if ($found==1) syslog(LOG_INFO,sprintf("%s Blocked: %s => %s\n",date($timeformat),trim($input), $blockreason));
					break;	
				} /*endif*/
		} /* end foreach */
        } /* endif count($block) */
	/* Block by IP */
	if ((count($blockip)>0) & ($found==0)) {
		foreach ($blockip as $check) {
			if ( (strpos($source,$check[0])!==false) or (strpos($output,$check[0])!==false) ) {
				$found = 1;
                if (strlen($check[1])>0) {$blockreason = urlencode($check[1]);}
                else {$blockreason = urlencode($defaultblockreason); };
                $output = sprintf($defaultpage,$blockreason)."\n";
				syslog(LOG_INFO,sprintf("%s Access to %s was blocked due to blockIP matching %s. (%s)",date($timeformat), trim($input),$source,$blockreason));
                break;
			} /* endif */
		} /* end foreach */
	} /* endif count($blockip) */
	/* End blockIP codes */
/* End blocking part */

/* 4 - Redirection codes */
        /* Redirect: */
        if ((count($redirect)>0) & ($found==0)) {
		foreach ($redirect as $check) {
			if (strpos($output,$check[0])) {
				$found = 1;
				$output = $check[1]."\n";
				break;
			} /*endif*/
		} /* end foreach */
        } /* endif count($redirect) */
/* End redirection part */
	

	#----------------------
	echo $output;

/* TTL check */
if ($ttl == 0) {
	exit(0);
} elseif ($ttl == -1) {
	/* Do nothing. We're not dying here. */
} else {
	$tnow = time();
	if (($tnow-$starttime)>=$ttl) {
		exit(0);
	} /*end if*/
} /*end if */

}

closelog();
?>