<!--
function uploadResponse(status)
{
     if(status!='KO')
     {
          openClose('uploadtab',-1);
          document.getElementById("uploadbox").innerHTML = "<center>Le document image a bien �t� envoy�. Vous pouvez tenter de g�n�rer la miniature associ�e</center>";
          document.getElementById("image_name").value=status;
     }
}

function exif_info(image)
{
     x_ImageInfos(image,draw_exif);
     openClose('exif_div',1);
}

function draw_exif(result)
{
     data = parseGET(result);
     if(data['status']!='OK')
          document.getElementById("exif_paragraph").innerHTML= "<span class='error'>Erreur: "+data['libelle']+"</span>";
     else
     {

          document.getElementById("exif_paragraph").innerHTML=data['libelle'];
     }
}

function genThumbs()
{
     imgsrc = document.getElementById("image_name").value;
     x_getThumbs(imgsrc,endgenThumbs);
}

function endgenThumbs(result)
{
     data = parseGET(result);
     if(data['status']!='KO')
     {
          document.getElementById("uploadbox").innerHTML = "<center>La miniature a �t� g�n�r�e</center>"+data['tn'];

     }
}
-->
