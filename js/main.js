var MYBLOG_LIMIT = 4;
var MYWRAPPER_CLASS = 'wp-container';
 
var WP={open:function(b){var a={posts:function(){var d=MYBLOG_LIMIT;var e=0;var c={all:function(g){var f=b+"/api/get_recent_posts/";f+="?count="+d+"&page="+e+"&callback=?";jQuery.getJSON(f,function(l){var k=l.posts;for(var j=0;j<k.length;j++){var h=k[j];h.createComment=function(i,m){i.postId=h.id;a.comments().create(i,m)}}g(k)})},findBySlug:function(f,h){var g=b+"/api/get_post/";g+="?slug="+f+"&callback=?";jQuery.getJSON(g,function(i){h(i.post)})},limit:function(f){d=f;return c},page:function(f){e=f;return c}};return c},pages:function(){var c={findBySlug:function(d,f){var e=b+"/api/get_page/";e+="?slug="+d+"&callback=?";jQuery.getJSON(e,function(g){f(g.page)})}};return c},categories:function(){var c={all:function(e){var d=b+"/api/get_category_index/";d+="?callback=?";jQuery.getJSON(d,function(f){e(f.categories)})}};return c},tags:function(){var c={all:function(e){var d=b+"/api/get_tag_index/";d+="?callback=?";jQuery.getJSON(d,function(f){e(f.tags)})}};return c},comments:function(){var c={create:function(f,e){var d=b+"/api/submit_comment/";d+="?post_id="+f.postId+"&name="+f.name+"&email="+f.email+"&content="+f.content+"&callback=?";jQuery.getJSON(d,function(g){e(g)})}};return c}};return a}};
 
var blog = WP.open('http://dailyflowfitness.com/movements/');
blog.posts().all(function(posts){
  for(var i = 0; i < posts.length; i++){
    jQuery('.'+MYWRAPPER_CLASS).append(function(){
      return '<div class="card"><a href="' + posts[i].url + '"><img class="card-display" src="' + posts[i].thumbnail + '"/></a><h4 class="card-title" href="' + posts[i].url + '">' + posts[i].title + '</h4><p class="card-name"' + posts[i].excerpt + '</p><a href="' + posts[i].url + '">Read More..</a><div>';
    });
  }
});


$(function () {

    // init the validator
    // validator files are included in the download package
    // otherwise download from http://1000hz.github.io/bootstrap-validator

    // dont need this as long as i do this: role="form" data-toggle="validator" in the html form
    // $('#contact-form').validator();


    // when the form is submitted
    $('#contact-form').on('submit', function (e) {

        if (!e.isDefaultPrevented()) {
            var url = "contact.php";

            // POST values in the background the the script URL
            $.ajax({
                type: "POST",
                url: url,
                data: $(this).serialize(),
                success: function (data) {
                    console.log(data);
                    // data = JSON object that contact.php returns

                    // we recieve the type of the message: success x danger and apply it to the 
                    var messageAlert = 'alert-' + data.type;
                    var messageText = data.message;

                    // let's compose Bootstrap alert box HTML
                    var alertBox = '<div class="alert ' + messageAlert + ' alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>' + messageText + '</div>';
                    
                    // If we have messageAlert and messageText
                    if (messageAlert && messageText) {
                        // inject the alert to .messages div in our form
                        $('#contact-form').find('.messages').html(alertBox);
                        // empty the form
                        $('#contact-form')[0].reset();
                    }
                }
            });
            return false;
        }
    })
});

