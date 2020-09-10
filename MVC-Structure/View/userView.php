<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <link href="https://fonts.googleapis.com/css?family=Bebas+Neue&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Oswald&display=swap" rel="stylesheet">
    <link rel="stylesheet" href='/<?php echo $dir1?>'>
    <link rel="stylesheet" href='/<?php echo $dir2?>'>
    <title>Home - <?php echo $_SESSION["current"]['name'] ?></title>

    <script
        src="http://code.jquery.com/jquery-3.4.1.min.js"
        integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo="
        crossorigin="anonymous">
    </script>

    <script>
        $(document).ready(function(){
            $(".tableblock").show();
            $(".block").hide();
        })
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
    <div class="optionsC">
        <div class="opt">
            <input class="b" name="showGuards" type="button" value="Show Guards" onclick="showG()">
        </div>

        <div class="opt">
            <input class="b" name="showAdmins" type="button" value="Show Admins" onclick="showA()">
        </div>

        <div class="opt">
            <input class="b" name="showAllTable" type="button" value="Show All" onclick="showAll()">
        </div>

        <div class="opt">
            <input class="b" name="showAddUser" type="button" value="Add User" onclick="addUser()">
        </div>

        <div class="opt">
            <input class="b" name="updateUser" type="button" value="Update Me" onclick="updateU()">
        </div>

        <form class="opt" method="post" action="<?php echo baseURL?>/UserController/deleteUser">
            <input class="b" name="deleteMe" type="submit" value="Delete Me">
        </form>
    </div>
</div>


<div class="mega">

    <div class="tableblock" id="V1">
        <p class="tt">Admins</p>
        <table class="tab">
            <thead>
            <tr>
                <th>Username</th>
                <th>Name</th>
                <th>Gender</th>
                <th>Address</th>
                <th>Date Of Birth</th>

            </tr>
            </thead>
            <tbody><?php print $adminData ?></tbody>
        </table>
    </div>


    <div class="tableblock" id="V2">
        <p class="tt">Guards</p>
        <table class="tab">
            <thead>
            <tr>
                <th>Username</th>
                <th>Name</th>
                <th>Gender</th>
                <th>Address</th>
                <th>Date Of Birth</th>
            </tr>
            </thead>
            <tbody><?php print $guardData ?></tbody>
        </table>
    </div>
</div>


<div class="block" id="addUserBlock" style="top: 0%; transform: translate(-50%, 0%);">
    <div class="formName"><p>Add User</p></div>
    <form class="f" method="post" action="<?php echo baseURL?>/UserController/addUser">
        <div class="merge">
            <div class="fieldC">
                <div class="ft"><p>Name</p></div>
                <input class="field" name="name" placeholder="Full Name" type="text" value="">
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
                <div class="ft"><p>Date Of Birth</p></div>
                <input class="field a" name="dateOfBirth" type="date" value="<?php echo date('Y-m-d'); ?>">
            </div>

            <div class="fieldC">
                <div class="ft"><p>Address</p></div>
                <input class="field" name="address" placeholder="Lives At" type="text" value="">
            </div>
        </div>

        <div class="merge">
            <div class="fieldC">
                <div class="ft"><p>Username</p></div>
                <input class="field" name="username" placeholder="Username" type="text" value="">
            </div>

            <div class="fieldC">
                <div class="ft"><p>Password</p></div>
                <input class="field" name="password" placeholder="Password" type="password" value="">
            </div>
        </div>


            <div class="fieldC">
                <div class="ft"><p>Admin Rights</p></div>
                <div id="radioblock">
                    <input class="rfield" name="isAdmin" type="radio" value="1" required>
                    <div class="ft"><p>YES</p></div>
                    <input class="rfield" name="isAdmin" type="radio" value="0" required>
                    <div class="ft"><p>NO</p></div>
                </div>
            </div>

            <div class="button">
                <input class="press" type="submit" name="createUser" value="SUBMIT">
            </div>
        </div>

    </form>
</div>


<div class="block" id="updateUserBlock" style="top: 0%; transform: translate(-50%, 0%);">
    <div class="formName"><p>Update User</p></div>
    <form class="f" method="post" action="<?php echo baseURL?>/UserController/updateUser">
        <div class="merge">
            <div class="fieldC">
                <div class="ft"><p>Name</p></div>
                <input class="field" name="name" placeholder="Full Name" type="text" value="<?php echo $user["name"]?>">
            </div>

            <div class="fieldC">
                <div class="ft"><p>Gender</p></div>
                <div id="radioblock">
                    <input class="rfield" name="gender" type="radio" value="Male" required <?php echo $Male?>>
                    <div class="ft"><p>Male</p></div>
                    <input class="rfield" name="gender" type="radio" value="Female" required <?php echo $Female?>>
                    <div class="ft"><p>Female</p></div>
                </div>
            </div>
        </div>

        <div class="merge">
            <div class="fieldC">
                <div class="ft"><p>Date Of Birth</p></div>
                <input class="field a" name="dateOfBirth" type="date" value="<?php echo date('Y-m-d', $date)?>">
            </div>

            <div class="fieldC">
                <div class="ft"><p>Address</p></div>
                <input class="field" name="address" placeholder="Lives At" type="text" value="<?php echo $user["address"]?>">
            </div>
        </div>

        <div class="merge">
            <div class="fieldC">
                <div class="ft"><p>Username</p></div>
                <input class="field" name="username" placeholder="Username" type="text" value="<?php echo $user["username"]?>">
            </div>

            <div class="fieldC">
                <div class="ft"><p>Password</p></div>
                <input class="field" name="password" placeholder="Password" type="password" value="<?php echo $user["password"]?>">
            </div>
        </div>
        <div class="button">
            <input class="press" type="submit" name="updateUser" value="SUBMIT">
        </div>

    </form>
</div>


<script>
    function showAll(){
        $(".tableblock").show();
        $(".block").hide();
    }
    function addUser(){
        $("#addUserBlock").show();
        $(".tableblock").hide();
        $("#updateUserBlock").hide();
    }

    function showG(){
        $(".block").hide();
        $("#V1").hide();
        $("#V2").show();

    }

    function showA(){
        $(".block").hide();
        $("#V1").show();
        $("#V2").hide();
    }

    function updateU(){
        $("#addUserBlock").hide();
        $(".tableblock").hide();
        $("#updateUserBlock").show();
    }

</script>

</body>
</html>
