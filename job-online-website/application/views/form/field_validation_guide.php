<h1>Rule Reference</h1>
<p>The following is a list of all the native rules that are available to use:</p>
<table cellspacing="1" cellpadding="0" border="1" class="tableborder" style="width: 100%;">
    <tbody>
        <tr>
            <th>Rule</th>
            <th>Parameter</th>
            <th>Description</th>
            <th>Example</th>
        </tr>
        <tr>

            <td class="td"><strong>required</strong></td>
            <td class="td">No</td>
            <td class="td">Returns FALSE if the form element is empty.</td>
            <td class="td"> </td>
        </tr>
        <tr>

            <td class="td"><strong>matches</strong></td>
            <td class="td">Yes</td>
            <td class="td">Returns FALSE if the form element does not match the one in the parameter.</td>
            <td class="td">matches[form_item]</td>
        </tr>
        <tr>

            <td class="td"><strong>min_length</strong></td>
            <td class="td">Yes</td>
            <td class="td">Returns FALSE if the form element is shorter then the parameter value.</td>
            <td class="td">min_length[6]</td>
        </tr>
        <tr>

            <td class="td"><strong>max_length</strong></td>
            <td class="td">Yes</td>
            <td class="td">Returns FALSE if the form element is longer then the parameter value.</td>
            <td class="td">max_length[12]</td>
        </tr>
        <tr>

            <td class="td"><strong>exact_length</strong></td>
            <td class="td">Yes</td>
            <td class="td">Returns FALSE if the form element is not exactly the parameter value.</td>
            <td class="td">exact_length[8]</td>
        </tr>
        <tr>

            <td class="td"><strong>alpha</strong></td>
            <td class="td">No</td>
            <td class="td">Returns FALSE if the form element contains anything other than alphabetical characters.</td>
            <td class="td"> </td>
        </tr>
        <tr>

            <td class="td"><strong>alpha_numeric</strong></td>
            <td class="td">No</td>
            <td class="td">Returns FALSE if the form element contains anything other than alpha-numeric characters.</td>
            <td class="td"> </td>
        </tr>
        <tr>

            <td class="td"><strong>alpha_dash</strong></td>
            <td class="td">No</td>
            <td class="td">Returns FALSE if the form element contains anything other than alpha-numeric characters, underscores or dashes.</td>
            <td class="td"> </td>
        </tr>

        <tr>
            <td class="td"><strong>numeric</strong></td>
            <td class="td">No</td>
            <td class="td">Returns FALSE if the form element contains anything other than numeric characters.</td>
            <td class="td"> </td>
        </tr>

        <tr>
            <td class="td"><strong>integer</strong></td>
            <td class="td">No</td>
            <td class="td">Returns FALSE if the form element contains anything other than an integer.</td>
            <td class="td"> </td>
        </tr>

        <tr>
            <td class="td"><strong>is_natural</strong></td>
            <td class="td">No</td>
            <td class="td">Returns FALSE if the form element contains anything other than a natural number: 0, 1, 2, 3, etc.</td>
            <td class="td"> </td>
        </tr>

        <tr>
            <td class="td"><strong>is_natural_no_zero</strong></td>
            <td class="td">No</td>
            <td class="td">Returns FALSE if the form element contains anything other than a natural number, but not zero: 1, 2, 3, etc.</td>
            <td class="td"> </td>
        </tr>

        <tr>
            <td class="td"><strong>valid_email</strong></td>
            <td class="td">No</td>
            <td class="td">Returns FALSE if the form element does not contain a valid email address.</td>
            <td class="td"> </td>
        </tr>

        <tr>
            <td class="td"><strong>valid_emails</strong></td>
            <td class="td">No</td>
            <td class="td">Returns FALSE if any value provided in a comma separated list is not a valid email.</td>
            <td class="td"> </td>
        </tr>

        <tr>
            <td class="td"><strong>valid_ip</strong></td>
            <td class="td">No</td>
            <td class="td">Returns FALSE if the supplied IP is not valid.</td>
            <td class="td"> </td>
        </tr>

        <tr>
            <td class="td"><strong>valid_base64</strong></td>
            <td class="td">No</td>
            <td class="td">Returns FALSE if the supplied string contains anything other than valid Base64 characters.</td>
            <td class="td"> </td>
        </tr>


    </tbody>
</table>