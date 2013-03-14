
NEWS_ARTICLE_CLASS = 'news-article';

function onSuccess(data) {
    removeArticles();
    if (data.length) {
        for (var i = 0, item; item = data[i++];) {
            $article = $(item.description).appendTo("#id_query_result");
            $article.addClass(NEWS_ARTICLE_CLASS);
            removeAds($article);
        }
    } else {
        $('#id_search_info').show();
    }
}

function removeArticles() {
    $('.' + NEWS_ARTICLE_CLASS).remove();
}

function removeAds($article) {
    $article.find('td:first').remove();
}

function buttonClick() {
    $('#id_search_info').hide();
    query = $("input:first").val().trim();
    
    if (!query) {
        return false;
    }

    $.ajax({
        url: "/aaa/php/get.php?q=" + query,
        dataType: "json",
        success: onSuccess
    });
}

$("button:first").click(buttonClick);
$('#id_search_info').hide();

