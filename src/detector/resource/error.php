<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Error <?=$code?></title>
    <style>
        .error {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            font-family: Calibri;
            text-align: center;
            color: rgba(0,0,0,0.4);
        }

        .code {
            color: rgba(0,0,0,0.4);
            font-size: 30px;
            font-weight: bolder;
        }

        .info {
            font-size: 12px;
        }
    </style>
</head>
<body>
<div class="error">
    <div class="code">
        <?=$code?> | Error
    </div>
    <div class="info">
        <?=$error;?>
    </div>
</div>
</body>
</html>
