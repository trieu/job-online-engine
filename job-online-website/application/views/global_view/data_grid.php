<style type="text/css" media="screen">
    .editable_table_cell{
        margin: 2px 4px;
        padding:1px 2px;
    }
    .editable_table_cell input{
        display:block;       
    }
    .editable_table_cell textarea{
        display:block;       
    }
    table div[class=editable_table_cell]:hover {
        background-color:#330099;
        color:#FFFF00;
        cursor:pointer;
        text-decoration:none;        
    }

    .editable_table_cell a{
        cursor:pointer;
        text-decoration:underline;
    }

    .editable_table_cell a:hover{
        background-color:#330099;
        color:#FFFF00;      
        text-decoration:underline;
    }

    .editable_table_cell_hover {
        background-color:#330099;
        color:#FFFF00;
        cursor:pointer;
        text-decoration:none;
    }
</style>
<script language="JavaScript" src="<?= base_url()?>assets/js/jquery.bt/jquery.bt.min.js"></script>
<script language="JavaScript" src="<?= base_url()?>assets/js/jquery.pagination/jquery.pagination.js"></script>
<link type="text/css" rel="stylesheet" media="screen" href="<?= base_url()?>assets/js/jquery.pagination/style.css"/>
<script language="JavaScript" src="<?= base_url()?>assets/js/jquery/jquery.jeditable.js"></script>

<?php
$table_template = array (
    'table_open'          => '<table border="1" cellpadding="4" cellspacing="0" id="'.$table_name.'">',

    'heading_row_start'   => '<tr>',
    'heading_row_end'     => '</tr>',
    'heading_cell_start'  => '<th>',
    'heading_cell_end'    => '</th>',

    'row_start'           => '<tr>',
    'row_end'             => '</tr>',
    'cell_start'          => '<td><div class="editable_table_cell">',
    'cell_end'            => '</div></td>',

    'row_alt_start'       => '<tr>',
    'row_alt_end'         => '</tr>',
    'cell_alt_start'      => '<td><div class="editable_table_cell">',
    'cell_alt_end'        => '</div></td>',

    'table_close'         => '</table>'
);

$this->table->set_template($table_template);
$this->table->set_heading($data_table_heading);
echo $this->table->generate($data_table);
echo("<div id='grid_pagination' class='pagination' align='center'></div>");

if( isset ($description)) {
    echo br().$description;
}
?>


<script type="text/javascript" language="JavaScript">

    var table_name = "<?= $table_name ?>";
    var data_editable_fields = null;
    var editable_type_fields = new Array();
    var pagination_config = null;
<?php
if(isset ($data_editable_fields)) {
    echo "data_editable_fields = ".json_encode($data_editable_fields).";";
}
if(isset ($editable_type_fields)) {
    echo "editable_type_fields = ".json_encode($editable_type_fields).";";
}
if(isset ($pagination_config)) {
    echo "pagination_config = ".json_encode($pagination_config).";";
}
?>

    function initEditableTableCell(){
        var arr = [];
        jQuery("#"+ table_name +" th").each(function(){
            arr.push(jQuery(this).html().trim());
        });
        var r, c = 0, node = null;
        var f = function(i){
            if( (i + arr.length) % arr.length == 0){
                r = (jQuery(this).find("div[class='editable_table_cell']").html());
                c = 0;
            }
            var id = table_name+"-"+r+"-"+arr[c];
            if(data_editable_fields != null){
                if(data_editable_fields[arr[c]]){
                    node = jQuery(this).find("div[class='editable_table_cell']");
                    jQuery(node).attr("id",id);
                    setEditableTableCell(node, editable_type_fields[arr[c]]);
                }
            }
            else {
                node = jQuery(this).find("div[class='editable_table_cell']");
                jQuery(node).attr("id",id);
                setEditableTableCell(node, editable_type_fields[arr[c]]);
            }
            c++;
        };
        jQuery("#"+ table_name +" td").each(f);
    }



    function setEditableTableCell(node, edit_type){
        var field_value = jQuery(node).html().trim();
        var tip = field_value;
        if(tip == ""){
            tip = "Click to edit ...";
        }
        else if(tip.length > 20){
            tip = "Click to edit \"" + tip.substr(0, 20)+" ... \"";
        }
        else {
            tip = "Click to edit \"" + tip +"\"";
        }

        if(edit_type == null) {
            jQuery(node).editable("<?php echo site_url($edit_in_place_uri); ?>", {
                type      : 'textarea',
                cancel    : 'Cancel',
                submit    : 'Save',
                indicator : "<span style='color:red;font-weight:bold;'>Saving...</span>",
                tooltip   : tip,
                id   : 'editable_field_name',
                name : 'editable_field_value'
            });           
        }
        else {

            var select_data = jQuery.extend(true, {}, edit_type["data"]);
            select_data["selected"] = field_value;
            tip = field_value + " = " + select_data[select_data["selected"]] + ". Click to edít!";

            jQuery(node).editable("<?php echo site_url($edit_in_place_uri); ?>", {
                type      : edit_type["type"],
                data  : select_data,
                callback : function(value, settings) {
                    window.location.reload();
                },
                cancel    : 'Cancel',
                submit    : 'Save',
                indicator : "<span style='color:red;font-weight:bold;'>Saving...</span>",
                style  : "inherit",
                tooltip   : tip,
                id   : 'editable_field_name',
                name : 'editable_field_value'
            });
            jQuery(node).attr("show_tip", "true");
        }
        //Hack css:hover for IE
        if(jQuery.browser["msie"]){
            jQuery(node).mouseover(function(){jQuery(this).addClass("editable_table_cell_hover");});
            jQuery(node).mouseout(function(){jQuery(this).removeClass("editable_table_cell_hover");});
        }
    }

    function initTooltipForEditableFields(){
        jQuery("div[class='editable_table_cell'][show_tip]").bt({
            shrinkToFit: true,
            cssStyles: {
                fontFamily: '"Lucida Grande",Helvetica,Arial,Verdana,sans-serif',
                fontSize: '14px',
                padding: '10px 14px'
            },
            shadow: true
        });
    }

    jQuery(document).ready(function() {
        initEditableTableCell();
        initTooltipForEditableFields();
        initPagination();
    });


    function initPagination() {
        if(pagination_config != null){
            // First Parameter: number of items
            // Second Parameter: options object
            jQuery("#grid_pagination").pagination( pagination_config["total_rows"], {
                items_per_page: pagination_config["per_page"] ,
                callback:handlePaginationClick
            });
            setPaginationLink();
        }
    }
    function setPaginationLink(){
        jQuery("#grid_pagination a").each(function(){
            var text = jQuery(this).html().trim();
            jQuery(this).attr("href", "javascript:void("+text+")");
            if(text == "Next"){
                jQuery(this).attr("href", "javascript:alert('next')");
            }
            else if(text == "Prev") {
                jQuery(this).attr("href", "javascript:alert('prev')");
            }
        });
    }

    function handlePaginationClick(new_page_index, pagination_container) {
        setPaginationLink();
    }


</script>
