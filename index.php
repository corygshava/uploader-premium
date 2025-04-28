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
    </style>
</head>
<body>
    <div class="content">
        <div class="callout w3-center">
            <h1>info</h1>
            <p>a catchy tagline</p>
            <div class="w3-center">
                <button class="themebtn active">go</button>
                <a class="themebtn" href="uploaded.php">view uploads</a>
            </div>
        </div>
    </div>
</body>