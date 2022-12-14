<?
#################################################
#        Company developer: ALTASIB
#        Developer: Evgeniy Pedan
#        Site: http://www.altasib.ru
#        E-mail: dev@altasib.ru
#        Copyright (c) 2006-2013 ALTASIB
#################################################
?>
<?
use Bitrix\Main;
class aReview extends aReviewMain
{
    const TABLE_NAME = 'altasib_review';
    const DB_TYPE = 'MYSQL';
        
        Function GetList($order = array("ID"=>"DESC"), $filter = array(), $select = array('*'),$group = array(),$limit = null,$offset = null)
        {
            if(!in_array("CNT",$select))
            {
                $select = array_keys(ALTASIB\Review\ReviewTable::getMap());
                unset($select[array_search("CNT",$select)]);
            }
            return ALTASIB\Review\ReviewTable::getList(array(
                    'select' => $select,
                    'filter' => $filter,
                    'order' => $order,
                    'group'=> $group,
                    'limit' => $limit, //$nav['nPageSize'],
                    'offset' => $offset, //$nav['iNumPage'],
            ));
        }
        
        Function Count($filter = array())
        {
            $ob = ALTASIB\Review\ReviewTable::getList(array(
                    'select' => array("CNT"),
                    'filter' => $filter,
            ));
            $arRes = $ob->fetch();
        return $arRes["CNT"];            
        }
        //count_total
        Function Delete($ID)
        {
            $ID = intVal($ID);
            if ($ID <= 0)
                return false;

            $rs = self::GetByID($ID,array("ID","ELEMENT_ID"));
            if($ar = $rs->fetch())
            {
                //$connection = \Bitrix\Main\Application::getDbConnection();
                //$connection->queryExecute("DELETE FROM altasib_review_vote_to_review WHERE REVIEW_ID = ".$ar["ID"]);
                global $DB;
                $DB->query("DELETE FROM altasib_review_vote_to_review WHERE REVIEW_ID = ".$ar["ID"]);
                $DB->query("DELETE FROM altasib_review_rating2element WHERE ELEMENT_ID = ".$ar["ELEMENT_ID"]);
                $GLOBALS["USER_FIELD_MANAGER"]->Delete("ALTASIB_REVIEW", $ID);
				if (CModule::IncludeModule("search") && COption::GetOptionString("altasib.review","indexing","Y")=="Y")
					CSearch::DeleteIndex("altasib.review", $ID);
                //ALTASIB\Review\ReviewTable::delete(array("ID"=>$ar["ID"]));
                $DB->query("DELETE FROM altasib_review WHERE ID = ".$ar["ID"]);
                aReviewFile::Delete($ID);   
            self::ClearCache($ar["ELEMENT_ID"]);
            }
        return true;
        }
        
        Function DeleteAll($ELEMENT_ID)
        {
                global $DB;
                $ELEMENT_ID = intVal($ELEMENT_ID);
                if ($ELEMENT_ID <= 0)
                                return false;

                $rs = self::GetList(Array(), Array("ELEMENT_ID" => $ELEMENT_ID),Array("ID"));
                while($ar = $rs->Fetch())
                {
                        self::Delete($ar["ID"]);
                }
        return true;
        }
                        
        //user
        Function GetUserList($order = array("ID"=>"DESC"), $filter = array(), $select = array('*'),$group = Array(),$limit = null,$offset = null)
        {
            return ALTASIB\Review\UserTable::getList(array(
                    'select' => $select,
                    'filter' => $filter,
                    'order' => $order,
                    'group'=> $group,
                    'limit' => $limit, //$nav['nPageSize'],
                    'offset' => $offset //$nav['iNumPage'],
            ));            
        }
        
        Function GetUserByID($USER_ID, $select = array('*'))
        {
            return ALTASIB\Review\UserTable::getList(array(
                    'select' => $select,
                    'filter' => Array("USER_ID"=>$USER_ID)
            ));            
        }
        
