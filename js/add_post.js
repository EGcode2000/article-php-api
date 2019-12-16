alert('working!');
let categoryId;
let title;
let body;
let author;

$(document).ready(function(){
    $('#addPostButton').click(function(e){

        categoryId = $('#category :selected').val();
        title = $('#title').val();
        body = $('#body').val();
        author = $('#author').val();
        let sendData = JSON.stringify({
            'category_id': categoryId,
            'author': author,
            'title' : title,
            'body': body
        });
        console.log(sendData);
        //post with ajax
        $.ajax({
            type:"POST",
            url: "http://localhost/php-rest-api-articles/api/posts/create.php",
            data: sendData,
            ContentType:"application/json",
            dataType: "json",
            success:function(){
                alert('successfully posted');
            },
            error:function(e){
                alert('Could not be posted');
                console.log(e);
            }

        });
    });
});