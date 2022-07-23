<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
    <form action="" method="POST">
        @csrf
        <span>name</span>
        <input type="text" name="name" placeholder="name">
        <br>
        <span>email</span>
        <input type="email" name="email" placeholder="email">
        <br>
        <span>password</span>
        <input type="password" name="password" placeholder="password">
        <br>
        <span>details</span>
        <input type="details" name="details" placeholder="details">
        <br>
        <span>Company name</span>
        <input type="text" name="nameCompany" placeholder="nameCompany">
        <br>
        <span>details of the company</span>
        <input type="text" name="details" placeholder="details">
        <br>
        <span>images</span>
        <input type="file" name="images" placeholder="images">
        <br>
        <span>phone_number</span>
        <input type="text" name="phone_number" placeholder="phone_number">
        <br>
    </form>
</body>
</html>
