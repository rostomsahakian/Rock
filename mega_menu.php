<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

echo "hello";

?>

<html>
    <head>
        <style>
.nav,
.nav a,
.nav ul,
.nav li,
.nav div,
.nav form,
.nav input {
    margin: 0;
    padding: 0;
    border: none;
    outline: none;
}
 
.nav a { text-decoration: none; }
 
.nav li { list-style: none; }
.nav {
    display: inline-block;
    position: relative;
    cursor: default;
    z-index: 500;
}
 
.nav > li {
    display: block;
    float: left;
}
.nav > li > a {
    position: relative;
    display: block;
    z-index: 510;
    height: 54px;
    padding: 0 20px;
    line-height: 54px;
 
    font-family: Helvetica, Arial, sans-serif;
    font-weight: bold;
    font-size: 13px;
    color: #fcfcfc;
    text-shadow: 0 0 1px rgba(0,0,0,.35);
 
    background: #372f2b;
    border-left: 1px solid #4b4441;
    border-right: 1px solid #312a27;
 
    -webkit-transition: all .3s ease;
    -moz-transition: all .3s ease;
    -o-transition: all .3s ease;
    -ms-transition: all .3s ease;
    transition: all .3s ease;
}
.nav > li:hover > a { background: #4b4441; }
 
.nav > li:first-child > a {
    border-radius: 3px 0 0 3px;
    border-left: none;
}
.nav > li.nav-search > form {
    position: relative;
    width: inherit;
    height: 54px;
    z-index: 510;
    border-left: 1px solid #4b4441;
}
.nav > li.nav-search input[type="text"] {
    display: block;
    float: left;
    width: 1px;
    height: 24px;
    padding: 15px 0;
    line-height: 24px;
 
    font-family: Helvetica, Arial, sans-serif;
    font-weight: bold;
    font-size: 13px;
    color: #999999;
    text-shadow: 0 0 1px rgba(0,0,0,.35);
 
    background: #372f2b;
 
    -webkit-transition: all .3s ease 1s;
    -moz-transition: all .3s ease 1s;
    -o-transition: all .3s ease 1s;
    -ms-transition: all .3s ease 1s;
    transition: all .3s ease 1s;
}
 
.nav > li.nav-search input[type="text"]:focus { color: #fcfcfc; }
 
.nav > li.nav-search input[type="text"]:focus,
.nav > li.nav-search:hover input[type="text"] {
    width: 110px;
    padding: 15px 20px;
 
    -webkit-transition: all .3s ease .1s;
    -moz-transition: all .3s ease .1s;
    -o-transition: all .3s ease .1s;
    -ms-transition: all .3s ease .1s;
    transition: all .3s ease .1s;
}
.nav > li.nav-search input[type="submit"] {
    display: block;
    float: left;
    width: 20px;
    height: 54px;
    padding: 0 25px;
    cursor: pointer;
 
    background: #372f2b url(../img/search-icon.png) no-repeat center center;
 
    border-radius: 0 3px 3px 0;
 
    -webkit-transition: all .3s ease;
    -moz-transition: all .3s ease;
    -o-transition: all .3s ease;
    -ms-transition: all .3s ease;
    transition: all .3s ease;
}
 
.nav > li.nav-search input[type="submit"]:hover { background-color: #4b4441; }
.nav > li > div {
    position: absolute;
    display: block;
    width: 100%;
    top: 50px;
    left: 0;
 
    opacity: 0;
    visibility: hidden;
    overflow: hidden;
 
    background: #ffffff;
    border-radius: 0 0 3px 3px;
 
    -webkit-transition: all .3s ease .15s;
    -moz-transition: all .3s ease .15s;
    -o-transition: all .3s ease .15s;
    -ms-transition: all .3s ease .15s;
    transition: all .3s ease .15s;
}
.nav > li:hover > div {
    opacity: 1;
    visibility: visible;
    overflow: visible;
}
.nav .nav-column {
    float: left;
    width: 20%;
    padding: 2.5%;
}
 
.nav .nav-column h3 {
    margin: 20px 0 10px 0;
    line-height: 18px;
 
    font-family: Helvetica, Arial, sans-serif;
    font-weight: bold;
    font-size: 14px;
    color: #372f2b;
    text-transform: uppercase;
}
 
.nav .nav-column h3.orange { color: #ff722b; }
 
.nav .nav-column li a {
    display: block;
    line-height: 26px;
 
    font-family: Helvetica, Arial, sans-serif;
    font-weight: bold;
    font-size: 13px;
    color: #888888;
}
 
.nav .nav-column li a:hover { color: #666666; }
        </style>
    </head>
    <body>
<ul class="nav">
    <li>
        <a href="#">What's new</a>
        <div class="nav-column">
<div class="nav-column">
    <h3>Home</h3>
    <ul>
        <li><a href="#">Pampers Diapers</a></li>
        <li><a href="#">Huggies Diapers</a></li>
        <li><a href="#">Seventh Generation</a></li>
        <li><a href="#">Diapers</a></li>
        <li><a href="#">Derbies</a></li>
        <li><a href="#">Driving shoes</a></li>
        <li><a href="#">Espadrilles</a></li>
        <li><a href="#">Loafers</a></li>
    </ul>
</div>
 
<div class="nav-column">
    <h3>Home</h3>
    <ul>
        <li><a href="#">Driving shoes</a></li>
        <li><a href="#">Espadrilles</a></li>
        <li><a href="#">Loafers</a></li>
    </ul>
 
    <h3>Home</h3>
    <ul>
        <li><a href="#">Driving shoes</a></li>
        <li><a href="#">Espadrilles</a></li>
        <li><a href="#">Loafers</a></li>
    </ul>
</div>
 
<div class="nav-column">
    <h3>Home</h3>
    <ul>
        <li><a href="#">Pampers Diapers</a></li>
        <li><a href="#">Huggies Diapers</a></li>
        <li><a href="#">Seventh Generation</a></li>
        <li><a href="#">Diapers</a></li>
        <li><a href="#">Derbies</a></li>
        <li><a href="#">Driving shoes</a></li>
        <li><a href="#">Espadrilles</a></li>
        <li><a href="#">Loafers</a></li>
    </ul>
</div>
 
<div class="nav-column">
    <h3 class="orange">Related Categories</h3>
    <ul>
        <li><a href="#">Pampers Diapers</a></li>
        <li><a href="#">Huggies Diapers</a></li>
        <li><a href="#">Diapers</a></li>
    </ul>
 
    <h3 class="orange">Brands</h3>
    <ul>
        <li><a href="#">Driving shoes</a></li>
        <li><a href="#">Espadrilles</a></li>
    </ul>
</div>
    </li>
    <li><a href="#">Top rated</a></li>
    <li>
        <a href="#">Earnings</a>
        <div>
            Mega Menu Content...
        </div>
    </li>
    <li><a href="#">Rings</a></li>
    <li><a href="#">Bracelets</a></li>
    <li><a href="#">All Categories</a></li>
    <li class="nav-search">
        <form action="#">
            <input type="text" placeholder="Search...">
            <input type="submit" value="">
        </form>
    </li>
</ul>
        
        
        
        
    </body>
</html>