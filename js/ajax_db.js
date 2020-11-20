
var slide_id;

if (window.addEventListener) { // Mozilla, Netscape, Firefox
    // window.addEventListener('load', myWindowLoadFunc, false);
    console.log("01 adding event listener: ");
    window.addEventListener('load', getSlideId, false);
} 
else if (window.attachEvent) { // IE
    // window.attachEvent('onload', myWindowLoadFunc);
    console.log("02 adding event listener: ");
    window.attachEvent('onload', getSlideId);
}

// function myWindowLoadFunc(event) { alert("Another onload script"); }

//* code to pass the ID of the slide clicked on   
//? pass the slide id in the query string
//? clientside ... interogate the query string using location.search
function getQueryString() {
    var result = {},
        queryString = location.search.slice(1),
        re = /([^&=]+)=([^&]*)/g,
        m;

    while (m = re.exec(queryString)) {
        //* I think ... m[1] = key  m[2] = value
        result[decodeURIComponent(m[1])] = decodeURIComponent(m[2]);
    }
    return result;
}

//? wrapper function for getQueryString()
function getQueryStringValue(queryStringKey) {

    return getQueryString()[queryStringKey];  // e.g slide-01

    //* e.g getQueryStringValue("selected_slide")
}

// ... after interogating the query string
//* function to populate media_view.php
function displaySlide(isSlide, slide_id) {

  let str_html = ""
  //* key-value pairs for media details
  let sess_key = "";
  let sess_value = "";
  let mediaDetails;
  
  mediaDetails = get_media_details_local(isSlide, slide_id);

  //* display media
  $(media_div).html("<img class='apod-image' src='" + mediaDetails.hdurl + "' alt='" + slide_id + "'></>");   

  //* save button
  if (isSlide) {
    // console.log("Setting up SAVE BUTTON: slide_id" + slide_id);
    // anonymous function for click event on Save Button
    $(save_media_btn).on("click", function () {
      // disable the button
      $(this).prop('disabled', true);
      // create empty json object 
      var obj_data_param = {};
      //obj_data_param['P_USER_ID'] = user_id;                                      
      // first parameter for ajax ... slide_id
      obj_data_param['slide_id'] = slide_id;
      //* extract slide media meta data from sessionStorage
      let session_vars = [
        { _column: (slide_id + "_copyright"),       _data: mediaDetails.copyright },
        { _column: (slide_id + "_date"),            _data: mediaDetails.date },
        { _column: (slide_id + "_explanation"),     _data: mediaDetails.explanation },
        { _column: (slide_id + "_hdurl"),           _data: mediaDetails.hdurl },
        { _column: (slide_id + "_media_type"),      _data: mediaDetails.media_type },
        { _column: (slide_id + "_service_version"), _data: mediaDetails.service_version },
        { _column: (slide_id + "_title"),           _data: mediaDetails.title },
        { _column: (slide_id + "_url"),             _data: mediaDetails.url }
      ];
      console.log("PRE PARAM BUILD ... title: " + mediaDetails.title);
      console.log("PRE PARAM BUILD ... date: " + mediaDetails.date);
      console.log("PRE PARAM BUILD ... hdurl: " + mediaDetails.hdurl);
      // myArray.forEach((element, index, array) => { };
      session_vars.forEach(
        (arr_element) => {
          console.log("PARAM BUILD ... " + arr_element._column + ": " + arr_element._data);
          obj_data_param[arr_element._column] = arr_element._data;
        }
      ); // end of forEach - loop
      console.log("params for save:");
      console.log(obj_data_param);
      //* perform ajax call
      $.ajax({
        type: 'POST',
        url: './php/jq_save_user_media_id.php',
        data: obj_data_param,
        dataType: 'json',
        success: function (result) { },
        //* super set of jqXHR: jQuery Xml Http Request Object
        error: function (_jqXHR, strStatus, strErrorThrown) {
          //* AJAX CALL GIVES AN ERROR 
          let strError = "{ [" + strStatus + "] [" + strErrorThrown + "] }";
          return strError;
        }
      });

    } // } // end of anonymous function                                    
    );
  }    
  else {
    // console.log("No SAVE BUTTON ... coming from Gallery page: media_id: " + media_id);
    $(save_media_btn).prop('disabled', true);
  }

  //* title
  $(title_para).html(mediaDetails.title);

  //* copyright
  if (mediaDetails.copyright != "undefined") { 
    str_html = "<i class='far fa-copyright'></i><p id='copyright_para' style='display:inline-block;'>";
    str_html += mediaDetails.copyright + "</p><br>";
    $(copyright_div).html(str_html); 
  }

  //* date
  str_html = "<i class='far fa-clock'></i><p id='date_para' style='display:inline-block;'>";
  str_html += mediaDetails.date + "</p><br>";
  $(date_div).html(str_html); 

  //* explanation
  str_html = "<i class='fas fa-info'></i><p id='explanation_para' style='display:inline-block;'>";
  str_html += mediaDetails.explanation + "</p>";
  $(explanation_div).html(str_html); 

} // end of function displaySlide()

