
    var slide_id;

    if (window.addEventListener) { // Mozilla, Netscape, Firefox
        // window.addEventListener('load', myWindowLoadFunc, false);
        console.log("01 slide_id: " + slide_id);
        window.addEventListener('load', getSlideId, false);
        console.log("02 slide_id: " + slide_id);
    } 
    else if (window.attachEvent) { // IE
        // window.attachEvent('onload', myWindowLoadFunc);
        console.log("IE.01 slide_id: " + slide_id);
        window.attachEvent('onload', getSlideId);
        console.log("IE.02 slide_id: " + slide_id);
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

    //* function to populate media_view.php ... after slide_id taken from query string
    function displaySlide(slide_id) {
      // console.log("DISPLAYING MEDIA NOW...");
      //*form key-value for hdurl
      var str_html = ""
      var sess_key = slide_id + "_hdurl";
      var sess_value = sessionStorage.getItem(sess_key);
      
      // console.log("sess_key: " + sess_key + " ... " + "sess_value: " + sess_value);
      $(media_div).html("<img class='apod-image' src='" + sess_value + "' alt='" + slide_id + "'></>");   

      // save button
      console.log("Setting up SAVE BUTTON: " + slide_id);
      $(save_media_btn).on("click", function () {
                                      // disable the button
                                      $(this).prop('disabled', true);
                                      console.log("01 INSIDE anonymous function: " + slide_id);
                                      // create empty json object 
                                      //   will contain data to be picked up server-side in $_POST 
                                      var obj_data_param = {}; 
                                      //obj_data_param['P_USER_ID'] = user_id;                                      
                                      // first parameter for ajax ... slide_id
                                      obj_data_param['slide_id'] = slide_id;
                                      console.log("02 INSIDE anonymous function: obj_data_param['slide_id'] = " + obj_data_param['slide_id']);
                                      // extract slide media meta data from sessionStorage
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
                                          // provide slide details from sessionStorage
                                          value.meta_data = sessionStorage.getItem(value.id);
                                          obj_data_param[value.id] = value.meta_data;
                                          console.log("GET: obj_data_param[" + value.id + "]: " + obj_data_param[value.id]);
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

                                    } // } // end of anonymous function                                    
      );
    
      // title
      sess_key = slide_id + "_title";
      sess_value = sessionStorage.getItem(sess_key);
      // console.log("sess_key: " + sess_key + " ... " + "sess_value: " + sess_value);
      $(title_para).html(sess_value);

      // copyright
      sess_key = slide_id + "_copyright";
      sess_value = sessionStorage.getItem(sess_key);
      // console.log("sess_key: " + sess_key + " ... " + "sess_value: " + sess_value);
      if (sess_value != "undefined") { 
          str_html = "<i class='far fa-copyright'></i><p id='copyright_para' style='display:inline-block;'>";
          str_html += sess_value + "</p><br>";
          $(copyright_div).html(str_html); 
      }
          
      // date
      sess_key = slide_id + "_date";
      sess_value = sessionStorage.getItem(sess_key);
      // console.log("sess_key: " + sess_key + " ... " + "sess_value: " + sess_value);
      str_html = "<i class='far fa-clock'></i><p id='date_para' style='display:inline-block;'>";
      str_html += sess_value + "</p><br>";
      $(date_div).html(str_html); 

      // explanation
      sess_key = slide_id + "_explanation";
      sess_value = sessionStorage.getItem(sess_key);
      // console.log("sess_key: " + sess_key + " ... " + "sess_value: " + sess_value);
      str_html = "<i class='fas fa-info'></i><p id='explanation_para' style='display:inline-block;'>";
      str_html += sess_value + "</p>";
      $(explanation_div).html(str_html); 

    }

    //* function to be called from media_view.php on page-load
    function getSlideId(event) {
        console.log("CHECKING FLAG NOW...");
        slide_id = getQueryStringValue("selected_slide");
        console.log("Query string slide_id: " + slide_id);
        // populate web page
        displaySlide(slide_id);        
        return slide_id;
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
      success: function (result) {},
      //* super set of jqXHR: jQuery Xml Http Request Object
      error: function (_jqXHR, strStatus, strErrorThrown) {
        //* AJAX CALL GIVES AN ERROR 
        let strError = "{ [" + strStatus + "] [" + strErrorThrown + "] }";
        return strError;
      }
    });

  } //* end of function function saveUserMedia() 
