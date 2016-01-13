<?php
?>
<!DOCTYPE html>
<html>
<head>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>
<script src="force.js"></script>
<style>
*{
    box-sizing:border-box;
}
#attack,
#steal{
    width:100%;
    margin-bottom:20px;
    text-align:center;
    border:1px solid #888;
    padding:5px;
    float:left;

}
#geturl{
    width:100%;
    margin-bottom:20px;
    float:left;
}
#bindarea{
    float:left;
}
#senu{
    margin-bottom:20px;
    padding:5px;
    float:left;
}
.nu{
    float:left;
}
textarea{
    display:block;
    margin:3px;
    float:left;
}
#u1{
    width:30%;

}
</style>
</head>
<body>
<div id="geturl">
    <textarea id="u1" class="url" name="s1" cols="30" rows="10" placeholder="URL"></textarea>
    <div id="senu"></div>
</div>
<div id="steal">steal</div>
<div id="bindarea">
    <div id="attack">attack</div>
    <textarea id="s1" class="bind" name="s1" cols="30" rows="10" placeholder="1"></textarea>
    <textarea id="s2" class="bind" name="s2" cols="30" rows="10" placeholder="2"></textarea>
    <textarea id="s3" class="bind" name="s3" cols="30" rows="10" placeholder="3"></textarea>
    <textarea id="s4" class="bind" name="s4" cols="30" rows="10" placeholder="4"></textarea>
    <textarea id="s5" class="bind" name="s5" cols="30" rows="10" placeholder="5"></textarea>
    <textarea id="s6" class="bind" name="s6" cols="30" rows="10" placeholder="6"></textarea>
    <textarea id="s7" class="bind" name="s7" cols="30" rows="10" placeholder="7"></textarea>
    <textarea id="s8" class="bind" name="s8" cols="30" rows="10" placeholder="8"></textarea>
    <textarea id="s9" class="bind" name="s9" cols="30" rows="10" placeholder="9"></textarea>
    <textarea id="s10" class="bind" name="s10" cols="30" rows="10" placeholder="10"></textarea>
</div>
</body>
</html>
