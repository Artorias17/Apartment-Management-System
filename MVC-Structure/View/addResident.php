<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <link href="https://fonts.googleapis.com/css?family=Bebas+Neue&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Oswald&display=swap" rel="stylesheet">
    <link rel="stylesheet" href='/<?php echo $dir?>'>
    <title>Add Resident - <?php echo $_SESSION["current"]['name'] ?></title>

    <script
            src="http://code.jquery.com/jquery-3.4.1.min.js"
            integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo="
            crossorigin="anonymous">
    </script>

</head>
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
    <div class="formName"><p>Add Resident</p></div>
    <form class="f" method="post" action="<?php echo baseURL?>/ResidentController/addResident">
        <div class="merge">
            <div class="fieldC">
                <div class="ft"><p>Name</p></div>
                <input class="field" name="rname" placeholder="Full Name" type="text" value="">
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
            <div class="fieldC" id="s1">
                <div class="ft"><p>Building Number</p></div>
                <input class="field" name="bno" placeholder="Building No." type="text" value="">
            </div>

            <div class="fieldC" id="s2">
                <div class="ft"><p>Floor</p></div>
                <input class="field" name="floor" placeholder="Floor No." type="text" value="">
            </div>

            <div class="fieldC" id="s3">
                <div class="ft"><p>Apartment</p></div>
                <input class="field" name= "aptLetter" placeholder="Apartment Letter" type="text" value="">
            </div>
         </div>

        <div class="fieldC">
            <div class="ft"><p>Contact No.</p></div>
            <input class="field" name="phone" placeholder="Phone/Telephone Number" type="text" value="">
        </div>

        <div class="button">
            <input class="press" type="submit" name="submit" value="SUBMIT">
        </div>

    </form>
</div>
</body>
</html>