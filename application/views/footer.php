<div id="footer">
<div id="sitemap">
<ul> <li><a href = "<?php echo base_url()."welcome"; ?>">Home</a></li>
     <li><a href = "#">About Us</a></li>
     <li><a href = "#">Contact us</a></li>
     <li><a href = "#">Advertise</a></li>
     <li><a href = "#">Copyright</a></li>
     <li><a href = "#">Policy</a></li>



     <SCRIPT LANGUAGE="JavaScript">
//calculate the time before calling the function in window.onload
beforeload = (new Date()).getTime();
function pageloadingtime()
{
 
        //calculate the current time in afterload
        afterload = (new Date()).getTime();
        // now use the beforeload and afterload to calculate the seconds
        secondes = (afterload-beforeload)/1000;
        // If necessary update in window.status
        window.status='You Page Load took  ' + secondes + ' seconde(s).';
        // Place the seconds in the innerHTML to show the results
        document.getElementById("loadingtime").innerHTML = "Page Loaded  in " + secondes + " seconde(s).";
       
}
 
window.onload = pageloadingtime;
</SCRIPT>

<!-- <div id="loadingtime" style = "margin: 0 0 0 136px; font-size : 9px; color : #898989;"></div> -->

</ul>                                               
</div> <!--ends sitemap div-->
</div> <!--ends footer div-->
</div> <!--ends container div here-->

</div> <!--ends wrapper div here-->

</body>
</html>