        Function AddUser($arFields)
        {
            //bug in core
            //return ALTASIB\Review\UserTable::add($arFields);
            global $DB;

            if(is_set($arFields, "ALLOW_POST") && $arFields["ALLOW_POST"]!="Y")
                            $arFields["ALLOW_POST"]="N";            
            if(is_set($arFields, "MODERATE_POST") && $arFields["MODERATE_POST"]!="Y")
                            $arFields["MODERATE_POST"]="N";
            
            if((int)$arFields["USER_ID"]==0)
                return false;
            
            $arInsert = $DB->PrepareInsert("altasib_review_user", $arFields, "altasib.review");
            $strSql = "INSERT INTO altasib_review_user(".$arInsert[0].") VALUES(".$arInsert[1].")";
            $DB->Query($strSql);
        return $DB->LastID();
        }
        
        Function UpdateUser($ID,$arFields)
        {
            //bug in core
            //return ALTASIB\Review\UserTable::update($ID, $arFields);
            
            global $DB;
            $ID = (int)$ID;
            if($ID==0)
                return false;
                
            if(is_set($arFields, "ALLOW_POST") && $arFields["ALLOW_POST"]!="Y")
                            $arFields["ALLOW_POST"]="N";            
            if(is_set($arFields, "MODERATE_POST") && $arFields["MODERATE_POST"]!="Y")
                            $arFields["MODERATE_POST"]="N";
            
            if(is_set($arFields, "USER_ID") && (int)$arFields["USER_ID"]==0)
                return false;
            
			$strUpdate = $DB->PrepareUpdate("altasib_review_user", $arFields, "altasib.review");
			$strSql = "UPDATE altasib_review_user SET ".$strUpdate." WHERE ID = ".$ID;
		return $DB->Query($strSql, false, "FILE: ".__FILE__."<br> LINE: ".__LINE__);
        }
        
