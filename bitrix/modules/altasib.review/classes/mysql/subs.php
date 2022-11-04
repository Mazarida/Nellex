<?
#################################################
#        Company developer: ALTASIB
#        Developer: Evgeniy Pedan
#        Site: http://www.altasib.ru
#        E-mail: dev@altasib.ru
#        Copyright (c) 2006-2012 ALTASIB
#################################################
?>
<?
class aReviewSubs extends aReviewSubsMain
{
    Function Add($ELEMENT_ID,$EMAIL)
    {
        global $DB;        

        if(!$this->CheckFields($ELEMENT_ID,$EMAIL))
        {
                $Result = false;
                $arFields["RESULT_MESSAGE"] = &$this->LAST_ERROR;
        }
        else
        {    
            $arInsert = $DB->PrepareInsert("altasib_review_subs", Array("ELEMENT_ID"=>$ELEMENT_ID,"EMAIL"=>$EMAIL), "altasib.review");
            $strSql = "INSERT INTO altasib_review_subs(".$arInsert[0].") VALUES(".$arInsert[1].")";
            $Result = $DB->Query($strSql);
        }
        
    return $Result;
    }
    
    Function IsSubs($ELEMENT_ID,$EMAIL)
    {
        global $DB;
        $ELEMENT_ID = intVal($ELEMENT_ID);
        if ($ELEMENT_ID <= 0 || strlen($EMAIL)==0)
            return false;
        
        $res = $DB->Query("SELECT EMAIL FROM altasib_review_subs WHERE ELEMENT_ID = ".$ELEMENT_ID." AND EMAIL='".$DB->ForSql($EMAIL)."'", false);
        if($res->Fetch())
            return true;
        else
            return false;
    }
    
    Function Delete($ELEMENT_ID,$EMAIL)
    {
        global $DB;
        $ELEMENT_ID = intVal($ELEMENT_ID);
        if ($ELEMENT_ID <= 0 || strlen($EMAIL)==0)
            return false;
        
        $DB->Query("DELETE FROM altasib_review_subs WHERE ELEMENT_ID = ".$ELEMENT_ID." AND EMAIL='".$DB->ForSql($EMAIL)."'", false);
    return true;        
    }
    
    Function GetList($arFilter = Array())
    {
        global $DB;
        $arSqlSearch = Array();
        $strSqlSearch = "";

        if (is_array($arFilter))
        {
            $filter_keys = array_keys($arFilter);

            for ($i=0; $i<count($filter_keys); $i++)
            {
                $val = $arFilter[$filter_keys[$i]];

                if (strlen($val)<=0 || $val."!"=="NOT_REF!") continue;

                switch(strtoupper($filter_keys[$i]))
                {
                    case "ELEMENT_ID":
                            $arSqlSearch[] = GetFilterQuery("RS.ELEMENT_ID",$val,"N");
                    break;

                    case "EMAIL":
                            $arSqlSearch[] = GetFilterQuery("RS.EMAIL",$val);
                    break;
                }
            }
        }
        $strSqlSearch = GetFilterSqlSearch($arSqlSearch);

        $strSql = "
        SELECT DISTINCT RS.*
        FROM altasib_review_subs RS
        WHERE
        "
        .$strSqlSearch;

        $res = $DB->Query($strSql, false, $err_mess.__LINE__);
        $res->is_filtered = (IsFiltered($strSqlSearch));

        return $res;        
    }
}
?>