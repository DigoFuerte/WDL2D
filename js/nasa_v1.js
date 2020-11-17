$(document).ready(function () {

  // $("p").click(function () {
  //   $(this).hide();
  // });

  // $('#myCarousel').hover(
  //   //* mouse enter handler
  //   function () {
  //     $(this).carousel('pause');
  //     // $('.btn-learn-more').css('display','none');
  //   },
  //   //* mouse leave handler
  //   function () {
  //     $(this).carousel('cycle');
  //     // $('.btn-learn-more').css('display','initial');
  //   }
  // );

//* 
//* Ptolemy Exchange ... PEX
//* in 150 BC Ptolemy was the first to list the constellations
//* 
//* eg: https://api.nasa.gov/planetary/apod?api_key=jDpuF0V85x4F99c50zfs182iKJgpnA7gbUKCKsgh
//*

// NASA: pictire of the day
const APOD_API_ID = 1;
const APOD_API_URL = 'https://api.nasa.gov/planetary/apod';
const NASA_API_KEY = 'jDpuF0V85x4F99c50zfs182iKJgpnA7gbUKCKsgh';

const NASA_IMAGES_API_ID = 2;
// images and audio available
const NASA_IMAGES_API_URL = 'https://images-api.nasa.gov';
// no key required ... ???
  
const SESSION_KEY_TEST = 'jq_php_test';
const SESSION_KEY_APOD = 'jq_php_apod';

  // let jq_value = '888-HHH-7890';
  // let jq_value = '333-XXX-2347';
  // let jq_value = '999-VVV-3721';
  // var jq_value = '101-YVX-5193';
  var jq_value = '144-HWX-1838';

  //! ....... SESSION CODE TEST ....... 
  //var session_key = SESSION_KEY_TEST;
  //jsPostSessionData(jq_value, session_key)
  // // var retValue;
  // // jsGetSessionData(session_key);
  //jsGetSessionData(session_key).then(
  //  function (result) {
  //    console.log("$_SESSION['" + session_key + "'] found with value: {" + result + "}");
  //  },
  //);
  // order required by Foreach() .... value, index,       arr {not need in this case}
  // async function jsPostSessionData(jq_value, session_key = "") {
  async function jsPostSessionData(value, key = "") {
    let session_value = "";
    let Session_key = ""
    if (key == "") {
      session_key = value.id;
      session_value = value.meta_data;
    }
    else {
      session_key = key;
      session_value = value;
    }

    let jsPostSessionPromise = new Promise(
      function (funcResolve, funcReject) {

        // if (session_key.length > 0 && session_value.length > 0) {
          //* create empty json object
          var obj_data_param = {};
          //* 01: the session variable key ... first key/value pair
          obj_data_param['SESSION_VARIABLE_KEY'] = session_key;
          //* 02: the value to save        ... second key/value pair 
          obj_data_param['SESSION_VARIABLE_VALUE'] = session_value;
            
          $.ajax({
            type: 'POST',
            url: './jq_to_session.php',
            data: obj_data_param,
            // dataType: 'dataType',
            success: function (data, _strStatus, _jqXHR) {
              // return strStatus; //* value should be: 'success'
              funcResolve(data);
            },        
            //* super set of jqXHR: jQuery Xml Http Request Object
            error: function (_jqXHR, strStatus, strErrorThrown) {
              let strError = "{ [" + strStatus + "] [" + strErrorThrown + "] }";;
              // return strError;
              funcReject(strError);
            }
          });
        // }
        // else {
          // // return "bad_parameter";
          // funcReject("");
        // }        
      }
    ); //* end of jsPostSessionPromise

    //? issue AWAIT STATEMENT here
    //? return the outcome of the Promise to the calling block
    return await jsPostSessionPromise;

  } //* end of function jsPostSessionData()

  //*wrapper function for jsGetSessionData()
  function getSlideMetaData(slide_id) {
    //* template for finding data stored in $_SESSION
    let session_vars = [
      (slide_id + "_copyright"),
      (slide_id + "_date"),
      (slide_id + "_explanation"),,
      (slide_id + "_hdurl"),
      (slide_id + "_media_type"),
      (slide_id + "_service_version"),
      (slide_id + "_title"),
      (slide_id + "_url"),
      (slide_id + "_flag")
    ];
    
    session_vars.forEach(function (value) {
          console.log("SEEKING $_SESSION variable: " + value);
        }
      );

  }
  async function jsGetSessionData(session_key) {
    
    let jsGetSessionPromise = new Promise(
      function (funcResolve, funcReject) {

        session_key = session_key.trim();

        if ((session_key.length) > 0) {
        
          //* create empty json object
          var obj_data_param = {};
          //* 01: the session variable key 
          obj_data_param['SESSION_VARIABLE_KEY'] = session_key;

          $.ajax({
            type: 'GET',
            url: './jq_to_session.php',
            data: obj_data_param,
            dataType: 'text',
            success: function (result) {
              // console.log("result: " + result);
              // return result; //* value should be non zero length string
              funcResolve(result);
            },      
            //* super set of jqXHR: jQuery Xml Http Request Object
            error: function (_jqXHR, strStatus, strErrorThrown) {
              let strError = "{ [" + strStatus + "] [" + strErrorThrown + "] }";
              // return strError;
              funcReject(strError);
            }
          });
        }
        else {
          // return "";
          funcReject("");
        }
      }
    ); //* end of jsPostSessionPromise

    //? issue AWAIT STATEMENT here
    //? return the outcome of the Promise to the calling block
    return await jsGetSessionPromise;

  } //* end of function function jsGetSessionData() 
  //! ....... SESSION CODE TEST ....... 

  //! ....... APOD CODE TEST ....... 
  getApod();
  getSevenDayWindow();
  //! ....... APOD CODE TEST ....... 
  
  function getSevenDayWindow() { 
    //* 24*60*60*1000 = 86400000 ... 1 day in milliseconds
    const ONE_DAY = 86400000;
    //* form query string to get image from this str_iDay
    //* https://api.nasa.gov/planetary/apod?date="YYYY-MM-DD"&api_key=DEMO_KEY
    let i;
    for (i = 0; i > -7; i--) {
      let str_api_url = APOD_API_URL + "?" + "api_key=" + NASA_API_KEY + "&date=";        
      let iDay = new Date(Date.now() + (ONE_DAY * i));
      var str_iDay = iDay.toISOString();
      str_iDay = str_iDay.substring(0, 10);

      //* form query string to get image from this str_iDay
      //* https://api.nasa.gov/planetary/apod?api_key=DEMO_KEY&date="YYYY-MM-DD"
      //* 
      //* NASA_API_KEY
      // str_api_url = encodeURI(str_api_url + str_iDay);
      str_api_url = str_api_url + str_iDay;
      let i_alt = ((-1) * i) + 1;
      let str_target_div = ".div-slide-0" + i_alt;
      //* call ajax function to update the webpage
      displayApodImage(str_api_url, i_alt, str_target_div);

    } //* end of for-loop 
  } // end of function getSevenDayWindow()

  //? ajax is intrinsicly asynchronous
  //? WRNING: these media do not necessarily return in the sequence they were called
  //?         if the order is important, wrap in a Promise
  function displayApodImage(str_url, i_alt, str_target_div) {
    $.ajax({
      url: str_url,
      type: 'GET',
      dataType: 'json',
      success: function (data) {  
        // console.log(data);
        //! save image details in $_SESSION ??? PERHAPS sessionStorage is better ???
        storeApodData(("slide-0" + i_alt), data);

        if (data.media_type === "image") {
          // $(str_target_div).html("<img class='apod-image' src='" + data.url + "' alt='slide " + i_alt + "'></>")
          $(str_target_div).html("<img class='apod-image' src='" + data.hdurl + "' alt='slide " + i_alt + "'></>")
        }
        else if (data.media_type === "video") {
          //* assume that the url points to youtube
          $(str_target_div).html("<iframe width=640px height=480px z-index: 20; src='" + data.url + "'></iframe>")
        }
      },
      error: function (xhr, status, errorThrown) {
        alert("Sorry, there was a problem!");
        console.log("Error: " + errorThrown);
        console.log("Status: " + status);
        console.dir(xhr);
      },
      complete: function () {
        // alert( "The request is complete!" );
      }

    });  // end of ajax function

  } //* end of function getAsyncApod()

  //? DATA TO SAVE IN $_SESSION
  //* 1  slide_id: slide-07
  //?    DATA FROM APOD IMAGES ... data.{...}
  //* 2. copyright:       "Casey Good/Steve Timmons"
  //* 3. date:            "2020-10-29"
  //* 4. explanation:     "Inspired by the halloween ... this frame at the upper left."
  //* 5. hdurl:           "https://apod.nasa.gov/apod/image/2010/GhoulGood.jpg"
  //* 6. media_type:      {"image","video"}
  //* 7. service_version: "v1"
  //* 8. title:           "The Ghoul of IC 2118"
  //* 9. url:             "https://apod.nasa.gov/apod/image/2010/GhoulGood_1024.jpg"
  //?    DATA FROM APOD IMAGES

  function storeApodData(slide_id, data) {
    //! copyright ... insome cases will contain "undefined"
    let session_vars = [ {id:(slide_id + "_copyright"), image_mdata:data.copyright},
                         {id:(slide_id + "_date"), image_mdata:data.date},
                         {id:(slide_id + "_explanation"), image_mdata:data.explanation},
                         {id:(slide_id + "_hdurl"), image_mdata:data.hdurl},
                         {id:(slide_id + "_media_type"), image_mdata:data.media_type},
                         {id:(slide_id + "_service_version"), image_mdata:data.service_version},
                         {id:(slide_id + "_title"), image_mdata:data.title},
                         {id:(slide_id + "_url"), image_mdata:data.url},
                         {id:(slide_id + "_flag"), image_mdata:false}

    ];
    // WORKOUT HOW TO ITERATE THROUGH ARRAY OF JSON OBJECTS
    // session_vars.forEach(
      // // function (value, idx, arr) {
      // function (value) {
        // console.log("id: [" + value.id + "] image_mdata: [" + value.image_mdata + "]");
      // }
    // );

    // 1. var numbers = [65, 44, 12, 4];
    // 2. numbers.forEach(myFunction)
    // 3. function myFunction(value, index, arr) {
    // 4.           arr[index] = item * 10;
    // 5.          }
    //* code storing data in $_SESSION
    // session_vars.forEach(
    //   function (image_mdata, id) {
    //     jsPostSessionData(image_mdata, id).then(
    //       function () {
    //         console.log("$_SESSION['" + slide_id + "'] should have been saved.");
    //       });
    //   }
    // );

    //* code storing data in window.sessionStorage
    if (typeof (Storage) !== "undefined") {
      // sessionStorage.clear();
      session_vars.forEach(
        function (value) {
          // console.log("id: [" + value.id + "] image_mdata: [" + value.image_mdata + "]");
          sessionStorage.setItem(value.id, value.image_mdata);
          //* retrieve saved item and display in console
          console.log("sessionStorage[" + value.id + "] : " + sessionStorage.getItem(value.id));
        }
      );
    }
    else {
      console.log("Sorry, your browser does not support Web Storage...");
    }

    //! GET $_SESSION data back and display
    // getSlideMetaData(slide_id);

  }

  function getApod() {
    $.ajax({
      
      // url : "https://api.nasa.gov/planetary/apod?api_key=prM66Z2Kgwfaloj6NNpLrJXb9gAcYRE5a4z1UsL2",
      url: "https://api.nasa.gov/planetary/apod?api_key=jDpuF0V85x4F99c50zfs182iKJgpnA7gbUKCKsgh",
      type: "GET",
      dataType: "json",
      success: function (data) {
        // console.log(data);
        $("#div-apod-img").html(
          "<div class='image-div'>"
          // + "<h3>Image of the day by NASA</h3>"
          // + "<img class='image' src=" + data.url + " >"
          + "<img class='apod-image' src=" + data.url + " >"
          + "<div class='image-info'>"
          +   "<h3>Image Title : " + data.title + "</h3>"
          +   "<hr><p style='text-align:justify;'>"
          +      "<b> Explanation :</ > " + data.explanation
          +   "</p > <hr>"
          +   "<p><b>Date :</b> " + new Date(data.date).toLocaleDateString() + "</p>"
          +   "<p><b>Media Type :</b> " + data.media_type + "</p>"
          +   "<p><b>Service Version :</b> " + data.service_version + "</p>"
          +   "<p><b>Copyright :</b> " + data.copyright + "</p>"
          + "</div>"
          +"</div > "
        )
      },
      error: function (xhr, status, errorThrown) {
        alert("Sorry, there was a problem!");
        console.log("Error: " + errorThrown);
        console.log("Status: " + status);
        console.dir(xhr);
      },
      complete: function () {
        // alert( "The request is complete!" );
      }

    });  // end of ajax function

  } //* end of function getApod()

}); // end of $(document).ready(...) 