        Function GetAvatar($USER_ID,$TYPE = false,$arSize = Array())
        {
            $USER_ID = (int)$USER_ID; 
            if($USER_ID==0)
                return false;
            
            if($arUser = CUser::GetByID($USER_ID)->Fetch())
            {							
                    $arRes = Array();
                    if(!$TYPE || $TYPE=="user")
                    {
                            $TYPE = "user";
                            if((int)$arUser["PERSONAL_PHOTO"]>0)
                                    $arRes["USER"]["AVATAR_ID"] = $arUser["PERSONAL_PHOTO"];
                    }

                    if(CModule::IncludeModule("forum") && (!$TYPE || $TYPE=="forum"))
                    {
                            if($arForumUser = CForumUser::GetByUSER_ID($USER_ID))
                            {
                                    if((int)$arForumUser["AVATAR"]>0)
                                            $arRes["FORUM"]["AVATAR_ID"] = $arForumUser["AVATAR"];
                            }
                    }

                    if(CModule::IncludeModule("blog") && (!$TYPE || $TYPE=="blog"))
                    {
                            if($arBlogUser = CBlogUser::GetByID($USER_ID, BLOG_BY_USER_ID))
                            {
                                    if((int)$arBlogUser["AVATAR"]>0)
                                            $arRes["BLOG"]["AVATAR_ID"] = $arBlogUser["AVATAR"];
                            }
                    }

                    if(count($arRes)>0)
                    {
                            foreach($arRes as $k=>$arID)
                            {
                                if(!isset($arSize) || $arSize["width"] == 0 || $arSize["height"] == 0)
                                    $arSize = Array("width"=>80,"height"=>80);

                                    $arImg = CFile::ResizeImageGet($arID["AVATAR_ID"], $arSize, BX_RESIZE_IMAGE_PROPORTIONAL);
                                    $arRes[$k]["SRC"] = $arImg["src"];
                            }
                            if($TYPE)
                            {
                                    return $arRes[strtoupper($TYPE)]["SRC"];
                            }
                            return $arRes;
                    }
                    else
                            return false;
            }
            else
                    return false;
        }        
        
        
        Function Add($arFields)
        {
            global $DB,$APPLICATION,$USER;

            if(is_set($arFields, "SUBSCRIBE") && $arFields["SUBSCRIBE"]!="Y")
                $arFields["SUBSCRIBE"]="N";

            if(is_set($arFields, "APPROVED") && $arFields["APPROVED"]!="Y")
                $arFields["APPROVED"]="N";

            if(is_set($arFields, "DELETED") && $arFields["DELETED"]!="Y")
                $arFields["DELETED"]="N";

            if(!isset($arFields["AUTHOR_IP"]) || empty($arFields["AUTHOR_IP"]))
                $arFields["AUTHOR_IP"] = $_SERVER["REMOTE_ADDR"];
            
    		if (!is_set($arFields, "POST_DATE"))
    			$arFields["POST_DATE"] = date("d.m.Y H:i:s");
            
            if(!isset($arFields["SITE_ID"]))
                    $arFields["SITE_ID"] = SITE_ID;
            
            $db_events = GetModuleEvents("altasib.review", "OnBeforeCommentAdd");
            while($arEvent = $db_events->Fetch())
            {
                    if(ExecuteModuleEventEx($arEvent, array(&$arFields))===false)
                    {
                        $ex = $APPLICATION->GetException();
                        $arFields["RESULT_MESSAGE"] = $ex->GetString();
                    return false;
                    }
            }
            
            if(!$this->CheckFields($arFields))
            {
                    $Result = false;
                    $arFields["RESULT_MESSAGE"] = &$this->LAST_ERROR;
            }
            elseif(!$GLOBALS["USER_FIELD_MANAGER"]->CheckFields("ALTASIB_REVIEW", 0, $arFields))
            {
    			$Result = false;
    			$err = $APPLICATION->GetException();
    			if(is_object($err))
    				$this->LAST_ERROR .= str_replace("<br><br>", "<br>", $err->GetString()."<br>");
    			$arFields["RESULT_MESSAGE"] = &$this->LAST_ERROR;                
            }
            else
            {
                $arAllowTags = aReview::GetAllowTags();
                $parser = new aReviewTextParser();
                $parser->parser_nofollow = COption::GetOptionString("altasib.review","ninf","Y")=="Y" ? 'Y' : "N";
                $arFields["MESSAGE_HTML"] = $parser->convert($arFields["MESSAGE"], $arAllowTags);
                $arFields["MESSAGE_PLUS_HTML"] = $parser->convert($arFields["MESSAGE_PLUS"], $arAllowTags);
                $arFields["MESSAGE_MINUS_HTML"] = $parser->convert($arFields["MESSAGE_MINUS"], $arAllowTags);
                $arFields["REPLY_HTML"] = $parser->convert($arFields["REPLY"], $arAllowTags);

                $arInsert = $DB->PrepareInsert("altasib_review", $arFields, "altasib.review");
                $strSql = "INSERT INTO altasib_review(".$arInsert[0].") VALUES(".$arInsert[1].")";
                $DB->Query($strSql);
                $Result = $DB->LastID();
                
				if($Result>0)
				{
				    $GLOBALS["USER_FIELD_MANAGER"]->Update("ALTASIB_REVIEW", $Result, $arFields);
				    self::SetRating($arFields["ELEMENT_ID"]);
					foreach($arFields["FILES"] as $FILE_ID)
					{
						$arFileFields = Array(
								"REVIEW_ID" => $Result,
								"FILE_ID" => $FILE_ID,
								"USER_ID" => $arFields["USER_ID"],
								"ELEMENT_ID"=>$arFields["ELEMENT_ID"],
						);
						$arFileInsert = $DB->PrepareInsert("altasib_review_file", $arFileFields, "altasib.review");
						$strSql = "INSERT INTO altasib_review_file(".$arFileInsert[0].") VALUES(".$arFileInsert[1].")";
						$DB->Query($strSql);
					}
                    
                    //subs
                    if($arFields["SUBSCRIBE"]=="Y")
                    {
                        $sub = new aReviewSubs();
                        $res = $sub->Add($arFields["ELEMENT_ID"],($USER->IsAuthorized() ? $USER->GetEmail() : $arFields["AUTHOR_EMAIL"]));
                    }
                    
    				//indexing
    				aReview::Index($Result,$arFields);
    
                    if($arFields["APPROVED"]=="Y")
                    {
                        aReview::SendSubsEmail($Result);
                    }
                    self::ClearCache($arFields["ELEMENT_ID"]);
				}
            }
        return $Result;                
        }
        
