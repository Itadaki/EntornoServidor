<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
    <head>
        <meta charset="UTF-8">
        <title></title>
    </head>
    <body>
        <!DOCTYPE html>
    <html>
        <body>

            <p>
                Depending on browser support:<br>
                The input type "range" can be diplayed as a slider control.
            </p>

            <form action="demo_form.asp" method="get">
                Points:
                <input id="u" type="range" name="points" min="0" max="10">
                <input type="submit" value="Send">
            </form>
            <script type="text/javascript">
                alert(document.getElementById('u').value;
            </script>
            <p>
                <b>Note:</b>
                type="range" is not supported in Internet Explorer 9 and earlier versions.
            </p>

        </body>
    </html>


</body>
</html>
