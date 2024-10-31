<?php
/*
Copyright 2010  Lee Thompson (email: mysql_dba@cox.net)

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License, version 2, as
    published by the Free Software Foundation.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/
class tagSpider
{

// set variable to hold curl instance
var $crl;

// this is where we dump the html we get
var $html; 

// set for binary type transfer
var $binary; 

// this is the url we are going to do a pass on
var $url;

// automatically executed on class call to clear variables
function tagSpider()
{
$this->html = "";
$this->binary = 0;
$this->url = "";
}

// takes url passed to it and.. can you guess?
function fetchPage($url)
{

// set the URL to scrape
$this->url = $url;

if (isset($this->url)) {

// start cURL instance
$this->ch = curl_init ();

// this tells cUrl to return the data
curl_setopt ($this->ch, CURLOPT_RETURNTRANSFER, 1);

// set the url to download
curl_setopt ($this->ch, CURLOPT_URL, $this->url); 

// follow redirects if any
curl_setopt($this->ch, CURLOPT_FOLLOWLOCATION, true); 

// tell cURL if the data is binary data or not
curl_setopt($this->ch, CURLOPT_BINARYTRANSFER, $this->binary); 

// grabs the webpage from the internets
$this->html = curl_exec($this->ch); 

// closes the connection
curl_close ($this->ch);
}

}

// function takes html, puts the data requested into an array
function parse_array($beg_tag, $close_tag)

{
// match data between specificed tags
preg_match_all("($beg_tag.*$close_tag)siU", $this->html, $matching_data); 

// return data in array
return $matching_data[0];
}

}
?>
