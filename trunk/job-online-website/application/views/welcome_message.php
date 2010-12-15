
<h1>Welcome to CodeIgniter!</h1>

<p>The page you are looking at is being generated dynamically by CodeIgniter.</p>

<p>If you would like to edit this page you'll find it located at:</p>
<code>system/application/views/welcome_message.php</code>


<script type="text/javascript">
    var _f_n_ = function(s){
        this.data = {a:1};
        if(s) {
            alert(s);
        }
        this.exec = function(){
            _f_n_.apply({},[s]);
        };
    };

    var rawFunc = _f_n_.toSource().replace('_f_n_', 'f2');
    var rawObj = 'var f2 = ' + rawFunc + ' ;new f2("hi, I am exist here").exec();';
    var scriptText = '<script type="text/javascript">' + rawObj + '<\/script>';
    console.log( rawObj );
    //console.log( f );
    //new f('hi, I am exist here').exec();
    eval(rawObj);
    //$("body").append( rawObj );
</script>
