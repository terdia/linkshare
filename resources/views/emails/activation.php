<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title></title>   
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

</head>
<body>

<h4>Dear <?= $data['name'] ?>,</h4>

<p>
    Please click on the link below to activate your LinkShare Account <br />
    <a href="http://<?= config('APP_URL') ?>/auth/activation/<?= $data['code'] ?>">
        Activate your account
    </a>
</p>

</body>
</html>
