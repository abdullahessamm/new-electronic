<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title> New Electronic </title>
</head>

<style type="text/css">

@keyframes color-animate {
    0% {
        color: #ffcc00;
    }
    100% {
        color: #ffffff;
    }
}

body {
    background-color: #135ea2;
    color: #eee;
    display: flex;
    justify-content: center;
    align-items: center;
    width: 100%;
    height: 100%;
    position: fixed;
}

body * { text-align: center }

.sub-title {
    animation: color-animate linear;
    animation-duration: 2000ms;
    animation-iteration-count: infinite;
    animation-direction: alternate;
    animation-fill-mode: forwards;
}

</style>

<body>
    <div id="app"></div>

    <script src="{{ mix('js/app.js') }}"></script>
</body>
</html>