function record(sel){
    var button = $(sel);
    button.click(function(event){
        event.preventDefault();
        var b = this;
        var music = new Audio(b.value);
        music.play();
        //insertPlay(b.id,$('input[name=user]').val());
    });
}

// function insertPlay(id,user) {
//     $.ajax({
//         url: "post/play.php",
//         data: {
//             tid:id,
//             username:user
//         },
//         method: "POST",
//         success: function(data) {
//         }
//     });
// }