<style type="text/css" media="screen">
    .resizable {       
        background-color: lavender;
        margin: 4px;
        height:30px;
    }
    #form_builder_container {
        border:1px solid #DDDDDD;
        clear:right;
        height:500px;
        overflow:auto;
        position:relative;
        width:700px;
    }
</style>
<div id="form_builder_container" >
    <div class="resizable">
        Resizable1        
    </div>
    <div class="resizable">
        Resizable2
      
    </div>
    <div class="resizable">
        Resizable3
       
    </div>
    <div class="resizable">
        Resizable4       
    </div>
</div>
<script type="text/javascript">


    jQuery(document).ready(function() {
        var sortOpts = {
            axis: "y",
            containment: '#form_builder_container',
            cursor: "move",
            distance: 3
        };
        jQuery("#form_builder_container").sortable(sortOpts);

        var resizeOpts = {                 
          maxWidth : 700 - 5 ,
          maxHeight: 800 ,
          minHeight: 40,
          minWidth : 60
        };
        jQuery("#form_builder_container div.resizable").resizable(resizeOpts);
    });

</script>

