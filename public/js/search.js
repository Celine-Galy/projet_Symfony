$(function() {
    $('#input-search').on('keyup', function() {
        let value = $(this).val().toLowerCase();
        $.get('/main_article/search?terms=' + value, function(articles) {
            $('#results').html("");
            articles.forEach((article) => {
                $('#results').append("<li><a href=" + 'main_article/' + article.id + ">" + article.title + "</a></li>");
            });
        })
    })
});