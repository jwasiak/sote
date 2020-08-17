function getValue(obj)
{
    var testIE = new RegExp("Microsoft Internet Explorer");
    var browserType = navigator.appName;
   
    if(testIE.test(browserType)==true)
    { 
        var checkIE = 1;
    }
    else
    {
        var checkIE = 0;
    }
    
    var checkEdit = new RegExp("frontend_edit");
    
    //sprawdza czy aktualne środowisko pozwala na edycje
    if(checkEdit.test(document.location.href)==true)
    { 
        
        //pobiera Id elementu
        var elementId = obj.id;       
       
        //zlicza ilość załączonych arkuszy styli css
        var countStyleSheets = document.styleSheets.length-1
          
            
        for (i=0; i<=countStyleSheets; i++)
        {
            //zlicza ilość definicji styli css
            
            if(checkIE == 1)
            {
                var countElementsCss = document.styleSheets[i].rules.length-1;
            }
            else
            {
                var countElementsCss = document.styleSheets[i].cssRules.length-1;    
            }
            
            
            for (ii=0; ii<=countElementsCss; ii++)
            {   
                //pobiera  konkretną definicję w stylach
                
                if(checkIE == 1)
                {
                    var elementCss = document.styleSheets[i].rules[ii].selectorText;
                    
                }
                else
                {
                    var elementCss = document.styleSheets[i].cssRules[ii].cssText;
                }
            
                //sprawdza czy występuje Id
                if(checkIE == 1)
                {
                    var searchElement = new RegExp("#"+elementId);
                }
                else
                {
                    var searchElement = new RegExp("#" + elementId + " ");
                }
                                           
                if(searchElement.test(elementCss)==true)
                {                      
                    
                    //pobierz nazwę obrazka ze stylu
                    if(checkIE == 1)
                    {       
                        var image = document.styleSheets[i].rules[ii].style.backgroundImage;    
                    }
                    else
                    {
                        var image = document.styleSheets[i].cssRules[ii].style.backgroundImage;    
                    }
                    var srcCss = document.styleSheets[i].href;
                    
                    var pathImage = image.split("(");
                    var image = pathImage[1].split(")");
                    var srcImage = image[0];
                    
                    var objectCssId = elementCss.split("{");
                    var objectCssId = objectCssId[0];
                    
                    var imageName = srcImage.slice(srcImage.lastIndexOf("/")+1);
                                
               
                    //przkazuje wartości do tablicy ktróre następnie lecą w linku
                    var elements = new Array(5);
                    
                    elements[0] = escape(elementId);
                    elements[1] = escape(objectCssId);
                    elements[2] = escape(srcCss);
                    elements[3] = escape(srcImage);
                    elements[4] = escape(imageName);
                                       
                    editPopup = window.open ("/frontend_edit.php/stThemeFrontend/changeImage?element="+ elements,"Name", 'titlebar=no, menubar=no, toolbar=no, location=no, scrollbars=yes, resizable=no, status=no, width=560, height=300, left=230, top=230');
                    editPopup.focus();
                }
            }
        }
    }
}