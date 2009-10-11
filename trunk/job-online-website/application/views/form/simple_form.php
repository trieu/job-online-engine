<style type="text/css">
    /**********************************

 Use: cmxform template
 Author: Nick Rigby

 ***********************************/

    form.cmxform fieldset { margin-bottom: 10px; }

    form.cmxform legend {
        padding: 0 2px;
        font-weight: bold;
        _margin: 0 -7px; /* IE Win */
    }

    form.cmxform label {
        display: inline-block;
        line-height: 1.8;
        vertical-align: top;
    }

    form.cmxform fieldset ol {
        margin: 0;
        padding: 0;
    }

    form.cmxform fieldset li {
        list-style: none;
        padding: 5px;
        margin: 0;
    }

    form.cmxform fieldset fieldset {
        border: none;
        margin: 3px 0 0;
    }

    form.cmxform fieldset fieldset legend {
        padding: 0 0 5px;
        font-weight: normal;
    }

    form.cmxform fieldset fieldset label {
        display: block;
        width: auto;
    }

    form.cmxform em {
        font-weight: bold;
        font-style: normal;
        color: #f00;
    }

    form.cmxform label { width: 120px; } /* Width of labels */
    form.cmxform fieldset fieldset label { margin-left: 123px; } /* Width plus 3 (html space) */

    /*\*//*/ form.cmxform legend { display: inline-block; } /* IE Mac legend fix */
    /**********************************

    Name: cmxform Styles
    Author: Nick Rigby

    ***********************************/

    form.cmxform {
        width: 370px;
        font-size: 1.1em;
        color: #333;
    }

    form.cmxform legend { padding-left: 0; }

    form.cmxform legend,
    form.cmxform label { color: #333; }

    form.cmxform fieldset {
        border: none;
        border-top: 1px solid #C9DCA6;
        background: lavender left bottom repeat-x;
    }

    form.cmxform fieldset fieldset { background: none; }

    form.cmxform fieldset li {
        padding: 5px 10px 7px;
        background: url(../images/cmxform-divider.gif) left bottom repeat-x;
    }

</style>
<a name="form_header"></a>
<form action="#" class="cmxform">
    <p>Please complete the form below. Mandatory fields marked <em>*</em></p>
    <fieldset id="q1">
        <legend>Delivery Details</legend>
        <ol>
            <li><label for="name">Name <em>*</em></label> <input id="name" /></li>

            <li><label for="address1">Address <em>*</em></label> <input id="address1" /></li>
            <li><label for="town-city">Town/City</label> <input id="town-city" /></li>
            <li><label for="county">County <em>*</em></label> <input id="county" /></li>
            <li><label for="postcode">Postcode <em>*</em></label> <input id="postcode" /></li>

            <li>
                <fieldset>
                    <legend>Is this address also your invoice address? <em>*</em></legend>
                    <label><input type="radio" name="invoice-address" /> Yes</label>
                    <label><input type="radio" name="invoice-address" /> No</label>
                </fieldset>

            </li>
        </ol>
        <input id="next" type="button" value="Next" />
    </fieldset >
    <fieldset id="q2" style="display:none;">
        <legend>Other Information</legend>
        <ol>
            <li><label for="dob">Date of Birth <span class="sr">(Day)</span> <em>*</em></label> <select id="dob"><option value="1">1</option><option value="2">2</option></select> <label for="dob-m" class="sr">Date of Birth (Month) <em>*</em></label> <select id="dob-m"><option value="1">Jan</option><option value="2">Feb</option></select> <label for="dob-y" class="sr">Date of Birth (Year) <em>*</em></label> <select id="dob-y"><option value="1979">1979</option><option value="1980">1980</option></select></li>

            <li><label for="sex">Sex <em>*</em></label> <select id="sex"><option value="female">Female</option><option value="male">Male</option></select></li>
            <li>
                <fieldset>
                    <legend>Which of the following sports do you enjoy?</legend>
                    <label for="football"><input id="football" type="checkbox" /> Football</label>

                    <label for="golf"><input id="golf" type="checkbox" /> Golf</label>
                    <label for="rugby"><input id="rugby" type="checkbox" /> Rugby</label>
                    <label for="tennis"><input id="tennis" type="checkbox" /> Tennis</label>
                    <label for="basketball"><input id="basketball" type="checkbox" /> Basketball</label>
                    <label for="boxing"><input id="boxing" type="checkbox" /> Boxing</label>

                </fieldset>
            </li>
            <li><label for="comments">Comments</label> <textarea id="comments" rows="7" cols="25"></textarea></li>
        </ol>
        <input id="back" type="button" value="Back" />
    </fieldset>
    <p><input type="submit" value="Submit order" /></p>
</form>
<script>
    google.setOnLoadCallback(function() {
        jQuery(document).ready(function(){
            $("#next").click(function () {
                $("#q1").hide("slide", { direction: "up" }, 1000, function(){
                    $("#q2").show("slide", { direction: "up" }, 1000);
                    window.location = "#form_header";
                });
            });
            $("#back").click(function () {
                $("#q2").hide("slide", { direction: "up" }, 1000,  function(){
                    $("#q1").show("slide", { direction: "up" }, 1000);
                    window.location = "#form_header";
                });
            });
        });
    });
</script>