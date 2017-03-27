<?php

//CSS:


?>



<!-- Latest compiled and minified CSS -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">

<!-- Optional theme -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap-theme.min.css" integrity="sha384-fLW2N01lMqjakBkx3l/M9EahuwpSfeNvV63J5ezn3uZzapT0u7EYsXMjQV+0En5r" crossorigin="anonymous">

<!-- Latest compiled and minified JavaScript -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js" integrity="sha384-0mSbJDEHialfmuBBQP6A4Qrprq5OVfW37PRR3j5ELqxss1yVqOtnepnHVP9aJ7xS" crossorigin="anonymous"></script>

<!--jQuery css -->
<script  src="https://code.jquery.com/ui/1.11.4/jquery-ui.js"   integrity="sha256-DI6NdAhhFRnO2k51mumYeDShet3I8AKCQf/tf7ARNhI="   crossorigin="anonymous"></script>

<!-- FontAwesome -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css">

<style>


h2{
	font-family: inherit;
	font-size: 10;
	font-style: inherit;
	font-weight: inherit;
	margin: 0;
	outline: 0;
	padding: 0;
	vertical-align: baseline;
	
}

.title{
	  font-size: 20px;
	 text-align: left;
}
.control-label{
	 font-size: 16px;
	 text-align: left;
	
}
.fa fa-plus{
	 font-size: 28px
	background-color: #E6E6FA;
}

body {
	background-color: #ffffff;
	
	line-height: 1;
	padding: 0 2em;
}
.col-md-3{
	width:250px;
	height:200px;
	background-color:#ffffff;
}
.pull-left{
	background-color:#ffffff;
	
}
nav navbar-nav{
	background-color:#616A6F;
}
navbar navbar-default{
	background-color:#616A6F;
	background-color:#616A6F;
}
.navbar navbar-custom{
	background-color:#1093DD;
	
}

caption, th, td {
	font-weight: normal;
	text-align: left;
}
dropdown-toggle{
	color:#E6E6FA;
	text: 0 1px 0 #f5f5f5
	
}
#page {
	margin: 2em auto;
	max-width: 1500px;
}



	html {
	  position: relative;
	  min-height: 100%;
	}
	body {
	  /* Margin bottom by footer height */
	  margin-bottom: 60px;
	  
	}
	.footer {
	  position: absolute;
	  bottom: 0;
	  width: 100%;
	  /* Set the fixed height of the footer here */
	  height: 60px;
	  background-color: #f5f5f5;
	}
	.container {
	padding-left:0px;
	margin-left:0px;
	}
	
	.container img {
	float: left;
	top: 0px;
	
    width: 200px;
    height: 120px;
	}
	.navbar-default{
		width: 100%;
		height:50px;
		background-color:#184777
	}
    #btn-debug{
    	/*
    	position: absolute;
    	right: 5px;
    	*/
    }

	#console-debug {
    	
    	position: absolute;
    	top: 50px;
    	left: 0px;
    	width:30%;
    	height:700px;
    	overflow-y:scroll;
    	background-color: #FFFFFF;
    	box-shadow: 2px 2px 5px #CCCCCC;
    }
    
   	#console-debug pre{
    	
    	    }
    
	li:hover ul{
    display:block;
	}

body{
  background-color: transparent;
}

.jf-form{
  margin-top: 28px;
}

.jf-option-box{
  display: none;
  margin-left: 8px;
}

.jf-hide{
  display: none;
}

.jf-disabled {
    background-color: #eeeeee;
    opacity: 0.6;
    pointer-events: none;
}

/* 
overwrite bootstrap default margin-left, because the <label> doesn't contain the <input> element.
*/
.checkbox input[type=checkbox], .checkbox-inline input[type=checkbox], .radio input[type=radio], .radio-inline input[type=radio] {
  position: absolute;
  margin-top: 4px \9;
  margin-left: 0px;
}

div.form-group{
  padding: 8px 8px 4px 8px;
}

.mainDescription{
  margin-bottom: 10px;
}
.responsive img{
  width: 100%;
}

p.error, p.validation-error{
  padding: 5px;
}

p.error{
  margin-top: 10px;
  color:#a94442;
}

p.server-error{
  font-weight: bold;
}

div.thumbnail{
  position: relative;
  text-align: center;
}

div.thumbnail.selected p{
  color: #ffffff;
}

div.thumbnail .glyphicon-ok-circle{
  position: absolute;
  top: 16px;
  left: 16px;
  color: #ffffff;
  font-size: 32px;
}

.jf-copyright{color: #888888; display: inline-block; margin: 16px;display:none;}

.form-group.required .control-label:after {
    color: #dd0000;
    content: "*";
    margin-left: 6px;
}

.submit .btn.disabled, .submit .btn[disabled]{
  background: transparent;
  opacity: 0.75;
}

/* for image option with span text */
.checkbox label > span, .radio label > span{
  display: block;
}

.form-group.inline .control-label,
.form-group.col-1 .control-label,
.form-group.col-2 .control-label,
.form-group.col-3 .control-label
{
  display: block;
}

.form-group.inline div.radio,
.form-group.inline div.checkbox{
  display: inline-block;
}

.form-group.col-1 div.radio,
.form-group.col-1 div.checkbox{
  display: block;
}

.form-group.col-2 div.radio,
.form-group.col-2 div.checkbox{
  display: inline-block;
  width: 48%;
}

.form-group.col-3 div.radio,
.form-group.col-3 div.checkbox{
  display: inline-block;
  width: 30%;
}

a.button {
    -webkit-appearance: button;
    -moz-appearance: button;
    appearance: button;

    text-decoration: none;
    color: initial;
}

.section{
background-color:#E6E6FA;
}

.reslut_selection{ 
	width: 100%;
	height: 34px;
	padding: 6px 12px;
	font-size: 14px;
}
option.red {background-color: #F57D59;}
option.mauve {background-color: #CC99FF;}
option.green {background-color: #C0F867;}
option.yellow {background-color: #D3EA0E;}
option.blue {background-color: #31C8F7;}

.mandatory{color:red;}
.title{
	  font-size: 18px;
	 text-align: left;
}	
</style>