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
IncludeModuleLangFile(__FILE__);
class aReviewSubsMain
{
    Function CheckFields($ELEMENT_ID,$EMAIL)
    {
        $this->LAST_ERROR = "";
        
        if(strlen($EMAIL)==0 || !check_email($EMAIL))
            $this->LAST_ERROR .= GetMessage("ALTASIB_REVIEW_SUBS_ERR_EMAIL")."<br />";
            
        if($ELEMENT_ID==0)
            $this->LAST_ERROR .= GetMessage("ALTASIB_REVIEW_SUBS_ERR_ELEMENT")."<br />";
        
        if(strlen($this->LAST_ERROR)==0 && aReviewSubs::IsSubs($ELEMENT_ID,$EMAIL))
            $this->LAST_ERROR .= GetMessage("ALTASIB_REVIEW_SUBS_EMAIL_EX")."<br />";
            
        if(strlen($this->LAST_ERROR)>0)
            return false;
    
    return true;
    }
}
?>