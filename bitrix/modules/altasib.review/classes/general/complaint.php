<?
#################################################
#        Company developer: ALTASIB
#        Developer: Evgeniy Pedan
#        Site: http://www.altasib.ru
#        E-mail: dev@altasib.ru
#        Copyright (c) 2006-2011 ALTASIB
#################################################
?>
<?
Class aReviewComplaintMain
{
        Function GetByID($ID,$arSelect = Array())
        {
                return  aReviewComplaint::GetList(Array(), Array("ID" => IntVal($ID)));
        }
}
?>