//? ....... CODE TEST FOR PROMISE ....... 
//jsGetMediaSessionData().then(
//  function (result) {
//    console.log("$_SESSION['" + session_key + "'] found with value: {" + result + "}");
//  },
//);
//* ... $_SESSION
// async function jsGetMediaSessionData(session_key) {
async function jsGetMediaSessionData(p_media_id) {

  let jsGetMediaSessionPromise = new Promise(
    function (funcResolve, funcReject) {
      $.ajax({
        type: 'POST',
        url: 'php/get_media_from_session.php',
        data: { 'media_id': p_media_id },
        // data: 2,
        dataType: 'json',
        success: function (result) {
          // let result_obj = JSON.parse(result);
          // console.log("SUCCESS !!!");
          // console.log(result);
          // funcResolve(JSON.parse(result));
          funcResolve(result);
        },      
        error: function (_jqXHR, strStatus, strErrorThrown) {
          let strError = "{ [" + strStatus + "] [" + strErrorThrown + "] }";
          funcReject(strError);
        }
      });
    }
  ); //* end of jsGetMediaSessionPromise

  //? return the outcome of the Promise to the calling block
  return await jsGetMediaSessionPromise;

} //* end of function jsGetMediaSessionData() 

function jq_save_user_media_local() {
  // let jsGetMediaSessionPromise = new Promise(
    // function (funcResolve, funcReject) {
      $.ajax({
        type: 'POST',
        url: 'php/get_media_from_session_local.php',
        // data: { 'media_id': p_media_id },
        data: 'GET_ALL_USER_MEDIA',
        dataType: 'json',
        success: function (result) {
          // let result_obj = JSON.parse(result);
          // console.log("SUCCESS !!!");
          // funcResolve(JSON.parse(result));
          // funcResolve(result);
          // return result;
          //* userMedia to sessionStorage
          console.log(result);
        },      
        error: function (_jqXHR, strStatus, strErrorThrown) {
          let strError = "{ [" + strStatus + "] [" + strErrorThrown + "] }";
          //* funcReject(strError);
          console.log(strError);
        }
      });
    // }
  // ); //* end of jsGetMediaSessionPromise

  //? return the outcome of the Promise to the calling block
  // return await jsGetMediaSessionPromise;

}
//* function to be called from media_view.php on page-load ... when loaded from Home page
function getSlideId(event) {

  console.log("CHECKING FOR SLIDE ID NOW...");
  let slide_id = getQueryStringValue("selected_slide");
  console.log("result from getQueryStringValue('selected_slide'): " + slide_id);
  let isSlide = ( slide_id != null );
  if ( isSlide ) {
    console.log("Query string slide_id: " + slide_id);
    // populate web page
    displaySlide(isSlide, slide_id);
    return slide_id;
  }
  else {
    console.log("CHECKING MEDIA ID NOW...");
    let media_id = getQueryStringValue("selected_media");
    console.log("Query string media_id: " + media_id);

    // populate web page
    displaySlide(isSlide, media_id);        
    return slide_id;
  }

}

//* function to save media_id to $_SESSION when media_view.php loaded from Gallery
function saveMediaId(event) {

}

// $(document).ready(function(){
    // $('#save_media_btn').click(function(){
    //     saveUserMedia(slide_id);
    // });        
// }); 

