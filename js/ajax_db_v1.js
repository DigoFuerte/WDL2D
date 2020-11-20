
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

//! function to populate media_view.php ... after slide_id taken from query string
function displaySlide(isSlide, slide_id) {

  let media_id = -88;

  if (isSlide) {
    console.log("isSlide: " + isSlide + " ... slide_id: " + slide_id);
  }
  else {
    console.log("isSlide: " + isSlide + " ... media_id: " + slide_id);
    media_id = slide_id;
  }

  //* form key-value for hdurl
  let str_html = ""
  let sess_key = "";
  let sess_value = "";
  let promiseResult;
  let userMedia = {};
  let user_title;
  let user_explanation;

  //* get url from sessionStorage ... coming from Home page
  if (isSlide) {
    sess_key = slide_id + "_hdurl";
    sess_value = sessionStorage.getItem(sess_key);
  }
  //* get url from $_SESSION['user_media'] ... coming from Gallery page
  else {
    console.log("GETTING MEDIA DATA FROM $_SESSION: ");
    // userMedia = jsGetMediaSessionData(media_id).then(
    //! in Javascript ... UNABLE TO WAIT FOR ASYNC PROCESS TO RETURN
    //! ALTERNATIVE   ... STORE USER MEDIA DETAILS IN session Storage beforehand
    // promiseResult = jsGetMediaSessionData(media_id).then(
    //   // anonymous function for: SUCCESS
    //   function (result) {

    //     // result.media_id
    //     // result.copyright       
    //     // result.apod_date       
    //     // result.explanation     
    //     // result.hdurl           
    //     // result.media_type      
    //     // result.service_version 
    //     // result.title           
    //     // result.url             

    //     // console.log("$_SESSION['user_media'] found with value: {" + JSON.parse(result) + "}");
    //     // console.log("$_SESSION['user_media'] found title: {" + result.title + "}");
    //     // console.log("$_SESSION['user_media'] found explanation: {" + result.explanation + "}");
    
    //     user_title = result.title;
    //     console.log("INSIDE PROMISE ... user_title: {" + user_title + "}");
        
    //     user_explanation = result.explanation;
    //     console.log("INSIDE PROMISE ... user_explanation: {" + user_title + "}");

    //     // userMedia = Object.assign(result);
    //     // console.log("INSIDE PROMISE ... userMedia.title: {" + userMedia.title + "}");
    //     // console.log("INSIDE PROMISE ... userMedia.explanation: {" + userMedia.explanation + "}");
    //     // console.log("INSIDE PROMISE ... userMedia.hdurl: {" + userMedia.hdurl + "}");
    //     return result;
    //   },
    //   // anonymous function for: ERROR
    //   function (error) {
    //     console.error("Error: " + error);
    //   } 
    // ); // end of promise jsGetMediaSessionData()

    // userMedia = Object.assign(promiseResult);
    // console.log("AFTER PROMISE ... userMedia.title: {" + userMedia.title + "}");
    // console.log("AFTER PROMISE ... userMedia.explanation: {" + userMedia.explanation + "}");
    // console.log("AFTER PROMISE ... userMedia.hdurl: {" + userMedia.hdurl + "}");

    // console.log("AFTER PROMISE ... user_title: {" + user_title + "}");
    // console.log("AFTER PROMISE ... user_explanation: {" + user_title + "}");

  }

  // console.log("sess_key: " + sess_key + " ... " + "sess_value: " + sess_value);
  $(media_div).html("<img class='apod-image' src='" + sess_value + "' alt='" + slide_id + "'></>");   

  //* save button
  if (isSlide) {
    console.log("Setting up SAVE BUTTON: slide_id" + slide_id);
    $(save_media_btn).on("click", function () {
      // disable the button
      $(this).prop('disabled', true);
      console.log("01 INSIDE anonymous function: " + slide_id);
      //* create empty json object 
      var obj_data_param = {};
      //obj_data_param['P_USER_ID'] = user_id;                                      
      // first parameter for ajax ... slide_id
      obj_data_param['slide_id'] = slide_id;
      // console.log("02 INSIDE anonymous function: obj_data_param['slide_id'] = " + obj_data_param['slide_id']);
      //* extract slide media meta data from sessionStorage
      let session_vars = [{ id: (slide_id + "_copyright"), image_mdata: "" },
      { id: (slide_id + "_date"), image_mdata: "" },
      { id: (slide_id + "_explanation"), image_mdata: "" },
      { id: (slide_id + "_hdurl"), image_mdata: "" },
      { id: (slide_id + "_media_type"), image_mdata: "" },
      { id: (slide_id + "_service_version"), image_mdata: "" },
      { id: (slide_id + "_title"), image_mdata: "" },
      { id: (slide_id + "_url"), image_mdata: "" }];
      // ,{id:(slide_id + "_flag"),            image_mdata:false} ];
      session_vars.forEach(
        function (value) {
          // get slide details from sessionStorage
          value.meta_data = sessionStorage.getItem(value.id);
          obj_data_param[value.id] = value.meta_data;
          // console.log("GET: obj_data_param[" + value.id + "]: " + obj_data_param[value.id]);
        }
      ); // end of forEach - loop
      // perform ajax call
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
    console.log("No SAVE BUTTON ... coming from Gallery page: media_id: " + media_id);
  }

  //* title
  if (isSlide) {
    sess_key = slide_id + "_title";
    sess_value = sessionStorage.getItem(sess_key);
  }
  else {
    sess_value = userMedia.title;
    // sess_value = user_title;
  }
  // console.log("sess_key: " + sess_key + " ... " + "sess_value: " + sess_value);
  $(title_para).html(sess_value);

  //* copyright
  if (isSlide) {
    sess_key = slide_id + "_copyright";
    sess_value = sessionStorage.getItem(sess_key);
  }
  else {
    sess_value = userMedia.copyright;
  }      
  if (sess_value != "undefined") { 
    str_html = "<i class='far fa-copyright'></i><p id='copyright_para' style='display:inline-block;'>";
    str_html += sess_value + "</p><br>";
    $(copyright_div).html(str_html); 
  }

  //* date
  if (isSlide) {
    sess_key = slide_id + "_date";
    sess_value = sessionStorage.getItem(sess_key);
  }
  else {
    sess_value = userMedia.date;
  }
  // console.log("sess_key: " + sess_key + " ... " + "sess_value: " + sess_value);
  str_html = "<i class='far fa-clock'></i><p id='date_para' style='display:inline-block;'>";
  str_html += sess_value + "</p><br>";
  $(date_div).html(str_html); 

  //* explanation
  if (isSlide) {
    sess_key = slide_id + "_explanation";
    sess_value = sessionStorage.getItem(sess_key);
  }
  else {
    console.log("OUTSIDE PROMISE ... userMedia.explanation: " + userMedia.explanation);
    sess_value = userMedia.explanation;
  }
  // console.log("sess_key: " + sess_key + " ... " + "sess_value: " + sess_value);
  str_html = "<i class='fas fa-info'></i><p id='explanation_para' style='display:inline-block;'>";
  str_html += sess_value + "</p>";
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