        Function Update($ID,$arFields)
        {
                global $DB,$APPLICATION;
                
                $ID = (int)$ID;
                if($ID==0)
                    return false;
                
                if(is_set($arFields, "APPROVED") && $arFields["APPROVED"]!="Y")
                                $arFields["APPROVED"]="N";

                if(!$this->CheckFields($arFields))
                {
                        $Result = false;
                        $arFields["RESULT_MESSAGE"] = &$this->LAST_ERROR;
                }
                elseif(!$GLOBALS["USER_FIELD_MANAGER"]->CheckFields("ALTASIB_REVIEW", 0, $arFields))
                {
        			$Result = false;
        			$err = $APPLICATION->GetException();
        			if(is_object($err))
        				$this->LAST_ERROR .= str_replace("<br><br>", "<br>", $err->GetString()."<br>");
        			$arFields["RESULT_MESSAGE"] = &$this->LAST_ERROR;                
                }
                else
                {
						if(array_key_exists("MESSAGE", $arFields) 
                        || array_key_exists("MESSAGE_PLUS", $arFields) 
                        || array_key_exists("MESSAGE_MINUS", $arFields)
                        || array_key_exists("REPLY", $arFields))
						{
								$arAllowTags = aReview::GetAllowTags();
								$parser = new aReviewTextParser();
								$parser->parser_nofollow = COption::GetOptionString("altasib.review","ninf","Y")=="Y" ? 'Y' : "N";
						}
						if(array_key_exists("MESSAGE", $arFields))
						{
								$arFields["MESSAGE_HTML"] = $parser->convert($arFields["MESSAGE"], $arAllowTags);
						}
						if(array_key_exists("MESSAGE_PLUS", $arFields))
						{
								$arFields["MESSAGE_PLUS_HTML"] = $parser->convert($arFields["MESSAGE_PLUS"], $arAllowTags);
						}
						if(array_key_exists("MESSAGE_MINUS", $arFields))
						{
								$arFields["MESSAGE_MINUS_HTML"] = $parser->convert($arFields["MESSAGE_MINUS"], $arAllowTags);
						}
						if(array_key_exists("REPLY", $arFields))
						{
								$arFields["REPLY_HTML"] = $parser->convert($arFields["REPLY"], $arAllowTags);
						}
                        		
						$strUpdate = $DB->PrepareUpdate("altasib_review", $arFields, "altasib.review");
						$strSql = "UPDATE altasib_review SET ".$strUpdate." WHERE ID = ".$ID;
						$Result = $DB->Query($strSql, false, "FILE: ".__FILE__."<br> LINE: ".__LINE__);
						
                        $GLOBALS["USER_FIELD_MANAGER"]->Update("ALTASIB_REVIEW", $ID, $arFields);
                        
                        $allow_upload_file = COption::GetOptionString("altasib.review","allow_upload_file","N")=="N" ? false : true;
                        if($Result && count($arFields["FILES"])>0)
                        {
                                $arFields["ELEMENT_ID"] = (int)$arFields["ELEMENT_ID"]>0 ? $arFields["ELEMENT_ID"] : self::GetElementIdById($ID);
                                $arFields["USER_ID"] = (int)$arFields["USER_ID"]>0 ? $arFields["USER_ID"] : 0; //bug
            					foreach($arFields["FILES"] as $FILE_ID)
            					{
            						$arFileFields = Array(
            								"REVIEW_ID" => $Result,
            								"FILE_ID" => $FILE_ID,
            								"USER_ID" => $arFields["USER_ID"],
            								"ELEMENT_ID"=>$arFields["ELEMENT_ID"],
            						);
            						$arFileInsert = $DB->PrepareInsert("altasib_review_file", $arFileFields, "altasib.review");
            						$strSql = "INSERT INTO altasib_review_file(".$arFileInsert[0].") VALUES(".$arFileInsert[1].")";
            						$DB->Query($strSql);
            					}       
                        }
						self::Index($ID,$arFields,true);
                        self::ClearCache(self::GetElementIdById($ID));				
                }
        return $Result;
        }
                
