// $(document).ready(function () {

function jq_save_user_media_local() {
  $.ajax({
    type: 'POST',
    url: 'php/get_media_from_session_local.php',
    // data: { 'media_id': p_media_id },
    data: 'GET_ALL_USER_MEDIA',
    dataType: 'json',
    success: function (result) {
      //* userMedia to sessionStorage
      // console.log("AJAX RETURNED: ");
      // console.log(result);
      result.forEach(function (media) {
        // form key-value pairs  
        sessionStorage.setItem("media_id_" + media.media_id + "_apod_date", media.apod_date);
        sessionStorage.setItem("media_id_" + media.media_id + "_copyright", media.copyright);
        sessionStorage.setItem("media_id_" + media.media_id + "_explanation", media.explanation);
        sessionStorage.setItem("media_id_" + media.media_id + "_hdurl", media.hdurl);
        sessionStorage.setItem("media_id_" + media.media_id + "_media_type", media.media_type);
        sessionStorage.setItem("media_id_" + media.media_id + "_service_version", media.service_version);
        sessionStorage.setItem("media_id_" + media.media_id + "_title", media.title);
        sessionStorage.setItem("media_id_" + media.media_id + "_url", media.url);
      });
    },      
    error: function (_jqXHR, strStatus, strErrorThrown) {
      let strError = "AJAX ERROR: { [" + strStatus + "] [" + strErrorThrown + "] }";
      //* funcReject(strError);
      // console.log(strError);
    }
  });
}

function get_media_details_local(isSlide, _id) {

  let mediaIdKey;
  (isSlide) ? mediaIdKey = _id :
              mediaIdKey = "media_id_" + _id;

  try {
    let _date;
    (isSlide) ? _date = sessionStorage.getItem(mediaIdKey + "_date") :
                _date = sessionStorage.getItem(mediaIdKey + "_apod_date") ;
    let _copyright = sessionStorage.getItem(mediaIdKey + "_copyright");    
    let _explanation = sessionStorage.getItem(mediaIdKey + "_explanation");
    let _hdurl = sessionStorage.getItem(mediaIdKey + "_hdurl");
    let _media_type = sessionStorage.getItem(mediaIdKey + "_media_type");
    let _service_version = sessionStorage.getItem(mediaIdKey + "_service_version");
    let _title = sessionStorage.getItem(mediaIdKey + "_title");
    let _url = sessionStorage.getItem(mediaIdKey + "_url");
    //return a JS object
    return {
      date: _date,
      copyright: _copyright,
      explanation: _explanation,
      hdurl: _hdurl,
      media_type: _media_type,
      service_version: _service_version,
      title: _title,
      url: _url
    };
  }
  catch (error) {
    return false;
  }
}

// }); // end of $(document).ready(...) 
