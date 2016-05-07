$(function () 
  {
$.ajax({                                      
      url: 'bdd_ajax.php',                  //the script to call to get data          
      data: "",                        //you can insert url argumnets here to pass to api.php
                                       //for example "id=5&parent=6"
      dataType: 'json',                //data format      
      success: function(data)          //on recieve of reply
      {
		            //get name
        //--------------------------------------------------------------------
        // 3) Update html content
        //--------------------------------------------------------------------
        $('#contenu').html("<b>id: </b>"+id+"<b> name: </b>"+vname); //Set output element html
        //recommend reading up on jquery selectors they are awesome 
        // http://api.jquery.com/category/selectors/
      } 
    });
}); 