        Function GetApproved($ID)
        {
                $ID = (int)$ID;
                if($ID==0)
                        return false;

				$obReview = aReview::GetByID($ID,Array("APPROVED"));
				if($arRes = $obReview->Fetch())
				{
						return $arRes["APPROVED"] == "Y" ? true : false;
				}
        return null;
        }

		Function SetApproved($ID,$app = true)
		{
                global $DB;

                $ID = (int)$ID;
                if($ID==0)
                        return false;
				
				$CommentApproved = aReview::GetApproved($ID);
				if(is_null($CommentApproved))
						return false;
				
                if(!isset($app))
                {
                        $app = $CommentApproved===true ? false : true;
                }
				if($app == true && $CommentApproved == true)
						return true;
				
				if($app == false && $CommentApproved == false)
						return true;
				
				$set = $app == true ? "Y" : "N";
				$strSql = "UPDATE altasib_review SET APPROVED='".$set."' WHERE ID=".$ID;
				$DB->Query($strSql);
                
                $arReview = self::GetByID($ID,array('USER_ID'))->fetch();
                if($arReview['USER_ID']>0)
                {
                    $cnt = self::Count(array("USER_ID"=>$arReview['USER_ID']));
                    $tcnt = COption::GetOptionInt('altasib.review','transfer',5);
                    if($cnt>$tcnt)
                    {
                		$arAltasibReviewFields["ALLOW_POST"] = "Y";
                        $arAltasibReviewFields["MODERATE_POST"] = 'N';
                        
                    	$ob_res = aReview::GetUserByID($arReview['USER_ID'], Array("ID"));
                    	if ($ar_res=$ob_res->fetch())
                    	{
                    		aReview::UpdateUser($ar_res["ID"], $arAltasibReviewFields);
                    	}
                        else
                    	{
                    		$arAltasibReviewFields["USER_ID"] = $ID;
                            aReview::AddUser($arAltasibReviewFields);
                    	}                        
                    }
                }
                
				self::ReIndex($ID);
                self::ClearCache(self::GetElementIdById($ID));				
                if($app == true)
                {
                    if(!aReview::IsSend($ID))
                        aReview::SendSubsEmail($ID);
                }
		return true;
		}

        Function IsSend($ID)
        {
            global $DB;
            $ID = (int)$ID;
            if($ID==0)
                            return false;

            $strSql = "SELECT IS_SEND from altasib_review where ID=".$ID;
            $res = $DB->Query($strSql);
            $arRes = $res->Fetch();
        return $arRes["IS_SEND"] == "Y" ? true : false;
        }

        Function SetSend($ID)
        {
            global $DB;
            $ID = (int)$ID;
            if($ID==0)
                return false;

            $strSql = "UPDATE altasib_review SET IS_SEND='Y' WHERE ID=".$ID;
            $DB->Query($strSql);
        return true;
        }                                
        //old    


