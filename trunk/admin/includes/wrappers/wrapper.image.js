/* Receivers */
function endgenThumbs(result)
{
	
     var data = parseGET(result);
     alert(data['thumb']);
     if(data['status']!='KO')
     {
          msgBox("La miniature a été générée",'Info');

     }
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
/* Callers */
function genThumbs()
{
     imgsrc = document.getElementById("image_name").value;
     x_generateThumb(imgsrc,endgenThumbs);
}

function exif_info(image)
{
     x_ImageInfos(image,draw_exif);
     openClose('exif_div',1);
}

/* Others */
function uploadResponse(status)
{
     if(status!='KO')
     {
          openClose('uploadtab',-1);
          //document.getElementById("uploadbox").innerHTML = "<center>Le document image a bien été envoyé. Vous pouvez tenter de générer la miniature associée</center>";
          msgBox("<center>Le document image a bien été envoyé. Vous pouvez tenter de générer la miniature associée</center>",'info');
          document.getElementById("image_name").value=status;
     }
}



