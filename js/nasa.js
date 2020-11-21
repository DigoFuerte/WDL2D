$(document).ready(function () {

  // $("p").click(function () {
  //   $(this).hide();
  // });


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
const NASA_IMAGES_API_URL = 'https://images-api.nasa.gov/search';
// no key required ... ???
  
const SESSION_KEY_TEST = 'jq_php_test';
const SESSION_KEY_APOD = 'jq_php_apod';

  // let jq_value = '888-HHH-7890';
  // let jq_value = '333-XXX-2347';
  // let jq_value = '999-VVV-3721';
  // var jq_value = '101-YVX-5193';
  var jq_value = '144-HWX-1838';

  //var session_key = SESSION_KEY_TEST;
  //jsPostSessionData(jq_value, session_key)
  // // var retValue;
  // // jsGetSessionData(session_key);
  // order required by Foreach() .... value, index,       arr {not need in this case}
  // async function jsPostSessionData(jq_value, session_key = "") {  .
  //* ...$_SESSION
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

  //* wrapper function for jsGetSessionData() ...$_SESSION
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
    
    session_vars.forEach(
      function (value) {
        console.log("SEEKING $_SESSION variable: " + value);
      }
    );

  } // endof function getSlideMetaData()

  //? ....... CODE TEST FOR PROMISE ....... 
  //jsGetSessionData(session_key).then(
  //  function (result) {
  //    console.log("$_SESSION['" + session_key + "'] found with value: {" + result + "}");
  //  },
  //);
  //* ... $_SESSION
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
    ); //* end of jsGetSessionPromise

    //? return the outcome of the Promise to the calling block
    return await jsGetSessionPromise;

  } //* end of function function jsGetSessionData() 

  //! ....... APOD CODE TEST ....... 
  // getApod();
  getApodWindow();
  //! ....... APOD CODE TEST ....... 
  
  function getApodWindow() { 
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

    //! ... CODE TEST FOR: NASA SEARCH PROMISE ...
    getNasaSearchResults().then(
      //* check nasa search result
      showNasaSearchResults()
    );
    //! ...       END OF TEST CODE             ...
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
        //* ... sessionStorage ... client-side
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
        console.log("Error: " + errorThrown);
        console.log("Status: " + status);
        console.dir(xhr);
      },
      complete: function () {
        // alert( "The request is complete!" );
      }

    });  // end of ajax function

  } // end of function displayApodImage()

  //* function to issue query to NASA API
  async function getNasaSearchResults(qryString="") {
    //* https://images-api.nasa.gov/search
    //*   ?q=apollo%2011
    //*   &description=moon%20landing
    //*   &media_type=image

    if (qryString.trim() === "") {
      qryString = "?q=apollo%2011&description=moon%20landing&media_type=image"
    }

    let str_url = NASA_IMAGES_API_URL + qryString
    
    //* WRAP AJAX CALLS IN A PROMISE
    let ajaxPromise = new Promise(
      function (funcResolve, funcReject) {

        $.ajax({
          url: str_url,
          type: 'GET',
          async: true,
          dataType: 'json',
          success: function (data) {
            console.log("NASA MEDIA SEARCH: 01");
            // console.log(data);
            // console.log(Object.keys((data.collection)));
            // console.log(data.collection.items);
            let nasa_search_count = 0;
            let _date_01;
            // let _date_02;
            let _hdurl;
            let _url;
            let _title;
            let _description_01;
            // let _description_02;
            let _media_type;
            let _copyright;
            let _thumbnail;
            data.collection.items.forEach((element) => {
              // console.log("element.href: " + element.href);
              // console.log("element.data.date: " + element.data[0].date_created);
              _date_01 = element.data[0].date_created;
              // console.log("element.data.title: " + element.data[0].title);
              _title = element.data[0].title;
              // console.log("element.data.description: " + element.data[0].description);
              _description_01 = element.data[0].description;
              // console.log("element.data.media_type: " + element.data[0].media_type);
              _media_type = element.data[0].media_type;
          
              //* INNER AJAX CALL TO COLLECTION JSON
              $.ajax({
                url: element.href,
                type: 'GET',
                async: true,
                dataType: 'json',
                success: function (cjsonData) {
                  console.log("NASA MEDIA SEARCH: 02");
                  //               cjsonData[0] ... http://images-assets.nasa.gov/image/NHQ201907180119/NHQ201907180119~orig.tif,
                  // hdurl    ... cjsonData[1] ... http://images-assets.nasa.gov/image/NHQ201907180119/NHQ201907180119~large.jpg,
                  // console.log("cjsonData[1] ~large.jpg: " + cjsonData[1]);
                  _hdurl = cjsonData[1];
                  // url      ... cjsonData[2] ... http://images-assets.nasa.gov/image/NHQ201907180119/NHQ201907180119~medium.jpg,
                  // console.log("cjsonData[2] ~medium.jpg: " + cjsonData[2]);
                  _url = cjsonData[2];
                  //           ... cjsonData[3] ... http://images-assets.nasa.gov/image/NHQ201907180119/NHQ201907180119~small.jpg,
                  // thumb    ... cjsonData[4] ... http://images-assets.nasa.gov/image/NHQ201907180119/NHQ201907180119~thumb.jpg,
                  // console.log("cjsonData[4] thumbnail: " + cjsonData[4]);
                  _thumbnail = cjsonData[4];
              
                  //* metadata ... cjsonData[5] ... http://images-assets.nasa.gov/image/NHQ201907180119/metadata.json
                  //* INNER AJAX CALL TO METADATA
                  $.ajax({
                    url: cjsonData[5],
                    type: 'GET',
                    async: true,
                    dataType: 'json',
                    success: function (meta_data) {
                      console.log("NASA MEDIA SEARCH: 03");
                      // console.log("AVAIL Date Created: " + meta_data["AVAIL:DateCreated"]);
                      // _date_02 = meta_data["AVAIL:DateCreated"];                
                      // console.log("AVAIL Copyright: " + meta_data["EXIF:Copyright"]);
                      _copyright = meta_data["EXIF:Copyright"];
                      // console.log("AVAIL Description: " + meta_data["AVAIL:Description"]);
                      _description_02 = meta_data["AVAIL:Description"];
                  
                      //* show collected information
                      // console.log(nasa_search_key + nasa_search_count + "_date_01: " + _date_01);
                      // console.log(nasa_search_key + nasa_search_count + "_date_02: " + _date_02);
                      // console.log(nasa_search_key + nasa_search_count + "_hdurl: " + _hdurl);
                      // console.log(nasa_search_key + nasa_search_count + "_url: " + _url);
                      // console.log(nasa_search_key + nasa_search_count + "_title: " + _title);
                      // console.log(nasa_search_key + nasa_search_count + "_description_01: " + _description_01);
                      // console.log(nasa_search_key + nasa_search_count + "_description_02: " + _description_02);
                      // console.log(nasa_search_key + nasa_search_count + "_media_type: " + _media_type);
                      // console.log(nasa_search_key + nasa_search_count + "_copyright: " + _copyright);
                  
                      //* save detail in sessionStorage
                      // sessionStorage.setItem(key, value);
                      nasa_search_count++;
                      let nasa_search_key = "nasa_search_key_" + nasa_search_count;
                      sessionStorage.setItem((nasa_search_key + "_date"), _date_01);
                      sessionStorage.setItem((nasa_search_key + "_hdurl"), _hdurl);
                      sessionStorage.setItem((nasa_search_key + "_url"), _url);
                      sessionStorage.setItem((nasa_search_key + "_title"), _title);
                      sessionStorage.setItem((nasa_search_key + "_explanation"), _description_01);
                      sessionStorage.setItem((nasa_search_key + "_media_type"), _media_type);
                      sessionStorage.setItem((nasa_search_key + "_copyright"), _copyright);
                      sessionStorage.setItem((nasa_search_key + "_thumbnail"), _thumbnail);
                      //* leave a hint as to how many search result are in sessionStorage
                      sessionStorage.setItem("nasa_search_count", nasa_search_count);

                    },
                    error: function (xhr, status, errorThrown) {
                      console.log("INNER AJAX MDATA Error: " + errorThrown);
                      console.log("INNER AJAX MDATA Status: " + status);
                      console.dir(xhr);
                    }
                  });
                  //* ______________________
                  // console.log("_date_01): ", _date_01);
                  // console.log("_date_02: ", _date_02);
                  // console.log("_hdurl: ", _hdurl);
                  // console.log("_url: ", _url);
                  // console.log("_title: ", _title);
                  // console.log("_description_01: ", _description_01);
                  // console.log("_description_02: ", _description_02);
                  // console.log("_media_type: ", _media_type);
                  // console.log("_copyright: ", _copyright);
                },
                error: function (xhr, status, errorThrown) {
                  console.log("INNER AJAX Error: " + errorThrown);
                  console.log("INNER AJAX Status: " + status);
                  console.dir(xhr);
                }
              });
              //* _____________________________              
            }); // end of data.collection.items.forEach((element))
            funcResolve();
          },
          error: function (xhr, status, errorThrown) {
            console.log("MAIN AJAX Error: " + errorThrown);
            console.log("MAIN AJAX Status: " + status);
            console.dir(xhr);
            funcReject(errorThrown);
          }
        });  // end of ajax function
        
        //* return the outcome of the Promise to the calling block
        //* ... in this case, 
        //*     simply wait until ajax calls have completed before exiting 
      }


    ); // end of promise ... ajaxPromise

    return await ajaxPromise;

  }

  //* function to return JS oBject nasa search result in sessionStorage
  function getNasaSearchItem(idx_search_result) {

    let nasa_search_key = "nasa_search_key_" + idx_search_result;
    let _date = sessionStorage.getItem( (nasa_search_key + "_date") );
    let _hdurl = sessionStorage.getItem( (nasa_search_key + "_hdurl") );
    let _url = sessionStorage.getItem( (nasa_search_key + "_url") );
    let _title = sessionStorage.getItem( (nasa_search_key + "_title") );                  
    let _explanation = sessionStorage.getItem( (nasa_search_key + "_explanation") );
    let _media_type = sessionStorage.getItem( (nasa_search_key + "_media_type") );
    let _copyright = sessionStorage.getItem((nasa_search_key + "_copyright") );
    let _thumbnail = sessionStorage.getItem((nasa_search_key + "_thumbnail"));
    
    return { date: _date,
             hdurl: _hdurl,
             url: _url,
             title: _title,                  
             explanation: _explanation,
             media_type: _media_type,
             copyright: _copyright,
             thumbnail: _thumbnail };
  } // end of function getNasaSearchResults()

  //* function to get all nasa search items() 
  function showNasaSearchResults() {
    //* get search result count
    let search_count = sessionStorage.getItem("nasa_search_count");
    for (var idx = 1; idx <= search_count; idx++) {
      let search_result = getNasaSearchItem(idx);
      console.log("search result {" + idx + "}:");
      console.log(search_result);
    }
  } // end of function showNasaSearchResults()

  //          DATA TO SAVE IN SESSION
  // 1  slide_id:        "slide-07"
  //    DATA FROM APOD IMAGES ... data.{...}
  // 2. copyright:       "Casey Good/Steve Timmons"
  // 3. date:            "2020-10-29"
  // 4. explanation:     "Inspired by the halloween ... this frame at the upper left."
  // 5. hdurl:           "https://apod.nasa.gov/apod/image/2010/GhoulGood.jpg"
  // 6. media_type:      {"image","video"}
  // 7. service_version: "v1"
  // 8. title:           "The Ghoul of IC 2118"
  // 9. url:             "https://apod.nasa.gov/apod/image/2010/GhoulGood_1024.jpg"
  //          DATA FROM APOD IMAGES

  function storeApodData (slide_id, data) {
    //* copyright ... in some cases this field will contain "undefined"
    let session_vars = [ {id:(slide_id + "_copyright"), image_mdata:data.copyright},
                         {id:(slide_id + "_date"), image_mdata:data.date},
                         {id:(slide_id + "_explanation"), image_mdata:data.explanation},
                         {id:(slide_id + "_hdurl"), image_mdata:data.hdurl},
                         {id:(slide_id + "_media_type"), image_mdata:data.media_type},
                         {id:(slide_id + "_service_version"), image_mdata:data.service_version},
                         {id:(slide_id + "_title"), image_mdata:data.title},
                         {id:(slide_id + "_url"), image_mdata:data.url},
                         {id:(slide_id + "_flag"), image_mdata:false} ];

    //* code for storing data in window.sessionStorage
    if (typeof (Storage) !== "undefined") {
      // sessionStorage.clear();
      session_vars.forEach(
        function (value) {
          // console.log("id: [" + value.id + "] image_mdata: [" + value.image_mdata + "]");
          sessionStorage.setItem(value.id, value.image_mdata);
          //* retrieve saved item and display in console
          // console.log("sessionStorage[" + value.id + "] : " + sessionStorage.getItem(value.id));
        }
      );
    }
    else {
      console.log("Sorry, your browser does not support Web Storage...");
    }

  } // end of function storeApodData()

  //! function incomplete
  function getSelectedSlide(slide_id) {    
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
        value.meta_data = sessionStorage.getItem(value.id);
        console.log("GET: sessionStorage[" + value.id + "] : " + value.meta_data);
      }
    );
  }
  //! function incomplete

}); // end of $(document).ready(...) 

//* __________________________
//*  OUTSIDE OF jQUERY BLOCK