        Function Vote($ID,$plus = true)
        {
                global $DB,$USER,$APPLICATION;
                $ID = (int)$ID;
                if($ID==0)
                        return false;

                $strSql = "UPDATE altasib_review SET ".($plus ? 'VOTE_PLUS' : 'VOTE_MINUS')." = ".($plus ? 'VOTE_PLUS' : 'VOTE_MINUS')." +1 WHERE ID=".$ID;
                $res = $DB->Query($strSql, false, "FILE: ".__FILE__."<br> LINE: ".__LINE__);

                $sess = (COption::GetOptionString("altasib.review","VOTE_SESION","N")=="Y");
                $cookie = (COption::GetOptionString("altasib.review","VOTE_COOKIE","N")=="Y");
                $ip = (COption::GetOptionString("altasib.review","VOTE_IP","N")=="Y");
                if($sess)
                {
                    if(!is_array($_SESSION["REVIEW_VOTE"]))
                        $_SESSION["REVIEW_VOTE"] = Array();
                        
                    $_SESSION["REVIEW_VOTE"][] = $ID;
                }
                
                if($cookie)
                {
                    $rv = $APPLICATION->get_cookie("REVIEW_VOTE");
                    $arRV = explode(",",$rv);
                    $arRV[] = $ID;
                    $APPLICATION->set_cookie("REVIEW_VOTE",implode(",",$arRV));                    
                }

                if($res)
                {
                        $USER_ID = $USER->GetID();
                        if($USER_ID>0 || $ip)
                        {
                                $arInsert = $DB->PrepareInsert("altasib_review_vote_to_review", Array("USER_ID"=>$USER_ID,"REVIEW_ID"=>$ID,"IP"=>$_SERVER["REMOTE_ADDR"]), "altasib.review");
                                $strSql = "INSERT INTO altasib_review_vote_to_review(".$arInsert[0].") VALUES(".$arInsert[1].")";
                                $DB->Query($strSql);
                        }
                        self::ClearCacheFull($ID);
                }
        return $res;
        }

        Function AllowVote($ID)
        {
                global $DB,$USER,$APPLICATION;

                $ID = (int)$ID;
                if($ID==0)
                        return false;

                $sess = (COption::GetOptionString("altasib.review","VOTE_SESION","N")=="Y");
                $cookie = (COption::GetOptionString("altasib.review","VOTE_COOKIE","N")=="Y");
                $ip = (COption::GetOptionString("altasib.review","VOTE_IP","N")=="Y");
                $user_id = (COption::GetOptionString("altasib.review","VOTE_USER_ID","Y")=="Y");
                
                if($sess)
                {
                    if(is_array($_SESSION["REVIEW_VOTE"]) && in_array($ID, $_SESSION["REVIEW_VOTE"]))
                    {
                        return false;
                    }
                }
                
                if($cookie)
                {
                    $rv = $APPLICATION->get_cookie("REVIEW_VOTE");
                    $arRV = explode(",",$rv);
                    if(in_array($ID, $arRV))
                    {
                        return false;
                    }
                }

                $arSqlSearch = Array();
                if($ip)
                {
                    $arSqlSearch[] = "IP='".$DB->ForSql($_SERVER["REMOTE_ADDR"])."'";
                }
                
                if($user_id && !$USER->IsAuthorized())
                    return false;
                elseif($user_id)
                {
                    $arSqlSearch[] = "USER_ID=".$USER->GetID();
                }
                
                if($ip || $user_id)
                {
                    $strSql = "SELECT 'x' FROM altasib_review_vote_to_review WHERE REVIEW_ID=".$ID." AND ((".implode(") OR (", $arSqlSearch)."))";
                    $res = $DB->Query($strSql);
                    if($res->Fetch())
                            return false;
                }
        return true;
        }