//? ....... CODE TEST FOR PROMISE ....... 
//jsGetSessionData(session_key).then(
//  function (result) {
//    console.log("$_SESSION['" + session_key + "'] found with value: {" + result + "}");
//  },
//);
//!DEFUNCT
async function async_saveUserMedia(slide_id) {
  
  let saveUserMediaPromise = new Promise(
    function (funcResolve, funcReject) {
    
      //* create empty json object
      //*   will contain data to be picked up server-side in $_POST 
      var obj_data_param = {};
      //obj_data_param['P_USER_ID'] = user_id;
      
      //* first parameter for ajax ... slide_id
      obj_data_param['slide_id'] = slide_id;

      //* extract slide media meta data from sessionStorage
      let session_vars = [ {id:(slide_id + "_copyright"),       image_mdata:""},
                            {id:(slide_id + "_date"),            image_mdata:""},
                            {id:(slide_id + "_explanation"),     image_mdata:""},
                            {id:(slide_id + "_hdurl"),           image_mdata:""},
                            {id:(slide_id + "_media_type"),      image_mdata:""},
                            {id:(slide_id + "_service_version"), image_mdata:""},
                            {id:(slide_id + "_title"),           image_mdata:""},
                            {id:(slide_id + "_url"),             image_mdata:""},
                            {id:(slide_id + "_flag"),            image_mdata:false} ];
  
      session_vars.forEach(
        function (value) {
          // provide slide details from sessionStorage
          value.meta_data = sessionStorage.getItem(value.id);
          // console.log("GET: sessionStorage[" + value.id + "] : " + value.meta_data);
          obj_data_param[value.id] = value.meta_data;
        }
      );

      // perform ajax call
      $.ajax({
        type: 'POST',
        url: './php/jq_save_user_media_id.php',
        data: obj_data_param,
        dataType: 'json',
        success: function (result) {
          // console.log("result: " + result);
          //* AJAX CALL COMPLETED ON SUCCESS
          funcResolve(result);
        },
        //* super set of jqXHR: jQuery Xml Http Request Object
        error: function (_jqXHR, strStatus, strErrorThrown) {
          //* AJAX CALL GIVES AN ERROR 
          let strError = "{ [" + strStatus + "] [" + strErrorThrown + "] }";
          funcReject(strError);
        }
      });

    } //* end of anonymous function ()
  ); //* end of saveMediaPromise

  //? return the outcome of the Promise to the calling block
  return await saveUserMediaPromise;

} //* end of function function async_saveUserMedia() 

//!DEFUNCT
function saveUserMedia(slide_id) {
  
  //* create empty json object
  //*   will contain data to be picked up server-side in $_POST 
  var obj_data_param = {};
  //obj_data_param['P_USER_ID'] = user_id;
  
  //* first parameter for ajax ... slide_id
  obj_data_param['slide_id'] = slide_id;

  //* extract slide media meta data from sessionStorage
  let session_vars = [ {id:(slide_id + "_copyright"),        image_mdata:""},
                        {id:(slide_id + "_date"),            image_mdata:""},
                        {id:(slide_id + "_explanation"),     image_mdata:""},
                        {id:(slide_id + "_hdurl"),           image_mdata:""},
                        {id:(slide_id + "_media_type"),      image_mdata:""},
                        {id:(slide_id + "_service_version"), image_mdata:""},
                        {id:(slide_id + "_title"),           image_mdata:""},
                        {id:(slide_id + "_url"),             image_mdata:""},
                        {id:(slide_id + "_flag"),            image_mdata:false} ];

  session_vars.forEach(
    function (value) {
      // provide slide details from sessionStorage
      value.meta_data = sessionStorage.getItem(value.id);
      // console.log("GET: sessionStorage[" + value.id + "] : " + value.meta_data);
      obj_data_param[value.id] = value.meta_data;
    }
  );

  // perform ajax call
  $.ajax({
    type: 'POST',
    url: './php/jq_save_user_media_id.php',
    data: obj_data_param,
    dataType: 'json',
    success: function (result) {},
    //* super set of jqXHR: jQuery Xml Http Request Object
    error: function (_jqXHR, strStatus, strErrorThrown) {
      //* AJAX CALL GIVES AN ERROR 
      let strError = "{ [" + strStatus + "] [" + strErrorThrown + "] }";
      return strError;
    }
  });

} //* end of function function saveUserMedia() 
