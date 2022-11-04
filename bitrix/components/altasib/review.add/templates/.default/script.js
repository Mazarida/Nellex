var active_vote_prev = {};
var aReviewVote = function()
{
    this.Curr = function(num,id)
    {
        for(i=1;i<6;i++)
        {
            var $div = BX('altasib_item_vote_'+id+'_'+i);
            if($div) {
                if (num >= i)
                    $div.className = 'alx_reviews_form_vote_item alx_reviews_form_vote_item_sel';
                else
                    $div.className = 'alx_reviews_form_vote_item';
            }
        }
    };
    this.Out = function(id)
    {
        for(i=1;i<6;i++)
        {
            var $div = BX('altasib_item_vote_'+id+'_'+i);
            if($div) {
                if (active_vote_prev[id] >= i)
                    $div.className = 'alx_reviews_form_vote_item alx_reviews_form_vote_item_sel';
                else
                    $div.className = 'alx_reviews_form_vote_item';
            }
        }
    };
    this.Set = function(num,field,id)
    {
        active_vote_prev[id] = num;
        BX(field).value=num;
        this.Curr(num,id);
    }
    this.Restore = function()
    {
        for(var key in active_vote_prev)
        {
            num = active_vote_prev[key];
            this.Curr(num,key);
        }
    }
}
var jsReviewVote = new aReviewVote();

function ShowReviewForm()
{
    BX('review_add_form').style.display = 'block';
    BX('review_show_form').style.display = 'none';
}

BX.addCustomEvent(window, 'onErrorFile', function(file){
    alert(BX.message("ERROR_FILE_UPLOAD") + ':'+ file['fileName'] + '. ' + file['error']);
});

BX.ready(function () {
    $('#mfi-reviewFileAdd-button > span').addClass('ui-btn ui-btn-xs');
});