        Function AllowSetRating($ELEMENT_ID)
        {
                global $DB,$USER,$APPLICATION;

                $ID = (int)$ELEMENT_ID;
                if($ID==0)
                        return false;

                $sess = (COption::GetOptionString("altasib.review","VOTE_SESION","N")=="Y");
                $cookie = (COption::GetOptionString("altasib.review","VOTE_COOKIE","N")=="Y");
                $ip = (COption::GetOptionString("altasib.review","VOTE_IP","N")=="Y");
                $user_id = (COption::GetOptionString("altasib.review","VOTE_USER_ID","Y")=="Y");

                if($sess)
                {
                    if(is_array($_SESSION["REVIEW_RATING"]) && in_array($ID, $_SESSION["REVIEW_RATING"]))
                    {
                        return false;
                    }
                }
                
                if($cookie)
                {
                    $rv = $APPLICATION->get_cookie("REVIEW_RATING");
                    $arRV = explode(",",$rv);

                    if(in_array($ID, $arRV))
                    {
                        return false;
                    }
                }

                $arSqlSearch = Array();
                if($ip)
                {
                    $arSqlSearch[] = "IP='".$DB->ForSql($_SERVER["REMOTE_ADDR"])."'";
                }
                
                if($user_id && !$USER->IsAuthorized())
                    return false;
                elseif($user_id)
                {
                    $arSqlSearch[] = "USER_ID=".$USER->GetID();
                }
                
                if($ip || $user_id)
                {
                    $strSql = "SELECT 'x' FROM altasib_review_rating2element WHERE ELEMENT_ID=".$ID." AND ((".implode(") OR (", $arSqlSearch)."))";
                    $res = $DB->Query($strSql);
                    if($res->Fetch())
                            return false;
                }
        return true;
        }
        
        Function SetRating($ELEMENT_ID)
        {
                global $DB,$USER,$APPLICATION;
                $ID = (int)$ELEMENT_ID;
                if($ID==0)
                        return false;

                $sess = (COption::GetOptionString("altasib.review","VOTE_SESION","N")=="Y");
                $cookie = (COption::GetOptionString("altasib.review","VOTE_COOKIE","N")=="Y");
                $ip = (COption::GetOptionString("altasib.review","VOTE_IP","N")=="Y");
                if($sess)
                {
                    if(!is_array($_SESSION["REVIEW_RATING"]))
                        $_SESSION["REVIEW_RATING"] = Array();
                        
                    $_SESSION["REVIEW_RATING"][] = $ID;
                }
                
                if($cookie)
                {
                    $rv = $APPLICATION->get_cookie("REVIEW_RATING");
                    $arRV = explode(",",$rv);
                    $arRV[] = $ID;
                    $APPLICATION->set_cookie("REVIEW_RATING",implode(",",$arRV));                    
                }

                $USER_ID = $USER->GetID();
                if($USER_ID>0 || $ip)
                {
                        $arInsert = $DB->PrepareInsert("altasib_review_rating2element", Array("USER_ID"=>$USER_ID,"ELEMENT_ID"=>$ID,"IP"=>$_SERVER["REMOTE_ADDR"]), "altasib.review");
                        $strSql = "INSERT INTO altasib_review_rating2element(".$arInsert[0].") VALUES(".$arInsert[1].")";
                        $DB->Query($strSql);
                }
        return $res;
        }        
        
        Function GetVoteCount($ID)
        {
                global $DB;
                $ID = (int)$ID;
                if($ID==0)
                        return 0;

                $strSql = "SELECT RM.VOTE_PLUS-RM.VOTE_MINUS as VOTE_SUMM FROM altasib_review RM WHERE ID=".$ID;
                $res = $DB->Query($strSql);
                $arRes = $res->Fetch();
        return $arRes["VOTE_SUMM"];
        }
		
		Function CalculateRating($ELEMENT_ID)
		{
				global $DB;
                $ELEMENT_ID = (int)$ELEMENT_ID;
                if($ELEMENT_ID==0)
                        return 0;
				
				$strSql = "SELECT SUM( RATING ) / count( ID ) AS CR FROM `altasib_review` WHERE APPROVED='Y' AND RATING >0 AND ELEMENT_ID =".$ELEMENT_ID;
				$res = $DB->Query($strSql);
				if($arRes = $res->Fetch())
						return number_format($arRes["CR"],1);
		return 0;
		}
}
?>