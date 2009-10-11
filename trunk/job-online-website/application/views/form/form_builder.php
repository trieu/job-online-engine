
<style type="text/css">
    #draggable { width: 100px; height: 100px; padding: 0.5em; float: left; margin: 10px 10px 10px 0;cursor:move }
    #droppable { width: 150px; height: 150px; padding: 0.5em; float: left; margin: 10px; }
</style>


<div class="demo">

    <div id="draggable" class="ui-widget-content">
        <input type="text" name="test" value="" style="width: 90px;"/>
    </div>

    <div id="droppable" class="ui-widget-header">
        <p>Drop here</p>
    </div>

</div>

<script type="text/javascript">
    jQuery(function() {
        jQuery("#draggable").draggable();
        jQuery("#droppable").droppable({
            drop: function(event, ui) {
                jQuery(this).addClass('ui-state-highlight').find('p').html('Dropped!');
                alert(jQuery(ui.draggable).html());
                //console.log(event);
            }
        });

    });
</script>
