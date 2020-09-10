<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
<!--    <link href="dist/css/datepicker.min.css" rel="stylesheet" type="text/css">-->
    <link href="https://fonts.googleapis.com/css?family=Bebas+Neue&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Oswald&display=swap" rel="stylesheet">
    <link rel="stylesheet" href='/<?php echo $dir?>'>
    <title>Add Visitor - <?php echo $_SESSION["current"]['name'] ?></title>

    <script
        src="http://code.jquery.com/jquery-3.4.1.min.js"
        integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo="
        crossorigin="anonymous">
    </script>

<!--    <<script src="dist/js/datepicker.min.js"></script>-->
<!--    <script src="dist/js/i18n/datepicker.en.js"></script>-->


    <script>
        $(document).ready(function () {
            $(".has").prop('checked', false);
            $(".parking").prop("disabled", true);
            $(".parking").prop("value", "");
            $(".parking").prop('placeholder', "N/A");
            $("input.parking:disabled").css("border", "1px solid red");
        })
    </script>
</head>

<!--Title Header-->
<body>
<div class="titleC">
    <div class="title" id="dashb">
        <a href="<?php echo baseURL?>/">Dashboard</a>
    </div>
    <div class="title" id="currentU">
        <?php echo $_SESSION["current"]['name'] ?>
    </div>
    <div class="btn">
        <a href="<?php echo baseURL?>/UserController/logout">LOGOUT</a>
    </div>
</div>

<div class="block">
    <div class="formName"><p>Add Visitor</p></div>
    <form class="f" method="post" action="<?php echo baseURL?>/VisitorController/addVisitor">

        <div class="merge">
            <div class="fieldC" id="a">
                <div class="ft"><p>Name</p></div>
                <input class="field" name="vname" placeholder="Enter Name" type="text" value="">
            </div>

            <div class="fieldC">
                <div class="ft"><p>Gender</p></div>
                <div id="radioblock">
                    <input class="rfield" name="gender" type="radio" value="Male" required>
                    <div class="ft"><p>Male</p></div>
                    <input class="rfield" name="gender" type="radio" value="Female" required>
                    <div class="ft"><p>Female</p></div>
                </div>
            </div>
        </div>

        <div class="merge">
            <div class="fieldC">
                <div class="ft"><p>Arrival</p></div>
                <input class="field a" name="arrival" type="date" value="<?php echo date('Y-m-d'); ?>">
            </div>

            <div class="fieldC">
                <div class="ft"><p>Departure</p></div>
                <input class="field b" name="departure" type="date" value="<?php echo date('Y-m-d'); ?>">
            </div>
        </div>

        <div class="fieldC">
            <div class="ft"><p>Address</p></div>
            <input class="field" name="address" placeholder="Lives At" type="text" value="">
        </div>

        <div class="fieldC">
            <div class="ft"><p>Contact No.</p></div>
            <input class="field" name="phone" placeholder="Phone/Telephone Number" type="text" value="">
        </div>

        <div class="fieldC">
            <div class="ft"><p>Whom to Visit</p></div>
            <select class="field" name="rid" placeholder="Select Resident">
                <?php
                    echo $option;
                ?>
            </select>
        </div>

        <div class="fieldC">
            <div class="ft"><p>Reason</p></div>
            <input class="field" name="reason" placeholder="Reason To Visit" type="text" value="">
        </div>

        <div class="merge">
            <div class="fieldC transport">
                <div class="ft"><p>Has Vehicle</p></div>
                <div id="radioblock">
                    <input class="has" id="v" name="vehicle" type="checkbox" value="has">
                </div>
            </div>

            <div class="fieldC transport">
                <div class="ft"><p>Licence</p></div>
                <input class="field parking" name="lic" id="li" type="text">
            </div>

            <div class="fieldC transport">
                <div class="ft"><p>Parking Lot</p></div>
                <input class="field parking" name="lot" id="pa" type="text">
            </div>
        </div>

        <div class="button">
            <input class="press" name="submit" type="submit" value="SUBMIT">
        </div>

    </form>
</div>


<script>

</script>
<script>
    $(".b").change(function () {
        var from = $("input.a").val();
        var to = $("input.b").val();
        if(Date.parse(from) > Date.parse(to)){
            alert("Can't depart before arrival");
            $("input.b").val(from);
        }
    })

</script>

<script>
    $(".has").change(function(){
        if(this.checked==true){
            $(".parking").prop("disabled", false);
            $("#li").prop("placeholder", "Enter Licence");
            $("#pa").prop("placeholder", "Enter Parking Lot");
            $("input.parking:enabled").css("border", "1px solid white");
        }else{
            $(".parking").prop("disabled", true);
            $(".parking").prop("value", "");
            $(".parking").prop("placeholder", "N/A");
            $("input:disabled").css("border", "1px solid red");
            $("input.parking:disabled").css("border", "1px solid red");
        }
    });
</script>
</body>
</html>