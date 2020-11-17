
$(document).ready(function(){

    $.ajax({
        // url : "https://api.nasa.gov/planetary/apod?api_key=prM66Z2Kgwfaloj6NNpLrJXb9gAcYRE5a4z1UsL2",
        url : "https://api.nasa.gov/planetary/apod?api_key=jDpuF0V85x4F99c50zfs182iKJgpnA7gbUKCKsgh",
        type: "GET",
        dataType : "json",
        success: function(data){
            console.log(data);
            $("#main-img").html(
                "<div class='image-block'>"
                +"<h3>Image of the day by NASA</h3>"
                +"<img class='image' src=" + data.url + " >"
                +"<div class='image-info'>"
                    +"<h3>Image Title : "+data.title+"</h3>"
                    +"<hr><p style='text-align:justify;'><b>Explanation :</b> "+data.explanation+"</p><hr>"
                    +"<p><b>Date :</b> "+new Date(data.date).toLocaleDateString()+"</p>"
                    +"<p><b>Media Type :</b> "+data.media_type+"</p>"
                    +"<p><b>Service Version :</b> "+data.service_version+"</p>"
                    +"<p><b>Copyright :</b> "+data.copyright+"</p>"
                +"</div></div>"
            )
        },
        error : function(xhr, status, errorThrown){
            alert( "Sorry, there was a problem!" );
                console.log( "Error: " + errorThrown );
                console.log( "Status: " + status );
                console.dir( xhr );
        },
        complete : function(){
            // alert( "The request is complete!" );
        }
    })  // End of ajax function
    
}) // End of ready function