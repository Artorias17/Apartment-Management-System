<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
<!--    <link href="dist/css/datepicker.min.css" rel="stylesheet" type="text/css">-->
    <link href="https://fonts.googleapis.com/css?family=Bebas+Neue&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Oswald&display=swap" rel="stylesheet">
    <link rel="stylesheet" href='/<?php echo $dir?>'>
    <title>Update - <?php echo $_SESSION["current"]['name'] ?></title>

    <script
        src="http://code.jquery.com/jquery-3.4.1.min.js"
        integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo="
        crossorigin="anonymous">
    </script>

    <script>
        $(document).ready(function () {
            if(!($(".has").is(":checked"))){
                $(".has").prop('checked', false);
                $(".parking").prop("disabled", true);
                $(".parking").prop("value", "");
                $(".parking").prop('placeholder', "N/A");
                $("input.parking:disabled").css("border", "1px solid red");
            }
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
    <div class="formName"><p>Update Visitor</p></div>
    <form class="f" method="post" action="<?php echo baseURL?>/VisitorController/updateVisitor">

        <div class="merge">
            <div class="fieldC" id="a">
                <div class="ft"><p>Name</p></div>
                <input class="field" name="name" placeholder="Enter Name" type="text" value="<?php echo $visitor["vname"]?>">
            </div>

            <div class="fieldC">
                <div class="ft"><p>Gender</p></div>
                <div id="radioblock">
                    <input class="rfield" name="gender" type="radio" value="Male" required <?php echo $isMale?>>
                        <div class="ft"><p>Male</p></div>
                    <input class="rfield" name="gender" type="radio" value="Female" required <?php echo $isFemale?>>
                        <div class="ft"><p>Female</p></div>
                </div>
            </div>
        </div>

        <div class="merge">
            <div class="fieldC">
                <div class="ft"><p>Arrival</p></div>
                <input class="field a" name="adate" type="date" value="<?php
                echo date('Y-m-d', $arrivaldate);
                ?>">
            </div>

            <div class="fieldC">
                <div class="ft"><p>Departure</p></div>
                <input class="field b" name="ddate" type="date" value="<?php
                echo date('Y-m-d', $departuredate);
                ?>">
            </div>
        </div>

        <div class="fieldC">
            <div class="ft"><p>Address</p></div>
            <input class="field" name="address" placeholder="Lives At" type="text" value="<?php echo $visitor["address"]?>">
        </div>

        <div class="fieldC">
            <div class="ft"><p>Contact No.</p></div>
            <input class="field" name="phone" placeholder="Phone/Telephone Number" type="text" value="<?php echo $visitor["phone"]?>">
        </div>

        <div class="fieldC">
            <div class="ft"><p>Whom to Visit</p></div>
            <select class="field" name="rid" placeholder="Enter Resident Name">
                <?php echo $options ?>
            </select>
        </div>

        <div class="fieldC">
            <div class="ft"><p>Reason</p></div>
            <input class="field" name="reason" placeholder="Reason To Visit" type="text" value="<?php echo $visitor["visitData"]["reason"]?>">
        </div>

        <div class="merge">
            <div class="fieldC transport">
                <div class="ft"><p>Has Vehicle</p></div>
                <div id="radioblock">
                    <input class="has" id="v" name="vehicle" type="checkbox" value="has" <?php if(isset($vehicle)) echo "checked"?>>
                </div>
            </div>

            <div class="fieldC transport">
                <div class="ft"><p>Licence</p></div>
                <input class="field parking" name="lic" id="li" type="text" <?php if(isset($vehicle)) echo "value={$vehicle["licence"]}"?>>
            </div>

            <div class="fieldC transport">
                <div class="ft"><p>Parking Lot</p></div>
                <input class="field parking" name="lot" id="pa" type="text" <?php if(isset($vehicle)) echo "value={$vehicle["lot"]}"?>>
            </div>
        </div>




        <div class="button">
            <input class="press" name="submit" type="submit" value="SUBMIT">
        </div>

    </form>
</div>

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