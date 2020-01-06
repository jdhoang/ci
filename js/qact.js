function DisActy() {
   document.getElementById("Area1").innerHTML = "";
   vfrom = document.getElementById("date_from").value;
   vto = document.getElementById("date_to").value;
   vdesc = document.getElementById("descrp").value;
   hostn = document.getElementById("hostn").value;
   ipaddr = document.getElementById("ipaddr").value;
   actid = document.getElementById("act_type_id").value;
   if (document.getElementById("act_type_id").selectedIndex > 0)
      subactid = document.getElementById("subact_id").value;
   else
      subactid = "";

   if (window.XMLHttpRequest) 
      xmlhttp = new XMLHttpRequest();
   else
      xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");

   xmlhttp.onreadystatechange = function () {
      if (this.readyState == 4 && this.status == 200) {
         document.getElementById("Area1").innerHTML = this.responseText;
         }
      }
   xmlhttp.open ("GET", "/ci/rqry_activity.php?date_from="+vfrom+"&date_to="+vto+"&desc="+vdesc+"&hostn="+hostn+"&ipaddr="+ipaddr+
                        "&act_id="+actid+"&subact_id="+subactid, true);
   xmlhttp.send ();
}

function DisSubAct() {
   document.getElementById("SubAct").innerHTML = "";
   actid = document.getElementById("act_type_id").value;
   if (window.XMLHttpRequest) 
      xmlhttp = new XMLHttpRequest();
   else
      xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");

   xmlhttp.onreadystatechange = function () {
      if (this.readyState == 4 && this.status == 200) {
         document.getElementById("SubAct").innerHTML = this.responseText;
         }
      }
   xmlhttp.open ("GET", "/ci/selSubAct.php?actid="+actid, true);
   xmlhttp.send ();
}
