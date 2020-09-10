<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <link href="https://fonts.googleapis.com/css?family=Bebas+Neue&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Oswald&display=swap" rel="stylesheet">
    <link rel="stylesheet" href='/<?php echo $dir?>'>
    <title>Home - <?php echo $_SESSION["current"]['name'] ?></title>

    <script
        src="http://code.jquery.com/jquery-3.4.1.min.js"
        integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo="
        crossorigin="anonymous">
    </script>

    <script>
        $(document).ready(function () {
            $("#V2").hide();
        });
    </script>

</head>
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


<div class="mid">
    <form id="sbox" method="post" action="<?php echo baseURL?>/">
        <div id="field">
            <input type="text" name="search" placeholder="Search Visitor" value="">
        </div>
        <div id="searchbtn">
            <input class="b" name="go" type="submit" value="SEARCH">
        </div>
    </form>
    <div class="optionsC">
        <form class="opt" method="post" action="<?php echo baseURL?>/VisitorController/addVisitor">
            <input class="b" name="addV" type="submit" value="Add Visitor">
        </form>
        <form class="opt" method="post" action="<?php echo baseURL?>/ResidentController/addResident">
            <input class="b" name="addR" type="submit" value="Add Resident">
        </form>

        <div class="opt">
            <input class="b" name="showV" type="button" value="Show Visitor" onclick="showV()">
        </div>
        <div class="opt">
            <input class="b" name="showR" type="button" value="Show Resident" onclick="showR()">
        </div>
<!--        <div class="opt">-->
<!--            <input class="b" name="showVV" type="button" value="Show Vehicle" onclick="showVV()">-->
<!--        </div>-->
        <div class="opt">
            <input class="b" name="showAll" type="button" value="Show All" onclick="showAll()">
        </div>

        <form class="opt" method="post" action="<?php echo baseURL?>/UserController/userView">
            <input class="b" name="userViewRedirect" type="submit" value="User Controls">
        </form>

        <!--<form class="opt" method="post">
            <input class="b" name="addR" type="submit" value="Add Resident">
        </form>-->

    </div>
</div>


<div class="mega">

    <?php echo $search?>

    <div class="tableblock" id="V1">
        <p class="tt">Visitors</p>
        <table class="tab">
            <thead>
            <tr>
                <th>Name</th>
                <th>Gender</th>
                <th>Address</th>
                <th>Phone</th>
                <th>Details</th>

            </tr>
            </thead>
            <tbody><?php print $data ?></tbody>
        </table>
    </div>


    <div class="tableblock" id="V2">
        <p class="tt">Visiting Details</p>
        <table class="tab">
            <thead>
            <tr>
<!--                <th>Visiting</th>-->
                <th>Arrival</th>
                <th>Departure</th>
                <th>Reason</th>
                <th>Licence</th>
                <th>Parking Spot</th>
                <th>Update</th>
                <th>Delete</th>
            </tr>
            </thead>
            <tbody><?php print $details ?></tbody>
        </table>
    </div>

    <div class="tableblock" id="R">
        <p class="tt">Residents</p>
        <table class="tab">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Gender</th>
                    <th>Phone</th>
                    <th>Building No.</th>
                    <th>Floor</th>
                    <th>Apartment Letter</th>
                    <th>Update</th>
                    <th>Delete</th>
                </tr>
            </thead>
            <tbody><?php print $residentData ?></tbody>
        </table>
    </div>
</div>

<script>
    function showV() {
        $("#V1").show();
        $("#V2").hide();
        $("#R").hide();
    };

    function showR(){
        $("#V1").hide();
        $("#V2").hide();
        $("#R").show();
        $('[class^="residentData"]').show();
    }

    // function showVV(){
    //     $("#V1").hide();
    //     $("#V2").show();
    //     $("#R").hide();
    // }

    function showAll(){
        $("#V1").show();
        $('[class^="visitorData"]').show();
        $("#V2").hide();
        $("#R").show();
        $('[class^="residentData"]').show();

    }

    function showD(i){
        $("#V1").show();
        $('[class^="visitorData"]').hide();
        $(".visitorData"+i).show()

        $("#V2").show();
        $('[class^="visitData"]').hide();
        $(".visitData"+i).show();

        $("#R").show();
        $('[class^="residentData"]').hide();
        $(".visitData"+i).show();

    }
</script>

</body>
</html>
