<?php
    require_once 'functions.php';

    echo'

    <meta http-equiv="Refresh" content="0;url=login.php">

    <title>logout</title>

    </head>

    <body>';
    if (isset($_SESSION['user']))
    {
        destroySession();
    }

    echo'

    </body>

    </html>
    ';

?>
