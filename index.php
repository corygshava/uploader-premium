<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Uploader Premium by CoryG</title>

    <link rel="stylesheet" href="css/styles.css">
    <link rel="stylesheet" href="css/w3.css">

    <style>
        *{
            box-sizing: border-box;
        }

        body{
            /* background-image: linear-gradient(80deg,var(--modeColor),var(--primaryColor) 90%); */
            /* background-image: url('images/mainbg.jpg'); */
        }

        .content{
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .callout{
            padding: 20px;
            max-width: 400px;
            width: 96%;
            border-radius: var(--roundness);
            background-color: var(--panelbg);
        }
        .callout h1{
            margin: 10px 0 20px 0;
            border-bottom: 1px solid var(--themecolor);
        }

        .themebtn.active{
            background-color: var(--themecolor);
        }
        .themebtn{
            padding: 12px 16px;
            border:none;
            border-radius: 12px;
            background-color: #eee;
            color: #111;
            text-decoration: none;
        }

        nav {
            position: fixed;
            top: 0;
            width: 100%;
            box-shadow: 0 0 12px rgba(0,0,0,0.3);
            padding: 0 20px;
            background-color: var(--bodybg);
            color: var(--textcolor);
            display: flex;
            align-items: center;
            justify-content: space-between;
        }
        nav .logo{
            padding: 20px;
            font-weight: 800;
        }
        nav .links a{
            padding: 20px 12px;
        }
        nav .links a.current{
            border-bottom: 2px solid var(--themecolor);
            color: var(--themecolor);
        }
    </style>
</head>
<body>
    <nav>
        <div class="logo">
            <b>Uploader P*</b>
        </div>
        <div class="links">
            <a href="index.php" class="current">home</a>
            <a href="uploadfile.php">upload</a>
            <a href="uploaded.php">files</a>
        </div>
    </nav>
    <div class="content">
        <div class="callout w3-center">
            <h1>Your files anywhere, anytime</h1>
            <p>Secure lockbox storage for all your files both big and small.</p>
            <i class="themetxt">work in progress</i>
            <div class="w3-center">
                <button class="themebtn active">go</button>
                <a class="themebtn" href="uploaded.php">view uploads</a>
            </div>
        </div>
    </div>
</body>